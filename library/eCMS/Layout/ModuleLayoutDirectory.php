<?php

require_once ('Zend/Layout/Controller/Plugin/Layout.php');

class eCMS_Layout_ModuleLayoutDirectory extends Zend_Layout_Controller_Plugin_Layout {
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		$moduleName = $request->getModuleName();
		switch($moduleName){
			case $moduleName:
				$this->_moduleChange($moduleName);
				break;
		}
	}

	protected function _moduleChange($moduleName){
		$this->getLayout()->setLayoutPath(dirname(dirname($this->getLayout()->getLayoutPath())) . DIRECTORY_SEPARATOR . $moduleName .'/layouts');
	}
}
