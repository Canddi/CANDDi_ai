<?php
/**
 * This is our default response for our
 * person_xxx_get lookups
 *
 * @author George Meadows
 **/

namespace CanddiAi\Lookup\Response;

use CanddiAi\Traits\GetArrayValue as NS_traitArrayValue;
use CanddiAi\Lookup\Response\Company\Company as InnerCompany;
use CanddiAi\Lookup\Response\Person as ResponsePerson;

class PersonCompany
{

    use NS_traitArrayValue;

    const KEY_DEBUG = 'Debug';

    private $_arrResponse;
    private $_mdlCompany = null;
    private $_mdlIP = null;

    public function __construct(Array $arrResponse)
    {
        $this->_arrResponse = $arrResponse;
        if(array_key_exists('Company', $arrResponse)) {
            $this->_mdlCompany = new InnerCompany($arrResponse['Company']);
        }
        if(array_key_exists('IP', $arrResponse)) {
            $this->_mdlPerson = new ResponsePerson($arrResponse['Person']);
        }
    }

    /**
     * @return  CanddiAi\Lookup\Response\Company\Company|null
     */
    public function getCompany()
    {
        return $this->_mdlCompany;
    }

    /**
     * @return  CanddiAi\Lookup\Response\Person|null
     */
    public function getPerson()
    {
        return $this->_mdlPerson;
    }

    public function getDebug() {
        return $this->_getArrayValue(
            $this->_arrResponse,
            [self::KEY_DEBUG],
            []
        );
    }

}
