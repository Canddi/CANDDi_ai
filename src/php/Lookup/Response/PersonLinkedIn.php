<?php
/**
 * This will soon be the new person response
 *
 * Currently we only have this for LinkedIn lookup
 *
 * @TODO This should be the default preson response
 *
 * @author George Meadows
 **/

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class PersonLinkedIn
{
    const KEY_NAME = 'Name';
    const KEY_FORENAME = 'FirstName';
    const KEY_MIDDLE = 'MiddleName';
    const KEY_SURNAME = 'LastName';
    const KEY_EMAILS = 'EmailAddresses';
    const KEY_PHONES = 'PhoneNumbers';
    const KEY_ROLE = 'Employment';
    const KEY_EDUCATION = 'Education';
    const KEY_PHOTO = 'Photos';
    const KEY_SOCIAL = 'SocialMedia';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
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
    public function getPhotos()
    {
        $arrPhotos  = $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_PHOTO
            ],
            []
        );
        $arrReturn  = [];
        return $arrReturn;
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
}
