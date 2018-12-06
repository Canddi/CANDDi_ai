<?php

namespace CanddiAi\Lookup\Response\Item;

class PhotoTest
    extends \CanddiAi\TestCase
{
    private $response;

    private function _getTestData()
    {
        return array(
            "URL" => "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/tim%40timlangley.me.uk\/image\/Foursquare.png",
            "Name" => "Foursquare",
            "IsPrimary" => true
        );
    }

    public function testBPrimary()
    {
        $response = new Photo($this->_getTestData());

        $this->assertTrue($response->bPrimary());
    }

    public function testGetName()
    {
        $response = new Photo($this->_getTestData());

        $strExpectedName = "Foursquare";
        $strReturnedName = $response->getName();

        $this->assertEquals($strExpectedName, $strReturnedName);
    }

    public function testGetURL()
    {
        $response = new Photo($this->_getTestData());

        $strExpectedURL = "https:\/\/s3-eu-west-1.amazonaws.com\/images.canddi.net\/tim%40timlangley.me.uk\/image\/Foursquare.png";
        $strReturnedURL = $response->getURL();

        $this->assertEquals($strExpectedURL, $strReturnedURL);
    }
}
