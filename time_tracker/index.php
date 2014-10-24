<?php

include("load.php");
/* while($i<5000000){
  $i=$i+1;
  } */

$DB = rqDB();
$R_Q = $_REQUEST;
$ACT = isset($R_Q['action']) ? $R_Q['action'] : "";

//========Start appsetting  ========//
if ($ACT == "appsetting") {
    //Output                
    $XML = '<?xml version="1.0" encoding="utf-16"?>
                        <List>
                         <appsetting>
                                <forgot>http://www.bio-pharma.com/login.html</forgot>
                                <about>http://www.bio-pharma.com/information/22/About-us</about>
                                <newaccount>http://www.bio-pharma.com/singup.html</newaccount>
                                <help>http://www.bio-pharma.com/information/54/Help</help>
                         </appsetting>
                        </List>';
    echo $XML;
    die();
}

//========End appsetting ========//
function getEmployerName($id) {
    $r = mysql_fetch_assoc(mysql_query("select username,fname,lname from serv_user where user_id='" . $id . "'"));
    $name = ucfirst($r['fname']) . " " . ucfirst($r['lname']);
    if (trim($name) == '') {
        $name = $r['username'];
    }
    return $name;
}

function getProjectID($id) {
    $r = mysql_fetch_assoc(mysql_query("select project_id from serv_project_tracker where id=(select project_tracker_id from serv_project_tracker_snap where id=" . $id . ")"));
    return $r['project_id'];
}

$pid = $R_Q['pid'];


//========Start User Login ========//
if ($ACT == "login") {
    $user = isset($R_Q['user']) ? $R_Q['user'] : "";
    $password = isset($R_Q['password']) ? md5($R_Q['password']) : "";
    $sql = "SELECT * FROM  serv_user WHERE  `username` ='$user' AND  `password` = '$password' and status='Y' and v_stat='Y' ";
    $REC = $DB->select($sql);
    if (isset($REC[0][0])) {
        $REC = $REC[0];
        //Output		
        $XML = '<?xml version="1.0" encoding="utf-16"?>
			<List>
			 <userinfo>
				<user_id>' . $REC['user_id'] . '</user_id>
				<user>' . $REC['fname'] . '</user>
				<username>' . $REC['username'] . '</username>
				<eamil>' . $REC['email'] . '</eamil>
                                <report>http://bio-pharma.com/timetrackerchecklogin/'.md5($REC['user_id']).'/'.md5($REC['username']).'/'.md5($REC['email']).'/working_jobs.html</report>
                                <profile>http://bio-pharma.com/timetrackerchecklogin/'.md5($REC['user_id']).'/'.md5($REC['username']).'/'.md5($REC['email']).'/dashboard.html</profile>
			 </userinfo>
			</List>';
        echo $XML;
    }
    die();
}
//========End  User Login ========//
//========Start Project List ========//
if ($ACT == "project") {
    $user_id = isset($R_Q['uid']) ? $R_Q['uid'] : "";
    if ($user_id != "") {
        $sql = "SELECT * FROM  serv_projects WHERE `chosen_id`='$user_id' and `status`='process' and project_type='H' ";
        $REC = $DB->select($sql);
        //$REC=mysql_fetch_assoc(mysql_query($sql));
        //OutPut
        $XML = '<?xml version="1.0" encoding="utf-16"?>';
        $XML.='<List>';
        if (isset($REC[0][0])) {
            foreach ($REC as $R) {
                $details = '';
                $sql1 = "SELECT * FROM  serv_buyer_bids WHERE `bidder_id`='" . $user_id . "' and `project_id`='" . $R['id'] . "'";
                $RECC = $DB->select($sql1);
                foreach ($RECC as $RR){
                    $details="Start Date: ".date('F d, Y', strtotime($R['startdate']))."\n";
                    $details.="Duration: ".$RR['duration']." days\n";
                    $details.="Rate: ".$RR['bid_amount']." per hr\n";
                }
                $XML.=
                        '<projectinfo>
					<project_id>' . $R['id'] . '</project_id>
					<project_title>' . $R['project'] . '</project_title>
					<project_by>' . "Employer: " . getEmployerName($R['user_id']) . '</project_by>
                                       <project_desc>' . $details . '</project_desc>
					<project_capt>10</project_capt>
					<project_caph>900</project_caph>
					<project_capw>1024</project_capw>
				</projectinfo>';
            }
        } else {
            $XML.=
                    '<projectinfo>
					<project_id>0</project_id>
					<project_title>0</project_title>
					<project_by>0</project_by>
                                        <project_desc>0</project_desc>
					<project_capt>0</project_capt>
					<project_caph>0</project_caph>
					<project_capw>0</project_capw>
				</projectinfo>';
        }

        $XML.='</List>';
        echo $XML;
    }
    die();
}
//========End Project List ========//
//========Start ProjectWork ========//
if ($ACT == "prowork") {
    $user_id = isset($R_Q['uid']) ? $R_Q['uid'] : "";
    $project_id = isset($R_Q['pid']) ? $R_Q['pid'] : "";
    $type = isset($R_Q['type']) ? $R_Q['type'] : "H";
    $note = isset($R_Q['note']) ? $R_Q['note'] : "";
    if ($user_id != "" && $project_id != "" && $type != "") {
        if ($type != "0") {
            $pwid = isset($R_Q['pwid']) ? $R_Q['pwid'] : "";
            $backnote = isset($R_Q['backnote']) ? $R_Q['backnote'] : "";
            if ($pwid != "") {
                $str_time = mysql_fetch_assoc(mysql_query("select start_time from serv_project_tracker where project_id='" . $R_Q['pid'] . "' order by start_time desc limit 1"));
                $sql = "UPDATE serv_project_tracker` SET  `stop_time`=NOW(), `note`='" . $backnote . "' WHERE `project_id` ='" . $R_Q['pid'] . "' and start_time='" . $str_time['start_time'] . "' ";
                run_quary($sql);
            }
        }

        $sql = "INSERT INTO serv_project_tracker (`project_id`, `worker_id`, `start_time`, `note`, `work_type`) VALUES ('$project_id', '$user_id', NOW(), '$note', '$type');";
        run_quary($sql);
        $idd = mysql_insert_id();
        if ($idd != "") {
            $XML = '';
            $XML.=
                    '<?xml version="1.0" encoding="utf-16"?>
				<List>
					<projectwork>
						<projectwork_id>' . $idd . '</projectwork_id>
					</projectwork>
				</List>';
        }
        echo $XML;
    }
    die();
}

if ($ACT == "proworkstop") {
    $note = isset($R_Q['note']) ? $R_Q['note'] : "";
    $projectwork_id = isset($R_Q['pwid']) ? $R_Q['pwid'] : "";
    if ($projectwork_id != "") {
        $esq = "";
        if ($note != "") {
            $esq = ",`note`='$note' ";
        }
        /* 		$sql2="select start_time from jobstask_project_tracker where id='$projectwork_id' order by start_time desc limit 1";

          $REC2=$DB->select($sql2);
          foreach($REC2 as $r2){
          $str_time=$r2['start_time'];
          }
         */
        //$sql="UPDATE jobstask_project_tracker SET  `stop_time`='".NOW()."'".$esq." WHERE `project_id` ='".getProjectID($projectwork_id)."' and start_time='".$str_time."'";

        $sql = "UPDATE serv_project_tracker SET  `stop_time`=NOW() $esq WHERE `id` ='$projectwork_id'";

        run_quary($sql);

        $XML = '';
        $XML.=
                '<?xml version="1.0" encoding="utf-16"?>
				<List>
				<projectwork>
					<projectwork_id>' . $project_id . '</projectwork_id>
				</projectwork>
				</List>';
        echo $XML;
    }
    die();
}


if ($ACT == "uploadSnap") {
    $pic_data = isset($R_Q['pic_data']) ? $R_Q['pic_data'] : "";
    $projectwork_id = isset($R_Q['pwid']) ? $R_Q['pwid'] : "";
    if ($projectwork_id != "") {
        $rcheck = mysql_fetch_array(mysql_query("SELECT *,TIME_TO_SEC(TIMEDIFF(NOW(),stop_time)) AS wt FROM serv_project_tracker WHERE id=".$projectwork_id));
        // mysql_query("INSERT INTO table_debug (text_debug) VALUES ('".$rcheck['wt']."')");
        if($rcheck['wt'] >= 600 || !$rcheck['wt']) {
            $pj_id = getProjectID($projectwork_id);
            $sql = "UPDATE `serv_project_tracker` SET  `stop_time`=NOW() WHERE `project_id` ='".$pj_id."'";
            run_quary($sql);
            mysql_query("INSERT INTO table_debug (text_debug) VALUES ('projectword_id: ".$projectwork_id."')");
            mysql_query("INSERT INTO table_debug (text_debug) VALUES ('".$pj_id."')");
            mysql_query("INSERT INTO table_debug (text_debug) VALUES ('var dump: ".var_dump($rcheck['wt'] == NULL)."')");
            // mysql_query("INSERT INTO table_debug (text_debug) VALUES ('".$rcheck['wt']."')");
            // mysql_query("INSERT INTO table_debug (text_debug) VALUES ('".mysql_real_escape_string($sql)."')");
            // $sql = "INSERT INTO `serv_project_tracker_snap` (`project_tracker_id`, `project_work_snap_time`) VALUES ('$projectwork_id', NOW());";
            // run_quary($sql);
            // $idd = mysql_insert_id();
            // $output_file = "";

            // $pro_id = getProjectID($idd);

            // $output_file = MEDPATH . $pro_id . "_" . $idd . ".jpg";
            // $data = $pic_data;
            // $data = explode(",", $data);
            // $string = implode(array_map("chr", $data));
            // $ifp = fopen($output_file, "wb");
            // fwrite($ifp, $string);
            // fclose($ifp);
            // echo $idd;
        }
    }

    die();
}

//========End ProjectWork ========//
?>