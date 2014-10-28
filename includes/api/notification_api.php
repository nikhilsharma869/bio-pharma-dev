<?php

function add_notification($user_id, $message, $type, $link = '') {
	global $prev;
	$query = sprintf("INSERT INTO ".$prev."notification (user_id, message, link, add_date, type) VALUES ('%s', '%s', '%s', '%s', '%s')",
		$user_id,
		mysql_real_escape_string($message),
		mysql_real_escape_string($link),
		date('Y-m-d'),
		$type
	);

	$result = mysql_query($query);

	return $result;
}

function load_notification_ajax() {
	global $prev;
	$user_id = $_REQUEST['user_id'];
	$type = $_REQUEST['type'];

	$r = mysql_query("SELECT * FROM ".$prev."notification WHERE user_id=".$user_id." AND (type ='".$type."' OR type='B' ) ORDER BY add_date DESC");
	if(mysql_num_rows($r) == 0) {
		echo "<li>No notification now.</li>";
		exit();
	}
	$list = '';
	$count = 0;
	while ($val = mysql_fetch_array($r)) {
		if($count == 5) {
			$li = '<li id="view-more-notif"><a href="javacript:;" onclick="readAllNotif()">View All Notification</a></li>';
			$list .= $li;
			break;
		}
		if(!$val['readyet']) {
			$readyet = 'notif-notread';
		} else {
			$readyet = ''; 
		}
		$li = sprintf('<li class="notif_%s %s"><a onclick="readNotif(\'%s\',\'%s\')" class="read-notif" href="javacript:;">%s</a><span class="notif-remove" onclick="removeNotif(\'%s\')" data-notif-remove="%s"><i class="fa fa-times"></i></span></li>',
			$val['id'],
			$readyet,
			$val['id'],
			$val['link'],
			$val['message'],
			$val['id'],
			$val['id']
		);
		$list .= $li;
		$count++;
	}

	echo $list;
	exit();
}

function read_notification_ajax() {
	global $prev;
	$id = $_REQUEST['id'];
	$r = mysql_query("UPDATE ".$prev."notification SET readyet='1' WHERE id=".$id);
}

function count_notification_ajax() {
	global $prev;
	$user_id = $_REQUEST['user_id'];
	$type = $_REQUEST['type'];
	$r = mysql_query("SELECT * FROM ".$prev."notification WHERE user_id=".$user_id." AND (type ='".$type."' OR type='B' ) AND readyet=0");
	if(mysql_num_rows($r) > 0) {
		echo mysql_num_rows($r);
	}
}

function read_all_notification_ajax() {
	global $prev;
	$type = $_REQUEST['type'];
	$r = mysql_query("UPDATE ".$prev."notification SET readyet='1' WHERE (type ='".$type."' OR type='B' )");
}

function remove_notification_ajax() {
	global $prev;
	$id = $_REQUEST['id'];
	$r = mysql_query("DELETE FROM ".$prev."notification WHERE id=".$id);
}