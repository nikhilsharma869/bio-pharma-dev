<?php


function send_interview($project_id, $receiver_id, $sender_id, $message = '') {
	global $prev;
	$datetime = date('Y-m-d H:i:s');
	$query = sprintf("INSERT INTO ".$prev."interview (project_id, receiver_id, sender_id, message, sent) VALUES ('%s', '%s', '%s', '%s', '%s')",
			$project_id,
			$receiver_id,
			$sender_id,
			mysql_real_escape_string($message),
			$datetime
		);
	$result = mysql_query($query);
}

function get_hire_job($user_id) {
	global $prev;
	$datetime = date('Y-m-d H:i:s');
	$q = "SELECT *, DATEDIFF('".$datetime."', i.sent) AS date_diff FROM ".$prev."interview AS i 
	LEFT JOIN ".$prev."projects AS p ON i.project_id=p.id
		INNER JOIN ".$prev."user AS u ON p.user_id=u.user_id
	WHERE i.status='A' AND i.receiver_id='".$user_id."'
	GROUP BY i.project_id";
	$r = mysql_query($q);
	$list = array();
	while ($val = mysql_fetch_array($r)) {
		array_push($list, $val);
	}
	return $list;
}

function get_interview_list($user_id) {
	global $prev;
	$datetime = date('Y-m-d H:i:s');
	$q = "SELECT *, DATEDIFF('".$datetime."', i.sent) AS date_diff FROM ".$prev."interview AS i 
	LEFT JOIN ".$prev."projects AS p ON i.project_id=p.id
		INNER JOIN ".$prev."user AS u ON p.user_id=u.user_id
	WHERE i.status='N' AND i.receiver_id='".$user_id."'
	GROUP BY i.project_id";
	$r = mysql_query($q);
	$list = array();
	while ($val = mysql_fetch_array($r)) {
		array_push($list, $val);
	}
	return $list;
}

function get_sent_job($user_id) {
	global $prev;
	$datetime = date('Y-m-d H:i:s');
	$q = "SELECT *, DATEDIFF('".$datetime."', b.add_date) AS date_diff FROM ".$prev."buyer_bids AS b
	LEFT JOIN ".$prev."projects AS p ON b.project_id=p.id
		INNER JOIN ".$prev."user AS u ON p.user_id=u.user_id 
	WHERE b.bidder_id='".$user_id."' AND b.chose != 'C' AND p.status='open' ORDER BY b.id DESC ";
	
	$r = mysql_query($q);
	$list = array();
	while ($val = mysql_fetch_array($r)) {
		array_push($list, $val);
	}
	return $list;
}

function get_archive_job($user_id) {
	global $prev;
	$datetime = date('Y-m-d H:i:s');
	$q = "SELECT *, DATEDIFF('".$datetime."', b.add_date) AS date_diff FROM ".$prev."buyer_bids AS b
	LEFT JOIN ".$prev."projects AS p ON b.project_id=p.id
		INNER JOIN ".$prev."user AS u ON p.user_id=u.user_id 
	WHERE b.bidder_id='".$user_id."' AND b.chose != 'C' ORDER BY b.id DESC ";
	
	$r = mysql_query($q);
	$list = array();
	while ($val = mysql_fetch_array($r)) {
		array_push($list, $val);
	}
	return $list;
}
function get_my_job($user_id, $project_type) {
	global $prev;
	$q = "";
	if($project_type!="*")
		$q = "SELECT *FROM ".$prev."projects AS p
			LEFT JOIN ".$prev."buyer_bids AS b ON p.id=b.project_id 
			LEFT JOIN ".$prev."user AS u ON p.user_id=u.user_id 
			WHERE p.chosen_id='".$user_id."' AND p.project_type= '".$project_type."'
			AND p.status= 'open'";	
	else
		$q = "SELECT *FROM ".$prev."projects AS p
			LEFT JOIN ".$prev."buyer_bids AS b ON p.id=b.project_id 
			LEFT JOIN ".$prev."user AS u ON p.user_id=u.user_id 
			WHERE p.chosen_id='".$user_id."'
			AND p.status= 'open'";	
	$r = mysql_query($q);	
	$list = array();
	while ($val = mysql_fetch_array($r)) {
		array_push($list, $val);
	}
	return $list;
}
/*page nav*/
/*function page_nav($num_row){
	global $prev; 
	$q = "SELECT *FROM ".$prev."projects AS p
			LEFT JOIN ".$prev."buyer_bids AS b ON p.id=b.project_id 
			LEFT JOIN ".$prev."user AS u ON p.user_id=u.user_id 
			WHERE p.chosen_id='". $_SESSION['user_id']."'
			AND p.status= 'open'";	
	$r = mysql_query($q);	
	$total_rows = mysql_num_rows($r);
	$total_pages = ceil($total_rows/$num_row);

	if(isset($_GET["p"]))
	{
		$p = intval($_GET["p"]);
	}
	else 
	{
		$p =1;
	}
	$pp = $p-1;
	$np = $p+1;

	$x = ($p-1) * $num_row;

	$query_page  = "SELECT *FROM ".$prev."projects AS p
			LEFT JOIN ".$prev."buyer_bids AS b ON p.id=b.project_id 
			LEFT JOIN ".$prev."user AS u ON p.user_id=u.user_id 
			WHERE p.chosen_id='". $_SESSION['user_id']."'
			AND p.status= 'open' limit'".$x."','".$num_row."'";	
	$r1 = mysql_query($query_page);	

	$list1 = array();
	while ($val1 = mysql_fetch_array($r1)) {
		array_push($list1, $val1);
	}
	return $list1;
	
}*/