<?php
/**
 *
 * @author jesse
 * @version
 */
require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * GenerateMenu Action Helper
 *
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class eCMS_Controller_Action_Helper_GenerateMenu extends Zend_Controller_Action_Helper_Abstract {
	/**
	 * @var Zend_Loader_PluginLoader
	 */
	public $pluginLoader;

	/**
	 * Constructor: initialize plugin loader
	 *
	 * @return void
	 */
	public function __construct() {
		// TODO Auto-generated Constructor
		$this->pluginLoader = new Zend_Loader_PluginLoader ( );
	}

	public function getMenu($user = false) {
		$menu['general'][] = 	 array('uri'=>'/','label'=>'News','type'=>'navighead');
		$menu['general'][] =    array('uri'=>'/view/popular','label'=>'Most Popular','type'=>'navig');
		$menu['general'][] =    array('uri'=>'/view/all','label'=>'All News','type'=>'navig');
		if($user)
		$menu['general'][] =    array('uri'=>'/add','label'=>'Submit News','type'=>'navig');

		if(!$user)
		$menu['member'][] =    array('uri'=>'/members/register','label'=>'Register','type'=>'navig');
		if(!$user)
		$menu['member'][] =    array('uri'=>'/members/auth/login','label'=>'Login','type'=>'navig');
		if($user)
		$menu['member'][] =    array('uri'=>'/members/submissions/view','label'=>'My Submissions','type'=>'navig');
		if($user)
		$menu['member'][] =    array('uri'=>'/members/password/change','label'=>'Change Password','type'=>'navig');
		if($user)
		$menu['member'][] = 	 array('uri'=>'/members/email/change','label'=>'Change Email Address','type'=>'navig');
		if(!$user)
		$menu['member'][] =    array('uri'=>'/members/password/forgot','label'=>'Forgot Password','type'=>'navig');
		if($user)
		$menu['member'][] =    array('uri'=>'/members/auth/logout','label'=>'Logout','type'=>'navig');

			

		return $menu;

	}

	/**
	 * Strategy pattern: call helper as broker method
	 */
	public function direct($user = null) {
		return $this->getMenu($user);
	}
}

