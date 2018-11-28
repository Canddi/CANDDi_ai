<?php
/**
 * @category
 * @package
 * @copyright  2011-06-05 (c) 2011 Campaign and Digital Intelligence (http://canddi.com)
 * @license
 * @author     Tim Langley
 **/

class Canddi_HelperTest extends Canddi_TestCase
{
    public function testCreateToken()
    {
        $strNewToken = Canddi_Helper::createToken();
        $this->assertRegexp('/^[0-9a-f]{32}$/', $strNewToken);
    }
    public function testIsUTF8()
    {
        $strTim         = "ValidString";
        $bReturn        = Canddi_Helper::isUTF8($strTim);
        $this->assertTrue($bReturn);

        $strTim         = base64_decode("DZ ZD0yRUEzRDQ4NDI0MzI2RUI4QTNFQzY4MjlBRjcxMz");
        $bReturn        = Canddi_Helper::isUTF8($strTim);
        $this->assertFalse($bReturn);
    }
    public function testToNumberInt()
    {
        $number = Canddi_Helper::toNumber('4');
        $this->assertEquals(4, $number);
        $this->assertTrue(is_int($number));
        $this->assertFalse(is_float($number));
        $this->assertTrue(is_numeric($number));
    }
    public function testToNumberFloat()
    {
        $number = Canddi_Helper::toNumber('4.2');
        $this->assertEquals(4.2, $number);
        $this->assertFalse(is_int($number));
        $this->assertTrue(is_float($number));
        $this->assertTrue(is_numeric($number));
    }
    public function testToNumberGigo()
    {
        $number = Canddi_Helper::toNumber('Gigo');
        $this->assertEquals(0, $number);
        $this->assertTrue(is_int($number));
        $this->assertFalse(is_float($number));
        $this->assertTrue(is_numeric($number));
    }
    public function testToUTF8Pound()
    {
        $strFrom = "\xa3";
        $strTo = "\xc2\xa3";
        $this->assertEquals($strTo, Canddi_Helper::toUTF8($strFrom));
    }
    public function testToUTF8()
    {
        // First we'll test normal string.
        $strExample = "kaltx\xc3\xac";
        $strUtf = 'kaltxì';

        $strResult = Canddi_Helper::toUTF8($strExample);

        $this->assertEquals($strResult, $strUtf);

        // now test multidimentinal arrays
        $arrTest = array(
            "kaltx\xc3\xac" => array(
                "Oe t\xc3\xa4txaw" => "kosman ma tsmuk\xc3\xa9!"
                ),
                "Ngey\xc3\xa4 key" => "lu h\xc3\xacyik srak?"
        );

        $arrExpected = array(
            'Kaltxì' => array(
                'Oe tätxaw' => 'kosman ma tsmuké!'
            ),
            'Ngeyä key' => 'lu hìyik srak?'
        );

        $arrResult = Canddi_Helper::toUTF8($arrExpected);

        $this->assertEquals($arrExpected, $arrResult);
    }
    public function testStrToLower_Recursive()
    {
        $o = new stdClass();

        $arrIn = [
            'hello' => [
                'Hello' => 123,
                'Goodbye' => 'ByeBye',
                'Object' => $o
            ]
        ];

        $arrOut = [
            'hello' => [
                'Hello' => 123,
                'Goodbye' => 'byebye',
                'Object' => $o
            ]
        ];

        $this->assertEquals($arrOut, Canddi_Helper::strtolower_recursive($arrIn));
    }
}
