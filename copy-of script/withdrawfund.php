<?php 
include "includes/header.php";
CheckLogin();
?>
<?php
$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);
$res1=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
$row1=mysql_fetch_array($res1);

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));
$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));
$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);
$balsum_sum = $rwbal['balsum1']-$rwbal2['baldeb'];
$sum=0;
$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");
while($row4pend=mysql_fetch_array($res4pend))
{
	$sum+=$row4pend['amount'];
}
$sum1=number_format($sum,2);
?>


<script type="text/javascript">
function chkfrm()
{
	if((document.getElementById('payAmount').value=='')||parseFloat(document.getElementById('payAmount').value)<10.00)
	{
		alert('Please enter deposit amount atleast 10 USD');
		document.getElementById('payAmount').focus();
		return false;
	}
	else
	{
		//alert('abhik');
		//document.withdrawfund_frm.submit();
		return true;
	}
}
function myamt(amt)
{
	var m = parseFloat(amt);
	var fchrg = parseFloat(document.getElementById('chrgAmount').value);
	//var pfee = parseFloat(document.getElementById('feAmount').value);
	if(isNaN(amt))
	{
		document.getElementById('payAmount').value = '0.00';
		document.getElementById('depamt').value = '0.00';
	}
	else if(m>0)
	{
		if(m>parseFloat(document.getElementById('pbal').value))
		{
			alert('You cannot withdraw more than your deposit amount');
			document.getElementById('payAmount').value='';
			document.getElementById('payAmount').focus();
		}
		else
		{
			var chrg = m-fchrg;
			document.getElementById('payAmount').value = m.toFixed(2);
			document.getElementById('depamt').value = chrg.toFixed(2);
		}
				
	}
	else if((m<1)||(amt==''))
	{
		document.getElementById('payAmount').value = '0.00';
		document.getElementById('depamt').value = '0.00';
	}
}
</script>
<style type="text/css">

.loginbuttonloginnow{
   background:url(images/paypal_button.png) no-repeat;
   height:46px;
   width:160px;
   border:none;
   font-size:18px;
   line-height:46px;
   color:#FFFFFF;
   font-weight:bold;
   cursor:pointer;
   }
.mytable_payments
{
	color:#2f5b67;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
.mytable_payments td
{
	border-bottom:1px dotted #2f5b67; height:25px;
}
</style>

<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="<?=$vpath?>payment/dsp/"><?=$lang['My_finance']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['WITHDRAW_FUND']?></a></p></div>
<div class="clear"></div>
<?php include 'includes/leftpanel1.php';?> 
 <div class="profile_right">
    <div id="wrapper_3">
	<div class="balence"><span><?=$lang['BAL_H']?>:</span><?=$paypal_settings['silver_member_currency']?><?php print $balsum;?></div>
  
	
   		<ul class="tabs">      
			<li><a href="<?=$vpath?>payment/dsp/" ><?=$lang['DEPOSIT_FUNDS']?></a></li>
			<li><a href="<?=$vpath?>milestone.html" ><?=$lang['MILDSTONE']?></a></li>
			<li><a href="<?=$vpath?>withdraw.html" class="selected"><?=$lang['WITHDRAW_FUND']?></a></li>
			<li><a href="<?=$vpath?>transaction_history.html" ><?=$lang['TRANSACTION_HISTORY']?></a></li>
			<li><a href="<?=$vpath?>membership.html" >Membership</a></li>
		</ul>
		<div class="browse_tab-content"> 
            <div class="browse_job_middle">
		<table cellpadding="0" cellspacing="0" border="0" style="color:#6d6d6d; font-size:12px;" width="100%" align = "center" >
            
<!------------------------------------------------Middle Body-------------------------------------------------------------->
            <tr>
            	<td>
<!----------------------------------------------------------------------------------------------------------->
<?php
$charges_cc = '';
$str = '';
$str1 = '';
$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
?>
<form name="withdrawfund_frm" action="<?=$vpath?>withdrawfundsql.html" method="post">
<?php
	if($_GET['meth']=='p')
	{ 
		$str = 'Paypal';
		$str1 = 'Paypal Withdraw';
		$charges_cc = $rw1['withdraw_paypal_charge'];
	}
	elseif($_GET['meth']=='m')
	{ 
		$str = 'Withdrawal Method - Moneybookers';
		$str1 = 'Moneybookers Withdraw';
		$charges_cc = $rw1['withdraw_moneybooker_charge'];
	}
	elseif($_GET['meth']=='py')
	{ 
		$str = 'Withdrawal Method - Payoneer';
		$str1 = 'Payoneer Withdraw';
		$charges_cc = $rw1['withdraw_payoneer_charge'];
	}
	elseif($_GET['meth']=='wired')

	{ 

		$str = 'Withdrawal Method - Wire Transfer';

		$str1 = 'Wire Transfer';

		$charges_cc = $rw1['withdraw_wired_charge'];

	}
?>
<input type="hidden" name="pmttype" value="<?php print $str1;?>" />
<input type="hidden" name="pmttypeb" value="<?php print $_GET['meth'];?>" />
<table  width="100%" cellpadding="8"> 
<tbody>
<tr class="tbl_bg_4"><td colspan="2"><?php print $str;?></td></tr>
<tr>
	<td style="width:200px;"><strong><?=$lang['BANANCE_AMOUNT']?></strong>   <b><?=$lang['USD']?></b></td>
    <td><input type="text" id="pbal" name="pbal_txt"  size="10" value="<?php print $balsum;?>" readonly="readonly" style="border:none;" class="from_input_box1"/>&nbsp;
<input type="hidden" value="<?php echo $balsum_sum; ?>" id="pbalsum" /></td>
</tr>
<tr>
	<td style="width:200px;"><strong><?=$lang['EW_Amount']?></strong></td>
    <td><input id="payAmount" type="text" name="depositamt_txt" size="10" onblur="return myamt(this.value);" class="from_input_box1"/></td>
</tr>
<tr>
	<td style="width:200px;"><strong><?=$lang['PROCES_CHARGES']?></strong><b><?=$lang['U_Fxd']?></b></td>
    <td>
    	<input type="text" id="chrgAmount" name="pcharges_txt"  size="10" value="<?php print $charges_cc;?>" readonly="readonly" style="border:none;" class="from_input_box1"/>&nbsp;
 </td>
</tr>
<tr>
	<td style="width:200px;"><strong><?=$lang['N_Amo']?></strong>   <b><?=$lang['USD']?></b></td>
    <td><input type="text" id="depamt" name="totalamt_txt"  size="10" readonly="readonly" class="from_input_box1" />&nbsp;</td>
</tr>
<tr>
	<td style="width:200px;">
    <?php
	if($_GET['meth']=='p')
	{ ?> <img src="<?=$vpath?>images/paypal_logo_reflection.png" /> <?php }
	elseif($_GET['meth']=='m')
	{ ?> <img src="<?=$vpath?>images/moneybookers_logo.png" /> <?php }
	elseif($_GET['meth']=='py')
	{ ?> <img src="<?=$vpath?>images/payoneer-logo.png" /> <?php }
?>
    </td>
    <td valign="center"><input type="submit" name="with_sub" value="<?=$lang['SUBMIT']?>" class="submit_bott"  onclick="return chkfrm();" /></td>
</tr>
</tbody>
</table></form>
<!----------------------------------------------------------------------------------------------------------->
                </td>
            </tr>
<!------------------------------------------------Middle Body End---------------------------------------------------------->
            </table>
    
    	
<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------>

    <!--end middle--> 
    <!-- rightside-->
    <!-- end rightside-->

<!---------------------------------------------------------------------------------------------------------------------------->
 
 <table width="100%" cellpadding="3" cellspacing="0" border="0"> 
 
 <tr class="tbl_bg_4"><td colspan="7">&nbsp; <?=$lang['WITHDRAW_LIST']?></td></tr>
 <tr class="tbl_bg_4">  
	<td width="13%" align=left>&nbsp;<?=$lang['DATE']?></td> 
	<td width="13%" align=left><?=$lang['TRANSACTION_ID']?></td> 
	<td width="18%" align=left><?=$lang['DESCRIPTION']?></td>  
	<td width="8%" align=left><?=$lang['TYPE']?></td>
	<td width="10%" align=left><?=$lang['STATUS']?></td> 
	
	
	
	<td width="8%"><?=$lang['AMOUNT']?></td>
    <td width="11%"><?=$lang['BALANCE']?></td>
</tr> 
<?php
$restrntab = mysql_query("select * from ".$prev."transactions where user_id='".$_SESSION['user_id']."' and (details='Paypal Withdraw' or details='Moneybookers Withdraw' or details='Payoneer Withdraw') order by add_date desc");
if(mysql_num_rows($restrntab)>0)
{
	while($rwtrntab=mysql_fetch_array($restrntab))
	{
		$rwpptran1 = mysql_fetch_array(mysql_query("select * from ".$prev."withdrawals where paypaltran_id='".$rwtrntab['paypaltran_id']."'"));

		$rwpptran2 = mysql_fetch_array(mysql_query("select * from ".$prev."deposits where paypaltran_id='".$rwtrntab['paypaltran_id']."'"));
	?>
		<tr class="tbl_bg2">  
			<td style="color:6d6d6d;" align=left><?php print date('M d, Y H:i:s',strtotime($rwtrntab['add_date']));?></td> 
			<td style="color:6d6d6d;" align=left><?php print $rwtrntab['paypaltran_id'];?></td>
            <td style="color:6d6d6d;" align=left><?php print $rwtrntab['details'].' - '.ucwords($rwpptran1['status']);?></td>
			<td style="color:6d6d6d;" align=left><?php print $rwtrntab['amttype'];?></td> 
			<td style="color:6d6d6d;" align=left><?php if($rwtrntab['status']=='P'){print "<font color='#FF0000'><b>".$lang['PENDING']."</b></font>";}elseif($rwtrntab['status']=='Y'){print "<font color='#009900'><b>".$lang['COMPLETED']."</b></font>";}?></td>
			<td style="color:6d6d6d;" align=left>$<?php print $rwpptran2['amount'];?></td>
			<td style="color:6d6d6d;" align=left>$<?php print $rwpptran1['amount'];?></td>
		</tr>
	<?php
	}
}
else
{
?>
	<tr class="tbl_bg2"><td colspan="7" align="center"><strong><?=$lang['NO_RECORD_FOUND']?></strong></td></tr>
<?php
}
?> 
</tbody>
</table>
    
    </div>

</div>
</div>


</div>
</div>
</div>
</div>
<?php include 'includes/footer.php';?> 
</body>
</html>