<?php
/**
 * @author Matty Glancy
 **/
namespace CanddiAi\Lookup;
class PersonTest
    extends \CanddiAi\TestCase
{
    public function testLookupEmail()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strEmail = 'tim@canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);
        $strURL             = sprintf(Person::c_URL_Person, $strEmail);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId
        ];
        $companyInstance = Person::getInstance($strBaseUri, $strAccessToken);
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
        Person::injectGuzzle($mockGuzzle);
        $actualCompanyResponse = $companyInstance->lookupEmail($strEmail, $strAccountURL, $guidContactId);
        $expectedCompanyResponse = new Response\Person([]);
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
            'contactid'     => $guidContactId
        ];

        $strEmail = 'tim@canddi.com';

        $mockResponse = \Mockery::mock('GuzzleHttp\Psr7\Response')
            ->shouldReceive('getStatusCode')
            ->twice()
            ->withNoArgs()
            ->andReturn(400)
            ->shouldReceive('getReasonPhrase')
            ->once()
            ->withNoArgs()
            ->andReturn('Bad Request')
            ->mock();

        $mockGuzzle = \Mockery::mock('GuzzleHttp\Client')
            ->shouldReceive('request')
            ->once()
            ->with(
                'GET',
                \Mockery::type('string'),
                [
                    'query'         => $arrQuery
                ]
            )
            ->andReturn($mockResponse)
            ->mock();

        Person::injectGuzzle($mockGuzzle);
        $lookupCompany = Person::getInstance($strBaseUri, $strAccessToken);

        $returnedException = null;

        try {
            $lookupCompany->lookupEmail($strEmail, $strAccountURL, $guidContactId);
        } catch(\Exception $e) {
            $returnedException = $e;
        }

        $this->assertEquals(
            "Service:Person:Email returned error for ($strEmail) ".
            " on Account ($strAccountURL), Contact ($guidContactId) ".
            "400-Bad Request",
            $returnedException->getMessage()
        );
    }
    public function testLookupLinkedIn()
    {
        $strBaseUri = 'baseuri.com';
        $strAccessToken = md5(1);
        $strUsername = 'linkedinName';
        $strAccountURL = 'anAccount';
        $strCBUrl = 'url';
        $guidContactId = md5(1);
        $strURL             = sprintf(Person::c_URL_LinkedIn, $strUsername);
        $arrQuery           = [
            'accounturl'    => $strAccountURL,
            'contactid'     => $guidContactId,
            'cburl'         => $strCBUrl,
            'cboptions'     => '{}'
        ];
        $companyInstance = Person::getInstance($strBaseUri, $strAccessToken);
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
        Person::injectGuzzle($mockGuzzle);

        $actualCompanyResponse = $companyInstance->lookupLinkedIn(
            $strUsername,
            $strAccountURL,
            $guidContactId,
            $strCBUrl
        );
        $expectedCompanyResponse = new Response\PersonLinkedIn([]);
        $this->assertEquals($expectedCompanyResponse, $actualCompanyResponse);
    }
}
