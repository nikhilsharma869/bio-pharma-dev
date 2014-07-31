<?php
include("includes/header_dashbord.php");
include("includes/access.php");
$light2="#666666";

if($_POST[SBMT_REG]):
   $r=mysql_query("update " . $prev . "paypal_settings set
   gold_member_charges = \"" . $_REQUEST[gold_member_charges_txt] . "\",
   gold_member_benefits = \"" . $_REQUEST[gold_member_benefits_txt] . "\",
   gold_membership_commission = \"" . $_REQUEST[gold_membership_commission_txt] . "\",
   silver_member_charges = \"" . $_REQUEST[silver_member_charges_txt] . "\",
   silver_member_benefits = \"" . $_REQUEST[silver_member_benefits_txt] . "\",
   silver_member_currency = \"" . $_REQUEST[silver_member_currency_txt] . "\",
    featured_company_charge = \"" . $_REQUEST[featured_company_charge] . "\",
	 featured_individual_charge = \"" . $_REQUEST[featured_individual_charge] . "\",
	  non_featured_company_charge = \"" . $_REQUEST[non_featured_company_charge] . "\",
	   non_featured_individual_charge = \"" . $_REQUEST[non_featured_individual_charge] . "\",
	    featured_company_charge_hourly = \"" . $_REQUEST[featured_company_charge_hourly] . "\",
	 featured_individual_charge_hourly = \"" . $_REQUEST[featured_individual_charge_hourly] . "\",
	  non_featured_company_charge_hourly = \"" . $_REQUEST[non_featured_company_charge_hourly] . "\",
	   non_featured_individual_charge_hourly = \"" . $_REQUEST[non_featured_individual_charge_hourly] . "\",
   silver_membership_commission = \"" . $_REQUEST[silver_membership_commission_txt] . "\"");
   if($r):
      $msg="Update Successful.";
   else:
      $msg="Update failure.";
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
                        <h1><i class="icon20 i-list-4"></i>Account Setting</h1>
                    </div>
					
					        <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='account_setting.php' class="header">&nbsp;Account Setting</a>&nbsp;&nbsp;<?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
            
           <table border="0" align=center cellpadding="4" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="table"> 
    <tr bgcolor=<?=$light?>>
    	<td  height="20" align="center" <? if(substr_count($_SERVER[PHP_SELF],"site.setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}?>>
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
	  <tr  class=header_tr style="background:#f1f1f1"><td height=25 colspan=2>&nbsp;Fixed Project</td>
   </tr>
    <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Featured company charge (Fixed)(%):</b></td>
         <td><input type="text" name="featured_company_charge" size="9" value="<?=$d[featured_company_charge]?>"/><br>
         
       <br>
         </td>
     </tr>
     
	  <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Featured individual charge (Fixed)(%) :</b></td>
         <td><input type="text" name="featured_individual_charge" size="9" value="<?=$d[featured_individual_charge]?>"/><br>
         
       
         </td>
     </tr>
     
	   <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Non featured company charge (Fixed)(%):</b></td>
         <td><input type="text" name="non_featured_company_charge" size="9" value="<?=$d[non_featured_company_charge]?>"/><br>
         
       <br>
         </td>
     </tr>
     
	  <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Non featured individual charge (Fixed)(%) :</b></td>
         <td><input type="text" name="non_featured_individual_charge" size="9" value="<?=$d[non_featured_individual_charge]?>"/><br>
         
       
         </td>
     </tr>
    
     	 
    
   
 
     
     
     
     
	 </table>
     </td></tr>
     <tr><td align=center valign=top>
    <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?> >
	  <tr  class=header_tr style="background:#f1f1f1"><td height=25 colspan=2>&nbsp;Hourly Project</td>
   </tr>
    <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Featured company charge (hourly)(%):</b></td>
         <td><input type="text" name="featured_company_charge_hourly" size="9" value="<?=$d[featured_company_charge_hourly]?>"/><br>
         
       <br>
         </td>
     </tr>
     
	  <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Featured individual charge (hourly)(%) :</b></td>
         <td><input type="text" name="featured_individual_charge_hourly" size="9" value="<?=$d[featured_individual_charge_hourly]?>"/><br>
         
       
         </td>
     </tr>
     
	   <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Non featured company charge (hourly)(%):</b></td>
         <td><input type="text" name="non_featured_company_charge_hourly" size="9" value="<?=$d[non_featured_company_charge_hourly]?>"/><br>
         
       <br>
         </td>
     </tr>
     
	  <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Non featured individual charge (hourly)(%) :</b></td>
         <td><input type="text" name="non_featured_individual_charge_hourly" size="9" value="<?=$d[non_featured_individual_charge_hourly]?>"/><br>
         
       
         </td>
     </tr>
    
     	 
    
   
 
     
     <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Currency :</b></td>
         <td><input type="text" name="silver_member_currency_txt" size="9" value="<?=$d[silver_member_currency]?>"/><br>
         
     
         </td>
     </tr>
     
     
	 </table>
     </td></tr>
    
	
	<tr bgcolor=<?=$light?>><td height=25 align=center><div align="left">
     <input type=submit class="button" name='SBMT_REG' value='Update'>
 </div></td></tr>
 
    </table>
	   </form>
</div>
</div>
</div>
</div>
			
			</div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    </div>

