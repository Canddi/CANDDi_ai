<?php

/**
 * @author Matty Glancy
 */

namespace CanddiAi\Traits;

use CanddiAi\Singleton\InterfaceSingleton;

class Test_Singleton
    implements InterfaceSingleton
{
    use TraitSingleton;
}

class TraitSingletonTest
    extends \CanddiAi\TestCase
{
    protected function _postTearDown()
    {
        Test_Singleton::reset();
    }
    public function testGetInstance_Fail()
    {
        $this->setExpectedException("Exception");
        Test_Singleton::getInstance();
    }
    public function testGeneral()
    {
        $strURL     = "https://testurl";
        $strAPI     = md5(1);

        $singletonInstance = Test_Singleton::getInstance(
            $strURL,
            $strAPI
        );
        $this->assertTrue($singletonInstance instanceOf Test_Singleton);

        Test_Singleton::inject($singletonInstance);

        $this->assertEquals($singletonInstance, Test_Singleton::getInstance());
    }
}

