<?php
/**
 * Wrapper for CANDDi Lookup
 * https://api.canddi.net
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Tim Langley
 **/
namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

use CanddiAi\Lookup\Response\Company\Company as InnerCompany;
use CanddiAi\Lookup\Response\Company\IP as InnerIP;

class Company
{
    const KEY_COMPANY   = 'Company';
    const KEY_IP        = 'IP';
    const KEY_HOSTNAME  = 'Hostname';
    const KEY_DEBUG     = 'Debug';
    const KEY_TYPE      = 'Type';

    use NS_traitArrayValue;

    private $_arrResponse;
    private $_mdlCompany = null;
    private $_mdlIP = null;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
        if(array_key_exists('Company', $arrResponse)) {
            $this->_mdlCompany = new InnerCompany($arrResponse['Company']);
        }
    }
    /**
     * @return  CanddiAi\Lookup\Response\Company\Company
     */
    public function getCompany()
    {
        return $this->_mdlCompany;
    }
    /**
     * @return  Array
     */
    public function getDebug()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_DEBUG],
            []
        );
    }
    /**
     * @return  Integer|null
     */
    public function getType()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_TYPE],
            null
        );
    }
    /**
     * @return  String|null
     */
    public function getHostname()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_HOSTNAME],
            null
        );
    }
}
