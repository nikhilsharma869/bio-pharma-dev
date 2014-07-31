<?php
session_start();
include "configs/config.php";
include "configs/path.php";
include "logincheck.php";
ob_start();
?>
<?php
if(isset($_GET['pm'])&&isset($_GET['pyid'])&&(base64_decode($_GET['pyid'])!='cancel'))
{
	$user_name=base64_decode($_GET['pyid']);
	$payment_id = rand(1000,9999).time();
	$payment_id1 = base64_decode($_GET['pm']);
	$res=mysql_query("select * from ".$prev."transactions where paypaltran_id='".$payment_id1."' and status='P'");
	if(mysql_num_rows($res)>0)
	{
		$row=mysql_fetch_array($res);
		$res1c = mysql_query("INSERT INTO ".$prev."transactions set
		details = '".$row['details']."',
		user_id = '".$user_name."',
		balance = '".$row['balance']."',
		add_date = now(),
		date2 = '".time()."',
		paypaltran_id = '".$payment_id."',
		status = 'Y', amttype = 'CR'");
		if($res1c)
		{
			mysql_query("update ".$prev."transactions set status = 'Y' where paypaltran_id = '".$payment_id1."'");
			$userrw = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$user_name."'"));
			$payerrw = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$row['user_id']."'"));
			$res2=mysql_query("select * from ".$prev."mailsetup where mail_type=\"registration\"");
			$rowmail1=mysql_fetch_array($res2);
				$to  = $userrw['email'];
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
							<td>'.html_entity_decode($rowmail1['header']).'</td>
						</tr>
					</tbody>
					</table>
				<p><br />
				Hi '.$userrw['fname'].',<br />
				<br />
				'.html_entity_decode($rowmail1['body']).'
				Your oDesk Account have been credited by  Amount: <b>$'.$row['balance'].' (USD)</b><br />
				From (Payer Name): <b>'.ucwords($payerrw['fname']).' '.ucwords($payerrw['lname']).'</b><br />
				On Dated: <b>'.$row['add_date'].'</b><br />
				oDesk Transaction ID: <b>'.$payment_id.'</b><br />
				<p>&nbsp;</p>
				<br />
				'.html_entity_decode($rowmail1['footer']).'
				</body>
				</html>
				';
				//print $message;die();
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				mail($to, $subject, $message, $headers);
			header("location:transfer.php?msg=Payment Transferred successfully");
		}
		else
		{
			print 'DB Error, Please try after some time';
		}
	}
	else
	{
		header("location:transfer.php");
	}
}
elseif(isset($_GET['pm'])&&isset($_GET['pyid'])&&(base64_decode($_GET['pyid'])=='cancel'))
{
	$payment_id1 = base64_decode($_GET['pm']);
	$res=mysql_query("select * from ".$prev."transactions where paypaltran_id='".$payment_id1."' and status='P'");
	if(mysql_num_rows($res)>0)
	{
		$abp = mysql_query("delete from ".$prev."transactions where paypaltran_id='".$payment_id1."'");
		if($abp)
		{
			header("location:transfer.php?msg=Payment Cancelled successfully");
		}
		else
		{
			print 'DB Error, Please try after some time';
		}
	}
		else
	{
		header("location:transfer.php");
	}
}
?>