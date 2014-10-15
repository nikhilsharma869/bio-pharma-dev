<?php
include('includes/function.php');
include('configs/path.php');
if(isset($_REQUEST['action'])) {
	eval($_REQUEST['action']());
}

function save_job() {
	global $prev;
	$user_id = $_REQUEST['user_id'];
	$project_id = $_REQUEST['project_id'];
	$datetime = date('Y-m-d H:i:s');
	$check = mysql_num_rows(mysql_query("select * from ".$prev."job_save where user_id=".$user_id." and project_id=".$project_id));
	
	if(!$check) {
		$query = sprintf("INSERT INTO ".$prev."job_save (user_id, project_id, created_time) VALUES ('%s', '%s', '%s')",
				$user_id,
				$project_id,
				$datetime
			);
		$result = mysql_query($query);
		
		if($result) {
			echo "Save job successfully!";
		} else {
			echo "Save failed!";
		}
	} else {
		echo "Job has been saved!";
	}
}

function remove_save_sme() {
	global $prev;
	$user_id = $_REQUEST['user_id'];
	$uid = $_REQUEST['uid'];
	
	$result = mysql_query("DELETE FROM ".$prev."wishlist WHERE user_id=".$user_id." AND uid=".$uid);
	if($result) {
		echo "Remove sme successfully!";
	} else {
		echo "Remove failed!";
	}
}

function add_manual_time() {
	global $prev;
	$user_id = $_REQUEST['user_id'];
	$project_id = $_REQUEST['project_id'];

	$date2add = $_REQUEST['date2add'];
	$stime2add = $_REQUEST['stime2add'];
	$etime2add = $_REQUEST['etime2add'];

	$memo2add = $_REQUEST['memo2add'];

	$start_time = date('Y-m-d H:i:s', strtotime($date2add.' '.$stime2add));
	$stop_time = date('Y-m-d H:i:s', strtotime($date2add.' '.$etime2add));
	
	if($start_time >= $stop_time) {
		$ra['error'] = "Start time should not greater or equal stop time!";
		echo json_encode($ra);
		exit();
	}

	$q_checker = sprintf("SELECT * FROM ".$prev."project_tracker WHERE worker_id='%s' AND ((start_time <= '%s' AND start_time >= '%s') OR (stop_time <= '%s' AND stop_time >= '%s'))",
		mysql_real_escape_string($user_id),
		mysql_real_escape_string($stop_time),
		mysql_real_escape_string($start_time),
		mysql_real_escape_string($stop_time),
		mysql_real_escape_string($start_time)
	);

	$row_check = mysql_num_rows(mysql_query($q_checker));

	$ra = array();
	if($row_check > 0) {
		$ra['error'] = "Exist Time! Please select other start time and end time!";
	} else {
		$q_itracker = sprintf("INSERT INTO ".$prev."project_tracker SET project_id='%s',worker_id='%s',start_time='%s',stop_time='%s',note='%s',status='1',time_added_by='M'",
			mysql_real_escape_string($project_id),
			mysql_real_escape_string($user_id),
			mysql_real_escape_string($start_time),
			mysql_real_escape_string($stop_time),
			mysql_real_escape_string($memo2add)
		);

		$r_itracker = mysql_query($q_itracker);
		$itracker_id=mysql_insert_id();
		if($itracker_id) {
			mysql_query("INSERT INTO ".$prev."project_tracker_snap SET project_tracker_id='".$itracker_id."',project_work_snap_time='".mysql_real_escape_string($start_time)."'");
			mysql_query("INSERT INTO ".$prev."project_tracker_snap SET project_tracker_id='".$itracker_id."',project_work_snap_time='".mysql_real_escape_string($stop_time)."'");
		}
		$ra['success'] = "Added successfully!";
	}

	echo json_encode($ra);
	exit();
}

function load_work_diary() {
	global $prev;
	$every_10_minutes = hoursRange( 0, 86400, 60 * 10, 'h:i a' );
	$user_id = $_REQUEST['user_id'];
	$project_id = $_REQUEST['project_id'];
	$load_date = date('Y-m-d H:i:s', strtotime($_REQUEST['load_date']));

	$q_work_diary = sprintf("SELECT * FROM ".$prev."project_tracker WHERE worker_id='%s' AND project_id='%s' AND DATEDIFF('%s', start_time)=0 AND DATEDIFF('%s', stop_time)=0",
		mysql_real_escape_string($user_id),
		mysql_real_escape_string($project_id),
		mysql_real_escape_string($load_date),
		mysql_real_escape_string($load_date)
	);

	$r_word_diary = mysql_query($q_work_diary);
	$list = array();
	while ($val = mysql_fetch_array($r_word_diary)) {
		$timesheet = array();
		$timesheet['start_time'] = date('H:i', strtotime($val['start_time']));
		$timesheet['stop_time'] = date('H:i', strtotime($val['stop_time']));
		$timesheet['memo'] = $val['note'];
		array_push($list, $timesheet);
	}
	$ul_pos = 'ul_first';
	$isul_f = false;
	$isul_l = false;
	for ($i=0; $i < count($list); $i++) { 
		foreach ($every_10_minutes as $key_time => $value_str) {
			if( date('H:i', strtotime($key_time)) >= date('H:i', strtotime($list[$i]['start_time'])) 
				&& date('H:i', strtotime($key_time)) <= date('H:i', strtotime($list[$i]['stop_time'])) ) {

				if (date('i', strtotime($key_time)) == '00' && $ul_pos = 'ul_first') {
					$isul_f = true;
				}
				else if( date('H:i', strtotime($key_time)) == date('H:i', strtotime($list[$i]['start_time'])) 
					&&  date('H', strtotime($key_time)) != date('H', strtotime($list[$i-1]['stop_time']))) {
					$isul_f = true;
				}
				else if( date('H:i', strtotime($key_time)) == date('H:i', strtotime($list[$i]['stop_time']))
						&&  date('H', strtotime($key_time)) != date('H', strtotime($list[$i+1]['start_time']))) {
					$isul_l = true;
				}
				else if (date('i', strtotime($key_time)) == '50' && $ul_pos = 'ul_last') {
					$isul_l = true;
				}
				
				if ( date('H:i', strtotime($key_time)) == date('H:i', strtotime($list[$i]['start_time'])) ) {
					$class = 'first-workdiary-snap ';
				} else if ( date('H:i', strtotime($key_time)) == date('H:i', strtotime($list[$i]['stop_time'])) ) {
					$class = 'last-workdiary-snap ';
				} else {
					$class = '';
				}
				if($isul_f) {
					$class .= 'first-li-workdiary-snap';
				}

				if(date('i', strtotime($key_time)) == '00') {
					$li_pos = 0;
				} else {
					$li_pos = (int) date('i', strtotime($key_time)) / 10;
				}

				$class .= ' workdiary-snap-item';
				$li_id = create_random_str(16);
				
				$li_data = sprintf("<span class='cwork-diary-label-memo'>%s</span><img src='images/job_work_diary/edit_bott.jpg'><input id='workdiary_snap%s' type='checkbox' class='css-input workdiary_snap_check_box' /><label for='workdiary_snap%s' class='css-label'>%s</label>", 
					$list[$i]['memo'],
					$li_id,
					$li_id,
					$value_str
				);

				$li = sprintf("<li data-workdiary-postion='%s' data-workdiary-time='%s' data-workdiary-memo='%s' class='%s'>%s</li>", 
					$li_pos,
					date('H', strtotime($key_time)), 
					$list[$i]['memo'], 
					$class, 
					$li_data
				);	

				if($isul_f) {
					echo '<ul class="workdiary-tracker-list-snap">';
					echo sprintf("<li class='snap-list-label'><h3>%s</h3><p>%s</p><input id='snap_%s' type='checkbox' data-check='%s' class='css-input snap-list-check' /><label for='snap_%s' class='css-label'></label></li>",
						date('h', strtotime($key_time)),
						date('a', strtotime($key_time)),
						date('H', strtotime($key_time)).$li_id,
						date('H', strtotime($key_time)),
						date('H', strtotime($key_time)).$li_id
					);
					echo $li;
					$ul_pos = 'ul_last';
					$isul_f = false;
					continue;
				}
				else if($isul_l) {
					echo $li;
					echo '</ul>';
					$ul_pos = 'ul_first';
					$isul_l = false;
					continue;
				}
				else {
					echo $li;
				}

			}
		}
	}
	
}

