<?php

/**
 * Guestbook data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 *
 * @uses       Default_Model_DbTable_Guestbook
 * @package    QuickStart
 * @subpackage Model
 */
class Default_Model_NewsMapper
{
	/**
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_dbTable;
	
	/**
	 * Specify Zend_Db_Table instance to use for data operations
	 *
	 * @param  Zend_Db_Table_Abstract $dbTable
	 * @return Default_Model_GuestbookMapper
	 */
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	/**
	 * Get registered Zend_Db_Table instance
	 *
	 * Lazy loads Default_Model_DbTable_Guestbook if no instance registered
	 *
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Default_Model_DbTable_News');
		}
		return $this->_dbTable;
	}

	/**
	 * Save a guestbook entry
	 *
	 * @param  Default_Model_Guestbook $guestbook
	 * @return void
	 */
	public function save(Default_Model_News $news)
	{
		$filter = new Default_Model_BadWordFilter();
		$data = array(
            'title'	   => $filter->filter($news->getTitle()),
			'summary'  => $filter->filter($news->getSummary()),
			'content'  => $filter->filter($news->getContent()),
            'author'   => $news->getAuthor(),
            'created'  => date('Y-m-d H:i:s'),
			'modified' => date('Y-m-d H:i:s'),
		);

		if (!$id = $news->getId()) {
			$data['views'] = 0;
			$this->getDbTable()->insert($data);
		} else {
			unset($data['created']);
			$this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}

	public function addView(Default_Model_News $news){
		$data = array('views'=>$news->getViews() + 1);
		$this->getDbTable()->update($data, array('id = ?' => $news->getId()));
	}

	/**
	 * Find a guestbook entry by id
	 *
	 * @param  int $id
	 * @param  Default_Model_Guestbook $guestbook
	 * @return void
	 */
	public function find($id, Default_Model_News $news)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		
		$row = $result->current();
		$res = $this->_catTable->find($row->category);
		$crow = $res->current();
		$news->setId($row->id)
		->setTitle($row->title)
		->setSummary($row->summary)
		->setContent($row->content)
		->setAuthor($row->author)
		->setCreated($row->created)
		->setModified($row->modified)
		->setViews($row->views)
		->setCategory($crow->name);

	}

	/**
	 * Fetch all guestbook entries
	 *
	 * @return array
	 */
	public function fetchAll()
	{
		$db = $this->getDbTable()->getDefaultAdapter();
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'p.cat_id = c.id')->order('id DESC')->limit(10);
		$resultSet = $db->fetchAll($select);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Model_News();
			$entry->setId($row->id)
			->setTitle($row->title)
			->setSummary($row->summary)
			->setContent($row->content)
			->setAuthor($row->author)
			->setCreated($row->created)
			->setModified($row->modified)
			->setViews($row->views)
			->setMapper($this);
			$entries[] = $entry;
		}
		return $entries;
	}

	public function fetchLatest($limit)
	{
		$db = $this->getDbTable()->getDefaultAdapter();
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'p.cat_id = c.id')->order('id DESC')->limit(10);
		$resultSet = $db->fetchAll($select);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Model_News();
			$entry->setId($row->id)
			->setTitle($row->title)
			->setSummary($row->summary)
			->setContent($row->content)
			->setAuthor($row->author)
			->setCreated($row->created)
			->setModified($row->modified)
			->setViews($row->views)
			->setMapper($this);
			$entries[] = $entry;
		}
		return $entries;
	}

	public function fetchPopular($limit)
	{
		$resultSet = $this->getDbTable()->fetchAll(null, 'views DESC', (int)$limit);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Model_News();
			$entry->setId($row->id)
			->setTitle($row->title)
			->setSummary($row->summary)
			->setContent($row->content)
			->setAuthor($row->author)
			->setCreated($row->created)
			->setModified($row->modified)
			->setViews($row->views)
			->setMapper($this);
			$entries[] = $entry;
		}
		return $entries;
	}

	public function fetchPage($page, $limit, $style)
	{
		$select = $this->getDbTable()->select();
		$select->order('id DESC');
		$pagination = Zend_Paginator::factory($select);
		$pagination->setCurrentPageNumber($page);
		$pagination->setItemCountPerPage($limit);
		$pagination->setDefaultScrollingStyle($style);
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
		return $pagination;

	}

	public function fetchNewsByAuthor($author, $page, $limit, $style)
	{
		$select = $this->getDbTable()->select();
		$select->where('author = ?', $author)
		->order('created DESC');
		$pagination = Zend_Paginator::factory($select);
		$pagination->setCurrentPageNumber($page);
		$pagination->setItemCountPerPage($limit);
		$pagination->setDefaultScrollingStyle($style);
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
		return $pagination;

	}

	public function deleteStory($id){
		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?',$id);
		$this->getDbTable()->delete($where);
	}
	
	public function fetchAllNews($page, $limit, $style){
	    $select = $this->getDbTable()->select();
		$select->order('created DESC');
		$pagination = Zend_Paginator::factory($select);
		$pagination->setCurrentPageNumber($page);
		$pagination->setItemCountPerPage($limit);
		$pagination->setDefaultScrollingStyle($style);
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
		return $pagination;
	}
}
