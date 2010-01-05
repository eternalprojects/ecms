<?php
/**
 * Contains the Application Bootstrapping data
 *
 * License:
 *
 * Copyright (c) 2009, JPL Web Solutions,
 *                     Jesse Lesperance <jesse@jplesperance.com>
 *
 * This file is part of EternalCMS.
 *
 * EternalCMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.  EternalCMS is distributed in the hope
 * that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * See the GNU General Public License for more details. You should have received
 * a copy of the GNU General Public License along with EternalCMS.
 *
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Boostrap
 * @subpackage Bootstrap
 * @author Jesse Lesperance <jesse@jplesperance.com>
 * @copyright 2010 JPL Web Solutions
 * @license http://www.gnu.org/licenses/gpl-3.0-standalone.html GNU General Public License
 *
 */
/**
 * Application bootstrap
 *
 * This is where the initialization code for the Autoloader, Views, Helpers, 
 * Routes and Settings are.
 * 
 * @uses    Zend_Application_Bootstrap_Bootstrap
 * @package Bootstrap
 * @subpackage Bootstrap
 * @author Jesse Lesperance
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Bootstrap autoloader for application resources
     *
     * @access protected
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
     * @access protected
     * @return Zend_View
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
    /**
     * Bootstrap the site settings configuration
     * 
     * @access protected
     */
    protected function _initSettings ()
    {
        $settings = new Zend_Config_Ini(APPLICATION_PATH . "/configs/siteSettings.ini", "general");
        Zend_Registry::set('settings', $settings);
    }
    /**
     * Initialize Action Helpers
     */
    protected function _initHelpers ()
    {
        Zend_Controller_Action_HelperBroker::addPrefix('eCMS_Controller_Action_Helper');
    }
    /**
     * Initialize the custom route definitions
     */
    protected function _initSiteRoutes ()
    {
        //Don't forget to bootstrap the front controller as the resource may not been created yet...
        $this->bootstrap("frontController");
        $front = $this->getResource("frontController");
        //Read the routes from an ini file and in that ini file use the options with routes prefix...
        $front->getRouter()->addConfig(new Zend_Config_Ini(APPLICATION_PATH . "/configs/routes.ini"), "routes");
    }
}
