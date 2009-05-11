<?php
/**
 *
 * @author Jesse
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * BaseUrl helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_BaseUrl {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
	public function baseUrl() {
		// TODO Auto-generated Zend_View_Helper_BaseUrl::baseUrl() helper 
		$fc = Zend_Controller_Front::getInstance();
		return $fc->getBaseUrl();
	}
	
}
