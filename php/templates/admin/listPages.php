<?php include '/templates/include/header.php' ?>

	<section class="articles">
		<h2 style="border-bottom: 1px solid #EEE">Pages</h2>
		<table class="admin">
			<tr>
				<th style="width:18%; text-align:right">Updated</th>
				<th>Title</th>
				<th>Category</th>
			</tr>
<?php foreach($results['pages'] as $page) { ?>
			<tr onclick="location='admin.php?action=editPage&page=<?php echo $page->id; ?>'">
				<td style="width:18%; text-align:right"><?php $date = new DateTime($page->updated_at); echo $date->format('M j, Y'); ?></td>
				<td><?php echo $page->title; ?></td>
				<td><?php
					if($page->categoryid) {
						echo Category::find($page->categoryid)->name;
					}
				?></td>
			</tr>
<?php } ?>
		</table>
		<p style="text-align: right">
			<?php echo $results['pageCount']?> page<?php echo ( $results['pageCount'] != 1 ) ? 's' : '' ?> in total.
			<br/>
			<a href="admin.php?action=newPage" class="admin">Add New Page</a>
		</p>
	</section>

<?php include "templates/include/footer.php" ?>