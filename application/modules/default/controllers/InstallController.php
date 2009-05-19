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
	}
	public function indexAction() {
		$this->view->title = "Installation";
		$config = new Zend_Config_Ini ( 'config.ini', 'production', array ('skipExtends' => true, 'allowModifications' => true ) );
		
		$installForm = new InstallForm ( null, $config );
		if ($this->_request->isPost ()) {
			$formData = $this->_request->getParams ();
			if ($installForm->isValid ( $formData )) {
				$config->site->name = $formData ['siteName'];
				$config->site->slogan = $formData['siteSlogan'];
				$config->db->params->host = $formData ['dbHost'];
				$config->db->params->username = $formData ['dbUser'];
				$config->db->params->password = $formData ['dbPword'];
				$config->db->params->dbname = $formData ['dbName'];
				$config->limit->latest = $formData ['latestLimit'];
				$config->limit->popular = $formData ['popularLimit'];
				$config->limit->perpage = $formData ['pageLimit'];
				try {
					$writer = new Zend_Config_Writer_Ini ( array ('config' => $config, 'filename' => '../application/config/config.ini' ) );
					$writer->write ();
				} catch ( Zend_Config_Exception $e ) {
					die ( $e->getTrace () . "<br><br>" . $e->getMessage () );
				}
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
		try {
			$db = Zend_Registry::get ( 'db' );
			$sql = "CREATE TABLE IF NOT EXISTS `news` (
  			`id` int(11) NOT NULL auto_increment,
  			`title` varchar(64) NOT NULL,
  			`summary` varchar(255) NOT NULL,
  			`content` longtext NOT NULL,
  			`author` varchar(128) NOT NULL,
  			`created` datetime NOT NULL default '0000-00-00 00:00:00',
  			`modified` datetime NOT NULL default '0000-00-00 00:00:00',
  			`views` int(11) NOT NULL,
  			PRIMARY KEY  (`id`),
  			KEY `title` (`title`,`summary`,`author`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Holds News story meta data'";
			$db->query ( $sql );
			$sql2 = "CREATE TABLE IF NOT EXISTS `members` (
  			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `fname` varchar(25) NOT NULL,
			  `lname` varchar(50) NOT NULL,
			  `uname` varchar(25) NOT NULL,
			  `pword` varchar(255) NOT NULL,
			  `email` varchar(150) NOT NULL,
			  `active` set('0','1') NOT NULL,
			  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1";
			$db->query ( $sql2 );
		} catch ( Zend_Db_Adapter_Exception $e ) {
			die ( $e->getTrace () . "<br><br>" . $e->getMessage () );
		}
		$this->_helper->viewRenderer->setNoRender ();
		$this->_redirect ( '/install/complete' );
	
	}
}
