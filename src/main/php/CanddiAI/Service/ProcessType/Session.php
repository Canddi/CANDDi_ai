<?php
class Canddi_Service_ProcessType_Session
    extends Canddi_Service_ProcessType_Abstract
{
    private $_modelSession;
    /**
     * Creates a Process Type Session
     *
     * @author Dan Dart
     **/
    public static function create(
        Canddi_Model_FirstOrder_Session_Abstract $modelSession,
        Canddi_Iterator_Cores $coreItems = null,
        $bSendTriggers = true
    ) {
        $ppaSession     = new Canddi_Service_ProcessType_Session(
            $coreItems,
            $bSendTriggers
        );
        $ppaSession->_modelSession = $modelSession;
        return $ppaSession;
    }
    /**
     * This deletes the PPA
     * This is used in instances where one of the PPA conditions has
     * fatally failed (example a CRM Connection being deleted)
     *
     * This is different for each type hence abstract
    **/
    protected function _deletePPA($mixedPPAId)
    {
        //TODO This needs to load the ModelTracker
        //Delete the Process function
        //Throw a "save Tracker message"
        Canddi_Helper_Log::getInstance()->log(
            "CURRENTLY NOT DELETING SESSION PPA's"
        );
    }
    protected function _getAccountURL()
    {
        return $this->_modelSession->getAccountURL();
    }
    protected function _getBaseInputName()
    {
        return Canddi_Service_ProcessType_Abstract::PF_INPUT_SESSION;
    }
    protected function _getBaseModel()
    {
        return $this->_modelSession;
    }
    protected function _getContactId()
    {
        return $this->_modelSession->getContactId();
    }
    protected function _getModelContact()
    {
        return Canddi_Gateway::getInstance()
                ->getContact(
                    $this->_getAccountURL(), $this->_bSendTriggers
                )
                ->getByContactGUID($this->_modelSession->getContactId());
    }
    protected function _getModelSession()
    {
        return $this->_modelSession;
    }
    protected function _getModelSessionGoal()
    {
        throw new Canddi_Exception_Fatal_NotImplemented(__METHOD__);
    }
    protected function _saveBaseModel($bSendTriggers = true)
    {
        Canddi_Gateway::getInstance()
            ->getSession($this->_getAccountURL())
            ->save($this->_modelSession);
    }
}
