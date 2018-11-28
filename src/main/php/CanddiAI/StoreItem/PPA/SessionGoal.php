<?php
class Canddi_StoreItem_PPA_SessionGoal
    extends Canddi_StoreItem_Abstract
{
    const   SG_PPA_ONE_TG   = 1;
    const   SG_PPA_ALL_TG   = 2;
    const   SG_PPA_ALL      = 15;

    private $_bitFlags      = self::SG_PPA_ALL;
    private $_modelSessionGoal;
    private $_bSendTriggers;

    /**
     * Creates using a SessionGoal
     *
     * @param   $modelSessionGoal
     * @param   $bitFlags   bit field of SG_PPA_xxx
     *
     * @author Tim Langley
     **/
    public function __construct(
        Canddi_Model_FirstOrder_SessionGoal_Abstract $modelSessionGoal,
        $bitFlags                   = self::SG_PPA_ALL,
        $bSendTriggers              = true
    ) {
        $this->_modelSessionGoal    = $modelSessionGoal;
        $this->_bitFlags            = $bitFlags;
        $this->_bSendTriggers       = $bSendTriggers;
    }
    /**
     * This is a Singleton based on SessionGoalId
     *
     * @return string
     *
     * @author Tim Langley
     **/
    public function getInstanceName() {
        return "PPA_SessionGoal:".$this->_modelSessionGoal->getId();
    }
    public function process()
    {
        $modelSessionGoal           = $this->_modelSessionGoal;
        if (!$modelSessionGoal->shouldProcessPPAs()) {
            return;
        }
        if (is_null($modelSessionGoal->getContactId())) {
            return;
        }

        $guidTrackerGoal            = $modelSessionGoal->getTrackerGoalId();
        if (empty($guidTrackerGoal)) {
            return;
        }

        $strAccountURL              = $modelSessionGoal->getAccountURL();
        $intHelperTypeId            = $modelSessionGoal->getSessionGoalTypeId();

        try {
            $modelTrackerGoal       = Canddi_Gateway::getInstance()
                ->getTrackerGoal($strAccountURL, $intHelperTypeId)
                ->getByTrackerGoalId($guidTrackerGoal);
        } catch(Canddi_Exception_Fatal_DaoItemNotFound $e) {
            //If the TrackerGoal isn't found
            // then just exit anyway (just don't fall over)
            Canddi_Helper_Log::getInstance()->log(
                "ActionPPAs $strAccountURL SessionGoal (".
                    $modelSessionGoal->getId().") [".$e->getMessage()."]",
                Zend_Log::ERR
            );
            return;
        }

        if( true == ($this->_bitFlags & self::SG_PPA_ALL_TG)) {
            $guidTracker            = $modelTrackerGoal->getTrackerGUID();
            $modelTracker           = Canddi_Gateway::getInstance()
                ->getTracker($strAccountURL)
                ->getById($guidTracker);
        }

        if(true == ($this->_bitFlags & self::SG_PPA_ONE_TG)) {
            try {
                $ittPPAs            = $modelTrackerGoal->getProcessActions();

                $base               = Canddi_Service::getInstance()->getProcess(
                    $modelSessionGoal,
                    null,
                    $this->_bSendTriggers
                );
                $hDepends           = Canddi_Service::getInstance()
                    ->getDependencyHandler(
                        $strAccountURL,
                        $ittPPAs
                    );
                $base->processPPAs($hDepends);
            } catch(Exception $e) {
                //This is stupid! but we don't want failing PPA's to
                //destroy other code
                Canddi_Helper_Log::getInstance()->log(
                    "ActionPPAs $strAccountURL SessionGoal (".
                        $modelSessionGoal->getId().") [".$e->getMessage()."]",
                    Zend_Log::ERR
                );
            }
        }

        if( true == ($this->_bitFlags & self::SG_PPA_ALL_TG) ) {
            try {
                $base               = Canddi_Service::getInstance()->getProcess(
                    $modelSessionGoal,
                    null,
                    $this->_bSendTriggers
                );
                $hDepends           = Canddi_Service::getInstance()
                    ->getDependencyHandler(
                        $strAccountURL,
                        $modelTracker->getAllGoalsProcessActions()
                    );
                $base->processPPAs($hDepends);
            } catch(Exception $e) {
                //This is stupid! but we don't want failing PPA's
                // to destroy other code
                Canddi_Helper_Log::getInstance()->log(
                    "ActionAllTGPPAs $strAccountURL SessionGoal (".
                        $modelSessionGoal->getId().") [".$e->getMessage()."]",
                    Zend_Log::ERR
                );
            }
        }
    }
}
