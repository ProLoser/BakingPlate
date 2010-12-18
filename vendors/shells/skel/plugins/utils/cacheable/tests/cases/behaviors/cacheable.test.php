<?php

/**
 * Generic CacheThing Model
 *
 * @since       0.1
 * @author      Joshua McNeese <jmcneese@gmail.com>
 * @package     cacheable
 * @subpackage  cacheable.tests.cases.behaviors
 * @uses        CakeTestModel
 * @license     Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 * @copyright   Copyright (c) 2009,2010 Joshua M. McNeese, HouseParty Inc.
 */
class CacheThing extends CakeTestModel {

	public $actsAs = array(
		 'Cacheable.Cacheable' => array(
			 'model' => array(
				'engine'    => 'File',
				'duration'  => '+1 hour',
				'prefix'    => 'cache_thing_',
				'serialize' => true
			),
			'record' => array(
				'engine'    => 'File',
				'duration'  => '+1 hour',
				'prefix'    => null,
				'serialize' => true
			)
		 )
	);

}

/**
 * CacheableBehavior Test Case
 *
 * @since       0.1
 * @author      Joshua McNeese <jmcneese@gmail.com>
 * @package     cacheable
 * @subpackage  cacheable.tests.cases.behaviors
 * @see         CacheableBehavior
 * @see         CacheThing
 * @license     Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 * @copyright   Copyright (c) 2009,2010 Joshua M. McNeese, HouseParty Inc.
 */
class CacheableTestCase extends CakeTestCase {

    /**
     * @var array
     */
    public $fixtures = array(
        'plugin.cacheable.cache_thing'
    );

    /**
     * @return  void
     */
    public function start() {

        parent::start();

        $this->CacheThing = ClassRegistry::init('Cacheable.CacheThing');
		
    }

    /**
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function startTest($action) {

        parent::startTest($action);

        Configure::write('Cache.disable',	false);
        Configure::write('Cache.check',		true);

    }

    /**
     * Test Instance Creation
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testInstanceSetup() {

        $this->assertIsA($this->CacheThing, 'Model');
        $this->assertTrue($this->CacheThing->Behaviors->attached('Cacheable'));

    }

    /**
     * Test getting the cache dir
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testGetCacheDir() {

        $id1 = String::uuid();
        $result1 = $this->CacheThing->getCacheDir();
        $this->assertTrue(file_exists($result1), "Directory not created: $result1 ");
        $this->assertTrue(is_dir($result1), "Path does not indicate a directory: $result1");
        $this->assertTrue(is_writeable($result1), "Directory not writeable: $result1");

        $result2 = $this->CacheThing->getCacheDir($id1);
        $this->assertTrue(file_exists($result2), "Directory not created: $result2 ");
        $this->assertTrue(is_dir($result2), "Path does not indicate a directory: $result2");
        $this->assertTrue(is_writeable($result2), "Directory not writeable: $result2");

        $this->CacheThing->id = $id1;
        $result3 = $this->CacheThing->getCacheDir();
        $this->assertTrue(file_exists($result3), "Directory not created: $result3 ");
        $this->assertTrue(is_dir($result3), "Path does not indicate a directory: $result3");
        $this->assertTrue(is_writeable($result3), "Directory not writeable: $result3");

    }

    /**
     * Test getting the cache config
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testGetCacheConfig() {

		$this->CacheThing->id = null;
        $result1 = $this->CacheThing->getCacheConfig();
        $this->assertTrue(Cache::config($result1));
        $this->assertEqual($result1, 'cacheable_' . $this->CacheThing->table);

		$id1 = String::uuid();
        $result2 = $this->CacheThing->getCacheConfig($id1);
        $this->assertTrue(Cache::config($result2));
        $this->assertEqual($result2, 'cacheable_' . $this->CacheThing->table . '_' . $id1);

    }

    /**
     * Test getting and setting the cache data
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testGetAndSetCached() {

        $uuid1 = String::uuid();
        $key1 = 'test';
        $data1 = array(
            'foo',
            'bar',
            'baz'
        );

        $result1 = $this->CacheThing->setCached($key1, $data1);
        $this->assertTrue($result1);

        $result2 = $this->CacheThing->getCached($key1);
        $this->assertTrue($result2);
        $this->assertEqual($result2, $data1);

        $result3 = $this->CacheThing->setCached($key1, $data1, $uuid1);
        $this->assertTrue($result3);

        $result4 = $this->CacheThing->getCached($key1, $uuid1);
        $this->assertTrue($result4);
        $this->assertEqual($result4, $data1);

    }

    /**
     * Test deleting specific cache data
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testDeleteCached() {

        $uuid1 = String::uuid();
        $key1 = 'test';
        $data1 = array(
            'foo',
            'bar',
            'baz'
        );

        $this->CacheThing->setCached($key1, $data1);

        $result1 = $this->CacheThing->deleteCached($key1);
        $this->assertTrue($result1);

        $result2 = $this->CacheThing->getCached($key1);
        $this->assertFalse($result2);

        $this->CacheThing->setCached($key1, $data1, $uuid1);

        $result3 = $this->CacheThing->deleteCached($key1, $uuid1);
        $this->assertTrue($result3);

        $result4 = $this->CacheThing->getCached($key1, $uuid1);
        $this->assertFalse($result4);

    }

    /**
     * Test deleting specific cache data
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testClearCached() {

        $uuid1 = String::uuid();
        $key1 = 'test';
        $data1 = array(
            'foo',
            'bar',
            'baz'
        );

        $this->CacheThing->setCached($key1, $data1);
        $this->CacheThing->setCached($key1, $data1, $uuid1);

        $result1 = $this->CacheThing->clearCached(false);
        $this->assertTrue($result1);

        $config1 = Cache::settings($this->CacheThing->getCacheConfig());
        $folder1 = new Folder($config1['path']);
        $contents1 = $folder1->read();
        $this->assertTrue(count($contents1['1']) == 0);

        $result2 = $this->CacheThing->clearCached(false, $uuid1);
        $this->assertTrue($result2);

        $config2 = Cache::settings($this->CacheThing->getCacheConfig($uuid1));
        $folder2 = new Folder($config2['path']);
        $contents2 = $folder2->read();
        $this->assertTrue(count($contents2['1']) == 0);

    }

    /**
     * Test afterSave callback
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testAfterSave() {

        $data1 = array(
            'foo',
            'bar',
            'baz'
        );

        $this->CacheThing->setCached('test', $data1);

        $this->CacheThing->id = 1;

        $data1 = $this->CacheThing->read();
        $hash1 = md5(serialize($data1));

        $this->CacheThing->setCached('hash', $hash1);
        $this->CacheThing->save();

        $result1 = $this->CacheThing->getCached('hash');
        $this->assertFalse($result1);

        $this->CacheThing->id = null;

        $result2 = $this->CacheThing->getCached('test');
        $this->assertFalse($result2);

    }

    /**
     * Test afterDelete callback
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testAfterDelete() {

        $data1 = array(
            'foo',
            'bar',
            'baz'
        );

        $this->CacheThing->setCached('test', $data1);

        $this->CacheThing->id = 1;

        $data1 = $this->CacheThing->read();
        $hash1 = md5(serialize($data1));

        $this->CacheThing->setCached('hash', $hash1);
        $this->CacheThing->delete();

        $result1 = $this->CacheThing->getCached('hash');
        $this->assertFalse($result1);

        $this->CacheThing->id = null;

        $result2 = $this->CacheThing->getCached('test');
        $this->assertFalse($result2);

    }

    /**
     * Test afterDelete callback
     *
     * @since   0.1
     * @author  Joshua McNeese <jmcneese@gmail.com>
     * @return  void
     */
    public function testFindCachedAndCallbacks() {

        $opts1 = array(
            'limit' => 1,
            'page'  => 2,
            'cacheable' => true,
            'order' => 'name DESC'
        );

        $result1 = $this->CacheThing->find('all', $opts1);
        $this->assertTrue($result1);

        $result2 = $this->CacheThing->findCached($opts1);
        $this->assertTrue($result2);
        $this->assertEqual($result2, $result1);

        $opts2 = array(
            'conditions' => array(
                'cacheable' => array(
                    'duration' => '+1 day'
                )
            )
        );

        $result3 = $this->CacheThing->find('all', $opts2);
        $this->assertTrue($result3);

        $result4 = $this->CacheThing->findCached($opts2);
        $this->assertTrue($result4);
        $this->assertEqual($result4, $result3);

    }

}

?>