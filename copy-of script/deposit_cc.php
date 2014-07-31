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
	/*color:#2f5b67;*/
	color:#a1282c;
	font-family:"Tahoma" ,Arial,Verdana,Sans-serif;
	font-size:12px;
}
.mytable_payments td
{
	border-bottom:1px dotted #2f5b67; height:25px;
}

</style>

<!-----------Header End-----------------------------> 

<!-- content-->
<div class="freelancer">


<!--Profile-->
<?php include 'includes/leftpanel1.php';?> 
    <!-- left side-->
    <!--middle -->
	
<div class="profile_right">
	<div class="edit_profile">
	<h2>Welcome <?php print $_SESSION['fullname'];?><br />
	<span>Your last login was on <?=mysqldate_show($_SESSION[ldate],1)?></span></h2>
	
	<div align="right" style="padding-right:10px; font-family:"Tahoma" ,Arial,Verdana,Sans-serif;">
	Balance  :  $ <strong><?php print $balsum;?></strong><br />
	Pending Transactions  :  $ <strong><?php print $sum1;?></strong>
	</div>
	<!--<ul>
	<li ><a href="profile.php">Update Profile</a></li>
	<li ><a href="select-expertise.php">Update Expertise</a></li>
	<li ><a href="upload-portfolio.php">Update Portfoolio</a></li>
	
	
	</ul>-->
	</div>
   
   
    <div class="edit_form_box">

<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->

            <table cellpadding="0" cellspacing="0" border="0" style="color:#a1282c; font-size:14px; font-family:"Tahoma" ,Arial,Verdana,Sans-serif;" width="90%" align="center" >
            <tr><td height="10px;"></td></tr>
<!------------------------------------------------Middle Body-------------------------------------------------------------->
            <tr>
            	<td>
<!----------------------------------------------------------------------------------------------------------->
<h3 style="margin-left:5px;">Deposit Funds - Credit/Debit Card</h3><br />
<?php $rescc = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));?>
<form name="depositpayment_frm" action="paypal.php" method="post">
<?php
$charges_cc = 0.00;
	if($rescc['depositcc_method']=='F')
	{ $charges_cc = $rescc['depositcc_charges'];}
	elseif($rescc['depositcc_method']=='P')
	{ $charges_cc = $rescc['depositcc_percent'];}
?>
<input type="hidden" id="chrgAmounttype" name="chargetype_txt" value="<?php print $rescc['depositcc_method'];?>" />
<input type="hidden" id="chrgAmount" name="charge_txt" value="<?php print $charges_cc;?>" />
<input type="hidden" id="feAmount" name="pfees_txt" value="<?php print $rescc['depositcc_fees'];?>" />
<input type="hidden" name="pmttype" value="Credit Card Deposit" />
<table  width="100%" cellpadding="8" style="color:#4E4D4D;"> 
<tbody>
<tr style="background-color:whitesmoke; height:40px;"> 
	<td colspan="2">Pay Using Credit / Debit Card Via Paypal</td>
</tr>
<tr>
	<td style="width:200px;"><strong>Enter Deposit Amount</strong></td>
    <td><input id="payAmount" type="text" name="depositamt_txt" size="10" onblur="return myamt(this.value);"/>&nbsp;<b>USD</b>&nbsp;(<i>enter atleast $10</i>)</td>
</tr>
<tr>
	<td style="width:200px;"><strong>Processing Charges</strong></td>
    <td>
<?php
    if($rescc['depositcc_method']=='F')
	{
?>
    	<input type="text" name="pcharges_txt"  size="10" value="<?php print $rescc['depositcc_charges'];?>" readonly="readonly" />&nbsp;<b>USD (Fixed)</b>
<?php
	}
	elseif($rescc['depositcc_method']=='P')
	{
?>
		<input type="text" name="pchargesp_txt"  size="10" readonly="readonly" />&nbsp;&nbsp;<?php print '@ '.$rescc['depositcc_percent'];?>&nbsp;%
<?php
	}
?>
    </td>
</tr>
<tr>
	<td style="width:200px;"><strong>Paypal Fees</strong></td>
    <td><input type="text" id="pyplfee" name="paypalfees_txt"  size="10" readonly="readonly" />&nbsp;&nbsp;<?php print '@ '.$rescc['depositcc_fees'];?>&nbsp;%</td>
</tr>
<tr>
	<td style="width:200px;"><strong>Total Deductable Amount</strong></td>
    <td><input type="text" id="depamt" name="totalamt_txt"  size="10" readonly="readonly" />&nbsp;<b>USD</b></td>
</tr>
<tr>
	<td style="width:200px;"><img src="images/cc_mb.gif" /></td>
    <td valign="bottom"><input type="button" name="ccpay" class="submit_bott" value="Submit" onclick="return chkfrm();" /></td>
</tr>
</tbody>
</table>
  </form> 
<!----------------------------------------------------------------------------------------------------------->
                </td>
            </tr>
<!------------------------------------------------Middle Body End---------------------------------------------------------->
            </table>
     </div>
    

<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------>

    <!--end middle--> 
    <!-- rightside-->
    <!-- end rightside-->

<!---------------------------------------------------------------------------------------------------------------------------->
<div style="width:95%; padding-left:10px;">
<h4 style="color:#a1282c;font-family:"Tahoma" ,Arial,Verdana,Sans-serif;">Credit Card Deposits</h4> 
 <table width="95%" cellpadding="8" class="mytable_payments" style="color:#4E4D4D;"> 
 <tbody>
<tbody>
 <tr style="background-color:whitesmoke; height:40px;">  
	<td width="13%">Date</td> 
	<td width="16%">Paypal Transaction ID</td> 
	<td width="11%">Receiver</td>
	<td width="10%">Status</td> 
	<td width="8%">Debit/Credit</td>
    <td width="11%">Amount(USD)</td>
</tr> 
<?php
$restrntab = mysql_query("select * from ".$prev."transactions where user_id='".$_SESSION['user_id']."' and details='Credit Card Deposit' order by add_date desc");
if(mysql_num_rows($restrntab)>0)
{
	while($rwtrntab=mysql_fetch_array($restrntab))
	{
		$rwpptran = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_transactions where odeskclone_txn_id='".$rwtrntab['paypaltran_id']."'")); 
	?>
		<tr>  
			<td><?php print date('d-m-Y H:i:s',strtotime($rwtrntab['add_date']));?></td> 
			<td><?php print $rwpptran['paypal_txn_id'];?></td> 
			<td><?php print $rwpptran['receiver_email'];?></td> 
			<td><?php if($rwtrntab['status']=='P'){print "<font color='#FF0000'><b>Pending</b></font>";}elseif($rwtrntab['status']=='Y'){print "<font color='#009900'><b>Completed</b></font>";}?></td>
			<td align="center"><?php print $rwtrntab['amttype'];?></td>
			<td>$<?php print $rwtrntab['balance'];?></td>
		</tr>
	<?php
	}
}
else
{
?>
	<tr><td colspan="6" align="center"><b>No records found</b></td></tr>
<?php
}
?> 
</tbody>
</table>
    
    </div>
<!---------------------------------------------------------------------------------------------------------------------------->

</div>
</div>


</div>
</div>
</div>
</div>
<?php include 'includes/footer.php';?> 
</body>
</html>