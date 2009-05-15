<?php

/**
 * SubmissionController
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class Members_SubmissionsController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	
	public function init(){
		$this->_user = Zend_Auth::getInstance()->getIdentity();
		$this->view->user = $this->_user;
		if(!$this->_user)
			$this->_redirect('/members/auth/login');
		$this->view->siteName = Zend_Registry::get('config')->site->name;
		$this->view->menu = $this->_helper->generateMenu($this->_user);
		$this->view->slogan = Zend_Registry::get('config')->site->slogan;
	}
	public function indexAction() {
		$this->_redirect('/');
	}
	
	public function viewAction(){
		$db = Zend_Registry::get('db');
		$this->view->title = "My Submissions";
		$page = $this->_request->getParam('page', 1);
        $select = $db->select()->from('news')->where('author = ?',$this->_user->uname)->order('id DESC');
        $pagination = Zend_Paginator::factory($select);
        $pagination->setCurrentPageNumber($page);
        $pagination->setItemCountPerPage(10);
        $pagination->setDefaultScrollingStyle('Elastic');
        $this->view->news = $pagination->getItemsByPage($page);
        $this->view->paginator = $pagination;
		
	}
	
	public function editAction(){
		if(!$sid = (int)$this->_request->getParam('sid'))
			$this->_redirect('/members/submissions/view');
		$this->view->title = "Edit Article";
		$formConfig = new Zend_Config_Ini('news.ini','edit-news');
		$news = new News();
		$row = $news->find($sid);
		$form = new Zend_Form($formConfig->news->edit);
		$form->setAction('/members/submissions/edit/sid/'.$sid);
		if($this->_request->isPost()){
			$formData = $this->_request->getParams();
			if($sid != $formData['articleId'])
				$this->_redirect('/members/submissions/view');
			if($form->isValid($formData)){
				$data = array(
					'title'=>$form->getValue('articleTitle'),
					'summary'=>$form->getValue('articleSummary'),
					'content'=>$form->getValue('articleContent')
				);
				$where = $news->getAdapter()->quoteInto('id = ?',$form->getValue('articleId'));
				$news->update($data, $where);
				$this->_redirect('/view/article/sid/'.$sid);
			}
		}
		
		$form->getElement('articleTitle')->setValue($row[0]['title']);
		$form->getElement('articleSummary')->setValue($row[0]['summary']);
		$form->getElement('articleContent')->setValue($row[0]['content']);
		$form->getElement('articleId')->setValue($sid);
		$this->view->form = $form;
	}
	
	public function deleteAction(){
		$this->view->title = "Delete Article";
		if(!$sid = (int)$this->_request->getParam('sid'))
			$this->_redirect('/members/submissions/view');
		if($this->_request->getParam('confirm') && $this->_request->getParam('confirm') == 1){
			$this->_removeArticle($sid);
			$this->_redirect('/members/submissions/view');
		}
		$news = new News();
		$row = $news->find($sid);
		$this->view->articleTitle = $row[0]['title'];
		$this->view->sid = $sid;
	}
	
	private function _removeArticle($sid){
		$news = new News();
		$row = $news->find($sid);
		if($this->_user->uname != $row[0]['author'])
			$this->_redirect('/members/submissions/view');
		$where = $news->getAdapter()->quoteInto('id = ?',$sid);
		$news->delete($where);	
	}

}
