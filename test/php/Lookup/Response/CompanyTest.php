<?php
namespace CanddiAi\Lookup\Response;

use \CanddiAi\TestCase as TestCase;

class CompanyTest
    extends TestCase
{
    private function _getTestData()
    {
        return [
            "Hostname"      => "canddi.com",
            "Type"          => 3,
            "Company"       => [
                "WebsiteURL"    => [
                    "https://www.canddi.com"
                ],
                "CRN"           => "07066939",
                "SocialMedia"   => [
                    "Pinterest" => [
                        "url"       => "pinterest.com/canddi",
                        "platform"  => "Pinterest",
                        "handle"    => "canddi"
                    ],
                    "Facebook"  => [
                        "url"       => "facebook.com/thisiscanddi",
                        "platform"  => "Facebook",
                        "handle"    => "thisiscanddi"
                    ],
                    "Twitter"   => [
                        "url"       => "twitter.com/canddi",
                        "platform"  => "Twitter",
                        "handle"    => "canddi"
                    ],
                    "Youtube"   => [
                        "url"       => "youtube.com/channel/UCU7aljz8YC9IdPfxuxLY39g",
                        "platform"  => "Youtube",
                        "handle"    => "UCU7aljz8YC9IdPfxuxLY39g"
                    ],
                    "LinkedIn"  => [
                        "url"       => "linkedin.com/company/canddi-campaign-and-digital-intelligence-limited-",
                        "platform"  => "LinkedIn",
                        "handle"    => "canddi-campaign-and-digital-intelligence-limited-"
                    ]
                ],
                "Description"     => "Campaign and Digital Intelligence   => the Prospect Analytics Pioneer. \n\nCANDDi tells you WHO is on your website, not just how many people. It tracks visitors across time and multiple devices, combining behavioural data with social profile information to provide actionable sales insight to boost ROI.\n\nCANDDi helps you to    =>\n - Close Deals     => Enable sales teams to make intelligent, timely interventions with rich profiles and real-time behaviour tracking\n - Nurture Leads   => Identify the hot prospects and the nearly customers and automatically nurture them towards a sale\n - Optimise Marketing   => Cut sales cycle length and cost by focusing on the campaigns that deliver sales not just leads",
                "Heading"     => "Turn visitors intoleads, and leadsinto sales.",
                "PhoneNumbers"    => [
                    "+441614141080"
                ],
                "EmailAddresses"  => [
                    "hello@canddi.com",
                    "help@canddi.com"
                ],
                "CompanyName"     => "CAMPAIGN AND DIGITAL INTELLIGENCE LTD",
                "LegalName"   => "Campaign and Digital Intelligence Limited",
                "EmployeeRange"   => "11-50 employees",
                "Employees"   => 39,
                "Logo"    => "https  =>//images.canddi.net/canddi.com/logo.png",
                "Location"    => [
                    "Lat"   => 53.4819,
                    "Lng"   => -2.2332,
                    "Line1"     => "47 Newton Street",
                    "Line2"     => "Manchester",
                    "PostCode"  => "M1 1FT",
                    "City"  => "Manchester",
                    "CountryCode"   => "GB"
                ],
                "SIC"     => [
                    "62012"
                ]
            ],
            "IP"        => [
                "StartIP"     => "84.13.20.215",
                "EndIP"   => "84.13.20.215",
                "Lat"     => 53.4606,
                "Lng"     => -2.2572,
                "IPRange"     => 0,
                "CompanyName"     => "1410143447-canddi.com",
                "IPAddress"   => "84.13.20.215",
                "Location"    => [
                    "Lat"   => 53.4606,
                    "Lng"   => -2.2572,
                    "Line1"     => "",
                    "Line2"     => "",
                    "PostCode"  => "M16",
                    "City"  => "Manchester",
                    "CountryCode"   => ""
                ]
            ],
            "Debug"     => [
              "JobId"   => null,
              "Reprocess"   => false,
              "IPTime"  => 1581519740,
              "MapTime"     => 1580994092,
              "CompanyTime"     => 1585909560,
              "IPId"    => 33604182,
              "CompanyId"   => 66101875,
              "CanddiCompanyId"     => 904877,
              "LastFunction"    => "finished_processing",
              "AllRecords"  => [
                [
                  "CompanyName"     => "1410143447-canddi.com",
                  "CompanyId"   => 66101875,
                  "Hostname"    => "canddi.com",
                  "Type"    => 3,
                  "MV"  => 1,
                  "LM"  => "2_Hosts_Summary",
                  "DataSource"  => 3,
                  "IPRange"     => 0,
                  "TimeUpdatedIP"   => 1581519740
                ]
              ]
            ]
        ];
    }

    public function testGetters()
    {
        $respCompany = new Company($this->_getTestData());

        $this->assertInstanceOf(
            Company\Company::class,
            $respCompany->getCompany()
        );

        $this->assertInstanceOf(
            Company\IP::class,
            $respCompany->getIP()
        );

        $this->assertEquals(
            $this->_getTestData()['Debug'],
            $respCompany->getDebug()
        );

        $this->assertEquals(
            $this->_getTestData()['Type'],
            $respCompany->getType()
        );

        $this->assertEquals(
            $this->_getTestData()['Hostname'],
            $respCompany->getHostname()
        );

        $this->assertEquals(
            false,
            $respCompany->bIsISP()
        );
    }
}
