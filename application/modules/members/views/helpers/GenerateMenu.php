<?php
/**
 *
 * @author Jesse
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * GenerateMenu helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_GenerateMenu {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	/**
	 *  
	 */
public function generateMenu($user = false) {
		$menu[] = array('uri'=>'','label'=>'News','type'=>'navighead');
        $menu[] =    array('uri'=>'/view/latest','label'=>'Latest News','type'=>'navig');
        $menu[] =    array('uri'=>'/view/popular','label'=>'Most Popular','type'=>'navig');
        $menu[] =    array('uri'=>'/view/all','label'=>'All News','type'=>'navig');
        $menu[] =    array('uri'=>'/add','label'=>'Submit News','type'=>'navig');
        $menu[] =    array('uri'=>'','label'=>'Members','type'=>'navighead');
        if(!$user)
        	$menu[] =    array('uri'=>'/members/register','label'=>'Register','type'=>'navig');
        if(!$user)
        	$menu[] =    array('uri'=>'/members/auth/login','label'=>'Login','type'=>'navig');
        if($user)
        	$menu[] =    array('uri'=>'/members/password/change','label'=>'Change Password','type'=>'navig');
        if($user)
        	$menu[] = 	 array('uri'=>'/members/email/change','label'=>'Change Email Address','type'=>'navig');
        if(!$user)
        	$menu[] =    array('uri'=>'/members/password/forgot','label'=>'Forgot Password','type'=>'navig');
        if($user)
        	$menu[] =    array('uri'=>'/members/auth/logout','label'=>'Logout','type'=>'navig');
            
			
		
		return $menu;
	}
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
