<?php
/**
 * Service for CANDDiAI NormalizeName Lookup
 *
 * @author Luke Roberts
 **/

namespace CanddiAi\Lookup;

use CanddiAi\Singleton\InterfaceSingleton;
use CanddiAi\Traits\TraitSingleton;

class NormalizeName
    implements InterfaceSingleton
{
    use TraitSingleton;

    const c_URL_NORMALIZE   = 'person/name/%s/normalize';

    /**
     * Takes a name and normalizes it
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
