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
 * @package    News
 * @subpackage Model
 * @author     Jesse Lesperance <jesse@jplesperance.com>
 * @copyright  2009-2012 JPL Web Solutions
 * @license    http://www.gnu.org/licenses/gpl-3.0-standalone.html GNU General Public License
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
 * @since      v0.2
 */
class Default_Model_News
{
    /**
     * @var string
     */
    protected $_category;
    /**
     *
     * @var int
     */
    protected $_views = 0;
    /**
     *
     * @var string
     */
    protected $_modified;
    /**
     *
     * @var string
     */
    protected $_created;
    /**
     *
     * @var string
     */
    protected $_author;
    /**
     *
     * @var string
     */
    protected $_content;
    /**
     *
     * @var string
     */
    protected $_summary;
    /**
     *
     * @var string
     */
    protected $_title;
    /**
     *
     * @var int
     */
    protected $_id = 0;
    /**
     *
     * @var Default_Model_NewsMapper
     */
    protected $_mapper;

    /**
     * Constructor
     *
     * @param  array|null $options
     *
     * @return void
     */
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
        $this->_mapper = new Default_Model_NewsMapper();
    }

    /**
     * Overloading: allow property access
     *
     * @param  string $name
     * @param  mixed  $value
     *
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
     *
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
     *
     * @return Default_Model_News
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
     * @param string $category
     *
     * @return void
     */
    public function setCategory($category)
    {
        $this->_category = $category;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     *
     * @param int $views
     *
     * @return void
     */
    public function setViews($views)
    {
        $this->_views = $views;

    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->_views;
    }

    /**
     * @param string $ts
     *
     * @return void
     */
    public function setModified($ts)
    {
        $this->_modified = $ts;
    }

    /**
     * @return string
     */
    public function getModified()
    {
        return $this->_modified;
    }

    /**
     * @param string $ts
     *
     * @return void
     */
    public function setCreated($ts)
    {
        $this->_created = $ts;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->_created;
    }

    public function setAuthor($author)
    {
        $this->_author = $author;
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
    }

    public function getSummary()
    {
        return $this->_summary;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setid($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set data mapper
     *
     * @param  mixed $mapper
     *
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
        $this->_mapper->save($this);
    }

    public function incrementViews()
    {
        $this->_views++;
        $this->_mapper->save($this);
    }

    /**
     * Find an entry
     *
     * Resets entry state if matching id found.
     *
     * @param  int $id
     *
     * @return Default_Model_Guestbook
     */
    public function find($id)
    {
        return $this->getMapper()->find($id, $this);
    }

    /**
     * Fetch all entries
     *
     * @return array
     */
    public function fetchAll()
    {
        return $this->_mapper->fetchMany();
    }

    public function fetchLatest($limit = 10)
    {
        return $this->_mapper->fetchMany($limit, 0, 'created');
    }

    public function fetchPopular($limit = 10)
    {
        return $this->_mapper->fetchMany($limit, 0, 'views');
    }

    public function fetchAllNews($page = 1, $limit = 10, $style = 'elastic')
    {
        $pag = $this->getMapper()->fetchNewsPage($page, $limit);
        $pag->setDefaultScrollingStyle($style);
        return $pag;
    }

    public function fetchNewsByAuthor($author, $page = 1, $limit = 10, $style = 'elastic')
    {
        $pag = $this->getMapper()->fetchNewsPage($page, $limit, 'author', $author);
        $pag->setDefaultScrollingStyle($style);
        return $pag;
    }

    public function deleteStory($id)
    {
        $this->getMapper()->delete($id);
    }

    public function fetchNewsByCategory($category, $page, $limit, $style = 'elastic')
    {
        $pag = $this->getMapper()->fetchNewsPage($page, $limit, 'category', $category);
        $pag->setDefaultScrollingStyle($style);
        return $pag;
    }


}


