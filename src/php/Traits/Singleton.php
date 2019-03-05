<?php
/**
 * @copyright 2016-12-14
 * @author Tim Langley
**/


namespace CanddiAi\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use CanddiAi\Singleton\InterfaceSingleton;
/**
 * Singleton trait
**/

trait TraitSingleton
{
    private $_strURL;
    private $_strAPIKey;

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
        InterfaceSingleton $locator = null
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
    private static $_guzzleConnection;

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
    protected static function _getGuzzle($strBaseUri, $strApiKey)
    {
        if (!self::$_guzzleConnection) {
            $arrDefaults                = [
                'base_uri'              => $strBaseUri,
                'timeout'               => 5,
                'connect_timeout'       => 5,
                'headers'               => [
                    'Accept'            => 'application/json',
                    'Accept-Encoding'   => 'gzip, deflate',
                    'x-api-key'         => $strApiKey
                ],
                "verify"                => false
            ];
            self::$_guzzleConnection    = new Client($arrDefaults);
        }
        return self::$_guzzleConnection;
    }
    protected function _callEndpoint(
        $strURL,
        Array $arrQuery                 = []
    )
    {
        $guzzleConnection = self::_getGuzzle($this->_strURL, $this->_strAPIKey);

        $response                   = $guzzleConnection
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
