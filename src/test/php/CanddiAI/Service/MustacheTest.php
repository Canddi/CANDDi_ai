<?php
class Canddi_Service_MustacheTest extends Canddi_TestCase
{
    public function _postSetUp()
    {
        Canddi_Service_Mustache::reset();
    }
    public function testRender()
    {
        $strMustache = 'Hello {{place}}!';
        $strExpected = 'Hello World!';
        $arrParams = array('place' => 'World');

        $strOut = Canddi_Service_Mustache::getInstance()
            ->render($strMustache, $arrParams);

        $this->assertEquals($strExpected, $strOut);
    }
    public function testRenderNoParams()
    {
        $strMustache = 'Hello {{place}}!';
        $strExpected = 'Hello {{place}}!';
        $arrParams = array();

        $strOut = Canddi_Service_Mustache::getInstance()
            ->render($strMustache, $arrParams);

        $this->assertEquals($strExpected, $strOut);
    }
    public function testRenderNoMustaches()
    {
        $strMustache = 'Hello World!';
        $strExpected = 'Hello World!';
        $arrParams = array('place' => 'World');

        $strOut = Canddi_Service_Mustache::getInstance()
            ->render($strMustache, $arrParams);

        $this->assertEquals($strExpected, $strOut);
    }
}
