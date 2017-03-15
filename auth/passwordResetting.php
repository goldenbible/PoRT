<h1>Reset Password</h1>
<?php
	if($_POST['password'] === $_POST['password_repeat'])
	{
		$result = $statement = $dbh -> prepare('update users set password = md5(:password), verification_code = null where verification_code = :code');
		$statement -> execute(array('code' => $_POST['verification_code'], 'password' => $_POST['password']));

		if(!$result)
		{
			echo '<p class="alert alert-danger">Whoops. We\'ve got issue with password reset. Sorry. Please, contact support.</p>';
		}
		else
		{
			echo '<p class="alert alert-success">Password changed. <a class="alert-link" href="./?menu=auth_signIn">Sign In.</a></p>';
		}
	}
	else
	{
		?>
<p>You typed different passwords.</p>
<form method="post">
	<div class="form-group">
			<label for="passwordResetPasswordField">Password</label>
			<input type="password" class="form-control" name="password" maxlength="16" id="passwordResetPasswordField">
	</div>

	<div class="form-group">
			<label for="passwordResetRepeatPasswordField">Repeat Password</label>
			<input type="password" class="form-control" name="password_repeat" maxlength="16" id="passwordResetRepeatPasswordField">
	</div>

	<input type="hidden" name="verification_code" value="<?=$_REQUEST['verification_code'];?>">
	<input type="hidden" name="menu" value="auth_passwordResetting">
	<input type="submit" class="btn btn-default form-control" name="submit" value="Reset" />
</form>
		<?php
	}
?>