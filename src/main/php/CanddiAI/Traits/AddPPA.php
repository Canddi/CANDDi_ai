<?php
trait Canddi_Traits_AddPPA
{
    /**
     * Provides parsing / adding of PPA's to a base Model
     *
     * @return $this (fluent)
     **/
    protected function _addPPAs(
        $strBasePPAType,
        Array $arrPPAStructure = []
    )
    {
        foreach ($arrPPAStructure as $strPPAId => $arrPPA) {

            //Firstly make the PPA
            if (
                is_int($strPPAId)
            ) {
                if (!isset($arrPPA[Canddi_Model_Local_Process_Action_Abstract::OUTPUT_FIELD_PPAId])) {
                    throw new Exception("PPA Array incorrectly formatted [Missing PPAId] ".print_r($arrPPA,true));
                }

                $strPPAId   = $arrPPA[Canddi_Model_Local_Process_Action_Abstract::OUTPUT_FIELD_PPAId];
            }

            if (
                !isset($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_Type])
            ) {
                throw new Exception("PPA Array incorrectly formatted [Missing PPA Type] ".print_r($arrPPA,true));
            }

            if (
                !isset($arrPPA[Canddi_Model_Local_Process_Action_Abstract::CHILD_ASSOC_Inputs]) &&
                !is_array($arrPPA[Canddi_Model_Local_Process_Action_Abstract::CHILD_ASSOC_Inputs])
            ) {
                throw new Exception("PPA Array incorrectly formatted [Missing Inputs] ".print_r($arrPPA,true));
            }

            switch($strBasePPAType) {
                case "Canddi_Model_Local_Process_Action_AllGoals":
                    $modelPPA   = Canddi_Model_Local_Process_Action_AllGoals::create(
                        $this,
                        $arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_Type],
                        $strPPAId
                    );
                    break;
                case "Canddi_Model_Local_Process_Action_Contact":
                    $modelPPA   = Canddi_Model_Local_Process_Action_Contact::create(
                        $this,
                        $arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_Type],
                        $strPPAId
                    );
                    break;
                case "Canddi_Model_Local_Process_Action_Tracker":
                    $modelPPA   = Canddi_Model_Local_Process_Action_Tracker::create(
                        $this,
                        $arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_Type],
                        $strPPAId
                    );
                    break;
                case "Canddi_Model_Local_Process_Action_TrackerGoal":
                    $modelPPA   = Canddi_Model_Local_Process_Action_TrackerGoal::create(
                        $this,
                        $arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_Type],
                        $strPPAId
                    );
                    break;
                default:
                    throw new Exception("Unable to add PPA's Unknown Base Model $strBasePPAType");
            }

            if (
                isset($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_ARRAY_Dependencies]) &&
                is_array($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_ARRAY_Dependencies])
            ) {
                $modelPPA->setDependencies(
                    $arrPPA[
                        Canddi_Model_Local_Process_Action_Abstract::FIELD_ARRAY_Dependencies
                    ]
                );
            }

            //Secondly Iterate through all the Inputs
            foreach ($arrPPA[Canddi_Model_Local_Process_Action_Abstract::CHILD_ASSOC_Inputs] as $strInputId => $arrInput) {
                $modelPPA->addInput(
                    $strInputId,
                    $arrInput[Canddi_Model_Local_Process_Input::FIELD_Type],
                    $arrInput
                )->updateParent();
            }

            //Thirdly iterate through the Params
            if (
                isset($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_HASH_Params]) &&
                is_array($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_HASH_Params])
            ) {
                $modelParams    = $modelPPA->getParams();

                foreach ($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_HASH_Params] as $strParam => $mixedValue) {
                    $modelParams->setParamByName($strParam, $mixedValue);
                }
                $modelParams->updateParent();
            }

            //Finally iterate through the Outputs
            if (
                isset($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_INDEX_OUTPUTS]) &&
                is_array($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_INDEX_OUTPUTS])
            ) {
                foreach ($arrPPA[Canddi_Model_Local_Process_Action_Abstract::FIELD_INDEX_OUTPUTS] as $arrOutput) {
                    $modelPPA->addOutput(
                        $arrOutput[\Canddi_Model_Local_Process_Output::FIELD_TYPE]
                    )->setName(
                        $arrOutput[\Canddi_Model_Local_Process_Output::FIELD_NAME]
                    )->updateParent();
                }
            }

            $modelPPA->updateParent();
        }

        return $this;
    }

}
