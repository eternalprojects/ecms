<?php

class Default_Form_InstallForm1 extends Zend_form
{
	public function init ()
	{

		$this->setAction('/install/next')
		->setMethod('POST')
		->setName('install_form');


		$dbHost = new Zend_Form_Element_Text('dbHost');
		$dbHost->setLabel('Database Server Hostname')
		->setRequired(true)
		->addValidator('NotEmpty');
		$dbUser = new Zend_Form_Element_Text('dbUser');
		$dbUser->setLabel('Database Username')
		->setRequired(true);
		$dbPword = new Zend_Form_Element_Password('dbPword');
		$dbPword->setLabel('Database Password');
		$dbName = new Zend_Form_Element_Text('dbName');
		$dbName->setLabel('Database Name')
		->setRequired(true)
		->addValidator('NotEmpty');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save Settings');


		$this->addElement($dbHost);
		$this->addElement($dbUser);
		$this->addElement($dbPword);
		$this->addElement($dbName);
		$this->addDisplayGroup(array('dbHost','dbUser','dbPword','dbName'),'dbInfo',array('legend'=>'Database Information'));

		$this->addElement($submit);
		$this->addDisplayGroup(array('submit'),'Submit',array('legend'=>'Save'));
	}
}