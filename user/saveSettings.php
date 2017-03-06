<h1>Settings</h1>
<br />
<?php
	if ($_POST['password'] === $_POST['password_repeat'])
	{
		$row = array(
						'nickname' => $_POST['nickname'], 
						'full_name' => $_POST['full_name'],
						'email' => $_POST['email'],
						'secret_question' => $_POST['secret_question'],
						'secret_answer' => $_POST['secret_answer'],
						'timezone' => $_POST['timezone'],
						'updated_by' => $_SESSION['uid'],
						'id' => $_SESSION['uid']
					);
		$command = $dbh -> prepare('update users set nickname = :nickname, full_name = :full_name, email = :email, secret_question = :secret_question, secret_answer = :secret_answer, updated = now(), timezone = :timezone, updated_by = :updated_by where id = :id;');
		try
		{
			$result = $command -> execute($row);
		}
		catch (PDOException $e)
		{
			echo $e -> getMessage();
		}

		$res = mysqli_query($mysql, 'select password from users where id = ' . $_SESSION['uid']);
		$row = mysqli_fetch_assoc($res);
		$message = '';
		if ($_POST['password'] !== $row['password'])
		{
			$statement = $dbh -> prepare('update users set password = md5(:password) where id = :id');
			$res = $statement -> execute(array('id' => $_SESSION['uid'], 'password' => $_POST['password']));
			if ($res)
			{ 
				$message = "Password saved. ";
			}
			else 
			{
				$message = "Whoops. We've got issue with password saving in settings. Sorry. Please, contact support.";
			}
		}

		if ($result)
		{ 
			$message .= "Settings saved. Hallelujah!";
		}
		else 
		{
			$message .= "Whoops. We've got issue with settings. Sorry. Please, contact support.";
		}
	}
	else $message = "You typed different passwords.";
?>
<p><?=$message;?></p>