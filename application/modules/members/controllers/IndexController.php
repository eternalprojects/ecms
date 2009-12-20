<?php
/**
 * IndexController
 *
 * @author
 * @version
 */
require_once 'Zend/Controller/Action.php';
class Members_IndexController extends Zend_Controller_Action
{
	/**
	 * The default action - show the home page
	 */
	public function indexAction ()
	{
		$this->_redirect('/');
	}
}
?>

