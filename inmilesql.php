<?php
session_start();
include "configs/config.php";
include "configs/path.php";
include("includes/function.php");
//include "logincheck.php";
if($_SESSION['user_id'])
	{$user_id=$_SESSION['user_id'];}else
	{$user_id=$_SESSION['usre_id'];}
	if(empty($user_id))
	{
	echo "aa";
	header("Location: login.php"); exit();}
ob_start();
?>
<?php
if($_POST['action_select']!='select')
{
	if($_POST['action_select']=='request')
	{
		$rw1 = mysql_query("select * from ".$prev."escrow where escrow_id = '".$_POST['hides']."' and status = 'P'");
		if(mysql_num_rows($rw1)>0)
		{
			$rw3 = mysql_fetch_array($rw1);
			$rw5 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id ='".$rw3['bidder_id']."'"));
			$rw6 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw3['user_id']."'"));
			$rw7 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".$_POST['hidep']."'"));
			
			echo $to=$rw5['email'];
				echo $to1=$rw6[email];

			
			$from = $setting['admin_mail'];
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_payment_request_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
			if (mysql_num_rows($mailqf) == 0) {
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_payment_request_for_freelancer' AND `langid`='en'");
			}

			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_payment_request_for_employe' AND `langid`='" . getUserLastLang($rw7['user_id']) . "'");
			if (mysql_num_rows($mailqe) == 0) {
			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_payment_request_for_employe' AND `langid`='en'");
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

			
			$body='Hi '.ucwords($rw6['fname']).'.<br><br>
			You are requested to release the payment, details of which are as follows.<br><p>
			Project Name: '.ucwords($rw7['project']).' job.<br><p>
			Contractor Name: '.ucwords($rw5['fname']).' '.ucwords($rw5['lname']).'.<br><p>
			
			Requested Amount: $'.$rw3['amount'].'(USD).<br><p>
			On Dated: '.date('d-M-Y', time()).'.<br><p>
			<br><p>';
			$exe4=mysql_query("insert into ".$prev."messages set 
			receiver='".$rw3['user_id']."',
			sender_id='".$rw3['bidder_id']."',
			sender='".$rw5['email']."',
			project_id='".$rw7['id']."',
			subject='Request To Release Milestone Payment',
			message='".$body."',
			sent_time='".date('Y-m-d,h:i:s',time())."',status='Y'");
			// mysql_query("insert into ".$prev."notification set 
			// user_id = '".$rw3['bidder_id']."',
			// message = 'Request to release Milestone Payment sent',
			// add_date = now()");
			$link = $vpath.'milestone.html';
			$notify = add_notification($rw3['bidder_id'], 'Request to release Milestone Payment sent', 'W', $link);

			// mysql_query("insert into ".$prev."notification set 
			// user_id = '".$rw3['user_id']."',
			// message = 'Request to release Milestone Payment received',
			// add_date = now()");
			$link = $vpath.'milestone.html';
			$notify = add_notification($rw3['user_id'], 'Request to release Milestone Payment received', 'E', $link);
			header('location:milestone.php');
		}		
	}
	elseif($_POST['action_select']=='dispute')
	{
		$rw9 = mysql_query("select * from ".$prev."escrow where escrow_id = '".$_POST['hides']."' and status = 'P'");
		if(mysql_num_rows($rw9)>0)
		{
			mysql_query("update ".$prev."escrow set status = 'D' where escrow_id = '".$_POST['hides']."'");
			// mysql_query("insert into ".$prev."notification set 
			// user_id = '".$rw3['bidder_id']."',
			// message = 'You have disputed ane Milestone Payment',
			// add_date = now()");
			$link = $vpath.'milestone.html';
			$notify = add_notification($rw3['bidder_id'], 'You have disputed ane Milestone Payment', 'W', $link);

			// mysql_query("insert into ".$prev."notification set 
			// user_id = '".$rw3['user_id']."',
			// message = 'Contractor has disputed one Milestone Payment',
			// add_date = now()");
			$link = $vpath.'milestone.html';
			$notify = add_notification($rw3['user_id'], 'Contractor has disputed one Milestone Payment', 'E', $link);

			header('location:milestone.php');
		}
	}
	elseif($_POST['action_select']=='cancel')
	{
		$rw10 = mysql_query("select * from ".$prev."escrow where escrow_id = '".$_POST['hides']."' and status = 'P'");
		if(mysql_num_rows($rw10)>0)
		{
			mysql_query("update ".$prev."escrow set status = 'C' where escrow_id = '".$_POST['hides']."'");
			// mysql_query("insert into ".$prev."notification set 
			// user_id = '".$rw3['bidder_id']."',
			// message = 'You have cancelled one Milestone Payment',
			// add_date = now()");
			$link = $vpath.'milestone.html';
			$notify = add_notification($rw3['bidder_id'], 'You have cancelled one Milestone Payment', 'E', $link);

			// mysql_query("insert into ".$prev."notification set 
			// user_id = '".$rw3['user_id']."',
			// message = 'Contractor has cancelled one Milestone Payment',
			// add_date = now()");
			$link = $vpath.'milestone.html';
			$notify = add_notification($rw3['user_id'], 'Contractor has cancelled one Milestone Payment', 'E', $link);
			header('location:milestone.php');
		}
	}
}

?>