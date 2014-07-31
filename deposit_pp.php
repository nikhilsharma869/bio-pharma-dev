<?php 
$current_page = "<p>Deposit Funds - Paypal Account</p>";

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
		alert('<?=$lang['ENT_DEPO_AMT_10']?>');
		document.getElementById('payAmount').focus();
		return false;
	}
document.depositpayment_frm.submit();
}
function myamt(amt)
{
	var m = parseFloat(amt);
	var fchrg = parseFloat(document.getElementById('chrgAmount').value);
	var pfee = parseFloat(document.getElementById('feAmount').value);
	if(isNaN(amt))
	{
		document.getElementById('payAmount').value = '0.00';
		if(document.getElementById('chrgAmounttype').value=='P')
		{
			document.depositpayment_frm.pchargesp_txt.value = '0.00';
		}
		document.getElementById('pyplfee').value = '0.00';
		document.getElementById('depamt').value = '0.00';
	}
	else if(m>0)
	{
		if(document.getElementById('chrgAmounttype').value=='F')
		{
			var fee = ((m+fchrg)*pfee)/100;
			var chrg = m+fchrg+fee+0.10;
			document.getElementById('pyplfee').value = fee;
			document.getElementById('depamt').value = chrg.toFixed(2);
		}
		else if(document.getElementById('chrgAmounttype').value=='P')
		{
			var temp = (m*fchrg)/100;
			var fee = ((m+temp)*pfee)/100;
			var chrg = m+temp+fee+0.10;
			document.depositpayment_frm.pchargesp_txt.value = temp.toFixed(2);
			document.getElementById('pyplfee').value = fee;
			document.getElementById('depamt').value = chrg.toFixed(2);
		}
				
	}
	else if((m<1)||(amt==''))
	{
		document.getElementById('payAmount').value = '0.00';
		if(document.getElementById('chrgAmounttype').value=='P')
		{
			document.depositpayment_frm.pchargesp_txt.value = '0.00';
		}
		document.getElementById('pyplfee').value = '0.00';
		document.getElementById('depamt').value = '0.00';
	}
}
</script>

<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>">Home</a> | <a href="javascript:void(0);" class="selected"><?php echo currentPageName($current_page); ?></a></p></div>
<div class="clear"></div>
<?php include 'includes/leftpanel1.php';?> 
    <!-- left side-->
    <!--middle -->
<div class="profile_right">
	<div id="wrapper_3">
	
	<!--<ul>
	<li ><a href="profile.php">Update Profile</a></li>
	<li ><a href="select-expertise.php">Update Expertise</a></li>
	<li ><a href="upload-portfolio.php">Update Portfoolio</a></li>
	
	
	</ul>-->
	
   
   		<ul class="tabs">      
			<li><a href="<?=$vpath?>payment/dsp/" class="selected"><?=$lang['DEPOSIT_FUNDS']?></a></li>
			<li><a href="<?=$vpath?>milestone.html" ><?=$lang['MILDSTONE']?></a></li>
			<li><a href="<?=$vpath?>withdraw.html" ><?=$lang['WITHDRAW_FUND']?></a></li>
			<li><a href="<?=$vpath?>transaction_history.html" ><?=$lang['TRANSACTION_HISTORY']?></a></li>
		</ul>
		<div class="balence"><span><?=$lang['BALANCE']?> :</span> <?php print $balsum;?></div>
            <div class="browse_tab-content"> 
            <div class="browse_job_middle">
    

<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->

            <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
         
<!------------------------------------------------Middle Body-------------------------------------------------------------->
            <tr>
            	<td>
<!----------------------------------------------------------------------------------------------------------->

<?php $rescc = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));?>
<form name="depositpayment_frm" action="<?=$vpath?>paypal.html" method="post">
<?php
$charges_pp = 0.00;
	if($rescc['depositpp_method']=='F')
	{ $charges_pp = $rescc['depositpp_charges'];}
	elseif($rescc['depositpp_method']=='P')
	{ $charges_pp = $rescc['depositpp_percent'];}
?>
<input type="hidden" id="chrgAmounttype" name="chargetype_txt" value="<?php print $rescc['depositpp_method'];?>" />
<input type="hidden" id="chrgAmount" name="charge_txt" value="<?php print $charges_pp;?>" />
<input type="hidden" id="feAmount" name="pfees_txt" value="<?php print $rescc['depositpp_fees'];?>" />
<input type="hidden" name="pmttype" value="Paypal Account Deposit" />
<table  width="100%" cellpadding="8" cellspacing="0" border="0" > 
<tbody>
<tr class="tbl_bg_4"> 
	<td colspan="2"><?=$lang['PAY_USING_H']?></td>
</tr>
<tr class="tbl_bg2">
	<td style="width:200px;"><strong><?=$lang['ENTR_DEP_AMT_H']?></strong></td>
    <td><input id="payAmount" type="text" name="depositamt_txt" size="5" maxlength="5" onblur="return myamt(this.value);" class="from_input_box1"/>&nbsp;<b><?=$lang['USD']?></b>&nbsp;(<i><?=$lang['ENTR_10_USD_H']?></i>)</td>
</tr>
<tr class="tbl_bg2">
	<td style="width:200px;"><strong><?=$lang['PROCES_CHARGES']?></strong></td>
    <td>
<?php
    if($rescc['depositpp_method']=='F')
	{
?>
    	<input type="text" name="pcharges_txt"  size="10" value="<?php print $rescc['depositpp_charges'];?>" readonly="readonly" class="from_input_box1" />&nbsp;<b><?=$lang['FIXED_USD_H']?></b>
<?php
	}
	elseif($rescc['depositcc_method']=='P')
	{
?>
		<input type="text" name="pchargesp_txt"  size="10" readonly="readonly" class="from_input_box1" />&nbsp;&nbsp;<?php print '@ '.$rescc['depositpp_percent'];?>&nbsp;%
<?php
	}
?>
    </td>
</tr>
<tr class="tbl_bg2">
	<td style="width:200px;"><strong><?=$lang['PAYPAL_FEES']?></strong></td>
    <td><input type="text" id="pyplfee" name="paypalfees_txt"  size="10" readonly="readonly" class="from_input_box1" />&nbsp;&nbsp;<?php print '@ '.$rescc['depositpp_fees'];?>&nbsp;%</td>
</tr>
<tr class="tbl_bg2">
	<td style="width:200px;"><strong><?=$lang['TOT_AMT_PAYABLE_H']?></strong></td>
    <td><input type="text" id="depamt" name="totalamt_txt"  size="10" readonly="readonly" class="from_input_box1"/>&nbsp;<b><?=$lang['USD']?></b></td>
</tr>
<tr class="tbl_bg2">
	<td style="width:200px;"><img src="<?=$vpath?>images/paypal_logo_reflection.png" /></td>
    <td valign="center"><input type="button" name="ccpay" class="submit_bott" onclick="return chkfrm();" value="<?=$lang['SUBMIT']?>" /></td>
</tr>
</tbody>
</table>
  </form>
<!----------------------------------------------------------------------------------------------------------->
                </td>
            </tr>
<!------------------------------------------------Middle Body End---------------------------------------------------------->
            </table>
        
<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------>

<hr />
 <table width="100%" cellpadding="8" cellspacing="0" border="0" > 
 <tbody>
<tbody>
<tr class="tbl_bg2"><td colspan="6"><h2 ><?=$lang['PAY_ACC_DEPOSIT']?></h2> </td></tr>
 <tr class="tbl_bg_4">  
	<td width="13%"><?=$lang['DATE']?></td> 
	<td width="16%"><?=$lang['PAY_TRAN_ID']?></td> 
	<td width="11%"><?=$lang['RECEIVER']?></td>
	<td width="10%"><?=$lang['JOB_CAT3']?></td> 
	<td width="8%"><?=$lang['CREDIT_DEBIT']?></td>
    <td width="11%"><?=$lang['AMT_H']?></td>
</tr> 
<?php
$restrntab = mysql_query("select * from ".$prev."transactions where user_id='".$_SESSION['user_id']."' and details='Paypal Account Deposit' order by add_date desc");
if(mysql_num_rows($restrntab)>0)
{
	while($rwtrntab=mysql_fetch_array($restrntab))
	{
		$rwpptran = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings")); 
	?>
		<tr class="tbl_bg2">  
			<td><?php print date('d-m-Y H:i:s',strtotime($rwtrntab['add_date']));?></td> 
			<td><?php print $rwtrntab['paypaltran_id'];?></td> 
			<td><?php print $rwpptran['ppemailaddr'];?></td> 
			<td><?php if($rwtrntab['status']=='P'){print "<font color='#FF0000'><b>Pending</b></font>";}elseif($rwtrntab['status']=='Y'){print "<font color='#009900'><b>Completed</b></font>";}?></td>
			<td align="center"><?php print $rwtrntab['amttype'];?></td>
			<td><?=$curn?><?php print $rwtrntab['amount'];?></td>
		</tr>
	<?php
	}
}
else
{
?>
	<tr class="tbl_bg2"><td colspan="6" align="center"><b><?=$lang['NO_REC_FOUND_H']?></b></td></tr>
<?php
}
?> 
</tbody>
</table>
    
</div>
</div>

</div>
<!--Profile Right End-->

</div>		  

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>