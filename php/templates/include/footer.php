	<footer class="main">
		<p><strong><a href="index.php"><?php echo SITE_NAME; ?></a></strong> is my dumping ground of code, projects, and resources. &copy;<em><a href="index.php?action=about">Russell Chapman</a></em> &nbsp;2013.</p>
		<?php
			if(loggedIn()) {
				include "templates/admin/loggedInControls.php";
			} else {
		?>
		<a class="adminLogin fancybox.ajax" href="templates/admin/loginForm.php">Admin Login</a>
		<?php } ?>
	</footer>
	<?php
	if(isset($_GET['error'])) {
		echo '<script>alert("' . $_GET['error'] . '");</script>';
	}
	?>
	<script type="text/javascript" src="javascript/fancyBox/source/jquery.fancybox.pack.js" defer></script>
	<script type="text/javascript" defer>
		$(document).ready(function() {
			$(".adminLogin").fancybox({
				padding : 0,
				maxWidth: 160,
				maxHeight: 130,
				autoSize: true,
				fitToView: false,
				closeClick: false,
				preload: false,
				type: 'iframe',
				openEffect: 'elastic',
				closeEffect: 'elastic'
			});
			/*
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-36647530-1']);
			_gaq.push(['_trackPageview']);
			
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
			*/
		});
	</script>
</body>
</html>