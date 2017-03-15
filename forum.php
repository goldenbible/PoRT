<h1><a href="./?menu=forum">Forum</a></h1>
<br />
<?php
	$result = mysqli_query($mysql, 'select * from forums order by sort');

	while ($forums_row = mysqli_fetch_assoc($result))
	{
		//echo '<h2>' .  . '</h2>';

		$subforums_result = mysqli_query($mysql, 'select * from subforums where forum_id = ' . $forums_row['id'] . ' order by sort');

		echo '<table class="table table-striped"><thead><tcaption><b>' . $forums_row['title'] . '</b></tcaption>' .
			'<tr><th width="80%">Title</th><th>Topics</th><th>Posts</th></tr></thead><tbody>';
		while ($subforum_row = mysqli_fetch_assoc($subforums_result)) 
		{
			$topic_count_result = mysqli_query($mysql, 'select count(id) from forum_topics where subforum_id = ' . $subforum_row['id'] . ' and deleted is null');
			$topic_count_row = mysqli_fetch_assoc($topic_count_result);

			$reply_count_result = mysqli_query($mysql, 'select count(fr.id) from forum_replies fr
							join forum_topics ft on ft.id = fr.topic_id
							where ft.subforum_id = ' . $subforum_row['id'] . ' and fr.deleted is null');
			$reply_count_row = mysqli_fetch_assoc($reply_count_result);

			echo '<tr><td><a href="./?menu=subforum&id=' . $subforum_row['id'] . '">' . $subforum_row['title'] . '</a></td><td>' . $topic_count_row['count(id)'] . '</td><td>' . $reply_count_row['count(fr.id)'] . '</td></tr>';
		}
		echo '</tbody></table><br />';
	}
?>