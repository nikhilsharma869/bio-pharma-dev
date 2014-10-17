<?php 
$current_page = "<p>Deposit Funds</p>";
include "includes/header.php";
CheckLogin();


$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);
$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));
$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));
$balsum = $rwbal['balsum1']-$rwbal2['baldeb'];
$balsum=number_format($balsum,2,'.',',');
$sum=0;
$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");
while($row4pend=mysql_fetch_array($res4pend))
{
	$sum+=$row4pend['amount'];
}
$sum1=number_format($sum,2);

$charges_cc = '';
$charges_pp = '';
$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

?>
<script type="text/javascript">
function chkfrm()
{
	if((document.getElementById('depositamt_txt').value=='')||parseFloat(document.getElementById('depositamt_txt').value)<10.00)
	{
		alert('<?=$lang['ENT_DEPO_AMT_10']?>');
		document.getElementById('depositamt_txt').focus();
		return false;
	}
document.depositpayment_frm.submit();
}

</script>

<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="<?=$vpath?>payment/dsp/"><?=$lang['My_finance']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['DEPOSIT_FUNDS']?></a></p></div>
<div class="clear"></div>
  <?php include 'includes/dashboard_menu.php';?>
  <!-- left side-->
  <!--middle -->
 <div class="profile_right">
    <div id="wrapper_3">
	<div class="balence"><span><?=$lang['BAL_H']?>: </span><?=$paypal_settings['silver_member_currency']?> <?php print $balsum;?></div>
  
	
   		<!-- <ul class="tabs">      
			<li><a href="<?=$vpath?>payment/dsp/" class="selected"><?=$lang['DEPOSIT_FUNDS']?></a></li>
			<li><a href="<?=$vpath?>milestone.html" ><?=$lang['MILDSTONE']?></a></li>
			<li><a href="<?=$vpath?>withdraw.html" ><?=$lang['WITHDRAW_FUND']?></a></li>
			<li><a href="<?=$vpath?>transaction_history.html" ><?=$lang['TRANSACTION_HISTORY']?></a></li>
                        <li><a href="<?= $vpath ?>membership.html" ><?= $lang['MEMBERSHIP'] ?></a></li>						<li><a  href="<?= $vpath ?>gift.html" ><?= $lang['GIVE_BONUS'] ?></a></li>
		</ul> -->
		<div class="browse_tab-content"> 
            <div class="browse_job_middle">
				
       <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
           <tr>
          <td>
              <table width="100%" cellpadding="8" cellspacing="0" border="0">
                <tbody>
                  <tr class="tbl_bg_4">
                    <td width="20%" style="margin-left:22px;"><strong style="margin-left:10px;"><?=$lang['METHOD']?></strong></td>
                    <td width="30%" align="left"><strong  style="margin-left:22px"></strong></td>
                    <td width="30%" align="left"><strong><?=$lang['AMOUNT']?></strong></td>
                    <td width="50%" align="left"><strong style="margin-left:30px;"><?=$lang['ACTIONS']?></strong></td>
                  </tr>
				  
				  <tr class="tbl_bg2">
                    <td class="space" align="left"><strong>&nbsp;&nbsp;<?=$lang['PAYPAL']?></strong><br /><br />
                     <img src="images/check.png" width="113" height="30" /></td>
                    <td align="left" class="space" >
						<?php
						
							if($rw1['depositpp_method']=='F')
						
							{ $charges_pp = $paypal_settings['silver_member_currency']." ".$rw1['depositpp_charges'];}
						
							elseif($rw1['depositpp_method']=='P')
						
							{ $charges_pp = $rw1['depositpp_percent'].' %';}
						
						?>
                      <ul style="margin-right:20px;">
                      <li><?=$lang['AVAIL_IMMEDIATE']?> </li>
                      <li><?=$lang['PAY_IN_USD']?></li> 
                      <li><?=$lang['SAFE']?></li>
                      </ul>
                      </td>
                      <td  class="space" align="left">
                      
					  <form name="depositpayment_frm" action="<?=$vpath?>paypal.html" method="post">
					  <span style="float: left;padding-top: 12px;"><b >$ &nbsp;</b></span> <input type="text" name="depositamt_txt" value="0" id="depositamt_txt" class="from_input_box1" style="width:110px;" />
					  </form>
                      </td>
                    <td class="space" align="left">
                      <button class="submit_bott btn-custom-blue" style="margin-left:5px;" onclick="chkfrm()">&nbsp; <?=$lang['PAY']?> &nbsp;</button>
                   </td>
                  </tr>
				  
				  <tr class="tbl_bg3"><td colspan="3">&nbsp;</td></tr>
                  
                </tbody>
              </table>
            <!------------------------------------------------------------------------------------------->
          </td>
        </tr>
        <!--------------------------------------------Middle Body End----------------------------------------------------->
      </table>
	  
		
	</div>
	</div></div></div>
<!--Profile Right End-->

</div>		  
</div></div>
<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>