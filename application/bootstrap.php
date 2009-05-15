<?php
/**
 * My new Zend Framework project
 * 
 * @author  
 * @version 
 */
set_include_path('.' . PATH_SEPARATOR . '../library' . PATH_SEPARATOR . '../application/config' . PATH_SEPARATOR . '../application/forms/' . PATH_SEPARATOR . get_include_path());
date_default_timezone_set('America/Los_Angeles');
require_once 'Zend/Loader/Autoloader.php';
require_once 'Initializer.php';

// Set up autoload.
$loader = Zend_Loader_Autoloader::getInstance(); 
$loader->setFallbackAutoloader(true);

// Prepare the front controller. 
$frontController = Zend_Controller_Front::getInstance(); 

// Change to 'production' parameter under production environemtn
$frontController->registerPlugin(new Initializer('production'));    

// Dispatch the request using the front controller. 
$frontController->dispatch(); 
?>

