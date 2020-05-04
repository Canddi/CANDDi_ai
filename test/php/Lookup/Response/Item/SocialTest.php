<?php

namespace CanddiAi\Lookup\Response\Item;

class SocialTest
    extends \CanddiAi\TestCase
{
    private $response;

    private function _getTestData()
    {
        return array(
            "bio" => "CEO & Co-Founder of @FullContact, Managing Director @v1vc_. Tech Entrepreneur, Investor. Husband to @parkerbenson and Father to Greyson Lorang",
            "followers" => 5454,
            "following" => 741,
            "type" => "twitter",
            "platform" => "twitter",
            "typeName" => "Twitter",
            "url" => "https:\/\/twitter.com\/bartlorang",
            "username" => "bartlorang",
            "id" => "5998422"
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
