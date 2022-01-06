<?php

namespace CanddiAi\Lookup\Response\Company;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Financial
{
    const KEY_CREDIT_WORTHY = 'CreditWorthy';
    const KEY_NEGATIVE_INDICATOR = 'NegativeIndicator';
    const KEY_FILING_DATE = 'FilingDate';
    const KEY_ANNUAL_RETURN_DATE = 'AnnualReturnDate';
    const KEY_ACC_DUE_DATE = 'AccDueDate';
    const KEY_INTERNATIONAL_SCORE = 'InternationalScore';
    const KEY_INTERNATIONAL_SCORE_DATE = 'InternationalScoreDate';
    const KEY_MADE_UP_TO_DATE = 'MadeUptoDate';
    const KEY_CURRENCY = 'Currency';
    const KEY_CONSOLIDATED_ACS = 'ConsolidatedAcs';
    const KEY_ACCOUNTS_FORMAT = 'AccountsFormat';
    const KEY_TURNOVER = 'Turnover';
    const KEY_TURNOVER_RANGE = 'TurnoverRange';
    const KEY_PRE_TAX_PROFIT = 'PreTaxProfit';
    const KEY_PROFIT_AFTER_TAX = 'ProfitAfterTax';
    const KEY_CASH = 'Cash';
    const KEY_TOTAL_CURRENT_ASSETS = 'TotalCurrentAssets';
    const KEY_TOTAL_ASSETS = 'TotalAssets';
    const KEY_TOTAL_LIABILITIES = 'TotalLiabilities';
    const KEY_SHAREHOLDER_FUNDS = 'ShareholderFunds';
    const KEY_NET_WORTH = 'NetWorth';
    const KEY_NUMBER_OF_EMPLOYEES = 'NumberOfEmployees';
    const KEY_CURRENT_RATIO = 'CurrentRatio';
    const KEY_AUDITORS = 'Auditors';
    const KEY_ACCOUNTANT_NAME = 'AccountantName';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    public function getCreditWorthy()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CREDIT_WORTHY],
            null
        );
    }

    public function getNegativeIndicator()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_NEGATIVE_INDICATOR],
            null
        );
    }

    public function getFilingDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_FILING_DATE],
            null
        );
    }

    public function getAnnualReturnDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_ANNUAL_RETURN_DATE],
            null
        );
    }

    public function getAccDueDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_ACC_DUE_DATE],
            null
        );
    }

    public function getInternationalScore()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_INTERNATIONAL_SCORE],
            null
        );
    }

    public function getInternationalScoreDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_INTERNATIONAL_SCORE_DATE],
            null
        );
    }

    public function getMadeUptoDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_MADE_UP_TO_DATE],
            null
        );
    }

    public function getCurrency()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CURRENCY],
            null
        );
    }

    public function getConsolidatedAcs()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CONSOLIDATED_ACS],
            null
        );
    }

    public function getAccountsFormat()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_ACCOUNTS_FORMAT],
            null
        );
    }

    public function getTurnover()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_TURNOVER],
            null
        );
    }

    public function getTurnoverRange()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_TURNOVER_RANGE],
            null
        );
    }

    public function getPreTaxProfit()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PRE_TAX_PROFIT],
            null
        );
    }

    public function getProfitAfterTax()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_PROFIT_AFTER_TAX],
            null
        );
    }

    public function getCash()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CASH],
            null
        );
    }

    public function getTotalCurrentAssets()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_TOTAL_CURRENT_ASSETS],
            null
        );
    }

    public function getTotalAssets()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_TOTAL_ASSETS],
            null
        );
    }

    public function getTotalLiabilities()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_TOTAL_LIABILITIES],
            null
        );
    }

    public function getShareholderFunds()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_SHAREHOLDER_FUNDS],
            null
        );
    }

    public function getNetWorth()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_NET_WORTH],
            null
        );
    }

    public function getNumberOfEmployees()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_NUMBER_OF_EMPLOYEES],
            null
        );
    }

    public function getCurrentRatio()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_CURRENT_RATIO],
            null
        );
    }

    public function getAuditors()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_AUDITORS],
            null
        );
    }

    public function getAccountantName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_ACCOUNTANT_NAME],
            null
        );
    }

}
