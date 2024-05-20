<?php

namespace CanddiAi\Lookup\Response\Company;

class PersonTest
    extends \CanddiAi\TestCase
{
    private function _getTestData()
    {
        return [
            "PersonId" => 274644,
            "Name" => "Timothy Edward Langley",
            "FirstName" => "Timothy Edward",
            "LastName" => "Langley",
            "Phones" => ['+4412345678'],
            "Email" => "tim@canddi.com",
            "JobRole" => "Founder & CEO",
            "PersonalDescription" => "Tim",
            "Emails" => [
                "tim@canddi.com",
                "tim@timlangley.me.uk"
            ],
            "SocialMedia" => [
                "Twitter" => [
                    "url" => "twitter.com/TimLangley",
                    "platform" => "Twitter",
                    "handle" => "TimLangley"
                ],
                "LinkedIn" => [
                    "url" => "linkedin.com/in/langleytim",
                    "platform" => "LinkedIn",
                    "handle" => "langleytim"
                ]
            ],
            "LegalRole" => "Director",
            "Position" => "",
            "YearsAtCompany" => 13,
            "YearsInRole" => 13,
            "YearsExperience" => 25
        ];
    }
    public function testCreateAndGetters()
    {

        $testData = $this->_getTestData();
        $response = new Person($testData);

        $this->assertEquals($testData[Person::KEY_PERSONID], $response->getPersonId());
        $this->assertEquals($testData[Person::KEY_NAME], $response->getName());
        $this->assertEquals($testData[Person::KEY_FORENAME], $response->getFirstName());
        $this->assertEquals($testData[Person::KEY_SURNAME], $response->getLastName());
        $this->assertEquals($testData[Person::KEY_EMAIL], $response->getEmail());
        $this->assertEquals($testData[Person::KEY_JOBROLE], $response->getJobRole());
        $this->assertEquals($testData[Person::KEY_PERSONALDESCRIPTION], $response->getPersonalDescription());
        $this->assertEquals($testData[Person::KEY_EMAILS], $response->getEmailAddresses());
        $this->assertEquals($testData[Person::KEY_PHONES], $response->getPhoneNumbers());
        $this->assertEquals($testData[Person::KEY_LEGAL_ROLE], $response->getLegalRole());
        $this->assertEquals($testData[Person::KEY_YEARSATCOMPANY], $response->getYearsAtCompany());
        $this->assertEquals($testData[Person::KEY_YEARSINROLE], $response->getYearsInRole());
        $this->assertEquals($testData[Person::KEY_YEARSEXPERIENCE], $response->getYearsExperience());

        $this->assertTrue(is_array($response->getSocialProfiles()));
        $this->assertEquals(count($testData[Person::KEY_SOCIAL]), count($response->getSocialProfiles()));
        foreach ($response->getSocialProfiles() as $mdlSocialProfile) {
            $this->assertInstanceOf(SocialMedia::class, $mdlSocialProfile);
        }
    }
    public function testGetFirstName()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $strExpectedFirstName = "Timothy Edward";
        $strReturnedFirstName = $response->getFirstName();

        $this->assertEquals($strExpectedFirstName, $strReturnedFirstName);

        // Test to make sure it returns null when there's no firstname
        unset($testData["FirstName"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getFirstName());

        // Test for if the ContactInfo field doesn't exist
        unset($testData["FirstName"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getFirstName());
    }
    public function testGetLastName()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $strExpectedLastName = "Langley";
        $strReturnedLastName = $response->getLastName();

        $this->assertEquals($strExpectedLastName, $strReturnedLastName);

        // Test to make sure it returns null when there's no LastName
        unset($testData["LastName"]);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getLastName());
    }

    public function testGetLegalRole()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);
        $strRole = $response->getLegalRole();

        $this->assertEquals('Director', $strRole);

        unset($testData['LegalRole']);
        $response = new Person($testData);

        $this->assertEquals(null, $response->getLegalRole());
    }
    public function testGetSocialProfiles()
    {
        $response = new Person($this->_getTestData());

        $arrProfiles = $response->getSocialProfiles();

        $this->assertTrue(is_array($arrProfiles));
    }
    public function testGetEmailAddresses()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $arrEmails = $response->getEmailAddresses();
        $expectedResponse = $testData[Person::KEY_EMAILS];

        $this->assertEquals($expectedResponse, $arrEmails);
    }
    public function testGetPhoneNumbers()
    {
        $testData = $this->_getTestData();
        $response = new Person($testData);

        $arrPhones = $response->getPhoneNumbers();
        $expectedResponse = $testData[Person::KEY_PHONES];

        $this->assertEquals($expectedResponse, $arrPhones);
    }
}
