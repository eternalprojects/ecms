<?php

/**
 * SubmissionController
 *
 * @author
 * @version
 */

require_once 'eCMS/Controller/Action.php';

class Members_SubmissionsController extends eCMS_Controller_Action {
	/**
	 * The default action - show the home page
	 */

	public function init(){
		parent::init();
		if(!$this->view->user)
		$this->_redirect('/members/auth/login');

	}
	public function indexAction() {
		$this->_redirect('/members/submissions/view');
	}

	public function viewAction(){
		$this->view->title = "My Submissions";
		$page = $this->_request->getParam('page', 1);
		$news = new Default_Model_News();
		$paginator = $news->fetchNewsByAuthor($this->view->user->uname, $page);
		$this->view->news = $paginator->getItemsByPage($page);
		$this->view->paginator = $paginator;

	}

	public function editAction(){
		if(!$sid = (int)$this->_request->getParam('sid'))
		$this->_redirect('/members/submissions/view');
		$this->view->title = "Edit Article";
		$news = new Default_Model_DbTable_News();
		$form = new Default_Form_EditNews();
		$row = $news->find($sid);
		$form->setAction('/members/submissions/edit/sid/'.$sid);
		if($this->_request->isPost()){
			$formData = $this->_request->getParams();
			if($sid != $formData['id'])
			$this->_redirect('/members/submissions/view');
			if($form->isValid($formData)){
				$data = array(
					'title'=>$form->getValue('title'),
					'summary'=>$form->getValue('summary'),
					'content'=>$form->getValue('content')
				);
				$where = $news->getAdapter()->quoteInto('id = ?',$form->getValue('id'));
				$news->update($data, $where);
				$this->_redirect('/view/article/sid/'.$sid);
			}
		}

		$form->getElement('title')->setValue($row[0]['title']);
		$form->getElement('summary')->setValue($row[0]['summary']);
		$form->getElement('content')->setValue($row[0]['content']);
		$form->getElement('id')->setValue($sid);
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
		$news = new Default_Model_DbTable_News();
		$row = $news->find($sid);
		$this->view->sid = $row[0]['id'];
		$this->view->articleTitle = $row[0]['title'];
	}

	// This needs to be moved to the News DAO/Mapper
	private function _removeArticle($sid){
		$news = new Default_Model_DbTable_News();
		$row = $news->find($sid);
		if($this->view->user->uname != $row[0]['author'])
		$this->_redirect('/members/submissions/view');
		$where = $news->getAdapter()->quoteInto('id = ?',$sid);
		$news->delete($where);
	}

}
