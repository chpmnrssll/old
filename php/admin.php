<?php
ini_set('display_errors','On');
ini_set('error_reporting','E_ALL | E_STRICT');
require_once('config.php');
require_once('lib/php-activerecord/ActiveRecord.php');

ActiveRecord\Config::initialize(function($cfg) {
	$cfg->set_model_directory('models');
	$cfg->set_connections(array('development' => 'mysql://root:@localhost/cms'));
});

$action = isset($_GET['action']) ? $_GET['action'] : "";
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
if($action != "login" && $action != "logout" && !$username) {
	login();
	exit;
}

switch($action) {
	case 'listPages':
		listPages();
		break;
	case 'listCategories':
		listCategories();
		break;
	case 'newPage':
		newPage();
		break;
	case 'newCategory':
		newCategory();
		break;
	case 'editPage':
		editPage();
		break;
	case 'editCategory':
		editCategory();
		break;
	case 'deletePage':
		deletePage();
		break;
	case 'deleteCategory':
		deleteCategory();
		break;
	case 'login':
		login();
		break;
	case 'logout':
		logout();
		break;
	default:
		header('Location: index.php');
}

function listPages() {
	$results = array();
	$results['pageCount'] = count(Page::find('all'));
	$results['pages'] = Page::find('all', array('order' => 'updated_at desc'));
	$results['title'] = SITE_NAME . ' - Pages';
	require(TEMPLATE_PATH . '/admin/listPages.php');
}

function listCategories() {
	$results = array();
	$results['categories'] = Category::find('all');
	$results['title'] = SITE_NAME . ' - Categories';
	require(TEMPLATE_PATH . '/admin/listCategories.php');
}

function newPage() {
	$results = array();
	$results['title'] = SITE_NAME . ' - New Page';
	$results['formAction'] = 'newPage';
	
	if(isset($_POST['saveChanges'])) {
		// User has posted the form: save the new page
		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$tags = isset($_POST['tags']) ? $_POST['tags'] : '';
		$image = isset($_POST['image']) ? $_POST['image'] : '';
		$categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : '';
		$page = Page::create(array('title' => $title, 'content' => $content, 'tags' => $tags, 'image' => $image, 'categoryId' => $categoryId));
		header('Location: admin.php?action=listPages&status=pageSaved');
	} elseif(isset($_POST['cancel'])) {
		// User has cancelled: return to the list
		header('Location: admin.php?action=listPages');
	} else {
		// User has not posted the form yet: display the form
		$results['page'] = new stdClass();
		$results['page']->id = '';
		$results['page']->title = '';
		$results['page']->content = '';
		$results['page']->image = '';
		$results['page']->tags = '';
		$results['page']->categoryid = 0;
		require(TEMPLATE_PATH . '/admin/editPage.php');
	}
}

function newCategory() {
	$results = array();
	$results['title'] = SITE_NAME . ' - New Category';
	$results['formAction'] = 'newCategory';
	
	if(isset($_POST['saveChanges'])) {
		// User has posted the form: save the new category
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$description = isset($_POST['description']) ? $_POST['description'] : '';
		$category = Category::create(array('name' => $name, 'description' => $description));
		header('Location: admin.php?action=listCategories&status=categorySaved');
	} elseif(isset($_POST['cancel'])) {
		// User has cancelled: return to the list
		header('Location: admin.php?action=listCategories');
	} else {
		// User has not posted the form yet: display the form
		$results['category'] = new stdClass();
		$results['category']->id = '';
		$results['category']->name = '';
		$results['category']->description = '';
		require(TEMPLATE_PATH . '/admin/editCategory.php');
	}
}

function editPage() {
	$results = array();
	$results['title'] = SITE_NAME . ' - Edit Page';
	$results['formAction'] = 'editPage';
	
	if(isset($_POST['saveChanges'])) {
		// User has posted the edit form: save the changes
		if(!$page = Page::find(isset($_POST['pageId']) ? $_POST['pageId'] : '')) {
			header('Location: admin.php?error=pageNotFound');
			return;
		}
		
		$page->title = isset($_POST['title']) ? $_POST['title'] : '';
		$page->content = isset($_POST['content']) ? $_POST['content'] : '';
		$page->tags = isset($_POST['tags']) ? $_POST['tags'] : '';
		$page->image = isset($_POST['image']) ? $_POST['image'] : '';
		$page->categoryid = isset($_POST['categoryId']) ? $_POST['categoryId'] : '';
		$page->save();
		header('Location: admin.php?action=listPages&status=pageSaved');
	} elseif(isset($_POST['cancel'])) {
		// User has cancelled their edits: return to the list
		header('Location: admin.php?action=listPages');
	} else {
		// User has not posted the edit form yet: display the form
		$results['page'] = Page::find((int)$_GET['page']);
		require(TEMPLATE_PATH . '/admin/editPage.php');
	}
}

function editCategory() {
	$results = array();
	$results['title'] = SITE_NAME . ' - Edit Category';
	$results['formAction'] = 'editCategory';
	
	if(isset($_POST['saveChanges'])) {
		// User has posted the edit form: save the changes
		if(!$category = Category::find(isset($_POST['categoryId']) ? $_POST['categoryId'] : '')) {
			header('Location: admin.php?action=listCategories&error=categoryNotFound');
			return;
		}
		
		$category->name = isset($_POST['name']) ? $_POST['name'] : '';
		$category->description = isset($_POST['description']) ? $_POST['description'] : '';
		$category->save();
		header('Location: admin.php?action=listCategories&status=categorySaved');
	} elseif(isset($_POST['cancel'])) {
		// User has cancelled their edits: return to the list
		header('Location: admin.php?action=listCategories');
	} else {
		// User has not posted the edit form yet: display the form
		$results['category'] = Category::find((int)$_GET['category']);
		require(TEMPLATE_PATH . '/admin/editCategory.php');
	}
}

function deletePage() {
	if(!$page = Page::find((int)$_GET['page'])) {
		header('Location: admin.php?error=pageNotFound');
		return;
	}
	
	$page->delete();
	header('Location: admin.php?action=listPages&status=pageDeleted');
}

function deleteCategory() {
	if(!$category = Category::find((int)$_GET['category'])) {
		header('Location: admin.php?action=listCategories&error=categoryNotFound');
		return;
	}
	
	$pages = Page::find('all', array('conditions' => array('categoryId = ?', $category->id)));
	if(count($pages) > 0) {
		header('Location: admin.php?action=listCategories&error=categoryContainsPages');
		return;
	}
	
	$category->delete();
	header('Location: admin.php?action=listCategories&status=categoryDeleted');
}

function login() {
	if(isset($_POST['login'])) {
		// User has posted the login form: attempt to log the user in
		if($_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD) {
			// Login successful: Create a session and redirect to the admin homepage
			$_SESSION['username'] = ADMIN_USERNAME;
			header('Location: admin.php');
		} else {
			// Login failed: display an error message to the user (homepage)
			header('Location: index.php?error=incorrectLogin');
		}
	}
}

function logout() {
	unset($_SESSION['username']);
	header('Location: index.php');
}
?>