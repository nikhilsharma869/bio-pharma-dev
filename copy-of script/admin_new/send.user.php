<?
	require_once("includes/access.php");
	require_once("includes/header.php");
	
	$utype=$_POST['ut_hid'];
	
	
	$from =$_REQUEST["from"];
	$to = $_REQUEST["send_sel"];
	$subject = $_REQUEST["subject"];
	$body = htmlentities($_REQUEST["message"]);
/*if($utype=='t')
{
	mysql_query("insert into ".$prev."messages set
	receiver='".$to."',
	sender_id='".$_SESSION['team_id']."',
	sender='".$from."',
	subject='".$subject."',
	message='".$body."',
	user_type='T',
	message_type = 'T',
	sent_time=now()");
}*/
//elseif($utype=='u')
/*if($utype=='u')
{
	$res1=mysql_query("select user_type from ".$prev."user where user_id='".$to."'");
	$row1=mysql_fetch_array($res1);
	$a=$row1['user_type'];
	mysql_query("insert into ".$prev."messages set
	receiver='".$to."',
	sender_id=0,
	sender='".$from."',
	subject='".$subject."',
	message='".$body."',
	user_type='".$a."',
	message_type = 'AU',
	sent_time=now()");
}
header("Location: ". "sendmessage.entry.php?msg=" . urlencode("Your Message has been sent!") );*/


$res3=mysql_query("insert into ".$prev."messages set
	receiver='".$to."',
	sender_id='1',
	sender='".$from."',
	subject='".$subject."',
	message='".$body."',
	user_type='sender',
	sent_time=now(),
	status='Y',
	message_type='A',
	read_status='N',
	view_user='AD'
	");
	if($res3)
	{
		$res4=mysql_query("insert into ".$prev."messages set
		receiver='".$to."',
		sender_id='1',
		sender='".$from."',
		subject='".$subject."',
		message='".$body."',
		user_type='reciver',
		sent_time=now(),
		status='Y',
		message_type='A',
		read_status='N',
		view_user='AD'
		");
	
		
		header("Location: ". "sendmessage.entry.php?m=".$utype."&msg=" . urlencode("Your Message has been sent!") );
		
		
	}
	else
	{
		header("Location: ". "sendmessage.entry.php?m=".$utype."&msg=" . urlencode("Try again ..") );
	}










?>