<?php

class Default_Form_InstallForm2 extends Zend_Form {
	public function init(){
		parent::init();

		$this->setAction('/install/settings')
			->setMethod('POST')
			->setName('settings_form');

		$siteName = new Zend_Form_Element_Text('siteName',array('size'=>75));
		$siteName->setLabel('Site Name')
			->addValidator('NotEmpty')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addFilter('HtmlEntities');
		$siteSlogan = new Zend_Form_Element_Text('siteSlogan', array('size'=>75));
		$siteSlogan->setLabel('Site Slogan')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addFilter('HtmlEntities');
		$latestLimit = new Zend_Form_Element_Text('latestLimit');
		$latestLimit->setLabel('Total Number of Latest News Entries')
			->setRequired(true)
			->addValidator('NotEmpty');
		$popularLimit = new Zend_Form_Element_Text('popularLimit');
		$popularLimit->setLabel('Total Number of Most Popular News Entries')
			->setRequired(true)
			->addValidator('NotEmpty');
		$pageLimit = new Zend_Form_Element_Text('pageLimit');
		$pageLimit->setLabel('Number of entries per page for All News listing')
			->setRequired(true)
			->addValidator('NotEmpty');
		$footerName = new Zend_Form_Element_Text('footerName');
		$footerName->setLabel('Company name to appear in Copyright in the footer')
			->addValidator('NotEmpty')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addFilter('HtmlEntities');
		$footerLink = new Zend_Form_Element_Text('footerLink');
		$footerLink->setLabel('URL for the company name provided above')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addFilter('HtmlEntities');
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save Settings');

		$this->addElement($siteName);
		$this->addElement($siteSlogan);
		$this->addDisplayGroup(array('siteName','siteSlogan'),'siteInfo',array('legend'=>'Site Information'));
		$this->addElement($latestLimit);
		$this->addElement($popularLimit);
		$this->addElement($pageLimit);
		$this->addDisplayGroup(array('latestLimit','popularLimit','pageLimit'),'displayInfo',array('legend'=>'Display Limits'));
		$this->addElement($submit);
		$this->addElement($footerName);
		$this->addElement($footerLink);
		$this->addDisplayGroup(array('footerName','footerLink'),'footerInfo', array('legend'=>'Footer Information'));
		$this->addDisplayGroup(array('submit'),'Complete Installation',array('legend'=>'Save'));

	}
}