<?php
/**
 * Wrapper for CANDDi Lookup
 *
 * @author Tim Langley
 **/

namespace CanddiAi\Traits;

trait GetArrayValue
{
    /**
     * This function parses through a multi-depth array
     * Trying to find the SubKey value (and returning mixedDefault otherwise)
     *
     *
     * @param array $arrData      Array of Data ["Contact" => ["Name" => "Tim"]]
     * @param array $arrKeys      Array of Keys to Lookup ie ["Contact","Name"]
     * @param mixed $mixedDefault Default return value if not existss
     *
     * @return  mixed OR mixedDefault
     **/
    protected function _getArrayValue(
        Array $arrData,
        Array $arrKeys,
        $mixedDefault = ""
    )
    {
        foreach ($arrKeys as $strKeyName) {
            //The Key Value didn't exist
            if (!isset($arrData[$strKeyName])) {
                return $mixedDefault;
            }
            $arrData    = $arrData[$strKeyName];
        }

        return $arrData;
    }
}
