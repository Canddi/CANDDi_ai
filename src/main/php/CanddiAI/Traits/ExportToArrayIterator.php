<?php

trait Canddi_Traits_ExportToArrayIterator {
    /**
     * This iterates through each item in the iterator and returns an array
     * of each model
     *
     * @param   array of fields to return
     * @return  array (of array ;-)
     * @author  Tim Langley
     **/
    public function exportToArray(Array $arrJsonFields = array())
    {
        if(!$this instanceof Iterator) {
            throw new Canddi_Exception_Fatal_NotImplemented("Iterator");
        }
        if(!$this instanceof countable) {
            throw new Canddi_Exception_Fatal_NotImplemented("countable");
        }

        $arrExport = array();
        if (0 == $this->count()) {
            //If we don't have any models then return nothing
            return $arrExport;
        }

        try {
            foreach ($this AS $model) {
                $arrExport[] = $model->exportToArray($arrJsonFields);
            }
        } catch(Canddi_Exception_Fatal_ItemNotInIterator $e) {
            //This isn't critical - but it shouldn't be happening
            Canddi_Helper_Log::getInstance()->log(
                sprintf("Iterator::exportToArray - Item not in Itterator: ".$e->getMessage()),
                Zend_Log::NOTICE
            );
        }
        return $arrExport;
    }
}
