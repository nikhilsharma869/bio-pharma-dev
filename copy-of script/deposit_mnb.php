<?php
session_start();
$current_page = "Deposit Funds - Moneybooker Account";
include("include/header.php");
include("country.php");
?>
<?php
include("include/header_menu.php");
CheckLogin();
?>
<?php
$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);
$res1=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
$row1=mysql_fetch_array($res1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Paypal Deposit</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
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

    
<!------Start-middle-------->
<div class="inner-middle">
<div class="dash_headding">
<p><a href="<?=$vpath?>index.html">Home</a> | <a href="<?=$vpath?>dashboard.html">Dashboard</a> | <a href="<?=$vpath?>membership_plan.html" class="selected">Membership Plan</a></p></div>
<div class="clear"></div>



<!--Dashboard Left Start-->
<div class="profile_left">
<div class="user_text">
<h1>Diposit</h1>
</div>

<?php include("include/leftpanel.php");?>

</div>



<!--Dashboard Left End-->


<!--Dashboard Right Start-->


<div class="latest_worbox">
<div class="testing_box">

   <h2>      	
    <ul class="job_tab">     
			<li><a href="<?=$vpath?>payment/dsp" class="selected">Deposit Funds</a></li>
			<li><a href="<?=$vpath?>milestone.html" >Milestone</a></li>
			<li><a href="<?=$vpath?>withdraw.html" >Withdraw Fund</a></li>
			<li><a href="<?=$vpath?>transaction_history.html" >Transaction History</a></li>
		</ul></h2>
  <div style="clear:both; height:10px;"></div>

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
 <div class="tab-content"> 
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="post_from">
    <tr>
      <td width="349" align="left" valign="top">Financial Account: <?php print ucwords($row['fname']).' '.ucwords($row['lname'])?><br /></td>
      <td width="609" align="left" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="177" height="32" align="left" valign="middle"><strong>Balance: $<?php print $balsum;?></strong></td>
          <td width="30" align="left" valign="middle" class="borderblue1">&nbsp;</td>
          <td width="400" align="left" valign="middle"><strong>Pending Transactions: $<?php print $sum1;?></strong></td>
        </tr>
        
      </table></td>
    </tr>
  </table>
</div>

<div style="clear:both;"></div>
<div class="content_div">
<table class="Body white-background " cellpadding="3" cellspacing="0" border="0" width="100%" id="TABLE_1">
  <tbody><tr>
          			
          
    <td valign="top" class="CellBody"><div class="curvearea6">
<h1>Moneybooker Payment Methods</h1>
   
<?php /*?><div id="header">
	<ul id="primary">
		<?php
		if($row['user_type']=='E')
		{
		?>
			<li><span>Payment Option</span></li>
		<?php
		}
		?>
		<?php
		if($row['user_type']=='E')
		{
		?>
			<li><a href="milestone.php"> Milestone Payment</a></li>
		<?php
		}
		if($row['user_type']=='E')
		{
		?>
		<li><a href="transfer.php">Transfer Money</a></li>
		<?php
		}
		?>
		<li><a href="withdraw.php">Withdraw Money</a></li>
		 <li><a href="acc_history.php"> Transfer History</a></li> 
	</ul>
	</div><?php */?>
<?php $rescc = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));?>
<form name="depositpayment_frm" action="moneybooker.php" method="post">
<?php
$charges_pp = 0.00;
	if($rescc['depositmnb_method']=='F')
	{ $charges_pp = $rescc['depositmnb_charges'];}
	elseif($rescc['depositmnb_method']=='P')
	{ $charges_pp = $rescc['depositmnb_percent'];}
?>
<input type="hidden" id="chrgAmounttype" name="chargetype_txt" value="<?php print $rescc['depositmnb_method'];?>" />
<input type="hidden" id="chrgAmount" name="charge_txt" value="<?php print $charges_pp;?>" />
<input type="hidden" id="feAmount" name="pfees_txt" value="<?php print $rescc['depositmnb_fees'];?>" />
<input type="hidden" name="pmttype" value="Moneybooker Deposit" />
<input type="hidden" name="email" id="email" value="<?=$row['email']?>"  />
<input type="hidden" name="userid" id="userid" value="<?=$row['user_id']?>"  />
<input type="hidden" name="firstname" id="firstname" value="<?=$row['fname']?>"  />
<div id="main">

		<div id="contents">
<table class="tblbordertab" name="tblbordertab" align="left"> 
<tbody>
<tr> 
	<th class="tblboder leftspace3" colspan="2">&nbsp;</th>
<!--	<th width="178" class="columnSubject">&nbsp;</th>
    <th width="211" class="columnSubject">Account</th>
    <th width="115" class="columnSubject">Status</th>
    <th width="161" class="columnDate">Actions</th>-->
</tr>
<tr>
	<td width="200" style="width:200px;">Enter Deposit Amount</td>
    <td width="547"><input id="payAmount" type="text" name="depositamt_txt" size="10" onblur="return myamt(this.value);"/>&nbsp;<b>USD</b>&nbsp;(<i>enter atleast $10</i>)</td>
</tr>
<tr>
	<td style="width:200px;">Processing Charges</td>
    <td>
<?php
    if($rescc['depositmnb_method']=='F')
	{
?>
    	<input type="text" name="pcharges_txt"  size="10" value="<?php print $rescc['depositmnb_charges'];?>" readonly="readonly" />&nbsp;<b>USD</b>
<?php
	}
	elseif($rescc['depositmnb_method']=='P')
	{
?>
		<input type="text" name="pchargesp_txt"  size="10" readonly="readonly" />&nbsp;&nbsp;<?php print '@ '.$rescc['depositmnb_percent'];?>&nbsp;%
<?php
	}
?>
    </td>
</tr>
<tr>
	<td style="width:200px;">Moneybookers Fees</td>
    <td><input type="text" id="pyplfee" name="paypalfees_txt"  size="10" readonly="readonly" />&nbsp;&nbsp;<?php print '@ '.$rescc['depositmnb_fees'];?>&nbsp;%</td>
</tr>
<tr>
	<td style="width:200px;">Total Deductable Amount</td>
    <td><input type="text" id="depamt" name="totalamt_txt"  size="10" readonly="readonly" />&nbsp;<b>USD</b></td>
</tr>
<tr>
	<td style="width:200px;">&nbsp;</td>
    <td valign="bottom"><input type="button" class="submit_bnt" name="ccpay" value="Submit" onclick="return chkfrm();" /></td>
</tr>
</tbody>
</table></div></div>
  </form>      
      
    </div></td>
  <td valign="top" class="CellBody right_cell">
    <?php /*?><div class="ourtemleft">
<h1>Helpful Links</h1>
<ul>
<li><a href="payment_schedule.php">Payment Schedule</a></li>
        <li><a href="account_balances.php">Account Balances</a></li>
        <li><a href="paying_contracts.php">Paying for Contracts</a></li>
        <li><a href="payment_help.php">Payments Help</a></li>
        <li><a href="referral_progam.php">Referral Program Help</a></li>


</ul>
</div><?php */?>
    </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr>
  <td colspan="2">
<div class="curvearea">
<h2 >Moneybooker Deposit</h2> 
 <table id="workHistory" class="tblbordertab" width="100%" cellpadding="8" align="left"> <caption style="padding-top: 0px;"></caption>
 <tbody>
 <tr class="messeagtab">  
	<th width="13%">Date</th> 
	<th width="16%"> Transaction ID</th> 
	<th width="11%">Receiver</th>
	<th width="10%">Status</th> 
	<th width="8%">Debit/Credit</th>
    <th width="11%">Amount(USD)</th>
</tr> 
<?php
$restrntab = mysql_query("select * from ".$prev."transactions where user_id='".$_SESSION['user_id']."' and details='Moneybooker Deposit' order by add_date desc");
if(mysql_num_rows($restrntab)>0)
{
	while($rwtrntab=mysql_fetch_array($restrntab))
	{
		$rwpptran = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_transactions where odeskclone_txn_id='".$rwtrntab['paypaltran_id']."'")); 
	?>
		<tr class="tbl_bg2">  
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
</table> <!--<a href="#" id="expandHistory" style="color:#0000FF;">more</a>--> </div> 
  </td>
  </tr>
</tbody></table>
</div>
<!--pro_up end-->
</div>





</div>
<!--Dashboard Right End-->


</div>


<!------end_middle-------->
<?php
include("include/footer.php");
?>
