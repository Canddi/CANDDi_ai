<?php
/**
 * Lookup class for Normalized Name
 *
 * @package default
 * @author Jessica Tallon
 **/
namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;

class NormalizeName
{
    const KEY_FIRSTNAME = 'FirstName';
    const KEY_LASTNAME = 'LastName';

    use NS_traitArrayValue;

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    /**
     * Gets the first name
     *
     * @return string|null
     * @author Jessica Tallon
     **/
    public function getFirstName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_FIRSTNAME],
            null
        );
    }

    /**
     * Gets the last name
     *
     * @return string|null
     * @author Jessica Tallon
     **/
    public function getLastName()
    {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_LASTNAME],
            null
        );
    }
}
