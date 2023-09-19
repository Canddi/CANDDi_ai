<?php
/**
 * @author Matty Glancy
 **/
namespace CanddiAi\Lookup;
class CompanyTest
    extends \CanddiAi\TestCase
{
    public function testLookupCompanyName()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strName = 'CANDD/i';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_CompanyName, str_replace('/', '%2F', $strName));
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody('[]'))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupCompanyName($strName, $strAccountURL, $guidContactId);
        $this->assertInstanceOf(Response\Company::CLASS, $actualCompanyResponse);
    }
    public function testLookupCompanyName_WithCallback()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strName = 'CANDDi';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strCallback = 'http://www.';
        $arrOptions = [
            'headers' => [
                'my' => 'header'
            ]
        ];
        $strURL             = sprintf(Company::c_URL_CompanyName, $strName);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => $strCallback,
            'cboptions'     => '{\"headers\":{\"my\":\"header\"}}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody('[]'))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupCompanyName($strName, $strAccountURL, $guidContactId, $strCallback, $arrOptions);
        $this->assertInstanceOf(Response\Company::CLASS, $actualCompanyResponse);
    }
    public function testLookupHost()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strHostname = 'hostname.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_Host, $strHostname);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody('[]'))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupHost($strHostname, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company([
        ]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
    public function testLookupIP()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $intIP = 12345;
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_IP, $intIP);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody('[]'))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupIP($intIP, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company([
        ]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
    public function testLookups_Fail()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];

        $strName = 'CANDDi';
        $intIP = 12345;
        $strHost = 'canddi.com';

        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->times(2)
            ->withNoArgs()
            ->andReturn(400)
            ->shouldReceive('getReasonPhrase')
            ->times(2)
            ->withNoArgs()
            ->andReturn('Bad Request')
            ->mock();

        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->times(2)
            ->with(
                'GET',
                \Mockery::type('string'),
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();

        Company::injectGuzzle($mockGuzzle);
        $lookupCompany = Company::getInstance($strBaseUri, $strAccessToken);

        $returnedException = null;

        try {
            $lookupCompany->lookupHost($strHost, $strAccountURL, $guidContactId);
        } catch(\Exception $e) {
            $returnedException = $e;
        }

        $this->assertEquals(
            "Service:Company:Host returned error for ($strHost) ".
            " on Account ($strAccountURL), Contact ($guidContactId) ".
            "400-Bad Request",
            $returnedException->getMessage()
        );

        try {
            $lookupCompany->lookupIP($intIP, $strAccountURL, $guidContactId);
        } catch(\Exception $e) {
            $returnedException = $e;
        }

        $this->assertEquals(
            "Service:Company:IP returned error for ($intIP) ".
            " on Account ($strAccountURL), Contact ($guidContactId) ".
            "400-Bad Request",
            $returnedException->getMessage()
        );
    }
    public function testLookupIP_NoData()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $intIP = 12345;
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_IP, $intIP);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(201)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody("{
                \"Reprocess\" : true
            }"))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupIP($intIP, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company([
            'Reprocess' => true
        ]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
    public function testLookupIP_IPOnly()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $intIP = 12345;
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_IP, $intIP);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody("{
                \"Hostname\": \"orckid.co.uk\",
                \"Type\": 0,
                \"IP\": {
                  \"StartIP\": \"46.37.49.250\",
                  \"EndIP\": \"46.37.49.250\",
                  \"CountryCode\": \"GB\",
                  \"Lat\": 52.9871,
                  \"Lng\": -1.0677,
                  \"IPRange\": 0,
                  \"CompanyName\": \"orckid design  marketing ltd 2\",
                  \"IPAddress\": \"46.37.49.250\",
                  \"Location\": {
                    \"Lat\": 52.9871,
                    \"Lng\": -1.0677,
                    \"Line1\": \"\",
                    \"Line2\": \"\",
                    \"PostCode\": \"NG4\",
                    \"City\": \"Nottingham\",
                    \"CountryCode\": \"GB\",
                    \"Region\": \"ENG\"
                  }
                }
              }"))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupIP($intIP, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company(json_decode("
        {
            \"Hostname\": \"orckid.co.uk\",
            \"Type\": 0,
            \"IP\": {
              \"StartIP\": \"46.37.49.250\",
              \"EndIP\": \"46.37.49.250\",
              \"CountryCode\": \"GB\",
              \"Lat\": 52.9871,
              \"Lng\": -1.0677,
              \"IPRange\": 0,
              \"CompanyName\": \"orckid design  marketing ltd 2\",
              \"IPAddress\": \"46.37.49.250\",
              \"Location\": {
                \"Lat\": 52.9871,
                \"Lng\": -1.0677,
                \"Line1\": \"\",
                \"Line2\": \"\",
                \"PostCode\": \"NG4\",
                \"City\": \"Nottingham\",
                \"CountryCode\": \"GB\",
                \"Region\": \"ENG\"
              }
            }
          }
        ", true));
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
        $this->assertNull($actualCompanyResponse->getCompany());
        $this->assertInstanceOf(Response\Company\IP::class, $actualCompanyResponse->getIP());
    }
    public function testLookupIP_IPAndCompany()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $intIP = 12345;
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_IP, $intIP);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody("{
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
                \"IP\": {
                  \"StartIP\": \"46.37.49.250\",
                  \"EndIP\": \"46.37.49.250\",
                  \"CountryCode\": \"GB\",
                  \"Lat\": 52.9871,
                  \"Lng\": -1.0677,
                  \"IPRange\": 0,
                  \"CompanyName\": \"orckid design  marketing ltd 2\",
                  \"IPAddress\": \"46.37.49.250\",
                  \"Location\": {
                    \"Lat\": 52.9871,
                    \"Lng\": -1.0677,
                    \"Line1\": \"\",
                    \"Line2\": \"\",
                    \"PostCode\": \"NG4\",
                    \"City\": \"Nottingham\",
                    \"CountryCode\": \"GB\",
                    \"Region\": \"ENG\"
                  }
                }
              }"))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupIP($intIP, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company(json_decode("{
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
            \"IP\": {
              \"StartIP\": \"46.37.49.250\",
              \"EndIP\": \"46.37.49.250\",
              \"CountryCode\": \"GB\",
              \"Lat\": 52.9871,
              \"Lng\": -1.0677,
              \"IPRange\": 0,
              \"CompanyName\": \"orckid design  marketing ltd 2\",
              \"IPAddress\": \"46.37.49.250\",
              \"Location\": {
                \"Lat\": 52.9871,
                \"Lng\": -1.0677,
                \"Line1\": \"\",
                \"Line2\": \"\",
                \"PostCode\": \"NG4\",
                \"City\": \"Nottingham\",
                \"CountryCode\": \"GB\",
                \"Region\": \"ENG\"
              }
            }
          }", true));
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
        $this->assertInstanceOf(Response\Company\Company::class, $actualCompanyResponse->getCompany());
        $this->assertInstanceOf(Response\Company\IP::class, $actualCompanyResponse->getIP());
    }
    public function testLookupHost_NoData()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strHost = 'canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_Host, $strHost);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(201)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody("{
                \"Reprocess\" : true
            }"))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupHost($strHost, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company([
            'Reprocess' => true
        ]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
    public function testLookupHost_WithIP()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strHost = 'canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $intIP = 1028;
        $strURL             = sprintf(Company::c_URL_Host, $strHost);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}',
            'ip'            => $intIP
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(201)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody("{
                \"Reprocess\" : true
            }"))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupHost($strHost, $strAccountURL, $guidContactId, null, [], $intIP);
        $expectedCompanyResponse = new Response\Company([
            'Reprocess' => true
        ]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
    public function testLookupHost_HasCompany()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strHost = 'canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_Host, $strHost);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($this->_mockResponseBody("{
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
                \"Hostname\": \"canddi.com\"
            }"))
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
        Company::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupHost($strHost, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company(json_decode("{
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
            \"Hostname\": \"canddi.com\"
        }", true));
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
}
