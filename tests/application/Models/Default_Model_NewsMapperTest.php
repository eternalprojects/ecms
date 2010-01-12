<?php
set_include_path ( get_include_path () . PATH_SEPARATOR . 'library/' );
require_once dirname ( __FILE__ ) . '/../../TestHelper.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'NewsMapper.php';
require_once 'DbTable/News.php';
/**
 * Default_Model_NewsMapper test case.
 */
class Default_Model_NewsMapperTest extends PHPUnit_Framework_TestCase {
	public $bootstrap = 'application/Bootstrap.php';
	/**
	 * @var Default_Model_NewsMapper
	 */
	private $Default_Model_NewsMapper;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		$this->bootstrap = array ($this, 'appBootstrap' );
		parent::setUp ();
		
		// TODO Auto-generated Default_Model_NewsMapperTest::setUp()
		

		$this->Default_Model_NewsMapper = new Default_Model_NewsMapper ( );
	
	}
	public function appBootstrap() {
		$this->application = new Zend_Application ( APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini' );
		
		$this->application->bootstrap ();
	}
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated Default_Model_NewsMapperTest::tearDown()
		

		$this->Default_Model_NewsMapper = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/**
	 * Tests Default_Model_NewsMapper->setDbTable()
	 */
	public function testSetDbTable() {
		$this->Default_Model_NewsMapper->setDbTable('Default_Model_DbTable_News');
		$dbTable = $this->Default_Model_NewsMapper->getDbTable ();
		$this->assertTrue ( $dbTable instanceof Zend_Db_Table_Abstract );
	}
	
	/**
	 * Tests Default_Model_NewsMapper->getDbTable()
	 */
	public function testGetDbTable() {
		
		$this->assertTrue($this->Default_Model_NewsMapper->getDbTable() instanceof Zend_Db_Table_Abstract);
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->save()
	 */
	public function testSave() {
		
		$data = array();
		$data['title'] = "Test Article";
		$data['summary'] = "blurb";
		$data['content'] = "blurbbbs";
		$data['author'] = "Jesse";
		$news = new Default_Model_News($data);
		$this->Default_Model_NewsMapper->save($news);
		$db = new Default_Model_DbTable_News();
		$this->assertNotNull($db->find(24));
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->addView()
	 */
	public function testAddView() {
		// TODO Auto-generated Default_Model_NewsMapperTest->testFetchAll()
		$this->markTestIncomplete ( "fetchAll test not implemented" );
		$this->Default_Model_NewsMapper->addView(/* parameters */);
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->find()
	 */
	public function testFind() {
		$news = new Default_Model_News();
		
		$this->Default_Model_NewsMapper->find(24, $news);
		
		$this->assertNotNull($news->getAuthor());
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->fetchAll()
	 */
	public function testFetchAll() {
		// TODO Auto-generated Default_Model_NewsMapperTest->testFetchAll()
		$this->markTestIncomplete ( "fetchAll test not implemented" );
		
		$this->Default_Model_NewsMapper->fetchAll(/* parameters */);
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->fetchLatest()
	 */
	public function testFetchLatest() {
		// TODO Auto-generated Default_Model_NewsMapperTest->testFetchLatest()
		$this->markTestIncomplete ( "fetchLatest test not implemented" );
		
		$this->Default_Model_NewsMapper->fetchLatest(/* parameters */);
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->fetchPopular()
	 */
	public function testFetchPopular() {
		// TODO Auto-generated Default_Model_NewsMapperTest->testFetchPopular()
		$this->markTestIncomplete ( "fetchPopular test not implemented" );
		
		$this->Default_Model_NewsMapper->fetchPopular(/* parameters */);
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->fetchPage()
	 */
	public function testFetchPage() {
		// TODO Auto-generated Default_Model_NewsMapperTest->testFetchPage()
		$this->markTestIncomplete ( "fetchPage test not implemented" );
		
		$this->Default_Model_NewsMapper->fetchPage(/* parameters */);
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->fetchNewsByAuthor()
	 */
	public function testFetchNewsByAuthor() {
		// TODO Auto-generated Default_Model_NewsMapperTest->testFetchNewsByAuthor()
		$this->markTestIncomplete ( "fetchNewsByAuthor test not implemented" );
		
		$this->Default_Model_NewsMapper->fetchNewsByAuthor(/* parameters */);
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->deleteStory()
	 */
	public function testDeleteStory() {
		// TODO Auto-generated Default_Model_NewsMapperTest->testDeleteStory()
		$this->markTestIncomplete ( "deleteStory test not implemented" );
		
		$this->Default_Model_NewsMapper->deleteStory(/* parameters */);
	
	}
	
	/**
	 * Tests Default_Model_NewsMapper->fetchAllNews()
	 */
	public function testFetchAllNews() {
		// TODO Auto-generated Default_Model_NewsMapperTest->testFetchAllNews()
		$this->markTestIncomplete ( "fetchAllNews test not implemented" );
		
		$this->Default_Model_NewsMapper->fetchAllNews(/* parameters */);
	
	}

}
