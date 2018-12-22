<?php
/**
 * Lookup class for Normalized Name
 *
 * @package default
 * @author Jessica Tallon
 **/
namespace CanddiAi\Lookup\Response;

class NormalizeName
{
    const KEY_DETAILS = 'nameDetails';
    const KEY_FIRSTNAME = 'givenName';
    const KEY_LASTNAME = 'familyName';

    private $_arrResponse;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
    }

    /**
     * This will get the value from an item in $_arrResponse,
     * if it doesn't exist or is empty
     * It'll return the $mixedDefault that's been passed in.
     *
     * @param string $strFieldName
     * @param string $mixedDefault
     * @return mixed
     * @author Jessica Tallon
     **/
    private function _getField($strFieldName, $mixedDefault)
    {
        if (!isset($this->_arrResponse[$strFieldName])) {
            return $mixedDefault;
        }
        $mixedField = $this->_arrResponse[$strFieldName];
        if (empty($mixedField)) {
            return $mixedDefault;
        }

        return $mixedField;
    }
    /**
     * Gets the first name
     *
     * @return str || null
     * @author Jessica Tallon
     **/
    public function getFirstName()
    {
        $arrFirstName = $this->_getField(self::KEY_DETAILS, null);
        if (is_null($arrFirstName)) {
            return null;
        }
        return isset($arrFirstName[self::KEY_FIRSTNAME]) ?
            $arrFirstName[self::KEY_FIRSTNAME] : null;
    }

    /**
     * Gets the last name
     *
     * @return str || null
     * @author Jessica Tallon
     **/
    public function getLastName()
    {
        $arrLastName = $this->_getField(self::KEY_DETAILS, null);
        if (is_null($arrLastName)) {
            return null;
        }
        return isset($arrLastName[self::KEY_LASTNAME]) ?
            $arrLastName[self::KEY_LASTNAME] : null;
    }
}
