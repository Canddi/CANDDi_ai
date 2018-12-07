<?php
/**
 * Wrapper for CANDDi Lookup
 * https://api.canddi.net
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Tim Langley
 **/

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;
/*
    Raw data looks like:

    {
        "Description": "",
        "ContactInfo": {
            "LastName": "Langley",
            "FirstName": "Tim",
            "Websites": [
                {
                    "url": "http:\/\/timlangley.me.uk"
                },
                {
                    "url": "http:\/\/www.timlanlgey.me.uk"
                }
            ],
            "Chats": ""
        },
        "Demographics": {
            "LocationGeneral": "Manchester, England, United Kingdom",
            "LocationDeduced": {
                "NormalizedLocation": "Manchester, England, United Kingdom",
                "DeducedLocation": "Manchester, England, United Kingdom",
                "City": {
                    "Deduced": false,
                    "Name": "Manchester"
                },
                "State": {
                    "Deduced": false,
                    "Name": "England",
                    "Code": "ENG"
                },
                "Country": {
                    "Deduced": false,
                    "Name": "United Kingdom",
                    "Code": "GB"
                },
                "Continent": {
                    "Deduced": true,
                    "Name": "Europe"
                },
                "County": {
                    "Deduced": true,
                    "Name": "City And Borough Of Manchester",
                    "Code": ""
                },
                "Likelihood": 1
            },
            "Age": "",
            "Gender": "Male",
            "AgeRange": ""
        },
        "SocialProfiles": [
            {
                "type": "aboutme",
                "typeId": "aboutme",
                "typeName": "About.me",
                "url": "https:\/\/about.me\/timlangley",
                "username": "timlangley"
            },
            {
                "bio": "Early stage technologist and entrepreneur.  Co-founder @canddi",
                "followers": 174,
                "type": "angellist",
                "typeId": "angellist",
                "typeName": "AngelList",
                "url": "https:\/\/angel.co\/timlangley",
                "username": "timlangley",
                "id": "177305"
            },
            {
                "type": "facebook",
                "typeId": "facebook",
                "typeName": "Facebook",
                "url": "https:\/\/www.facebook.com\/timlangley"
            },
            {
                "type": "foursquare",
                "typeId": "foursquare",
                "typeName": "Foursquare",
                "url": "https:\/\/foursquare.com\/user\/58169",
                "id": "58169"
            },
            {
                "followers": 26,
                "type": "google",
                "typeId": "google",
                "typeName": "GooglePlus",
                "url": "https:\/\/plus.google.com\/108444331901471510044",
                "id": "108444331901471510044"
            },
            {
                "type": "gravatar",
                "typeId": "gravatar",
                "typeName": "Gravatar",
                "url": "https:\/\/gravatar.com\/canddi1",
                "username": "canddi1",
                "id": "15376356"
            },
            {
                "type": "klout",
                "typeId": "klout",
                "typeName": "Klout",
                "url": "http:\/\/klout.com\/TimLangley",
                "username": "TimLangley",
                "id": "65302199362501867"
            },
            {
                "bio": "CEO and Founder CANDDi I created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the team. Specialties: Innovation, Creativity and Entrepreneurship Early stage finance and Business Analysis Expert knowledge of Javascript (Backbone), PHP (Zend), No-SQL and Big Data",
                "followers": 500,
                "following": 500,
                "type": "linkedin",
                "typeId": "linkedin",
                "typeName": "LinkedIn",
                "url": "https:\/\/www.linkedin.com\/in\/langleytim",
                "username": "langleytim",
                "id": "4190793"
            },
            {
                "followers": 23,
                "following": 54,
                "type": "pinterest",
                "typeId": "pinterest",
                "typeName": "Pinterest",
                "url": "http:\/\/www.pinterest.com\/langleytim\/",
                "username": "langleytim"
            },
            {
                "type": "plancast",
                "typeId": "plancast",
                "typeName": "Plancast",
                "url": "http:\/\/www.plancast.com\/timlangley",
                "username": "timlangley",
                "id": "20984"
            },
            {
                "bio": "Early stage technologist and entrepreneur.  Co-founder @CANDDi",
                "followers": 691,
                "following": 597,
                "type": "twitter",
                "typeId": "twitter",
                "typeName": "Twitter",
                "url": "https:\/\/twitter.com\/TimLangley",
                "username": "TimLangley",
                "id": "14360125"
            }
        ],
        "DigitalFootprint": {
            "Topics": [
                {
                    "provider": "angellist",
                    "value": "Investor"
                },
                {
                    "provider": "klout",
                    "value": "Angel Investing"
                },
                {
                    "provider": "klout",
                    "value": "CEOs and Executives"
                },
                {
                    "provider": "klout",
                    "value": "Entrepreneurship"
                },
                {
                    "provider": "klout",
                    "value": "Manchester"
                },
                {
                    "provider": "klout",
                    "value": "Newcastle Upon Tyne"
                }
            ],
            "Scores": [
                {
                    "provider": "klout",
                    "type": "general",
                    "value": 28
                }
            ]
        },
        "Organizations": [
            {
                "isPrimary": false,
                "name": "CANDDi (Campaign and Digital Intelligence Limited)",
                "startDate": "2009-06",
                "title": "CEO and Founder",
                "current": true
            }
        ],
        "Photos": [
            {
                "URL": "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/tim%40canddi.com\/image\/Pinterest.png",
                "Name": "Pinterest",
                "IsPrimary": false
            },
            {
                "URL": "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/tim%40canddi.com\/image\/LinkedIn.png",
                "Name": "LinkedIn",
                "IsPrimary": true
            },
            {
                "URL": "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/tim%40canddi.com\/image\/Foursquare.png",
                "Name": "Foursquare",
                "IsPrimary": false
            },
            {
                "URL": "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/tim%40canddi.com\/image\/Gravatar.png",
                "Name": "Gravatar",
                "IsPrimary": false
            },
            {
                "URL": "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/tim%40canddi.com\/image\/Facebook.png",
                "Name": "Facebook",
                "IsPrimary": false
            },
            {
                "URL": "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/tim%40canddi.com\/image\/Twitter.png",
                "Name": "Twitter",
                "IsPrimary": false
            }
        ]
    }
*/
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

        foreach($arrPhotos as $arrPhoto) {
            if(isset($arrPhoto['IsPrimary']) && $arrPhoto['IsPrimary']) {
                $itemPhoto = new Item\Photo($arrPhoto);
                break;
            }
        }
        if(!isset($itemPhoto)) {
            if(empty($arrPhotos)) {
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
