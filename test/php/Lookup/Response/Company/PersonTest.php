<?php

namespace CanddiAi\Lookup\Response\Company;

class PersonTestLinkedIn
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
            "Position" => ""
        ];
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
