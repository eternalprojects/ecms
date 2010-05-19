<?php
/**
 * Controller for adding News
 *
 * License:
 *
 * Copyright (c) 2009, JPL Web Solutions,
 * Jesse Lesperance <jesse@jplesperance.com>
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
 * @package Bug
 * @subpackage Controller
 * @author Jesse Lesperance <jesse@jplesperance.com>
 * @copyright 2010 JPL Web Solutions
 * @license http://www.gnu.org/licenses/gpl-3.0-standalone.html GNU General Public License
 *
 */
/**
 * Controller for Reporting New Bugs
 * 
 * This COntroller contains the code needed for users of the site to submit bugs 
 * The encounter while using the application
 *
 * @author Jesse Lesperance <jesse@jplesperance.com>
 * @package Bug
 * @subpackage Controller
 * @uses eCMS_Controller_Action
 */
class BugController extends eCMS_Controller_Action
{
    public function init(){
        parent::init();
    }
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {}
    
    public final function submitAction ()
    {
        $this->view->title = "Submit a Bug Report";
        $bugReportForm = new Default_Form_BugReportForm();
        $bugReportForm->setAction('/bug/submit');
        $bugReportForm->setMethod('post');
        if ($this->getRequest()->isPost()) {
            if ($bugReportForm->isValid($_POST)) {
                // just dump the data for now
                $data = $bugReportForm->getValues();
                $bugs = new Default_Model_Bugs($data);
                $bugs->save();
                $this->_forward('confirm');
                // process the data
            }
        }
        $this->view->form = $bugReportForm;
    }
    
    public final function confirmAction(){
        $this->view->title = "Bug Submitted";
        $this->view->pagecopy = "Thank you for your bug submission.<br /><br />We will review and prioritize your submission shortly.";
    }
    
 
}

