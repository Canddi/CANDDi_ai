<?php
/**
 * This is the actual PPA class that loops through the available processes and runs them.
 * This is the PROCESSOR not the child - it takes in the child iterator
 *
 * @package default
 * @author Dan Dart
 **/
abstract class Canddi_Service_ProcessType_Abstract
{
    const PF_INPUT_CONTACT          = "Contact";
    const PF_INPUT_SESSION          = "Session";
    const PF_INPUT_SESSIONGOAL      = "SessionGoal";


    const OUTPUT_CONTACT            = 'Contact';
    const OUTPUT_CONTACT_WIDGETDATA = 'ContactWidgetData';

    /**
     * Holds all the Cores which have come from processing previous
     * PPA's.  If you specify an OutputName on the Output type then this
     * is where it will be stored before being merged into the Inputs
     *
     * @var Canddi_Iterator_Cores
     **/
    private     $_ittCores_ForOutputItems;
    /**
     * Used when reprocessing - should we send any trigger notifications?
     *
     * @var boolean
     **/
    protected     $_bSendTriggers;
    /**
     * Creates a Process Contact
     *
     * @author Tim Langley
     **/
    protected function __construct(
        Canddi_Iterator_Cores       $coreItems  = null,
        $bSendTriggers                          = true
    )
    {
        $this->_ittCores_ForOutputItems = is_null($coreItems)?
            new Canddi_Iterator_Cores():
            $coreItems;
        $this->_bSendTriggers   = $bSendTriggers;
    }
    /**
     * This deletes the PPA
     * This is used in instances where one of the PPA conditions has
     * fatally failed (example a CRM Connection being deleted)
     *
     * This is different for each type hence abstract
    **/
    abstract protected function _deletePPA($mixedPPAId);
    abstract protected function _getAccountURL();
    abstract protected function _getBaseModel();
    /**
     * Gets the relevant Output Item
     *
     * Output Items must support Canddi_Interface_PPAOutputModel
     *
     * NOTE :  This should really be a private method
     *         However it's public so that we can test this in each child
     *
     * @param $helperCoreItem
     *
     * @return Canddi_Interface_PPAOutputModel
     * @throws Canddi_Exception_Fatal_InvalidCoreClass
     * @throws Canddi_Exception_Fatal_InvalidType
     *
     * @author Tim Langley
     **/
    public function getOutputModelBySaveToTypeAndCores(
        Canddi_Helper_Response_ProcessSaveToCore $helperCoreItem
    )
    {
        $strType    = $helperCoreItem->getOutputType();
        switch ($strType) {
            case Canddi_Service_ProcessType_Abstract::OUTPUT_CONTACT:

                return $this->_getModelContact();

            case Canddi_Service_ProcessType_Abstract::OUTPUT_CONTACT_WIDGETDATA:
                switch($helperCoreItem->getCoreClass()) {

                    case "Canddi_Core_LeadScore":
                        $daoExisting    = new Canddi_Dao_CreateExisting();
                        return Canddi_Model_SecondOrder_Contact_Widgets_LeadScore::setDataFromDAO(
                            $daoExisting,
                            []
                        );
                    default:
                        throw new Canddi_Exception_Fatal_InvalidCoreClass(
                            "Contact_WidgetData",
                            "requires: Core_LeadScore"
                        );
                }
            default:
                throw new Canddi_Exception_Fatal_InvalidType($strType);
        }
    }
    abstract protected function _getContactId();
    abstract protected function _getModelContact();
    abstract protected function _getModelSession();
    abstract protected function _getModelSessionGoal();
    /**
     * Gets the relevant Input Item
     *
     * Input items must support Canddi_Interface_IsInputType
     *
     * NOTE :  This should really be a private method
     *         However it's public so that we can test this in each child
     *
     * @param string $strType
     *
     * @return Canddi_Interface_IsInputType
     * @throws Canddi_Exception_Fatal_InvalidType
     *
     * @author Tim Langley
     **/
    public function _getInputItemBySource($strSource)
    {
        switch ($strSource) {
            case Canddi_Model_Local_Process_Input::SOURCE_CONTACT:
                return $this->_getModelContact();
            case Canddi_Model_Local_Process_Input::SOURCE_SESSION:
                return $this->_getModelSession();
            case Canddi_Model_Local_Process_Input::SOURCE_SESSIONGOAL:
                return $this->_getModelSessionGoal();
            default:
                throw new Canddi_Exception_Fatal_InvalidType($strSource);
        }
    }
    /**
     * This function converts the $modelPPA->getInputs()
     *   an Canddi_Iterator<Canddi_Model_Local_Process_Input>
     *   into Canddi_Iterator_Cores
     *
     * @param   Canddi_Iterator<Canddi_Model_Local_Process_Input> $ittInputs
     *
     * @return  Canddi_Iterator_Cores
     *
     * @throws  Canddi_Exception_Fatal_InvalidType from _getInputItemBySource
     *              - This is ultimately a development problem
     *              - Bad Data in the Source field
     *
     * @throws  Canddi_Exception_Fatal_ItemExists (from $coreItemsInput->addCoreItem)
     *              - this happens if a duplicate
     *              - this should NEVER be possible because it's taking the Key
     *
     * @throws  Canddi_Exception_Notice_InvalidInput
     *              - This happens if the Input isn't valid
     *              - Therefore we should stop processing this PPA
    **/
    private function _prepareInputs(
        Canddi_Iterator_Interface $ittInputs,
        Canddi_Iterator_Cores $ittInputsFromOutputs
    )
    {
        $coreItemsInput     = new Canddi_Iterator_Cores();
        foreach ($ittInputs as $modelInput) {
            $hashInputParams= $modelInput->getParams();
            $strType        = $modelInput->getType();

            //This is where we get the InputModels
            switch ($strType) {
                case Canddi_Model_Local_Process_Input::TYPE_TEXT:
                    $mixedValue     = $modelInput->getText();
                    break;
                case Canddi_Model_Local_Process_Input::TYPE_FIELD:

                    $mixedDataItem  = $this->_getInputItemBySource(
                        $modelInput->getSource()
                    );

                    // Get the correct OutputValue
                    try {
                        $mixedValue = $mixedDataItem->getOutputValue(
                            $modelInput->getRef(),
                            $hashInputParams
                        );
                    } catch (Canddi_Exception_Ignore $e) {
                        Canddi_Helper_Log::getInstance()->debug(
                            $e->getMessage()
                        );
                        $mixedValue = "";
                    } catch(Canddi_Exception_Notice $e) {
                        Canddi_Helper_Log::getInstance()->logException(
                            $e, Zend_Log::DEBUG
                        );
                        //We can't find the value
                        //or some problem has occured
                        $mixedValue = "";
                    } catch(Exception $e) {
                        if(!$e instanceOf Canddi_Exception_Fatal_MissingProperty) {
                            //We don't need to log MissingProperties
                            Canddi_Helper_Log::getInstance()->logException($e);
                        }
                        //We can't find the value
                        //or some problem has occured
                        $mixedValue = "";
                    }

                    break;
                case Canddi_Model_Local_Process_Input::TYPE_DATAITEM:
                    $mixedValue     = $this->_getInputItemBySource(
                        $modelInput->getSource()
                    );
                    break;
                default:
                    try {
                        $mixedValue     = $ittInputsFromOutputs
                            ->getByName($modelInput->getOutputName())
                            ->getValue();
                    } catch(Exception $e) {
                        //We can't find the value
                        // or some problem has occured
                        $mixedValue     = "";
                    }
                    break;
            }

            // Ensure that the Value we have is correct
            // Check if the value obtained is allowed or blocked
            //
            if(
                in_array(
                    $mixedValue, $modelInput->getIgnoreValues()
                )
            ) {
                $mixedValue = "";
            }

            $bOptionalInput = $hashInputParams->getOptional();

            //Now our options are as follows:
            //1. This is an Optional Value and Ignored
            //2. This is a Required Value and Empty (we should error)
            //        [this is same as Required and Ignored]
            if(!$bOptionalInput && empty($mixedValue)) {
                //We should Ignore this value BUT the Input is Requried
                throw new Canddi_Exception_Notice_InvalidInput(
                    get_called_class()
                );
            }

            $strKey         = $modelInput->getCId();
            $coreItem       = Canddi_Helper_PPAInputType::create(
                $mixedValue
            );
            $coreItemsInput->addCoreItem($strKey, $coreItem);
        }

        // TL: This is a MASSIVE HACK
        // Now if we have a SessionGoalPPA then we will ALWAYS
        // get the Model SessionGoal passed in as an input
        // with the Core Id of
        // Canddi_Service_ProcessType_Abstract::PF_INPUT_SESSIONGOAL
        // (
        //  Slightly more general now - a ContactPPA will always have a Contact
        //  etc....)
        $mixedValue     = $this->_getBaseModel();
        $coreItem       = Canddi_Helper_PPAInputType::create(
            $mixedValue
        );
        try {
            $coreItemsInput->addCoreItem(
                $this->_getBaseInputName(),
                $coreItem
            );
        } catch(Canddi_Exception_Fatal_ItemExists $e) {
            //We don't really care here - basically means the SG is already
            // in the list
        }

        return $coreItemsInput;
    }

    /**
     * Process the PPAs
     *
     * @param   Canddi_Iterator_Process_Handler $hDepends This is a special type of itterator
     * @return  integer     //NOTE the return value dosen't mean anything - it's used for testing only
     * @author  Tim Langley
     **/
    public function processPPAs(
        Canddi_Iterator_Process_Handler $hDepends
    )
    {
        if (0 === count($hDepends)) {
            return 1;
        }

        $objSave            = new Canddi_Iterator_Process_Save();

        while ($modelPPA    = $hDepends->getNext()) {

            //This litte check stops us running PPA's again
            if(
                false === $this->_bSendTriggers &&
                false === $modelPPA->getParams()->getRunOnReprocess()
            ) {
                //This is a "success"
                $hDepends->setOK($modelPPA);
                $this->_getBaseModel()->setPPASuccess($modelPPA);
                continue;
            }

            $pf             = $modelPPA->getFunction();

            //This step we prepare the Inputs
            // the $coreItemsInput will EITHER BE PERFECT
            // or all will be rejected
            try {
                //Prepare the inputs
                $coreItemsInput     = $this->_prepareInputs(
                    $modelPPA->getInputs(),
                    $this->_ittCores_ForOutputItems
                );

                //Run the actual transform into a Result
                $modelParams        = $modelPPA->getParams();
                $Result             = $pf->transform(
                    $coreItemsInput, $modelParams
                );
            } catch (Canddi_ProcessFunction_Exception_DeletePPA $e) {
                //This is a very special type of error
                //We need to find the object which created this
                // and then perform the delete by PPAId
                Canddi_Helper_Log::getInstance()->log(
                    "DELETE PPA Account:[".$this->_getAccountURL()."] ".
                    " PPAId ".$modelPPA->getId(),
                    Zend_Log::ERR
                );
                $this->_deletePPA($modelPPA->getId());
                continue;
            } catch (Canddi_Exception_Ignore $e) {
                Canddi_Helper_Log::getInstance()->debug($e->getMessage());
                continue;
            } catch (Canddi_Exception_Notice $e) {
                $hDepends->setNotice($modelPPA, $e);
                continue;
            } catch (Exception $e) {
                $hDepends->setError($modelPPA, $e);
                continue;
            }

            //Deal with OutputNames
            //Save process the Result according to the outputs
            $ittOutputs         = $modelPPA->getOutputs();
            $arrTypesWithNames  = [];
            foreach ($ittOutputs as $modelOutput) {
                $strOutputName  = $modelOutput->getName();
                if ( !empty($strOutputName) ) {
                    $strType    = $modelOutput->getType();
                    $arrCoreResult = $Result
                        ->getCoreItemByOutput($strType);

                    //If the output has a name - then save it to the OutputItems
                    if ( !empty($arrCoreResult) ) {
                        $this->_ittCores_ForOutputItems->addCoreItem(
                            $strOutputName,
                            $arrCoreResult[\Canddi_Iterator_Process_Result::FIELD_CORE],
                            !$arrCoreResult[\Canddi_Iterator_Process_Result::FIELD_DELETE]
                        );
                    }

                    $arrTypesWithNames[] = $strType;
                }
            }

            //Iterate over stuff in the $Result
            $arrCoresFromResult       = $Result->getCores();
            foreach ($arrCoresFromResult as $coreArr) {
                $coreItem = $coreArr[\Canddi_Iterator_Process_Result::FIELD_CORE];
                if (
                    $modelPPA->bCanSaveMultiple() ||
                    !$this->_getBaseModel()->bHasPPARun($modelPPA)
                ) {
                    $strCoreClass       = get_class($coreItem);

                    //Now here's where we get a bit clever!
                    //These classes need additional saves
                    switch($strCoreClass) {
                        case "Canddi_Core_Company":
                            $modelSOCompany = Canddi_Gateway::getInstance()
                                ->getCompany($this->_getAccountURL())
                                ->getOrCreateCompany(
                                    $coreItem,
                                    $this->_getModelContact(),
                                    !$coreArr[\Canddi_Iterator_Process_Result::FIELD_DELETE]
                                );
                            $strModelCompanyId = $modelSOCompany->getId();
                            $coreItem->setId($strModelCompanyId);
                            break;
                        case "Canddi_Core_LeadScore":
                            $objSave->addCoreToSave(
                                $coreItem,
                                self::OUTPUT_CONTACT_WIDGETDATA,
                                !$coreArr[\Canddi_Iterator_Process_Result::FIELD_DELETE],
                                $coreArr[\Canddi_Iterator_Process_Result::FIELD_MANUAL],
                                $Result->intQualityScoreResponse()
                            );
                            break;
                        default:
                    }

                    //Everything gets saved to the Contact
                    $objSave->addCoreToSave(
                        $coreItem,
                        self::OUTPUT_CONTACT,
                        !$coreArr[\Canddi_Iterator_Process_Result::FIELD_DELETE],
                        $coreArr[\Canddi_Iterator_Process_Result::FIELD_MANUAL],
                        $Result->intQualityScoreResponse()
                    );
                }
            }

            $hDepends->setOK($modelPPA);
            $this->_getBaseModel()->setPPASuccess($modelPPA);
        }

        foreach ($objSave->getItems() as $arrSaveToItems) {
            foreach ($arrSaveToItems as $helperCoreItem) {
                $strType        = $helperCoreItem->getOutputType();
                //This is where we get the Output Model(s)
                try {
                    $model      = $this->getOutputModelBySaveToTypeAndCores(
                        $helperCoreItem
                    );

                    $model->updateFromCore(
                        $helperCoreItem,
                        $this->_getContactId(),
                        $this->_bSendTriggers
                    );

                    switch($strType) {
                        case Canddi_Service_ProcessType_Abstract::OUTPUT_CONTACT:
                            Canddi_Gateway::getInstance()
                                ->getContact(
                                    $this->_getAccountURL(),
                                    $this->_bSendTriggers
                                )
                                ->save(
                                    $model,
                                    true,
                                    $this->_bSendTriggers
                                );
                            break;
                        case Canddi_Service_ProcessType_Abstract::OUTPUT_CONTACT_WIDGETDATA:
                            Canddi_Gateway::getInstance()
                                ->getContactWidget(
                                    $this->_getAccountURL(),
                                    $model->getWidgetType()
                                )
                                ->save(
                                    $this->_getContactId(),
                                    $model
                                );
                            break;
                        default:
                            Canddi_Helper_Log::getInstance()->log(
                                "PPA Processing Problem - ".
                                "Unable to save Model of type ($strType) ".
                                get_class($model),
                                Zend_Log::ERR
                            );
                    }
                } catch(Exception $e) {
                    //No point in logging a CoreNotSupported
                    if (
                        !($e instanceOf Canddi_Exception_Ignore_CoreNotSupported)
                    ) {
                        Canddi_Helper_Log::getInstance()->logException($e);
                    }
                }
            }
        }

        //Finally we can save the actual model
        try {
            $this->_saveBaseModel($this->_bSendTriggers);
        } catch (Exception $e) {
            Canddi_Helper_Log::getInstance()->logException($e);
        }

        $hDepends->logAppropriately();
        return 2;
    }
    abstract protected function _saveBaseModel($bSendTriggers = true);
}
