<?php
class InteractiveTestCase extends CakeTestCase {
  var $Interactive = null;
	var $fixtures = array('core.post');
  
  function startCase() {
    $this->Interactive = ClassRegistry::init('Interactive.Interactive');
		$this->Interactive->objectCache = false;
		$this->Interactive->setDataSource('test_suite');
  }
	
	function startTest() {
		$this->Interactive->objectPath = null;
	}
  
  function testInstance() {
    $this->assertTrue(is_a($this->Interactive, 'Interactive'));
  }
  
  function testFindCmdTypeClass() {
    $type = $this->Interactive->__findCmdType('User::find("all")');
    $this->assertEqual('class', $type);
    
    $type = $this->Interactive->__findCmdType('User->find("all")');
    $this->assertEqual('class', $type);
    
    $type = $this->Interactive->__findCmdType('User->Group->find("all")');
    $this->assertEqual('class', $type);
		
    $type = $this->Interactive->__findCmdType('$User->find("all")');
    $this->assertEqual('class', $type);
  }
  
  function testFindCmdTypeSql() {
    $type = $this->Interactive->__findCmdType('SELECT * FROM users');
    $this->assertEqual('sql', $type);
    
    $type = $this->Interactive->__findCmdType('delete from users where id = 2');
    $this->assertEqual('sql', $type);
    
    $type = $this->Interactive->__findCmdType('update users set username = "test" where id = 3');
    $this->assertEqual('sql', $type);
  }
  
  function testFindCmdTypeUnknown() {
    $type = $this->Interactive->__findCmdType('__("test")');
    $this->assertEqual('code', $type);
  }
	
	function testSqlCall() {
		$result = $this->Interactive->__sqlCall('SELECT * FROM posts');
		$this->assertEqual(3, count($result));

		$result = $this->Interactive->__sqlCall('select * from posts');
		$this->assertEqual(3, count($result));
		
		$this->Interactive->__sqlCall('UPDATE posts SET title = "Test Post" WHERE id = 1');
		$result = $this->Interactive->__sqlCall('select * from posts where id = 1');
		$this->assertEqual("Test Post", $result[0]['posts']['title']);
	}
	
	function testCodeCall() {
		$result = $this->Interactive->__codeCall('is_array(array(1,2,3))');
		$this->assertTrue($result);
		
		$result = $this->Interactive->__codeCall('10 % 4');
		$this->assertEqual(2, $result);
		
		$result = $this->Interactive->__codeCall('ife(true, "one", "two")');
		$this->assertEqual("one", $result);
	}
	
	function testFixClassName() {
		$result = $this->Interactive->__fixClassName('html');
		$this->assertEqual('Html', $result);
		
		$result = $this->Interactive->__fixClassName('$html');
		$this->assertEqual('Html', $result);
		
		$result = $this->Interactive->__fixClassName('TestsAppsPostsController');
		$this->assertEqual('TestsAppsPosts', $result);
		
		$result = $this->Interactive->__fixClassName('$TestsAppsPostsController');
		$this->assertEqual('TestsAppsPosts', $result);
	}
	
	function testGetClass() {
		$result = $this->Interactive->__getClass('Html');
		$this->assertTrue(is_a($result, 'HtmlHelper'));
		
		$result = $this->Interactive->__getClass('Form');
		$this->assertTrue(is_a($result->Html, 'HtmlHelper'));
		
		$this->Interactive->objectPath = ROOT . DS . CAKE_TESTS . 'test_app' . DS . 'models';
		Configure::write('modelPaths', array(ROOT . DS . CAKE_TESTS . 'test_app' . DS . 'models'));
		$result = $this->Interactive->__getClass('Post');
		$this->assertTrue(is_a($result, 'Post'));
	
		Configure::write('controllerPaths', array(ROOT . DS . CAKE_TESTS . 'test_app' . DS . 'controllers'));
		$this->Interactive->objectPath = ROOT . DS . CAKE_TESTS . 'test_app' . DS . 'controllers';
		$result = $this->Interactive->__getClass('TestsAppsPostsController');
		$this->assertTrue(is_a($result, 'TestsAppsPostsController'));
	}
	
	function testClassCallHelper() {
		$result = $this->Interactive->__classCall('$html->image("icons/ajax.gif")');
		$expected = '<img src="img/icons/ajax.gif" alt="" />';
		$this->assertEqual($expected, $result);
		
		$result = $this->Interactive->__classCall('$form->input("Article.title")');
		$expected = '<div class="input text"><label for="ArticleTitle">Title</label><input name="data[Article][title]" type="text" value="" id="ArticleTitle" /></div>';
		$this->assertEqual($expected, $result);
	}
	
	function testClassCallController() {
		Configure::write('controllerPaths', array(ROOT . DS . CAKE_TESTS . 'test_app' . DS . 'controllers'));
		$this->Interactive->objectPath = ROOT . DS . CAKE_TESTS . 'test_app' . DS . 'controllers';
		$result = $this->Interactive->__classCall('$TestsAppsPostsController->uses');
		$this->assertEqual(array('Post'), $result);
	}
	
	function testClassCallComponent() {
		Configure::write('debug', 0);
		Configure::write('Security.salt', 'fc4a7a2d16ed61344ff95c87674620c4ece9cea1');
		$result = $this->Interactive->__classCall('AuthComponent::password("test")');
		$this->assertEqual('cfc21a50c1f69eabdb6687d7f2b33891865f69bb', $result);
		Configure::write('debug', 2);
	}
	
	function testClassCallCore() {
		$result = $this->Interactive->__classCall('Router::url(array("controller" => "posts", "action" => "view", 3))');
		$this->assertEqual('/posts/view/3', $result);
	}
	
	function testClassCallModel() {
		$this->Interactive->objectPath = ROOT . DS . CAKE_TESTS . 'test_app' . DS . 'models';
		Configure::write('modelPaths', array(ROOT . DS . CAKE_TESTS . 'test_app' . DS . 'models'));
		$result = $this->Interactive->__classCall('Post::find("all")');
		$this->assertEqual(3, count($result));
		$this->assertEqual('First Post', $result[0]['Post']['title']);
	}
}
?>