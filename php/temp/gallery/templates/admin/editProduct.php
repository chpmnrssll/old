<?php include "templates/include/header.php" ?>
<?php include "templates/admin/imageUploadForm.php" ?>
	<iframe id="uploadIframe" style="display: none;"></iframe>
	<br/>
	<div class="content">
		<h2><?php echo $results['pageTitle']?></h2>
<?php if(isset($results['errorMessage'])) { ?><div class="errorMessage"><?php echo $results['errorMessage'] ?></div><?php } ?>
		<form action="admin.php?action=<?php echo $results['formAction']?>" method="post" class="edit" name="editForm" autocomplete="off">
			<input type="hidden" name="saveChanges" value="Save Changes"/> <!-- admin.php action -->
<?php if(!is_null($results['product']->id)) { ?> <input type="hidden" name="id" value="<?php echo $results['product']->id ?>"/> <?php } ?>
			<ul>
				<li>
					<label>Category</label>
					<select name="category">
						<option value="Cowboys Last Ride" <?php if($results['product']->category == 'Cowboys Last Ride') echo "selected='selected'"; ?>>Cowboys Last Ride</option>
						<option value="Metal" <?php if($results['product']->category == 'Metal') echo "selected='selected'"; ?>>Metal</option>
						<option value="Head Panels" <?php if($results['product']->category == 'Head Panels') echo "selected='selected'"; ?>>Head Panels</option>
						<option value="Emblems" <?php if($results['product']->category == 'Emblems') echo "selected='selected'"; ?>>Emblems</option>
					</select>
				</li>
				<li>
					<label>Name</label>
					<input type="text" name="name" id="name" placeholder="Product Name" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['product']->name )?>" />
				</li>
				<li>
					<label>Description</label>
					<textarea name="description" id="description" placeholder="Description" maxlength="100000" ><?php echo htmlspecialchars($results['product']->description) ?></textarea>
				</li>
				<li>
					<label>Stock #</label>
					<input type="text" name="stock" id="stock" placeholder="0" maxlength="255" value="<?php echo $results['product']->stock ?>" />
				</li>
				<li>
					<label>Price</label>
					<input type="text" name="price" id="price" placeholder="0" maxlength="255" value="<?php echo $results['product']->price ?>" />
				</li>
				<li>
					<input type="hidden" name="images" id="images" placeholder="..." maxlength="255" value="<?php echo $results['product']->images ?>" />
				</li>
				<li>
					<label>In Stock</label>
					<input type="checkbox" name="available" id="available" <?php if($results['product']->available > 0) echo 'checked="checked"' ?> value="true"/>
				</li>
			</ul>
		</form>
		
		<?php	//fill in file names input (file1, file2, file3 ...)
			$htmlString = "";
			if($results['product']->images != "") {
				$images = explode(',', $results['product']->images);
				for($i = 0; $i < count($images); $i++) {
					if($images[$i] != "") {
						$image = Image::getById((int)$images[$i]);
						$htmlString = $htmlString . $image->fileName . ',';
					}
				}
			}
		?>
		<input type="hidden" name="fileNames" id="fileNames" value="<?php echo $htmlString ?>" />
		
		<div style="border: 1px solid #EEE">
			<h3>&nbsp;Images</h3>
			&nbsp;<a href="javascript:void(0)" onclick="show('imageUploadForm')" class="edit">Add Image</a>
			<div id="imagePreview" style="text-align: center;"></div>
		</div>
		
		<script type="text/javascript" language="JavaScript" src="javascript/image.js"></script>
		<script type="text/javascript" language="JavaScript">
			imagePreview();
		</script>
		
		<div style="line-height: 2.25; text-align: right;">
			<a href="javascript: document.editForm.submit()" class="edit">Save Changes</a>
<?php if(!is_null($results['product']->id)) { ?>
			<a href="admin.php?action=deleteProduct&amp;productId=<?php echo $results['product']->id ?>" onclick="return confirm('Delete This Product?')" class="edit">Delete Product</a>
<?php } ?>
			<a href="admin.php?action=controlPanel" class="edit">Cancel</a>
		</div>
	</div>
<?php include "templates/include/footer.php" ?>
