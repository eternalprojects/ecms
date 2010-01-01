<?php
/**
 * InstallController
 *
 * @author
 * @version
 */
require_once 'eCMS/Controller/Action.php';
class InstallController extends eCMS_Controller_Action {
	/**
	 * The default action - show the home page
	 */

	public function init(){
		parent::init();
		$bootstrap = $this->getInvokeArg('bootstrap');
		$this->resource = $bootstrap->getPluginResource('db');

	}
	public function indexAction() {
		$this->view->title = "Installation";
		$this->view->subTitle = "Step 1: Database Settings";
		$config = new Zend_Config_Ini (APPLICATION_PATH .'/configs/application.ini', 'production', array ('skipExtends' => true, 'allowModifications' => true ) );

		$installForm = new Default_Form_InstallForm1 ( null, $config );
		if ($this->_request->isPost ()) {
			$formData = $this->_request->getParams ();
			if ($installForm->isValid ( $formData )) {
				$config->resources->db->params->host = $formData ['dbHost'];
				$config->resources->db->params->username = $formData ['dbUser'];
				$config->resources->db->params->password = $formData ['dbPword'];
				$config->resources->db->params->dbname = $formData ['dbName'];
				try {
					$writer = new Zend_Config_Writer_Ini ( array ('config' => $config, 'filename' => APPLICATION_PATH .'/configs/application.ini' ) );
					$writer->write ();
				} catch ( Zend_Config_Exception $e ) {
					die ( $e->getTrace () . "<br><br>" . $e->getMessage () );
				}
				
				$this->_redirect('/install/settings');
			}
		}

		$this->view->form = $installForm;

	}

	final public function settingsAction(){
		
		$this->view->title = "Installation";
		$this->view->subTitle = "Step 2: Site Settings";
		$config = new Zend_Config_Ini (APPLICATION_PATH .'/configs/siteSettings.ini', 'general', array ('skipExtends' => true, 'allowModifications' => true ) );
		$settingsForm = new Default_Form_InstallForm2();
		if($this->_request->isPost()){
			$formData = $this->_request->getParams();
			if($settingsForm->isValid($formData)){
				$config->site->name = $settingsForm->getValue('siteName');
				$config->site->slogan = $settingsForm->getValue('siteSlogan');
				$config->limit->latest = $settingsForm->getValue('latestLimit');
				$config->limit->popular = $settingsForm->getValue('popularLimit');
				$config->limit->perpage = $settingsForm->getValue('pageLimit');
				$config->footer->link = $settingsForm->getValue('footerLink');
				$config->footer->title = $settingsForm->getValue('footerName');
				try {
					$writer = new Zend_Config_Writer_Ini ( array ('config' => $config, 'filename' => APPLICATION_PATH .'/configs/siteSettings.ini' ) );
					$writer->write ();
				} catch ( Zend_Config_Exception $e ) {
					die ( $e->getTrace () . "<br><br>" . $e->getMessage () );
				}
				$this->_redirect('/install/complete');
			}
		}
		Default_Model_Install::createTables($this->resource->getDbAdapter());
		$this->view->form = $settingsForm;
	}

	final public function completeAction() {
		$this->view->title = "Installation Complete";
		$this->view->bodyCopy = "<p>EternalCMS has successfully been installed.  You may now start adding news stories and using the application</p><p>You should either delete the Install Controller or change the permissions to make it unaccessable, to prevent users from accessing sensative system information.</p>";
	}

}
