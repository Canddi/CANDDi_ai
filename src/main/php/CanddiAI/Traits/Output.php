<?php
/**
 * @category
 * @package
 * @copyright  2011-03-19 (c) 2011-12 Campaign and Digital Intelligence
 * @license
 * @author     Tim Langley
 **/
trait Canddi_Traits_Output
{
    /**
     *
     * @param   $strValue   The value already found from the array
     * @param   $arrParams  an array parameters to pass in
     *              FilterValue
     *
     * @return  string
     * @throws  Canddi_Exception_Notice_IgnoreInputField
     *                  This is returned if the value is blocked
     *                  This is an Ignore message because it shouldn't be logged
     *
     * @author Tim Langley
     **/
    protected function _throwIfValueBlocked(
        $strValue,
        Canddi_Model_Local_Process_Params_Input $objParamsInput
    ) {
        //Filter value is to filter things out
        // if it matches then exit!
        $regFilterValue         = $objParamsInput->getFilterValue();
        if(!empty($regFilterValue)) {
            //Filter the / character
            $regFilterValue     = str_replace('\\/', '/', $regFilterValue);
            if(false !== strpos($regFilterValue,'/') && !strpos($regFilterValue,'\/')) {
                $regFilterValue = str_replace('/','\/',$regFilterValue);
            }
            $regexFilterValue   = '/'.$regFilterValue.'/i';

            try {
                $intPregMatch   = Canddi_Helper_PregMatch::preg_match(
                    $regexFilterValue,$strValue
                );
            } catch(ErrorException $e) {
                throw new Canddi_Exception_Fatal_InvalidData(
                    "Unable to match Regex: ".$regexFilterValue.'-'.$strValue, $e->getMessage()
                );
            }

            if(1 === $intPregMatch) {
                throw new Canddi_Exception_Notice_IgnoreInputField(
                    $strValue
                );
            }
        }
        $regMatchValue          = $objParamsInput->getMatchValue();
        if(!empty($regMatchValue)) {
            $regMatchValue      = str_replace('\\/', '/', $regMatchValue);
            if(false !== strpos($regMatchValue,'/') && !strpos($regMatchValue,'\/')) {
                $regMatchValue  = str_replace('/','\/',$regMatchValue);
            }
            $regexMatchValue    = '/'.$regMatchValue.'/i';

            try {
                $intPregMatch   = Canddi_Helper_PregMatch::preg_match(
                    $regexMatchValue,$strValue,$arrOutputs
                );
            } catch(ErrorException $e) {
                throw new Canddi_Exception_Fatal_InvalidData(
                    "Unable to match Regex: ".$regexMatchValue.'-'.$strValue, $e->getMessage()
                );
            }
            if(1 !== $intPregMatch) {
                throw new Canddi_Exception_Notice_IgnoreInputField(
                    $strValue
                );
            }

            $strValue           = $arrOutputs[0];
        }

        return $strValue;
    }
    /**
     * This function looks up the the Post / Query key
     * NOTE: If not found AND if provided then this checks the keys against the Filter Keys array
     * NOTE: this can log duplciates if they are found
     *
     * @param   $arrData    the array of data to check (in a SessionGoal this is the rawPostArray or the QueryArray)
     * @param   $arrParams  an array parameters to pass in
     *              Key         => the key in the $arrData to look up
     *              Filter_Keys => array of regex to check against (see Canddi_Model_Local_TrackerGoal_Abstrac::cleanPostKey)
     *
     * @return  string
     * @throws  Canddi_Exception_Fatal_MissingProperty
     * @throws  Canddi_Exception_Ignore_IgnoreInputField
     *
     * @author Tim Langley
     **/
    protected function _getItemFromArray(
        Array $arrData,
        Canddi_Model_Local_Process_Params_Input $objParamsInput
    ) {
        $strKey             = $objParamsInput->getKey();
        if( !(is_string($strKey) || is_int($strKey))) {

            throw new Canddi_Exception_Fatal_MissingProperty(
                Canddi_Model_Local_Process_Params_Input::FIELD_KEY,
                __METHOD__
            );
        }

        if (array_key_exists($strKey, $arrData)) {
            return $this->_throwIfValueBlocked(
                $arrData[$strKey],
                $objParamsInput
            );
        }

        //CS-6013 Sometimes people use UTM_medium (which is wrong)
        // should be utm_medium - HOWEVER we shouldn't fail in this situtation
        $arrDataLowerKeys   = array_change_key_case($arrData, CASE_LOWER);
        if (
            array_key_exists(
                strtolower($strKey),
                $arrDataLowerKeys
            )
        ) {
            return $this->_throwIfValueBlocked(
                $arrDataLowerKeys[strtolower($strKey)],
                $objParamsInput
            );
        }

        if(filter_var($strKey, FILTER_VALIDATE_URL) === false) {
            // We should parse keys that contain dots - look for nested values.
            $arrSplitKey = explode(".", $strKey);
            if(count($arrSplitKey) > 1 && isset($arrData[$arrSplitKey[0]])) {
                $mixedValue = $arrData[$arrSplitKey[0]];
                if(is_array($mixedValue)) {
                    // We found an array on the key we are looking at.

                    // Remove the first property on the key (before the .), and run
                    // this function recursively.
                    $objParamsInput->setParamByName(
                        Canddi_Model_Local_Process_Params_Input::FIELD_KEY,
                        implode(".", array_slice($arrSplitKey, 1))
                    );
                    return $this->_getItemFromArray(
                        $mixedValue,
                        $objParamsInput
                    );
                }
                throw new Canddi_Exception_Fatal_InvalidData(
                    $mixedValue,
                    'an array'
                );
            }
        }

        //Bugger - the item didn't exist straight off
        // this calls for tougher measures -> now we're going to check if there are FilterParams
        $strReturnValue     = null;
        $arrDuplicates      = [];

        $arrFilterKeys      = $objParamsInput->getFilterKeys();
        if( !empty($arrFilterKeys)) {

            // in which case we want to test EVERY key in the arrData against these
            // if NONE match - then we throw an exception
            // if ONE matches - yay we've got it
            // if >ONE match - crap - we have a problem
            //          select the first and error log any more
            $arrRawKeys     = array_keys($arrData);

            foreach($arrData as $strRawKey => $mixedRawValue) {
                $strPostKey = Canddi_Model_Local_TrackerGoal_Abstract::cleanPostKey($strRawKey, $arrFilterKeys);
                if(!empty($strPostKey) && $strPostKey == $strKey) {

                    //Not empty - something matched !
                    if(is_null($strReturnValue)) {
                        //We should save it
                        $strReturnValue = $mixedRawValue;
                    } else {
                        //Crap - a duplicate - Log this!
                        $arrDuplicates[] = $strReturnValue.'-'.$strRawKey.'-'.$mixedRawValue;
                    }
                }
            }
        }

        if(!empty($arrDuplicates)) {
            Canddi_Helper_Log::getInstance()->log(
                __METHOD__." DUPLICATE POST KEYS Used Account [".
                $this->getAccountURL()."] ($strKey), Found ".
                print_r($arrDuplicates,true),
                Zend_Log::ERR
            );
        }
        if(!is_null($strReturnValue)) {

            return $this->_throwIfValueBlocked(
                $strReturnValue,
                $objParamsInput
            );
        }

        //Ok - this is fucked up
        // This relates to
        //  https://canddi.zendesk.com/agent/tickets/9089
        // basically if we have a TriggerIF key then we need to throw a
        // Canddi_Exception_Notice_IgnoreInputField here
        //
        // This deals with the case where the Key didn't exist
        // This should ALL be refactored to get rid of this trait!
        if (
            !empty($objParamsInput->getMatchValue()) ||
            !empty($objParamsInput->getFilterValue())
        )
        {
            throw new Canddi_Exception_Notice_IgnoreInputField(
                $strKey
            );
        }

        if($objParamsInput->getOptional()) {
            //If it's optional field then don't stress
            return "";
        }

        throw new Canddi_Exception_Fatal_MissingProperty($strKey, __CLASS__);
    }
    /**
     * This returns an array of fields
     *
     * @return array
     *              [
     *                  'Query' => array(Canddi_Interface_GetOutputValue::PARAM_METHOD => '_getQueryItemFromParams')
     *              ]
     * @author Tim Langley
     **/
    abstract protected function _getOutputFields();
    /**
     * Gets the output value
     *
     * @param string $strRef
     * @param array $modelParamsInput - optional Key parameter
     *
     * @return mixed
     * @throws Canddi_Exception_Fatal_MethodDoesNotExist
     * @throws Canddi_Exception_Fatal_InvalidRef
     *
     * @author Dan Dart
     **/
    public function getOutputValue(
        $strRef, Canddi_Model_Local_Process_Params_Input $modelParamsInput
    )
    {
        $arrOutputFields = $this->_getOutputFields();
        if (!isset($arrOutputFields[$strRef])) {
            $arrKeys     = array_keys($arrOutputFields);
            $strError    = "";
            foreach($arrKeys as $strKey) {
                $strError .= $strKey . ", ";
            }

            throw new Canddi_Exception_Fatal_InvalidValue(
                "Account [".$this->getAccountURL()."] ".
                "Item [".$this->getId()."] ".
                "OutputType with Reference : ".$strRef,
                "Reference should be one of : [".trim($strError,", ")."]"
            );
        }

        $arrInfo            = $arrOutputFields[$strRef];
        if (!isset($arrOutputFields[$strRef][Canddi_Interface_GetOutputValue::PARAM_METHOD])) {
            throw new Canddi_Exception_Fatal_InvalidValue(
                "Account [".$this->getAccountURL()."] ".
                "Item [".$this->getId()."] ".
                "OutputType Reference : ".$strRef,
                "Method not set"
            );
        }
        $strMethod          = $arrInfo[Canddi_Interface_GetOutputValue::PARAM_METHOD];

        if (!method_exists($this, $strMethod)) {
            throw new Canddi_Exception_Fatal_MethodDoesNotExist(
                $strMethod , get_class($this));
        }
        $mixedValue         = $this->$strMethod($modelParamsInput);

        if(true == $modelParamsInput->getBase64Decode()) {
            //NOTE The need for the URL Decoding - otherwise we can end-up
            // with wierd shit ;-)
            // as demonstrated in testGetOutputValues_Querystring_Base64
            // we double decode it because occasionally we get
            // MAINT-2864 (and urldecode is a transative function)
            $mixedValue     = base64_decode(
                urldecode(
                    urldecode($mixedValue)
                )
            );
        }

        //We should trim the mixedValue so that we get real data
        //MAINT-2858
        if(!is_array($mixedValue)) {
            $mixedValue     = trim($mixedValue);
        }
        if(is_array($mixedValue)) {
            $arrOutput      = [];
            foreach ($mixedValue as $strKey => $mixedItem) {
                $arrOutput[$strKey]= trim($mixedItem);
            }
            $mixedValue     = $arrOutput;
        }
        return $mixedValue;
    }
}
