<?php
/**
 * @author Tim Langley
 **/

namespace CanddiAI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Person
    extends LookupAbstract
{
    /**
        This class needs this as otherwise when we inject more than once in a unit test
        the second is overwritten, which was leading to issues where it would try to call
        getDescription and so on on the Person class (and vice versa)
    **/
    protected static $_locater;

    const c_URL_Person  = 'person/email/%s';
    /**
     * This calls the https://api.canddi.net/person/email/[emailaddress]
     * end point and returns an array of data
     *
     * @param   string $strEmailAddress - Email Address to call with
     * @param   optional string $strAccountURL
     * @param   optional string $guidContactId
     *
     * @return  array  structure as
     *              ** TODO REFACTOR THIS TO RETURN OBJECT **
     *
    **/
    public function lookupEmail(
        $strEmailAddress,
        $strAccountURL = null,
        $guidContactId = null
    ) {
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
                "Service:Person returned error for ($strEmailAddress) ".
                " on Account ($strAccountURL), Contact ($guidContactId) ".
                $e->getMessage()
            );
        }

        return new Response\Person($arrResponse);
    }
}
