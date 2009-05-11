<?php
/**
 * ViewController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class ViewController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
	public function init(){
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
		$this->view->siteName = Zend_Registry::get('config')->site->name;
		$this->view->slogan = Zend_Registry::get('config')->site->slogan;
	}
    public function indexAction ()
    {
        $this->_helper->redirector('latest');
    }
    public function latestAction ()
    {
        $news = new News();
        $config = Zend_Registry::get('config');
        $limit = (int) $config->limit->latest;
        $this->view->title = 'Latest News';
        $this->view->footerTitle = $config->footer->title;
        $this->view->footerLink = $config->footer->link;
        $this->view->news = $news->fetchAll(null, 'id DESC', $limit);
    }
    public function popularAction ()
    {
        $news = new News();
        $config = Zend_Registry::get('config');
        $limit = (int) $config->limit->popular;
        $this->view->title = 'Most Popular';
        $this->view->footerTitle = $config->footer->title;
        $this->view->footerLink = $config->footer->link;
        $this->view->news = $news->fetchAll(null, 'views DESC', $limit);
    }
    public function allAction ()
    {
        $db = Zend_Registry::get('db');
        $config = Zend_Registry::get('config');
        $limit = (int) $config->limit->perpage;
        $this->view->title = 'All News';
        $this->view->footerTitle = $config->footer->title;
        $this->view->footerLink = $config->footer->link;
        $page = $this->_request->getParam('page', 1);
        $select = $db->select();
        $select->from('news');
        $select->order('id DESC');
        $pagination = Zend_Paginator::factory($select);
        $pagination->setCurrentPageNumber($page);
        $pagination->setItemCountPerPage($limit);
        $pagination->setDefaultScrollingStyle('Elastic');
        $this->view->news = $pagination->getItemsByPage($page);
        $this->view->paginator = $pagination;
    }
    public function cssAction ()
    {}
    
    public function articleAction(){
        $sid = $this->_request->getParam('sid');
        $news = new News;
        $row = $news->find($sid);
        $rows = $row->toArray();
        $views = (int)$rows[0]['views'] + 1;
        $data = array('views'=> $views);
        $where = $news->getAdapter()->quoteInto('id = ?',$sid);
        $news->update($data, $where);
        $this->view->title = $rows[0]['title'];
        $this->view->author = $rows[0]['author'];
        $this->view->created = $rows[0]['created'];
        $this->view->views = $rows[0]['views'];
        $this->view->summary = $rows[0]['summary'];
        $this->view->content = $rows[0]['content'];
        
    }
}
