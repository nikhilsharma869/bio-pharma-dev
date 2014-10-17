<?php 
$current_page="Withdraw Funds";
include "includes/header.php";

CheckLogin();

?>
<?php

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

$row=mysql_fetch_array($res);

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));

$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));
$balsum = (float)$rwbal['balsum1']-(float)$rwbal2['baldeb'];

$sum=0;

$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");

while($row4pend=mysql_fetch_array($res4pend))

{

	$sum+=$row4pend['amount'];

}

$sum1=number_format($sum,2);

?>
<link rel="stylesheet" type="text/css" href="<?=$vpath?>highslide/highslide.css" />
<script type="text/javascript" src="<?=$vpath?>highslide/highslide-with-html.js"></script>
<script type="text/javascript">

	hs.graphicsDir = '<?=$vpath?>highslide/graphics/';

	hs.outlineType = 'rounded-white';

	hs.wrapperClassName = 'draggable-header';

	hs.minWidth = 300;

	hs.creditsText = '<i><?=$lang['ENT_VLD_EMAIL_ID_H']?></i>';

</script>
<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="<?=$vpath?>payment/dsp/"><?=$lang['My_finance']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['WITHDRAW_FUNDS']?></a></p></div>
<div class="clear"></div>
    <?php include 'includes/dashboard_menu.php';?>
  <!-- left side-->
  <!--middle -->
  <div class="profile_right">
  
  <div id="wrapper_3">
     <div class="balence"><span><?=$lang['BALANCE']?>:</span> <?=$curn?> <?php echo number_format($balsum,2)?></div>
   
   
   <!--  <ul class="tabs">      
			<li ><a href="<?=$vpath?>payment/dsp/" ><?=$lang['DEPOSIT_FUNDS']?></a></li>
			<li><a href="<?=$vpath?>milestone.html" ><?=$lang['MILDSTONE']?></a></li>
			<li><a class="selected" href="withdraw.html" ><?=$lang['WITHDRAW_FUNDS']?></a></li>
			<li><a href="<?=$vpath?>transaction_history.html" ><?=$lang['TRANSACTION_HISTORY']?></a></li>
                        <li><a href="<?= $vpath ?>membership.html" ><?= $lang['MEMBERSHIP'] ?></a></li>						<li><a  href="<?= $vpath ?>gift.html" ><?= $lang['GIVE_BONUS'] ?></a></li>
		</ul> -->
		<div class="clear"></div>
    <div class="latest_text latest_text_new"><h1><?=$lang['WITHDRAW_FUNDS']?></h1></div>
		<div class="browse_tab-content"> 
            <div class="browse_job_middle">

      <table cellpadding="0" cellspacing="0" border="0"  width="100%" align = "center" >
        <tr>
          <td>
		
		  <?php

$charges_cc = '';

$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

?>
            <table width="100%" cellpadding="8" cellspacing="0" border="0">
              <tbody>
                <tr class="tbl_bg_4">
                  <td width="20%" align="left" valign="middle"><strong><?=$lang['METHOD']?></strong></td>
                  <td width="20%" align="left" valign="middle"><strong><?=$lang['FEES']?></strong></td>
                  <td width="30%" align="left" valign="middle"><strong><?=$lang['ACCOUNT']?></strong></td>
                  <td width="15%" align="left" valign="middle"><strong><?=$lang['WITHDRAW']?></strong></td>
                  <td width="15%" align="left" valign="middle"><strong><?=$lang['ACTIONS']?></strong></td>
                </tr>
	
				<?php if($rw1['withdraw_payoneer']=='Y') {?>
                        <tr class="tbl_bg2">
                  <td align="left" valign="middle" style="color:#6d6d6d"><strong>&nbsp;<?=$lang['PAYONEER']?></strong></td>
                        <td align="left" valign="middle"  class="tblboder1"><strong><?php print $rw1['withdraw_payoneer_charge'];?><?=$curn?></strong><span lang="en">&nbsp;<?=$lang['PER_WITHDRAWL']?>.</span></td>
                     <td align="left" valign="middle"  class="tblboder1"><?php if($row['user_payoneeracc']=='N') {?>
                           <?=$lang['NOT_REGISTER']?>
                          <?php } else {?>
                          <font color="#1b4471"><?php print $row['user_payoneeracc'];?></font>
                          <?php }?>                        </td>
                        <td align="left" valign="middle"  class="tblboder1"><?php if($row['user_payoneeracc']=='N') {?>
                          - -
                          <?php } else {?>
                          <a href="<?=$vpath?>withdrawfund/py/" lang="en"><?=$lang['CLICK_HERE']?></a>
                          <?php }?>                        </td>
          <td align="left" valign="middle"  class="tblboder1"><?php if($row['user_payoneeracc']=='N') {?>
                                <a href="withdraw_pyon.php" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="button-small" lang="en"><?=$lang['ADD_ACCOUNT']?></a>
                                <?php } else {?>
                                <a href="withdraw_pyon.php" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="button-small" lang="en"><?=$lang['EDIT_ACCOUNT']?></a>
                                <?php }?>                        </td>
                    </tr>
                      <?php }
if($rw1['withdraw_moneybooker']=='Y') {?>
                      <tr class="tbl_bg2">
                  <td align="left" valign="middle" style="color:#6d6d6d"><strong><?=$lang['MONEY_BOOKERS']?></strong></td>
                        <td align="left" valign="middle"  class="tblboder1"><strong><?php print $rw1['withdraw_moneybooker_charge'];?><?=$curn?></strong><span lang="en">&nbsp;<?=$lang['PER_WITHDRAWL']?></span></td>
                        <td align="left" valign="middle"  class="tblboder1"><?php if($row['user_moneybookeracc']=='N') {?>
                         <?=$lang['NOT_REGISTER']?>
                          <?php } else {?>
                          <font color="#1b4471"><?php print $row['user_moneybookeracc'];?></font>
                          <?php }?>                        </td>
                        <td align="left" valign="middle"  class="tblboder1"><?php if($row['user_moneybookeracc']=='N') {?>
                          - -
                          <?php } else {?>
                          <a href="<?=$vpath?>withdrawfund/m/" lang="en" class="link_class"><?=$lang['CLICK_HERE']?></a>
                          <?php }?>                        </td>
          <td align="left" valign="middle"  class="tblboder1"><?php if($row['user_moneybookeracc']=='N') {?>
                                <a href="withdraw_mnb.php" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="button-small" lang="en"><?=$lang['ADD_ACCOUNT']?></a>
                                <?php } else {?>
                                <a href="withdraw_mnb.php" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="link_class" lang="en"><?=$lang['EDIT_ACCOUNT']?></a>
                                <?php }?>                        </td>
                    </tr>
                      <?php }
if($rw1['withdraw_paypal']=='Y') {?>
                <tr class="tbl_bg2">
                  <td align="left" valign="middle" style="color:#6d6d6d"><strong><?=$lang['PAYPAL']?></strong></td>
                  <td align="left" valign="middle"><strong><?php print $rw1['withdraw_paypal_charge'];?> <?=$curn?> </strong> <?=$lang['PER_WITHDRAWL']?></td>
                  <td align="left" valign="middle"><?php if($row['user_paypalacc']=='N') {?>
                    <?=$lang['NOT_REGISTER']?>
                    <?php } else {?>
                    <font color="#1b4471"><?php print $row['user_paypalacc'];?></font>
                    <?php }?>                  </td>
                  <td align="left" valign="middle"><?php if($row['user_paypalacc']=='N') {?>
                    - -
                    <?php } else {?>
                    <a href="<?=$vpath?>withdrawfund/p/" class="link_class"><?=$lang['CLICK_HERE']?></a>
                    <?php }?>                  </td>
                  <td align="left" valign="middle"><?php if($row['user_paypalacc']=='N') {?>
                    <a href="withdraw_pp.php" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="link_class"><?=$lang['ADD_ACCOUNT']?></a>
                    <?php } else {?>
                    <a href="withdraw_pp.php" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="link_class"><?=$lang['EDIT_ACCOUNT']?></a>
                    <?php }?>                  </td>
                </tr>
                <?php } if($rw1['withdraw_wired']=='Y') {?>
                       <tr class="tbl_bg2">
                  <td align="left" valign="middle" style="color:#6d6d6d"><strong><?=$lang['WIRE']?></strong></td>
                        <td align="left" valign="middle"><strong><?php print $rw1['withdraw_wired_charge'];?><?=$curn?></strong>&nbsp;<?=$lang['PER_WITHDRAWL']?></td>
                         <td align="left" valign="middle"><?php if($row['user_wiredacc']=='N' || $row['user_wiredacc']=='') {?>
                        <?=$lang['NOT_REGISTER']?>
                          <?php } else {?>
                          <font color="#1b4471"><?=$lang['VERIFIED']?></font>
                          <?php }?>                        </td>
                        <td align="left" valign="middle"  ><?php if($row['user_wiredacc']=='N'  || $row['user_wiredacc']=='') {?>
                          - -
                          <?php } else {?>
                          <a href="<?=$vpath?>withdrawfund/wired/" lang="en" class="link_class"><?=$lang['CLICK_HERE']?></a>
                          <?php }?>                        </td>
          <td align="left" valign="middle" ><?php if($row['user_wiredacc']=='N'  || $row['user_wiredacc']=='') {?>
                                <a href="<?=$vpath?>wire_tran.html" class="link_class" ><?=$lang['ADD_ACCOUNT']?></a>
                                <?php } else {?>
                                <a href="<?=$vpath?>wire_tran.html" class="link_class" ><?=$lang['EDIT_ACCOUNT']?></a>
                                <?php }?>                        </td>
                    </tr>
                      <?php }?>
              </tbody>
            </table></td>
        </tr>
      </table>
	  
</div></div></div>
  </div>
</div>
</div>
</div>
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?>
