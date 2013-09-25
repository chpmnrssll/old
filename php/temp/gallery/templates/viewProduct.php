<?php include "templates/include/header.php" ?>
	<script type="text/javascript" src="javascript/popupImage.js"></script>
	<br/>
	<div class="content">
		<h2><?php echo htmlspecialchars($results['product']->category)?></h2>
		<h3><?php echo htmlspecialchars($results['product']->name) ?></h3>
		Availability: <?php 
			if($results['product']->available > 0) {
				echo "In Stock";
			}
			else {
				echo "Out of Stock";
			}
		?><br/>
		<?php if($results['product']->stock > 0) { ?>
		Stock #: <?php echo $results['product']->stock ?><br/>
		<?php } ?>
		<?php if($results['product']->price > 0) { ?>
		Price: $<?php echo $results['product']->price ?><br/><br/>
		<?php } ?>
		<?php if($results['product']->description != "") { ?>
		Description: <?php echo $results['product']->description ?><br/>
		<?php } ?>
		<br/><br/>
		<div style="text-align: center;">
		<?php
			if($results['product']->images != "") {
				$images = explode(',', $results['product']->images);
				for($i = 0; $i < count($images); $i++) {
					$image = Image::getById((int)$images[$i]);
					if($image) {
						if($image->description != "") {
							echo "<a href='javascript:void(0)' onclick='showImage(\"imageDiv\", \"imageResize.php?f=images/upload/" . $image->fileName . "&w=800&h=600\", \"" . $image->description . "\")'>";
						}
						else {
							echo "<a href='javascript:void(0)' onclick='showImage(\"imageDiv\", \"imageResize.php?f=images/upload/" . $image->fileName . "&w=800&h=600\")'>";
						}
						echo "<img src='imageResize.php?f=images/upload/" . $image->fileName . "&w=200&h=100' class='preview'/>&nbsp;";
						echo "</a>";
					}
				}
			}
		?>
		</div>
		
		<div id="bgFade" class="background" style="display:none;"></div>
		<div id="imageDiv" class="fullImage" style="display:none;">
		</div>
	</div>
<?php include "templates/include/footer.php" ?>
