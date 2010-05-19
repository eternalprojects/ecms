<?php

class Default_Form_BugReportForm extends Zend_Form
{
    public function init ()
    {
        $author = $this->createElement('text', 
        'author');
        $author->setLabel('Enter your name:');
        $author->setRequired(TRUE);
        $author->setAttrib('size', 30);
        $this->addElement($author);
        
        $email = $this->createElement('text', 
        'email');
        $email->setLabel('Your email address:');
        $email->setRequired(TRUE);
        $email->addValidator(
        new Zend_Validate_EmailAddress());
        $email->addFilters(
        array(new Zend_Filter_StringTrim(), 
        new Zend_Filter_StringToLower()));
        $email->setAttrib('size', 40);
        $this->addElement($email);
        
        $date = $this->createElement('text', 
        'date');
        $date->setLabel(
        'Date the issue occurred (mm-dd-yyyy):');
        $date->setRequired(TRUE);
        $date->addValidator(
        new Zend_Validate_Date('MM-DD-YYYY'));
        $date->setAttrib('size', 20);
        $this->addElement($date);
        
        $url = $this->createElement('text', 
        'url');
        $url->setLabel('Issue URL:');
        $url->setRequired(TRUE);
        $url->setAttrib('size', 50);
        $this->addElement($url);
        
        $description = $this->createElement(
        'textarea', 'description');
        $description->setLabel(
        'Issue description:');
        $description->setRequired(TRUE);
        $description->setAttrib('cols', 50);
        $description->setAttrib('rows', 4);
        $this->addElement($description);
        
        $this->addElement('captcha','captcha', array('label'=>'Please enter the code below','captcha'=>array('captcha'=>'image','wordlen'=>7,'timeout'=>300,'font'=>APPLICATION_PATH . "/configs/VERDANA.TTF")));
        
        $this->addElement('submit', 'submit', 
        array('label' => 'Submit'));
    }
}
?>