<?php

/**
 * AccountController
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class Members_AccountController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	
	public function init(){
		$this->view->siteName = Zend_Registry::get('config')->site->name;
		$this->view->menu = $this->_helper->generateMenu(Zend_Auth::getInstance()->getIdentity());
		$this->view->slogan = Zend_Registry::get('config')->site->slogan;
	}
	public function indexAction() {
		// TODO Auto-generated AccountController::indexAction() default action
		$this->_redirect('/');
	}
	
	public function activateAction(){
		$params = $this->_request->getParams();
		if(isset($params['mid']) && isset($params['pid'])){
			$members = new Members();
			$select = $members->select();
			$select->where('id=?',$params['mid']);
			$select->where('pword=?',$params['pid']);
			if($members->fetchRow($select)){
				$data = array('active'=>1);
				$where = $members->getAdapter()->quoteInto('id=?',$params['mid']);
				$members->update($data, $where);
				$this->view->status = "Success";
			}else{
				$this->view->status = "Fail";
			}
			
		}else{
			$this->_redirect('/');
		}
	}

}
?>

