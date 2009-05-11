<?php
/**
 * News
 *  
 * @author Jesse
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';
class News extends Zend_Db_Table_Abstract
{
    /**
     * The default table name 
     */
    protected $_name = 'news';
    protected $_sequence = true;
}
