<?php

namespace CanddiAi\Lookup\Response;

class NormalizeNameTest
    extends \CanddiAi\TestCase
{
    private $response;

    private function _getTestData()
    {
        return [
            'nameDetails'   => [
                'givenName' => "Tim",
                'familyName'=> "Langley"
            ]
        ];
    }

    public function testGetFirstName()
    {
        $testData = $this->_getTestData();
        $response = new NormalizeName($testData);

        $this->assertEquals("Tim", $response->getFirstName());

        // Test to make sure it returns null when there's no firstname
        unset($testData["nameDetails"]["givenName"]);
        $response = new NormalizeName($testData);

        $this->assertEquals(null, $response->getFirstName());

        // Test for if the nameDetails field doesn't exist
        unset($testData["nameDetails"]);
        $response = new NormalizeName($testData);

        $this->assertEquals(null, $response->getFirstName());
    }
    public function testGetLastName()
    {
        $testData = $this->_getTestData();
        $response = new NormalizeName($testData);

        $this->assertEquals("Langley", $response->getLastName());

        // Test to make sure it returns null when there's no firstname
        unset($testData["nameDetails"]["familyName"]);
        $response = new NormalizeName($testData);

        $this->assertEquals(null, $response->getLastName());

        // Test for if the nameDetails field doesn't exist
        unset($testData["nameDetails"]);
        $response = new NormalizeName($testData);

        $this->assertEquals(null, $response->getLastName());
    }
}
