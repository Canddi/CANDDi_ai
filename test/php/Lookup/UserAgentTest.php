<?php
namespace CanddiAi\Lookup;


class UserAgentTest
    extends \CanddiAi\TestCase
{
    private $response;

    public function testLookupAgent()
    {
        $arrUserAgentData = [
            "BrowserType" => "Chrome",
            "BrowserVersion" => "1.0.0",
            "OperatingSystem" => "Mac OS X",
            "OperatingVersion" => "10.10.10",
            "Device" => "Other",
            "DeviceVersion" => "0.0.0"
        ];
        $arrExpectedUserAgentData = [
            "BrowserType" => "Chrome",
            "BrowserVersion" => "1.0",
            "OperatingSystem" => "Mac OS X",
            "OperatingVersion" => "10.10",
            "Device" => "Other",
            "DeviceVersion" => "0.0"
        ];
        $strBaseUri = 'baseuri.com';
        $strApiKey = 'api_key_v4387yt876y745';
        $strUserAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.86 Safari/537.36';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $arrQuery = [
            'accounturl' => null,
            'contactid'  => null
        ];
        $strURL = sprintf(UserAgent::c_URL_Agent, urlencode($strUserAgent));
        $userAgentInstance = UserAgent::getInstance($strBaseUri, $strApiKey);
        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn(JSON_encode($arrUserAgentData))
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
        UserAgent::injectGuzzle($mockGuzzle);
        $actualAgentResponse = $userAgentInstance->lookupAgent($strUserAgent);
        $expectedAgentResponse = new Response\UserAgent($arrExpectedUserAgentData);
        $this->assertEquals($expectedAgentResponse, $actualAgentResponse);
    }
}