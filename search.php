<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=search">Search</a></h1>
<?php
	if (isset($_REQUEST['search_query']))
		$search_query = $_REQUEST['search_query'];
	else $search_query = '';

?>
<form method="post">
	<input type="hidden" name="menu" value="search" />
	<div class="input-group input-group-sm">
		<input type="text" class="form-control" name="search_query" placeholder="Search" value="<?=$search_query;?>" />
		<span class="input-group-btn"><input type="submit" class="btn btn-default" name="submit" value="Search"></span>
	</div>
</form>
<br />
<?php

	if(strlen($search_query) > 2)
	{
		$special_characters = [' ', '\'', '"', '.', ',','?', '!', '[',']','{','}','(',')','@','#','$','^','&','*','¿','¡', '-', '=', '+', '_', '/', '\\'];

		for($i = 0; $i < strlen($search_query); $i++)
		{
			if (in_array($search_query[$i], $special_characters))
				$search_query[$i] = '%';
		}
		$search_query = htmlspecialchars($search_query);
		$search_query = mysqli_real_escape_string($mysql, $search_query);

		$query = 'select ft.id, ft.title, ft.post, sf.title `subforum_title`, sf.id `subforum_id`, f.title `forum_title`, f.id `forum_id` from forum_topics ft
					join subforums sf on ft.subforum_id = sf.id
					join forums f on sf.forum_id = f.id
					where ft.title like \'%' . $search_query . '%\'
			union select ft.id, ft.title, ft.post, sf.title `subforum_title`, sf.id `subforum_id`, f.title `forum_title`, f.id `forum_id` from forum_topics ft
					join subforums sf on ft.subforum_id = sf.id
					join forums f on sf.forum_id = f.id
					where ft.post like \'%' . $search_query . '%\'
			union select ft.id, ft.title, fr.entry `post`, sf.title `subforum_title`, sf.id `subforum_id`, f.title `forum_title`, f.id `forum_id` from forum_replies fr
					join forum_topics ft on fr.topic_id = ft.id
					join subforums sf on ft.subforum_id = sf.id
					join forums f on sf.forum_id = f.id
					where fr.entry like \'%' . $search_query . '%\'
					
			';
		$search_result = mysqli_query($mysql, $query);

		if ($search_result)
		{
			if (mysqli_num_rows($search_result) > 0)
			{
				echo '<table class="table table-striped">';
				while($row = mysqli_fetch_assoc($search_result))
				{
					$first_words_of_post = prepare_post(substr($row['post'], 0, 100));
					if (strlen($row['post']) > 100) $first_words_of_post .= '...';
					echo '<tr><td>' . $row['forum_title'] . ' :: <a href="./?menu=subforum&id='.$row['subforum_id'].'">' . $row['subforum_title']. '</a> :: <a href="./?menu=forum_topic&id=' . $row['id'] . '"><b>' . $row['title'] . '</b></a><br /><br />' . $first_words_of_post . '</td></tr>';
				}
				echo '</table>';
			}
			else
			{
				$msg_type = 'info';
				$message = 'No posts found. Try to use exact pharase and avoid special characters.';
			}
		}
		else
		{
			$msg_type = 'danger';
			$message = 'We\'ve  got issue with forum search. Please, contact support.';
			echo mysqli_error($mysql);
		}
	}

	if (isset($msg_type) and isset($message))
	{
		echo '<p class="alert alert-' . $msg_type . '">' . $message . '</p>';
	}

?>