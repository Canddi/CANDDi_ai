<?php
namespace CanddiAi\Lookup;


class UserAgentResponseTest
    extends \CanddiAi\TestCase
{
    public function testConstruct()
    {
        $arrResponseData = [
            "BrowserType" => "Chrome",
            "BrowserVersion" => "1.0",
            "OperatingSystem" => "Mac OS X",
            "OperatingVersion" => "10.10",
            "Device" => "Other",
            "DeviceVersion" => "0.0"
        ];

        $response = new Response\UserAgent($arrResponseData);

        $this->assertEquals($arrResponseData['BrowserType'], $response->getBrowserType());
        $this->assertEquals($arrResponseData['BrowserVersion'], $response->getBrowserVersion());
        $this->assertEquals($arrResponseData['OperatingSystem'], $response->getOperatingSystem());
        $this->assertEquals($arrResponseData['OperatingVersion'], $response->getOperatingVersion());
        $this->assertEquals($arrResponseData['Device'], $response->getDevice());
        $this->assertEquals($arrResponseData['DeviceVersion'], $response->getDeviceVersion());
    }
}