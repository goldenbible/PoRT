<h1>Sign Up</h1>
<br />
<?php
	$messages = [];
	if ($_POST['password'] === $_POST['password_repeat'])
	{
		switch ($_POST['possible_role']) 
		{
		 	case 'programming':
		 			$role_id = 3;
		 		break;
		 	/*case 'suggesting':
		 			$role_id = '(select id from roles where code = "common_community_member")';
		 		break;
		 	case 'hanging_out':
		 			$role_id = '(select id from roles where code = "common_community_member")';
		 		break;*/
		 	default:
		 			$role_id = 5;
		 		break;
		 } 
		$row = array(
						'nickname' => $_POST['nickname'], 
						'full_name' => $_POST['full_name'],
						'email' => $_POST['email'],
						'password' => md5($_POST['password']),
						'secret_question' => $_POST['secret_question'],
						'secret_answer' => $_POST['secret_answer'],
						'timezone' => $_POST['timezone'],
						'role_id' => $role_id
					);
		$command = $dbh -> prepare('insert into users (nickname, full_name, email, password, secret_question, secret_answer, role_id, inserted, timezone) 
					values (:nickname,:full_name,:email, :password,:secret_question,:secret_answer, :role_id, now(), :timezone);');
		$dbh -> beginTransaction();
		$result = $command -> execute($row);
		$dbh -> commit();

		if ($result)
		{ 
			$messages[] = ['type' => 'success', 'text' => 'You are registered user now, please <a href="./?menu=auth_signIn" class="alert-link">Sign In</a>. '];
			if ($_POST['possible_role'] === 'hanging_out')

				$messages[] = ['type' => 'warning', 'text' => 'During registration you "said" that you gonna hanging out. Please, use proper forum threads for that.'];
		}
		else $messages[] = ['type' => 'danger', 'text' => 'We\'ve got issue with registration. Sorry. Please, contact support.'];
	}
	else $messages[] = ['type' => 'danger', 'text' => 'You typed different passwords. <a href="#" onclick="window.history.go(-1)" class="alert-link">Return to the form.</a>'];

	$with_exception = FALSE;
	foreach ($messages as $item) 
	{
		if ($item['type'] === 'danger') $with_exception = true;
		echo '<p class="alert alert-' . $item['type'] . '">' . $item['text'] . '</p>';
	}

	if (!$with_exception)
			echo '<p class="alert alert-success">Hallelujah!</p>';
?>