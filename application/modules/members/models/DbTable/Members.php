<?php
/**
 * Members
 *
 * @author Jesse
 * @version
 */
require_once 'Zend/Db/Table/Abstract.php';
class Members_Model_DbTable_Members extends Zend_Db_Table_Abstract
{
	/**
	 * The default table name
	 */
	protected $_name = 'members';
	protected $_sequence = true;
}
