<?php
	if(isset($_GET['file'])) {
		$width = isset($_GET['width']) ? $_GET['width'] : 320;
		$height = isset($_GET['height']) ? $_GET['height'] : 240;
?>
	<script type="text/javascript" src="<?= $_GET['file'] ?>"></script>
	<canvas id="canvas" width="<?= $width ?>" height="<?= $height ?>">HTML5 Canvas not supported.</canvas>
<?php } else echo 'File not found.' ?>