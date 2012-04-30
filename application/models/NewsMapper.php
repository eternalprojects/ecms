<?php
/**
 * Contains News Mapper class
 *
 * License:
 *
 * Copyright (c) 2009-2012, JPL Web Solutions,
 *                     Jesse P Lesperance <jesse@jplesperance.me>
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
 * @author     Jesse P Lesperance <jesse@jplesperance.me>
 * @copyright  2009-2012 JPL Web Solutions
 * @license    http://www.gnu.org/licenses/gpl-3.0-standalone.html GNU General Public License
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
 * @since      0.2
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
     * @param string $dbTable
     *
     * @return void
     * @since v0.2
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable ();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception ('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
    }

    /**
     * Get registered Zend_Db_Table instance
     *
     * Lazy loads Default_Model_DbTable_News if no instance registered
     *
     * @since v0.2
     * @return Default_Model_DbTable_News
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
     * @uses Default_Model_News
     * @uses Default_Model_BadWord_Filter
     *
     * @param  Default_Model_News $news
     *
     * @return void
     */
    public function save(Default_Model_News $news)
    {

        if ($news->getId() == 0) {
            $this->getDbTable()->insert((array)$news);
        } else {
            $this->getDbTable()->update((array)$news, array('id=?'=> $news->getId()));
        }
    }


    /**
     * Find a news story by id
     *
     * @uses Default_Model_News
     *
     * @param  int                $id
     * @param  Default_Model_News $news
     *
     * @return void
     */
    public function find($id, Default_Model_News $news)
    {
        $db     = $this->getDbTable()->getDefaultAdapter();
        $select = $db->select()->from(array('n' => 'news'))
            ->join(array('c' => 'categories'), 'n.cat_id = c.id', array('c.name'))
            ->where('n.id = ?', $id)
            ->order('n.id DESC');
        $row    = $db->fetchRow($select, null, Zend_Db::FETCH_OBJ);

        $news->setOptions((array)$row);
        return $news;
    }

    /**
     * Retrieve several news articles at the same time
     *
     * This method allows for the retrieval of sets of news articles.  There are optional parameters to allow for
     * customising the sorting of the result set.  The optional limit and offset parameters allow this method to be
     * used in conjunction with Zend_Paginator.
     *
     * @uses  Default_Model_News
     *
     * @param int    $limit
     * @param int    $offset
     * @param string $sortBy
     * @param string $order
     *
     * @return array
     * @since v0.5.2
     */
    public function fetchMany($limit = 0, $offset = 0, $sortBy = 'id', $order = 'DESC')
    {
        $db     = $this->getDbTable()->getDefaultAdapter();
        $select = $db->select()
            ->from(array('n'=> 'news'))
            ->join(array('c'=> 'categories'), 'n.cat_id = c.id', array(c . name))
            ->order("n.${sortBy} ${order}");
        if ($limit > 0) {
            $select->limit($limit, $offset);

        }
        $resultSet = $db->fetchAll($select, null, Zend_Db::FETCH_OBJ);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry      = new Default_Model_News ((array)$row);
            $entries [] = $entry;
        }
        return $entries;


    }

    /**
     * Delete the specified story from the database
     *
     * @param int $id
     *
     * @return void
     * @since v0.2
     */
    public function delete($id)
    {
        $where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
        $this->getDbTable()->delete($where);
    }

    /**
     * @param int    $page
     * @param int    $limit
     * @param string $type
     * @param string $value
     *
     * @return Zend_Paginator
     * @since v0.5.2
     */
    public function fetchNewsPage($page = 1, $limit = 10, $type = '', $value = '')
    {
        $db = $this->getDbTable()->getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = $db->select()->from(array('n' => 'news'))
            ->join(array('c' => 'categories'), 'n.cat_id = c.id', array('c.name'))
            ->order('n.id DESC');
        switch ($type) {
        case 'author':
            $select->where('author = ?', $value);
            break;
        case 'category':
            $select->where('n.cat_id = ?', $value);
            break;
        default:
            break;

        }
        $pagination = Zend_Paginator::factory($select);
        $pagination->setCurrentPageNumber($page);
        $pagination->setItemCountPerPage($limit);
        return $pagination;
    }
}
