<?php

/**
 * @author Matty Glancy
 */

namespace CanddiAi\Lookup;

class LookupAbstractTest
    extends \CanddiAi\TestCase
{
    public function testConstructor_MissingData()
    {
        $strBaseUri = 'baseuri.com';

        $this->setExpectedException(\Exception::class, 'Unable to create instance - Missing URL OR Key');

        Test_LookupAbstract::getInstance($strBaseUri, null);
    }
    public function testClone()
    {
        $strBaseUri = 'baseuri.com';
        $strApiKey = 'FAKE_API_KEY';

        $lookupAbstract = Test_LookupAbstract::getInstance($strBaseUri, $strApiKey);

        $this->setExpectedException(\Exception::class, 'Cannot clone');

        clone $lookupAbstract;
    }
    public function testGetGuzzle()
    {
        $strBaseUri = 'baseuri.com';
        $strApiKey = 'FAKE_API_KEY';

        $return = Test_LookupAbstract::getGuzzle($strBaseUri, $strApiKey);

        $this->assertInstanceOf('GuzzleHttp\Client', $return);
        $this->assertEquals($strBaseUri, $return->getConfig('base_uri'));
        $this->assertEquals($strApiKey, $return->getConfig('headers')['x-api-key']);
    }
    public function testInjectAndReset()
    {
        $mockLookup = \Mockery::mock('CanddiAi\Lookup\LookupAbstract');

        Test_LookupAbstract::inject($mockLookup);
        $instance = $this->_getProtAttr(Test_LookupAbstract::class, '_locater');

        $this->assertEquals($mockLookup, $instance);

        Test_LookupAbstract::reset();
        $instance = $this->_getProtAttr(Test_LookupAbstract::class, '_locater');

        $this->assertNull($instance);
    }
}


class Test_LookupAbstract
    extends LookupAbstract
{
    public static function getGuzzle($strBaseUri, $strApiKey) {
        return self::_getGuzzle($strBaseUri, $strApiKey);
    }
}
