<?php
/**
 * @copyright   2016-12-14
 * @author      Kathie Dart
**/

namespace CanddiAi\Singleton;

/**
 * Singleton interface - used by Gateway, Message, Service
**/

interface InterfaceSingleton
{
    /**
     *  Implements the singleton pattern
     *  @return:$this       - this is a fluent interface
    **/
    public static function getInstance(
        $strURL     = null,
        $strAccessToken  = null
    );

    /**
     * This method is used for testing
     *  @param: $locator    - this is mainly for testing
     *                      - it allows a mock version of the
     *                          Common_Gateway to be injected
    **/
    public static function inject(InterfaceSingleton $locator = null);

    /**
     * This wipes out anything cached
     *
     **/
    public static function reset();
}
