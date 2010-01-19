<?php

/**
 * Categories
 *  
 * @author lesperancej
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Admin_Model_DbTable_Categories extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'categories';
	protected $_sequence = true;

}

