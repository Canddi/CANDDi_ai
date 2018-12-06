<?php

namespace CanddiAi\Lookup\Response;

class PersonTest
    extends \CanddiAi\TestCase
{
    private $response;

    private function _getTestData()
    {
        return array(
            "ContactInfo" => array(
                "FirstName" => "Bart",
                "LastName" => "Lorang",
                "Websites" => array(
                    array(
                        "url" => "https:\/\/fullcontact.com\/bart"
                    ),
                    array(
                        "url" => "http:\/\/bartlorang.com"
                    )
                ),
                "Chats" => array(
                    array(
                        "client" => "gtalk",
                        "handle" => "lorangb@gmail.com"
                    ),
                    array(
                        "client" => "skype",
                        "handle" => "bart.lorang"
                    )
                )
            ),
            "Demographics" => array(
                "LocationGeneral" => "80202 Denver, Colorado, United States",
                "LocationDeduced" => array(
                    "NormalizedLocation" => "Denver, Colorado, United States",
                    "DeducedLocation" => "Denver, Colorado, United States",
                    "City" => array(
                        "Deduced" => false,
                        "Name" => "Denver"
                    ),
                    "State" => array(
                        "Deduced" => false,
                        "Name" => "Colorado",
                        "Code" => "CO"
                    ),
                    "Country" => array(
                        "Deduced" => false,
                        "Name" => "United States",
                        "Code" => "US"
                    ),
                    "Continent" => array(
                        "Deduced" => true,
                        "Name" => "North America"
                    ),
                    "County" => array(
                        "Deduced" => true,
                        "Name" => ""
                    ),
                    "Likelihood" => 1
                ),
                "Gender" => "Male"
            ),
            "SocialProfiles" => array(
                array(
                    "bio" => "Co-Founder and CEO of FullContact",
                    "type" => "aboutme",
                    "typeId" => "aboutme",
                    "typeName" => "About.me",
                    "url" => "https:\/\/about.me\/lorangb",
                    "username" => "lorangb"
                ),
                array(
                    "type" => "facebook",
                    "typeId" => "facebook",
                    "typeName" => "Facebook",
                    "url" => "https:\/\/www.facebook.com\/bart.lorang"
                ),
                array(
                    "type" => "github",
                    "typeId" => "github",
                    "typeName" => "Github",
                    "url" => "https:\/\/github.com\/lorangb",
                    "username" => "lorangb"
                ),
                array(
                    "followers" => 1,
                    "type" => "google",
                    "typeId" => "google",
                    "typeName" => "GooglePlus",
                    "url" => "https:\/\/plus.google.com\/111748526539078793602",
                    "id" => "111748526539078793602"
                ),
                array(
                    "type" => "instagram",
                    "typeId" => "instagram",
                    "typeName" => "Instagram",
                    "url" => "https:\/\/instagram.com\/bartlorang"
                ),
                array(
                    "bio" => "Mr. Lorang is a proven entrepreneur, executive and manager in the global technology industry. Mr. Lorang is active in the startup technology community as an angel investor, strategic advisor and speaker at industry events. Bart serves as Co-Founder & CEO of FullContact. Mr. Lorang is responsible for communicating FullContact's vision and strategy. Mr. Lorang is a visionary technologist with extensive experience conceiving, designing, building, marketing and selling enterprise software solutions on a global scale. Bart is also Co-Founder and Managing Director of v1.vc, a $5M seed stage fund dedicated to helping crazy entrepreneurs change the world. Bart serves on the Board of the Colorado Technology Association, Rapt Media and is on the Advisory Board of Education Funding Partners. Bart is a regular guest on FOX Business channel and has been featured by ABC, CNN, FOX News, MSNBC, Forbes, FastCompany, Yahoo, Inc Magazine and TechCrunch. Prior to founding FullContact, Mr. Lorang was an owner in Dimension Technology Solutions where he served as President and oversaw all day to day operations, customer engagements, partner relations, product development, sales and marketing functions. Mr. Lorang is recognized for providing solutions that are simple and work reliably. He strongly believes in using technology to solve problems as opposed to using problems to demonstrate technology. Mr. Lorang holds a Bachelor of Science degree in Computer Science from the University of Colorado and an MBA from the Daniels College of Business at University of Denver. Specialties: Investments, Startups, Financial Analysis, Sales, Technical Sales, Implementations, System Integration, Project Management, Leadership",
                    "followers" => 500,
                    "following" => 500,
                    "type" => "linkedin",
                    "typeId" => "linkedin",
                    "typeName" => "LinkedIn",
                    "url" => "https:\/\/www.linkedin.com\/in\/bartlorang",
                    "username" => "bartlorang",
                    "id" => "8995706"
                ),
                array(
                    "type" => "quora",
                    "typeId" => "quora",
                    "typeName" => "Quora",
                    "url" => "http:\/\/www.quora.com\/bart-lorang",
                    "username" => "bart-lorang"
                ),
                array(
                    "bio" => "CEO & Co-Founder of @FullContact, Managing Director @v1vc_. Tech Entrepreneur, Investor. Husband to @parkerbenson and Father to Greyson Lorang",
                    "followers" => 5454,
                    "following" => 741,
                    "type" => "twitter",
                    "typeId" => "twitter",
                    "typeName" => "Twitter",
                    "url" => "https:\/\/twitter.com\/bartlorang",
                    "username" => "bartlorang",
                    "id" => "5998422"
                ),
            ),

            "DigitalFootprint" => array(
                "Topics" => array(
                    array(
                        "provider" => "aboutme",
                        "value" => "Angel Investor"
                    ),
                    array(
                        "provider" => "aboutme",
                        "value" => "Entrepreneur"
                    ),
                    array(
                        "provider" => "aboutme",
                        "value" => "Husband"
                    ),
                    array(
                        "provider" => "aboutme",
                        "value" => "Tech Nerd"
                    ),
                    array(
                        "provider" => "aboutme",
                        "value" => "Technology"
                    )
                ),
                "Scores" => ""
            ),
            "Organizations" => array(
                array(
                    "isPrimary" => false,
                    "name" => "V1.vc",
                    "startDate" => "2015-07",
                    "title" => "Co-Founder & Managing Director",
                    "current" => true
                ),
                array(
                    "isPrimary" => false,
                    "name" => "FullContact",
                    "startDate" => "2010",
                    "title" => "Co-Founder & CEO",
                    "current" => true
                )
            ),
            "Photos" => array(
                array(
                    "URL" => "https:\/\/upload.wikimedia.org/wikipedia\/en\/a\/a9\/Example.jpg",
                    "Name" => "Facebook",
                    "IsPrimary" => false
                ),
                array(
                    "URL" => "https:\/\/test-of-tests-for-testing.s3-eu-west-1.amazonaws.com\/bart%40fullcontact.com\/image\/Foursquare.png",
                    "Name" => "Foursquare",
                    "IsPrimary" => true
                )
            ),
            "Bio" => "Mr. Lorang is a proven entrepreneur, executive and manager in the global technology industry. Mr. Lorang is active in the startup technology community as an angel investor, strategic advisor and speaker at industry events. Bart serves as Co-Founder & CEO of FullContact. Mr. Lorang is responsible for communicating FullContact's vision and strategy. Mr. Lorang is a visionary technologist with extensive experience conceiving, designing, building, marketing and selling enterprise software solutions on a global scale. Bart is also Co-Founder and Managing Director of v1.vc, a $5M seed stage fund dedicated to helping crazy entrepreneurs change the world. Bart serves on the Board of the Colorado Technology Association, Rapt Media and is on the Advisory Board of Education Funding Partners. Bart is a regular guest on FOX Business channel and has been featured by ABC, CNN, FOX News, MSNBC, Forbes, FastCompany, Yahoo, Inc Magazine and TechCrunch. Prior to founding FullContact, Mr. Lorang was an owner in Dimension Technology Solutions where he served as President and oversaw all day to day operations, customer engagements, partner relations, product development, sales and marketing functions. Mr. Lorang is recognized for providing solutions that are simple and work reliably. He strongly believes in using technology to solve problems as opposed to using problems to demonstrate technology. Mr. Lorang holds a Bachelor of Science degree in Computer Science from the University of Colorado and an MBA from the Daniels College of Business at University of Denver. Specialties: Investments, Startups, Financial Analysis, Sales, Technical Sales, Implementations, System Integration, Project Management, Leadership",
            "JobTitle" => "CEO"
        );
    }

    public function testGetFirstName()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $strExpectedFirstName = "Bart";
        $strReturnedFirstName = $response->getFirstName();

        $this->assertEquals($strExpectedFirstName, $strReturnedFirstName);

        // Test to make sure it returns null when there's no firstname
        unset($testData["ContactInfo"]["FirstName"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getFirstName());

        // Test for if the ContactInfo field doesn't exist
        unset($testData["ContactInfo"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getFirstName());
    }

    public function testGetLastName()
    {
        $testData = $this->_getTestData();
        $response = new Person($this->_getTestData());

        $strExpectedLastName = "Lorang";
        $strReturnedLastName = $response->getLastName();

        $this->assertEquals($strExpectedLastName, $strReturnedLastName);

        unset($testData["ContactInfo"]["LastName"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getLastName());

        unset($testData["ContactInfo"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getLastName());
    }
    public function testGetBio()
    {
        $testData = $this->_getTestData();
        $response = new Person($this->_getTestData());

        $this->assertEquals($testData['Bio'], $response->getBio());

        unset($testData['Bio']);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getBio());
    }
    public function testGetRole()
    {
        $testData = $this->_getTestData();
        $response = new Person($this->_getTestData());

        $this->assertEquals($testData['JobTitle'], $response->getRole());

        unset($testData['JobTitle']);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getRole());
    }
    public function testGetSocialProfiles()
    {
        $response = new Person($this->_getTestData());

        $arrProfiles = $response->getSocialProfiles();

        $this->assertTrue(is_array($arrProfiles));
    }

    public function testGetPhotos()
    {
        $response = new Person($this->_getTestData());

        $arrPhotos = $response->getPhotos();

        $this->assertTrue(is_array($arrPhotos));
    }
    public function testGetPrimaryPhoto()
    {
        $response = new Person($this->_getTestData());

        $itemPhoto = $response->getPrimaryPhoto();

        $this->assertTrue($itemPhoto->bPrimary());
        $this->assertEquals("Foursquare", $itemPhoto->getName());
        $this->assertEquals(
            "https:\/\/test-of-tests-for-testing.s3-eu-west-1.amazonaws.com\/bart%40fullcontact.com\/image\/Foursquare.png",
            $itemPhoto->getURL()
        );
    }
    public function testGetPrimaryPhoto_NoPrimary()
    {
        $response = new Person([
            "Photos" => [
                [
                    "URL" => "a URL",
                    "Name" => "a Name",
                    "IsPrimary" => false
                ],
                [
                    "URL" => "another URL",
                    "Name" => "another Name",
                    "IsPrimary" => false
                ]
            ]
        ]);

        $itemPhoto = $response->getPrimaryPhoto();

        // Should pick first image
        $this->assertFalse($itemPhoto->bPrimary());
        $this->assertEquals("a Name", $itemPhoto->getName());
        $this->assertEquals("a URL", $itemPhoto->getURL());
    }
    public function testGetPrimaryPhoto_NoPhotos()
    {
        $response = new Person([]);

        $itemPhoto = $response->getPrimaryPhoto();

        // Should return null
        $this->assertNull($itemPhoto);
    }
}
