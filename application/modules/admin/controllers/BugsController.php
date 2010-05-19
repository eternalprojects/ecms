<?php
/**
 * BugsController
 * 
 * @author
 * @version 
 */
class Admin_BugsController extends eCMS_Controller_Action
{
    public function init ()
    {
        parent::init();
        $this->_bugs = new Default_Model_Bugs();
    }
    public final function indexAction ()
    {
        $this->view->title = "Reported Bugs";
        $listToolsForm = new Admin_Form_BugReportListToolsForm();
        $sort = null;
        $filter = null;
        // if this request is a postback and is valid, then add the sort
        // filter criteria
        if ($this->getRequest()->isPost()) {
            if ($listToolsForm->isValid(
            $_POST)) {
                $sortValue = $listToolsForm->getValue(
                'sort');
                if ($sortValue !=
                 '0') {
                    $sort = $sortValue;
                }
                $filterFieldValue = $listToolsForm->getValue(
                'filter_field');
                if ($filterFieldValue !=
                 '0') {
                    $filter[$filterFieldValue] = $listToolsForm->getValue(
                    'filter');
                }
            }
        }
        $page = $this->_request->getParam('page', 1);
        $listToolsForm->setAction('/admin/bugs/index');
        $listToolsForm->setMethod('post');
        $paginator = $this->_bugs->fetchAll($filter, $sort, 25, $page);
        $this->view->bugs = $paginator->getItemsByPage($page);
        $this->view->paginator = $paginator;
        $this->view->listToolsForm = $listToolsForm;
    }
    
    public final function deleteAction(){
        if(!is_null($this->_request->getParam('id')))
            $this->_bugs->deleteBug($this->_request->getParam('id'));
        $this->_forward('index');
        
    }
}

