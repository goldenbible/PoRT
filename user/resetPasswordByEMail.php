<h1>Reset Pasword</h1>	
<?php
	//$messages = [];
	if (!isset($_REQUEST['verification_code'])
		and isset($_REQUEST['email']))
	{
		$statement_email = $pdo -> prepare('select full_name, email from users where email = :email');
		$result_email = $statement_email -> execute(array('email' => $_REQUEST['email']));
		if (!$result_email or $statement_email -> rowCount() === 0)
		{
			$msg_type = 'danger';
			$message = 'Information for your email not found. ';
		}
		else
		{
			$user_row = $statement_email -> fetch();
			$verification_code = uniqid() . uniqid();

			$statement_code = $pdo -> prepare('update users set verification_code = :verification_code where email = :email');
			$result_code = $statement_code -> execute(array('email' => $_REQUEST['email'], 'verification_code' => $verification_code));
			if (!$result_code)
			{
				$msg_type = 'danger';
				$message = 'Verification code was not set. Please, contact support. ';
				log_msg(__FILE__ . ':' . __LINE__ . ' Verification code wasn\'t set. Info = {' . json_encode($statement_code -> errorInfo()) . '}, $_REQUEST = {' . json_encode($_REQUEST) . '}');
			}
			else
			{
				$email_text = 'Greetings, %user_name%. ' . PHP_EOL
					. 'For your account on PoRT Site http://%http_host%'
					. ' was requested resetting of password. ' . PHP_EOL
					. ' If you want to reset your password, please, click this link: ' . PHP_EOL
					. ' %http_host%?menu=user_resetPasswordByEMail' 
					. '&verification_code=%verification_code%'
					. '&email=%user_email% ' . PHP_EOL . PHP_EOL . PHP_EOL
					. 'If you did not request this operation, just ignore this letter.'
					. 'Thank you.';

				$email_text = str_ireplace('%user_name%', $user_row['full_name'], $email_text);
				$email_text = str_ireplace('%http_host%', $base_url, $email_text);
				$email_text = str_ireplace('%verification_code%', $verification_code, $email_text);
				$email_text = str_ireplace('%user_email%', $user_row['email'], $email_text);

				if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1')
				{
					$result_mail_send = mail($user_row['email'], 'PoRT - Reset Password', $email_text);

					if ($result_mail_send)
					{
						$msg_type = 'info';
						$message = str_ireplace('%user_email%', $user_row['email'], 'Email with reset link was sent to your email `user_email`. If you did not find it, please, check "Spam" folder.');
					}
					else
					{
						$msg_type = 'danger';
						$message = str_ireplace('%user_email%', $user_row['email'], 'Email to your address `%user_email%` was not sent. Please, contact support. ');
						log_msg(__FILE__ . ':' . __LINE__ . ' Reset password letter wasn\'t sent. $_REQUEST = {' . json_encode($_REQUEST) . '}');
					}
				}
				else
				{
					$msg_type = 'info';
					$message = 'Letter was not send, it is not internet web server ;]';
				}
			}
		}
	}
	
	if (isset($_REQUEST['verification_code']) and 
		(!isset($_REQUEST['password']))
		or (isset($_REQUEST['password']) and ($_REQUEST['password'] !== $_REQUEST['password_repeat'] ))
		)
	{
		$statement_check = $pdo -> prepare('select id from `users` where email = :email and verification_code = :verification_code');
		$statement_check -> execute(['email' => $_REQUEST['email'], 'verification_code' => $_REQUEST['verification_code']]);
		if  ($statement_check -> rowCount() === 0)
		{
			$msg_type = 'danger';
			$message = 'Information about your email or verification code not found. Please, contact support. ';
		}
		else
		{
?>

<form method="post">
	<div class="form-group">
			<label for="resetPasswordEMPasswordField">Password</label>
			<input type="password" class="form-control" name="password" maxlength="16" id="resetPasswordEMPasswordField">
	</div>
	<div class="form-group">
			<label for="resetPasswordEMRepeatPasswordField">Repeat Password</label>
			<input type="password" class="form-control" name="password_repeat" maxlength="16" id="resetPasswordEMRepeatPasswordField">
	</div>

	<input type="hidden" name="verification_code" value="<?=$_REQUEST['verification_code'];?>">
	<input type="hidden" name="email" value="<?=$_REQUEST['email'];?>">
	<input type="hidden" name="menu" value="user_resetPasswordByEMail">
	<input type="submit" class="btn btn-default form-control" name="submit" value="Reset" />
</form>

<?php
		}
	}
	
	elseif (isset($_REQUEST['verification_code'])
		and isset($_REQUEST['email'])
		and isset($_REQUEST['password'])
		and isset($_REQUEST['password_repeat']))
	{
		if ($_REQUEST['password'] === $_REQUEST['password_repeat'])
		{
			$statement_pswd = $pdo -> prepare(
									'update users set `password` = md5(:password), verification_code = null where (email = :email) and (verification_code = :verification_code)'
							);
			$pdo -> beginTransaction();
			$result_pswd = $statement_pswd -> execute([
							'password' => $_REQUEST['password'],
							'email' => $_REQUEST['email'],
							'verification_code' => $_REQUEST['verification_code']]);
			$pdo -> commit();
			//log_msg(__FILE__ . ':' . __LINE__ . ' Lines affected: ' . $statement_pswd -> rowCount());
			if ($result_pswd and ($statement_pswd -> rowCount() > 0))
			{
				$msg_type = 'success';
				$message =  'Password changed. <a href="./?menu=auth_signIn">Sign In</a><meta http-equiv="refresh" content="2; ./?menu=auth_signIn">';
			}
			else
			{
				$msg_type = 'danger';
				$message = 'Password was not updated. Please, contact support. ';
				log_msg(__FILE__ . ':' . __LINE__ . ' Password wasn\'t updated. $_REQUEST = {' . json_encode($_REQUEST) . '}');
			}
		}
		else 
		{
			$msg_type = 'danger';
			$message = 'You typed different passwords. ';
		}
	}

	if (isset($message) and isset($msg_type))
	{
		echo "<div class='alert alert-$msg_type'>$message</div>";
	}
?>