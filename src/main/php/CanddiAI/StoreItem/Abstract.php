<?php
/**
 * This is a StoreItem class which can be run multiple times
 *
 **/
abstract class Canddi_StoreItem_Abstract
{
    /**
     * Is this a FinalStoreItem (ie should be run after all others finished)
     *
     * @var boolean
     **/
    private $_bIsFinal              = false;
    /**
     * undocumented class variable
     *
     * @var string
     **/
    public function getFinal()
    {
        return $this->_bIsFinal;
    }
    /**
     * This is the name (for Multiple items make it random)
     * for singleton items make this unique
     *
     * @return string
     *
     * @author Tim Langley
     **/
    abstract public function getInstanceName();
    /**
     * Processes the storeItem
     *
     * @return $this
     * @author Dan Dart
     **/
    abstract public function process();

    /**
     * Sets this StoreItem to a final item
     *
     * @return $this (fluent)
     **/
    public function setFinal($bIsFinal = false)
    {
        $this->_bIsFinal    = (boolean)$bIsFinal;
        return $this;
    }
}
