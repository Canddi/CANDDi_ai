<?php
/**
 * Wrapper for CANDDi Lookup
 * https://api.canddi.net
 *
 * @TODO REFACTOR THIS TO a separate composer package
 *
 * @author Christian Wilkinson
 **/

namespace CanddiAi\Lookup\Response\Item;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class JobSummary
{
    const KEY_JOB_ROLE          = 'JobRole';
    const KEY_NORMAL_JOB_ROLE   = 'NormalJobRole';
    const KEY_COMPANY_HOST_NAME = 'CompanyHostname';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getJobRole()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_JOB_ROLE
            ],
            null
        );
    }

    public function getNormalJobRole()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_NORMAL_JOB_ROLE
            ],
            null
        );
    }

    public function getCompanyHostname()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_COMPANY_HOST_NAME
            ],
            null
        );
    }
}
