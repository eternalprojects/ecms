<?php

require_once ('Zend/Controller/Action.php');

class eCMS_Controller_Action extends Zend_Controller_Action {
	public function init(){
		if($this->view->user = Zend_Auth::getInstance()->getIdentity()){
		    if($this->view->user->uname != 'admin' && $this->_request->getModuleName() == 'admin'){
		        $this->_redirect('/');
		    }
		}elseif($this->_request->getModuleName() == 'admin'){
		    $this->_redirect('/');
		}
		$this->view->siteName = Zend_Registry::get('settings')->site->name;
		$this->view->menu = $this->_helper->generateMenu(Zend_Auth::getInstance()->getIdentity());
		$this->view->slogan = Zend_Registry::get('settings')->site->slogan;
		$this->view->footLink = Zend_Registry::get('settings')->footer->link;
		$this->view->footTitle = Zend_Registry::get('settings')->footer->title;
	}
}
?>
