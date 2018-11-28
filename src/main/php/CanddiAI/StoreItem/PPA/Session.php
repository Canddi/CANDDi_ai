<?php
class Canddi_StoreItem_PPA_Session
    extends Canddi_StoreItem_Abstract
{
    private $_modelSession;
    private $_bSendTriggers;

    /**
     * Creates using a SessionGoal
     *
     * @author Dan Dart
     **/
    public function __construct(
        Canddi_Model_FirstOrder_Session_Abstract $modelSession,
        $bSendTriggers = true
    )
    {
        $this->_modelSession = $modelSession;
        $this->_bSendTriggers= $bSendTriggers;
    }
    /**
     * This is a Singleton based on SessionId
     *
     * @return string
     *
     * @author Tim Langley
     **/
    public function getInstanceName() {
        return "PPA_Session:".$this->_modelSession->getId();
    }
    public function process()
    {
        $modelSession       = $this->_modelSession;

        if("Canddi_Model_FirstOrder_Session_Website" !== get_class($modelSession)) {
            //For now these PPA's are ONLY on Website Sessions
            return;
        }
        $strAccountURL      = $modelSession->getAccountURL();
        try {
            $modelTracker   = Canddi_Gateway::getInstance()
                    ->getTracker($strAccountURL)
                    ->getById($modelSession->getTrackerGUID());

            $base           = Canddi_Service::getInstance()->getProcess(
                $modelSession,
                null,
                $this->_bSendTriggers
            );
            $hDepends       = Canddi_Service::getInstance()->getDependencyHandler(
                $strAccountURL,
                $modelTracker->getProcessActions());

            $base->processPPAs($hDepends);
            return $modelSession;
        } catch(Exception $e) {
            //This is stupid! but we don't want failing PPA's to destroy other code
            Canddi_Helper_Log::getInstance()->log(
                "ActionPPAs Account (".$strAccountURL.") Session (".$modelSession->getId().") [".$e->getMessage()."]",
                Zend_Log::ERR
            );
        }
    }
}
