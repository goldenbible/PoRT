<h1>Reset Password</h1>
<br />
	<?php
		$statement = $dbh -> prepare('select secret_question from users where email = :email');
		$statement -> execute(array('email' => $_GET['reset_email']));
		if ($row = $statement -> fetch())
		{
			echo '<form method="post">
				<div class="form-group"><label for="resetPasswordSecretQuestion">Secret Question</label>' . '<p class="form-control" id="resetPasswordSecretQuestion">' . $row['secret_question'] . '</p></div>
			';
		?>

			<div class="form-group">
					<label for="resetPasswordSecretAnswer">Secret Answer</label>
					<input type="text" class="form-control" name="secret_answer" id="resetPasswordSecretAnswer">
			</div>

			<input type="hidden" name="reset_email" value="<?=$_REQUEST['reset_email'];?>">
			<input type="hidden" name="menu" value="auth_secretAnswerChecking">
			<!-- TO DO: check email by pattern-->
			<input type="submit" class="btn btn-default form-control" name="submit" value="Reset" />				
		</form>
		<?php

		}
		else
		{
			echo '<p class="alert alert-danger">Information for your email not found.</p>';
		}
	?>