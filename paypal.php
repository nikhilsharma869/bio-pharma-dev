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
$depositamt = sprintf("%01.2f",$balanceamt+(($balanceamt*3.99)/100)+0.30);
$payment_id = rand(1000,9999).time();
$_POST['pmttype']="Paypal Account Deposit";
$sql = "INSERT INTO ".$prev."transactions set
details = '".$_POST['pmttype']."',
user_id = '".$_SESSION['user_id']."',
amount = '".$balanceamt."',
add_date = now(),
balance = '".$balanceamt."',
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
	setTimeout("functionformsubmit()", 10);
}
function functionformsubmit()
{
	document.formsendpaypal.submit();
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
    <form name="formsendpaypal" id="formsendpaypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="<?php print $rescc['ppemailaddr']; ?>" />
        <input type="hidden" name="item_name" value="<?php print $_POST['pmttype']; ?>">
        <input type="hidden" name="item_number" value="<?php print $payment_id; ?>">
        <input type="hidden" name="buyer_credit_promo_code" value="1"> 
        <input type="hidden" name="buyer_credit_product_category" value="1"> 
        <input type="hidden" name="buyer_credit_shipping_method" value="1"> 
        <input type="hidden" name="buyer_credit_user_address_change" value="1"> 
        <input type="hidden" name="no_shipping" value="1"> 
        <input type="hidden" name="no_note" value="1"> 
        <input type="hidden" name="currency_code" value="<?=$curncode[1]?>"> <!--Value is currency code--> 
        <input type="hidden" name="lc" value="US"> <!--Country code-->
        <input type="hidden" name="notify_url" value="<?php echo $vpath;?>paypalipn.php" /> 
        <input type="hidden" name="bn" value="PP-SubscriptionsBF"> 
        <input type="hidden" name="amount" value="<?php print $depositamt;?>"> <!--Value is the amount how much you collect from user, this value is mandatary, you can get this value from the hidden filed of previous form you come from or get from passing to the url, best to get from hidden field, if you get from url it is not safe because we give chance to the user to change the amount value--> 
        <input type="hidden" name="return" value="<?php echo $vpath;?>thankpay.php?payment_id=<?php echo base64_encode($payment_id);?>&action=success">  
        <input type="hidden" name="cancel_return" value="<?php echo $vpath;?>cancelpay.php?payment_id=<?php echo base64_encode($payment_id);?>&action=failure">
    </form> 
		</div>
</div>
</body>
 
</html>