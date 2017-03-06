<?php
	session_start();
	setcookie(session_name(), session_id());


	if(isset($_GET['menu']) && $_GET['menu'] === 'sign_out')
	{
		session_unset(session_id());
	}

	if (!isset($_SESSION['uid']))
	{
		$_SESSION['uid'] = -1;
		$_SESSION['role_id'] = 6;
		$_SESSION['timezone'] = 'America/New_York';
		$menu = 'forum';
		$_POST['menu'] = 'forum';
		$_GET['menu'] = 'forum';
		$_REQUEST['menu'] = 'forum';
		$_SESSION['topics_per_page'] = 25;
		$_SESSION['posts_per_page'] = 25;
		$_SESSION['messages_per_page'] = 25;
	}
	else
	{
		$result = mysqli_query($mysql, 'update users set last_hit = now(), remote_addr = "' . $_SERVER['REMOTE_ADDR'] . '" where id = ' . $_SESSION['uid']);
	}

	if(isset($_POST['menu']) && $_POST['menu'] === 'auth_signingIn')
	{
		$params = array('email' => $_POST['email'], 'password' => $_POST['password']);
		$statement = $dbh -> prepare('select * from users where email = :email and password = md5(:password)');
		$statement -> execute($params);
		$row = $statement -> fetch();
		if ($row['email'] === $_POST['email'])
		{
			$_SESSION['uid'] = $row['id'];
			$menu = 'forum';
			$_POST['menu'] = 'forum';
			$_GET['menu'] = 'forum';
			$_REQUEST['menu'] = 'forum';
		}
		else
		{
			$message = 'Authentification information is incorrect.';
			$reset_email = $_POST['email'];
		}
	}

	if ($_SESSION['uid'] > 0)
	{
		$statement = $dbh -> prepare('select * from users join roles on roles.id = users.role_id where users.id = :id');
		$statement -> execute(array('id' => $_SESSION['uid']));
		$row = $statement -> fetch();
		$_SESSION['nickname'] = $row['nickname'];
		$_SESSION['email'] = $row['email'];
		$_SESSION['role_id'] = $row['role_id'];
		$_SESSION['role'] = $row['name'];
		$_SESSION['timezone'] = $row['timezone'];

		$_SESSION['topics_per_page'] = (empty($row['topics_per_page'])) ? 25 : $row['topics_per_page'];
		$_SESSION['posts_per_page'] = (empty($row['posts_per_page'])) ? 25 : $row['posts_per_page'];
		$_SESSION['messages_per_page'] = (empty($row['messages_per_page'])) ? 25 : $row['messages_per_page'];
	}
	if (!isset($_REQUEST['menu']))
	{
		$menu = 'forum';
		$_POST['menu'] = 'forum';
		$_GET['menu'] = 'forum';
		$_REQUEST['menu'] = 'forum';
	}
?>