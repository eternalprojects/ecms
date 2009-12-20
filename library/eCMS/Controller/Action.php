<?php

require_once ('Zend/Controller/Action.php');

class eCMS_Controller_Action extends Zend_Controller_Action {
	public function init(){
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
		$this->view->siteName = Zend_Registry::get('settings')->site->name;
		$this->view->menu = $this->_helper->generateMenu(Zend_Auth::getInstance()->getIdentity());
		$this->view->slogan = Zend_Registry::get('settings')->site->slogan;
	}
}

?>
