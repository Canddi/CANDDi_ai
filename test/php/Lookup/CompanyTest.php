<?php
/**
 * @author Matty Glancy
 **/
namespace CanddiAi\Lookup;
class CompanyTest
    extends \CanddiAi\TestCase
{
    public function testLookupCompanyName()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strName = 'CANDD/i';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_CompanyName, str_replace('/', '%2F', $strName));
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
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
        $actualCompanyResponse = $companyInstance->lookupCompanyName($strName, $strAccountURL, $guidContactId);
        $this->assertInstanceOf(Response\Company::CLASS, $actualCompanyResponse);
    }
    public function testLookupCompanyName_WithCallback()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strName = 'CANDDi';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strCallback = 'http://www.';
        $arrOptions = [
            'headers' => [
                'my' => 'header'
            ]
        ];
        $strURL             = sprintf(Company::c_URL_CompanyName, $strName);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => $strCallback,
            'cboptions'     => '{\"headers\":{\"my\":\"header\"}}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
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
        $actualCompanyResponse = $companyInstance->lookupCompanyName($strName, $strAccountURL, $guidContactId, $strCallback, $arrOptions);
        $this->assertInstanceOf(Response\Company::CLASS, $actualCompanyResponse);
    }
    public function testLookupHost()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strHostname = 'hostname.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_Host, $strHostname);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
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
        $expectedCompanyResponse = new Response\Company([
            'Type'   => '',
            'bIsISP' => false
        ]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
    public function testLookupIP()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $intIP = 12345;
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_IP, $intIP);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
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
        $actualCompanyResponse = $companyInstance->lookupIP($intIP, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company([
            'Type'   => '',
            'bIsISP' => false
        ]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
    public function testLookupName()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strName = 'CANDDi';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Company::c_URL_Name, $strName);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];
        $companyInstance = Company::getInstance($strBaseUri, $strAccessToken);
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
        $actualCompanyResponse = $companyInstance->lookupName($strName, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Company([
            'Type'   => '',
            'bIsISP' => false
        ]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
    public function testLookups_Fail()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => '',
            'cboptions'     => '{}'
        ];

        $strName = 'CANDDi';
        $intIP = 12345;
        $strHost = 'canddi.com';

        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->times(6)
            ->withNoArgs()
            ->andReturn(400)
            ->shouldReceive('getReasonPhrase')
            ->times(3)
            ->withNoArgs()
            ->andReturn('Bad Request')
            ->mock();

        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->times(3)
            ->with(
                'GET',
                \Mockery::type('string'),
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();

        Company::injectGuzzle($mockGuzzle);
        $lookupCompany = Company::getInstance($strBaseUri, $strAccessToken);

        $returnedException = null;

        try {
            $lookupCompany->lookupHost($strHost, $strAccountURL, $guidContactId);
        } catch(\Exception $e) {
            $returnedException = $e;
        }

        $this->assertEquals(
            "Service:Company:Host returned error for ($strHost) ".
            " on Account ($strAccountURL), Contact ($guidContactId) ".
            "400-Bad Request",
            $returnedException->getMessage()
        );

        try {
            $lookupCompany->lookupIP($intIP, $strAccountURL, $guidContactId);
        } catch(\Exception $e) {
            $returnedException = $e;
        }

        $this->assertEquals(
            "Service:Company:IP returned error for ($intIP) ".
            " on Account ($strAccountURL), Contact ($guidContactId) ".
            "400-Bad Request",
            $returnedException->getMessage()
        );

        try {
            $lookupCompany->lookupName($strName, $strAccountURL, $guidContactId);
        } catch(\Exception $e) {
            $returnedException = $e;
        }

        $this->assertEquals(
            "Service:Company:Name returned error for ($strName) ".
            " on Account ($strAccountURL), Contact ($guidContactId) ".
            "400-Bad Request",
            $returnedException->getMessage()
        );
    }
}
