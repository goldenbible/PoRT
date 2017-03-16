<?php
	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $_GET['id']));
	$subforum_row = $statement -> fetch();

	$statement = $dbh -> prepare('select is_read_only from forums where id = :forum_id');
	$statement -> execute(array('forum_id' => $subforum_row['forum_id']));
	$forum_row = $statement -> fetch();

	$statement = $dbh -> prepare('select role_id from users where id = :user_id');
	$statement -> execute(array('user_id' => $_SESSION['uid']));
	$user_row = $statement -> fetch();

	if (isset($_REQUEST['page']))
		$page = $_REQUEST['page'];
	else $page = 1;
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$subforum_row['id'];?>"><?=$subforum_row['title'];?></a></h1>
<form method="post">
	<input type="hidden" name="menu" value="search" />
	<div class="input-group input-group-sm">
		<input type="text" class="form-control" name="search_query" placeholder="Search" />
		<span class="input-group-btn"><input type="submit" class="btn btn-default" name="submit" value="Search"></span>
	</div>
</form>
<br />
<?php
	if ((($subforum_row['is_read_only'] != '1') and 
			($forum_row['is_read_only'] != '1') and $_SESSION['uid'] > -1)
			or ($_SESSION['role_id'] <= 2))
	{
?>
<p align="right">
<a href="./?menu=forum_createTopic&subforum_id=<?=$_GET['id'];?>"><button class="btn btn-default">Create Topic</button></a>
</p>
<?php
	}

	$page_nav = '<a href="./?menu=subforum&id=' . $_GET['id'] . '">First Page</a> ';
	$statement = $dbh -> prepare('select count(id) from forum_topics where subforum_id = :id and deleted is null');
	$statement -> execute(array('id' => $_GET['id'] ));
	$topic_count_row = $statement -> fetch();
	$topic_count = $topic_count_row['count(id)'];
	$page_count = floor($topic_count / $_SESSION['topics_per_page']);
	if( ($topic_count % $_SESSION['topics_per_page']) != 0) $page_count++;
	/*echo 'topic_count = `' . $topic_count . '`<br />' .
		'topics_per_page = `' . $_SESSION['topics_per_page'] . '`<br />' .
		'page_count = `' . $page_count . '`<br />' .
		'page = `' . $page . '` <br />';*/

	if ($page_count > 1)
	{
		for($i=($page-5); $i<($page+5); $i++)
		{
			if($i>1 and $i<$page_count)
			{
				$page_nav .= "<a href=\"./?menu=subforum&id=" . $_GET['id'] . "&page=$i\">[$i]</a> ";
			}
		}
		$page_nav .= '<a href="./?menu=subforum&id=' . $_GET['id'] . '&page=' . $page_count . '">Last Page</a> ';
	}
	else $page_nav = '';
	echo $page_nav;
?>
<table class="table table-striped"><thead><tr><th width="90%">Title</th><th>Posts</th></tr></thead><tbody>
<?php

	// todo: order by last reply or inserted + union for pinned topics
	$statement = $dbh -> prepare('select * from forum_topics where subforum_id = :id and deleted is null order by pinned desc, inserted desc limit ' . (($page - 1)* $_SESSION['topics_per_page'] ) . ', ' . $_SESSION['topics_per_page'] );
	$statement -> execute(array('id' => $_GET['id']));

	while($row = $statement -> fetch())
	{
		$reply_count_result = mysqli_query($mysql, 'select count(id) from forum_replies
						where topic_id = ' . $row['id'] . ' and deleted is null');
		$reply_count_row = mysqli_fetch_assoc($reply_count_result);
		$pinned = '';
		if (!empty($row['pinned']))
			$pinned= '<span class="glyphicon glyphicon-flag" aria-hidden="true"></span> ';

		echo '<tr><td>' . $pinned . '<a href="./?menu=forum_topic&id=' . $row['id'] . '" title="' . substr($row['post'], 0, 100) . '">' . $row['title'] . '</td><td>' . $reply_count_row['count(id)'] . '</td></tr>';
	}
?></tbody>
</table>
<?=$page_nav;?>
<br />
<br />
<h3><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$subforum_row['id'];?>"><?=$subforum_row['title'];?></a></h3>