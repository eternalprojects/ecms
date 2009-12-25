<?php
class Admin_NewsController extends eCMS_Controller_Action
{
    public function init ()
    {
        parent::init();
        $this->news = new Default_Model_News();
        $this->settings = Zend_Registry::get('settings');
        $this->view->footerTitle = $this->settings->footer->title;
        $this->view->footerLink = $this->settings->footer->link;
    }
    public function indexAction ()
    {
        $this->view->title = "Site Administration: Published News";
        $page = $this->_request->getParam('page', 1);
        $paginator = $this->news->fetchAllNews($page, $this->settings->limit->perpage);
        $this->view->news = $paginator->getItemsByPage($page);
        $this->view->paginator = $paginator;
    }
    public function editAction ()
    {
        if (! $sid = (int) $this->_request->getParam('sid')) {
            $this->_redirect('/admin/news');
        }
        $this->view->title = "Site Administration: Edit News Story";
        $form = new Admin_Form_EditNews();
        $this->news->find($sid);
        $form->setAction('/admin/news/edit/' . $sid);
        if ($this->_request->isPost()) {
            $formData = $this->_request->getParams();
            if ($sid != $formData['id']) {
                $this->_redirect('/admin/news');
            }
            if ($form->isValid($formData)) {
                $data = $form->getValues();
                $news = new Default_Model_News($data);
                $news->setId($sid);
                $news->save();
                $this->_redirect('/view/article/sid/' . $sid);
            } else {
                $form->populate($formData);
                $this->view->form = $form;
            }
        } else {
            $form->getElement('title')->setValue($this->news->getTitle());
            $form->getElement('summary')->setValue($this->news->getSummary());
            $form->getElement('content')->setValue($this->news->getContent());
            $form->getElement('author')->setValue($this->news->getAuthor());
            $form->getElement('id')->setValue($sid);
            $this->view->form = $form;
        }
    }
    public function deleteAction ()
    {
        $this->view->title = "Site Administration: Delete News Story";
        if (! $sid = (int) $this->_request->getParam('sid'))
            $this->_redirect('/admin/news');
        if ($this->_request->getParam('confirm') && $this->_request->getParam('confirm') == 1) {
            $this->_removeArticle($sid);
            $this->_redirect('/admin/news');
        }
        $news = new Default_Model_News();
        $news->find($sid);
        $this->view->sid = $news->getId();
        $this->view->articleTitle = $news->getTitle();
    }
    // This needs to be moved to the News DAO/Mapper
    private function _removeArticle ($sid)
    {
        $news = new Default_Model_News();
        $news->find($sid);
        $news->deleteStory($sid);
    }
}
