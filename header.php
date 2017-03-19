<!doctype html>
<html lang="">
	<head>
		<title>PoRT - People of Red Table</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="./favicon.ico" />
		<?php
			if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
			{
		?>
		<!-- <prog-server> -->
		<script src="./jquery/jquery.min.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="./bootstrap/css/bootstrap-theme.min.css" crossorigin="anonymous">
		<script src="./bootstrap/js/bootstrap.min.js" crossorigin="anonymous"></script>
		<!-- </prog-server> -->		
		<?php
			}
			else
			{
		?>
		<!-- <for-web-server> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-91441675-3', 'auto');
		  ga('send', 'pageview');
		</script>
		<!-- </for-web-server> -->		
		<?php
			}
		?>
		<link rel="stylesheet" href="./style.css">
	</head>
	<body>
	<nav class="nav navbar-inverse" role="navigation">
			<div class="container">

				<div class="navbar-header">
					<a href="./" class="navbar-brand navbar-link" title="People of Red Table">PoRT</a>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-bar-port">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="collapse navbar-collapse" id="nav-bar-port">
					<ul class="nav navbar-nav">
						<li><a href="./?menu=forum">Forum</a></li>
						<?php 
							if ($_SESSION['uid'] >= 0)
							{ 
								echo '<li><a href="./?menu=messages_inbox">Messages ';
								$result = mysqli_query($mysql, 
									'select count(id) from messages where to_user_id = ' . $_SESSION['uid']
									.' and when_read is null');
								$message_count_row = mysqli_fetch_assoc($result);
								if ($message_count_row['count(id)'] > 0)
								{
									echo '<span class="badge">' . $message_count_row['count(id)'] . '</span>';
								}
						 		echo '</a></li>';
						 	}
						 ?>
						<!--<li><a href="#">New</a></li>
						<li><a href="#">Wiki</a></li>
						<li><a href="#">Community</a></li>
						<li><a href="#">Directorate</a></li>						
						-->
					</ul>

					<ul class="nav navbar-nav navbar-right">
					<?php
						if ($_SESSION['uid'] > -1)
						{
					?>
						<li><a href="./?menu=user_settings">Settings</a></li>
						<li><a href="./?menu=sign_out">Sign Out</a></li>
						<li><a href="./?menu=user_profile&id=<?=$_SESSION['uid'];?>"><b><?=$_SESSION['nickname'];?></b></a></li>
					<?php
						}
						else 
						{
					?>
						<li><a href="./?menu=auth_signUp">Sign Up</a></li>
						<li><a href="./?menu=auth_signIn">Sign In</a></li>
					<?php
						}
					?>
					</ul>
				</div>

			</div>
		</nav>
		<br />
		<div = class="container">
		<?php
			$array = explode(';', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			$array = explode(',', $array[0]);
			$language = strtolower($array[1]);
			$language_country = strtolower($array[0]);
			$charity_links = '<div class="row">';

			$charity_links .= '<div class="col-md-2"><a href="http://redcross.org/" target="_blank">American Red Cross</a></div>';

			foreach ($charity as $item) 
			{
				if($item['Code'] == $language_country)
				{
					if ($item['CharityType'] == 'Charity')
						$text = 'Charity for ';
					else $text = $item['CharityType'] . ' of ';
					$charity_links .= '<div class="col-md-2"><a href="' . $item['CharityLink'] . '" target="_blank">' . $text . $item['Country'] . '</a></div>';
				}
			}

			$charity_links .=  '<div class="col-md-2"><a href="http://www.evansnyc.com/charity/" target="_blank">Charity for Russia</a></div>';

			$charity_links .= '<div class="col-md-2"><a href="http://cvbsp.org.br/redcross/index.php?p=pages/home" target="_blank">Brazilian Red Cross</a></div>';

			$charity_links .= '<div class="col-md-2"><a href="http://redcross.org.uk/" target="_blank">British Red Cross</a></div>';

			$charity_links .= '<div class="col-md-2"><a href="http://icrc.org/" target="_blank">Intern. Committee of Red Cross</a></div>';

			$charity_links .= '</div>';
			
			echo $charity_links;
		?>
		</div>
		<!-- <content> -->
		<div class="container">