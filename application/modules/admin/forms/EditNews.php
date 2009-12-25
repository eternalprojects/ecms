<?php

class Admin_Form_EditNews extends Zend_Form
{
	public function init(){
		$this->setMethod('post');
		$this->addElement('hidden', 'id');
		$this->addElement('hidden', 'author');
		$this->addElement('text','title',array('required'=>true,'label'=>'Article Title','size'=>75,'validators'=>array('NotEmpty',array('stringLength',8)),'filters'=>array('StripTags','StringTrim')));
		$this->addElement('textarea','summary', array('required'=>true,'label'=>'Article Summary','rows'=>4,'validators'=>array('NotEmpty'),'filters'=>array('StringTrim')));
		$this->addElement('textarea','content', array('required'=>true,'label'=>'Article Content','validators'=>array('NotEmpty'),'filters'=>array('StringTrim')));
		$this->addElement('captcha','captcha', array('label'=>'Please enter the code below','captcha'=>array('captcha'=>'image','wordlen'=>7,'timeout'=>300,'font'=>APPLICATION_PATH . "/configs/VERDANA.TTF")));
		$this->addElement('submit','submit',array('label'=>'Edit Article'));
		$this->addDisplayGroup(array('title', 'summary', 'content', 'id', 'author'), 'Article Info', array('legend' => 'Article Info'));
		$this->addDisplayGroup(array('captcha','submit'), 'Save', array('legend' => 'Save'));
	}
}
