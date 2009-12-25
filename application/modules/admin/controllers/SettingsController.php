<?php
class Admin_SettingsController extends eCMS_Controller_Action
{
    public function init ()
    {
        parent::init();
    }
    public function indexAction ()
    {
        $this->view->title = "Site Administration: Settings";
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
        $this->view->dbHost = $config->resources->db->params->host;
        $this->view->username = $config->resources->db->params->username;
        $this->view->password = $config->resources->db->params->password;
        $this->view->dbName = $config->resources->db->params->dbname;
        $settings = new Zend_Config_Ini(APPLICATION_PATH . '/configs/siteSettings.ini', 'general');
        $this->view->siteName = $settings->site->name;
        $this->view->siteSlogan = $settings->site->slogan;
        $this->view->limitLatest = $settings->limit->latest;
        $this->view->limitPopular = $settings->limit->popular;
        $this->view->limitPerPage = $settings->limit->perpage;
        $this->view->footerName = $settings->footer->title;
        $this->view->footerLink = $settings->footer->link;
    }
    public function editAction ()
    {
        $this->view->title = "Site Administration: Edit Settings";
        $form = new Admin_Form_Settings();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production', array('skipExtends' => true , 'allowModifications' => true));
        $settings = new Zend_Config_Ini(APPLICATION_PATH . '/configs/siteSettings.ini', 'general', array('skipExtends' => true , 'allowModifications' => true));
        if ($this->_request->isPost()) {
            $formData = $this->_request->getParams();
            if ($form->isValid($formData)) {
                $config->resources->db->params->host = $formData['dbHost'];
                $config->resources->db->params->username = $formData['dbUser'];
                $config->resources->db->params->password = $formData['dbPword'];
                $config->resources->db->params->dbname = $formData['dbName'];
                $writer = new Zend_Config_Writer_Ini(array('config' => $config , 'filename' => APPLICATION_PATH . '/configs/application.ini'));
                $writer->write();
                
                $settings->site->name = $form->getValue('siteName');
                $settings->site->slogan = $form->getValue('siteSlogan');
                $settings->limit->latest = $form->getValue('latestLimit');
                $settings->limit->popular = $form->getValue('popularLimit');
                $settings->limit->perpage = $form->getValue('pageLimit');
                $settings->footer->link = $form->getValue('footerLink');
                $settings->footer->title = $form->getValue('footerName');
                $writer2 = new Zend_Config_Writer_Ini(array('config' => $settings , 'filename' => APPLICATION_PATH . '/configs/siteSettings.ini'));
                $writer2->write();
                $this->_redirect('/admin/settings');
            }
        }
        $form->getElement('dbHost')->setValue($config->resources->db->params->host);
        $form->getElement('dbUser')->setValue($config->resources->db->params->username);
        $form->getElement('dbPword')->setValue($config->resources->db->params->password);
        $form->getElement('dbName')->setValue($config->resources->db->params->dbname);
        $form->getElement('siteName')->setValue($settings->site->name);
        $form->getElement('siteSlogan')->setValue($settings->site->slogan);
        $form->getElement('latestLimit')->setValue($settings->limit->latest);
        $form->getElement('popularLimit')->setValue($settings->limit->popular);
        $form->getElement('pageLimit')->setValue($settings->limit->perpage);
        $form->getElement('footerLink')->setValue($settings->footer->link);
        $form->getElement('footerName')->setValue($settings->footer->title);
        $this->view->form = $form;
    }
}