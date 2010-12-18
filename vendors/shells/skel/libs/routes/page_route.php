<?php
/* todo: in past I have made a SlugRoute and page, article routes etc extend that good|bad */
class PageRoute extends CakeRoute {
 
    function parse($url) {
        $params = parent::parse($url);
        if (empty($params)) {
            return false;
        }
		$slugs = Cache::read('page_slugs', 'routes');
		if (empty($slugs)) {
			App::import('Model', 'Page');
			$Page = new Page();
			$pages = $Page->find('all', array(
				'fields' => array('Page.slug'),
				'recursive' => -1
			));
			$slugs = array_flip(Set::extract('/Page/slug', $pages));
			Cache::write('page_slugs', $slugs, 'routes');
		}
		if (isset($slugs[$params['slug']])) {
			return $params;
		}
        return false;
    }
 
}
?>