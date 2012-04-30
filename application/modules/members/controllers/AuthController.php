<?php

/**
 * AuthController
 *
 * @author
 * @version
 */

require_once 'eCMS/Controller/Action.php';

class Members_AuthController extends eCMS_Controller_Action
{
    /**
     * The default action - show the home page
     */

    public function init()
    {
        parent::init();
        $this->initView();

    }

    public function indexAction()
    {

        $this->_redirect('/');
    }

    public function loginAction()
    {
        $this->view->title   = "Member Login";
        $this->view->message = '';
        if ($this->_request->isPost()) {
            $f        = new Zend_Filter_StripTags();
            $username = $f->filter($this->_request->getParam('username'));
            $password = $f->filter($this->_request->getParam('password'));
            if (empty($username)) {
                $this->view->message = "Please Provide a Username";
            } else {
                $member      = new Members_Model_DbTable_Members();
                $authAdapter = new Zend_Auth_Adapter_DbTable($member->getAdapter());
                $authAdapter->setTableName('members');
                $authAdapter->setIdentityColumn('uname');
                $authAdapter->setCredentialColumn('pword');
                $authAdapter->setCredentialTreatment('md5(?)');
                $authAdapter->setIdentity($username);
                $authAdapter->setCredential($password);

                $auth   = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);
                if ($result->isValid()) {
                    $data = $authAdapter->getResultRowObject(null, 'password');
                    if ($data->active) {
                        $auth->getStorage()->write($data);
                        $this->_helper->FlashMessenger("Login Successful");
                        $this->_redirect('/');
                    } else {
                        $this->view->message   =
                            "Your account is not activated.  Please check your email for the welcome email from when you registered and follow the directions in that email to activate you account before logging in.";
                        $this->view->notActive = TRUE;
                        $auth->clearIdentity();
                    }

                } else {
                    $this->view->message = "Your username/password is incorrect";
                }
            }
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }

}
