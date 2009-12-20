<?php
/**
 * Application bootstrap
 *
 * @uses    Zend_Application_Bootstrap_Bootstrap
 * @package QuickStart
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 * Bootstrap autoloader for application resources
	 *
	 * @return Zend_Application_Module_Autoloader
	 */
	protected function _initAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default',
            'basePath'  => dirname(__FILE__),
		));
		return $autoloader;
	}

	/**
	 * Bootstrap the view doctype
	 *
	 * @return void
	 */
	protected function _initDoctype()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
	}

	protected function _initSettings(){
		$settings = new Zend_Config_Ini(APPLICATION_PATH . "/configs/siteSettings.ini","general");
		Zend_Registry::set('settings', $settings);
	}

	protected function _initHelpers(){
		Zend_Controller_Action_HelperBroker::addPrefix('eCMS_Controller_Action_Helper');
	}
}
