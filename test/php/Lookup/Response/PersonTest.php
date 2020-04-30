<?php

namespace CanddiAi\Lookup\Response;

class PersonTestLinkedIn
    extends \CanddiAi\TestCase
{

    private function _getTestData()
    {
        return [
            "EmailAddresses" => [
                "not-real@fake.com"
            ],
            "SocialMedia" => [
                "Facebook" => [
                    "url" => "facebook.com/not-real",
                    "platform" => "Facebook",
                    "handle" => "not-real"
                ],
                "LinkedIn" => [
                    "url" => "linkedin.com/in/not-real",
                    "platform" => "LinkedIn",
                    "handle" => "not-real"
                ],
                "Twitter" => [
                    "url" => "twitter.com/not-real",
                    "platform" => "Twitter",
                    "handle" => "not-real"
                ]
            ],
            "PhoneNumbers" => [
                "+44123456789"
            ],
            "Location" => [
                [
                    "Address" => [
                        "PostalCode" => null,
                        "Line1" => null,
                        "Line2" => null,
                        "Country" => "united kingdom",
                        "Region" => "manchester"
                    ]
                ]
            ],
            "Name" => [
                "FirstName" => "not",
                "LastName" => "real",
                "MiddleName" => null,
                "FullName" => "not real"
            ],
            "Gender" => "male",
            "Employment" => [
                [
                    "CompanyName" => "the fake company",
                    "StartDate" => "2007-06",
                    "EndDate" => "2007-10",
                    "Title" => "venture capitalist",
                    "IsPrimary" => false
                ],
                [
                    "CompanyName" => "the sequel to the fake company",
                    "StartDate" => "2010-02",
                    "EndDate" => null,
                    "Title" => "ceo",
                    "IsPrimary" => true
                ]
            ],
            "Education" => [
                [
                    "Name" => "the fake school",
                    "StartDate" => null,
                    "EndDate" => "1996"
                ]
            ]
        ];
    }
    public function testGetFirstName()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $strExpectedFirstName = "not";
        $strReturnedFirstName = $response->getFirstName();

        $this->assertEquals($strExpectedFirstName, $strReturnedFirstName);

        // Test to make sure it returns null when there's no firstname
        unset($testData["Name"]["FirstName"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getFirstName());

        // Test for if the ContactInfo field doesn't exist
        unset($testData["Name"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getFirstName());
    }
    public function testGetLastName()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $strExpectedLastName = "real";
        $strReturnedLastName = $response->getLastName();

        $this->assertEquals($strExpectedLastName, $strReturnedLastName);

        // Test to make sure it returns null when there's no LastName
        unset($testData["Name"]["LastName"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getLastName());

        // Test for if the ContactInfo field doesn't exist
        unset($testData["Name"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getFirstName());
    }

    public function testGetRole()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);
        $itemRole = $response->getRole();

        $this->assertTrue($itemRole->bPrimary());
        $this->assertEquals('ceo', $itemRole->getTitle());
        $this->assertEquals('the sequel to the fake company', $itemRole->getName());
        $this->assertEquals('2010-02', $itemRole->getStartDate());
        $this->assertEquals('', $itemRole->getEndDate());

        unset($testData['Employment']);
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
    public function testGetEducation()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $arrEducation = $response->getEducation();

        $this->assertTrue(is_array($arrEducation));

        $expectedResponse = $testData['Education'];

        $this->assertEquals($expectedResponse, $arrEducation);
    }
}
