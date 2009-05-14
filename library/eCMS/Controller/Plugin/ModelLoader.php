<?php

require_once ('Zend/Controller/Plugin/Abstract.php');

class eCMS_Controller_Plugin_ModelLoader extends Zend_Controller_Plugin_Abstract {
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		$moduleName = $request->getModuleName();
		$base_dir = Zend_Registry::get('base_dir');
		set_include_path(get_include_path() . PATH_SEPARATOR . $base_dir . '/application/modules/'. $moduleName .'/models');
	}
}

?>