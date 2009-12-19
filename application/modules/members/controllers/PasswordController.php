<?php

/**
 * PasswordController
 * 
 * @author
 * @version 
 */

require_once 'eCMS/Controller/Action.php';

class Members_PasswordController extends eCMS_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function init(){
		parent::init();
	}
	public function indexAction() {
		$this->_redirect('/');
	}
	
	public function changeAction(){
		$this->view->title = "Change Password";
		$user = Zend_Auth::getInstance()->getIdentity();
		if(!$user)
			$this->_redirect('/');
        $form = new Members_Form_ChangePassword();
        $form->getElement('password')->getValidator('Regex')->setMessage('Invalid Password.  Passwords must contain at least one number and one capital letter.');
        if($this->_request->isPost()){
        	$formData = $this->_request->getParams();
        	$members = new Members_Model_Members();
        	if($form->isValid($formData)){
        		
        		if(md5($formData['oldPassword']) != $user->pword){
        			$form->getElement('oldPassword')->addError('Incorrect Password specified');
        			$form->populate($formData);
        			$this->view->form = $form;
        		}else{
        			if($formData['password'] !== $formData['password2']){
                    	$form->getElement('password2')->addError('Passwords do not match');
                    	$this->view->form = $form;
        			}else{
        				$members->updatePassword($formData['password']);
        				$this->_redirect('/members/password/changed');
        			}
        		}
        	}
        }
        $this->view->form = $form;
        
	}
	
	public function changedAction(){
		$this->view->title = "Password Changed Successfully";
	}
	
	public function forgotAction(){
		$this->view->title = "Forgotten Password";
		$this->view->bodyCopy = "Enter you the email address that is registered with our site and we will email you a new password.";
		$settings = Zend_Registry::get('settings');
		if($this->_request->isPost()){
			$email = $this->_request->getParam('email');
			$members = new Members_Model_Members();
			$members->fetchMember();
			if($email = $members->getEmail()){
				$password = Members_Model_RandPass::generatePass(10);
				$dbPassword = md5($password);
				$members->updatePassword($password);
				$mail = new Zend_Mail();
				$mail->setBodyText('At your request we have generated a new password for your account.
				
				Password: '.$password.'
				
				We suggest that you login and change this password at your earliest convenience.');
					$mail->setBodyHtml('Dear '.$row['uname'].',<br><p>At your request, we have generated a new temporary password for you.  You will find your new password below.  If you did not make this request, you should now that someone used your email address on the \'Forgotten Password\' page at <a href="'.$_SERVER['HTTP_HOST'].'">'.$settings->site->name.'</a>.<br><br>Password: '.$password);
					$mail->setFrom('no-reply@'.$_SERVER['HTTP_HOST'], $settings->site->name);
					$mail->addTo($email, $email);
					$mail->setSubject('New Password');
					$mail->send();	
					$this->view->bodyCopy = "An email has been sent to the email address provided.  Please check your email for your new temporary password.";
					$this->view->sent = true;
			}else{
				$this->view->bodyCopy .= "<br><br><span style='color: red; font-weight: bold'>Email address not found</span>";
			}
		}
	}

}
