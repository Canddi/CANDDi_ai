<?php

class Test_TraitsOutput
{
    use Canddi_Traits_Output;

    const TIME_CREATED          = "TimeCreated";

    public function __construct($strURL = "")
    {
        $this->_strURL  = $strURL;
    }
    /**
     * This returns an array of fields
     *
     * @return array
     * @author Tim Langley
     **/
    protected function _getOutputFields()
    {
        return [
            'URL'               => [
                Canddi_Interface_GetOutputValue::PARAM_METHOD   => '_getURL'
            ],
            'Post'              => [
                Canddi_Interface_GetOutputValue::PARAM_METHOD   => '_getPostItemFromParams'
            ],
            'BadFormatField'    => [],
            'KeyMethodNotExists'=> [
                Canddi_Interface_GetOutputValue::PARAM_METHOD   => '_getMethodNotExists'
            ],
            'TimeCreated'       => [
                Canddi_Interface_GetOutputValue::PARAM_METHOD   => 'getTimeCreated'
            ]
        ];
    }
    protected function _getURL(Canddi_Model_Local_Process_Params_Input $objParamsInput)
    {
        return $this->_throwIfValueBlocked($this->_strURL, $objParamsInput);
    }
    /**
     * Gets a path item from parameters
     *
     * @param Canddi_Model_Local_Process_Params_Input $objParamsInput
     * @return mixed
     * @author Dan Dart
     **/
    protected function _getPostItemFromParams(Canddi_Model_Local_Process_Params_Input $objParamsInput)
    {
        $arrOutput          = [
            "Base64Key"         => "c2FyYWguY2hhcHBlbGxAYWNjb3JkbWFya2V0aW5nLmNvbQ%3d%3d",
            "Base64KeyDouble"   => "c2FyYWguY2hhcHBlbGxAYWNjb3JkbWFya2V0aW5nLmNvbQ%253d%253d",
            "PostKey1"          => "PostKeyValue1",
            "FilterPostKey"     => "FilterPostKeyValue1",
            "PostKeyNeedsTrim" => "  PostKeyNeedsTrimValue  "
        ];
        return $this->_getItemFromArray($arrOutput, $objParamsInput);
    }
    public function getTimeCreated()
    {
        return self::TIME_CREATED;
    }
    //NOTE This is very naughty
    // I've assumed this trait is ALWAYS in a regular Model
    public function getAccountURL(){}
    public function getId(){}
}

class Canddi_Traits_OutputTest
    extends Canddi_TestCase
{
    public function testGetOutputValues_FAIL_InvalidValue()
    {
        $this->setExpectedException("Canddi_Exception_Fatal_InvalidValue");

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input");

        $traitOutput        = new Test_TraitsOutput();
        $traitOutput->getOutputValue('InvalidValue', $objParams1);
    }
    public function testGetOutputValues_FAIL_BadlyFormatedField()
    {
        $this->setExpectedException("Canddi_Exception_Fatal_InvalidValue");

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input");

        $traitOutput        = new Test_TraitsOutput();
        $traitOutput->getOutputValue('BadFormatField', $objParams1);
    }
    public function testGetOutputValues_FAIL_MethodNotExists()
    {
        $this->setExpectedException("Canddi_Exception_Fatal_MethodDoesNotExist");

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input");

        $traitOutput        = new Test_TraitsOutput();
        $traitOutput->getOutputValue('KeyMethodNotExists', $objParams1);
    }
    public function testGetOutputValues_WorksWithDefault()
    {
        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(false)
            ->mock();

        $traitOutput        = new Test_TraitsOutput();
        $this->assertEquals(
            Test_TraitsOutput::TIME_CREATED,
            $traitOutput->getOutputValue('TimeCreated', $objParams1)
        );
    }
    public function testGetOutputValues_WithRegularKeys()
    {
        $strKey             = "PostKey1";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn($strKey)
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(false)
            ->mock();

        $traitOutput        = new Test_TraitsOutput();
        $this->assertEquals(
            "PostKeyValue1",
            $traitOutput->getOutputValue('Post', $objParams1)
        );
    }
    public function testGetOutputValues_ShouldTrimBadShit()
    {
        $strKey             = "PostKeyNeedsTrim";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn($strKey)
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(false)
            ->mock();

        $traitOutput        = new Test_TraitsOutput();
        $this->assertEquals(
            "PostKeyNeedsTrimValue",
            $traitOutput->getOutputValue('Post', $objParams1)
        );
    }
    public function testGetOutputValues_Base64Decoded()
    {
        $strKey             = "Base64Key";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn($strKey)
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(true)
            ->mock();

        $traitOutput        = new Test_TraitsOutput();
        $this->assertEquals(
            "sarah.chappell@accordmarketing.com",
            $traitOutput->getOutputValue('Post', $objParams1)
        );

        //Also check double URL encoding
        //MAINT-2864
        $strKey             = "Base64KeyDouble";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn($strKey)
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(true)
            ->mock();

        $traitOutput        = new Test_TraitsOutput();
        $this->assertEquals(
            "sarah.chappell@accordmarketing.com",
            $traitOutput->getOutputValue('Post', $objParams1)
        );
    }
    public function testGetOutputValues_FAIL_WrongKey()
    {
        $this->setExpectedException("Canddi_Exception_Fatal_MissingProperty");

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn(true)
            ->mock();

        $traitOutput        = new Test_TraitsOutput();
        $this->assertEquals(
            "PostKeyValue1",
            $traitOutput->getOutputValue('Post', $objParams1)
        );
    }
    public function testGetOutputValues_WithFilterValue_Matches()
    {
        $strKey1             = "PostKey1";

        //This regex ONLY only matches
        // keys WITH FilterPostKey
        $strRequireValue    = "^(?!FilterPostKey).*$";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn($strKey1)
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn($strRequireValue)
            ->mock();

        $traitOutput        = new Test_TraitsOutput();

        try {
            $traitOutput->getOutputValue('Post', $objParams1);
            throw new Exception("TEST FAILED");
        } catch(Canddi_Exception_Notice_IgnoreInputField $e) {}


        $strKey2            = "FilterPostKey";

        $objParams2         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn($strKey2)
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn($strRequireValue)
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(false)
            ->mock();

        $this->assertEquals(
            "FilterPostKeyValue1",
            $traitOutput->getOutputValue('Post', $objParams2)
        );
    }
    public function testGetOutputValues_WithMatchValue_Matches()
    {
        $strKey1             = "PostKey1";

        //This regex ONLY only matches
        // keys WITH FilterPostKey
        $strRequireValue    = "^(?!FilterPostKey).*$";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn($strKey1)
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn($strRequireValue)
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(false)
            ->mock();

        $traitOutput        = new Test_TraitsOutput();


        $return             = $traitOutput->getOutputValue('Post', $objParams1);
        $this->assertEquals("PostKeyValue1", $return);


        $strKey2            = "FilterPostKey";

        $objParams2         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getKey')
            ->once()
            ->andReturn($strKey2)
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(false)
            ->mock();

        $this->assertEquals(
            "FilterPostKeyValue1",
            $traitOutput->getOutputValue('Post', $objParams2)
        );
    }
    public function testGetOutputValues_WithMatchValue_WierdURL_NotBlocked()
    {
        $strURL             = "http://www.cupapizarras.com/es";

        //This regex ONLY only matches
        // keys WITH FilterPostKey
        $strRequireValue    = "/es";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn($strRequireValue)
            ->shouldReceive('getBase64Decode')
            ->once()
            ->andReturn(false)
            ->mock();

        $traitOutput        = new Test_TraitsOutput($strURL);

        $return             = $traitOutput->getOutputValue('URL', $objParams1);
        $this->assertEquals($strRequireValue, $return);
    }
    public function testGetOutputValues_WithMatchValue_WierdURL_Blocked()
    {
        $strURL             = "http://www.cupapizarras.com/fs";

        //This regex ONLY only matches
        // keys WITH FilterPostKey
        $strRequireValue    = "/es";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn($strRequireValue)
            ->mock();

        $traitOutput        = new Test_TraitsOutput($strURL);

        try {
            $traitOutput->getOutputValue('URL', $objParams1);
            throw new Exception("FAILS");
        } catch(Canddi_Exception_Notice_IgnoreInputField $e) {}
    }
    public function testGetOutputValues_WithMatchValue_DoubleSlashes_Blocked()
    {
        $strURL             = "http://www.executiveheadhunters.co.uk/";

        //This regex ONLY only matches
        // keys WITH FilterPostKey
        $strRequireValue    = "\\/opportunities\\/";

        $objParams1         = Mockery::mock("Canddi_Model_Local_Process_Params_Input")
            ->shouldReceive('getFilterValue')
            ->once()
            ->andReturn("")
            ->shouldReceive('getMatchValue')
            ->once()
            ->andReturn($strRequireValue)
            ->mock();

        $traitOutput        = new Test_TraitsOutput($strURL);

        try {
            $traitOutput->getOutputValue('URL', $objParams1);
            throw new Exception("FAILS");
        } catch(Canddi_Exception_Notice_IgnoreInputField $e) {}
    }
}
