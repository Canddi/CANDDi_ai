<?php
/**
 * Service for Stackpath api
 *
 * @author Shane Critchley-Kenyon
 **/

namespace Canddi\Service;

class Stackpath
    implements \Canddi_Interface_Singleton
{
    use \Canddi_Traits_Singleton;

    const SITE_ID = "588278";
    const COMPANY_ALIAS = "lhzufrjflvifva";
    const CLIENT_KEY = "566f54bc5c6cfba84ec3c5270929895e0589d01a3";
    const CLIENT_SECRET = "31241c01c78ca65b514db280923f747d";

    public function clearCache(Array $arrParams = []) {

        $api = new \MaxCDN(
            self::COMPANY_ALIAS,
            self::CLIENT_KEY,
            self::CLIENT_SECRET
        );

        return $api->delete('/sites/'.self::SITE_ID.'/cache', $arrParams);
    }
}
