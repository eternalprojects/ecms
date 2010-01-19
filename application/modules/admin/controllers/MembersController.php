<?php
/**
 * Contains the Admin Member Controller
 *
 * License:
 *
 * Copyright (c) 2009, JPL Web Solutions,
 *                     Jesse Lesperance <jesse@jplesperance.com>
 *
 * This file is part of EternalCMS.
 *
 * EternalCMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.  EternalCMS is distributed in the hope
 * that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * See the GNU General Public License for more details. You should have received
 * a copy of the GNU General Public License along with EternalCMS.
 *
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Admin
 * @subpackage Controller
 * @author Jesse Lesperance <jesse@jplesperance.com>
 * @copyright 2010 JPL Web Solutions
 * @license http://www.gnu.org/licenses/gpl-3.0-standalone.html GNU General Public License
 *
 */
/**
 * Members Controller for the Admin Module
 * 
 * @uses eCMS_Controller_Action
 * @package Admin
 * @subpackage Controller
 */
class Admin_MembersController extends eCMS_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->settings = Zend_Registry::get('settings');
        $this->members = new Members_Model_Members();
    }

    public function indexAction(){
        $this->view->title = "Site Administration: Registered Users";
    	$limit = (int)$this->settings->limit->perpage;
    	$page = $this->_request->getParam('page', 1);
		$paginator = $this->members->fetchAllMembers($page, $limit);
		$this->view->users = $paginator->getItemsByPage($page);
		$this->view->paginator = $paginator;

    }

    public function activateAction(){
        $username = $this->_request->getParam('uname');
        $this->members->activateMember($username);
        $this->_redirect('/admin/members');
    }
    
    public function deactivateAction(){
        $username = $this->_request->getParam('uname');
        $this->members->deactivateMember($username);
        $this->_redirect('/admin/members');
    }
}