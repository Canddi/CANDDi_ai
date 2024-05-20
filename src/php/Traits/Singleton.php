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
    private $_strAccessToken;

    /**
     * Prevent instantiation and cloning
     * ONLY use getInstance()
    **/
    final protected function __construct(
        $strURL,
        $strAccessToken
    )
    {
        if (empty($strURL) || empty($strAccessToken)) {
            throw new \Exception(
                "Unable to create instance - Missing URL OR Key"
            );
        }

        $this->_strURL      = $strURL;
        $this->_strAccessToken   = $strAccessToken;
    }

    final protected function __clone()
    {
        throw new \Exception('Cannot clone');
    }

    /**
     *  Implements the singleton pattern
     *  @return $this       - this is a fluent interface
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
        $strAccessToken  = null
    )
    {
        if (is_null(static::$_locater)) {
            static::$_locater   = new static(
                $strURL,
                $strAccessToken
            );
        }

        static::$_locater->setAccessToken(
            $strAccessToken
        );

        return static::$_locater;
    }

    private function setAccessToken(
        $strAccessToken = null
    )
    {
        $this->_strAccessToken = $strAccessToken;
    }
    /**
     * This method is used for testing
     *  @param static $locator    - this is mainly for testing
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
     * @param \GuzzleHttp\Client $guzzleConnection
     **/
    public static function injectGuzzle(
        Client $guzzleConnection
    )
    {
        self::$_guzzleConnection    = $guzzleConnection;
    }
    protected static function _getGuzzle($strBaseUri, $strAccessToken)
    {
        if (!self::$_guzzleConnection) {
            $arrDefaults                = [
                'base_uri'              => $strBaseUri,
                'timeout'               => 10,
                'connect_timeout'       => 10,
                'headers'               => [
                    'Accept'            => 'application/json',
                    'Accept-Encoding'   => 'gzip, deflate',
                    'Authorization'         => $strAccessToken
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
        $guzzleConnection = self::_getGuzzle(
            $this->_strURL,
            $this->_strAccessToken
        );

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
