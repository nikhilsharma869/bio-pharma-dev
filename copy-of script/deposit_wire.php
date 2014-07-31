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
echo "insert into ".$prev."wire_transfer (user_id,deposit_fee,bank_ac_no,bank_ac_name,bank_ifsc,street_address,city,country,add_date) values ('".$_SESSION['user_id']."', ".$_POST['depositamt_txt'].", '".$_POST['bank_ac']."', '".$_POST['ac_name']."', '".$_POST['ifsc']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['country']."', now())";

$insert_sql=mysql_query("insert into ".$prev."wire_transfer (user_id,deposit_fee,bank_ac_no,bank_ac_name,bank_ifsc,street_address,city,country,add_date) values ('".$_SESSION['user_id']."', ".$_POST['depositamt_txt'].", '".$_POST['bank_ac']."', '".$_POST['ac_name']."', '".$_POST['ifsc']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['country']."', now())");
if($insert_sql)
{
	$succ_msg="Your details is saved. Money will be transferred once your account will verified.";
}
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
<h3 style="margin-left:5px;">Deposit Funds - Wire Transfer</h3><br />
<?php $rescc = mysql_fetch_array(mysql_query("select * from ".$prev."wire_transfer where 1"));?>
<form name="depositpayment_frm"  method="post">

<input type="hidden" id="chrgAmount" name="charge_txt" value="<?php print $rescc['depositamt_txt'];?>" />
<input type="hidden" id="feAmount" name="pfees_txt" value="<?php print $rescc['deposit_fee'];?>" />
<input type="hidden" name="pmttype" value="Wire Deposit" />
<table  width="100%" cellpadding="8" style="color:#4E4D4D;"> 
<tbody>
<tr > 
	<td colspan="2"><?php if($succ_msg){echo $succ_msg;} ?></td>
</tr>
<tr style="background-color:whitesmoke; height:40px;"> 
	<td colspan="2">Pay Using Bank Transfer</td>
</tr>
<tr>
	<td style="width:200px;"><strong>Enter Deposit Amount</strong></td>
    <td><input id="payAmount" type="text" name="depositamt_txt" size="10" onblur="return myamt(this.value);"/>&nbsp;<b>USD</b>&nbsp;(<i>enter atleast $10</i>)</td>
</tr>

<tr>
	<td style="width:200px;"><strong>Bank A/C No</strong></td>
    <td><input type="text" id="bank_ac" name="bank_ac"  size="20" /></td>
</tr>
<tr>
	<td style="width:200px;"><strong>A/C Name</strong></td>
    <td><input type="text" id="ac_name" name="ac_name"  size="50" /></td>
</tr>
<tr>
	<td style="width:200px;"><strong>IFS Code</strong></td>
    <td><input type="text" id="ifsc" name="ifsc"  size="20" /></td>
</tr>
<tr>
	<td style="width:200px;"><strong>Street Address</strong></td>
    <td><input type="text" id="address" name="address"  size="50" /></td>
</tr>
<tr>
	<td style="width:200px;"><strong>City</strong></td>
    <td><input type="text" id="city" name="city"  size="50" /></td>
</tr>
<tr>
	<td style="width:200px;"><strong>Country</strong></td>
    <td><input type="text" id="country" name="country"  size="50" /></td>
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
<h4 style="color:#a1282c;font-family:"Tahoma" ,Arial,Verdana,Sans-serif;">Bank Transfer Deposits</h4> 
 <table width="95%" cellpadding="8" class="mytable_payments" style="color:#4E4D4D;"> 
 <tbody>
<tbody>
 <tr style="background-color:whitesmoke; height:40px;">  
	<td width="13%">Date</td> 
	<td width="16%">Transaction ID</td> 
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