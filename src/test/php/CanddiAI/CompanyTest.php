<?php

namespace CanddiAI;

class CompanyTest
    extends CanddiAI_TestCase
{
    public function testLookupHost()
    {

        $strBaseUri = 'baseuri.com';
        $strApiKey = 'api_key_v4387yt876y745';

        $strHostname = 'hostname.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_Host, $strHostname);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];

        $companyInstance = Company::getInstance($strBaseUri, $strApiKey);

        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn('[]')
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

        Company::injectGuzzle($mockGuzzle);

        $actualCompanyResponse = $companyInstance->lookupHost($strHostname, $strAccountURL, $guidContactId);

        $expectedCompanyResponse = new Response\Company([]);

        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }

    public function testLookupIP()
    {

        $strBaseUri = 'baseuri.com';
        $strApiKey = 'api_key_v4387yt876y745';

        $STRIP = 'hostname.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_Host, $STRIP);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];

        $companyInstance = Company::getInstance($strBaseUri, $strApiKey);

        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->once()
            ->withNoArgs()
            ->andReturn(200)
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn('[]')
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

        Company::injectGuzzle($mockGuzzle);

        $actualCompanyResponse = $companyInstance->lookupHost($STRIP, $strAccountURL, $guidContactId);

        $expectedCompanyResponse = new Response\Company([]);

        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
}
