<?php include "templates/include/header.php" ?>
	<script type="text/javascript" src="javascript/popupImage.js"></script>
	<div class="content">
		<h2><?php echo htmlspecialchars($results['product']->category)?></h2>
		<h4><?php echo htmlspecialchars($results['product']->name) ?></h4>
		<?php if($results['product']->description != "") { ?>
		<?php echo $results['product']->description ?><br/>
		<?php } ?>
		<?php
			if($results['product']->available > 0) {
				echo "<h3>Available for adoption.</h3>";
			}
			else {
				echo "<h3>Adopted.</h3>";
			}
		?>
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
		<?php if($results['product']->video != "") { ?>
		<iframe width="420" height="315" style="display: block; margin: 0 auto;" src="http://www.youtube.com/embed/<?php echo $results['product']->video ?>?rel=0;showinfo=0;theme=light" frameborder="0" allowfullscreen></iframe>
		<?php } ?>
		
		<div id="bgFade" class="background" style="display:none;"></div>
		<div id="imageDiv" class="fullImage" style="display:none;">
		</div>
	</div>
<?php include "templates/include/footer.php" ?>
