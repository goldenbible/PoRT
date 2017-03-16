<h1>User Profile</h1>
<?php
	$statement = $dbh -> prepare('select * from users where id = :id');
	$statement -> execute(array('id' => $_GET['id'] ));
	$user_row = $statement -> fetch();
?>
	<div class="row">
		<div class="col-md-2">
			<p>Nickname</p>
		</div>
		<div class="col-md-2">
			<p><?=$user_row['nickname'];?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<p>Full Name</p>
		</div>
		<div class="col-md-2">
			<p><?=$user_row['full_name'];?></p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<a href="./?menu=messages_send&id=<?=$user_row['id'];?>"><button class="btn btn-default btn-sm"><span class="glyphicon glyphicon-envelope"></span> Send a Message</button></a>
		</div>
	</div>
<?php
	$statement = $dbh -> prepare('select sn.base_url, sn.network_name, us.page_id from users_socials us join social_networks sn on us.social_network_id = sn.id where us.user_id = :user_id');
	$result = $statement -> execute(array('user_id' => $_GET['id']));
	if(!$result)
	{
		echo '<p class="alert alert-danger">We\'ve got issue with settings. Sorry. Please, contact support.</p>';
	}
	while ($row = $statement -> fetch())
	{
		echo '<br /><a href="' . $row['base_url'] . $row['page_id'] . '" target="_blank">' . $row['network_name'] . '</a>';		
	}
?>

	<!--<div class="row">
		<div class="col-md-2">
			<p>Timezone</p>
		</div>
		<div class="col-md-2">
			<p><?=$user_row['timezone'];?></p>
		</div>
	</div>-->