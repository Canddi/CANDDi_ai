<?php
/**
 * This is our people response for companies
 * it's a condensed version of our people endpoint
 * person_xxx_get lookups
 *
 * @author George Meadows
 **/

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Person
{
    const KEY_FORENAME = 'FirstName';
    const KEY_SURNAME = 'LastName';
    const KEY_EMAILS = 'EmailAddresses';
    const KEY_PHONES = 'PhoneNumbers';
    const KEY_SOCIAL = 'SocialMedia';
    const KEY_LEGAL_ROLE = 'LegalRole';
    const KEY_POSITION = 'Position';

    use NS_traitArrayValue;

    private $_arrResponse;
    private $_mdlCompanyResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getEmailAddresses()
    {
        $arrEmails  = $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_EMAILS
            ],
            []
        );

        return $arrEmails;
    }

    public function getFirstName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_FORENAME
            ],
            null
        );
    }

    public function getLastName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_SURNAME
            ],
            null
        );
    }

    public function getPhoneNumbers()
    {
        $arrPhones  = $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_PHONES
            ],
            []
        );

        return $arrPhones;
    }

    public function getSocialProfiles()
    {
        $arrProfiles  = $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_SOCIAL
            ],
            []
        );
        $arrReturn  = [];

        //This is a horrible way of returning
        // too many loops = slow code
        // @TODO refactor with an Iterator
        foreach ($arrProfiles as $arrProfile) {
            $arrReturn[] = new SocialMedia($arrProfile);
        }
        return $arrReturn;
    }

    public function getLegalRole()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_LEGAL_ROLE
            ],
            null
        );
    }

    public function getPosition()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_POSITION
            ],
            null
        );
    }
}
