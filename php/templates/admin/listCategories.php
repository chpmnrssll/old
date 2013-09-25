<?php include '/templates/include/header.php' ?>

	<section class="articles">
		<h2 style="border-bottom: 1px solid #EEE">Categories</h2>
		<table class="admin">
			<tr>
				<th style="width:18%">Category</th>
				<th>Description</th>
			</tr>
			<?php foreach($results['categories'] as $category) { ?>
			<tr onclick="location='admin.php?action=editCategory&category=<?php echo $category->id?>'">
				<td>
					<?php echo $category->name?>
				</td>
				<td>
					<?php echo $category->description?>
				</td>
			</tr>
			<?php } ?>
		</table>
		
		<p style="text-align: right">
			<?php echo count($results['categories']) ?> categor<?php echo (count($results['categories']) != 1) ? 'ies' : 'y' ?> in total.
			<br/>
			<a class="admin" href="admin.php?action=newCategory">Add a New Category</a>
		</p>
	</section>

<?php include "templates/include/footer.php" ?>