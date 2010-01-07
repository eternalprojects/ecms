<?php
/**
 * Contains News Mapper class
 *
 * License:
 *
 * Copyright (c) 2009, JPL Web Solutions,
 *                     Jesse Lesperance <jesse@jplesperance.com>
 *
 * This file is part of EternalCMS.
 *
 * EternalCMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.  EternalCMS is distributed in the hope
 * that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * See the GNU General Public License for more details. You should have received
 * a copy of the GNU General Public License along with EternalCMS.
 *
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * @package News
 * @subpackage Model
 * @author Jesse Lesperance <jesse@jplesperance.com>
 * @copyright 2010 JPL Web Solutions
 * @license http://www.gnu.org/licenses/gpl-3.0-standalone.html GNU General Public License
 *
 */
/**
 * News data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 *
 * @uses       Default_Model_DbTable_News
 * @package    News
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
	 * @return Default_Model_NewsMapper
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
	 * Lazy loads Default_Model_DbTable_News if no instance registered
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
	 * @param  Default_Model_News $news
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
	/**
	 * Increments the number of view for a story
	 * 
	 * @param Default_Model_News $news
	 * @return void
	 */
	public function addView(Default_Model_News $news){
		$data = array('views'=>$news->getViews() + 1);
		$this->getDbTable()->update($data, array('id = ?' => $news->getId()));
	}

	/**
	 * Find a news story by id
	 *
	 * @param  int $id
	 * @param  Default_Model_News $news
	 * @return void
	 */
	public function find($id, Default_Model_News $news)
	{
		$db = $this->getDbTable()->getDefaultAdapter();
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'n.cat_id = c.id')->where('n.id = ?', $id)->order('n.id DESC')->limit(10);
		$row = $db->fetchRow($select,null,Zend_Db::FETCH_OBJ);

		$news->setId($row->id)
		->setTitle($row->title)
		->setSummary($row->summary)
		->setContent($row->content)
		->setAuthor($row->author)
		->setCreated($row->created)
		->setModified($row->modified)
		->setViews($row->views)
		->setCategory($row->name);

	}

	/**
	 * Fetch all News Stories
	 *
	 * @return array
	 */
	public function fetchAll()
	{
		$db = $this->getDbTable()->getDefaultAdapter();
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'n.cat_id = c.id')->order('n.id DESC')->limit(10);
		$resultSet = $db->fetchAll($select);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Model_News();
			$entry->setId($row->id)
			->setTitle($row->title)
			->setSummary($row->summary)
			->setContent($row->content)
			->setAuthor($row->author)
			->setCategory($row->name)
			->setCreated($row->created)
			->setModified($row->modified)
			->setViews($row->views)
			->setMapper($this);
			$entries[] = $entry;
		}
		return $entries;
	}
	/**
	 * Fetch the most recent news stories
	 * 
	 * @param int $limit
	 * @return array
	 */
	public function fetchLatest($limit)
	{
		$db = $this->getDbTable()->getDefaultAdapter();
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'n.cat_id = c.id')->order('n.id DESC')->limit(10);
		$resultSet = $db->fetchAll($select,null,Zend_Db::FETCH_OBJ);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Model_News();
			$entry->setId($row->id)
			->setTitle($row->title)
			->setSummary($row->summary)
			->setContent($row->content)
			->setAuthor($row->author)
			->setCategory($row->name)
			->setCreated($row->created)
			->setModified($row->modified)
			->setViews($row->views)
			->setMapper($this);
			$entries[] = $entry;
		}
		return $entries;
	}
	/**
	 * Fetch the stories with the most views
	 * 
	 * @param int $limit
	 * @return array
	 */
	public function fetchPopular($limit)
	{
		$db = $this->getDbTable()->getDefaultAdapter();
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'n.cat_id = c.id')->order('n.views DESC')->limit(10);
		$resultSet = $db->fetchAll($select,null,Zend_Db::FETCH_OBJ);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Model_News();
			$entry->setId($row->id)
			->setTitle($row->title)
			->setSummary($row->summary)
			->setContent($row->content)
			->setAuthor($row->author)
			->setCategory($row->name)
			->setCreated($row->created)
			->setModified($row->modified)
			->setViews($row->views)
			->setMapper($this);
			$entries[] = $entry;
		}
		return $entries;
	}
	/**
	 * Fetch stories for a specific page number
	 * 
	 * @param int $page
	 * @param int $limit
	 * @param string $style
	 * @return Zend_Paginator
	 */
	public function fetchPage($page, $limit, $style)
	{
		$db = $this->getDbTable()->getDefaultAdapter();
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'n.cat_id = c.id')->order('n.created DESC');
		$pagination = Zend_Paginator::factory($select);
		$pagination->setCurrentPageNumber($page);
		$pagination->setItemCountPerPage($limit);
		$pagination->setDefaultScrollingStyle($style);
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
		return $pagination;

	}
	/**
	 * Fetch stories submitted by specified author
	 * 
	 * @param string $author The author of the stories we are requesting
	 * @param int $page The page number the user is viewing
	 * @param int $limit The number of entries to display on the page
	 * @param string $style The style of the Pagination control
	 * @return Zend_Paginator
	 */
	public function fetchNewsByAuthor($author, $page, $limit, $style)
	{
		$db = $this->getDbTable()->getDefaultAdapter();
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'n.cat_id = c.id');
		$select->where('n.author = ?', $author)
		->order('n.created DESC');
		$pagination = Zend_Paginator::factory($select);
		$pagination->setCurrentPageNumber($page);
		$pagination->setItemCountPerPage($limit);
		$pagination->setDefaultScrollingStyle($style);
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
		return $pagination;

	}
	/**
	 * Delete the specified story from the database
	 * 
	 * @param int $id
	 * @return void
	 */
	public function deleteStory($id){
		$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?',$id);
		$this->getDbTable()->delete($where);
	}
	/**
	 * Fetch all the news entries
	 * 
	 * @param int $page
	 * @param int $limit
	 * @param string $style
	 * @return Zend_Paginator
	 */
	public function fetchAllNews($page, $limit, $style){
		$db = $this->getDbTable()->getDefaultAdapter();
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$select = $db->select()->from(array('n'=>'news'))->join(array('c'=>'categories'),'n.cat_id = c.id')->order('n.created DESC');
		$pagination = Zend_Paginator::factory($select);
		$pagination->setCurrentPageNumber($page);
		$pagination->setItemCountPerPage($limit);
		$pagination->setDefaultScrollingStyle($style);
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
		return $pagination;
	}
}
