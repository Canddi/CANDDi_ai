<?php
/**
 * Service for CANDDi Company Lookup
 * https://api.canddi.net/lookup/....
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Tim Langley
 **/

namespace CanddiAI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Company
    extends LookupAbstract
{
    /**
        This class needs this as otherwise when we inject more than once in a unit test
        the second is overwritten, which was leading to issues where it would try to call
        get and so on on the Company class (and vice versa)
    **/
    protected static $_locater;

    const c_URL_Host    = 'lookup/hostname/%s';
    const c_URL_IP      = 'lookup/ip/%s';

    /**
     * Calls https://api.candd.net/lookup/host/[hostname]
     * end point and returns an array of data
     *
     * @param   string $strHostname
     * @param   optional string $strAccountURL
     * @param   optional string $guidContactId
     *
     * @return  array  structure as
     *              ** TODO REFACTOR THIS TO RETURN OBJECT **
     *
    **/
    public function lookupHost(
        $strHostName,
        $strAccountURL = null,
        $guidContactId = null
    ) {
        $strURL             = sprintf(self::c_URL_Host, $strHostName);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];

        try {
            $arrResponse    = $this->_callEndpoint(
                $strURL,
                $arrQuery
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Company:Host returned error for ($strHostName) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        return new Response\Company($arrResponse);
    }
    /**
     * Calls https://api.candd.net/lookup/ip/[ipaddress]
     * end point and returns an array of data
     *
     * @param   string $mixedIPAddress (either dot notation or integer)
     * @param   optional string $strAccountURL
     * @param   optional string $guidContactId
     *
     * @return  array  structure as
     *              ** TODO REFACTOR THIS TO RETURN OBJECT **
     *
    **/
    public function lookupIP(
        $mixedIPAddress,
        $strAccountURL = null,
        $guidContactId = null
    ) {
        $strURL             = sprintf(self::c_URL_IP, $mixedIPAddress);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];

        try {
            $arrResponse    = $this->_callEndpoint(
                $strURL,
                $arrQuery
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Company:IP returned error for ($mixedIPAddress) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        return new Response\Company($arrResponse);
    }
}
