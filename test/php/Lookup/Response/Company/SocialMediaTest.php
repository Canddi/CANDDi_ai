<?php
namespace CanddiAi\Lookup\Response\Company;

use \CanddiAi\TestCase as TestCase;

class SocialMediaTest
    extends TestCase
{
    private function _getTestData()
    {
        return [
            "url"       => "pinterest.com/canddi",
            "platform"  => "Pinterest",
            "handle"    => "canddi"
        ];
    }

    public function testGetters()
    {
        $innerSocial = new SocialMedia($this->_getTestData());

        $this->assertEquals(
            $this->_getTestData()['url'],
            $innerSocial->getUrl()
        );
        $this->assertEquals(
            $this->_getTestData()['platform'],
            $innerSocial->getPlatform()
        );
        $this->assertEquals(
            $this->_getTestData()['handle'],
            $innerSocial->getHandle()
        );
    }
}
