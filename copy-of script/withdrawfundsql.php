<?php
session_start();
include "configs/config.php";
include "configs/path.php";
CheckLogin();
ob_start();
?>
<?php
$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));			
			$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));			
			$balsum = $rwbal['balsum1']-$rwbal2['baldeb'];
if($_POST['depositamt_txt']=="")
{
	$_SESSION['error']="Withdrawal amount can not left blank.";
	header('location:'.$vpath.'withdrawfund/'.$_POST[pmttypeb].'/');
}
else if($_POST['pcharges_txt']=="")
{
	$_SESSION['error']="Processing charges can not left blank.";
	header('location:'.$vpath.'withdrawfund/'.$_POST[pmttypeb].'/');
}
else if($_POST['totalamt_txt']=="")
{
	$_SESSION['error']="Net amount can not left blank.";
	header('location:'.$vpath.'withdrawfund/'.$_POST[pmttypeb].'/');
}
else
{			
if(isset($_POST['with_sub'])&&($_POST['with_sub']=='Submit') && $balsum >=$_POST['totalamt_txt'])
{
	$payment_id = rand(1000,9999).time();
	$rw1 = mysql_query("insert into ".$prev."withdrawals set 
	paypaltran_id = '".$payment_id."',
	user_id = '".$_SESSION['user_id']."',
	add_date = now(),
	amount = '".$_POST['totalamt_txt']."', status = 'Pending'");

	if($rw1)
	{
	$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$_SESSION['user_id']));
   	$to  = $usr['email'];
	$from = $setting['admin_mail'];
	$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='paypal_withdrawal_request' AND `langid`='" . $_SESSION['lang_code'] . "'");
	if (mysql_num_rows($mailqf) == 0) {
	$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='paypal_withdrawal_request' AND `langid`='en'");
	}
	$mailrf = mysql_fetch_assoc($mailqf);
	$mailbodyf = html_entity_decode($mailrf['body']);
		$subjectf = html_entity_decode($mailrf['subject']);
		$mailbodyf = str_replace("{username}", $usr['username'], $mailbodyf);
		$mailbodyf = str_replace("{amount}", $_POST['totalamt_txt'], $mailbodyf);
			
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
		$headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
		
		mail($to, $subjectf, $mailbodyf, $headers);
		
		$rw2 = mysql_query("insert into ".$prev."transactions set 
		details = '".$_POST['pmttype']."',
		user_id = '".$_SESSION['user_id']."',
		balance = '".$_POST['depositamt_txt']."',
		add_date = now(),
		date2 = '".time()."',
		paypaltran_id = '".$payment_id."',
		status = 'Y',
		amttype = 'DR'");
				
		$rw3 = mysql_query("insert into ".$prev."deposits set 
		details = '".$_POST['pmttype']."',
		user_id = '".$_SESSION['user_id']."',
		amount = '".$_POST['pcharges_txt']."',
		add_date = now(),
		paypaltran_id = '".$payment_id."',
		status = 'N',
		amttype = 'CR'");
		header('location:withdraw.php');
	}
	else
	{
		echo 'DB Error, Please try later';
	}
}
}
?>