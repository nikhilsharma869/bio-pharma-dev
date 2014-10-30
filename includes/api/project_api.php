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
	WHERE b.bidder_id='".$user_id."' AND b.chose != 'C' AND p.status='open' GROUP BY p.id ORDER BY b.id DESC ";
	
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
	WHERE b.bidder_id='".$user_id."' AND b.chose != 'C' GROUP BY p.id ORDER BY b.id DESC ";
	
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
	if($project_type!="*"){
		$q = "SELECT * FROM ".$prev."projects AS p
					LEFT JOIN ".$prev."buyer_bids AS b ON p.id=b.project_id 
					LEFT JOIN ".$prev."user AS u ON p.user_id=u.user_id 
					WHERE p.chosen_id='".$user_id."' AND p.project_type= '".$project_type."'
					AND p.status= 'process'";	
	}		
	else{
		$q = "SELECT * FROM ".$prev."projects AS p
						LEFT JOIN ".$prev."buyer_bids AS b ON p.id=b.project_id AND p.chosen_id=b.chosen_id 
						LEFT JOIN ".$prev."user AS u ON p.user_id=u.user_id 
				WHERE p.chosen_id='".$user_id."' AND p.status= 'process'";	
	}		
			
	$q .= " GROUP BY p.id";	
	$r = mysql_query($q);	
	$list = array();
	while ($val = mysql_fetch_array($r)) {
		array_push($list, $val);
	}
	return $list;
}
function list_jobs(){
	global $prev;
	
		$q = "SELECT * FROM ".$prev."projects p
				WHERE p.chosen_id='".$_SESSION['user_id']."' AND p.status= 'process' AND p.project_type='H' ORDER BY p.id DESC";	
			
	$r = mysql_query($q);	
	$list = array();
	while ($val = mysql_fetch_array($r)) {
		array_push($list, $val);
	}
	return $list;
}


function get_project_snap($project_id, $project_tracker_id, $time, $offset) {
	global $prev;

	$q = sprintf("SELECT *,ABS(TIME_TO_SEC(TIMEDIFF('%s',CONVERT_TZ(project_work_snap_time,'+00:00','%s')))) AS time_check, CONVERT_TZ(project_work_snap_time,'+00:00','%s') AS time_a FROM ".$prev."project_tracker_snap WHERE project_tracker_id='%s'",
		mysql_real_escape_string($time),
		$offset,
		$offset,
		mysql_real_escape_string($project_tracker_id)
	);

	$data_snap = array();
	$r = mysql_query($q);
	while ($val = mysql_fetch_array($r)) { 
		if($val['time_check'] <= 300) {
			$data_snap['time'] = date('h:i a', strtotime($val['time_a']));
			$data_snap['img'] = 'time_tracker/mediafile/'.$project_id.'_'.$val['id'].'.jpg';
			return $data_snap;
		}
	}
	$data_snap['img'] = 'images/manual_time_bg.jpg';
	return $data_snap;

}

function calculate_logtime($worker_id, $project_id, $datelog){
	global $prev;	
	$load_date = date('Y-m-d H:i:s', strtotime($datelog));

	$q = sprintf("SELECT *,TIME_TO_SEC(TIMEDIFF(stop_time,start_time)) AS wt FROM ".$prev."project_tracker WHERE worker_id='%s' AND project_id='%s' AND DATEDIFF('%s', start_time)=0 AND DATEDIFF('%s', stop_time)=0 ORDER BY start_time ASC",
		mysql_real_escape_string($worker_id),
		mysql_real_escape_string($project_id),
		mysql_real_escape_string($load_date),
		mysql_real_escape_string($load_date)
	);

	$r = mysql_query($q);
	$total = array();
	$timeM = 0;
	$timeA = 0;

    while ($t = mysql_fetch_assoc($r)) {
        if($t['time_added_by'] == 'M') {
        	$timeM = $timeM + $t['wt'];
    	} else {
    		$timeA = $timeA + $t['wt'];
    	}
    }
    // $total['manual'] = gmdate("H:i", $timeM);
    // $total['auto'] = gmdate("H:i", $timeA);
    // $total['total'] = gmdate("H:i", $timeM+$timeA);
    $total = $timeM+$timeA;
    return $total;
}

function calculate_worktime_of_week($worker_id, $project_id) {
	$first_day_of_week = date('Y-m-d', strtotime('Last Monday'));
	$last_day_of_week = date('Y-m-d', strtotime('Next Sunday'));

	$total_log = array();
	$total_log['total_in_hour'] = 0;
	$total_log['total_in_sec'] = 0;
	for ($i = 0; $i <= 6; $i++) { 
		$datelog = date('Y-m-d', strtotime($first_day_of_week.' + '.$i.' days'));
		$sec_log = calculate_logtime($worker_id, $project_id, $datelog);
		$total_log['total_in_sec'] += $sec_log;
	}
	return $total_log;
}