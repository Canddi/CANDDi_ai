<?php
namespace CanddiAi\Lookup\Response\Item;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class Role
{
    const KEY_PRIMARY   = 'IsPrimary';
    const KEY_TITLE     = 'Title';
    const KEY_NAME      = 'CompanyName';
    const KEY_START     = 'StartDate';
    const KEY_END       = 'EndDate';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }
    public function bPrimary()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_PRIMARY
            ],
            false
        );
    }
    public function getTitle()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_TITLE
            ],
            ""
        );
    }
    public function getName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_NAME
            ],
            ""
        );
    }
    public function getStartDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_START
            ],
            ""
        );
    }
    public function getEndDate()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [
                self::KEY_END
            ],
            ""
        );
    }
}
