<?php

/**
 * @author Matty Glancy
 */

namespace CanddiAi\Traits;

class GetArrayValueTest
    extends \CanddiAi\TestCase
{
    public function testGetValue()
    {
        $arrData = ['Key' => ['Nested' => 'Value']];
        $arrKeys = ['Key', 'Nested'];
        $strDefault = 'Default';

        $instance = new Test_GetArrayValue();

        $return = $instance->getArrayValue($arrData, $arrKeys, $strDefault);

        $this->assertEquals($arrData['Key']['Nested'], $return);
    }
    public function testGetValue_Default()
    {
        $arrData = ['Key' => ['Nested' => 'Value']];
        $arrKeys = ['Key', 'Nested', 'Non-existent'];
        $strDefault = 'Default';

        $instance = new Test_GetArrayValue();

        $return = $instance->getArrayValue($arrData, $arrKeys, $strDefault);

        $this->assertEquals($strDefault, $return);
    }
}

class Test_GetArrayValue
{
    use GetArrayValue;

    public function getArrayValue(
        Array $arrData,
        Array $arrKeys,
        $mixedDefault = ""
    )
    {
        return $this->_getArrayValue($arrData, $arrKeys, $mixedDefault);
    }
}
