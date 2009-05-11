<?php
/**
 * My new Zend Framework project
 * 
 * @author  
 * @version 
 */

require_once 'Zend/Controller/Plugin/Abstract.php';
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Controller/Request/Abstract.php';
require_once 'Zend/Controller/Action/HelperBroker.php';


/**
 * 
 * Initializes configuration depndeing on the type of environment 
 * (test, development, production, etc.)
 *  
 * This can be used to configure environment variables, databases, 
 * layouts, routers, helpers and more
 *   
 */
class Initializer extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var Zend_Config
     */
    protected static $_config;

    /**
     * @var string Current environment
     */
    protected $_env;

    /**
     * @var Zend_Controller_Front
     */
    protected $_front;

    /**
     * @var string Path to application root
     */
    protected $_root;

    /**
     * Constructor
     *
     * Initialize environment, root path, and configuration.
     * 
     * @param  string $env 
     * @param  string|null $root 
     * @return void
     */
    public function __construct($env, $root = null)
    {
        $this->_setEnv($env);
        if (null === $root) {
            $root = realpath(dirname(__FILE__) . '/../');
        }
        
        $this->_root = $root;

        $this->initPhpConfig();
        
        $this->_front = Zend_Controller_Front::getInstance();
        $moduleName = $this->_front->getModuleDirectory()?$this->_front->getModuleDirectory():'default';
        set_include_path($this->_root .'/application/modules/' . $moduleName . '/models' . PATH_SEPARATOR . get_include_path());
        // set the test environment parameters
        if ($env == 'development') {
			// Enable all errors so we'll know when something goes wrong. 
			error_reporting(E_ALL | E_STRICT);  
			ini_set('display_startup_errors', 1);  
			ini_set('display_errors', 1); 

			$this->_front->throwExceptions(true);  
        }

		
    }

    /**
     * Initialize environment
     * 
     * @param  string $env 
     * @return void
     */
    protected function _setEnv($env) 
    {
		$this->_env = $env;    	
    }
    

    /**
     * Initialize Config
     * 
     * @return void
     */
    public function initPhpConfig()
    {
    	$config = new Zend_Config_Ini($this->_root . '/application/config/config.ini', $this->_env);
    	Zend_Registry::set('config', $config);
    	self::$_config = $config;
    }
    
    /**
     * Route startup
     * 
     * @return void
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
       	$this->initDb();
        $this->initHelpers();
        $this->initView();
        $this->initPlugins();
        $this->initRoutes();
        $this->initControllers();
    }
    
    /**
     * Initialize data bases
     * 
     * @return void
     */
    public function initDb()
    {
    	try{
    		$config = Zend_Registry::get('config');
    		$db = Zend_Db::factory($config->db);
    		Zend_Db_Table::setDefaultAdapter($db);
    		Zend_Registry::set('db', $db);
    	}catch(Zend_Db_Exception $e){
    		die($e->getMessage());
    	}
    }

    /**
     * Initialize action helpers
     * 
     * @return void
     */
    public function initHelpers()
    {
    	// register the default action helpers
    	Zend_Controller_Action_HelperBroker::addPath('../application/default/helpers', 'Zend_Controller_Action_Helper');
    }
    
    /**
     * Initialize view 
     * 
     * @return void
     */
    public function initView()
    {
		// Bootstrap layouts
		Zend_Layout::startMvc(array(
		    'layoutPath' => $this->_root .  '/application/layouts',
		    'layout' => 'main'
		));
		$view = new Zend_View();
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');

		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    	
    }
    
    /**
     * Initialize plugins 
     * 
     * @return void
     */
    public function initPlugins()
    {
    	
    }
    
    /**
     * Initialize routes
     * 
     * @return void
     */
    public function initRoutes()
    {
    	
    }

    /**
     * Initialize Controller paths 
     * 
     * @return void
     */
    public function initControllers()
    {
    	$this->_front->addControllerDirectory($this->_root .'/application/modules/default/controllers','default');
    	$this->_front->addControllerDirectory($this->_root . '/application/modules/members/controllers','members');
    	
    }
}
?>
