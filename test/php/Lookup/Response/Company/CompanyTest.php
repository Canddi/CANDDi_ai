<?php
namespace CanddiAi\Lookup\Response\Company;

use \CanddiAi\TestCase as TestCase;

class CompanyTest
    extends TestCase
{
    private function _getTestData()
    {
        return [
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
            "AlexaRank" => 1,
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
        ];
    }

    public function testGetters()
    {
        $innerCompany = new Company($this->_getTestData());

        $this->assertEquals(
            $this->_getTestData()['AlexaRank'],
            $innerCompany->getAlexaRank()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['City'],
            $innerCompany->getCity()
        );
        $this->assertEquals(
            $this->_getTestData()['CompanyName'],
            $innerCompany->getCompanyName()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['CountryCode'],
            $innerCompany->getCountryCode()
        );
        $this->assertEquals(
            $this->_getTestData()['CRN'],
            $innerCompany->getCRN()
        );
        $this->assertEquals(
            $this->_getTestData()['Debug'],
            $innerCompany->getDebug()
        );
        $this->assertEquals(
            $this->_getTestData()['Description'],
            $innerCompany->getDescription()
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
            $this->_getTestData()['Employees'],
            $innerCompany->getEmployees()
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
            $this->_getTestData()['Industry'],
            $innerCompany->getIndustry()
        );
        $this->assertEquals(
            $this->_getTestData()['IndustryGroup'],
            $innerCompany->getIndustryGroup()
        );
        $this->assertEquals(
            $this->_getTestData()['IndustryNAICS'],
            $innerCompany->getIndustryNAICS()
        );
        $this->assertEquals(
            $this->_getTestData()['IndustrySector'],
            $innerCompany->getIndustrySector()
        );
        $this->assertEquals(
            $this->_getTestData()['IndustrySIC'],
            $innerCompany->getIndustrySIC()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['Lat'],
            $innerCompany->getLat()
        );
        $this->assertEquals(
            $this->_getTestData()['LegalName'],
            $innerCompany->getLegalName()
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
            $this->_getTestData()['MarketCap'],
            $innerCompany->getMarketCap()
        );
        $this->assertEquals(
            $this->_getTestData()['OrigIP'],
            $innerCompany->getOrigIP()
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
            $this->_getTestData()['Raised'],
            $innerCompany->getRaised()
        );
        $this->assertEquals(
            $this->_getTestData()['Location']['Region'],
            $innerCompany->getRegion()
        );
        $this->assertEquals(
            $this->_getTestData()['Revenue'],
            $innerCompany->getRevenue()
        );
        $this->assertEquals(
            $this->_getTestData()['RevenueEstimated'],
            $innerCompany->getRevenueEstimated()
        );
        $this->assertEquals(
            $this->_getTestData()['SIC'],
            $innerCompany->getSIC()
        );
        $this->assertEquals(
            $this->_getTestData()['Tags'],
            $innerCompany->getTags()
        );
        $this->assertEquals(
            $this->_getTestData()['VAT'],
            $innerCompany->getVAT()
        );
        $this->assertEquals(
            $this->_getTestData()['WebsiteURL'],
            $innerCompany->getWebsiteURL()
        );
        $this->assertEquals(
            $this->_getTestData()['WebsiteScreenshot'],
            $innerCompany->getWebsiteScreenshot()
        );

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
}
