<a href="javascript:void(0)" onclick="show('loginForm')">Login</a>
		<div id="bgFade" class="background" style="display:none;"></div>
		<div id="loginForm" class="login" style="display:none;">
			<a class="close" href="javascript:void(0)" onclick="hide('loginForm')">X</a>
			<strong>Admin Login</strong>
			<form action="admin.php?action=login" method="post" style="text-align:center;">
				<input type="hidden" name="login" value="true" />
				<input type="text" name="username" id="username" placeholder="username" required autofocus maxlength="20" />
				<br/>
				<input type="password" name="password" id="password" placeholder="password" required maxlength="20" />
				<br/>
				<input type="submit" name="login" value="Login" />
			</form>
		</div>
