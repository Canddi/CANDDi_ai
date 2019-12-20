<?php

/**
 * @author Matty Glancy
 */

namespace CanddiAi\Lookup;

class FunctionalTest_Company
    extends \CanddiAi\Functional_TestCase
{
    private $_strApiKey = '';
    private $_strBaseUri = '';

    public function testLookupHost()
    {
        $strHost = 'canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);

        $instance = Company::getInstance($this->_strBaseUri, $this->_strAccessToken);

        $response = $instance->lookupHost($strHost, $strAccountURL, $guidContactId);

        print_r($this->_getProtAttr($response, '_arrResponse'));
    }
    public function testLookupIP()
    {
        $strIP = '87.238.85.156';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);

        $instance = Company::getInstance($this->_strBaseUri, $this->_strAccessToken);

        $response = $instance->lookupIP($strIP, $strAccountURL, $guidContactId);

        print_r($this->_getProtAttr($response, '_arrResponse'));
    }
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
}
