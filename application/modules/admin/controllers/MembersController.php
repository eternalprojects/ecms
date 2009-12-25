<?php

class Admin_MembersController extends eCMS_Controller_Action
{
    public function init()
    {
        parent::init();
		$this->settings = Zend_Registry::get('settings');
		$this->view->footerTitle = $this->settings->footer->title;
		$this->view->footerLink = $this->settings->footer->link;
        $this->members = new Members_Model_Members();
    }

    public function indexAction(){
        $this->view->title = "Site Administration: Registered Users";
    	$limit = (int)$this->settings->limit->perpage;
    	$page = $this->_request->getParam('page', 1);
		$paginator = $this->members->fetchAllMembers($page, $limit);
		$this->view->users = $paginator->getItemsByPage($page);
		$this->view->paginator = $paginator;

    }

    public function activateAction(){
        $username = $this->_request->getParam('uname');
        $this->members->activateMember($username);
        $this->_redirect('/admin/members');
    }
    
    public function deactivateAction(){
        $username = $this->_request->getParam('uname');
        $this->members->deactivateMember($username);
        $this->_redirect('/admin/members');
    }
}