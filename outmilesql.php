<?php

session_start();
include "configs/config.php";
include "configs/path.php";
include("includes/function.php");
CheckLogin();
ob_start();
?>
<?php

if ($_POST['action_select'] != 'select') {
    if ($_POST['action_select'] == 'release') {
        $rw1 = mysql_query("select * from " . $prev . "escrow where escrow_id = '" . $_POST['hides'] . "' and status = 'P'");
        if (mysql_num_rows($rw1) > 0) {
            $rw3 = mysql_fetch_array($rw1);
            $rw2 = mysql_query("update " . $prev . "escrow set status = 'Y' ,released_by ='employer' where escrow_id = '" . $_POST['hides'] . "'");
            if ($rw2) {
                $payment_id = rand(1000, 9999) . time();
                $rw4 = mysql_query("insert into " . $prev . "transactions set 
				details = 'Milestone Payment Transfer',
				user_id = '" . $rw3['bidder_id'] . "',
				balance = '" . $rw3['user_amount'] . "',
				add_date = now(),
				date2 = '" . time() . "',
				paypaltran_id = '" . $payment_id . "',
				status = 'Y',amttype = 'CR'");

                if ($rw4) {

                    $res2 = mysql_fetch_array(mysql_query("select emp_charge,project_id from " . $prev . "buyer_bids where id='" . $rw3['bidid'] . "'"));
                    $rw5 = mysql_fetch_array(mysql_query("select sum(amount) as escrow_amount from " . $prev . "escrow where bidid = '" . $rw3['bidid'] . "' and status = 'Y'"));
                    $bid_amount = floatval($res2['emp_charge']);
                    if ($rw5['escrow_amount'] >= $bid_amount) {
                        if (getprojecttype($res2['project_id']) == "F") {
                            mysql_query("update " . $prev . "projects set status='complete' where id='" . $res2['project_id'] . "'");
                        }
                    }
     //                mysql_query("insert into " . $prev . "notification set 
					// user_id = '" . $rw3['bidder_id'] . "',
					// message = 'Milestone payment deposited in your account',
					// date = now()");
                    $link = $vpath.'milestone.html';
					$notify = add_notification($rw3['bidder_id'], 'Milestone payment deposited in your account', 'W', $link);

     //                mysql_query("insert into " . $prev . "notification set 
					// user_id = '" . $rw3['user_id'] . "',
					// message = 'Milestone payment released to contractor',
					// date = now()");
					$link = $vpath.'milestone.html';
					$notify = add_notification($rw3['user_id'], 'Milestone payment released to contractor', 'E', $link);

                    $rw5 = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id ='" . $rw3['bidder_id'] . "'"));
                    $rw6 = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = '" . $rw3['user_id'] . "'"));
                    $rw7 = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id = '" . $_POST['hidep'] . "'"));

                    $rec = mysql_query("select * from " . $prev . "buyer_bids where id = '" . $rw3['bidid'] . "'");
                    $rec1 = mysql_fetch_array($rec);
                    $total = $rec1['paid_amount'] + $rw3['amount'];

                    mysql_query("update " . $prev . "buyer_bids set paid_amount = '" . $total . "' where id = '" . $rw3['bidid'] . "'");

                    if ($total >= $rec1['bid_amount']) {
                        if (getprojecttype($rec1['project_id']) == "F") {
                            mysql_query("update " . $prev . "projects set status = 'complete' where id = '" . $rec1['project_id'] . "'");
                        }
                    }

                   
				$to=$rw5['email'];
				$to1=$rw6[email];

			
			$from = $setting['admin_mail'];
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_release_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
			if (mysql_num_rows($mailqf) == 0) {
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_release_for_freelancer' AND `langid`='en'");
			}

			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_release_for_employe' AND `langid`='" . getUserLastLang($rw7['user_id']) . "'");
			if (mysql_num_rows($mailqe) == 0) {
			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_release_for_employe' AND `langid`='en'");
			}

			$mailrf = mysql_fetch_assoc($mailqf);
			$mailre = mysql_fetch_assoc($mailqe);

			$mailbodyf = html_entity_decode($mailrf['body']);
			$mailbodye = html_entity_decode($mailre['body']);
		$subjectf = html_entity_decode($mailrf['subject']);
		$mailbodyf = str_replace("{username}", $rw5['username'], $mailbodyf);
		$mailbodyf = str_replace("{project}", '<a href="'.$vpath . 'project-dtl.php?id=' .$_POST['hidep'].'">'. $rw7[project].'</a>', $mailbodyf);
		$mailbodyf = str_replace("{employer}", $rw6[username], $mailbodyf);
		$mailbodyf = str_replace("{amount}", $rw3['amount'], $mailbodyf);
	
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
		$headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
		
		
		$subjecte = html_entity_decode($mailre['subject']);
		$mailbodye = str_replace("{username}", $rw6['username'], $mailbodye);
		$mailbodye = str_replace("{project}", '<a href="'.$vpath . 'project-dtl.php?id=' .$_POST['hidep'].'">'. $rw7[project].'</a>', $mailbodye);
		$mailbodye = str_replace("{freelancer}", $rw5[username], $mailbodye);
		$mailbodye = str_replace("{amount}", $rw3['amount'], $mailbodye);
												

		mail($to, $subjectf, $mailbodyf, $headers);

		 mail($to1, $subjecte, $mailbodye, $headers);
            
                    header('location:' . $vpath . 'milestone.html');
                }
            }
        }
    } elseif ($_POST['action_select'] == 'dispute') {
        //echo "select * from ".$prev."escrow where escrow_id = '".$_POST['hides']."' and status = 'P'";
        $rw9 = mysql_query("select * from " . $prev . "escrow where escrow_id = '" . $_POST['hides'] . "' and status = 'P'");
        $rw3 = mysql_fetch_array($rw9);
        if (mysql_num_rows($rw9) > 0) {


            mysql_query("update " . $prev . "escrow set status = 'D' where escrow_id = '" . $_POST['hides'] . "'");

            mysql_query("insert into " . $prev . "notification set 
			user_id = '" . $rw3['user_id'] . "',
			message = 'You have disputed ane Milestone Payment',
			date = now()");
            mysql_query("insert into " . $prev . "notification set 
			user_id = '" . $rw3['bidder_id'] . "',
			message = 'Employer has disputed one Milestone Payment',
			date = now()");

            $rw5 = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id ='" . $rw3['bidder_id'] . "'"));
            $rw6 = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = '" . $rw3['user_id'] . "'"));
            $rw7 = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id = '" . $_POST['hidep'] . "'"));

        		$to=$rw5['email'];
				$to1=$rw6[email];

			
			$from = $setting['admin_mail'];
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_dispute_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
			if (mysql_num_rows($mailqf) == 0) {
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_dispute_for_freelancer' AND `langid`='en'");
			}

			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_dispute_for_employe' AND `langid`='" . getUserLastLang($rw7['user_id']) . "'");
			if (mysql_num_rows($mailqe) == 0) {
			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_dispute_for_employe' AND `langid`='en'");
			}

			$mailrf = mysql_fetch_assoc($mailqf);
			$mailre = mysql_fetch_assoc($mailqe);

			$mailbodyf = html_entity_decode($mailrf['body']);
			$mailbodye = html_entity_decode($mailre['body']);
		$subjectf = html_entity_decode($mailrf['subject']);
		$mailbodyf = str_replace("{username}", $rw5['username'], $mailbodyf);
		$mailbodyf = str_replace("{project}", '<a href="'.$vpath . 'project-dtl.php?id=' .$_POST['hidep'].'">'. $rw7[project].'</a>', $mailbodyf);
		$mailbodyf = str_replace("{employer}", $rw6[username], $mailbodyf);
		$mailbodyf = str_replace("{amount}", $rw3['amount'], $mailbodyf);
	
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
		$headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
		
		
		$subjecte = html_entity_decode($mailre['subject']);
		$mailbodye = str_replace("{username}", $rw6['username'], $mailbodye);
		$mailbodye = str_replace("{project}", '<a href="'.$vpath . 'project-dtl.php?id=' .$_POST['hidep'].'">'. $rw7[project].'</a>', $mailbodye);
		$mailbodye = str_replace("{freelancer}", $rw5[username], $mailbodye);
		$mailbodye = str_replace("{amount}", $rw3['amount'], $mailbodye);
												

		mail($to, $subjectf, $mailbodyf, $headers);

		 mail($to1, $subjecte, $mailbodye, $headers);




            $resout_mile = mysql_fetch_array(mysql_query("select * from " . $prev . "escrow where escrow_id = '" . $_POST['hides'] . "'"));

            $q = mysql_query("insert into  " . $prev . "disputes set disput_by='" . $_SESSION['user_id'] . "',claim_proj_id='" . $_POST['hidep'] . "',disput_for='" . $resout_mile['bidder_id'] . "',claim_title='" . $_POST['hidep'] . "_Dispute',claim_desc='" . $resout_mile['reason'] . "',claim_amount='" . $resout_mile['user_amount'] . "',round_stat='Y',date=NOW(),escrow_id = '" . $resout_mile['escrow_id'] . "'");

            header('location:' . $vpath . 'milestone.html');
        }
    }
}
?>