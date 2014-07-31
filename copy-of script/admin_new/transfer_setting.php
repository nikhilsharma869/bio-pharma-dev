<?php
include("includes/header_dashbord.php");
include("includes/access.php");
$light2="#666666";
if($_POST[SBMT_REG]):
//print_r($_POST);
$ppwith = 'N';
$pywith = 'N';
$mnwith = 'N';
if($_POST[paypal_check]=='Y')
{$ppwith = 'Y';}
if($_POST[payoneer_check]=='Y')
{$pywith = 'Y';}
if($_POST[moneybooker_check]=='Y')
{$mnwith = 'Y';}
if($_POST[withdraw_wired]=='Y')
{$pywire = 'Y';}
   $r=mysql_query("update " . $prev . "paypal_settings set
   ppemailaddr = \"" . $_REQUEST[ppemailaddr_txt] . "\",
   paypal_uid = \"" . $_REQUEST[paypal_uid] . "\",
   paypal_pass = \"" . $_REQUEST[paypal_pass] . "\",
   paypal_signature = \"" . $_REQUEST[paypal_signature] . "\",
   depositcc_fees = \"" . $_REQUEST[depositcc_fees_txt] . "\",
   depositcc_percent = \"" . $_REQUEST[depositcc_percent_txt] . "\",
   depositcc_charges = \"" . $_REQUEST[depositcc_charges_txt] . "\",
   depositpp_fees = \"" . $_REQUEST[depositpp_fees_txt] . "\",
   depositpp_percent = \"" . $_REQUEST[depositpp_percent_txt] . "\",
   depositpp_charges = \"" . $_REQUEST[depositpp_charges_txt] . "\",
   depositcc_method = \"" . $_REQUEST[depositcc_method_txt] . "\",
   depositpp_method = \"" . $_REQUEST[depositpp_method_txt] . "\",
   withdraw_paypal = \"" . $ppwith . "\",
   withdraw_moneybooker = \"" . $mnwith . "\",
    withdraw_wired = \"" . $pywire . "\",
   withdraw_payoneer = \"" . $pywith . "\",
   withdraw_paypal_charge = \"" . $_REQUEST[withdraw_paypal_charge_txt] . "\",
   withdraw_moneybooker_charge = \"" . $_REQUEST[withdraw_moneybooker_charge_txt] . "\",
   withdraw_payoneer_charge = \"" . $_REQUEST[withdraw_payoneer_charge_txt] . "\",
   bid_charge_type = \"" . $_REQUEST[bid_charge_type_txt] . "\",
   bid_charge_fixed = \"" . $_REQUEST[bid_charge_fixed_txt] . "\",
   withdraw_wired_charge = \"" . $_REQUEST[withdraw_wired_charge_txt] . "\",
   bid_charge_percent = \"" . $_REQUEST[bid_charge_percent_txt] . "\"
   ");
   if($r):
       $msg="Update Successful.";
   else:
       $msg="Update Failure.";
   endif;		
endif;
$r=mysql_query("select * from " . $prev . "paypal_settings");
$d=@mysql_fetch_array($r);
$class="lnk";
    ?>
<div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
	
        <section id="content">
            <div class="wrapper">
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                    </ul>
                </div>
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Transfer Setting</h1>
                    </div>
					
					        <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='transfer_setting.php' class="header">&nbsp;Transfer Setting</a>&nbsp;&nbsp; <?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
            
          <table border="0" align=center cellpadding="4" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="table"> 
    <tr bgcolor=<?=$light?>>
        <td  height="20" align="center" <? if(substr_count($_SERVER[PHP_SELF],"site.setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a  href='site.setting.php' class=<?=$class?>>Site Setting</a>
        </td>
        <td align=center <? if(substr_count($_SERVER[PHP_SELF],"account_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a href='account_setting.php' class=<?=$class?>>Account Setting</a>
        </td>
        <td align=center <? if(substr_count($_SERVER[PHP_SELF],"transfer_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a href='transfer_setting.php' class=<?=$class?>>Transfer Setting</a>
        <td height="20" width="25%" align=center <?php if(substr_count($_SERVER[PHP_SELF],"site_under_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href="site_under_setting.php" class=<?=$class?>>Site Under Maintainance</a></td>
        </td>
    </tr>
    </table>

    <form name=register method=post action="<?=$_SERVER['PHP_SELF']?>" onSubmit="javscript:return ValidSet(this);">
    <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" class=table>
   
    <tr><td align=center valign=top>
    
    <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?> >
    <tr class=lnk bgcolor="#ffffff">
    	<td valign="top" width="25%"><b> Paypal Email Id :</b></td>
        <td>
     		<input type="text" name="ppemailaddr_txt" size="45" value="<?=$d[ppemailaddr]?>">       <br>
    Description: The PayPal email address where users pay when depositting money (via paypal), and when the user clicks on the PayPal link, they will be taken to the referral signup referred by this email address (if you don\'t have a PayPal account, use the one shown in the example).<br>
    Example: youremail@youremail.com
    	</td>
    </tr>
	<tr class=lnk bgcolor="#ffffff">
    	<td valign="top" width="25%"><b> Paypal API user id :</b></td>
        <td>
     		<input type="text" name="paypal_uid" size="45" value="<?=$d[paypal_uid]?>"> 
    
    	</td>
    </tr>
	<tr class=lnk bgcolor="#ffffff">
    	<td valign="top" width="25%"><b> Paypal API password :</b></td>
        <td>
     		<input type="text" name="paypal_pass" size="45" value="<?=$d[paypal_pass]?>"> 
    
    	</td>
    </tr>
	<tr class=lnk bgcolor="#ffffff">
    	<td valign="top" width="25%"><b> Paypal API paypal_signature :</b></td>
        <td>
     		<input type="text" name="paypal_signature" size="45" value="<?=$d[paypal_signature]?>">
    	</td>
    </tr>
	
   <!-- <tr class=lnk bgcolor="#ffffff">
    	<td valign="top"  width="25%"><b> Bidding Commission :</b></td>
    	<td>
        <input type="radio" name="bid_charge_type_txt" value="P" <?php if($d[bid_charge_type]=='P'){?> checked="checked"<?php } ?> />Percent (%)&nbsp;&nbsp;&nbsp;
        <input type="radio" name="bid_charge_type_txt" value="F" <?php if($d[bid_charge_type]=='F'){?> checked="checked"<?php } ?>/>Fixed
    <br>
    Description: Choose anyone of the methods by which wesite charges commission per bid. The calculated charges will be deducted from buyer account if he chooses the corresponding bid.<br>
    	</td>
    </tr>-->
    
        <!--<tr bgcolor="#ffffff" class=lnk>
        <td valign="top"  width="25%"><b> Bidding Commission Amount (Fixed) :</b></td>
        <td>
       <input type=text class=lnk name="bid_charge_fixed_txt" value="<?=$d[bid_charge_fixed]?>" size=10>
       <br>
        Description: Provide fixed amount (in USD) that will be charged as commission for each bid.<br>
        </td>
    </tr>-->
    
    <!--<tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%"><b> Bidding Commission Amount (%) :</b></td>
        <td>
        <input type=text class=lnk name="bid_charge_percent_txt" value="<?=$d[bid_charge_percent]?>" size=10>&nbsp;%
        <br>
        Description: Provide commission % that will be charged for each bid.<br />
        </td>
    </tr>-->
<!------>
   <!-- <tr class=lnk bgcolor="#ffffff">
    	<td valign="top"  width="25%"><b> Deposit By Creditcard Commission :</b></td>
    	<td>
        <input type="radio" name="depositcc_method_txt" value="P" <?php if($d[depositcc_method]=='P'){?> checked="checked"<?php } ?> />Percent (%)&nbsp;&nbsp;&nbsp;
       <!-- <input type="radio" name="depositcc_method_txt" value="F" <?php if($d[depositcc_method]=='F'){?> checked="checked"<?php } ?>/>Fixed-->
    <!--<br>
    Description: Choose anyone of the methods by which wesite charges commission per deposit. The calculated charges will be added to the deposit amount.<br>
    	</td>
    </tr>-->

    <!--<tr bgcolor="#ffffff" class=lnk>
        <td valign="top"  width="25%"><b> Deposit By Creditcard Commission Amount (Fixed) :</b></td>
        <td>
       <input type=text class=lnk name="depositcc_charges_txt" value="<?=$d[depositcc_charges]?>" size=10>
       <br>
        Description: Provide fixed amount (in USD) that will be charged as commission for each deposit using credit card.<br>
        </td>
    </tr>-->
    
    <!--<tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%"><b> Deposit By Creditcard Commission Amount (%) :</b></td>
        <td>
        <input type=text class=lnk name="depositcc_percent_txt" value="<?=$d[depositcc_percent]?>" size=10>&nbsp;%
        <br>
        Description: Provide commission % that will be charged for each deposit using credit card.<br />
        </td>
    </tr>-->
    
    <tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%" ><b> Deposit By Creditcard Fees - Paypal (%) :</b></td>
        <td>
        <input type=text class=lnk name="depositcc_fees_txt" value="<?=$d[depositcc_fees]?>" size=10>&nbsp;%
        <br>
        Description: Provide the paypal fees (in %) that paypal charges for each transaction. This may change from time to time, so remain updated as how much paypal is charging. This amount will be debited from user.<br>
        </td>
    </tr>
	
    <tr class=lnk bgcolor="#ffffff">
        <td valign="top" width="25%" ><b> Deposit By Paypal Commission :</b></td>
        <td>
            <input type="radio" name="depositpp_method_txt" value="P" <?php if($d[depositpp_method]=='P'){?> checked="checked"<?php } ?> />Percent (%)&nbsp;&nbsp;&nbsp;
            <input type="radio" name="depositpp_method_txt" value="F" <?php if($d[depositpp_method]=='F'){?> checked="checked"<?php } ?>/>Fixed
        <br>
        Description: Choose anyone of the methods by which wesite charges commission per deposit. The calculated charges will be added to the deposit amount.<br>
        </td>
    </tr>

    <tr bgcolor="#ffffff" class=lnk>
        <td valign="top"  width="25%"><b> Deposit By Paypal Commission Amount (Fixed) :</b></td>
        <td>
        <input type=text class=lnk name="depositpp_charges_txt" value="<?=$d[depositpp_charges]?>" size=10>
        <br>
        Description: Provide fixed amount (in USD) that will be charged as commission for each deposit using paypal account.<br>
        </td>
    </tr>
    
    <tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%" ><b> Deposit By Paypal Commission Amount (%) :</b></td>
        <td>
        <input type=text class=lnk name="depositpp_percent_txt" value="<?=$d[depositpp_percent]?>" size=10>&nbsp;%
        <br>
        Description: Provide commission % that will be charged for each deposit using paypal account.<br />
        </td>
    </tr>
    
    <tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%" ><b> Deposit By Paypal Fees - Paypal (%) :</b></td>
        <td>
        <input type=text class=lnk name="depositpp_fees_txt" value="<?=$d[depositpp_fees]?>" size=10>&nbsp;%
        <br>
        Description: Provide the paypal fees (in %) that paypal charges for each transaction. This may change from time to time, so remain updated as how much paypal is charging. This amount will be debited from user.<br>
        </td>
    </tr>
    
    <tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%" ><b> Withdrawal Methods :</b></td>
        <td>
        <input type="checkbox" name="paypal_check" value="Y" <?php if($d[withdraw_paypal]=='Y'){?> checked="checked"<?php }?> />&nbsp;Paypal
        <input type="checkbox" name="moneybooker_check" value="Y" <?php if($d[withdraw_moneybooker]=='Y'){?> checked="checked"<?php }?> />&nbsp;Moneybooker
        <input type="checkbox" name="payoneer_check" value="Y" <?php if($d[withdraw_payoneer]=='Y'){?> checked="checked"<?php }?> />&nbsp;Payoneer
       
		
            <input type="checkbox" name="withdraw_wired" value="Y" <?php if($d[withdraw_wired]=='Y'){?> checked="checked"<?php }?> />

            &nbsp;Wire Transfer <br />
        Description: Please tick the checkboxes for withdrawal methods. Unchecked method will remain inactive in the frontend.<br>
        </td>
    </tr>

    <tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%" ><b> Withdraw By Paypal Commission Amount (Fixed) :</b></td>
        <td>
        <input type=text class=lnk name="withdraw_paypal_charge_txt" value="<?=$d[withdraw_paypal_charge]?>" size=10>
        <br>
        Description: Provide fixed amount (in USD) that will be charged as commission for each withdrawal using paypal account.<br>
        </td>
    </tr>
    
    
    <tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%" ><b> Withdraw By Moneybooker Commission Amount (Fixed) :</b></td>
        <td>
        <input type=text class=lnk name="withdraw_moneybooker_charge_txt" value="<?=$d[withdraw_moneybooker_charge]?>" size=10>
        <br>
        Description: Provide fixed amount (in USD) that will be charged as commission for each withdrawal using moneybooker account.<br>
        </td>
    </tr>
    
    
    <tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%" ><b> Withdraw By Payoneer Commission Amount (Fixed) :</b></td>
        <td>
        <input type=text class=lnk name="withdraw_payoneer_charge_txt" value="<?=$d[withdraw_payoneer_charge]?>" size=10>
        <br>
        Description: Provide fixed amount (in USD) that will be charged as commission for each withdrawal using payoneer account.<br>
        </td>
    </tr>
    
     <tr bgcolor="#ffffff" class="lnk">

          <td valign="top" width="25%" ><b> Withdraw By Wire Transfer Commission Amount (Fixed) :</b></td>

          <td><input type="text" class="lnk" name="withdraw_wired_charge_txt" value="<?=$d[withdraw_wired_charge]?>" size="10" />

                <br />

            Description: Provide fixed amount (in USD) that will be charged as commission for each withdrawal using wire_transfer.<br />

          </td>

        </tr>  
    <tr bgcolor=<?=$light?>><td></td><td height=25><div align="left">
      <input type=submit class="button" name='SBMT_REG' value='Update'>
    </div></td></tr>
   
    </table></td></tr></table>
	 </form>
</div>
</div>
</div>
</div>
			
			</div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    </div>

