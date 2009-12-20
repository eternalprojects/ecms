<?php

class Members_Form_ChangePassword extends Zend_Form
{
	public function init()
	{
		$this->setMethod('post');

		$this->addElement('password','oldPassword',array('required'=>true,'label'=>'Current Password'));
		$this->addElement('password','password',array('required'=>true,'label'=>'New Password','validators'=>array(array('validator'=>'regex', 'options'=>array('pattern'=>'/^\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*$/')),array('validator'=>'StringLength', 'options'=>array(8,25)))));
		$this->addElement('password','password2',array('required'=>true,'label'=>'Confirm'));
		$this->addElement('submit','submit',array('label'=>'Change Password'));
	}
}
