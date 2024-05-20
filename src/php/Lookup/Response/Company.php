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
use CanddiAi\Lookup\Response\Company\IP as CompanyIP;
use CanddiAi\Lookup\Response\Company\Person as CompanyPerson;

class Company
{
    const KEY_COMPANY   = 'Company';
    const KEY_IP        = 'IP';
    const KEY_HOSTNAME  = 'Hostname';
    const KEY_DEBUG     = 'Debug';
    const KEY_TYPE      = 'Type';
    const KEY_REPROCESS = 'Reprocess';

    const TYPE_ISP          = 1;
    const TYPE_MOBILE_ISP   = 2;

    use NS_traitArrayValue;

    private $_arrResponse;
    private $_mdlCompany = null;
    private $_mdlIP = null;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
        if (array_key_exists('Company', $arrResponse)) {
            $this->_mdlCompany = new InnerCompany($arrResponse['Company']);
        }
        if (array_key_exists('IP', $arrResponse)) {
            $this->_mdlIP = new CompanyIP($arrResponse['IP']);
        }
    }
    /**
     * @return  \CanddiAi\Lookup\Response\Company\Company|null
     */
    public function getCompany()
    {
        return $this->_mdlCompany;
    }
    /**
     * @return  \CanddiAi\Lookup\Response\Company\IP|null
     */
    public function getIP()
    {
        return $this->_mdlIP;
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
    public function bIsISP()
    {
        $intType = $this->getType();

        if (
            !is_null($intType) &&
            $intType === self::TYPE_ISP
        ) {
            return true;
        }

        return false;
    }

    public function bIsMobileISP()
    {
        $intType = $this->getType();

        if (
            !is_null($intType) &&
            $intType === self::TYPE_MOBILE_ISP
        ) {
            return true;
        }

        return false;
    }

    /**
     * @return  bool
     */
    public function bIsReprocessing()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_REPROCESS],
            false
        );
    }
}
