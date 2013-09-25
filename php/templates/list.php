<?php include '/templates/include/header.php' ?>

	<section class="articles">
		<h2 style="border-bottom: 1px solid #EEE"><?php echo $results['category']->name; ?></h2>
		<p class="description"><?php echo $results['category']->description; ?></p>
		<ul>
<?php foreach($results['pages'] as $page) { ?>
			<li>
				<article class="excerpt">
					<header class="article">
					<a href="index.php?action=view&page=<?php echo $page->id?>">
					<?php
						if($page->image) {
							echo '<img class="preview" src="imageResize.php?f=' . $page->image . '&w=160&h=160"/>';
						}
					?>
						<h3><?php echo $page->title?></h3></a>
						<time><?php $date = new DateTime($page->created_at); echo $date->format('M j, Y'); ?></time>
					</header>
					<br/>
					<?php echo '<span>' . $page->excerpt(EXCERPT_LENGTH) . ' ...</span>'; ?>
					
				</article>
			</li>
<?php } ?>
		</ul>
		<br/>
<?php
	if(($results['offset'] - NUM_ARTICLES_PAGE) > -1) {
		echo '<a href="index.php?action=list&category=' . $results['category']->id . '&offset=' . ($results['offset'] - NUM_ARTICLES_PAGE) . '"><span class="newer"><< Newer</span></a>';
	}
	if(($results['offset'] + NUM_ARTICLES_PAGE) < $results['pageCount']) {
		echo '<a href="index.php?action=list&category=' . $results['category']->id . '&offset=' . ($results['offset'] + NUM_ARTICLES_PAGE) . '"><span class="older">Older >></span></a>';
	}
?>

	</section>
<?php include '/templates/include/footer.php' ?>