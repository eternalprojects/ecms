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
		$config = new Zend_Config_Ini (APPLICATION_PATH .'/configs/application.ini', 'production', array ('skipExtends' => true, 'allowModifications' => true ) );

		$installForm = new Default_Forms_InstallForm1 ( null, $config );
		if ($this->_request->isPost ()) {
			$formData = $this->_request->getParams ();
			if ($installForm->isValid ( $formData )) {
				$config->db->params->host = $formData ['dbHost'];
				$config->db->params->username = $formData ['dbUser'];
				$config->db->params->password = $formData ['dbPword'];
				$config->db->params->dbname = $formData ['dbName'];
				try {
					$writer = new Zend_Config_Writer_Ini ( array ('config' => $config, 'filename' => APPLICATION_PATH .'/configs/application.ini' ) );
					$writer->write ();
				} catch ( Zend_Config_Exception $e ) {
					die ( $e->getTrace () . "<br><br>" . $e->getMessage () );
				}
				Default_Model_Install::createTables($this->resource->getDbAdapter());
				$this->_redirect ( '/install/createdb' );
			}
		}

		$this->view->form = $installForm;

	}

	final public function completeAction() {
		$this->view->title = "Installation Complete";
		$this->view->bodyCopy = "<p>EternalCMS has successfully been installed.  You may now start adding news stories and using the application</p><p>You should either delete the Install Controller or change the permissions to make it unaccessable, to prevent users from accessing sensative system information.</p>";
	}

	final public function createdbAction() {

		$this->_helper->viewRenderer->setNoRender ();
		$this->_redirect ( '/install/complete' );

	}
}
