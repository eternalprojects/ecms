<?php
/**
 * Contains News DAO class
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
 * News model
 *
 * This class is a DAO class
 *
 * @uses       Default_Model_News
 * @package    News
 * @subpackage Model
 */
class Default_Model_News
{
	/**
	 * 
	 */
	protected $_category;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_views;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_modified;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_created;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_author;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_content;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_summary;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_title;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_id;
	/**
	 * 
	 * @var unknown_type
	 */
	protected $_mapper;
	/**
	 * Constructor
	 *
	 * @param  array|null $options
	 * @return void
	 */
	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}

	/**
	 * Overloading: allow property access
	 *
	 * @param  string $name
	 * @param  mixed $value
	 * @return void
	 */
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if ('mapper' == $name || !method_exists($this, $method)) {
			throw Exception('Invalid property specified');
		}
		$this->$method($value);
	}

	/**
	 * Overloading: allow property access
	 *
	 * @param  string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		$method = 'get' . $name;
		if ('mapper' == $name || !method_exists($this, $method)) {
			throw new Exception('Invalid property specified');
		}
		return $this->$method();
	}

	/**
	 * Set object state
	 *
	 * @param  array $options
	 * @return Default_Model_Guestbook
	 */
	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}
	/**
	 * 
	 * @param unknown_type $category
	 */
	public function setCategory($category){
		$this->_category = $category;
		return $this;
	}
	/**
	 * 
	 */
	public function getCategory(){
		return $this->_category;
	}
	/**
	 * 
	 * @param unknown_type $views
	 */
	public function setViews($views)
	{
		$this->_views = $views;
		return $this;
	}

	public function getViews()
	{
		return $this->_views;
	}

	public function setModified($ts)
	{
		$this->_modified = $ts;
		return $this;
	}

	public function getModified()
	{
		return $this->_modified;
	}

	public function setCreated($ts)
	{
		$this->_created = $ts;
		return $this;
	}

	public function getCreated()
	{
		return $this->_created;
	}

	public function setAuthor($author)
	{
		$this->_author = $author;
		return $this;
	}

	public function getAuthor()
	{
		return $this->_author;
	}

	public function setContent($content)
	{
		$this->_content = $content;
		return $this;
	}

	public function getContent()
	{
		return $this->_content;
	}

	public function setSummary($summary)
	{
		$this->_summary = $summary;
		return $this;
	}

	public function getSummary()
	{
		return $this->_summary;
	}

	public function setTitle($title)
	{
		$this->_title = $title;
		return $this;
	}

	public function getTitle()
	{
		return $this->_title;
	}

	public function setid($id)
	{
		$this->_id = $id;
		return $this;
	}

	public function getId()
	{
		return $this->_id;
	}

	/**
	 * Set data mapper
	 *
	 * @param  mixed $mapper
	 * @return Default_Model_Guestbook
	 */
	public function setMapper($mapper)
	{
		$this->_mapper = $mapper;
		return $this;
	}

	/**
	 * Get data mapper
	 *
	 * Lazy loads Default_Model_GuestbookMapper instance if no mapper registered
	 *
	 * @return Default_Model_GuestbookMapper
	 */
	public function getMapper()
	{
		if (null === $this->_mapper) {
			$this->setMapper(new Default_Model_NewsMapper());
		}
		return $this->_mapper;
	}

	/**
	 * Save the current entry
	 *
	 * @return void
	 */
	public function save()
	{
		$this->getMapper()->save($this);
	}

	public function addView()
	{
		$this->getMapper()->addView($this);
	}
	/**
	 * Find an entry
	 *
	 * Resets entry state if matching id found.
	 *
	 * @param  int $id
	 * @return Default_Model_Guestbook
	 */
	public function find($id)
	{
		$this->getMapper()->find($id, $this);
	}

	/**
	 * Fetch all entries
	 *
	 * @return array
	 */
	public function fetchAll()
	{
		return $this->getMapper()->fetchAll();
	}

	public function fetchLatest($limit = 10)
	{
		return $this->getMapper()->fetchLatest($limit);
	}

	public function fetchPopular($limit = 10)
	{
		return $this->getMapper()->fetchPopular($limit);
	}

	public function fetchPage($page = 1, $limit = 10, $style = 'elastic')
	{
		return $this->getMapper()->fetchPage($page, $limit, $style);
	}

	public function fetchNewsByAuthor($author, $page = 1, $limit = 10, $style = 'elastic'){
		return $this->getMapper()->fetchNewsByAuthor($author, $page, $limit, $style);
	}

	public function deleteStory($id){
		$this->getMapper()->deleteStory($id);
	}
	
	public function fetchAllNews($page, $limit, $style = 'elastic'){
	    return $this->getMapper()->fetchAllNews($page, $limit, $style);
	}
	
	public function fetchNewsByCategory($category, $page, $limit, $style = 'elastic'){
		return $this->getMapper()->fetchNewsByCategory($category, $page, $limit, $style);
	}
}
