<?php
/**
 * Contains News DAO class
 *
 * License:
 *
 * Copyright (c) 2009, JPL Web Solutions,
 * Jesse Lesperance <jesse@jplesperance.com>
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
 * @package Bugs
 * @subpackage Model
 * @author Jesse Lesperance <jesse@jplesperance.com>
 * @copyright 2010 JPL Web Solutions
 * @license http://www.gnu.org/licenses/gpl-3.0-standalone.html GNU General Public License
 *
 */
/**
 * Bugs model
 *
 * This class is a DAO class
 *
 * @uses       Default_Model_Bugs
 * @package    Bugs
 * @subpackage Model
 */
class Default_Model_Bugs
{
    /**
     * @var unknown_type
     */
    protected $_status;
    protected $_priority;
    protected $_description;
    protected $_url;
    protected $_date;
    protected $_email;
    protected $_author;
    protected $_id;
    protected $_mapper;
    public function __construct (array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions(
            $options);
        }
    }
    /**
     * Set object state
     *
     * @param  array $options
     * @return Default_Model_Guestbook
     */
    public function setOptions (array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst(
            $key);
            if (in_array($method, 
            $methods)) {
                $this->$method(
                $value);
            }
        }
        return $this;
    }
    public function __get ($name)
    {
        $method = 'get' . $name;
        if ('mapper' == $name || ! method_exists(
        $this, $method)) {
            throw new Exception(
            'Invalid property specified');
        }
        return $this->$method();
    }
    public function __set ($name, $value)
    {
        $method = 'set' . $name;
        if ('mapper' == $name || ! method_exists(
        $this, $method)) {
            throw Exception(
            'Invalid property specified');
        }
        $this->$method($value);
    }
    /**
     * @return the $_status
     */
    public function getStatus ()
    {
        return $this->_status;
    }
    /**
     * @return the $_priority
     */
    public function getPriority ()
    {
        return $this->_priority;
    }
    /**
     * @return the $_description
     */
    public function getDescription ()
    {
        return $this->_description;
    }
    /**
     * @return the $_url
     */
    public function getUrl ()
    {
        return $this->_url;
    }
    /**
     * @return the $_date
     */
    public function getDate ()
    {
        return $this->_date;
    }
    /**
     * @return the $_email
     */
    public function getEmail ()
    {
        return $this->_email;
    }
    /**
     * @return the $_author
     */
    public function getAuthor ()
    {
        return $this->_author;
    }
    /**
     * @return the $_id
     */
    public function getId ()
    {
        return $this->_id;
    }
    /**
     * @param $_status the $_status to set
     */
    public function setStatus ($status)
    {
        $this->_status = $status;
        return $this;
    }
    /**
     * @param $_priority the $_priority to set
     */
    public function setPriority ($priority)
    {
        $this->_priority = $priority;
        return $this;
    }
    /**
     * @param $_description the $_description to set
     */
    public function setDescription ($description)
    {
        $this->_description = $description;
        return $this;
    }
    /**
     * @param $_url the $_url to set
     */
    public function setUrl ($url)
    {
        $this->_url = $url;
        return $this;
    }
    /**
     * @param $_date the $_date to set
     */
    public function setDate ($date)
    {
        $this->_date = $date;
        return $this;
    }
    /**
     * @param $_email the $_email to set
     */
    public function setEmail ($email)
    {
        $this->_email = $email;
        return $this;
    }
    /**
     * @param $_author the $_author to set
     */
    public function setAuthor ($author)
    {
        $this->_author = $author;
        return $this;
    }
    /**
     * @param $_id the $_id to set
     */
    public function setId ($id)
    {
        $this->_id = $id;
        return $this;
    }
    /**
     * Set data mapper
     *
     * @param  mixed $mapper
     * @return Default_Model_Guestbook
     */
    public function setMapper ($mapper)
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
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(
            new Default_Model_BugsMapper());
        }
        return $this->_mapper;
    }
    /**
     * Save the current entry
     *
     * @return void
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
    /**
     * Fetch all entries
     *
     * @return array
     */
    public function fetchAll ($filters = array(), $sortField = null, $limit = null, $page = 1 )
    {
        return $this->getMapper()->fetchAll($filters, $sortField, $limit, $page);
    }
    
    public function deleteBug($id){
        $this->getMapper()->deleteBug($id);
    }
}
?>