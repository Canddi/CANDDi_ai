<?php

namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Legal
{
    const KEY_LEGALNAME             = 'LegalName';
    const KEY_COMPANYTYPE           = 'CompanyType';
    const KEY_CRN                   = 'CRN';
    const KEY_INCORPORATIONDATE     = 'IncorporationDate';
    const KEY_REGISTEREDLOCATION    = 'RegisteredLocation';
    const KEY_FINANCIAL             = 'Financial';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getCompanyType()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_COMPANYTYPE],
            null
        );
    }
    public function getCRN()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CRN],
            null
        );
    }
    public function getIncorporationDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_INCORPORATIONDATE],
            null
        );
    }
    public function getLegalName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LEGALNAME],
            null
        );
    }
    /**
     * @return Location|null
     */
    public function getRegisteredLocation()
    {
        $arrLocation = $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_REGISTEREDLOCATION],
            null
        );

        if (empty($arrLocation)) {
            return null;
        }

        return new Location($arrLocation);
    }
    /**
     * @return Financial|null
     */
    public function getFinancial()
    {
        $arrFinancial = $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_FINANCIAL],
            null
        );
        if (empty($arrFinancial)) {
            return null;
        }
        return new Financial($arrFinancial);
    }
}
