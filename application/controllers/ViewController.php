<?php
/**
 * ViewController
 *
 * @author
 * @version
 */
require_once 'eCMS/Controller/Action.php';
class ViewController extends eCMS_Controller_Action
{
    private $_news;

    /**
     * The default action - show the home page
     */
    public function init()
    {
        parent::init();
        $this->settings          = Zend_Registry::get('settings');
        $this->view->footerTitle = $this->settings->footer->title;
        $this->view->footerLink  = $this->settings->footer->link;

    }

    public function __construct()
    {
        $this->_news = new Default_Model_News();
    }

    public function indexAction()
    {
        $this->_helper->redirector('latest');
    }

    public function latestAction()
    {
        $this->view->title = 'Latest News';
        $this->view->news  = $this->_news->fetchLatest((int)$this->settings->limit->latest);
    }

    public function popularAction()
    {
        $this->view->title = 'Most Popular';
        $this->view->news  = $this->_news->fetchPopular((int)$this->settings->limit->popular);
    }

    public function allAction()
    {
        $limit                 = (int)$this->settings->limit->perpage;
        $this->view->title     = 'All News';
        $page                  = $this->_request->getParam('page', 1);
        $paginator             = $this->news->fetchAllNews($page, $limit);
        $this->view->news      = $paginator->getItemsByPage($page);
        $this->view->paginator = $paginator;
    }

    public function articleAction()
    {
        $id = $this->_request->getParam('sid');
        $this->news->find($id);
        $this->view->title = $this->news->getTitle();
        $this->view->news  = $this->news;

    }
}
