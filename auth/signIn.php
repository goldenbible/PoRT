<h1>Sign In</h1>
<?php
	if($_SESSION['uid'] > 1)
	{
		$message = 'What are you doing here, genius? You are already signed in... and reported.';
	}
?>
<form method="post">
	<div class="row">
		<div class="col-md-2">
			<p>E-Mail</p>
		</div>
		<div class="col-md-2">
			<input type="text" name="email">
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<p>Password</p>
		</div>
		<div class="col-md-2">
			<input type="password" name="password" maxlength="16">
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<input type="hidden" name="menu" value="auth_signingIn">
			<!-- TO DO: check email by pattern-->
			<p align="center"><input type="submit" name="submit" value="Sign In" /></p>
		</div>
	</div>

</form>