<?php
	require("config.php");
	$action = isset($_GET['action']) ? $_GET['action'] : "";
	$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
	
	switch($action) {
		case 'viewProduct':
			viewProduct();
			break;
		case 'products':
			products();
			break;
		default:
			products();
	}
	
	function viewProduct() {
		if(!isset($_GET["productId"]) || !$_GET["productId"]) {
			products();
			return;
		}
		
		$results = array();
		$results['product'] = Product::getById((int)$_GET["productId"]);
		require(TEMPLATE_PATH . "/viewProduct.php");
	}
	
	function products() {
		$results = array();
		$category = null;
		if(isset($_GET["category"])) {
			$category = $_GET["category"];
		}
		
		$data = Product::getList($category);
		$results['products'] = $data['results'];
		$results['pageTitle'] = $category;
		if(isset($_GET["desc"])) {
			$results['description'] = $_GET["desc"];
		}
		else {
			$results['description'] = "";
		}
		
		require(TEMPLATE_PATH . "/products.php");
	}
?>
