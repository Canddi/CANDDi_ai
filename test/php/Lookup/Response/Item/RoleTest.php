<?php

namespace CanddiAi\Lookup\Response\Item;

class RoleTest
    extends \CanddiAi\TestCase
{
    private $response;

    private function _getTestData()
    {
        return [
            "CompanyName" => "the sequel to the fake company",
            "StartDate" => "2010-02",
            "EndDate" => null,
            "Title" => "ceo",
            "IsPrimary" => true
        ];
    }

    public function testBPrimary()
    {
        $response = new Role($this->_getTestData());

        $this->assertTrue($response->bPrimary());
    }

    public function testGetName()
    {
        $response = new Role($this->_getTestData());

        $strExpectedName = "the sequel to the fake company";
        $strReturnedName = $response->getName();

        $this->assertEquals($strExpectedName, $strReturnedName);
    }

    public function testGetStartDate()
    {
        $response = new Role($this->_getTestData());

        $strExpectedDate = "2010-02";
        $strReturnedDate = $response->getStartDate();

        $this->assertEquals($strExpectedDate, $strReturnedDate);
    }
    public function testGetEndDate()
    {
        $response = new Role($this->_getTestData());

        $strExpectedDate = "";
        $strReturnedDate = $response->getEndDate();

        $this->assertEquals($strExpectedDate, $strReturnedDate);
    }
    public function testGetTitle()
    {
        $response = new Role($this->_getTestData());

        $strExpectedTitle = "ceo";
        $strReturnedTitle = $response->getTitle();

        $this->assertEquals($strExpectedTitle, $strReturnedTitle);
    }
}
