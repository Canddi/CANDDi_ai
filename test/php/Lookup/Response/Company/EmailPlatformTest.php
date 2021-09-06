<?php

namespace CanddiAi\Lookup\Response\Company;

class EmailPlatformTest
    extends \CanddiAi\TestCase
{
    private function _getTestData()
    {
        return [
            "MX"        => "*google.com",
            "Type"      => "Gmail",
            "Priority"  => 1
        ];
    }
    public function testCreateAndGetters()
    {
        
        $testData = $this->_getTestData();
        $response = new EmailPlatform($testData);
        
        $this->assertEquals($testData[EmailPlatform::KEY_MX], $response->getMX());
        $this->assertEquals($testData[EmailPlatform::KEY_PRIORITY], $response->getPriority());
        $this->assertEquals($testData[EmailPlatform::KEY_TYPE], $response->getType());
    }
}
