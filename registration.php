<h1>Sign In</h1>
<br />
<?php
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
			$message = "You are registered user now, please sign in. ";
			if ($_POST['possible_role'] === 'hanging_out')
				$message .= 'During registration you "said" that you gonna hanging out. Please, use proper forum threads for that.';
		}
		else $message = "Whoops. We've got issue. Sorry. Please, contact support.";
	}
	else $message = "You typed different passwords.";
?>
	<p><?=$message;?></p>