<?php
date_default_timezone_set('America/Los_Angeles');
/**
 * RegisterController
 * 
 * @author
 * @version 
 */
require_once 'eCMS/Controller/Action.php';
class Members_RegisterController extends eCMS_Controller_Action
{
    /**
     * The default action - show the home page
     */
	
	public function init(){
		parent::init();
	}
    public function indexAction ()
    {    
        
        $this->view->title = "User Registration";
        $this->view->bodyCopy = "<p>Fill out the following form to register for a user account</p><p>The passwords must be a minimum of 8 characters and must include at least 1 capital letter and 1 number.</p><p>* - indicates a required field</p>";
        $form = new Members_Form_Register();
        $form->getElement('password')->getValidator('Regex')->setMessage('Invalid Password.  Passwords must contain at least one number and one capital letter.');
        $form->getElement('password2')->getValidator('Regex')->setMessage('Invalid Password.  Passwords must contain at least one number and one capital letter.');

	if($this->_request->isPost()){
            $formData = $this->_request->getParams();
            if($form->isValid($formData)){
            	$members = new Members_Model_Members();
            	$select1 = $members->select()->where('uname = ?', $form->getValue('username'));
                $select2 = $members->select()->where('email = ?', $form->getValue('email'));
                if($formData['password'] !== $formData['password2']){
                    $form->getElement('password2')->addError('Passwords do not match');
                    $form->populate($formData);
                    $this->view->form = $form;
                }elseif($row = $members->fetchRow($select1)){
                  	$form->getElement('username')->addError('Username is already taken');
                  	$form->populate($formData);
                    $this->view->form = $form;
                }elseif($row = $members->fetchRow($select2)){
                  	$form->getElement('email')->addError('Email is already taken');
                  	$form->populate($formData);
                    $this->view->form = $form;
                }else{
                    $dbPassword = md5($form->getValue('password'));
                    $row = $members->createRow();
                    $row->fname = $form->getValue('firstName');
                    $row->lname = $form->getValue('lastName');
                    $row->email = $form->getValue('email');
                    $row->uname = $form->getValue('username');
                    $row->pword = $dbPassword;
                    $id = $row->save();
                    
                    $settings = Zend_Registry::get('settings');
                    
                    try{
			$mail = new Zend_Mail();
					$mail->setBodyText('Thank you for registering at '.$settings->site->name.'. 
					
					In order to complete you registration you just need to activate your account.  You can either click on or copy and paste the following URL into your browser.
					
					http://'.$_SERVER['HTTP_HOST'].'/members/account/activate/mid/'.$id.'/pid/'.$dbPassword);
					$mail->setBodyHtml('<p>Thank you for registering with '.$settings->site->name.'.<br><br>In order to complete your registration you need to activate your account.  <a href="http://'.$_SERVER['HTTP_HOST'].'/members/account/activate/mid/'.$id.'/pid/'.$dbPassword.'">Activate Now</a>');
					$mail->setFrom('no-reply@'.$_SERVER['HTTP_HOST'], $settings->site->name);
					$mail->addTo($form->getValue('email'), $form->getValue('fname').' '.$form->getValue('lname'));
					$mail->setSubject('Thank you for Registering');
					$mail->send();
			}catch(Zend_Mail_Exception $e){
			 die($e->getMessage());
			}
                    $this->_redirect('/members/register/success');
                }
            }else{
                $form->addErrorMessage('Please correct the issues below');
                $form->populate($formData);
                $this->view->form = $form;
            }
            
        }else{
            $this->view->form = $form;
        }
        
    }
    
    final public function successAction(){
    	$this->view->title = "Registration Successful";
    	$this->view->bodyCopy = "<p>You have been successfully registered.  A welcome email has been sent to the email address you regisred with.</p><p>Before you can login to your account you will need to activate it.  An activation link has been included in the welcome email.  Once the account has been activate you may login and take full advantage of Members features</p>";
    }
}
