<?php
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set("Europe/Vienna");

defined("APPLICATION_PATH")
	|| define("APPLICATION_PATH", realpath(dirname(__FILE__) . "/../../application"));
defined("APPLICATION_ENV")
	|| define("APPLICATION_ENV", (getenv("APPLICATION_ENV") ? getenv("APPLICATION_ENV") : "testing"));
set_include_path(implode(PATH_SEPARATOR, array(
	get_include_path(),
	realpath(APPLICATION_PATH . "/../library"),
	"/usr/local/share/pear",
)));
require_once 'Zend/Loader/Autoloader.php';
require_once 'Zend/Application/Module/Autoloader.php';


$autoloader = new Zend_Application_Module_Autoloader(array(
	"namespace" => "Default",
	"basePath" => APPLICATION_PATH
));


$cfg = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'testing'); 
    Zend_Registry::set('config', $cfg);

    // Set up the database in the Registry
    $db = Zend_Db::factory($cfg->resources->db);
    Zend_Db_Table_Abstract::setDefaultAdapter($db);

/**
 * @var Zend_Application_Module_Autoloader
 */

