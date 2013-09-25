<?php
	require("config.php");
	$action = isset($_GET['action']) ? $_GET['action'] : "";
	$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
	
	if($_SESSION['back'] == "") {
		$_SESSION['back'] = "index.php";
	}
	
	if($action != "login" && $action != "logout" && !$username) {
		login();
		exit;
	}
	
	switch($action) {
		case 'login':
			login();
			break;
		case 'logout':
			logout();
			break;
		case 'newProduct':
			newProduct();
			break;
		case 'editProduct':
			editProduct();
			break;
		case 'deleteProduct':
			deleteProduct();
			break;
		case 'newImage':
			newImage();
			break;
		case 'editImage':
			editImage();
			break;
		case 'deleteImage':
			deleteImage();
			break;
		case 'controlPanel':
			controlPanel();
			break;
		case 'uploadImage':
			uploadImage();
			break;
		default:
			header("Location: " . $_SESSION['back']);
	}
	
	function login() {
		$results = array();
		$results['pageTitle'] = "Admin Login | " . SITE_NAME;
		
		if(isset($_POST['login'])) {
			// User has posted the login form: attempt to log the user in
			if($_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD) {
				// Login successful: Create a session and redirect to the admin homepage
				$_SESSION['username'] = ADMIN_USERNAME;
				header("Location: " . $_SESSION['back']);
			} else {
				// Login failed: display an error message to the user (homepage)
				$results['errorMessage'] = "Incorrect username or password. Please try again.";
				header("Location: " . $_SESSION['back']);
			}
		}
	}
	
	function logout() {
		unset($_SESSION['username']);
		header("Location: index.php");
	}
	
	function newProduct() {
		$results = array();
		$results['pageTitle'] = "New Product";
		$results['formAction'] = "newProduct";
		
		if(isset($_POST['saveChanges'])) {
			// User has posted the product edit form: save the new product
			$product = new Product;
			$product->storeFormValues($_POST);
			$product->insert();
			header("Location: admin.php?action=controlPanel");
		} elseif(isset($_POST['cancel'])) {
			// User has cancelled their edits: return to the control panel
			header("Location: admin.php?action=controlPanel");
		} else {
			// User has not posted the product edit form yet: display the form
			$results['product'] = new Product;
			require(TEMPLATE_PATH . "/admin/editProduct.php");
		}
	}
	
	function editProduct() {
		$results = array();
		$results['pageTitle'] = "Edit Product";
		$results['formAction'] = "editProduct";
		
		if(isset($_POST['saveChanges'])) {
			// User has posted the product edit form: save the product changes
			if(!$product = Product::getById((int)$_POST['id'])) {
				header("Location: admin.php?error=productNotFound");
				return;
			}
			
			$product->storeFormValues($_POST);
			$product->update();
			header("Location: admin.php?action=controlPanel");
		} elseif(isset($_POST['cancel'])) {
			// User has cancelled their edits: return to the control panel
			header("Location: admin.php?action=controlPanel");
		} else {
			// User has not posted the product edit form yet: display the form
			$results['product'] = Product::getById((int)$_GET['productId']);
			require(TEMPLATE_PATH . "/admin/editProduct.php");
		}
	}
	
	function deleteProduct() {
		if(!$product = Product::getById((int)$_GET['productId'])) {
			header("Location: admin.php?error=productNotFound");
			return;
		}
		
		$product->delete();
		header("Location: admin.php?action=controlPanel");
	}
	
	function newImage() {
		$results = array();
		$results['pageTitle'] = "New Image";
		$results['formAction'] = "newImage";
		
		if(isset($_POST['saveChanges'])) {
			// User has posted the image edit form: save the new image
			$image = new Image;
			$image->storeFormValues($_POST);
			$image->insert();
			header("Location: admin.php?action=controlPanel");
		} elseif(isset($_POST['cancel'])) {
			// User has cancelled their edits: return to the control panel
			header("Location: admin.php?action=controlPanel");
		} else {
			// User has not posted the image edit form yet: display the form
			$results['image'] = new Image;
			require(TEMPLATE_PATH . "/admin/editImage.php");
		}
	}
	
	function editImage() {
		$results = array();
		$results['pageTitle'] = "Edit Image";
		$results['formAction'] = "editImage";
		
		if(isset($_POST['saveChanges'])) {
			// User has posted the image edit form: save the image changes
			if(!$image = Image::getById((int)$_POST['id'])) {
				header("Location: admin.php?error=imageNotFound");
				return;
			}
			
			$image->storeFormValues($_POST);
			$image->update();
			header("Location: admin.php?action=controlPanel");
		} elseif(isset($_POST['cancel'])) {
			// User has cancelled their edits: return to the control panel
			header("Location: admin.php?action=controlPanel");
		} else {
			// User has not posted the image edit form yet: display the form
			$results['image'] = Image::getById((int)$_GET['imageId']);
			require(TEMPLATE_PATH . "/admin/editImage.php");
		}
	}
	
	function deleteImage() {
		if(!$image = Image::getById((int)$_GET['imageId'])) {
			header("Location: admin.php?error=imageNotFound");
			return;
		}
		
		$image->delete();
		header("Location: admin.php?action=controlPanel");
	}
	
	function controlPanel() {
		$results = array();
		$data = Product::getList(null);
		$results['products'] = $data['results'];
		$results['totalRows'] = $data['totalRows'];
		
		$data = Image::getList(null);
		$results['images'] = $data['results'];
		$results['totalImages'] = $data['totalRows'];
		
		if(isset($_GET['error'])) {
			if($_GET['error'] == "productNotFound") $results['errorMessage'] = "Error: Product not found.";
			if($_GET['error'] == "imageNotFound") $results['errorMessage'] = "Error: Image not found.";
		}
		
		if(isset($_GET['status'])) {
			if($_GET['status'] == "changesSaved") $results['statusMessage'] = "Your changes have been saved.";
			if($_GET['status'] == "productDeleted") $results['statusMessage'] = "Product deleted.";
			if($_GET['status'] == "imageDeleted") $results['statusMessage'] = "Image deleted.";
		}
		
		require(TEMPLATE_PATH . "/admin/controlPanel.php");
	}
	
	function uploadImage() {
		if($_FILES['image']['error'] == UPLOAD_ERR_OK && in_array($_FILES['image']['type'], array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg','image/png'))) {
			move_uploaded_file($_FILES['image']['tmp_name'], 'images/upload/' . $_FILES['image']['name']);
			
			$image = new Image();
			$image->fileName = $_FILES['image']['name'];
			$image->description = $_POST['description'];
			$image->insert();
			
			echo "<script type='text/javascript' src='javascript/popup2.js'></script>\n";
			echo "<script type='text/javascript' src='javascript/image.js'></script>\n";
			echo "<script language='JavaScript' type='text/javascript'>\n";
			echo "var imagesField = window.parent.document.getElementById('images');\n";
			echo "var fileNamesField = window.parent.document.getElementById('fileNames');\n";
			echo "imagesField.value += '" . $image->id . ",';\n";
			echo "fileNamesField.value += '" . $image->fileName . ",';";
			echo "hide('imageUploadForm');\n";
			echo "imagePreview();\n";
			echo "</script>\n";
		}
	}
?>
