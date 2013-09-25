<?php include 'templates/include/header.php' ?>

	<article class="full">
		<header class="article">
			<h2 style="border-bottom: 1px solid #EEE"><?php echo $results['category']->name; ?></h2>
			<p class="description"><?php echo $results['category']->description; ?></p>
		</header>
		<?php echo $results['page']->content . "\n"; ?>
		<br/>
	</article>
<?php include 'templates/include/footer.php' ?>
