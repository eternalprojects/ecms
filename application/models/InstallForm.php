<?php
require_once 'Zend/Form.php';
class InstallForm extends Zend_form
{
    public function __construct ($options = null)
    {
        parent::__construct($options);
        $this->setAction('/install')
            ->setMethod('POST')
            ->setName('install_form');
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
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Save Settings');
            
        $this->addElement($siteName);
        $this->addElement($siteSlogan);
        $this->addDisplayGroup(array('siteName','siteSlogan'),'siteInfo',array('legend'=>'Site Information'));
        $this->addElement($dbHost);
        $this->addElement($dbUser);
        $this->addElement($dbPword);
        $this->addElement($dbName);
        $this->addDisplayGroup(array('dbHost','dbUser','dbPword','dbName'),'dbInfo',array('legend'=>'Database Information'));
        $this->addElement($latestLimit);
        $this->addElement($popularLimit);
        $this->addElement($pageLimit);
        $this->addDisplayGroup(array('latestLimit','popularLimit','pageLimit'),'displayInfo',array('legend'=>'Display Information'));
        $this->addElement($submit);
        $this->addDisplayGroup(array('submit'),'Submit',array('legend'=>'Save'));
    }
}