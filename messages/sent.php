<?php
	if (isset($_REQUEST['page']))
		$page = $_REQUEST['page'];
	else $page = 1;
?>
<h1><a href="./?menu=messages_inbox">Messages</a> :: <a href="./?menu=messages_sent">Sent</a></h1><br />

<div class="row">
	<div class="col-md-6">
		<p><a class="messages-link" href="./?menu=messages_inbox">[Inbox]</a> <a class="messages-link" href="./?menu=messages_sent">[Sent]</a></p>
	</div>
</div>
<?php
	$statement = $dbh -> prepare('select msg.id, msg.from_user_id, msg.to_user_id, msg.subject, msg.message, u.nickname, msg.when_read,msg.inserted, msg.from_deleted from messages msg
									join users u on msg.to_user_id = u.id
									where msg.from_user_id = :id and msg.from_deleted is null order by msg.inserted desc limit ' . (($page - 1)* $_SESSION['messages_per_page'] ) . ', ' . $_SESSION['messages_per_page']);
	$result = $statement -> execute(array('id' => $_SESSION['uid']));
	if(!$result)
	{
		echo "<p>Whoops! We've got issue with messages.</p>";
		print_r($statement -> errorInfo());
	}
	elseif($statement -> rowCount() > 0)
	{
		$page_nav = '<a href="./?menu=messages_sent">First Page</a> ';
		$count_statement = $dbh -> prepare('select count(id) from messages where from_user_id = :id and from_deleted is null');
		$count_statement -> execute(array('id' => $_SESSION['uid'] ));
		$message_count_row = $count_statement -> fetch();
		$message_count = $message_count_row['count(id)'];
		$page_count = floor($message_count / $_SESSION['messages_per_page']);
		if( ($message_count % $_SESSION['messages_per_page']) != 0) $page_count++;
		/*echo 'rowCount = ' . $statement -> rowCount() . '<br />' . 
			'message_count = `' . $message_count . '`<br />' .
			'messages_per_page = `' . $_SESSION['messages_per_page'] . '`<br />' .
			'page_count = `' . $page_count . '`<br />' .
			'page = `' . $page . '` <br />';*/

		if ($page_count > 1)
		{
			for($i=($page-5); $i<($page+5); $i++)
			{
				if($i>1 and $i<$page_count)
				{
					$page_nav .= "<a href=\"./?menu=messages_sent&page=$i\">[$i]</a> ";
				}
			}
			$page_nav .= '<a href="./?menu=messages_sent&page=' . $page_count . '">Last Page</a> ';
		}
		else $page_nav = '';
		echo $page_nav;

		echo '<form method="post" name="messagesForm" action="./?menu=messages_deleteSent"><table class="table table-striped"><thead><tr><th></th><th>Subject</th><th>From</th><th>Sent</th></tr></thead><tbody>';
		while ($message_row = $statement -> fetch()) 
		{
			echo "<tr><td><input type='checkbox' name='messages[]' value='" . $message_row['id'] . "'></td><td>";
			if (empty($message_row['when_read']))
				echo '<b>';
			echo "<a href='./?menu=messages_readOut&id=" . $message_row['id'] . "'>" . $message_row['subject'] . "</a>";
			if (empty($message_row['when_read']))
				echo '</b>';
			echo "</td><td><a href='./?menu=user_profile&id=" . $message_row['to_user_id'] . "'>" . $message_row['nickname'] . "</a></td><td>" . format_date($message_row['inserted']) . "</td></tr>";
		}
		echo "</tbody></table>" . $page_nav;
		?>
<div class="row">
	<div class="col-md-6">
		<input type="hidden" id="menu" name="menu" value="messages_deleteSent" />
		<p><input type="submit" class="btn btn-danger btn-sm" name="submit" value="Delete" title="It won't delete the message[s] from recepient's inbox" onclick="document.messagesForm.submit();" /></p>
	</div>
</div>
</form>		
		<?php
	}
	else 
	{
		echo '<p class="alert alert-info">No messages</p>';
	}
?>
