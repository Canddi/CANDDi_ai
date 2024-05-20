<?php

namespace CanddiAi\Lookup;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\RequestException as RequestException;
use CanddiAi\Singleton\InterfaceSingleton;
use CanddiAi\Lookup\Response\UserAgent as ResponseUserAgent;
use CanddiAi\Traits\TraitSingleton;


class UserAgent
    implements InterfaceSingleton
{
    use TraitSingleton;

    const c_URL_Agent = 'lookup/useragent/%s';

    public function lookupAgent(
        $strUserAgent,
        $strAccountUrl = null,
        $guidContactId = null
    )
    {
        $strUserAgent = rawurlencode($strUserAgent);
        $strURL = sprintf(self::c_URL_Agent, $strUserAgent);
        $arrQuery = [
            'accounturl' => $strAccountUrl,
            'contactid'  => $guidContactId
        ];

        try {
            $arrResponse = $this->_callEndpoint(
                $strURL,
                $arrQuery
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Useragent:Host returned error for ($strUserAgent)".
                " on account ($strAccountUrl), Contact ($guidContactId)".
                $e->getMessage()
            );
        }

        if (
            !array_key_exists('BrowserVersion', $arrResponse) ||
            count($arrResponse) != 6
        ) {
            error_log(
                "Data not found on useragent " . $strUserAgent .
                " on account " . $strAccountUrl . ", Contact " .
                $guidContactId
            );
            $arrResponse = [];
        } else {
            $arrBrowserVersionParts = explode(
                ".", $arrResponse['BrowserVersion']
            );
            $arrResponse['BrowserVersion'] =
                $arrBrowserVersionParts[0] . '.' . $arrBrowserVersionParts[1];

            $arrOperatingVersionParts = explode(
                ".", $arrResponse['OperatingVersion']
            );
            $arrResponse['OperatingVersion'] =
                $arrOperatingVersionParts[0] . '.' .
                $arrOperatingVersionParts[1];

            $arrDeviceVersionParts = explode(
                ".", $arrResponse['DeviceVersion']
            );
            $arrResponse['DeviceVersion'] =
                $arrDeviceVersionParts[0] . '.' . $arrDeviceVersionParts[1];
        }

        return new ResponseUserAgent($arrResponse);
    }
}
