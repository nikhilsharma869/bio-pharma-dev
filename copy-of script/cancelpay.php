<?php 
$current_page = "<p>Cancel Pay</p>";
include "includes/header.php";
CheckLogin();

?>

<?php
$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);
$res1=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
$row1=mysql_fetch_array($res1);
?>
<?php
//print 'Payment Cancelled';
mysql_query("delete from ".$prev."transactions where paypaltran_id='".base64_decode($_REQUEST['payment_id'])."'");
mysql_query("delete from ".$prev."paypal_transactions where odeskclone_txn_id='".base64_decode($_REQUEST['payment_id'])."'");
?>
<?php
$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));
$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));
$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);
$sum=0;
$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");
while($row4pend=mysql_fetch_array($res4pend))
{
	$sum+=$row4pend['amount'];
}
$sum1=number_format($sum,2);
?>


<div class="freelancer">
  <!--Profile-->
  <?php include ('includes/leftpanel1.php');?>
  <!-- left side-->
  <!--middle -->
  <div class="profile_right">
  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr >
    <td width="10%">&nbsp;</td>
	<td width="30%">&nbsp;</td>
	<td width="60%">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3" align="center"><h2><?=$lang[cancle_tarn]?></h2></td>
  </tr>
  <tr >
    <td colspan="3">&nbsp;</td>
  </tr>
   <tr >
    <td >&nbsp;</td>
    <td ><strong><?=$lang[Financial_Account]?> : </strong></td>
	<td ><strong><?php print ucwords($row['fname']).' '.ucwords($row['lname'])?></strong></td>
  </tr>
   <tr >
    <td >&nbsp;</td>
    <td ><strong><?=$lang['BAL_H']?> : </strong></td>
	<td ><?php print $balsum;?></td>
  </tr>
   <tr >
    <td >&nbsp;</td>
    <td ><strong><?=$lang[Pending_Transactions]?> : </strong></td>
	<td ><?php print $sum1;?></td>
  </tr>
   <tr >
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3">&nbsp;</td>
  </tr>
   <tr >
    <td width="10%">&nbsp;</td>
	<td width="30%"><a href="withdraw.php" ><?=$lang[Withdraw_Transfer]?></a></td>
	<td width="60%"><a href="transaction_history.php"><?=$lang[TRANSACTION_HISTORY]?></a></td>
  </tr>
  <tr >
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3">&nbsp;</td>
  </tr>
</table>



</div>

</div>		  

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>