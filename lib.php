<?php
	function format_date($datetime)
	{
		$date = new DateTime($datetime);
		$timezone = new DateTimezone($_SESSION['timezone']);
		$date -> setTimezone($timezone);
		return $date -> format('H:i:s d.m.Y');
	}

	function prepare_post($text)
	{
		$text = str_replace("\n", "<br />", $text);
		//$text = prepare_links($text);
		$text = replace_BBCode($text);
		return $text;
	}

	function prepare_links($text)
	{
		$offset = 0;
		while ( $pos = stripos($text, 'http', $offset) !== false) 
		{
			$link = substr($text, $pos, stripos($text, ' ', $offset));
			$replace = '<a href="' . $link . '" target="_blank">' . $link . '</a>';
			str_ireplace($link, $replace, $text);
			$offset += strlen($replace);
		}
		return $text;
	}

	/*
		User can swap tags and spoil design... Code needs changes.
	*/
	function replace_BBCode($text)
	{
		$BBCode = array(
							'~\[b\](.*?)\[/b\]~s',
							'~\[i\](.*?)\[/i\]~s',
							'~\[u\](.*?)\[/u\]~s',
							'~\[p\](.*?)\[/p\]~s',
							'~\[h2\](.*?)\[/h2\]~s',
							'~\[h3\](.*?)\[/h3\]~s',
							'~\[br\]~s',
							'~\[center\](.*?)\[/center\]~s',
							'~\[left\](.*?)\[/left\]~s',
							'~\[right\](.*?)\[/right\]~s',
							'~\[justify\](.*?)\[/justify\]~s',
							'~\[quote\](.*?)\[/quote\]~s',
							'~\[quote=(.*?)\](.*?)\[/quote\]~s',
							'~\[size=(.*?)\](.*?)\[/size\]~s',
							'~\[color=(.*?)\](.*?)\[/color\]~s',
							'~\[url\]((?:ftp|https|http?)://.*?)\[/url\]~s',
							'~\[url=((?:ftp|https|http?)://.*?)\](.*?)\[/url\]~s',
							'~\[img\]((?:https|http?)://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
						);
		$replace = array(
							'<b>$1</b>',
							'<i>$1</i>',
							'<u>$1</u>',
							'<p>$1</p>',
							'<h2>$1</h2>',
							'<h3>$1</h3>',
							'<br />',
							'<p align="center">$1</p>',
							'<p align="left">$1</p>',
							'<p align="right">$1</p>',
							'<p align="justify">$1</p>',
							'<blockquote>$1</blockquote>',
							'<blockquote>$2<footer>$1</footer></blockquote>',
							'<span style="font-size:$1em">$2</span>',
							'<span style="color:$1">$2</span>',
							'<a href="$1" target="_blank">$1</a>',
							'<a href="$1" target="_blank">$2</a>',
							'<img src="$1" />'
						);
		/*$BBCode = array(
							'' =>  array('type' => BBCODE_TYPE_ROOT, 'childs' => '!i' ),
							'i' =>  array('type' => BBCODE_TYPE_NOARG, 
											'open_tag' => '<i>',
											'close_tag' => '</i>',
										'childs' => 'b,u'),
							'url' => array('type' => BBCODE_TYPE_OPTARG, 
										'open_tag' => '<a href="{PARAM}">',
										'close_tag' => '</a>',
										'default_arg' => '{CONTENT}', 'childs' => 'b,i,u'),
							'img' => array('type' => BBCODE_TYPE_NOARG, 
											'open_tag' => '<img src="', 'close_tag' => '" />',
											'childs' => ''),
							'b' => array('type' => BBCODE_TYPE_NOARG, 'open_tag' => '<b>',
										'close_tag' => '</b>'),
							'u' => array('type' => BBCODE_TYPE_NOARG, 'open_tag' => '<u>',
										'close_tag' => '</u>')
						);*/
		/*$BBCodeHandler = bbcode_create($BBCode);
		return bbcode_parse($BBCodeHandler, $text);
						
		$pair_tags = array('b', 'i', 'u', 'p', 'h2', 'h3');

		foreach ($pair_tags as $tag) 
		{
			if (substr_count($text, '['. $tag .']') == substr_count($text, '[/' . $tag . ']'))
			{
				$text = str_ireplace('[' . $tag . ']', '<' . $tag . '>', $text);
				$text = str_ireplace('[/' . $tag . ']', '</' . $tag . '>', $text);
			}
		}
		
		$pair_tags = array('right', 'left', 'justify', 'center');

		foreach ($pair_tags as $tag) 
		{
			if (substr_count($text, '['. $tag .']') == substr_count($text, '[/' . $tag . ']'))
			{
				$text = str_ireplace('[' . $tag . ']', '<p align="' . $tag . '">', $text);
				$text = str_ireplace('[/' . $tag . ']', '</p>', $text);
			}
		}

		$tags = array('br', 'br /', 'br/');

		foreach ($tags as $tag) 
		{
				$text = str_ireplace('[' . $tag . ']', '<br />', $text);
		}*/
		return preg_replace($BBCode, $replace, $text);
	}
?>