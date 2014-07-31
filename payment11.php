<?php 
$current_page="<p>Deposit Funds</p>"; 
include "includes/header.php";

CheckLogin();

?>
<?php

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

$row=mysql_fetch_array($res);

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));

$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));

$balsum = $rwbal['balsum1']-$rwbal2['baldeb'];



//if($balsum > 0)

//header("Location:milestone.php");



$sum=0;

$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");

while($row4pend=mysql_fetch_array($res4pend))

{

	$sum+=$row4pend['amount'];

}

$sum1=number_format($sum,2);

?>
<!-- content-->

<div class="browse_contract">
  <!--Profile-->
  <?php include 'includes/leftpanel1.php';?>
  <!-- left side-->
  <!--middle -->
  <div class="profile_right">
    <div class="create_profile" style="height: 93px;">
      <h2>Deposit Funds</h2>
	 <div style="position: relative;text-align: right;top: -44px;"> 
		 Balance  :  $ <?php print $balsum;?>  <br />    
		 Pending Transactions  :  $ <?php print $sum1;?>
	 </div>
    </div>
    <div class="create_profile2">
	<div style="clear:both; height:10px;"></div>
      <table cellpadding="0" cellspacing="0" border="0"  width="90%" align="center" >
        
        <tr>
          <td>
            <?php
			$charges_cc = '';
			$charges_pp = '';
			$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
			
			?>
            
           
            <table width="100%" cellpadding="8" cellspacing="0" border="0" >
              <tbody>
                <tr style="background-color:whitesmoke; height:40px;">
                  <td width="40%" style="font-weight:bold; font-size:12px;">Method</td>
                  <td width="40%" style="font-weight:bold; font-size:12px;">Fees</td>
                  <td width="20%" style="font-weight:bold; font-size:12px;">Actions</td>
                </tr>
                
                <tr>
                  <td><strong>Paypal</strong><br />
                    you can pay with paypal, for the second option.</td>
                  <td>
				    <?php
						if($rw1['depositpp_method']=='F')
						{ $charges_pp = '$ '.$rw1['depositpp_charges'].' (USD)';}
						elseif($rw1['depositpp_method']=='P')
						{ $charges_pp = $rw1['depositpp_percent'].' %';}
					?>
                    Paypal Fees - <strong><?php print $rw1['depositpp_fees'];?>&nbsp;%</strong><br />
                    Processing charges - <strong><?php print $charges_pp;?></strong> </td>
                  <td><a href="deposit_pp.php" >
                    <button class="submit_bott">&nbsp; Paypal &nbsp;</button>
                    </a></td>
                </tr>
                
                <tr>
                  <td height="10px;"></td>
                </tr>
              </tbody>
            </table>
           
          </td>
        </tr>
       
      </table>
    </div>
  </div>
</div>
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?>
