<?php
/**
 * AddController
 *
 * @author
 * @version
 */
require_once 'eCMS/Controller/Action.php';
class AddController extends eCMS_Controller_Action
{
	/**
	 * The default action - show the home page
	 */
	public function init(){
		parent::init();
	}
	public function indexAction ()
	{
		$this->view->title = "Add Article";
		$this->view->bodyCopy = "<p>Fill out the following form to add an article.</p><p>The summary can be up to 250 characters long</p>";
		$form = new Default_Form_AddNews();
		if ($this->_request->isPost()) {
			$formData = $this->_request->getPost();
			if ($form->isValid($formData)) {
				$data = $form->getValues();
				$data['author'] = $this->view->user->uname;
				$news = new Default_Model_News($data);
				$news->save();
				$this->_redirect('view/latest');
			} else {
				$form->populate($formData);
				$this->view->form = $form;
			}
		} else {
			$this->view->form = $form;
		}
	}
}
