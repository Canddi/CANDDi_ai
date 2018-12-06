<?php
/**
* @category
* @package
* @copyright  2011-03-01 (c) 2011-12 Campaign and Digital Intelligence
* @license
* @author     Tim Langley
**/

// Fix REQUEST_URI because for some reason PHPUnit hates it.
if (!isset($_SERVER['REQUEST_URI']) and isset($_SERVER['SCRIPT_NAME']))
{
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
    if (isset($_SERVER['QUERY_STRING']) and
        !empty($_SERVER['QUERY_STRING']))
        $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
}

ini_set("memory_limit","1500M");
set_time_limit(0);



// PHP unit needs to get these from the phpunit script.
// It may eventually get them from the .profile of the user
putenv('APPLICATION_PATH='.realpath("./src/php"));
putenv('APPLICATION_ENV=unit-test');
putenv('VENDOR_PATH='.realpath("./vendor/"));

define('APPLICATION_PATH',   realpath("src/php"));
define('TEST_PATH',          realpath("test/php/"));

require_once './test/php/TestCase.php';
require_once './vendor/autoload.php';

Mockery::getConfiguration()->allowMockingNonExistentMethods(false);

\Zend_Session::$_unitTestEnabled = true;
\Zend_Session::start();
