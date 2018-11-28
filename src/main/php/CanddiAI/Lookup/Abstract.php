<?php
/**
 * Wrapper for CANDDi Lookup
 * https://api.canddi.net
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Tim Langley
 **/

namespace CanddiAI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

abstract class LookupAbstract
    implements \Canddi_Interface_Singleton
{
    use \Canddi_Traits_Singleton;

    private static $_guzzleConnection       = null;

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

            $helperServers = \Canddi_Helper_Config_Servers::getInstance();

            $arrDefaults                = [
                'base_uri'              => $helperServers
                    ->getHostLookupServiceURL(),
                'timeout'               => 5,
                'connect_timeout'       => 5,
                'headers'               => [
                    'Accept'            => 'application/json',
                    'Accept-Encoding'   => 'gzip, deflate',
                    'x-api-key'         => $helperServers
                        ->getLookupAPIKey()
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
            throw new \Exception(
                $response->getStatusCode().'-'.$response->getReasonPhrase()
            );
        }

        return json_decode(
            (string)$response->getBody(), true
        );
    }
}
