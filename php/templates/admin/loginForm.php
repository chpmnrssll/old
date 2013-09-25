<div id="loginForm">
	<strong style="color: #954B4B">Admin Login</strong>
	<form action="..\..\admin.php?action=login" method="post" style="text-align:center;" target="_parent">
		<input type="hidden" name="login" value="true" />
		<input type="text" name="username" id="username" maxlength="20" placeholder="username" required autofocus />
		<br/>
		<input type="password" name="password" id="password" maxlength="20" placeholder="password" required />
		<br/>
		<input type="submit" name="login" value="Login" />
	</form>
</div>