<?php
/**
 * @category
 * @package
 * @copyright  2011-03-19 (c) 2011-12 Campaign and Digital Intelligence
 * @license
 * @author     Tim Langley
 **/
trait Canddi_Traits_NeedsAccount
{
    /**
     * The AccountURL
     *
     * @var string
     **/
    private $_strAccountURL;

    //Implements _injectAccountURL
    /**
     * This is used for base classes which are "stored under the Account"
     * This is used in Base::setDataFromDAO to save the ModelAccount
     *  This can also be used for testing if required
     *
     * @param   string (the account url)
     * @return  $this
     * @author  Tim Langley
     **/
    protected function _injectAccountURL($strAccountURL)
    {
        $this->_strAccountURL = $strAccountURL;
        return $this;
    }
    /**
     * The AccountURL
     *
     * @return      string
     * @throws      Canddi_Exception_Fatal_NotSaved
     * @author      Dan Dart
     **/
    public function getAccountURL()
    {
        if (is_null($this->_strAccountURL)) {
            throw new Canddi_Exception_Fatal_NotSaved(__CLASS__);
        }
        return $this->_strAccountURL;
    }
}