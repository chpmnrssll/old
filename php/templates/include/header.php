<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $results['title']; ?></title>
	<meta charset="utf-8" />
	<link rel="dns-prefetch" href="//ajax.googleapis.com" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Bevan" type="text/css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Pontano+Sans" type="text/css" />
	<link rel="stylesheet" href="javascript/fancyBox/source/jquery.fancybox.css" type="text/css" />
	<link rel="stylesheet" href="javascript/codemirror/lib/codemirror.css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body>
	<header class="main">
		<h1><a href="index.php"><?php echo SITE_NAME; ?></a></h1>
		<nav>
			<ul>
<?php
	foreach(Category::find('all', array('order' => 'id asc')) as $category) {
		if(isset($results['category'])) {
			$active = ($results['category']->id === $category->id) ? ' class="active"' : '';
		} else {
			$active = '';
		}
?>
				<li><a href="index.php?action=list&category=<?php echo $category->id; ?>" <?php echo $active ?>><?php echo $category->name ?></a></li>
<?php } ?>
			</ul>
		</nav>
	</header>