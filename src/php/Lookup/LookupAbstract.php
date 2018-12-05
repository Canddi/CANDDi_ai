<?php
/**
 * Wrapper for CANDDi Lookup
 * https://ip.canddi.ai
 *
 * @author Tim Langley
 **/

namespace CanddiAi\Lookup;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

abstract class LookupAbstract
{

    /**
     *  Implements the singleton pattern
    **/
    protected static $_locater;

    private static $_guzzleConnection       = null;

    /**
     * Prevent instantiation and cloning
     * ONLY use getInstance()
    **/
    final protected function __construct(
        $strURL,
        $strApiKey
    )
    {
        if (empty($strURL) || empty($strApiKey)) {
            throw new \Exception(
                "Unable to create instance - Missing URL OR Key"
            );
        }

        $this->_strURL      = $strURL;
        $this->_strAPIKey   = $strApiKey;
    }
    final protected function __clone()
    {
        throw new \Exception('Cannot clone');
    }
    /**
     * Used for testing
     *      This injects in a GuzzleConnection so we can
     *      mock this
     *
     * @param GuzzleHttp\Client $guzzleConnection
     **/
    public static function injectGuzzle(
        Client $guzzleConnection
    )
    {
        self::$_guzzleConnection    = $guzzleConnection;
    }
    /**
     * Gets an instance of the current class
     *
     * @return static
     * @author Tim Langley
    **/
    public static function getInstance(
        $strURL     = null,
        $strApiKey  = null
    )
    {
        if (is_null(static::$_locater)) {
            static::$_locater   = new static(
                $strURL,
                $strApiKey
            );
        }

        return static::$_locater;
    }

    /**
     * This method is used for testing
     *  @param: $locator    - this is mainly for testing
     *                      - it allows a mock version of the
     *                          Common_Gateway to be injected
    **/
    public static function inject(
        LookupAbstract $locator = null
    )
    {
        static::$_locater   = $locator;
    }
    /**
     * This wipes out anything cached
     *
     **/
    public static function reset()
    {
        static::$_locater = null;
    }
    protected function _callEndpoint(
        $strURL,
        Array $arrQuery                 = []
    )
    {
        if (!self::$_guzzleConnection) {
            $arrDefaults                = [
                'base_uri'              => $this->_strURL,
                'timeout'               => 5,
                'connect_timeout'       => 5,
                'headers'               => [
                    'Accept'            => 'application/json',
                    'Accept-Encoding'   => 'gzip, deflate',
                    'x-api-key'         => $this->_strAPIKey
                ],
                "verify"                => false
            ];
            self::$_guzzleConnection    = new Client($arrDefaults);
        }

        $response                   = self::$_guzzleConnection
            ->request(
                'GET',
                $strURL,
                [
                    'query'         => $arrQuery
                ]
            );

        if (200 !== intval($response->getStatusCode())) {
            throw new \Exception(
                $response->getStatusCode().'-'.$response->getReasonPhrase()
            );
        }

        return json_decode(
            (string)$response->getBody(), true
        );
    }
}
