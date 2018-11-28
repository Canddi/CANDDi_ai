<?php
/**
 * @copyright 2016-12-14
 * @author Kathie Dart
**/

/**
 * Singleton trait - used by Gateway, Message, Service
**/

trait Canddi_Traits_Singleton
{
    /**
     * Prevent instantiation and cloning
     * ONLY use getInstance()
    **/
    final protected function __construct()
    {
    }

    final protected function __clone()
    {
        throw new Exception('Cannot clone');
    }

    /**
     *  Implements the singleton pattern
     *  @return:$this       - this is a fluent interface
    **/
    protected static $_locater;

    /**
     * Gets an instance of the current class
     *
     * @return static
     * @author Tim Langley
    **/
    public static function getInstance()
    {
        if (is_null(static::$_locater)) {
            static::$_locater   = new static();
            //This allows us to configure the instance
            // when first loads
            static::$_locater->_postInstance();
        }

        return static::$_locater;
    }

    /**
     * This method is used for testing
     *  @param: $locator    - this is mainly for testing
     *                      - it allows a mock version of the
     *                          Common_Gateway to be injected
    **/
    public static function inject(
        Canddi_Interface_Singleton $locator = null
    )
    {
        static::$_locater   = $locator;
    }
    /**
     * This wipes out anything cached
     *
     **/
    public static function reset()
    {
        static::$_locater = null;
    }
    /**
     * This allows us to configure the instance
     * when first loads
     * Override in children
     *
     **/
    protected function _postInstance()
    {

    }
}
