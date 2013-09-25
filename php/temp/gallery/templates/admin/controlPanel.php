<?php include "templates/include/header.php" ?>
	<br/>
	<div class="content">
		<h2>Control Panel</h2>
		<br/>
<?php if(isset($results['errorMessage'])) { ?><div class="errorMessage"><?php echo $results['errorMessage'] ?></div><?php } ?>
<?php if(isset($results['statusMessage'])) { ?><div class="statusMessage"><?php echo $results['statusMessage'] ?></div><?php } ?>
		<div class="list">
			<h3 style="border-bottom: 1px solid #EEE;">Products</h3>
			<table>
				<tr>
					<th style="width:200px; text-align:left">Category</th>
					<th style="text-align:left">Name</th>
				</tr>
<?php foreach($results['products'] as $product) { ?>
				<tr onclick="location='admin.php?action=editProduct&amp;productId=<?php echo $product->id ?>'">
					<td style="width:200px"><?php echo $product->category ?></td>
					<td><?php echo $product->name ?></td>
				</tr>
<?php } ?>
			</table>
			<div style="text-align: right"><a href="admin.php?action=newProduct" class="admin">Add Product</a></div>
			<br/>
			<br/>
		</div>
	</div>
<?php include "templates/include/footer.php" ?>