<?php

namespace CanddiAi\Lookup\Response;

class NormalizeNameTest
    extends \CanddiAi\TestCase
{
    private $response;

    private function _getTestData()
    {
        return [
            'FirstName' => "Tim",
            'LastName'=> "Langley"
        ];
    }

    public function testGetFirstName()
    {
        $testData = $this->_getTestData();
        $response = new NormalizeName($testData);

        $this->assertEquals("Tim", $response->getFirstName());

        // Test to make sure it returns null when there's no firstname
        unset($testData["FirstName"]);
        $response = new NormalizeName($testData);

        $this->assertEquals(null, $response->getFirstName());
    }
    public function testGetLastName()
    {
        $testData = $this->_getTestData();
        $response = new NormalizeName($testData);

        $this->assertEquals("Langley", $response->getLastName());

        // Test to make sure it returns null when there's no firstname
        unset($testData["LastName"]);
        $response = new NormalizeName($testData);

        $this->assertEquals(null, $response->getLastName());
    }
}
