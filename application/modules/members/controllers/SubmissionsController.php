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
		if(!$this->view->user){
			$this->_redirect('/members/auth/login');
		}

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
		if(!$sid = (int)$this->_request->getParam('sid')){
			$this->_redirect('/members/submissions/view');
		}
		$this->view->title = "Edit Article";
		$news = new Default_Model_News();
		$form = new Default_Form_EditNews();
		$news->find($sid);
		$form->setAction('/members/submissions/edit/sid/'.$sid);
		if($this->_request->isPost()){
			$formData = $this->_request->getParams();
			if($sid != $formData['id']){
				$this->_redirect('/members/submissions/view');
			}
			if($form->isValid($formData)){
				$data = $form->getValues();
				$data['author'] = $this->view->user->uname;
				$data['id'] = $sid;
				$news = new Default_Model_News($data);
				$news->setId($sid);
				$news->save();
				$this->_redirect('/view/article/sid/'.$sid);
			}
		}

		$form->getElement('title')->setValue($news->getTitle());
		$form->getElement('summary')->setValue($news->getSummary());
		$form->getElement('content')->setValue($news->getContent());
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
		$news = new Default_Model_News();
		$row = $news->find($sid);
		$this->view->sid = $row->getId();
		$this->view->articleTitle = $row->getTitle();
	}

	// This needs to be moved to the News DAO/Mapper
	private function _removeArticle($sid){
		$news = new Default_Model_News();
		$row = $news->find($sid);
		if($this->view->user->uname != $row->getAuthor())
			$this->_redirect('/members/submissions/view');
		$news->deleteStory($sid);
	}

}
