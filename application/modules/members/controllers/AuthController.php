<?php

/**
 * AuthController
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class Members_AuthController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	
	public function init(){
		$this->initView();
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
		$this->view->siteName = Zend_Registry::get('config')->site->name;
		$this->view->slogan = Zend_Registry::get('config')->site->slogan;
	}
	public function indexAction() {
		// TODO Auto-generated AuthController::indexAction() default action
		$this->_redirect('/');
	}
	
	public function loginAction(){
		$this->view->title = "Member Login";
		$this->view->message = '';
		if($this->_request->isPost()){
			$f = new Zend_Filter_StripTags();
			$username = $f->filter($this->_request->getParam('username'));
			$password = $f->filter($this->_request->getParam('password'));
			if(empty($username)){
				$this->view->message = "Please Provide a Username";
			}else{
				$db = Zend_Registry::get('db');
				$authAdapter = new Zend_Auth_Adapter_DbTable($db);
				$authAdapter->setTableName('members');
				$authAdapter->setIdentityColumn('uname');
				$authAdapter->setCredentialColumn('pword');
				$authAdapter->setCredentialTreatment('md5(?)');
				$authAdapter->setIdentity($username);
				$authAdapter->setCredential($password);
				
				$auth = Zend_Auth::getInstance();
				$result = $auth->authenticate($authAdapter);
				if($result->isValid()){
					$data = $authAdapter->getResultRowObject(null, 'password');
					if($data->active){
						$auth->getStorage()->write($data);
						$this->_redirect('/');
					}else{
						$this->view->message = "Your account is not activated.  Please check your email for the welcome email from when you registered and follow the directions in that email to activate you account before logging in.";
						$this->view->notActive = TRUE;
						$auth->clearIdentity();
					}
					
				}else{
					$this->view->message = "Your username/password is incorrect";
				}
			}
		}
	}
	
	public function logoutAction(){
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect('/');
	}

}