<?php
trait Canddi_Traits_HideOnDelete {
    public static function getHideOnDeleteModelFields()
    {
        return [
            self::FIELD_Hidden   => [
                "Type" => Canddi_Model_Abstract::UPDATE_TYPE_FIELD
            ]
        ];
    }
    public static function getHideOnDeleteJsonFields()
    {
        return [
            self::FIELD_Hidden => [
                Canddi_Interface_ExportToArray::EXPORT_TYPE => Canddi_Interface_ExportToArray::EXPORTTYPE_VALUE,
                Canddi_Interface_ExportToArray::EXPORT_FUNCTION =>"getHidden"
            ]
        ];
    }
    public function getHidden()
    {
        return $this->_getField(self::FIELD_Hidden, false);
    }
    public function getVisible()
    {
        return !$this->getHidden();
    }
    public function setHidden($bHidden)
    {
        $this->_setField(self::FIELD_Hidden, $bHidden);
    }
    public function removeChild()
    {
        $this->setHidden(true);
        $this->updateParent();
        return $this;
    }
    // Deletes the child, even when it is set to hide on delete
    public function deleteChild()
    {
        $this->_deleted = true;
        $this->updateParent();
        return $this;
    }
}
