<?php
/**
 * @author Matty Glancy
 **/
namespace CanddiAi\Lookup;
class PersonTest
    extends \CanddiAi\TestCase
{
    public function testLookupEmail()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strEmail = 'tim@canddi.com';
        $strAccountURL = 'anAccount';
        $strCallbackUrl = 'callbackurl';
        $arrCallbackOptions = [123, 456];
        $guidContactId = md5(1);
        $strURL             = sprintf(Person::c_URL_Person, $strEmail);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => $strCallbackUrl,
            'cboptions'     => str_replace('"', '\\"', json_encode($arrCallbackOptions,JSON_FORCE_OBJECT))
        ];
        $companyInstance = Person::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn('[]')
            ->mock();
        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();
        Person::injectGuzzle($mockGuzzle);
        $actualPersonResponse = $companyInstance->lookupEmail($strEmail, $strAccountURL, $guidContactId, $strCallbackUrl, $arrCallbackOptions);
        $expectedPersonResponse = new Response\Person([]);
        $this->assertEquals($expectedPersonResponse, $actualPersonResponse);
    }
    public function testLookups_Fail()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strCallbackUrl = 'callbackurl';
        $arrCallbackOptions = [123, 456];
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => $strCallbackUrl,
            'cboptions'     => str_replace('"', '\\"', json_encode($arrCallbackOptions,JSON_FORCE_OBJECT))
        ];

        $strEmail = 'tim@canddi.com';

        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(400)
            ->shouldReceive('getReasonPhrase')
            ->once()
            ->withNoArgs()
            ->andReturn('Bad Request')
            ->mock();

        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                \Mockery::type('string'),
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();

        Person::injectGuzzle($mockGuzzle);
        $lookupCompany = Person::getInstance($strBaseUri, $strAccessToken);

        $returnedException = null;

        try {
            $lookupCompany->lookupEmail($strEmail, $strAccountURL, $guidContactId, $strCallbackUrl, $arrCallbackOptions);
        } catch(\Exception $e) {
            $returnedException = $e;
        }

        $this->assertEquals(
            "Service:Person:Email returned error for ($strEmail) ".
            " on Account ($strAccountURL), Contact ($guidContactId) ".
            "400-Bad Request",
            $returnedException->getMessage()
        );
    }
    public function testLookupLinkedIn_Empty()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strUsername = 'linkedinName';
        $strAccountURL = 'anAccount';
        $strCBUrl = 'url';
        $guidContactId = md5(1);
        $strURL             = sprintf(Person::c_URL_LinkedIn, $strUsername);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => $strCBUrl,
            'cboptions'     => '{}'
        ];
        $companyInstance = Person::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn('[]')
            ->mock();
        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();
        Person::injectGuzzle($mockGuzzle);

        $actualPersonResponse = $companyInstance->lookupLinkedIn(
            $strUsername,
            $strAccountURL,
            $guidContactId,
            $strCBUrl
        );
        $expectedPersonResponse = new Response\Person([]);
        $this->assertEquals($expectedPersonResponse, $actualPersonResponse);
    }
    public function testLookupLinkedIn_HasData()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strUsername = 'linkedinName';
        $strAccountURL = 'anAccount';
        $strCBUrl = 'url';
        $guidContactId = md5(1);
        $strURL             = sprintf(Person::c_URL_LinkedIn, $strUsername);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => $strCBUrl,
            'cboptions'     => '{}'
        ];
        $companyInstance = Person::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn("{
              \"Person\": {
                  \"Name\": {
                      \"FirstName\": \"Tim\",
                      \"LastName\": \"Langley\",
                      \"MiddleName\": [
                          \"EDWARD\"
                      ]
                  },
                  \"Bio\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the team.Specialties: Innovation, Creativity and EntrepreneurshipEarly stage finance and Business AnalysisExpert knowledge of Javascript (Backbone), PHP (Zend), No-SQL and Big Data\",
                  \"Gender\": \"Male\",
                  \"PhoneNumbers\": [],
                  \"SocialMedia\": {
                      \"Twitter\": {
                          \"url\": \"twitter.com/timlangley\",
                          \"platform\": \"Twitter\",
                          \"handle\": \"timlangley\"
                      },
                      \"LinkedIn\": {
                          \"url\": \"linkedin.com/in/langleytim\",
                          \"platform\": \"LinkedIn\",
                          \"handle\": \"langleytim\"
                      }
                  },
                  \"Location\": {
                      \"Lat\": 53.4795,
                      \"Lng\": -2.2451,
                      \"Line1\": \"\",
                      \"Line2\": \"\",
                      \"PostCode\": \"\",
                      \"City\": \"Manchester\",
                      \"CountryCode\": \"GB\",
                      \"Region\": \"North West England\"
                  },
                  \"BirthDate\": \"1978-03\",
                  \"EmailAddresses\": [
                      \"tim.langley@kompli-global.com\",
                      \"tim@canddi.com\",
                      \"tim@timlangley.me.uk\"
                  ],
                  \"Email\": \"\"
              },
              \"JobSummary\": [
                  {
                      \"CompanyHostname\": \"canddi.com\",
                      \"CompanyName\": \"Campaign And Digital Intelligence\",
                      \"LegalRole\": \"Director\",
                      \"JobRole\": \"CEO and Founder\",
                      \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                      \"YearsAtCompany\": 13,
                      \"YearsInRole\": 13,
                      \"YearsExperience\": 25
                  },
                  {
                      \"CompanyHostname\": \"go-email.co.uk\",
                      \"CompanyName\": \"Go Email Ltd\",
                      \"LegalRole\": \"Director\",
                      \"JobRole\": \"CTO / Co-Founder / Overworked Geek :)\",
                      \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                      \"YearsAtCompany\": 2,
                      \"YearsInRole\": 2,
                      \"YearsExperience\": 25
                  },
                  {
                      \"CompanyHostname\": \"kompli-global.com\",
                      \"CompanyName\": \"Kompli Holdings Plc\",
                      \"LegalRole\": \"Director\",
                      \"JobRole\": \"CTO\",
                      \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                      \"YearsAtCompany\": 6,
                      \"YearsInRole\": 6,
                      \"YearsExperience\": 25
                  }
              ],
              \"Hostname\": \"canddi.com\",
              \"Company\": {
                  \"Hostname\": \"canddi.com\",
                  \"VAT\": \"GB107133945\",
                  \"Email\": \"hello@canddi.com\",
                  \"Legal\": {
                      \"LegalName\": \"CAMPAIGN AND DIGITAL INTELLIGENCE\",
                      \"CRN\": \"07066939\",
                      \"IncorporationDate\": \"2009-11-05\",
                      \"CompanyType\": \"private limited company\",
                      \"RegisteredLocation\": {
                          \"Lat\": 53.4819,
                          \"Lng\": -2.2331,
                          \"Line1\": \"47 Newton Street\",
                          \"Line2\": \"City Centre\",
                          \"PostCode\": \"M1 1FT\",
                          \"City\": \"Manchester\",
                          \"CountryCode\": \"GB\",
                          \"Region\": \"ENG\"
                      }
                  },
                  \"Phone\": \"0161 414 1080\",
                  \"Heading\": \"Lets turn yourwebsite visitors intocustomers\",
                  \"Sectors\": [
                      \"Marketing and Advertising\"
                  ],
                  \"Location\": {
                      \"Lat\": 53.4819,
                      \"Lng\": -2.2332,
                      \"Line1\": \"47 Newton St; Manchester\",
                      \"Line2\": \"Piccadilly\",
                      \"PostCode\": \"M1 1FT\",
                      \"City\": \"Manchester\",
                      \"CountryCode\": \"GB\",
                      \"Region\": \"England\"
                  },
                  \"WebsiteURL\": [
                      \"canddi.com\"
                  ],
                  \"CompanyName\": \"CANDDi (Campaign and Digital Intelligence Limited)\",
                  \"Description\": \"Campaign and Digital Intelligence: the Prospect Analytics Pioneer. CANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI. CANDDi helps you to: - Close Deals: Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking - Nurture Leads: Identify the hot prospects and the nearly customers and automatically nurture them towards a sale - Optimise Marketing: Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads\",
                  \"SocialMedia\": {
                      \"Twitter\": {
                          \"url\": \"twitter.com/canddi\",
                          \"platform\": \"Twitter\",
                          \"handle\": \"canddi\"
                      },
                      \"Youtube\": {
                          \"url\": \"youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g\",
                          \"platform\": \"Youtube\",
                          \"handle\": \"UCU7aljz8YC9IdPfxuxLY39g\"
                      },
                      \"Facebook\": {
                          \"url\": \"facebook.com/thisiscanddi\",
                          \"platform\": \"Facebook\",
                          \"handle\": \"thisiscanddi\"
                      },
                      \"LinkedIn\": {
                          \"url\": \"linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-\",
                          \"platform\": \"LinkedIn\",
                          \"handle\": \"canddi-campaign-and-digital-intelligence-limited-\"
                      },
                      \"Pinterest\": {
                          \"url\": \"pinterest.com/canddi\",
                          \"platform\": \"Pinterest\",
                          \"handle\": \"canddi\"
                      }
                  },
                  \"PhoneNumbers\": [
                      \"+441614141080\"
                  ],
                  \"EmployeeRange\": \"11-50\",
                  \"EmailAddresses\": [
                      \"hello@canddi.com\",
                      \"help@canddi.com\",
                      \"privacy@canddi.com\",
                      \"dpo@canddi.com\",
                      \"jobs@canddi.com\"
                  ],
                  \"DateDomainLastEdited\": \"2020-09-30\",
                  \"DateDomainRegistered\": \"2009-09-29\",
                  \"CompanyEmailPlatforms\": [
                      {
                          \"MX\": \"*google.com\",
                          \"Type\": \"Gmail\",
                          \"Priority\": 1
                      },
                      {
                          \"MX\": \"*googlemail.com\",
                          \"Type\": \"Gmail\",
                          \"Priority\": 10
                      }
                  ]
              }
          }")
            ->mock();
        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();
        Person::injectGuzzle($mockGuzzle);

        $actualPersonResponse = $companyInstance->lookupLinkedIn(
            $strUsername,
            $strAccountURL,
            $guidContactId,
            $strCBUrl
        );
        $expectedPersonResponse = new Response\Person(json_decode("{
          \"Person\": {
              \"Name\": {
                  \"FirstName\": \"Tim\",
                  \"LastName\": \"Langley\",
                  \"MiddleName\": [
                      \"EDWARD\"
                  ]
              },
              \"Bio\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the team.Specialties: Innovation, Creativity and EntrepreneurshipEarly stage finance and Business AnalysisExpert knowledge of Javascript (Backbone), PHP (Zend), No-SQL and Big Data\",
              \"Gender\": \"Male\",
              \"PhoneNumbers\": [],
              \"SocialMedia\": {
                  \"Twitter\": {
                      \"url\": \"twitter.com/timlangley\",
                      \"platform\": \"Twitter\",
                      \"handle\": \"timlangley\"
                  },
                  \"LinkedIn\": {
                      \"url\": \"linkedin.com/in/langleytim\",
                      \"platform\": \"LinkedIn\",
                      \"handle\": \"langleytim\"
                  }
              },
              \"Location\": {
                  \"Lat\": 53.4795,
                  \"Lng\": -2.2451,
                  \"Line1\": \"\",
                  \"Line2\": \"\",
                  \"PostCode\": \"\",
                  \"City\": \"Manchester\",
                  \"CountryCode\": \"GB\",
                  \"Region\": \"North West England\"
              },
              \"BirthDate\": \"1978-03\",
              \"EmailAddresses\": [
                  \"tim.langley@kompli-global.com\",
                  \"tim@canddi.com\",
                  \"tim@timlangley.me.uk\"
              ],
              \"Email\": \"\"
          },
          \"JobSummary\": [
              {
                  \"CompanyHostname\": \"canddi.com\",
                  \"CompanyName\": \"Campaign And Digital Intelligence\",
                  \"LegalRole\": \"Director\",
                  \"JobRole\": \"CEO and Founder\",
                  \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                  \"YearsAtCompany\": 13,
                  \"YearsInRole\": 13,
                  \"YearsExperience\": 25
              },
              {
                  \"CompanyHostname\": \"go-email.co.uk\",
                  \"CompanyName\": \"Go Email Ltd\",
                  \"LegalRole\": \"Director\",
                  \"JobRole\": \"CTO / Co-Founder / Overworked Geek :)\",
                  \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                  \"YearsAtCompany\": 2,
                  \"YearsInRole\": 2,
                  \"YearsExperience\": 25
              },
              {
                  \"CompanyHostname\": \"kompli-global.com\",
                  \"CompanyName\": \"Kompli Holdings Plc\",
                  \"LegalRole\": \"Director\",
                  \"JobRole\": \"CTO\",
                  \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                  \"YearsAtCompany\": 6,
                  \"YearsInRole\": 6,
                  \"YearsExperience\": 25
              }
          ],
          \"Hostname\": \"canddi.com\",
          \"Company\": {
              \"Hostname\": \"canddi.com\",
              \"VAT\": \"GB107133945\",
              \"Email\": \"hello@canddi.com\",
              \"Legal\": {
                  \"LegalName\": \"CAMPAIGN AND DIGITAL INTELLIGENCE\",
                  \"CRN\": \"07066939\",
                  \"IncorporationDate\": \"2009-11-05\",
                  \"CompanyType\": \"private limited company\",
                  \"RegisteredLocation\": {
                      \"Lat\": 53.4819,
                      \"Lng\": -2.2331,
                      \"Line1\": \"47 Newton Street\",
                      \"Line2\": \"City Centre\",
                      \"PostCode\": \"M1 1FT\",
                      \"City\": \"Manchester\",
                      \"CountryCode\": \"GB\",
                      \"Region\": \"ENG\"
                  }
              },
              \"Phone\": \"0161 414 1080\",
              \"Heading\": \"Lets turn yourwebsite visitors intocustomers\",
              \"Sectors\": [
                  \"Marketing and Advertising\"
              ],
              \"Location\": {
                  \"Lat\": 53.4819,
                  \"Lng\": -2.2332,
                  \"Line1\": \"47 Newton St; Manchester\",
                  \"Line2\": \"Piccadilly\",
                  \"PostCode\": \"M1 1FT\",
                  \"City\": \"Manchester\",
                  \"CountryCode\": \"GB\",
                  \"Region\": \"England\"
              },
              \"WebsiteURL\": [
                  \"canddi.com\"
              ],
              \"CompanyName\": \"CANDDi (Campaign and Digital Intelligence Limited)\",
              \"Description\": \"Campaign and Digital Intelligence: the Prospect Analytics Pioneer. CANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI. CANDDi helps you to: - Close Deals: Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking - Nurture Leads: Identify the hot prospects and the nearly customers and automatically nurture them towards a sale - Optimise Marketing: Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads\",
              \"SocialMedia\": {
                  \"Twitter\": {
                      \"url\": \"twitter.com/canddi\",
                      \"platform\": \"Twitter\",
                      \"handle\": \"canddi\"
                  },
                  \"Youtube\": {
                      \"url\": \"youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g\",
                      \"platform\": \"Youtube\",
                      \"handle\": \"UCU7aljz8YC9IdPfxuxLY39g\"
                  },
                  \"Facebook\": {
                      \"url\": \"facebook.com/thisiscanddi\",
                      \"platform\": \"Facebook\",
                      \"handle\": \"thisiscanddi\"
                  },
                  \"LinkedIn\": {
                      \"url\": \"linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-\",
                      \"platform\": \"LinkedIn\",
                      \"handle\": \"canddi-campaign-and-digital-intelligence-limited-\"
                  },
                  \"Pinterest\": {
                      \"url\": \"pinterest.com/canddi\",
                      \"platform\": \"Pinterest\",
                      \"handle\": \"canddi\"
                  }
              },
              \"PhoneNumbers\": [
                  \"+441614141080\"
              ],
              \"EmployeeRange\": \"11-50\",
              \"EmailAddresses\": [
                  \"hello@canddi.com\",
                  \"help@canddi.com\",
                  \"privacy@canddi.com\",
                  \"dpo@canddi.com\",
                  \"jobs@canddi.com\"
              ],
              \"DateDomainLastEdited\": \"2020-09-30\",
              \"DateDomainRegistered\": \"2009-09-29\",
              \"CompanyEmailPlatforms\": [
                  {
                      \"MX\": \"*google.com\",
                      \"Type\": \"Gmail\",
                      \"Priority\": 1
                  },
                  {
                      \"MX\": \"*googlemail.com\",
                      \"Type\": \"Gmail\",
                      \"Priority\": 10
                  }
              ]
          }
      }", true));
        $this->assertEquals($expectedPersonResponse, $actualPersonResponse);
        $this->assertInstanceOf(Response\Company\Company::class, $actualPersonResponse->getCompany());
    }
    public function testLookupEmail_NoData()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strEmailAddress = 'matt@canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Person::c_URL_Person, $strEmailAddress);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => null,
            'cboptions'     => '{}'
        ];
        $personInstance = Person::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(201)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn("{
                \"Reprocess\" : true
            }")
            ->mock();
        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();
        Person::injectGuzzle($mockGuzzle);
        $actualPersonResponse = $personInstance->lookupEmail($strEmailAddress, $strAccountURL, $guidContactId);
        $expectedPersonResponse = new Response\Person([
            'Reprocess' => true
        ]);
        $this->assertEquals($expectedPersonResponse, $actualPersonResponse);
    }
    public function testLookupEmail_CompanyOnly()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strEmailAddress = 'matt@canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Person::c_URL_Person, $strEmailAddress);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => null,
            'cboptions'     => '{}'
        ];
        $personInstance = Person::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn("{
                \"Hostname\": \"orckid.co.uk\",
                \"Type\": 0,
                \"Company\": {
                    \"VAT\": \"GB107133945\",
                    \"Email\": \"hello@canddi.com\",
                    \"Legal\": {
                      \"LegalName\": \"CAMPAIGN AND DIGITAL INTELLIGENCE\",
                      \"CRN\": \"07066939\",
                      \"IncorporationDate\": \"2009-11-05\",
                      \"CompanyType\": \"private limited company\",
                      \"RegisteredLocation\": {
                        \"Lat\": 53.4819,
                        \"Lng\": -2.2331,
                        \"Line1\": \"47 Newton Street\",
                        \"Line2\": \"City Centre\",
                        \"PostCode\": \"M1 1FT\",
                        \"City\": \"Manchester\",
                        \"CountryCode\": \"GB\",
                        \"Region\": \"ENG\"
                      }
                    },
                    \"Phone\": \"0161 414 1080\",
                    \"Heading\": \"Lets turn yourwebsite visitors intocustomers\",
                    \"Sectors\": [
                      \"Marketing and Advertising\"
                    ],
                    \"Location\": {
                      \"Lat\": 53.4819,
                      \"Lng\": -2.2332,
                      \"Line1\": \"47 Newton St; Manchester\",
                      \"Line2\": \"Piccadilly\",
                      \"PostCode\": \"M1 1FT\",
                      \"City\": \"Manchester\",
                      \"CountryCode\": \"GB\",
                      \"Region\": \"England\"
                    },
                    \"WebsiteURL\": [
                      \"canddi.com\"
                    ],
                    \"CompanyName\": \"CANDDi (Campaign and Digital Intelligence Limited)\",
                    \"Description\": \"Campaign and Digital Intelligence: the Prospect Analytics Pioneer. CANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI. CANDDi helps you to: - Close Deals: Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking - Nurture Leads: Identify the hot prospects and the nearly customers and automatically nurture them towards a sale - Optimise Marketing: Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads\",
                    \"SocialMedia\": {
                      \"Twitter\": {
                        \"url\": \"twitter.com/canddi\",
                        \"platform\": \"Twitter\",
                        \"handle\": \"canddi\"
                      },
                      \"Youtube\": {
                        \"url\": \"youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g\",
                        \"platform\": \"Youtube\",
                        \"handle\": \"UCU7aljz8YC9IdPfxuxLY39g\"
                      },
                      \"Facebook\": {
                        \"url\": \"facebook.com/thisiscanddi\",
                        \"platform\": \"Facebook\",
                        \"handle\": \"thisiscanddi\"
                      },
                      \"LinkedIn\": {
                        \"url\": \"linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-\",
                        \"platform\": \"LinkedIn\",
                        \"handle\": \"canddi-campaign-and-digital-intelligence-limited-\"
                      },
                      \"Pinterest\": {
                        \"url\": \"pinterest.com/canddi\",
                        \"platform\": \"Pinterest\",
                        \"handle\": \"canddi\"
                      }
                    },
                    \"PhoneNumbers\": [
                      \"+441614141080\"
                    ],
                    \"EmployeeRange\": \"11-50\",
                    \"EmailAddresses\": [
                      \"hello@canddi.com\",
                      \"help@canddi.com\",
                      \"privacy@canddi.com\",
                      \"dpo@canddi.com\",
                      \"jobs@canddi.com\"
                    ],
                    \"DateDomainLastEdited\": \"2020-09-30\",
                    \"DateDomainRegistered\": \"2009-09-29\",
                    \"CompanyEmailPlatforms\": [
                      {
                        \"MX\": \"*google.com\",
                        \"Type\": \"Gmail\",
                        \"Priority\": 1
                      },
                      {
                        \"MX\": \"*googlemail.com\",
                        \"Type\": \"Gmail\",
                        \"Priority\": 10
                      }
                    ],
                    \"People\": [
                      {
                        \"PersonId\": 2099080,
                        \"Name\": \"Tim Langley\",
                        \"FirstName\": \"Tim\",
                        \"LastName\": \"Langley\",
                        \"Phones\": [],
                        \"Emails\": [
                          \"tim.langley@kompli-global.com\",
                          \"tim@canddi.com\",
                          \"tim@timlangley.me.uk\"
                        ],
                        \"Email\": \"tim@canddi.com\",
                        \"SocialMedia\": {
                          \"Twitter\": {
                            \"url\": \"twitter.com/timlangley\",
                            \"platform\": \"Twitter\",
                            \"handle\": \"timlangley\"
                          },
                          \"LinkedIn\": {
                            \"url\": \"linkedin.com/in/langleytim\",
                            \"platform\": \"LinkedIn\",
                            \"handle\": \"langleytim\"
                          }
                        },
                        \"LegalRole\": \"Director\",
                        \"JobRole\": \"CEO and Founder\",
                        \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                        \"YearsAtCompany\": 13,
                        \"YearsInRole\": 13,
                        \"YearsExperience\": 25
                      },
                      {
                        \"PersonId\": 2099561,
                        \"Name\": \"Claire Garside\",
                        \"FirstName\": \"Claire\",
                        \"LastName\": \"Garside\",
                        \"Phones\": [],
                        \"Emails\": [
                          \"claire@canddi.com\"
                        ],
                        \"Email\": \"claire@canddi.com\",
                        \"SocialMedia\": {
                          \"LinkedIn\": {
                            \"url\": \"linkedin.com/in/claire-garside-3b0a16194\",
                            \"platform\": \"LinkedIn\",
                            \"handle\": \"claire-garside-3b0a16194\"
                          }
                        },
                        \"LegalRole\": \"\",
                        \"JobRole\": \"Senior Sales Consultant\",
                        \"PersonalDescription\": \"If you want to know exactly WHO has been visiting your website and what they did when they got there, then don't hesitate to contact me\",
                        \"YearsAtCompany\": 3,
                        \"YearsInRole\": 3,
                        \"YearsExperience\": 3
                      }
                    ],
                    \"Hostname\": \"canddi.com\"
                  },
                  \"JobSummary\": [
                    {
                      \"CompanyHostname\": \"angloscientific.com\",
                      \"CompanyName\": \"\",
                      \"LegalRole\": \"\",
                      \"JobRole\": \"MBA intern Venture Capitalist\",
                      \"NormalJobRole\": \"mba intern venture capitalist\",
                      \"PersonalDescription\": \"\",
                      \"YearsAtCompany\": 15,
                      \"YearsInRole\": 0,
                      \"YearsExperience\": 0
                    },
                    {
                      \"CompanyHostname\": \"canddi.com\",
                      \"CompanyName\": \"\",
                      \"LegalRole\": \"Director\",
                      \"JobRole\": \"CEO and Founder\",
                      \"NormalJobRole\": \"ceo\",
                      \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                      \"YearsAtCompany\": 13,
                      \"YearsInRole\": 13,
                      \"YearsExperience\": 25
                    }
                  ]
              }")
            ->mock();
        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();
        Person::injectGuzzle($mockGuzzle);
        $actualPersonResponse = $personInstance->lookupEmail($strEmailAddress, $strAccountURL, $guidContactId);
        $expectedPersonResponse = new Response\Person(json_decode("
        {
            \"Hostname\": \"orckid.co.uk\",
            \"Type\": 0,
            \"Company\": {
                \"VAT\": \"GB107133945\",
                \"Email\": \"hello@canddi.com\",
                \"Legal\": {
                  \"LegalName\": \"CAMPAIGN AND DIGITAL INTELLIGENCE\",
                  \"CRN\": \"07066939\",
                  \"IncorporationDate\": \"2009-11-05\",
                  \"CompanyType\": \"private limited company\",
                  \"RegisteredLocation\": {
                    \"Lat\": 53.4819,
                    \"Lng\": -2.2331,
                    \"Line1\": \"47 Newton Street\",
                    \"Line2\": \"City Centre\",
                    \"PostCode\": \"M1 1FT\",
                    \"City\": \"Manchester\",
                    \"CountryCode\": \"GB\",
                    \"Region\": \"ENG\"
                  }
                },
                \"Phone\": \"0161 414 1080\",
                \"Heading\": \"Lets turn yourwebsite visitors intocustomers\",
                \"Sectors\": [
                  \"Marketing and Advertising\"
                ],
                \"Location\": {
                  \"Lat\": 53.4819,
                  \"Lng\": -2.2332,
                  \"Line1\": \"47 Newton St; Manchester\",
                  \"Line2\": \"Piccadilly\",
                  \"PostCode\": \"M1 1FT\",
                  \"City\": \"Manchester\",
                  \"CountryCode\": \"GB\",
                  \"Region\": \"England\"
                },
                \"WebsiteURL\": [
                  \"canddi.com\"
                ],
                \"CompanyName\": \"CANDDi (Campaign and Digital Intelligence Limited)\",
                \"Description\": \"Campaign and Digital Intelligence: the Prospect Analytics Pioneer. CANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI. CANDDi helps you to: - Close Deals: Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking - Nurture Leads: Identify the hot prospects and the nearly customers and automatically nurture them towards a sale - Optimise Marketing: Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads\",
                \"SocialMedia\": {
                  \"Twitter\": {
                    \"url\": \"twitter.com/canddi\",
                    \"platform\": \"Twitter\",
                    \"handle\": \"canddi\"
                  },
                  \"Youtube\": {
                    \"url\": \"youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g\",
                    \"platform\": \"Youtube\",
                    \"handle\": \"UCU7aljz8YC9IdPfxuxLY39g\"
                  },
                  \"Facebook\": {
                    \"url\": \"facebook.com/thisiscanddi\",
                    \"platform\": \"Facebook\",
                    \"handle\": \"thisiscanddi\"
                  },
                  \"LinkedIn\": {
                    \"url\": \"linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-\",
                    \"platform\": \"LinkedIn\",
                    \"handle\": \"canddi-campaign-and-digital-intelligence-limited-\"
                  },
                  \"Pinterest\": {
                    \"url\": \"pinterest.com/canddi\",
                    \"platform\": \"Pinterest\",
                    \"handle\": \"canddi\"
                  }
                },
                \"PhoneNumbers\": [
                  \"+441614141080\"
                ],
                \"EmployeeRange\": \"11-50\",
                \"EmailAddresses\": [
                  \"hello@canddi.com\",
                  \"help@canddi.com\",
                  \"privacy@canddi.com\",
                  \"dpo@canddi.com\",
                  \"jobs@canddi.com\"
                ],
                \"DateDomainLastEdited\": \"2020-09-30\",
                \"DateDomainRegistered\": \"2009-09-29\",
                \"CompanyEmailPlatforms\": [
                  {
                    \"MX\": \"*google.com\",
                    \"Type\": \"Gmail\",
                    \"Priority\": 1
                  },
                  {
                    \"MX\": \"*googlemail.com\",
                    \"Type\": \"Gmail\",
                    \"Priority\": 10
                  }
                ],
                \"People\": [
                  {
                    \"PersonId\": 2099080,
                    \"Name\": \"Tim Langley\",
                    \"FirstName\": \"Tim\",
                    \"LastName\": \"Langley\",
                    \"Phones\": [],
                    \"Emails\": [
                      \"tim.langley@kompli-global.com\",
                      \"tim@canddi.com\",
                      \"tim@timlangley.me.uk\"
                    ],
                    \"Email\": \"tim@canddi.com\",
                    \"SocialMedia\": {
                      \"Twitter\": {
                        \"url\": \"twitter.com/timlangley\",
                        \"platform\": \"Twitter\",
                        \"handle\": \"timlangley\"
                      },
                      \"LinkedIn\": {
                        \"url\": \"linkedin.com/in/langleytim\",
                        \"platform\": \"LinkedIn\",
                        \"handle\": \"langleytim\"
                      }
                    },
                    \"LegalRole\": \"Director\",
                    \"JobRole\": \"CEO and Founder\",
                    \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                    \"YearsAtCompany\": 13,
                    \"YearsInRole\": 13,
                    \"YearsExperience\": 25
                  },
                  {
                    \"PersonId\": 2099561,
                    \"Name\": \"Claire Garside\",
                    \"FirstName\": \"Claire\",
                    \"LastName\": \"Garside\",
                    \"Phones\": [],
                    \"Emails\": [
                      \"claire@canddi.com\"
                    ],
                    \"Email\": \"claire@canddi.com\",
                    \"SocialMedia\": {
                      \"LinkedIn\": {
                        \"url\": \"linkedin.com/in/claire-garside-3b0a16194\",
                        \"platform\": \"LinkedIn\",
                        \"handle\": \"claire-garside-3b0a16194\"
                      }
                    },
                    \"LegalRole\": \"\",
                    \"JobRole\": \"Senior Sales Consultant\",
                    \"PersonalDescription\": \"If you want to know exactly WHO has been visiting your website and what they did when they got there, then don't hesitate to contact me\",
                    \"YearsAtCompany\": 3,
                    \"YearsInRole\": 3,
                    \"YearsExperience\": 3
                  }
                ],
                \"Hostname\": \"canddi.com\"
              },
              \"JobSummary\": [
                {
                  \"CompanyHostname\": \"angloscientific.com\",
                  \"CompanyName\": \"\",
                  \"LegalRole\": \"\",
                  \"JobRole\": \"MBA intern Venture Capitalist\",
                  \"NormalJobRole\": \"mba intern venture capitalist\",
                  \"PersonalDescription\": \"\",
                  \"YearsAtCompany\": 15,
                  \"YearsInRole\": 0,
                  \"YearsExperience\": 0
                },
                {
                  \"CompanyHostname\": \"canddi.com\",
                  \"CompanyName\": \"\",
                  \"LegalRole\": \"Director\",
                  \"JobRole\": \"CEO and Founder\",
                  \"NormalJobRole\": \"ceo\",
                  \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                  \"YearsAtCompany\": 13,
                  \"YearsInRole\": 13,
                  \"YearsExperience\": 25
                }
              ]
          }
        ", true));
        $this->assertEquals($expectedPersonResponse, $actualPersonResponse);
        $modelJobSummary = $actualPersonResponse->getJobSummary();
        $this->assertInstanceOf(Response\Item\JobSummary::class, $modelJobSummary);
        $this->assertEquals('CEO and Founder', $modelJobSummary->getJobRole());
        $this->assertEquals('ceo', $modelJobSummary->getNormalJobRole());
    }
    public function testLookupEmail_PersonAndCompany()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strEmailAddress = 'matt@canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Person::c_URL_Person, $strEmailAddress);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => null,
            'cboptions'     => '{}'
        ];
        $personInstance = Person::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn("{
                \"Hostname\": \"orckid.co.uk\",
                \"Type\": 0,
                \"Company\": {
                  \"VAT\": \"GB107133945\",
                  \"Email\": \"hello@canddi.com\",
                  \"Legal\": {
                    \"LegalName\": \"CAMPAIGN AND DIGITAL INTELLIGENCE\",
                    \"CRN\": \"07066939\",
                    \"IncorporationDate\": \"2009-11-05\",
                    \"CompanyType\": \"private limited company\",
                    \"RegisteredLocation\": {
                      \"Lat\": 53.4819,
                      \"Lng\": -2.2331,
                      \"Line1\": \"47 Newton Street\",
                      \"Line2\": \"City Centre\",
                      \"PostCode\": \"M1 1FT\",
                      \"City\": \"Manchester\",
                      \"CountryCode\": \"GB\",
                      \"Region\": \"ENG\"
                    }
                  },
                  \"Phone\": \"0161 414 1080\",
                  \"Heading\": \"Lets turn yourwebsite visitors intocustomers\",
                  \"Sectors\": [
                    \"Marketing and Advertising\"
                  ],
                  \"Location\": {
                    \"Lat\": 53.4819,
                    \"Lng\": -2.2332,
                    \"Line1\": \"47 Newton St; Manchester\",
                    \"Line2\": \"Piccadilly\",
                    \"PostCode\": \"M1 1FT\",
                    \"City\": \"Manchester\",
                    \"CountryCode\": \"GB\",
                    \"Region\": \"England\"
                  },
                  \"WebsiteURL\": [
                    \"canddi.com\"
                  ],
                  \"CompanyName\": \"CANDDi (Campaign and Digital Intelligence Limited)\",
                  \"Description\": \"Campaign and Digital Intelligence: the Prospect Analytics Pioneer. CANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI. CANDDi helps you to: - Close Deals: Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking - Nurture Leads: Identify the hot prospects and the nearly customers and automatically nurture them towards a sale - Optimise Marketing: Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads\",
                  \"SocialMedia\": {
                    \"Twitter\": {
                      \"url\": \"twitter.com/canddi\",
                      \"platform\": \"Twitter\",
                      \"handle\": \"canddi\"
                    },
                    \"Youtube\": {
                      \"url\": \"youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g\",
                      \"platform\": \"Youtube\",
                      \"handle\": \"UCU7aljz8YC9IdPfxuxLY39g\"
                    },
                    \"Facebook\": {
                      \"url\": \"facebook.com/thisiscanddi\",
                      \"platform\": \"Facebook\",
                      \"handle\": \"thisiscanddi\"
                    },
                    \"LinkedIn\": {
                      \"url\": \"linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-\",
                      \"platform\": \"LinkedIn\",
                      \"handle\": \"canddi-campaign-and-digital-intelligence-limited-\"
                    },
                    \"Pinterest\": {
                      \"url\": \"pinterest.com/canddi\",
                      \"platform\": \"Pinterest\",
                      \"handle\": \"canddi\"
                    }
                  },
                  \"PhoneNumbers\": [
                    \"+441614141080\"
                  ],
                  \"EmployeeRange\": \"11-50\",
                  \"EmailAddresses\": [
                    \"hello@canddi.com\",
                    \"help@canddi.com\",
                    \"privacy@canddi.com\",
                    \"dpo@canddi.com\",
                    \"jobs@canddi.com\"
                  ],
                  \"DateDomainLastEdited\": \"2020-09-30\",
                  \"DateDomainRegistered\": \"2009-09-29\",
                  \"CompanyEmailPlatforms\": [
                    {
                      \"MX\": \"*google.com\",
                      \"Type\": \"Gmail\",
                      \"Priority\": 1
                    },
                    {
                      \"MX\": \"*googlemail.com\",
                      \"Type\": \"Gmail\",
                      \"Priority\": 10
                    }
                  ],
                  \"People\": [
                    {
                      \"PersonId\": 2099080,
                      \"Name\": \"Tim Langley\",
                      \"FirstName\": \"Tim\",
                      \"LastName\": \"Langley\",
                      \"Phones\": [],
                      \"Emails\": [
                        \"tim.langley@kompli-global.com\",
                        \"tim@canddi.com\",
                        \"tim@timlangley.me.uk\"
                      ],
                      \"Email\": \"tim@canddi.com\",
                      \"SocialMedia\": {
                        \"Twitter\": {
                          \"url\": \"twitter.com/timlangley\",
                          \"platform\": \"Twitter\",
                          \"handle\": \"timlangley\"
                        },
                        \"LinkedIn\": {
                          \"url\": \"linkedin.com/in/langleytim\",
                          \"platform\": \"LinkedIn\",
                          \"handle\": \"langleytim\"
                        }
                      },
                      \"LegalRole\": \"Director\",
                      \"JobRole\": \"CEO and Founder\",
                      \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                      \"YearsAtCompany\": 13,
                      \"YearsInRole\": 13,
                      \"YearsExperience\": 25
                    },
                    {
                      \"PersonId\": 2099561,
                      \"Name\": \"Claire Garside\",
                      \"FirstName\": \"Claire\",
                      \"LastName\": \"Garside\",
                      \"Phones\": [],
                      \"Emails\": [
                        \"claire@canddi.com\"
                      ],
                      \"Email\": \"claire@canddi.com\",
                      \"SocialMedia\": {
                        \"LinkedIn\": {
                          \"url\": \"linkedin.com/in/claire-garside-3b0a16194\",
                          \"platform\": \"LinkedIn\",
                          \"handle\": \"claire-garside-3b0a16194\"
                        }
                      },
                      \"LegalRole\": \"\",
                      \"JobRole\": \"Senior Sales Consultant\",
                      \"PersonalDescription\": \"If you want to know exactly WHO has been visiting your website and what they did when they got there, then don't hesitate to contact me\",
                      \"YearsAtCompany\": 3,
                      \"YearsInRole\": 3,
                      \"YearsExperience\": 3
                    }
                  ],
                  \"Hostname\": \"canddi.com\"
                },
                \"Person\": {
                    \"Name\": {
                        \"FirstName\": \"Tim\",
                        \"LastName\": \"Langley\",
                        \"MiddleName\": [
                            \"EDWARD\"
                        ]
                    },
                    \"Bio\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the team.Specialties: Innovation, Creativity and EntrepreneurshipEarly stage finance and Business AnalysisExpert knowledge of Javascript (Backbone), PHP (Zend), No-SQL and Big Data\",
                    \"Gender\": \"Male\",
                    \"PhoneNumbers\": [
                        \"+441614141080\"
                    ],
                    \"SocialMedia\": {
                        \"Twitter\": {
                            \"url\": \"twitter.com/timlangley\",
                            \"platform\": \"Twitter\",
                            \"handle\": \"timlangley\"
                        },
                        \"LinkedIn\": {
                            \"url\": \"linkedin.com/in/langleytim\",
                            \"platform\": \"LinkedIn\",
                            \"handle\": \"langleytim\"
                        }
                    },
                    \"Location\": {
                        \"Lat\": 53.4795,
                        \"Lng\": -2.2451,
                        \"Line1\": \"\",
                        \"Line2\": \"\",
                        \"PostCode\": \"\",
                        \"City\": \"Manchester\",
                        \"CountryCode\": \"GB\",
                        \"Region\": \"North West England\"
                    },
                    \"BirthDate\": \"1978-03\",
                    \"EmailAddresses\": [
                        \"tim.langley@kompli-global.com\",
                        \"tim@canddi.com\",
                        \"tim@timlangley.me.uk\"
                    ],
                    \"Email\": \"tim\"
                }
              }")
            ->mock();
        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                $strURL,
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();
        Person::injectGuzzle($mockGuzzle);
        $actualPersonResponse = $personInstance->lookupEmail($strEmailAddress, $strAccountURL, $guidContactId);
        $expectedPersonResponse = new Response\Person(json_decode("{
            \"Hostname\": \"orckid.co.uk\",
            \"Type\": 0,
            \"Company\": {
              \"VAT\": \"GB107133945\",
              \"Email\": \"hello@canddi.com\",
              \"Legal\": {
                \"LegalName\": \"CAMPAIGN AND DIGITAL INTELLIGENCE\",
                \"CRN\": \"07066939\",
                \"IncorporationDate\": \"2009-11-05\",
                \"CompanyType\": \"private limited company\",
                \"RegisteredLocation\": {
                  \"Lat\": 53.4819,
                  \"Lng\": -2.2331,
                  \"Line1\": \"47 Newton Street\",
                  \"Line2\": \"City Centre\",
                  \"PostCode\": \"M1 1FT\",
                  \"City\": \"Manchester\",
                  \"CountryCode\": \"GB\",
                  \"Region\": \"ENG\"
                }
              },
              \"Phone\": \"0161 414 1080\",
              \"Heading\": \"Lets turn yourwebsite visitors intocustomers\",
              \"Sectors\": [
                \"Marketing and Advertising\"
              ],
              \"Location\": {
                \"Lat\": 53.4819,
                \"Lng\": -2.2332,
                \"Line1\": \"47 Newton St; Manchester\",
                \"Line2\": \"Piccadilly\",
                \"PostCode\": \"M1 1FT\",
                \"City\": \"Manchester\",
                \"CountryCode\": \"GB\",
                \"Region\": \"England\"
              },
              \"WebsiteURL\": [
                \"canddi.com\"
              ],
              \"CompanyName\": \"CANDDi (Campaign and Digital Intelligence Limited)\",
              \"Description\": \"Campaign and Digital Intelligence: the Prospect Analytics Pioneer. CANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI. CANDDi helps you to: - Close Deals: Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking - Nurture Leads: Identify the hot prospects and the nearly customers and automatically nurture them towards a sale - Optimise Marketing: Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads\",
              \"SocialMedia\": {
                \"Twitter\": {
                  \"url\": \"twitter.com/canddi\",
                  \"platform\": \"Twitter\",
                  \"handle\": \"canddi\"
                },
                \"Youtube\": {
                  \"url\": \"youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g\",
                  \"platform\": \"Youtube\",
                  \"handle\": \"UCU7aljz8YC9IdPfxuxLY39g\"
                },
                \"Facebook\": {
                  \"url\": \"facebook.com/thisiscanddi\",
                  \"platform\": \"Facebook\",
                  \"handle\": \"thisiscanddi\"
                },
                \"LinkedIn\": {
                  \"url\": \"linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-\",
                  \"platform\": \"LinkedIn\",
                  \"handle\": \"canddi-campaign-and-digital-intelligence-limited-\"
                },
                \"Pinterest\": {
                  \"url\": \"pinterest.com/canddi\",
                  \"platform\": \"Pinterest\",
                  \"handle\": \"canddi\"
                }
              },
              \"PhoneNumbers\": [
                \"+441614141080\"
              ],
              \"EmployeeRange\": \"11-50\",
              \"EmailAddresses\": [
                \"hello@canddi.com\",
                \"help@canddi.com\",
                \"privacy@canddi.com\",
                \"dpo@canddi.com\",
                \"jobs@canddi.com\"
              ],
              \"DateDomainLastEdited\": \"2020-09-30\",
              \"DateDomainRegistered\": \"2009-09-29\",
              \"CompanyEmailPlatforms\": [
                {
                  \"MX\": \"*google.com\",
                  \"Type\": \"Gmail\",
                  \"Priority\": 1
                },
                {
                  \"MX\": \"*googlemail.com\",
                  \"Type\": \"Gmail\",
                  \"Priority\": 10
                }
              ],
              \"People\": [
                {
                  \"PersonId\": 2099080,
                  \"Name\": \"Tim Langley\",
                  \"FirstName\": \"Tim\",
                  \"LastName\": \"Langley\",
                  \"Phones\": [],
                  \"Emails\": [
                    \"tim.langley@kompli-global.com\",
                    \"tim@canddi.com\",
                    \"tim@timlangley.me.uk\"
                  ],
                  \"Email\": \"tim@canddi.com\",
                  \"SocialMedia\": {
                    \"Twitter\": {
                      \"url\": \"twitter.com/timlangley\",
                      \"platform\": \"Twitter\",
                      \"handle\": \"timlangley\"
                    },
                    \"LinkedIn\": {
                      \"url\": \"linkedin.com/in/langleytim\",
                      \"platform\": \"LinkedIn\",
                      \"handle\": \"langleytim\"
                    }
                  },
                  \"LegalRole\": \"Director\",
                  \"JobRole\": \"CEO and Founder\",
                  \"PersonalDescription\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the t\",
                  \"YearsAtCompany\": 13,
                  \"YearsInRole\": 13,
                  \"YearsExperience\": 25
                },
                {
                  \"PersonId\": 2099561,
                  \"Name\": \"Claire Garside\",
                  \"FirstName\": \"Claire\",
                  \"LastName\": \"Garside\",
                  \"Phones\": [],
                  \"Emails\": [
                    \"claire@canddi.com\"
                  ],
                  \"Email\": \"claire@canddi.com\",
                  \"SocialMedia\": {
                    \"LinkedIn\": {
                      \"url\": \"linkedin.com/in/claire-garside-3b0a16194\",
                      \"platform\": \"LinkedIn\",
                      \"handle\": \"claire-garside-3b0a16194\"
                    }
                  },
                  \"LegalRole\": \"\",
                  \"JobRole\": \"Senior Sales Consultant\",
                  \"PersonalDescription\": \"If you want to know exactly WHO has been visiting your website and what they did when they got there, then don't hesitate to contact me\",
                  \"YearsAtCompany\": 3,
                  \"YearsInRole\": 3,
                  \"YearsExperience\": 3
                }
              ],
              \"Hostname\": \"canddi.com\"
            },
            \"Person\": {
                \"Name\": {
                    \"FirstName\": \"Tim\",
                    \"LastName\": \"Langley\",
                    \"MiddleName\": [
                        \"EDWARD\"
                    ]
                },
                \"Bio\": \"CEO and Founder CANDDiI created the original CANDDi software and set out the technology roadmap to continue the platform's development. Today I define the vision, lead the fundraising, and drive the team.Specialties: Innovation, Creativity and EntrepreneurshipEarly stage finance and Business AnalysisExpert knowledge of Javascript (Backbone), PHP (Zend), No-SQL and Big Data\",
                \"Gender\": \"Male\",
                \"PhoneNumbers\": [
                    \"+441614141080\"
                ],
                \"SocialMedia\": {
                    \"Twitter\": {
                        \"url\": \"twitter.com/timlangley\",
                        \"platform\": \"Twitter\",
                        \"handle\": \"timlangley\"
                    },
                    \"LinkedIn\": {
                        \"url\": \"linkedin.com/in/langleytim\",
                        \"platform\": \"LinkedIn\",
                        \"handle\": \"langleytim\"
                    }
                },
                \"Location\": {
                    \"Lat\": 53.4795,
                    \"Lng\": -2.2451,
                    \"Line1\": \"\",
                    \"Line2\": \"\",
                    \"PostCode\": \"\",
                    \"City\": \"Manchester\",
                    \"CountryCode\": \"GB\",
                    \"Region\": \"North West England\"
                },
                \"BirthDate\": \"1978-03\",
                \"EmailAddresses\": [
                    \"tim.langley@kompli-global.com\",
                    \"tim@canddi.com\",
                    \"tim@timlangley.me.uk\"
                ],
                \"Email\": \"tim\"
            }
          }", true));
        $this->assertEquals($expectedPersonResponse, $actualPersonResponse);
        $this->assertInstanceOf(Response\Company\Company::class, $actualPersonResponse->getCompany());
        $this->assertEquals('Tim', $actualPersonResponse->getFirstName());
        $this->assertEquals('Langley', $actualPersonResponse->getLastName());
        $modelJobSummary = $actualPersonResponse->getJobSummary();
        $this->assertNull($modelJobSummary->getJobRole());
        $this->assertNull($modelJobSummary->getNormalJobRole());
    }
}
