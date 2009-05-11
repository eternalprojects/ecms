<?php

/**
 * IndexController - The default controller class
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class IndexController extends Zend_Controller_Action 
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction() 
    {
        $this->_redirect('/view/latest');
    }
}
