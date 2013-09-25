<?php
if(!defined('CONFIG')) {
	date_default_timezone_set("America/Denver");
	define("TEMPLATE_PATH", "templates");
	define("IMAGE_PATH", "images");
	
	define("SITE_NAME", "Russell Chapman");
	define("NUM_ARTICLES_PAGE", 5);
	define("EXCERPT_LENGTH", 160);
	
	define("ADMIN_USERNAME", "admin");
	define("ADMIN_PASSWORD", "almis2010");
	
	function loggedIn() {
		if(isset($_SESSION['username'])) {
			if($_SESSION['username'] == ADMIN_USERNAME) {
				return true;
			}
		}
		return false;
	}
	
	session_start();
	define("CONFIG", true);
}
?>