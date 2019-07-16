<?php

namespace CanddiAi\Lookup;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\RequestException as RequestException;
use CanddiAi\Singleton\InterfaceSingleton;
use CanddiAi\Lookup\Response\Address as ResponseAddress;
use CanddiAi\Traits\TraitSingleton;


class Address
    implements InterfaceSingleton
{
    use TraitSingleton;

    const c_URL_Address = 'lookup/address/%s';

    public function lookupAddress(
        $strAddress
    )
    {
        $strAddress = rawurlencode($strAddress);
        $strURL = sprintf(self::c_URL_Address, $strAddress);

        try {
            $arrResponse = $this->_callEndpoint(
                $strURL
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Address:Host returned error for ($strAddress)".
                $e->getMessage()
            );
        }

        return new ResponseAddress($arrResponse);
    }
}
