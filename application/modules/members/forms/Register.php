<?php

class Members_Form_Register extends Zend_Form {
	public function init(){
		$this->setMethod('POST');

		$this->addElement('text', 'username', array(
            'label'      => 'Username',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags','StringToLower'),
            'validators' => array('alnum',array('validator'=>'StringLength','options'=>array(6,25)))
		));

		$this->addElement('text', 'firstName', array(
            'label'      => 'First Name',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            'validators' => array('alpha',array('validator'=>'StringLength','options'=>array(2,25)))
		));

		$this->addElement('text', 'lastName', array(
            'label'      => 'Last Name',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags','StringToLower'),
            'validators' => array('alpha',array('validator'=>'StringLength','options'=>array(2,25)))
		));

		$this->addElement('text', 'email', array(
            'label'      => 'Email Address',
            'required'   => true,
            'validators' => array('EmailAddress')
		));

		$this->addElement('password', 'password', array(
            'label'      => 'Password',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            'validators' => array(array('validator'=>'regex', 'options'=>array('pattern'=>'/^\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*$/')),array('validator'=>'StringLength','options'=>array(8,25)))
		));

		$this->addElement('password', 'password2', array(
            'label'      => 'Confirm',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags'),
            'validators' => array(array('validator'=>'regex', 'options'=>array('pattern'=>'/^\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*$/')),array('validator'=>'StringLength','options'=>array(8,25)))
		));

		$this->addElement('captcha', 'captcha', array(
            'label'      => 'Please enter the code below:',
            'required'   => true,
            'captcha'    => array('captcha' => 'image', 'wordLen' => 7, 'timeout' => 300, 'font'=> APPLICATION_PATH . "/configs/VERDANA.TTF")
		));

		$this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Register',
		));

		// And finally add some CSRF protection
		$this->addElement('hash', 'csrf', array(
            'ignore' => true,
		));

	}
}
