<?php
ini_set('display_errors','On');
ini_set('error_reporting','E_ALL | E_STRICT');
error_reporting(E_ALL);
require_once("$HOME/config.php");
require_once("$HOME/lib/php-activerecord/ActiveRecord.php");

ActiveRecord\Config::initialize(function($cfg) {
	$cfg->set_model_directory('models');
	//$cfg->set_connections(array('development' => 'mysql://root:@localhost/cms'));
	$cfg->set_connections(array('development' => "mysql://$OPENSHIFT_MYSQL_DB_HOST:$OPENSHIFT_MYSQL_DB_PORT/cms"));
});

$action = isset($_GET['action']) ? $_GET['action'] : null;
switch($action) {
	case 'list':
		listPages();
		break;
	case 'view':
		viewPage();
		break;
	default:
		listPages();
}

function listPages() {
	$results = array();
	$results['category'] = isset($_GET['category']) ? Category::find($_GET['category']) : Category::find('first');
	$results['offset'] = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
	$results['pageCount'] = count(Page::find('all', array('conditions' => array('categoryId = ?', $results['category']->id))));
	$results['pages'] = Page::find('all', array('conditions' => array('categoryId = ?', $results['category']->id), 'limit' => NUM_ARTICLES_PAGE, 'offset' => $results['offset'], 'order' => 'created_at desc'));
	$results['title'] = SITE_NAME . ' - ' . $results['category']->name;
	
	if($results['pageCount'] == 1) {
		categoryPage($results['pages'][0]);
		return;
	} else {
		require(TEMPLATE_PATH . '/list.php');
	}
}

function categoryPage($page) {
	$results = array();
	$results['page'] = $page;
	$results['category'] = Category::find((int)$results['page']->categoryid);
	$results['title'] = SITE_NAME . ' - ' . $results['page']->title;
	require(TEMPLATE_PATH . '/categoryPage.php');
}

function viewPage() {
	if(!isset($_GET['page'])) {
		listPages();
		return;
	}
	
	$results = array();
	$results['page'] = Page::find($_GET['page']);
	$results['category'] = Category::find((int)$results['page']->categoryid);
	$results['title'] = SITE_NAME . ' - ' . $results['page']->title;
	require(TEMPLATE_PATH . '/view.php');
}
?>