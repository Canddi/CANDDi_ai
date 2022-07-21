<?php
namespace CanddiAi\Lookup\Response\Company;

use \CanddiAi\TestCase as TestCase;

class CompanyTest
    extends TestCase
{
    private function _getTestData()
    {
        return [
            "Hostname" => "canddi.com",
            "SIC" => [
                "62012"
            ],
            "VAT" => "GB107133945",
            "Email" => "hello@canddi.com",
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
            ],
            "Phone" => "0161 414 1080",
            "Heading" => "Lets turn yourwebsite visitors intocustomers",
            "Sectors" => [
                "Marketing and Advertising",
                "Software company",
                "Marketing Boards and Bodies",
                "Overseas Real Estate Agents"
            ],
            "Keywords" => [
                "developer",
                "lead",
                "trial",
                "level",
                "ship",
                "summary",
                "marketing",
                "activity",
                "login",
                "tracking",
                "knowing",
                "opportunity",
                "case",
                "visitor",
                "attribution",
                "board",
                "manager",
                "measure",
                "tech"
            ],
            "Location" => [
                "Lat" => 53.4819,
                "Lng" => -2.2331,
                "Line1" => "47 Newton Street",
                "Line2" => "City Centre",
                "PostCode" => "M1 1FT",
                "City" => "Manchester",
                "CountryCode" => "GB",
                "Region" => "North West England"
            ],
            "WebsiteURL" => [
                "canddi.com"
            ],
            "CompanyName" => "CANDDi (Campaign and Digital Intelligence Limited)",
            "Description" => "Campaign and Digital Intelligence: the Prospect Analytics Pioneer. CANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI. CANDDi helps you to: - Close Deals: Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking - Nurture Leads: Identify the hot prospects and the nearly customers and automatically nurture them towards a sale - Optimise Marketing: Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads",
            "SocialMedia" => [
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
                "Facebook" => [
                    "url" => "facebook.com/thisiscanddi",
                    "platform" => "Facebook",
                    "handle" => "thisiscanddi"
                ],
                "LinkedIn" => [
                    "url" => "linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-",
                    "platform" => "LinkedIn",
                    "handle" => "canddi-campaign-and-digital-intelligence-limited-"
                ],
                "Pinterest" => [
                    "url" => "pinterest.com/canddi",
                    "platform" => "Pinterest",
                    "handle" => "canddi"
                ]
            ],
            "PhoneNumbers" => [
                "+441614141080"
            ],
            "EmployeeRange" => "11-50",
            "EmailAddresses" => [
                "hello@canddi.com"
            ],
            "CompanyEmailPlatforms" => [
                [
                    "MX" => "*google.com",
                    "Type" => "Gmail",
                    "Priority" => 1
                ],
                [
                    "MX" => "*googlemail.com",
                    "Type" => "Gmail",
                    "Priority" => 10
                ]
            ],
            "Logo"    => "https://images.canddi.net/canddi.com/logo.png",
            "People" => [
                [
                    "PersonId" => 2175927,
                    "Name" => "Tim Langley",
                    "FirstName" => "Tim",
                    "LastName" => "Langley",
                    "Phones" => [],
                    "Emails" => [
                        "tim.langley@canddi.com",
                        "tim.langley@kompli-global.com",
                        "tim@canddi.com",
                        "tim@help-email.canddi.com",
                        "tim@lcfcomputers.co.uk"
                    ],
                    "Email" => "tim@canddi.com",
                    "SocialMedia" => [
                        "Twitter" => [
                            "url" => "twitter.com/timlangley",
                            "platform" => "Twitter",
                            "handle" => "timlangley"
                        ],
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/langleytim",
                            "platform" => "LinkedIn",
                            "handle" => "langleytim"
                        ]
                    ],
                    "LegalRole" => "Director",
                    "JobRole" => "CEO and Founder",
                    "PersonalDescription" => "CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t",
                    "YearsAtCompany" => 13,
                    "YearsInRole" => 13,
                    "YearsExperience" => 25
                ],
                [
                    "PersonId" => 2099560,
                    "Name" => "Jasmine Collins",
                    "FirstName" => "Jasmine",
                    "LastName" => "Collins",
                    "Phones" => [],
                    "Emails" => [
                        "jasmine.collins@canddi.com"
                    ],
                    "Email" => "jasmine.collins@canddi.com",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/jasmineelizabethcollins",
                            "platform" => "LinkedIn",
                            "handle" => "jasmineelizabethcollins"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Customer Success Manager",
                    "PersonalDescription" => "I'm an experienced and passionate events industry professional with 3 years' experience in Marketing, Events Management, and Content Creation. I have a demonstrated ability to drive online engagement ",
                    "YearsAtCompany" => 2,
                    "YearsInRole" => 2,
                    "YearsExperience" => 8
                ],
                [
                    "PersonId" => 605935,
                    "Name" => "Daniel Wingfield",
                    "FirstName" => "Daniel",
                    "LastName" => "Wingfield",
                    "Phones" => [],
                    "Emails" => [
                        "daniel@canddi.com"
                    ],
                    "Email" => "daniel@canddi.com",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/daniel-wingfield-3298a5b7",
                            "platform" => "LinkedIn",
                            "handle" => "daniel-wingfield-3298a5b7"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Customer Care Manager",
                    "PersonalDescription" => "What Does CANDDi Do?Improve your sales and marketing results by knowing who came on your website and what pages or products they have been looking at.CANDDi For Sales- Identify and prioritize leads.- ",
                    "YearsAtCompany" => 6,
                    "YearsInRole" => 6,
                    "YearsExperience" => 7
                ],
                [
                    "PersonId" => 2099561,
                    "Name" => "Claire Garside",
                    "FirstName" => "Claire",
                    "LastName" => "Garside",
                    "Phones" => [],
                    "Emails" => [
                        "claire.garside@canddi.com"
                    ],
                    "Email" => "claire.garside@canddi.com",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/claire-garside-3b0a16194",
                            "platform" => "LinkedIn",
                            "handle" => "claire-garside-3b0a16194"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Senior Sales Consultant",
                    "PersonalDescription" => "If you want to know exactly WHO has been visiting your website and what they did when they got there, then don't hesitate to contact me",
                    "YearsAtCompany" => 3,
                    "YearsInRole" => 3,
                    "YearsExperience" => 3
                ],
                [
                    "PersonId" => 2099558,
                    "Name" => "Iuliia",
                    "FirstName" => "Iuliia",
                    "LastName" => "",
                    "Phones" => [],
                    "Emails" => [
                        "iuliia@canddi.com"
                    ],
                    "Email" => "iuliia@canddi.com",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/iuliia-yulia-nikonova-2551a2105",
                            "platform" => "LinkedIn",
                            "handle" => "iuliia-yulia-nikonova-2551a2105"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Data Scientist",
                    "PersonalDescription" => "",
                    "YearsAtCompany" => 4,
                    "YearsInRole" => 4,
                    "YearsExperience" => 8
                ],
                [
                    "PersonId" => 2099559,
                    "Name" => "Logan White",
                    "FirstName" => "Logan",
                    "LastName" => "White",
                    "Phones" => [],
                    "Emails" => [
                        "logan.white@kompli-global.com",
                        "logan@timlangley.me.uk"
                    ],
                    "Email" => "",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/logan-white-65b14b126",
                            "platform" => "LinkedIn",
                            "handle" => "logan-white-65b14b126"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Software Developer",
                    "PersonalDescription" => "",
                    "YearsAtCompany" => 6,
                    "YearsInRole" => 6,
                    "YearsExperience" => 6
                ],
                [
                    "PersonId" => 2099564,
                    "Name" => "Yulia Nikonova",
                    "FirstName" => "Yulia",
                    "LastName" => "Nikonova",
                    "Phones" => [],
                    "Emails" => [
                        "yulia.nikonova@kompli-global.com",
                        "yulia@timlangley.me.uk"
                    ],
                    "Email" => "",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/yulia-nikonova-2551a2105",
                            "platform" => "LinkedIn",
                            "handle" => "yulia-nikonova-2551a2105"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Data Scientist",
                    "PersonalDescription" => "",
                    "YearsAtCompany" => 4,
                    "YearsInRole" => 4,
                    "YearsExperience" => 8
                ],
                [
                    "PersonId" => 2099563,
                    "Name" => "Ellice Eadie",
                    "FirstName" => "Ellice",
                    "LastName" => "Eadie",
                    "Phones" => [],
                    "Emails" => [
                        "ellice.eadie@kompli-global.com",
                        "ellice@timlangley.me.uk"
                    ],
                    "Email" => "",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/ellice-eadie-9a010b160",
                            "platform" => "LinkedIn",
                            "handle" => "ellice-eadie-9a010b160"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Content Creator",
                    "PersonalDescription" => "",
                    "YearsAtCompany" => 2,
                    "YearsInRole" => 2,
                    "YearsExperience" => 7
                ],
                [
                    "PersonId" => 3385,
                    "Name" => "George Meadows",
                    "FirstName" => "George",
                    "LastName" => "Meadows",
                    "Phones" => [],
                    "Emails" => [
                        "george.meadows@canddi.com",
                        "george@canddi.com"
                    ],
                    "Email" => "george.meadows@canddi.com",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/george-meadows-7b5190189",
                            "platform" => "LinkedIn",
                            "handle" => "george-meadows-7b5190189"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Software Developer",
                    "PersonalDescription" => "I'm a self taught software developer with hands on, real world experience. I really value my career, and the industry I deal with.",
                    "YearsAtCompany" => 3,
                    "YearsInRole" => 3,
                    "YearsExperience" => 3
                ],
                [
                    "PersonId" => 2742021,
                    "Name" => "Malcolm Smith",
                    "FirstName" => "Malcolm",
                    "LastName" => "Smith",
                    "Phones" => [],
                    "Emails" => [
                        "malcolm.smith@360globalnet.com",
                        "malcolm@360globalnet.com"
                    ],
                    "Email" => "",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/malcolm-smith-4414202",
                            "platform" => "LinkedIn",
                            "handle" => "malcolm-smith-4414202"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "Chairman Of The Board",
                    "PersonalDescription" => "",
                    "YearsAtCompany" => 5,
                    "YearsInRole" => 0,
                    "YearsExperience" => 0
                ],
                [
                    "PersonId" => 1210970,
                    "Name" => "Chris Glover",
                    "FirstName" => "Chris",
                    "LastName" => "Glover",
                    "Phones" => [],
                    "Emails" => [
                        "chris@cheshireeast.gov.uk",
                        "chris@muir.org.uk"
                    ],
                    "Email" => "",
                    "SocialMedia" => [
                        "LinkedIn" => [
                            "url" => "linkedin.com/in/chris-glover-6b2663160",
                            "platform" => "LinkedIn",
                            "handle" => "chris-glover-6b2663160"
                        ]
                    ],
                    "LegalRole" => "",
                    "JobRole" => "",
                    "PersonalDescription" => "",
                    "YearsAtCompany" => 0,
                    "YearsInRole" => 0,
                    "YearsExperience" => 0
                ]
            ]
        ];
    }

    public function testGetters()
    {
        $innerCompany = new Company($this->_getTestData());

        $this->assertEquals(
            $this->_getTestData()['Location']['City'],
            $innerCompany->getCity()
        );
        $this->assertEquals(
            $this->_getTestData()['Legal']['LegalName'],
            $innerCompany->getCompanyName()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['CountryCode'],
            $innerCompany->getCountryCode()
        );
        $this->assertEquals(
            $this->_getTestData()['Description'],
            $innerCompany->getDescription()
        );
        $this->assertEquals(
            $this->_getTestData()['Email'],
            $innerCompany->getEmail()
        );
        $this->assertEquals(
            $this->_getTestData()['EmailAddresses'],
            $innerCompany->getEmailAddresses()
        );
        $this->assertEquals(
            $this->_getTestData()['EmployeeRange'],
            $innerCompany->getEmployeeRange()
        );
        $this->assertEquals(
            $this->_getTestData()['Heading'],
            $innerCompany->getHeading()
        );
        $this->assertEquals(
            $this->_getTestData()['Hostname'],
            $innerCompany->getHostname()
        );
        $this->assertEquals(
            $this->_getTestData()['Keywords'],
            $innerCompany->getKeywords()
        );
        $this->assertInstanceOf(
            Legal::class,
            $innerCompany->getLegal()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['Lat'],
            $innerCompany->getLat()
        );
        $this->assertInstanceOf(
            Location::class,
            $innerCompany->getLocation()
        );
        $this->assertEquals(
            $this->_getTestData()['Logo'],
            $innerCompany->getLogo()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['Lng'],
            $innerCompany->getLon()
        );
        $this->assertEquals(
            $this->_getTestData()['Phone'],
            $innerCompany->getPhone()
        );
        $this->assertEquals(
            $this->_getTestData()['PhoneNumbers'],
            $innerCompany->getPhoneNumbers()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['PostCode'],
            $innerCompany->getPostCode()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['Region'],
            $innerCompany->getRegion()
        );
        $this->assertEquals(
            $this->_getTestData()['Sectors'],
            $innerCompany->getSectors()
        );
        $this->assertEquals(
            $this->_getTestData()['SIC'],
            $innerCompany->getSIC()
        );
        $this->assertEquals(
            $this->_getTestData()['VAT'],
            $innerCompany->getVAT()
        );
        $this->assertEquals(
            $this->_getTestData()['WebsiteURL'],
            $innerCompany->getWebsiteURL()
        );

        $arrPeople = $innerCompany->getPeople();
        $this->assertEquals(
            count($this->_getTestData()[Company::KEY_PEOPLE]),
            count($arrPeople)
        );
        foreach($arrPeople as $mdlPerson) {
            $this->assertInstanceOf(
                Person::class,
                $mdlPerson
            );
        }

        $arrEmailPlatforms = $innerCompany->getCompanyEmailPlatforms();
        $this->assertEquals(
            count($this->_getTestData()[Company::KEY_COMPANYEMAILPLATFORMS]),
            count($arrEmailPlatforms)
        );
        foreach($arrEmailPlatforms as $mdlEmailPlatform) {
            $this->assertInstanceOf(
                EmailPlatform::class,
                $mdlEmailPlatform
            );
        }

        $arrSocialMedia = $innerCompany->getSocialMedia();
        $this->assertEquals(
            5,
            count($arrSocialMedia)
        );
        foreach($arrSocialMedia as $mdlSocial) {
            $this->assertInstanceOf(
                SocialMedia::class,
                $mdlSocial
            );
        }
    }

    public function testCompanyNameWithNoLegal()
    {
        $arrData = [
            "CompanyName" => "CANDDi (Campaign and Digital Intelligence Limited)",
        ];
        $innerCompany = new Company($arrData);
        $this->assertEquals(
            $arrData['CompanyName'],
            $innerCompany->getCompanyName()
        );
    }
}
