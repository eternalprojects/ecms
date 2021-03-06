<?php
/**
 * Members data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 *
 * @uses       Default_Model_DbTable_Guestbook
 * @package    QuickStart
 * @subpackage Model
 */
class Members_Model_MembersMapper
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
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
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
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Members_Model_DbTable_Members');
        }
        return $this->_dbTable;
    }
    /**
     * Save a guestbook entry
     *
     * @param  Default_Model_Guestbook $guestbook
     * @return void
     */
    public function save (Members_Model_Members $members)
    {
        $row = $this->getDbTable()->createRow();
        $row->fname = $members->getFirstName();
        $row->lname = $members->getLastName();
        $row->email = $members->getEmail();
        $row->uname = $members->getUsername();
        $row->pword = md5($members->getPassword());
        $row->active = 0;
        $row->joined = date('Y-m-d H:i:s');
        return $row->save();
    }
    public function updateEmail ($email)
    {
        $data['email'] = $email;
        $this->getDbTable()->update($data, $this->getDbTable()->getAdapter()->quoteInto('uname = ?', Zend_Auth::getInstance()->getIdentity()->uname));
    }
    public function updatePassword ($password)
    {
        $data['pword'] = md5($password);
        $this->getDbTable()->update($data, $this->getDbTable()->getAdapter()->quoteInto('uname = ?', Zend_Auth::getInstance()->getIdentity()->uname));
    }
    public function fetchMember (Members_Model_Members $members)
    {
        $select = $this->getDbTable()->select()->where('uname = ?', Zend_Auth::getInstance()->getIdentity());
        $row = $this->getDbTable()->fetchRow($select);
        $members->setId($row['id'])->setFirstName($row['fname'])->setLastName($row['lname'])->setUsername($row['username'])->setEmail($row['email'])->setActive($row['active'])->setJoined($row['joined']);
    }
    public function fetchAllMembers ($page, $limit, $style)
    {
        $select = $this->getDbTable()->select();
        $select->order('uname ASC');
        $pagination = Zend_Paginator::factory($select);
        $pagination->setCurrentPageNumber($page);
        $pagination->setItemCountPerPage($limit);
        $pagination->setDefaultScrollingStyle($style);
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
        return $pagination;
    }
    public function activateMember ($username)
    {
        $data['active'] = 1;
        $this->getDbTable()->update($data, $this->getDbTable()->getAdapter()->quoteInto('uname = ?', $username));
    }
    public function deactivateMember ($username)
    {
        $data['active'] = 0;
        $this->getDbTable()->update($data, $this->getDbTable()->getAdapter()->quoteInto('uname = ?', $username));
    }
}
