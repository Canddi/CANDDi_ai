<?php

namespace CanddiAi\Lookup\Response;

class PersonTestLinkedIn
    extends \CanddiAi\TestCase
{

    private function _getTestData()
    {
        return [
            "Company" => [
                "WebsiteURL" => [
                    "canddi.com"
                ],
                "SocialMedia" => [
                    "Pinterest" => [
                        "url" => "pinterest.com/canddi",
                        "platform" => "Pinterest",
                        "handle" => "canddi"
                    ],
                    "Facebook" => [
                        "url" => "facebook.com/thisiscanddi",
                        "platform" => "Facebook",
                        "handle" => "thisiscanddi"
                    ],
                    "Twitter" => [
                        "url" => "twitter.com/canddi",
                        "platform" => "Twitter",
                        "handle" => "canddi"
                    ],
                    "Youtube" => [
                        "url" => "youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g",
                        "platform" => "Youtube",
                        "handle" => "UCU7aljz8YC9IdPfxuxLY39g"
                    ],
                    "LinkedIn" => [
                        "url" => "linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-",
                        "platform" => "LinkedIn",
                        "handle" => "canddi-campaign-and-digital-intelligence-limited-"
                    ]
                ],
                "Description" => "Campaign and Digital Intelligence => the Prospect Analytics Pioneer. \n\nCANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI.\n\nCANDDi helps you to =>\n - Close Deals => Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking\n - Nurture Leads => Identify the hot prospects and the nearly customers and automatically nurture them towards a sale\n - Optimise Marketing => Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads",
                "Heading" => "Turn visitors intoleads, and leadsinto sales.",
                "PhoneNumbers" => [
                    "+441614141080"
                ],
                "EmailAddresses" => [
                    "hello@canddi.com",
                    "help@canddi.com",
                    "dpo@canddi.com",
                    "privacy@canddi.com"
                ],
                "CompanyName" => "CANDDi (Campaign and Digital Intelligence Limited)",
                "EmployeeRange" => "11-50 employees",
                "Location" => [
                    "Lat" => 53.4819,
                    "Lng" => -2.2331,
                    "Line1" => "47 Newton Street",
                    "Line2" => "City Centre",
                    "PostCode" => "M1 1FT",
                    "City" => "Manchester",
                    "CountryCode" => "GB",
                    "Region" => "ENG"
                ],
                "Legal" => [
                    "LegalName" => "CAMPAIGN AND DIGITAL INTELLIGENCE",
                    "CRN" => "07066939",
                    "IncorporationDate" => "2009-11-05",
                    "CompanyType" => "private limited company",
                    "RegisteredLocation" => [
                        "Lat" => 53.4819,
                        "Lng" => -2.2331,
                        "Line1" => "47 Newton Street",
                        "Line2" => "City Centre",
                        "PostCode" => "M1 1FT",
                        "City" => "Manchester",
                        "CountryCode" => "GB",
                        "Region" => "ENG"
                    ]
                ]
            ],
            "Debug" => [
                "p2PersonId" => 1,
                "TimeUpdated" => 1590000000,
                "Reprocess" => false
            ],
            "Person" => [
                "EmailAddresses" => [
                    "tim@canddi.com",
                    "tim@timlangley.me.uk"
                ],
                "SocialMedia" => [
                    "Facebook" => [
                        "url" => "facebook.com/timlangley",
                        "platform" => "Facebook",
                        "handle" => "timlangley"
                    ],
                    "LinkedIn" => [
                        "url" => "linkedin.com/in/tim-langley-2894a11",
                        "platform" => "LinkedIn",
                        "handle" => "tim-langley-2894a11"
                    ],
                    "Twitter" => [
                        "url" => "twitter.com/timlangley",
                        "platform" => "Twitter",
                        "handle" => "timlangley"
                    ]
                ],
                "PhoneNumbers" => [
                    "+441234567890"
                ],
                "Location" => [
                    "Lat" => 0,
                    "Lng" => 0,
                    "Line1" => "",
                    "Line2" => "",
                    "PostCode" => "",
                    "City" => "",
                    "CountryCode" => "GB",
                    "Region" => "manchester"
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
                        "CompanyName" => "the sequel to the fake company",
                        "StartDate" => "2010-02",
                        "EndDate" => null,
                        "Title" => "ceo",
                        "IsPrimary" => true
                    ]
                ],
                "Education" => [
                    [
                        "Name" => "manchester business school",
                        "StartDate" => "2006",
                        "EndDate" => "2008"
                    ]
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
        unset($testData['Person']["Name"]["FirstName"]);
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
        unset($testData['Person']["Name"]["LastName"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getLastName());

        // Test for if the ContactInfo field doesn't exist
        unset($testData['Person']["Name"]);
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

        unset($testData['Person']['Employment']);
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

        $expectedResponse = $testData['Person']['Education'];

        $this->assertEquals($expectedResponse, $arrEducation);
    }
    public function testGetEmailAddresses()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $arrEmails = $response->getEmailAddresses();
        $expectedResponse = $testData['Person'][Person::KEY_EMAILS];

        $this->assertEquals($expectedResponse, $arrEmails);
    }
    public function testGetPhoneNumbers()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $arrPhones = $response->getPhoneNumbers();
        $expectedResponse = $testData['Person'][Person::KEY_PHONES];

        $this->assertEquals($expectedResponse, $arrPhones);
    }
    public function testNoPersonField() {
        $arrTestData = $this->_getTestData()['Person'];

        $response = new Person($arrTestData);

        $expectedResponse = $arrTestData[Person::KEY_PHONES];
        $actualResponse = $response->getPhoneNumbers();

        $this->assertEquals($expectedResponse, $actualResponse);
    }
}
