<?php include 'templates/include/header.php' ?>
	
	<article class="full">
		<header class="article">
			<a href="index.php?action=view&page=<?php echo $results['page']->id; ?>"><h3><?php echo $results['page']->title; ?></h3></a>
			<time><?php $date = new DateTime($results['page']->updated_at); echo $date->format('M j, Y'); ?></time>
		</header>
		<?php echo $results['page']->content . "\n"; ?>
		<br/>
	</article>
<?php include 'templates/include/footer.php' ?>
