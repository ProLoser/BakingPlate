<?php
/**
 * AutoHelperView
 *
 * Provides automatic loading, or "lazy loading" of heleprs for the `View`
 * class.
 *
 * If a helper needs to be called prior to rendering or if it has any
 * settings you should keep it in your controller's `$helpers` array.
 *
 * @author Joe Beeson <jbeeson@gmail.com>
 */
App::import('Core', array('View', 'Controller'));
App::import('Helper', 'Cache');
App::import('View', array('AutoHelper', 'ThemedAutoHelper'));

Mock::generate('Helper', 'CallbackMockHelper');
Mock::generate('CacheHelper', 'ViewTestMockCacheHelper');

if (!class_exists('ErrorHandler')) {
		App::import('Core', array('Error'));
}

class ThemedAutoHelperTest extends CakeTestCase {

}
