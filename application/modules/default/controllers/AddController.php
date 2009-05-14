<?php
/**
 * AddController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class AddController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
	public function init(){
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
		$this->view->siteName = Zend_Registry::get('config')->site->name;
		$this->view->menu = $this->_helper->generateMenu(Zend_Auth::getInstance()->getIdentity());
		$this->view->slogan = Zend_Registry::get('config')->site->slogan;
	}
    public function indexAction ()
    {
        $this->view->title = "Add Article";
        $this->view->bodyCopy = "<p>Fill out the following form to add an article.<br><br>To add another page, click on 'Add Page'  <br>When you have added all pages and are ready to publish the article, click on 'Add Article'.</p>";
        $config = new Zend_Config_Ini('news.ini','add-news');
        $form = new Zend_Form($config->news->add);
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $filter = new BadWordFilter();
                $news = new News();
                $row = $news->createRow();
                $row->title = $filter->filter($form->getValue('articleTitle'));
                $row->summary = $filter->filter(nl2br($form->getValue('articleSummary')));
                $date = date('Y/m/d H:i:s');
                $row->created = $date;
                $row->modified = $date;
                $row->author = ($this->view->user)?$this->view->user->uname : 'Anonymous';
                $row->views = 0;
                $row->content = $filter->filter(nl2br($form->getValue('articleContent')));
                $row->save();
                $db = Zend_Registry::get('db');
                $id = $db->lastInsertId();
                $this->_redirect('view/article/sid/' . $id);
            } else {
                $form->populate($formData);
                $this->view->form = $form;
            }
        } else {
            $this->view->form = $form;
        }
    }
}
