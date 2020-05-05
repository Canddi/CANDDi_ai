<?php

namespace CanddiAi\Lookup\Response\Item;

class SocialTest
    extends \CanddiAi\TestCase
{
    private $response;

    private function _getTestData()
    {
        return array(
            "platform" => "twitter",
            "url" => "https:\/\/twitter.com\/bartlorang",
            "handle" => "bartlorang",
        );
    }

    public function testType()
    {
        $response = new Social($this->_getTestData());

        $strExpectedType = "twitter";
        $strReturnedType = $response->getType();

        $this->assertEquals($strExpectedType, $strReturnedType);

    }

    public function testGetUsername()
    {
        $response = new Social($this->_getTestData());

        $strExpectedName = "bartlorang";
        $strReturnedName = $response->getUsername();

        $this->assertEquals($strExpectedName, $strReturnedName);
    }

    public function testGetURL()
    {
        $response = new Social($this->_getTestData());

        $strExpectedURL = "https:\/\/twitter.com\/bartlorang";
        $strReturnedURL = $response->getURL();

        $this->assertEquals($strExpectedURL, $strReturnedURL);
    }
}
