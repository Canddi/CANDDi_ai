<?php
trait Canddi_Traits_HasPPARun
{
    /**
     * Determine whether a PPA has run for this model
     *
     * @param Canddi_Model_Local_Process_Action_Abstract $modelProcess
     * @return bool
     * @author Dan Dart
     **/
    public function bHasPPARun(Canddi_Model_Local_Process_Action_Abstract $modelProcess)
    {
        $arrProcessedPPAs = $this->_getField(Canddi_Interface_PPABaseModel::FIELD_ARRAY_PROCESSEDPPAS, array());

        $strParentFieldName = $modelProcess->getPPAType();
        $strPPACId          = $modelProcess->getCId();

        return in_array($strParentFieldName.'_'.$strPPACId, $arrProcessedPPAs);
    }

    /**
     * Saves information about a PPA that has run
     *
     * @param Canddi_Model_Local_Process_Action_Abstract $modelProcess
     * @return void
     * @author Dan Dart
     **/
    public function setPPASuccess(Canddi_Model_Local_Process_Action_Abstract $modelProcess)
    {
        $strParentFieldName = $modelProcess->getPPAType();
        $strPPACId = $modelProcess->getCId();

        $strElement =  $strParentFieldName.'_'.$strPPACId;

        $this->_setFieldArray(Canddi_Interface_PPABaseModel::FIELD_ARRAY_PROCESSEDPPAS, $strElement);

        return $this;
    }
}
