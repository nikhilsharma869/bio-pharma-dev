<?php 
$current_page="Thanks For the Payment"; 
include "includes/header.php";
CheckLogin();

$charges_cc = '';
$charges_pp = '';
$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);
$res1=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
$row1=mysql_fetch_array($res1);

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
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>">Home</a> | <a href="<?=$vpath?>payment/dsp/">My Finance</a> | <a href="javascript:void(0);" class="selected">Thank You Pay</a></p></div>
<div class="clear"></div>
  <?php include ('includes/leftpanel1.php');?>
  <!-- left side-->
  <!--middle -->
  <div class="profile_right">
	<div class="myproheading">	
		
		<h3><?=$lang[thnk_tarn]?></h3>
		</div>
		<div class="myproblockleft" style="width:350px;">
            <strong style="padding:12px 0; display:block;">Details</strong>
            <p><?=$lang[Financial_Account]?> :<b> <?php print ucwords($row['fname']).' '.ucwords($row['lname'])?></b></p>
			
           <p><?=$lang['BAL_H']?> : <b>$<?php print $balsum;?></b></p>
		    <p>Click <a href="<?=$vpath?>milestone.php" class="link_class" ><b>here</b></a> to transfer money</p>
			 <p>Click <a href="<?=$vpath?>transaction_history.php" class="link_class" ><b>here</b></a> to check your transation</p>
			
            </div><div ><img src="<?=$vpath?>images/paypal.jpg"/></div>
	
		
		

  </div>
</div>		  

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>