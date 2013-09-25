<?php include "templates/include/header.php" ?>
	
	<br/>
	<div class="content">
		<h2><?php echo htmlspecialchars($results['pageTitle']); ?></h2>
<?php if($results['description'] != "") { include $results['description']; }?>
		<br/>
		<ul class="products">
<?php foreach($results['products'] as $product) { ?>
			<li>
				<a href="catalog.php?action=viewProduct&amp;productId=<?php echo $product->id?>">
				<?php
					if($product->images != "") {
						$images = explode(',', $product->images);
						$image = Image::getById((int)$images[0]);
						echo "<img src='imageResize.php?f=images/upload/" . $image->fileName . "&w=200&h=100' class='preview'/>&nbsp;";
					}
				?>
				<?php echo htmlspecialchars($product->name)?>
				</a>
			</li>
<?php } ?>
		</ul>
		<br/>
	</div>
<?php include "templates/include/footer.php" ?>
