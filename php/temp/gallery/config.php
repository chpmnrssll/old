<?php
	if(!defined('CONFIG')) {
		date_default_timezone_set("America/Denver");
		/* online host only */
		//define("DB_DSN", "mysql:host=coloradocasketcompan.ipagemysql.com;dbname=my_new_db");
		//define("DB_USERNAME", "products");
		//define("DB_PASSWORD", "products");
		//define("HOME_PATH", "/hermes/bosweb/web246/b2463/ipg.coloradocasketcompan/");
		
		/* localhost only */
		define("DB_DSN", "mysql:host=localhost;dbname=products");
		define("DB_USERNAME", "root");
		define("DB_PASSWORD", "");
		define("HOME_PATH", "/");
		
		define("CLASS_PATH", HOME_PATH . "classes");
		define("TEMPLATE_PATH", HOME_PATH . "templates");
		define("IMAGE_PATH", HOME_PATH . "images");
		define("ADMIN_USERNAME", "admin");
		define("ADMIN_PASSWORD", "almis2012");
		define("SITE_NAME", "Gallery");
		//require(CLASS_PATH . "/product.php");
		//require(CLASS_PATH . "/image.php");
		
		function handleException($exception) {
			echo "Sorry, a problem occurred. Please try later. <br/>";
			echo $exception->getMessage();
		}
		
		function loggedIn() {
			if(isset($_SESSION['username'])) {
				if($_SESSION['username'] == ADMIN_USERNAME) {
					return true;
				}
			}
			return false;
		}
		
		session_start();
		set_exception_handler('handleException');
		define("CONFIG", true);
	}
?>
