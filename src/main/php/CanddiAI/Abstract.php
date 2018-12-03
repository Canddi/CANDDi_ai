<?php
/**
 * @author Tim Langley
 **/

namespace CanddiAI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

abstract class LookupAbstract
{
    private static $_guzzleConnection       = null;

    private static $_strBaseUri = null;
    private static $_strApiKey = null;

    /**
     *
     *
     * @author Luke Roberts
     **/
    private function __construct(
        $strBaseUri,
        $strApiKey
    )
    {
        $this->_strBaseUri = $strBaseUri;
        $this->_strApiKey = $strApiKey;
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
    ) {
        self::$_guzzleConnection    = $guzzleConnection;
    }

    protected function _callEndpoint(
        $strURL,
        Array $arrQuery                 = []
    ) {
        if(!self::$_guzzleConnection) {
            $arrDefaults                = [
                'base_uri'              => $this->$strBaseUri,
                'timeout'               => 5,
                'connect_timeout'       => 5,
                'headers'               => [
                    'Accept'            => 'application/json',
                    'Accept-Encoding'   => 'gzip, deflate',
                    'x-api-key'         => $this->$strApiKey
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

        if(200 !== intval($response->getStatusCode())) {
            throw new Exception(
                $response->getStatusCode().'-'.$response->getReasonPhrase()
            );
        }

        return json_decode(
            (string)$response->getBody(), true
        );
    }


    /**
     * The following functions belong in a singleton trait but for some reason
     *     traits aren't loading
    **/

    final protected function __clone()
    {
        throw new Exception('Cannot clone');
    }

    /**
     *  Implements the singleton pattern
     *  @return:$this       - this is a fluent interface
    **/
    protected static $_locater;

    /**
     * Gets an instance of the current class
     *
     * @return static
     * @author Tim Langley
    **/
    public static function getInstance(
        $strBaseUri,
        $strApiKey
    )
    {
        if (is_null(static::$_locater)) {
            static::$_locater   = new static($strBaseUri, $strApiKey);
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
}
