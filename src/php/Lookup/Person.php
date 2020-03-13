<?php
/**
 * Service for CANDDi Person Lookup
 * https://api.canddi.net/person/....
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Tim Langley
 **/

namespace CanddiAi\Lookup;

use CanddiAi\Singleton\InterfaceSingleton;
use CanddiAi\Traits\TraitSingleton;

class Person
    implements InterfaceSingleton
{
    use TraitSingleton;

    const c_URL_Person  = 'person/email/%s';
    const c_URL_LinkedIn = 'person/linkedin/%s';
    /**
     * This calls the https://api.canddi.net/person/email/[emailaddress]
     * end point and returns an array of data
     *
     * @param   string $strEmailAddress - Email Address to call with
     * @param   optional string $strAccountURL
     * @param   optional string $guidContactId
     *
     * @return  Response\Person
     *
    **/
    public function lookupEmail(
        $strEmailAddress,
        $strAccountURL = null,
        $guidContactId = null
    )
    {
        $strURL             = sprintf(self::c_URL_Person, $strEmailAddress);
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
                "Service:Person:Email returned error for ($strEmailAddress) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        return new Response\Person($arrResponse);
    }

    public function lookupLinkedIn(
        $strLinkedInUsername,
        $strAccountURL = null,
        $guidContactId = null,
        $strCallbackUrl = null,
        $arrCallbackOptions = []
    )
    {
        $strURL = sprintf(self::c_URL_LinkedIn, $strLinkedInUsername);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => $strCallbackUrl,
            'cboptions'     => str_replace('"', '\\"', json_encode($arrCallbackOptions,JSON_FORCE_OBJECT))
        ];

        try {
            $arrResponse = $this->_callEndpoint(
                $strURL,
                $arrQuery
            );
        } catch(\Exception $e) {
            throw new \Exception(
                "Service:Person:LinkedIn returned error for ($strLinkedInUsername) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        return new Response\PersonLinkedIn($arrResponse);
    }
}
