<?php if(isset($_GET['file'])) { ?>
	<script type="text/javascript" src="javascript/syntaxhighlighter/scripts/shCore.js"></script>
	<script type="text/javascript" src="javascript/syntaxhighlighter/scripts/shBrushJScript.js"></script>
	<link href="javascript/syntaxhighlighter/styles/shCore.css" rel="stylesheet" type="text/css" />
	<link href="javascript/syntaxhighlighter/styles/shThemeDefault.css" rel="stylesheet" type="text/css" />
	<pre class="brush: js">
<?php include $_GET['file']; ?>
	</pre>
	<script type="text/javascript">SyntaxHighlighter.all()</script>
<?php } else echo 'File not found.' ?>