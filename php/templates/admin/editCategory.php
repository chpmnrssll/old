<?php include '/templates/include/header.php' ?>

	<section class="articles">
		<h2 style="border-bottom: 1px solid #EEE">Edit Category</h2>
		<form action="admin.php?action=<?php echo $results['formAction']; ?>" method="post" class="edit">
			<input type="hidden" name="categoryId" value="<?php echo $results['category']->id; ?>"/>
			<ul>
				<li>
					<label for="name">Name</label>
					<input type="text" name="name" id="name" placeholder="Name of the category" required autofocus maxlength="255" value="<?php echo $results['category']->name; ?>" />
				</li>
				<li>
					<label for="description">Description</label>
					<textarea name="description" id="description" placeholder="Brief description of the category" required maxlength="1000" style="height: 5em;"><?php echo $results['category']->description; ?></textarea>
				</li>
			</ul>
			
			<input type="submit" name="saveChanges" value="Save Changes" />
			<input type="submit" formnovalidate name="cancel" value="Cancel" />
<?php if($results['category']->id) { ?>
			<p style="float: right"><a href="admin.php?action=deleteCategory&category=<?php echo $results['category']->id; ?>" onclick="return confirm('Delete This Category?')" class="admin">Delete This Category</a></p>
<?php } ?>
		</form>
	</section>
<?php include '/templates/include/footer.php' ?>
