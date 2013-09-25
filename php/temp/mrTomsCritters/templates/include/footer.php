	<div class="footer">
		<p>Please <a href="contact.php">contact</a> us for more information.<br/>
		<a href="privacy.php">Privacy Policy</a>
		<?php
			if(loggedIn()) {
				include "templates/admin/loggedInControls.php";
			} else {
				include "templates/admin/loginForm.php";
			}
		?>
		</p>
		<h3>Site design and development by <a href="http://chpmn.lonelydev.org/index.php?action=about" target="_blank">Russell Chapman</a></h3>
	</div>
	<?php $_SESSION['back'] = str_replace("/public_html/", "", $_SERVER['REQUEST_URI']); ?>
</body>
</html>
