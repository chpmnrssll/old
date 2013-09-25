<?php include "templates/include/header.php" ?>
	<div class="content">
		<h2>Critters</h2>
		<br/>
		<ul class="products" style="height: 340px;">
			<li>
				<a href="catalog.php?action=products&category=Dogs&desc=templates/include/dogs.html">
				<img src="imageResize.php?f=images/dog.jpg&w=200&h=100"/><br/>
				Dogs</a>
			</li>
			<li>
				<a href="catalog.php?action=products&category=Cats&desc=templates/include/cats.html">
				<img src="imageResize.php?f=images/cat.jpg&w=200&h=100"/><br/>
				Cats</a>
			</li>
			<li>
				<a href="catalog.php?action=products&category=Critters&desc=templates/include/critters.html">
				<img src="imageResize.php?f=images/ferret.jpg&w=200&h=100"/><br/>
				Critters</a>
			</li>
			<li>
				<a href="catalog.php?action=products&category=Reptiles&desc=templates/include/reptiles.html">
				<img src="imageResize.php?f=images/lizard.jpg&w=200&h=100"/><br/>
				Reptiles</a>
			</li>
		</ul>
	</div>
<?php include "templates/include/footer.php" ?>