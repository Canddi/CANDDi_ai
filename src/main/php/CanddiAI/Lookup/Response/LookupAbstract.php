<?php
/**
 * @author Luke Roberts
 **/

namespace CanddiAI\Response;

abstract class LookupAbstract
{
    protected $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    /**
     * This function parses through a multi-depth array
     * Trying to find the SubKey value (and returning mixedDefault otherwise)
     *
     *
     * @param   $arrData        Array of Data ["Contact" => ["Name" => "Tim"]]
     * @param   $arrKeys        Array of Keys to Lookup ie ["Contact","Name"]
     * @param   $mixedDefault   Default return value if not existss
     *
     * @return  mixedValue OR mixedDefault
     **/
    protected function _getArrayValue(
        Array $arrData,
        Array $arrKeys,
        $mixedDefault = ""
    )
    {
        foreach($arrKeys as $strKeyName) {
            //The Key Value didn't exist
            if (!isset($arrData[$strKeyName])) {
                return $mixedDefault;
            }
            $arrData    = $arrData[$strKeyName];
        }

        return $arrData;
    }
}
