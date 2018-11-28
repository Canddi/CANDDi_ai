<?php
/**
 * Lookup class for FullContact
 *
 * @package default
 * @author Jessica Tallon
 **/

use GuzzleHttp\Client;

class Canddi_Service_NormalizeName_API
    implements Canddi_Interface_Singleton
{
    use Canddi_Traits_Singleton;

    private static $_guzzleConnection   = null;

    const URL_NORMALIZE                 = 'person/name/%s/normalize';

    /**
     * This function is required because (whilst it should never happen)
     * Sometimes Zend_Json will return false not array
     *
     * @param  string (hopefully of json)
     * @return array
     * @author Jessica Tallon.
     **/
    private function _decodeJSON($strJson)
    {
        if(empty($strJson)) {
            return [];
        }

        return Canddi_Helper_Json::decode($strJson);
    }
    /**
     * Takes a name and normalizes it using FullContact's name normalization.
     *
     * @return void
     * @author Jessica Tallon
     **/
    public function normalizeName($strName)
    {
        $helperServers  = Canddi_Helper_Config_Servers::getInstance();
        if(!self::$_guzzleConnection) {
            self::$_guzzleConnection = new Client([
                'base_uri'          => $helperServers->getHostLookupServiceURL(),
                'timeout'           => 5,
                'connect_timeout'   => 5,
                'headers'           => [
                    'Accept'    => 'application/json',
                    'X-Api-Key' => $helperServers->getLookupAPIKey()
                ]
            ]);
        }
        $strName = rawurlencode(urldecode($strName));

        $response = self::$_guzzleConnection->request(
            'GET',
            sprintf(self::URL_NORMALIZE, $strName)
        );

        if(200 !== $response->getStatusCode()) {
            throw new Exception(
                $response->getStatusCode().'-'.$response->getReasonPhrase()
            );
        }
        $strBody        = $response->getBody();
        $arrInfo        = $this->_decodeJSON($strBody);
        return new Canddi_Service_NormalizeName_Response($arrInfo);
    }
}
