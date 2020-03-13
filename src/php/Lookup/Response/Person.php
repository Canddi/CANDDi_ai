<?php
/**
 * Wrapper for CANDDi Lookup
 * https://api.canddi.net
 *
 * @TODO REFACTOR THIS TO a separate composer package
 * @TODO REPLACE THIS WITH PRESONLINKEDIN
 *
 * @author Tim Langley
 **/

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Person
{
    const KEY_BIO           = 'Bio';
    const KEY_CONTACT       = 'ContactInfo';
    const KEY_FORENAME      = 'FirstName';
    const KEY_ROLE          = 'JobTitle';
    const KEY_SURNAME       = 'LastName';
    const KEY_PHOTO         = 'Photos';
    const KEY_SOCIAL        = 'SocialProfiles';

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
                self::KEY_CONTACT,
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
                self::KEY_CONTACT,
                self::KEY_SURNAME
            ],
            null
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
    public function getRole()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_ROLE
            ],
            null
        );
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

        //This is a horrible way of returning
        // too many loops = slow code
        // @TODO refactor with an Iterator
        foreach ($arrPhotos as $arrPhoto) {
            $arrReturn[] = new Item\Photo($arrPhoto);
        }
        return $arrReturn;
    }
    /**
     * Finds the first photo with IsPrimary = true
     *
     * @return Item\Photo | null    The primary image (first photo is used if
     *                                  primary is not present), or null if no
     *                                  photos are present.
     */
    public function getPrimaryPhoto()
    {
        $arrPhotos  = $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_PHOTO
            ],
            []
        );

        foreach ($arrPhotos as $arrPhoto) {
            if (isset($arrPhoto['IsPrimary']) && $arrPhoto['IsPrimary']) {
                $itemPhoto = new Item\Photo($arrPhoto);
                break;
            }
        }
        if (!isset($itemPhoto)) {
            if (empty($arrPhotos)) {
                // Got no photos, explicitly return null
                return null;
            }
            // Choose the first photo if we don't have a primary
            $itemPhoto = new Item\Photo($arrPhotos[0]);
        }
        return $itemPhoto;
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
}
