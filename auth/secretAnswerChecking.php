<h1>Reset Password</h1>
<form method="post">
<?php
	$statement = $dbh -> prepare('select secret_answer from users where email = :email');
	$statement -> execute(array('email' => $_POST['reset_email']));
	if ($row = $statement -> fetch())
	{
		if ($_POST['secret_answer'] === $row['secret_answer'])
		{
			$verification_code = uniqid() . uniqid();
			$statement = $dbh -> prepare('update users set verification_code = :code where email = :email');
			$result = $statement -> execute(array('code' => $verification_code, 'email' => $_POST['reset_email']));
			
		if(!$result)
		{
			echo '<p class="alert alert-danger">We\'ve got issue with password reset. Sorry. Please, contact support.</p>';
		}
	?>

	<div class="form-group">
			<label for="resetPasswordPasswordField">Password</label>
			<input type="password" class="form-control" name="password" maxlength="16" id="resetPasswordPasswordField">
	</div>

	<div class="form-group">
			<label for="resetPasswordRepeatPasswordField">Repeat Password</label>
			<input type="password" class="form-control" name="password_repeat" maxlength="16" id="resetPasswordRepeatPasswordField">
	</div>

	<input type="hidden" name="verification_code" value="<?=$verification_code;?>">
	<input type="hidden" name="menu" value="auth_passwordResetting">
	<input type="submit" class="btn btn-default form-control" name="submit" value="Reset" />

	<?php	
		}
		else
		{
			echo '<p class="alert alert-danger">Secret answer is incorrect.</p>';
		}
	}
	else
	{
		echo '<p class="alert alert-danger">Information for your email not found.</p>';
	}	
?>
</form>