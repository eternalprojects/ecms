<?php
/**
 * Settings
 *  
 * @author lesperancej
 * @version 
 */
class Admin_Form_Settings extends Zend_Form
{
    public function init ()
    {
        $dbHost = new Zend_Form_Element_Text('dbHost');
        $dbHost->setLabel('Database Server Hostname')->setRequired(true)->addValidator('NotEmpty');
        $dbUser = new Zend_Form_Element_Text('dbUser');
        $dbUser->setLabel('Database Username')->setRequired(true);
        $dbPword = new Zend_Form_Element_Password('dbPword');
        $dbPword->setLabel('Database Password');
        $dbName = new Zend_Form_Element_Text('dbName');
        $dbName->setLabel('Database Name')->setRequired(true)->addValidator('NotEmpty');
        $siteName = new Zend_Form_Element_Text('siteName', array('size' => 75));
        $siteName->setLabel('Site Name')->addValidator('NotEmpty')->setRequired(true)->addFilter('StripTags')->addFilter('StringTrim')->addFilter('HtmlEntities');
        $siteSlogan = new Zend_Form_Element_Text('siteSlogan', array('size' => 75));
        $siteSlogan->setLabel('Site Slogan')->addFilter('StripTags')->addFilter('StringTrim')->addFilter('HtmlEntities');
        $latestLimit = new Zend_Form_Element_Text('latestLimit');
        $latestLimit->setLabel('Total Number of Latest News Entries')->setRequired(true)->addValidator('NotEmpty');
        $popularLimit = new Zend_Form_Element_Text('popularLimit');
        $popularLimit->setLabel('Total Number of Most Popular News Entries')->setRequired(true)->addValidator('NotEmpty');
        $pageLimit = new Zend_Form_Element_Text('pageLimit');
        $pageLimit->setLabel('Number of entries per page for paginated pages')->setRequired(true)->addValidator('NotEmpty');
        $footerName = new Zend_Form_Element_Text('footerName');
        $footerName->setLabel('Company name to appear in Copyright in the footer')->addValidator('NotEmpty')->setRequired(true)->addFilter('StripTags')->addFilter('StringTrim')->addFilter('HtmlEntities');
        $footerLink = new Zend_Form_Element_Text('footerLink');
        $footerLink->setLabel('URL for the company name provided above')->addFilter('StripTags')->addFilter('StringTrim')->addFilter('HtmlEntities');
    
        $this->addElement($dbHost);
        $this->addElement($dbUser);
        $this->addElement($dbPword);
        $this->addElement($dbName);
        $this->addDisplayGroup(array('dbHost' , 'dbUser' , 'dbPword' , 'dbName'), 'dbInfo', array('legend' => 'Database Information'));
        $this->addElement($siteName);
        $this->addElement($siteSlogan);
        $this->addDisplayGroup(array('siteName' , 'siteSlogan'), 'siteInfo', array('legend' => 'Site Information'));
        $this->addElement($latestLimit);
        $this->addElement($popularLimit);
        $this->addElement($pageLimit);
        $this->addDisplayGroup(array('latestLimit' , 'popularLimit' , 'pageLimit'), 'displayInfo', array('legend' => 'Display Limits'));
        $this->addElement($footerName);
        $this->addElement($footerLink);
        $this->addDisplayGroup(array('footerName' , 'footerLink'), 'footerInfo', array('legend' => 'Footer Information'));
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Update Settings');
        
        $this->addElement($submit);
        $this->addDisplayGroup(array('submit'), 'Submit', array('legend' => 'Save'));
    }
}