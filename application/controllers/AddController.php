<?php
/**
 * This file is part of EternalCMS
 *
 * License:
 *
 * Copyright (c) 2009-2012, JPL Web Solutions,
 *                     Jesse P Lesperance <jesse@jplesperance.me>
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
 * @package    News
 * @subpackage Controller
 * @author     Jesse Lesperance <jesse@jplesperance.com>
 * @copyright  2010 JPL Web Solutions
 * @license    http://www.gnu.org/licenses/gpl-3.0-standalone.html GNU General Public License
 *
 */
/**
 * Controller for handling adding news
 *
 * This controller contains the functionality for displaying the add news form,
 * validating the data and calling the News Model for inserting the submitted
 * news story into the database.
 *
 * @author     Jesse P Lesperance <jesse@jplesperance.com>
 * @package    News
 * @subpackage Controller
 * @uses       eCMS_Controller_Action
 */
class AddController extends eCMS_Controller_Action
{
    /**
     * Call the parent init function
     */
    public function init()
    {
        parent::init();
    }

    /**
     * The primary/default action
     *
     * This method will dis[play the add news form if it does not detect the
     * form already being submitted.  If the form has been submitted it validates
     * the submitted data and upon validation it then calls the News model to
     * insert the submitted data into the database
     *
     * @
     */
    public function indexAction()
    {
        $this->view->title    = "Add Article";
        $this->view->bodyCopy =
            "<p>Fill out the following form to add an article.</p><p>The summary can be up to 250 characters long</p>";
        $form                 = new Default_Form_AddNews();
        if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)) {
                $data           = $form->getValues();
                $data['author'] = $this->view->user->uname;
                $news           = new Default_Model_News($data);
                $news->save();
                $this->_redirect('view/latest');
            } else {
                $form->populate($formData);
                $this->view->form = $form;
            }
        } else {
            $this->view->form = $form;
        }
    }
}
