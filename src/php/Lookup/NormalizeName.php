<?php
/**
 * Service for CANDDiAI NormalizeName Lookup
 *
 * @author Luke Roberts
 **/

namespace CanddiAi\Lookup;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class NormalizeName
    extends LookupAbstract
{
    const c_URL_NORMALIZE   = 'person/name/%s/normalize';

    /**
     * Takes a name and normalizes it using FullContact's name normalization.
     *
     * @return void
     * @author Luke Roberts
     **/
    public function normalizeName(
        $strName
    )
    {
        $strURL             = sprintf(self::c_URL_NORMALIZE, $strName);

        try {
            $arrResponse    = $this->_callEndpoint(
                $strURL
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:NormalizeName returned error for ($strName) " .
                $e->getMessage()
            );
        }

        return new Response\NormalizeName($arrResponse);
    }
}