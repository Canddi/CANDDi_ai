<?php

/**
 * @author Matty Glancy
 */

namespace CanddiAi\Lookup;

class FunctionalTest_Person
    extends \CanddiAi\Functional_TestCase
{
    private $_strApiKey = '';
    private $_strBaseUri = '';

    public function testLookupEmail()
    {
        $strEmail = 'tim@canddi.com';
        $strAccountURL = 'anAccount';
        $guidContactId = md5(1);

        $instance = Person::getInstance($this->_strBaseUri, $this->_strApiKey);

        $response = $instance->lookupEmail($strEmail, $strAccountURL, $guidContactId);

        print_r($this->_getProtAttr($response, '_arrResponse'));
    }
}
