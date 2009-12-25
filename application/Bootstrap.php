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
    protected function _initAutoload ()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array('namespace' => 'Default' , 'basePath' => dirname(__FILE__)));
        return $autoloader;
    }
    /**
     * Bootstrap the view doctype
     *
     * @return void
     */
    protected function _initView ()
    {
        $view = new Zend_View();
        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        return $view;
    }
    protected function _initSettings ()
    {
        $settings = new Zend_Config_Ini(APPLICATION_PATH . "/configs/siteSettings.ini", "general");
        Zend_Registry::set('settings', $settings);
    }
    protected function _initHelpers ()
    {
        Zend_Controller_Action_HelperBroker::addPrefix('eCMS_Controller_Action_Helper');
    }
    
    protected function _initSiteRoutes()
    {
        //Don't forget to bootstrap the front controller as the resource may not been created yet...
        $this->bootstrap("frontController");
        $front = $this->getResource("frontController");
        //Read the routes from an ini file and in that ini file use the options with routes prefix...
        $front->getRouter()->addConfig(new Zend_Config_Ini(APPLICATION_PATH . "/configs/routes.ini"), "routes");
    }
}
