<?php
/**
 * This is our default response for our
 * person_xxx_get lookups
 *
 * @author George Meadows
 **/

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;
use CanddiAi\Lookup\Response\Company\Company as ResponseCompany;

class Person
{
    const KEY_BIRTHDATE = 'BirthDate';
    const KEY_NAME = 'Name';
    const KEY_FORENAME = 'FirstName';
    const KEY_MIDDLE = 'MiddleName';
    const KEY_SURNAME = 'LastName';
    const KEY_GENDER = 'Gender';
    const KEY_EMAILS = 'EmailAddresses';
    const KEY_PHONES = 'PhoneNumbers';
    const KEY_ROLE = 'Employment';
    const KEY_EDUCATION = 'Education';
    const KEY_PHOTO = 'Pictures';
    const KEY_SOCIAL = 'SocialMedia';
    const KEY_BIO = 'Bio';
    const KEY_REPROCESS = 'Reprocess';

    use NS_traitArrayValue;

    private $_arrResponse;
    private $_mdlCompanyResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = [];
        if(array_key_exists('Person', $arrResponse)) {
            $this->_arrResponse = $arrResponse['Person'];
        }

        if(array_key_exists('Company', $arrResponse)) {
            $this->_mdlCompanyResponse = new ResponseCompany($arrResponse['Company']);
        } else {
            $this->_mdlCompanyResponse = new ResponseCompany([]);
        }
    }

    /**
     * @return  bool
     */
    public function bIsReprocessing() {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_REPROCESS],
            false
        );
    }

    public function getCompany()
    {
        return $this->_mdlCompanyResponse;
    }

    public function getBirthDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_BIRTHDATE],
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
                self::KEY_NAME,
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
                self::KEY_NAME,
                self::KEY_SURNAME
            ],
            null
        );
    }
    public function getGender()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_GENDER],
            null
        );
    }
    public function getRole()
    {
        $arrRoles =  $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_ROLE
            ],
            []
        );

        foreach ($arrRoles as $arrRole) {
            if (isset($arrRole['IsPrimary']) && $arrRole['IsPrimary']) {
                $itemRole = new Item\Role($arrRole);
                break;
            }
        }

        if (!isset($itemRole)) {
            if (empty($arrRoles)) {
                // Got no photos, explicitly return null
                return null;
            }
            // Choose the first photo if we don't have a primary
            $itemRole = new Item\Role($arrRoles[0]);
        }
        return $itemRole;
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
    public function getPhotos()
    {
        $arrPhotos  = $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_PHOTO
            ],
            []
        );

        return $arrPhotos;
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
            $arrReturn[] = new Item\Social($arrProfile);
        }
        return $arrReturn;
    }
    public function getEducation()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_EDUCATION
            ],
            []
        );
    }
    public function getBio()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_BIO
            ],
            null
        );
    }
}
