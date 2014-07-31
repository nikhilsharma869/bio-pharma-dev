<?php
session_start();
include "configs/config.php";
include "configs/path.php";
CheckLogin();
?>
<?php
//print_r($_POST);
$odeskcharges = $_POST['pcharges_txt'];
$balanceamt = $_POST['depositamt_txt'];
$depositamt = $_POST['totalamt_txt'];
$userid=$_POST['userid'];
$email=$_POST['email'];
$firstname=$_POST['firstname'];

$payment_id = rand(1000,9999).time();

$sql = "INSERT INTO ".$prev."transactions set
details = '".$_POST['pmttype']."',
user_id = '".$_SESSION['user_id']."',
balance = '".$balanceamt."',
add_date = now(),
date2 = '".time()."',
paypaltran_id = '".$payment_id."',
status = 'P', amttype = 'CR'";
$rs1 = mysql_query($sql);

if($rs1)
{
	mysql_query("insert into ".$prev."paypal_transactions set odeskclone_txn_id = '".$payment_id."'");
	/*mysql_query("insert into ".$prev."profits set 
	amount = '".$odeskcharges."',
	paypaltran_id = '".$payment_id."',
	desc = '".$_POST['pmttype']."',
	add_date =now() , status = 'P'");*/
}
/*$_SESSION['trnid'] = mysql_insert_id();*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript">
function paypalformsubmit()
{
	document.getElementById('ajaxloader').style.display = '';
	setTimeout("functionformsubmit()", 5);
}
function functionformsubmit()
{
	document.getElementById('formsendpaypal').submit();
}

</script></head> 
<body  onload="javascript:paypalformsubmit();">
<div align="center" >
		<div style="height:70px;"></div>
    	<div id="ajaxloader" style="display:none; width:40%;">
    		<img src="images/blue_loading.gif" border="0" />
            <div style="height:20px;"></div>
            <div style="font-size:12px; color:#0C96E9; margin:0 0 0 7px; font-weight:bold;" align="center">Please wait ..</div>
			 <div style="height:120px;"></div>
    	</div>
		<div>
<?php $rescc = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));?>

<form name="formsendpaypal" id="formsendpaypal" action="https://www.moneybookers.com/app/payment.pl" method="post">
<input type="hidden" name="pay_to_email" value="jobstask@yahoo.com">
<input type="hidden" name="transaction_id" value="<?php print $payment_id; ?>"> 
<input type="hidden" name="return_url" value="<?php echo $vpath;?>thankpay.php?payment_id=<?php echo base64_encode($payment_id);?>&action=success">
<input type="hidden" name="cancel_url" value="<?php echo $vpath;?>cancelpay.php?payment_id=<?php echo base64_encode($payment_id);?>&action=failure">
<input type="hidden" name="status_url" value="https://www.moneybookers.com/process_payment.cgi"> 
<input type="hidden" name="language" value="EN"> 
<input type="hidden" name="customer_number" value="<?=$userid?>"> 
<input type="hidden" name="session_ID" value="<?=$userid?>"> 
<input type="hidden" name="pay_from_email" value="<?=$email?>"> 
<input type="hidden" name="amount" value="<?php print $depositamt;?>"> 
<input type="hidden" name="currency" value="USD"> 
<input type="hidden" name="firstname" value="<?=$firstname?>"> 
<input type="hidden" name="detail1_description" value="<?php print $payment_id; ?>"> 
<input type="hidden" name="detail1_text" value="<?php print $_POST['pmttype']; ?>"> 
<input type="hidden" name="confirmation_note" value="Thank You for the Transaction!">
</form> 

     
		</div>
</div>
</body>
 
</html>