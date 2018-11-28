<?php

trait Canddi_Traits_ExportToArray {
    /**
     * Converts ModelFields into an ExportToArray function
     * NOTE : This requires that each ModelFields has a
     *            'Type'
     *            'Function'
     *
     * @return array
     *
     * @author Tim Langley
    **/
    public static function ConvertFieldsToExport(Array $arrFields)
    {
        $arrLocalFields     = [];
        foreach($arrFields as $strKey => $arrField) {
            $arrLocalField  = [];
            $strType        = $arrField[Canddi_Helper_ModelField::KEY_Type];

            if(isset($arrField[Canddi_Helper_ModelField::KEY_SkipFromExport])) {
                continue;
            }
            if(!isset($arrField[Canddi_Helper_ModelField::KEY_Function])) {
                throw new Exception("Missing Function in ($strKey) ".__CLASS__);
            }
            if(isset($arrField[Canddi_Helper_ModelField::KEY_OutputKey])) {
                $strKey     =  $arrField[Canddi_Helper_ModelField::KEY_OutputKey];
            }
            switch($strType) {
                case Canddi_Model_Abstract::UPDATE_TYPE_FIELD:
                case Canddi_Model_Abstract::UPDATE_TYPE_FIELDDATE:
                case Canddi_Model_Abstract::UPDATE_TYPE_FIELDID:
                case Canddi_Model_Abstract::UPDATE_TYPE_FIELDOBJECT:
                    $arrLocalField  = [
                        Canddi_Interface_ExportToArray::EXPORT_TYPE     => Canddi_Interface_ExportToArray::EXPORTTYPE_VALUE,
                        Canddi_Interface_ExportToArray::EXPORT_FUNCTION => $arrField[Canddi_Helper_ModelField::KEY_Function]
                    ];
                    break;
                default:
                    throw new Exception("Invalid Type ($strType) ($strKey) ".__CLASS__);
            }

            $arrLocalFields[$strKey]       = $arrLocalField;
        }
        return $arrLocalFields;
    }

    //This is a little hack function for the HashReferrer
    //if you return true then this will skip the Export to Array and return an array
    protected function _bSkipExportToArray() {
        return false;
    }

    //THIS IS A SAFETY FUNCTION FOR NOW
    public function getJsonFields()
    {
        // This died with self on Models
        // We should delete this quite quickly
        return static::GET_JsonFields();
    }
    /**
     * This decodes a single Mustache field
     *
     * @param array $arrField
     * @return array
     * @author Tim Langley
     * @author Dan Dart
     **/
    private function _jsonField($strType, Array $arrField)
    {
        if (
            !isset($arrField[Canddi_Interface_ExportToArray::EXPORT_FUNCTION])
        ) {
            throw new Canddi_Exception_Fatal_ValueCantBeNull(
                Canddi_Interface_ExportToArray::EXPORT_FUNCTION
            );
        }
        $arrJsonFields          = [];

        switch ($strType) {
            case Canddi_Interface_ExportToArray::EXPORTTYPE_CHILD:
            {
                $fnToGet        = $arrField[Canddi_Interface_ExportToArray::EXPORT_FUNCTION];
                //We should remove this optional check soon s.t. no longer runs E.A
                if( isset($arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS])) {
                    if(
                        is_string($arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS]) &&
                        isset($arrField[Canddi_Interface_ExportToArray::EXPORT_CHILD_CLASS])
                    ) {
                        $strChildClass      = $arrField[Canddi_Interface_ExportToArray::EXPORT_CHILD_CLASS];
                        $strChildFunction   = $arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS];
                        $arrJsonFields      = $strChildClass::$strChildFunction();
                    }

                    if( is_array($arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS])) {
                        $arrJsonFields      = $arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS];
                    }
                }

                $fn             = $this->$fnToGet();

                return $fn->exportToArray($arrJsonFields);
            }
            case Canddi_Interface_ExportToArray::EXPORTTYPE_ITERATOR:
            case Canddi_Interface_ExportToArray::EXPORTTYPE_ITERATOR_HASH:
            {
                $fnToGet    = $arrField[Canddi_Interface_ExportToArray::EXPORT_FUNCTION];
                $iterator   = $this->$fnToGet();
                if (!($iterator instanceof Canddi_Iterator_Interface)) {
                    throw new Canddi_Exception_Fatal_InvalidValue(
                        $strType,
                        Canddi_Interface_ExportToArray::EXPORTTYPE_ITERATOR
                    );
                }

                $arrItems                           = [];
                if (!$iterator->isEmpty()) {
                    foreach ($iterator AS $arrItem) {
                        $arrOutputItem              = null;

                        if(
                            isset($arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS])
                        ) {
                            if(
                                is_string($arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS])
                            ) {
                                $strChildClass      = get_class($arrItem);
                                $strMethod          = $arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS];
                                $arrJsonFields      = $strChildClass::$strMethod();
                            }
                            if(
                                is_array($arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS])
                            ) {
                                $arrJsonFields      = $arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_JSONFIELDS];
                            }
                        }
                        if (isset($arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_FILTERFUNCTION])) {
                            $strFilterFunction      = $arrField[Canddi_Interface_ExportToArray::EXPORT_ITERATOR_FILTERFUNCTION];
                            $bMethodExists          = method_exists($arrItem, $strFilterFunction);
                            $bReturnTrue            = false;
                            if($bMethodExists) {
                                $bReturnTrue        = $arrItem->$strFilterFunction();
                            }

                            if(
                                ($bMethodExists && $bReturnTrue) ||
                                !$bMethodExists
                            ) {
                                $arrOutputItem      = $arrItem->exportToArray($arrJsonFields);
                            }
                        } else {
                            $arrOutputItem          = $arrItem->exportToArray($arrJsonFields);
                        }

                        if(!empty($arrOutputItem)) {
                            if(Canddi_Interface_ExportToArray::EXPORTTYPE_ITERATOR_HASH === $strType) {
                                $arrItems[$arrItem->getCId()]   = $arrOutputItem;
                            } else {
                                $arrItems[]   = $arrOutputItem;
                            }
                        }

                    }
                }
                return $arrItems;
            }
            case Canddi_Interface_ExportToArray::EXPORTTYPE_VALUE:
            {
                $fnToGet = $arrField[Canddi_Interface_ExportToArray::EXPORT_FUNCTION];
                if(method_exists($this, $fnToGet) === false) {
                    return "";
                }
                return $this->$fnToGet();
            }
            default:
                throw new Canddi_Exception_Fatal_InvalidType(__METHOD__."[".$strType."]");
        }
    }

    /**
     *
     * @param   array of fields to return
     * @return  array
     * @author Tim Langley
     **/
    public function exportToArray(Array $arrJsonFields = array())
    {
        //This is a hack for the ReferrerHash
        if(true === $this->_bSkipExportToArray()) {
            return array();
        }

        $arrJsonFields = empty($arrJsonFields) ? $this->getJsonFields() : $arrJsonFields;
        if (!is_array($arrJsonFields)) {
            throw new Canddi_Exception_Fatal_ValueCantBeNull("JsonFields");
        }

        $arrData = array();
        foreach ($arrJsonFields AS $key => $arrField) {
            if (!isset($arrField[Canddi_Interface_ExportToArray::EXPORT_TYPE])) {
                throw new Canddi_Exception_Fatal_ValueCantBeNull(
                    Canddi_Interface_ExportToArray::EXPORT_TYPE
                );
            }
            $strType            = $arrField[
                Canddi_Interface_ExportToArray::EXPORT_TYPE
            ];
            $arrReturn          = $this->_jsonField($strType, $arrField);

            $arrData[$key]  = $arrReturn;
        }
        return $arrData;
    }
}
