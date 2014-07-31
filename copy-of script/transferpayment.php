<?php
session_start();
include "configs/config.php";
include "configs/path.php";
include "logincheck.php";
ob_start();
if(isset($_POST['milesub'])&&($_POST['milesub']=='Submit'))
{
	$depositamt = $_POST['tranamt_txt'];
	$payment_id = rand(1000,9999).time();
	$res = mysql_query("INSERT INTO ".$prev."transactions set
	amount = '".$_POST['transfer_sel']."',
	details = '".$_POST['pmttype']."',
	user_id = '".$_SESSION['user_id']."',
	balance = '".$depositamt."',
	add_date = now(),
	date2 = '".time()."',
	paypaltran_id = '".$payment_id."',
	status = 'P', amttype = 'DR'");
	if($res)
	{	
		$rwpayee = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_POST['transfer_sel']."'"));
		$curl=$vpath."transfer_confirm.php?pm=".base64_encode($payment_id)."&pyid=".base64_encode($_POST['transfer_sel']);
		$curl1=$vpath."transfer_confirm.php?pm=".base64_encode($payment_id)."&pyid=".base64_encode('cancel');
		$res2=mysql_query("select * from ".$prev."mailsetup where mail_type=\"registration\"");
		$row=mysql_fetch_array($res2);
		$to  = $_POST['emailhid'];
		$subject = 'Payment Transfer Confirmation Mail';
		$message = '
		<html>
		<head>
		  <title>oDesk Notification</title>
		</head>
		<body>
			<p>&nbsp;</p>
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody>
				<tr>
					<td>'.html_entity_decode($row['header']).'</td>
				</tr>
			</tbody>
			</table>
		<p><br />
		Hi '.$_POST['fnamehid'].',<br />
		<br />
		'.html_entity_decode($row['body']).'
		You have requested for direct transfer of payment of Amount: $'.$depositamt.' (USD)<br />
		to (Payee Name): '.ucwords($rwpayee['fname']).' '.ucwords($rwpayee['lname']).'<br />
		<p>&nbsp;</p>
		Click below to confirm your transaction:<br />
		<a target="_blank" style="color: rgb(0, 0, 204); " href='.$curl.'>'.$curl.'</a><br />
		<p>&nbsp;</p>
		Click below to cancel your transaction:<br />
		<a target="_blank" style="color: rgb(0, 0, 204); " href='.$curl1.'>'.$curl1.'</a><br />
		<br />
		If you have problems, please paste the above URL into your web browser.&nbsp;<br />
		<br />
		'.html_entity_decode($row['footer']).'
		</body>
	</html>
		';
		//print $message;die();
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		mail($to, $subject, $message, $headers);
		header('location:transfer.php?msg=Please check mail id');
	}
	else
	{
		print "DB Error Please Try Later";
	}
}