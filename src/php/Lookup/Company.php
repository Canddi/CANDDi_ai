<?php
/**
 * Service for CANDDi Company Lookup
 *
 * @author Tim Langley
 **/

namespace CanddiAi\Lookup;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use CanddiAi\Response\Company as ResponseCompany;

class Company
    extends LookupAbstract
{
    const c_URL_Host    = 'lookup/hostname/%s';
    const c_URL_IP      = 'lookup/ip/%s';
    const c_URL_Name    = 'lookup/company/%s';

    /**
     * Calls https://ip.candd.ai/lookup/host/[hostname]
     * end point and returns an array of data
     *
     * @param   string $strHostname
     * @param   optional string $strAccountURL
     * @param   optional string $guidContactId
     *
     * @return  array  structure as
     *
    **/
    public function lookupHost(
        $strHostName,
        $strAccountURL = null,
        $guidContactId = null
    )
    {
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
    )
    {
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

    public function lookupName(
        $strCompanyName,
        $strAccountURL = null,
        $guidContactId = null
    )
    {
        $strURL             = sprintf(self::c_URL_Name, $strCompanyName);
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
                "Service:Company:Name returned error for ($mixedIPAddress) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        return new ResponseCompany($arrResponse);
    }
}
