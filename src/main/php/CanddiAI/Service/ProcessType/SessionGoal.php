<?php
class Canddi_Service_ProcessType_SessionGoal
    extends Canddi_Service_ProcessType_Abstract
{
    private $_modelSessionGoal;
    /**
     * Creates a Process Type SessionGoal
     *
     * @author Dan Dart
     **/
    public static function create(
        Canddi_Model_FirstOrder_SessionGoal_Abstract $modelSessionGoal,
        Canddi_Iterator_Cores $coreItems = null,
        $bSendTriggers = true
    ) {
        $ppaSessionGoal = new Canddi_Service_ProcessType_SessionGoal(
            $coreItems,
            $bSendTriggers
        );
        $ppaSessionGoal->_modelSessionGoal = $modelSessionGoal;
        return $ppaSessionGoal;
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
        //TODO This needs to load the ModelTracker OR ModelTrackerGoal
        //Delete the Process function
        //Throw a "save model message"
        Canddi_Helper_Log::getInstance()->log(
            "CURRENTLY NOT DELETING TRACKERGOAL OR AllGOALS PPA's"
        );
    }
    protected function _getAccountURL()
    {
        return $this->_modelSessionGoal->getAccountURL();
    }
    protected function _getBaseInputName()
    {
        return Canddi_Service_ProcessType_Abstract::PF_INPUT_SESSIONGOAL;
    }
    protected function _getBaseModel()
    {
        return $this->_modelSessionGoal;
    }
    protected function _getContactId()
    {
        return $this->_modelSessionGoal->getContactId();
    }
    protected function _getModelContact()
    {
        return Canddi_Gateway::getInstance()
                ->getContact(
                    $this->_getAccountURL(), $this->_bSendTriggers
                )
                ->getByContactGUID($this->_modelSessionGoal->getContactId());
    }
    protected function _getModelSession()
    {
        return Canddi_Gateway::getInstance()
                ->getSession($this->_getAccountURL())
                ->getById($this->_modelSessionGoal->getSessionGUID());
    }
    protected function _getModelSessionGoal()
    {
        return $this->_modelSessionGoal;
    }
    protected function _saveBaseModel($bSendTriggers = true)
    {
        Canddi_Gateway::getInstance()
            ->getSessionGoal($this->_getAccountURL())
            ->save($this->_modelSessionGoal);

        //Now this is a little shitty
        // BUT if the SessionGoal has changed then we need to update the last
        // SessionGoal saved on the Contact
        // This is for MAINT-2866
        try {
            $modelContact           = $this->_getModelContact();
        } catch(Canddi_Exception_Fatal_DaoItemNotFound $e) {
            //This is even stranger!
            // sometimes the Contact doesn't exist
            // in this instance we just revert to normal
            return;
        }

        $guidSGFromContact      = $modelContact->getLastSessionGoalId();
        $guidSGFromSG           = $this->_modelSessionGoal->getId();

        //Time is the
        if($guidSGFromContact   === $guidSGFromSG) {
            Canddi_Gateway::getInstance()
                ->getContact(
                    $this->_getAccountURL(), $this->_bSendTriggers
                )
                ->updateSummaryData(
                    $modelContact->getContactId(),
                    $modelContact->getCompanies(),
                    null,
                    $this->_modelSessionGoal,
                    0,
                    0,
                    0,
                    0
                );
        }

    }
}
