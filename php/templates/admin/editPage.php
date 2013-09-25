<?php include '/templates/include/header.php' ?>

	<section class="articles">
		<h2 style="border-bottom: 1px solid #EEE">Edit Page</h2>
		<form action="admin.php?action=<?php echo $results['formAction']; ?>" method="post" class="edit">
			<input type="hidden" name="pageId" value="<?php echo $results['page']->id; ?>"/>
			<ul>
				<li>
					<label for="title">Title</label>
					<input type="text" name="title" id="title" placeholder="Page Title" required autofocus maxlength="255" value="<?php echo $results['page']->title; ?>" />
				</li>
				<li>
					<label for="content">Content</label>
					<textarea name="content" id="content" placeholder="Page Content" required maxlength="100000" style="height: 30em;"><?php echo $results['page']->content; ?></textarea>
				</li>
				<li>
					<label for="image">Image</label>
					<input type="text" name="image" id="image" placeholder="Image" maxlength="255" value="<?php echo $results['page']->image; ?>" />
				</li>
				<li>
					<label for="tags">Tags</label>
					<input type="text" name="tags" id="tags" placeholder="Tags" maxlength="255" value="<?php echo $results['page']->tags; ?>" />
				</li>
				<li>
					<label for="categoryId">Category</label>
					<select name="categoryId">
						<option value="0"<?php echo !$results['page']->categoryid ? " selected" : ""; ?>>(none)</option>
						<?php foreach(Category::find('all') as $category) { ?>
						<option value="<?php echo $category->id; ?>" <?php echo ($category->id == $results['page']->categoryid) ? " selected" : ""; ?>><?php echo $category->name; ?></option>
						<?php } ?>
					</select>
				</li>
			</ul>
			<input type="submit" name="saveChanges" value="Save Changes"/>
			<input type="submit" formnovalidate name="cancel" value="Cancel"/>
<?php if($results['page']->id) { ?>
			<p style="float: right"><a href="admin.php?action=deletePage&page=<?php echo $results['page']->id; ?>" onclick="return confirm('Delete This Page?')" class="admin">Delete Page</a>&nbsp;&nbsp;&nbsp;&nbsp;</p>
<?php } ?>
		</form>
	</section>
<?php include '/templates/include/footer.php' ?>
