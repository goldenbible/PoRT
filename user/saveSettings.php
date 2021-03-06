<h1>Settings</h1>
<br />
<?php
	$messages = [];

	if (isset($_REQUEST['current_password']))
	{
		$res = mysqli_query($mysql, 'select password from users where id = ' . $_SESSION['uid']);
		$row = mysqli_fetch_assoc($res);
		if (md5($_REQUEST['current_password']) === $row['password'])
		{
			if ($_POST['password'] === $_POST['password_repeat'])
			{
				$statement = $dbh -> prepare('update users set password = md5(:password) where id = :id');
				$res = $statement -> execute(array('id' => $_SESSION['uid'], 'password' => $_POST['password']));
				if ($res)
				{
					$messages[] = ['type' => 'success', 'text' => 'Password saved.'];
				}
				else 
				{
					$messages[] = ['type' => 'danger', 'text' => 'We\'ve got issue with password saving in settings. Sorry. Please, contact support.'];
				}
			}
			else $messages[] = ['type' => 'danger', 'text' => 'You typed different passwords.'];
		}
		else $messages[] = ['type' => 'danger', 'text' => 'You typed not your current password.'];
		
	}

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

	if ($result)
	{ 
		$messages[] = ['type' => 'success', 'text' => 'Settings saved.'];
	}
	else 
	{
		$messages[] = ['type' => 'danger', 'text' => 'We\'ve got issue with settings. Sorry. Please, contact support.'];
	}

	$with_exception = FALSE;
	foreach ($messages as $item) 
	{
		if ($item['type'] === 'danger') $with_exception = true;
		echo '<p class="alert alert-' . $item['type'] . '">' . $item['text'] . '</p>';		
	}

	if (!$with_exception)
			echo '<p class="alert alert-success">Hallelujah!</p>';
?>