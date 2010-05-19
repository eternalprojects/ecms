<?php
/**
 * Contains Bugs Mapper class
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
 * Bugs data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 *
 * @uses       Default_Model_DbTable_Bugs
 * @package    Bugs
 * @subpackage Model
 */
class Default_Model_BugsMapper
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
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception(
            'Invalid table data gateway provided');
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
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable(
            'Default_Model_DbTable_Bugs');
        }
        return $this->_dbTable;
    }
    /**
     * Save a guestbook entry
     * 
     * @uses Default_Model_News
     * @uses Default_Model_BadWord_Filter
     * @param  Default_Model_News $news
     * @return void
     */
    public function save (Default_Model_Bugs $bugs)
    {
        $dateObject = new Zend_Date(
        $bugs->getDate());
        $data = array(
        'author' => $bugs->getAuthor(), 
        'email' => $bugs->getEmail(), 
        'date' => $dateObject->get(
        Zend_Date::TIMESTAMP), 
        'url' => $bugs->getUrl(), 
        'description' => $bugs->getDescription(), 
        'priority' => 'normal', 
        'status' => 'new');
        $this->getDbTable()->insert($data);
    }
    public function fetchAll ($filters, $sortField, $limit, 
    $page)
    {
        $db = $this->getDbTable()->getDefaultAdapter();
        $db->setFetchMode ( Zend_Db::FETCH_OBJ );
        $select = $db->select()->from('bugs');
        if (count($filters) > 0) {
            foreach ($filters as $field => $filter) {
                $select->where($field . ' = ?', $filter);
            }
        }
        // add the sort field is it is set
        if (null != $sortField) {
            $select->order($sortField);
        }
		$pagination = Zend_Paginator::factory ( $select );
		$pagination->setCurrentPageNumber ( $page );
		$pagination->setItemCountPerPage ( $limit );
		$pagination->setDefaultScrollingStyle ( 'elastic' );
		Zend_View_Helper_PaginationControl::setDefaultViewPartial ( 'pagination.phtml' );
		return $pagination;
    }
    
    public function deleteBug($id){
        $where = $this->getDbTable ()->getAdapter ()->quoteInto ( 'id = ?', $id );
		$this->getDbTable ()->delete ( $where );
    }
}
?>