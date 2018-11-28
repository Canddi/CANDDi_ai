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
putenv('APPLICATION_PATH='.realpath("./src/main/php"));
putenv('APPLICATION_ENV=unit-test');
putenv('APPLICATION_CONFIG_PATH='.realpath("./src/main/php/CanddiAI/Helper/Config/config/canddi"));
putenv('VENDOR_PATH='.realpath("./src/main/php/vendor/"));

define('APPLICATION_PATH',   realpath("src/main/php"));
define('TEST_PATH',          realpath("src/test/php/"));
define('MOCKERY_PATH',       realPath("./src/main/php/vendor/mockery/mockery/library"));


define('ENVIRONMENT_TYPE_PATH', TEST_PATH.'/../');
require_once APPLICATION_PATH.'/environments.php';

$paths = array(
    VENDOR_PATH.'/zendframework/zendframework1/library',
    MOCKERY_PATH
);
set_include_path(get_include_path().PATH_SEPARATOR.implode(PATH_SEPARATOR, $paths));

require_once TEST_PATH.'/CanddiAI/TestCase.php';


require_once MOCKERY_PATH.'/Mockery/Loader.php';
require_once MOCKERY_PATH.'/Mockery/Configuration.php';
$mockery_loader = new \Mockery\Loader;
$mockery_loader->register();
Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
Mockery::getConfiguration()->allowMockingMethodsUnnecessarily(false);

Zend_Session::$_unitTestEnabled = true;
Zend_Session::start();


