<?php
session_start();
ob_start();
include "configs/config.php";
include "configs/path.php";
//include "logincheck.php";
?>
<?php
/*	if(isset($_REQUEST['payment_id'])&& $_REQUEST['payment_id']!="")
	{
		$update_mem_paymentstatus = "update ".$prev."transactions set status='Y' where paypaltran_id='".base64_decode($_REQUEST['payment_id'])."'";
		mysql_query($update_mem_paymentstatus);
		$select_premium_vout="select * from ".$prev."transactions where paypaltran_id=".base64_decode($_REQUEST['payment_id'])." and status='Y'";
		$rec_premium_vout=mysql_query($select_premium_vout);
		if(mysql_num_rows($rec_premium_vout)>0)
		{
			$row_premium_vout=mysql_fetch_array($rec_premium_vout);
			$rwusr = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$row_premium_vout['user_id']."'"));
			$name = ucwords($rwusr['fname']).' '.$rwusr['lname'];
		
			$headers = "From: oOfficework\r\nReply-to: ".$rwusr['email']."\r\nContent-type:text/html;charset=iso-8859-1";
			$pmtdetail = $row_premium_vout['details'];
			$msg="
				<html>
					<head>
						 <title>Account Activation Mail</title>
					</head>
					<body>
					<p>Thank You For Your Payment</p>
					<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
						<tr >
							<td width=\"30%\">Name :</td>
							<td>".$name."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>Email Id :</td>
							<td>".$rwusr['email']."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"> 
							</td>
						</tr>
						<tr>
							<td>Address :</td>
							<td>".$rwusr['user_addr']."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>City :</td>
							<td>".$rwusr['user_city']."
						</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>State :</td>
							<td>".$rwusr['user_state']."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>Country :</td>
							<td>".$rwusr['country']."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>Payment Status :</td>
							<td><b>DONE</b></td>
						</tr>
				</table>
				</body>
				</html>
			";*/
			/*if(mail($rwusr['email'],"Payment Confirmation - $pmtdetail",$msg,$headers))
			{
				$return_email='abhik_stfc@hotmail.com';
				mail($return_email,"Payment Confirmation - $pmtdetail",$msg,$headers);*/
				header("location:thankyou.php?trnid=".base64_decode($_REQUEST['payment_id']));
			/*}
		}
}*/
?>