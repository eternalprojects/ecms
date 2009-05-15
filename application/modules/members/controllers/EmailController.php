<?php

/**
 * EmailController
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class Members_EmailController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function init(){
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
		$this->view->siteName = Zend_Registry::get('config')->site->name;
		$this->view->menu = $this->_helper->generateMenu(Zend_Auth::getInstance()->getIdentity());
		$this->view->slogan = Zend_Registry::get('config')->site->slogan;
	}
	
	public function indexAction() {
		$this->_redirect('/');
		
	}
	
	public function changeAction(){
		if(!$user = Zend_Auth::getInstance()->getIdentity())	
			$this->_redirect('/');
		$this->view->bodyCopy = "Enter the new email address below.";
		$this->view->title = "Change Email Address";
		if($this->_request->isPost()){
			$validator = new Zend_Validate_EmailAddress();
			$email = $this->_request->getParam('email');
			if(!$validator->isValid($email)){
				$this->view->bodyCopy .= "<br><br><span style='color: red; font-weight: bold'>Invalid email address specified.</span>";
				$this->render();
				
			}else{
				$members = new Members();
				$data = array('email'=>$email);
				$where = $members->getAdapter()->quoteInto('uname = ?',$user->uname);
				$members->update($data, $where);
				$this->view->title = "Email Address Changed";
				$this->view->bodyCopy = "Your email address has successfully been changed to: $email";
				$this->view->email = true;
			}
			
		}
	}

}
