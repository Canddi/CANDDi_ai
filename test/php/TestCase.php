<?php

namespace CanddiAi;

class TestCase extends \Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->_postSetUp();
    }
    public function _postSetUp()
    {

    }
    public function isInIsolation()
    {
        return true;
    }
    /**
     * Make sure all necessary singletons and connections are blanked.
     *
     * @return void
     * @author Dan Dart
     **/
    public final function tearDown()
    {
        \Mockery::close();
        \Zend_Registry::_unsetInstance();

        Lookup\LookupAbstract::reset();
        $this->_setProtAttr(Lookup\LookupAbstract::class, '_guzzleConnection', null);

        $this->_postTearDown();

    }

    /**
     * Override this to add any extra tear down functionality
     *
     * @return void
     * @author Dan Dart
     **/
    protected function _postTearDown()
    {

    }

    /**
     * This function uses reflection to get the value of a Protected or Private attribute
     * This is useful for us to test the internal data structures
     *
     * @param string $obj
     * @param string $attr
     * @return mixed - the value
     * @author Dan Dart
     **/
    protected function _getProtAttr($obj, $attr)
    {
        $reflection = new \ReflectionClass($obj);
        $prop = $reflection->getProperty($attr);
        $prop->setAccessible(true);
        return $prop->getValue($obj);
    }
    /**
     * This function sets a static value
     *
     * @param string $obj
     * @param string $attr
     * @param string $value
     *
     * @author Tim Langley
     **/
    protected function _setProtAttr($obj, $attr, $value)
    {
        $reflectedClass     = new \ReflectionClass($obj);
        $reflectedProperty  = $reflectedClass->getProperty($attr);
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue($obj, $value);
    }
    /**
     * Use reflection again to invoke a protected or private method
     * Takes an optional arg
     *
     * @param string $obj
     * @param string $method
     * @param string $arg (optional)
     * @return the method's return value
     * @author Tim Langley
     **/
    protected function _invokeProtMethod($obj, $method, $arg = null, $arg2 = null)
    {
        $reflection = new \ReflectionClass($obj);
        $refMethod = $reflection->getMethod($method);
        $refMethod->setAccessible(true);
        return $refMethod->invoke($obj, $arg, $arg2);
    }
}
