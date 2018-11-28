<?php
trait Canddi_Traits_CanBeManual
{
    public static function getCanBeManualModelFields()
    {
        return [
            self::FIELD_Manual   => [
                "Type" => Canddi_Model_Abstract::UPDATE_TYPE_FIELD
            ]
        ];
    }
    public static function getCanBeManualJsonFields()
    {
        return [
            self::FIELD_Manual => [
                Canddi_Interface_ExportToArray::EXPORT_TYPE => Canddi_Interface_ExportToArray::EXPORTTYPE_VALUE,
                Canddi_Interface_ExportToArray::EXPORT_FUNCTION =>"getManual"
            ]
        ];
    }
    public function getManual()
    {
        return $this->_getField(self::FIELD_Manual, false);
    }
    public function setManual($bManual = true)
    {
        $this->_setField(self::FIELD_Manual, $bManual);
    }
}
