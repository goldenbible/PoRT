<?php

	if (isset($_REQUEST['page']))
		$page = $_REQUEST['page'];
	else $page = 1;

	$statement = $dbh -> prepare('select * from forum_topics where id = :id');
	$statement -> execute(array('id' => $_GET['id']));
	$row = $statement -> fetch();

	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $row['subforum_id']));
	$subrow = $statement -> fetch();
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$subrow['id'];?>"><?=$subrow['title'];?></a> :: <a href="./?menu=forum_topic&id=<?=$row['id'];?>"><?=$row['title'];?></a></h1>
<br />

<?php
	if ($_SESSION['role_id'] < 3)
	{
		echo '<p align="right">';
		if(empty($row['pinned']))
			echo '<a href="./?menu=forum_pinTopic&id=' . $row['id'] . '"><button class="small">Pin the Topic</button></a>';
		else
			echo '<a href="./?menu=forum_unpinTopic&id=' . $row['id'] . '"><button class="small">Unpin the Topic</button></a>';
		echo '</p>';
	}

?>

<table class="table table-striped">
<?php

	$statement = $dbh -> prepare('select * from users where id = :id');
	$statement -> execute(array('id' => $_SESSION['uid']));
	$current_user_row = $statement -> fetch();

	$statement = $dbh -> prepare('select * from users join roles on roles.id = users.role_id where users.id = :id');
	$statement -> execute(array('id' => $row['user_id']));
	$user_row = $statement -> fetch();

	echo "<tr><td><a href='./?menu=user_profile&id=" . $row['user_id'] . "' target='_blank'><b>" . $user_row['nickname'] . "</b></a><br /><small>" . $user_row['name'] . "</small></td><td>" . prepare_post($row['post']) . "</td></tr>" .
		"<tr><td>" . format_date($row['inserted']) . "</td><td align='right'>";
		if ( ($row['user_id'] == $_SESSION['uid'])
			or ($current_user_row['role_id'] < 3))
		echo '<a href="./?menu=forum_topicEdit&id=' . $row['id'] . '"><button class="small">Edit</button></a><a href="./?menu=forum_topicDelete&id=' . $row['id'] . '"><button class="small">Delete</button></a><a href="./?menu=forum_closeTopic&id=' . $row['id'] . '"><button class="small">Close</button></a>';
		echo "</td></tr>";

	echo '</table>';

	$page_nav = '<a href="./?menu=forum_topic&id=' . $_GET['id'] . '">First Page</a> ';
	$statement = $dbh -> prepare('select count(id) from forum_replies where topic_id = :id and deleted is null');
	$statement -> execute(array('id' => $_GET['id'] ));
	$post_count_row = $statement -> fetch();
	$post_count = $post_count_row['count(id)'];
	$page_count = floor($post_count / $_SESSION['posts_per_page']);
	//echo 'page count without last posts = ' . $page_count . '<br />';
	if( ($post_count % $_SESSION['posts_per_page']) != 0) $page_count++;
	/*echo 'post_count = `' . $post_count . '`<br />' .
		'posts_per_page = `' . $_SESSION['posts_per_page'] . '`<br />' .
		'page_count = `' . $page_count . '`<br />' .
		'page = `' . $page . '` <br />';*/

	if ($page_count > 1)
	{
		for($i=($page-5); $i<($page+5); $i++)
		{
			if($i>1 and $i<$page_count)
			{
				$page_nav .= "<a href=\"./?menu=forum_topic&id=" . $_GET['id'] . "&page=$i\">[$i]</a> ";
			}
		}
		$page_nav .= '<a href="./?menu=forum_topic&id=' . $_GET['id'] . '&page=' . $page_count . '">Last Page</a> ';
	}
	else $page_nav = '';
	echo $page_nav . '<br /><br />';

	echo '<table class="table table-striped">';

	$statement = $dbh -> prepare('select fr.user_id, roles.name, fr.inserted, fr.id, fr.entry, users.nickname from forum_replies fr join users on fr.user_id = users.id join roles on users.role_id = roles.id where fr.topic_id = :topic_id and fr.deleted is null order by inserted asc limit ' . (($page - 1)* $_SESSION['posts_per_page'] ) . ', ' . $_SESSION['posts_per_page']);
	/*$query = '';
	if($page === 1)
		$query = 'select ft.id, ft.user_id, ut.nickname, rt.name, ft.post, ft.inserted from forum_topics ft
		join users ut on ut.id = ft.user_id
		join roles rt on rt.id = ut.role_id
		where ft.id = :topic_id
		union all ';
	$statement = $dbh -> prepare($query . 'select fr.id, fr.user_id, ur.nickname, rr.name, fr.entry `post`, fr.inserted from forum_replies fr
		join users ur on ur.id = fr.user_id	
		join roles rr on rr.id = ur.role_id
		where fr.topic_id = :topic_id
		order by inserted
		limit ' . (($page - 1)* $_SESSION['posts_per_page'] ) . ', ' . $_SESSION['posts_per_page']);*/

	$statement -> execute(array('topic_id' => $_GET['id']));
	//print_r($statement -> errorInfo());
	//echo 'rowCount = ' . $statement -> rowCount() . '<br />';
	while($reply_row = $statement -> fetch())
	{
		echo "<tr><td><a href='./?menu=user_profile&id=" . $reply_row['user_id'] . "' target='_blank'><b>" . $reply_row['nickname'] . "</b></a><br /><small>" . $reply_row['name'] . "</small></td><td>" . prepare_post($reply_row['entry']) . "</td></tr>" .
		"<tr><td>" . format_date($reply_row['inserted']) . "</td><td align='right'>";
		if ( ($reply_row['user_id'] == $_SESSION['uid'])
			or ($current_user_row['role_id'] < 3))
		echo '<a href="./?menu=forum_replyEdit&id=' . $reply_row['id'] . '"><button class="small">Edit</button></a><a href="./?menu=forum_replyDelete&id=' . $reply_row['id'] . '"><button class="small">Delete</button></a>';
		echo "</td></tr>";
		;
	}

?>
</table>
<?php
	echo $page_nav;
	$statement = $dbh -> prepare('select is_read_only from forums where id = :forum_id');
	$statement -> execute(array('forum_id' => $subrow['forum_id']));
	$forum_row = $statement -> fetch();

	$statement = $dbh -> prepare('select role_id from users where id = :user_id');
	$statement -> execute(array('user_id' => $_SESSION['uid']));
	$user_row = $statement -> fetch();


	if (

		((($subrow['is_read_only'] != '1') and 
			($forum_row['is_read_only'] != '1'))
			or ($user_row['role_id'] <= 2))
		and empty($row['closed'])

		)


	{
	?><br />
<h3>Reply</h3><hr /><br />

		<form method="post">
			<div class="row">
				<div class="col-md-2">
					<p>Post</p>
				</div>
				<div class="col-md-2">
					<textarea name="entry" maxlength="5000" cols="80" rows="10"></textarea>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<input type="hidden" name="menu" value="forum_replying">
					<input type="hidden" name="page" value="<?=$page;?>">
					<input type="hidden" name="topic_id" value="<?=$_GET['id']?>">
					<p align="center"><input type="submit" name="submit" value="Reply" /></p>
				</div>
			</div>
		</form>	
		<!--<div class="row">
			<div class="col-md-12">
				<p align="center"><a href="./?menu=forum_reply&topic_id=<?=$_GET['id'];?>"><button>Reply</button></a></p>
			</div>
		</div>-->
	<?php
	}
	if (!empty($row['closed']))
	{
		echo '<p align="center">Topic is closed.</p>';
		if ($user_row['role_id'] <= 2)
		{
			echo '<p align="center"><a href="./?menu=forum_openTopic&id=' . $row['id'] . '"><button>Open Topic</button></a></p>';
		}
	}
	?>
<h3><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$subrow['id'];?>"><?=$subrow['title'];?></a> :: <a href="./?menu=forum_topic&id=<?=$row['id'];?>"><?=$row['title'];?></a></h3>
<br />