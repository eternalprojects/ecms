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
class Default_Model_MembersMapper
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
            $this->setDbTable('Default_Model_DbTable_Members');
        }
        return $this->_dbTable;
    }

    /**
     * Save a guestbook entry
     * 
     * @param  Default_Model_Guestbook $guestbook 
     * @return void
     */
    public function save(Default_Model_Members $members)
    {
		$data = array(
            'fname'		=> $members->getFirstName(),
			'lname'  	=> $members->getLastName(),
			'email'  	=> $members->getEmail(),
            'uname'   	=> $members->getUsername(),
            'pword'  	=> md5($members->getPassword()),
			'active'	=> 0,
			'joined' 	=> date('Y-m-d H:i:s'),
        );

        if (null === ($id = $members->getId())) {
            $this->getDbTable()->insert($data);
        } 
    }
    
    public function updateEmail($email){
    	$data['email'] = $email;
    	$this->getDbTable()->update($data, array('uname = ?' => Zend_Auth::getInstance()->getIdentity()));
    }
    
    public function updatePassword($password){
    	$data['password'] = md5($password);
    	$this->getDbTable()->update($data, array('uname = ?' => Zend_Auth::getInstance()->getIdentity()));
    }
    
    public function fetchMember(Members_Model_Members $members){
    	$select = $this->getDbTable()->select()->where('uname = ?', Zend_Auth::getInstance()->getIdentity());
    	$row = $this->getDbTable()->fetchRow($select);
    	$members->setId($row['id'])
    		->setFirstName($row['fname'])
    		->setLastName($row['lname'])
    		->setUsername($row['username'])
    		->setEmail($row['email'])
    		->setPassword($row['pword'])
    		->setActive($row['active'])
    		->setJoined($row['joined']);
    }
}