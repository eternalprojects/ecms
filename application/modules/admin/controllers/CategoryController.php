<?php
/**
 * Contains the Admin Category Controller
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
 * Category Controller for the Admin Module
 * 
 * 
 * @uses eCMS_Controller_Action
 * @package Admin
 * @subpackage Controller
 *
 */
class Admin_CategoryController extends eCMS_Controller_Action {
	/**
	 * 
	 */
	public function indexAction() {
		$this->view->footerTitle = $this->settings->footer->title;
		$this->view->footerLink = $this->settings->footer->link;
		$this->category = new Admin_Model_DbTable_Category();
	}
	/**
	 * 
	 */
	public function addAction(){
		
	}
	/**
	 * 
	 */
	public function editAction(){
		
	}
	/**
	 * 
	 */
	public function deleteAction(){
		
	}

}

