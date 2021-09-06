<?php
/**
 * This is our people response for companies
 * it's a condensed version of our people endpoint
 * person_xxx_get lookups
 *
 * @author George Meadows
 **/

namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Person
{
    const KEY_PERSONID = 'PersonId';
    const KEY_NAME = 'Name';
    const KEY_FORENAME = 'FirstName';
    const KEY_SURNAME = 'LastName';
    const KEY_EMAIL = 'Email';
    const KEY_JOBROLE = 'JobRole';
    const KEY_PERSONALDESCRIPTION = 'PersonalDescription';
    const KEY_EMAILS = 'Emails';
    const KEY_PHONES = 'Phones';
    const KEY_SOCIAL = 'SocialMedia';
    const KEY_LEGAL_ROLE = 'LegalRole';
    const KEY_YEARSATCOMPANY = 'YearsAtCompany';
    const KEY_YEARSINROLE = 'YearsInRole';
    const KEY_YEARSEXPERIENCE = 'YearsExperience';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getPersonId()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PERSONID],
            null
        );
    }
    public function getName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_NAME],
            null
        );
    }
    public function getEmail()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_EMAIL],
            null
        );
    }
    public function getJobRole()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_JOBROLE],
            null
        );
    }
    public function getPersonalDescription()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PERSONALDESCRIPTION],
            null
        );
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

    public function getYearsAtCompany()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_YEARSATCOMPANY],
            null
        );
    }
    public function getYearsInRole()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_YEARSINROLE],
            null
        );
    }
    public function getYearsExperience()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_YEARSEXPERIENCE],
            null
        );
    }
}
