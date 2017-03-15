<h1>Sign In</h1>
<br />
<?php
	if($_SESSION['uid'] > 1)
	{
		$message = 'What are you doing here, genius? You are already signed in... and reported.';
	}
?>
<form method="post">
	<div class="form-group">
			<label for="signInEmail">E-Mail</label>
			<input type="text" class="form-control" name="email" id="signInEmail">
	</div>

	<div class="form-group">
			<label for="signInPassword">Password</label>
			<input type="password" class="form-control" name="password" maxlength="16" id="signInPassword">
	</div>

	<input type="hidden" name="menu" value="auth_signingIn">
	<!-- TO DO: check email by pattern-->
	<input type="submit" class="btn btn-default form-control" name="submit" value="Sign In" />

</form>