<?php

class Test_TraitsExportToArray
{
    use Canddi_Traits_ExportToArray;

    public function __construct()
    {

    }
}

class Canddi_Traits_ExportToArrayTest
    extends Canddi_TestCase
{
    // Tests that when a function doesn't exist on an object, export to array
    // can handle + return ""
    public function testExportFunctionDoesntExist()
    {
        $fakeInstance = new Test_TraitsExportToArray();
        $arrExported = $fakeInstance->exportToArray([
            "MissingFunction" => [
                \Canddi_Interface_ExportToArray::EXPORT_TYPE =>
                    \Canddi_Interface_ExportToArray::EXPORTTYPE_VALUE,
                \Canddi_Interface_ExportToArray::EXPORT_FUNCTION =>
                    "fakeFunctionDoesntExist"
            ]
        ]);
        $this->assertEquals(
            [
                "MissingFunction" => ""
            ],
            $arrExported
        );
    }
}
