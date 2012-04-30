<?php

/**
 * AccountController
 *
 * @author
 * @version
 */

require_once 'eCMS/Controller/Action.php';

class Members_AccountController extends eCMS_Controller_Action
{
    /**
     * The default action - show the home page
     */

    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {

        $this->_redirect('/');
    }

    public function activateAction()
    {
        $params = $this->_request->getParams();
        if (isset($params['mid']) && isset($params['pid'])) {
            $members = new Members_Model_DbTable_Members();
            $select  = $members->select();
            $select->where('id=?', $params['mid']);
            $select->where('pword=?', $params['pid']);
            if ($members->fetchRow($select)) {
                $data  = array('active'=> 1);
                $where = $members->getAdapter()->quoteInto('id=?', $params['mid']);
                $members->update($data, $where);
                $this->view->status = "Success";
            } else {
                $this->view->status = "Fail";
            }

        } else {
            $this->_redirect('/');
        }
    }

}

