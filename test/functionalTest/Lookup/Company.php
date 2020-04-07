<?php

/**
 * @author Matty Glancy
 */

namespace CanddiAi\Lookup;

class FunctionalTest_Company
    extends \CanddiAi\Functional_TestCase
{
    private $_strAccessToken = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IlJUQXhPVVZCTlRBM1FqRkJOVUV5UmtVd01rSkVSRFV6UkRNelFrRTJNalpCUTBJM05rRkZRZyJ9.eyJpc3MiOiJodHRwczovL2NhbmRkaS1kYXRhLmV1LmF1dGgwLmNvbS8iLCJzdWIiOiIxd2UyMDNCV2dtUkhrS3Z1RTRZSktTaXc5YkFBSlNYU0BjbGllbnRzIiwiYXVkIjoiYXBpLmNhbmRkaS5haSIsImlhdCI6MTU4NjI2NTc4OCwiZXhwIjoxNTg2MzUyMTg4LCJhenAiOiIxd2UyMDNCV2dtUkhrS3Z1RTRZSktTaXc5YkFBSlNYUyIsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyJ9.JIC5O46hIrXj4-bSLIYZu9RgbfEBF-3SIEQxB87XaRzdkrbIxpNPVmQLWThRuxeAr35ODvn0zCOZTUuSVZRo0hOffzNCrlrwn7Nyy-95jBcNmuR73RRiiAD4X9ssHTXfjKvljbhGkHm9URetqlGZf3SWo-9J_6dqnaeSbZcX8vU1uQsnnMu7XcRIkkregvTr7VYSz_98izvra5PYvcH3IZaOf-ALhmsHFlXqDjzRBcOCL12lZYlhZS-yu3609NpTZKlKgwOBlyYEoJZlVDdGONIizlBZD2SVZBhKYnCRzUW6GGljILQMqTWEP6Jw3ITkRI1LtHcu1bIUFy_aB1Ggfw";
    private $_strBaseUri = 'https://ip.canddi.ai/';

    /*
    public function testLookupHost()
    {
        $strHost = 'canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);

        $instance = Company::getInstance($this->_strBaseUri, $this->_strAccessToken);

        $response = $instance->lookupHost($strHost, $strAccountURL, $guidContactId);

        print_r($this->_getProtAttr($response, '_arrResponse'));
    }
    */
    public function testLookupIP()
    {
        $strIP = '88.98.243.9';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);

        $instance = Company::getInstance($this->_strBaseUri, $this->_strAccessToken);

        $response = $instance->lookupIP($strIP, $strAccountURL, $guidContactId);

        print_r($response);
    }
    /*
    public function testLookupName()
    {
        $strName = 'CANDDi';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);

        $instance = Company::getInstance($this->_strBaseUri, $this->_strAccessToken);

        $response = $instance->lookupName($strName, $strAccountURL, $guidContactId);

        print_r($this->_getProtAttr($response, '_arrResponse'));
    }
    public function testLookupCompanyName()
    {
        $strName = 'CANDDi';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);

        $instance = Company::getInstance($this->_strBaseUri, $this->_strAccessToken);

        $response = $instance->lookupCompanyName($strName, $strAccountURL, $guidContactId);

        print_r($this->_getProtAttr($response, '_arrResponse'));
    }
    */
}
