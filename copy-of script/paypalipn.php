<?php
session_start();
include "configs/path.php";  // this is optional but useful for setting up database access constants etc
$rescc = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

$myemail = $rescc['admin_mail']; 
$payment_status = $_POST['payment_status'];

// The majority of the following code is a direct copy of the example code specified on the Paypal site.

// Paypal POSTs HTML FORM variables to this page
// we must post all the variables back to paypal exactly unchanged and add an extra parameter cmd with value _notify-validate

// initialise a variable with the requried cmd parameter
$req = 'cmd=_notify-validate'; 

// go through each of the POSTed vars and add them to the variable
foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
	
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
 
	// If testing on Sandbox use: 
$header .= "Host: www.sandbox.paypal.com:443\r\n";
//$header .= "Host: ipnpb.paypal.com:443\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

	// If testing on Sandbox use:
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
//$fp = fsockopen ('ssl://ipnpb.paypal.com', 443, $errno, $errstr, 30);


if (!$fp) {
// HTTP ERROR Failed to connect
// You can optionally send an email to let you know of the problem
// or add other error handling. 

 //email
 $mail_From = "From: noreply@consultsunlimitedinc.com";
 $mail_To = $myemail;
 $mail_Subject = "HTTP ERROR";
 $mail_Body = $errstr;//error string from fsockopen

 mail($mail_To, $mail_Subject, $mail_Body, $mail_From); 
//
// If you want to log to a file as well then uncomment the following lines
// You can use these later on in the script as well
// 
// $fh = fopen("logipn.txt", 'a');//open file and create if does not exist
// fwrite($fh, "\r\n/////////////////////////////////////////\r\n HTTP ERROR \r\n");//Just for spacing in log file
//
// fwrite($fh, $errstr);//write data
// fclose($fh);//close file

}
else
{

fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
	mail("pragati@scriptgiant.com","paypal1", $fp.',,,,,,,,'.$res,$header . $req);

// assign posted variables to local variables
// the actual variables POSTed will vary depending on your application.
// there are a huge number of possible variables that can be used. See the paypal documentation.

// the ones shown here are what is needed for a simple purchase
// a "custom" variable is available for you to pass whatever you want in it. 
// if you have many complex variables to pass it is possible to use session variables to pass them.

      $item_name = $_POST['item_name'];
      $order_id = $_POST['item_number'];
      //$item_colour = $_POST['custom'];  
      $payment_status = $_POST['payment_status'];
	  $payment_fees = $_POST['mc_fee'];
      $payment_amount = $_POST['mc_gross'];         //full amount of payment. payment_gross in US
      $payment_currency = $_POST['mc_currency'];
      $txn_id = $_POST['txn_id'];                   //unique transaction id
      $receiver_email = $_POST['receiver_email'];
      $payer_email = $_POST['payer_email'];
	  $payment_dt = $_POST['payment_date'];
	  $sub = $item_name."<br />".$order_id."<br />".$payment_status;
// use the above params to look up what the price of "item_name" should be.
    //  $amount_they_should_have_paid = lookup_price($item_name); // you need to create this code to find out what the price for the item they bought really is so that you can check it against what they have paid. This is an anti hacker check.

// the next part is also very important from a security point of view
// you must check at the least the following...

      if ($payment_status=='Completed') {  //txn_id isn't same as previous to stop duplicate payments. You will need to write a function to do this check.

// everything is ok
// you will probably want to do some processing here such as logging the purchase in a database etc
$sql = "SELECT * FROM ".$prev."paypal_transactions WHERE payment_status = 'Completed' AND paypal_txn_id='".$txn_id."' AND odeskclone_txn_id = '".$order_id."' ";
$res = mysql_query ($sql);
$row=mysql_fetch_array($res);
if(!$row)
{
			$sql = "UPDATE ".$prev."paypal_transactions SET details = '".$item_name."',
			receiver_email = '".$receiver_email."',
			payer_email = '".$payer_email."',
			paypal_txn_id = '".$txn_id."',
			amount = '".$payment_amount."',
			currency_type = '".$payment_currency."',
			payment_fee = '".$payment_fees."',
			payment_date = '".$payment_dt."',
			payment_status = '".$payment_status."' where odeskclone_txn_id = '".$order_id."'";
			mysql_query($sql);
			
			$rwp = mysql_fetch_array(mysql_query("select * from ".$prev."transactions where paypaltran_id = '".$order_id."'"));
			
			$rwp1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rwp['user_id']."'"));
			
			$profit = floatval($payment_amount) - floatval($rwp['balance']);
			
			$sql = "UPDATE ".$prev."transactions SET status = 'Y' WHERE paypaltran_id = '".$order_id."'";
			mysql_query($sql);
			
			mysql_query("insert into ".$prev."profits set 
			amount = '".$profit."',
			paypaltran_id = '".$order_id."',
			descrip = '".$item_name."',
			add_date =now() , status = 'Y'");
			
			$headers = "From: freelance\r\nReply-to: ".$rwp1['email']."\r\nContent-type:text/html;charset=iso-8859-1";
			
			$download_message="
				<html>
					<head>
						 <title>Servilance Notification</title>
					</head>
					<body>
					<p>The following transaction has been done</p>
					<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">
						<tr >
							<td width=\"30%\">Payer Name :</td>
							<td>".ucwords($rwp1['fname']).' '.ucwords($rwp1['lname'])."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>Payer-Email Id :</td>
							<td>".$payer_email."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"> 
							</td>
						</tr>
						<tr>
							<td>Amount (USD):</td>
							<td>$ ".$payment_amount."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>Paypal Transaction ID :</td>
							<td>".$txn_id."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>Payment Status :</td>
							<td>".$payment_status."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
						<tr>
							<td>Payment Date :</td>
							<td>".$payment_dt."</td>
						</tr>
						<tr>
							<td colspan=\"2\" height=\"10\"></td>
						</tr>
				</table>
				</body>
				</html>
			";
			mail($rwp1['email'],"Payment Confirmation - $item_name",$download_message,$headers);
			$return_email = $myemail;
			mail($return_email,"Payment Confirmation - $item_name",$download_message,$headers);
			header("Location: thankpay.php");
			
}
			

// you can also during development or debugging send yourself an email to say it worked.
// email is a good choice because you can't display messages on the screen as this processing is happening totally independently of
// the main web page processing.

//        uncomment this section during development to receive an email to indicate whats happened

      }
      else
      {
//
// paypal replied with something other than completed or one of the security checks failed.
// you might want to do some extra processing here
//
//in this application we only accept a status of "Completed" and treat all others as failure. You may want to handle the other possibilities differently
//payment_status can be one of the following
//Canceled_Reversal: A reversal has been canceled. For example, you won a dispute with the customer, and the funds for
//                           Completed the transaction that was reversed have been returned to you.
//Completed:            The payment has been completed, and the funds have been added successfully to your account balance.
//Denied:                 You denied the payment. This happens only if the payment was previously pending because of possible
//                            reasons described for the PendingReason element.
//Expired:                 This authorization has expired and cannot be captured.
//Failed:                   The payment has failed. This happens only if the payment was made from your customer's bank account.
//Pending:                The payment is pending. See pending_reason for more information.
//Refunded:              You refunded the payment.
//Reversed:              A payment was reversed due to a chargeback or other type of reversal. The funds have been removed from
//                          your account balance and returned to the buyer. The reason for the
//                           reversal is specified in the ReasonCode element.
//Processed:            A payment has been accepted.
//Voided:                 This authorization has been voided.
//

//
// we will send an email to say that something went wrong
          $mail_To = $myemail;
          $mail_Subject = "PayPal IPN status not completed or security check fail";
//
//you can put whatever debug info you want in the email
//
          $mail_Body = "Something wrong. \n\nThe transaction ID number is: $txn_id \n\n Payment status = $payment_status \n\n Payment amount = $payment_amount";
          mail($mail_To, $mail_Subject, $mail_Body);

      }
    }
    else if (strcmp ($res, "INVALID") == 0) {
//
// Paypal didnt like what we sent. If you start getting these after system was working ok in the past, check if Paypal has altered its IPN format
//
      $mail_To = $myemail;
      $mail_Subject = "PayPal - Invalid IPN ";
      $mail_Body = "We have had an INVALID response. \n\nThe transaction ID number is: $txn_id \n\n username = $username";
      mail($mail_To, $mail_Subject, $mail_Body);
    }
  } //end of while
fclose ($fp);
}

?>