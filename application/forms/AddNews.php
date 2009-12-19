<?php

class Default_Form_AddNews extends Zend_Form
{
	public function init(){
		$this->setMethod('post');
        	$this->setAction('/add');
		$this->addElement('text','title',array('required'=>true,'label'=>'Article Title','size'=>75,'validators'=>array('NotEmpty',array('stringLength',8)),'filters'=>array('StripTags','StringTrim')));
        	$this->addElement('textarea','summary', array('required'=>true,'label'=>'Article Summary','rows'=>4,'cols'=>80,'validators'=>array('NotEmpty'),'filters'=>array('StripTags','StringTrim')));

        	$this->addElement('textarea','content', array('required'=>true,'label'=>'Article Content','validators'=>array('NotEmpty'),'filters'=>array('StripTags','StringTrim')));
	       	$this->addElement('captcha','captcha', array('label'=>'Please enter the code below','captcha'=>array('captcha'=>'image','wordlen'=>7,'timeout'=>300,'font'=>APPLICATION_PATH . "/configs/VERDANA.TTF")));
		$this->addElement('submit','submit',array('label'=>'Add Article'));
       		
		$this->addDisplayGroup(array('title', 'summary', 'content'), 'Article Info', array('legend' => 'Article Info'));
        	$this->addDisplayGroup(array('captcha','submit'), 'Save', array('legend' => 'Save'));
	}
}
