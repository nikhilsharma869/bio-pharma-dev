<?php
require_once("includes/access.php");
require_once("includes/header.php");
$light2="#16559c";

if($_POST[SBMT_REG]):
   $r=mysql_query("update " . $prev . "paypal_settings set
   gold_member_charges = \"" . $_REQUEST[gold_member_charges_txt] . "\",
   gold_member_benefits = \"" . $_REQUEST[gold_member_benefits_txt] . "\",
   gold_membership_commission = \"" . $_REQUEST[gold_membership_commission_txt] . "\",
   silver_member_charges = \"" . $_REQUEST[silver_member_charges_txt] . "\",
   silver_member_benefits = \"" . $_REQUEST[silver_member_benefits_txt] . "\",
   silver_member_currency = \"" . $_REQUEST[silver_member_currency_txt] . "\",
   silver_membership_commission = \"" . $_REQUEST[silver_membership_commission_txt] . "\"");
   if($r):
      $msg="<script>Update Successful.</script>";
   else:
      $msg="<p align=center class=lnkred><br><br>Update failure.</p>";
   endif;	
endif;
    $r=mysql_query("select * from " . $prev . "paypal_settings");
    $d=@mysql_fetch_array($r);
	$class="lnk";
    ?>
	
    <table border="0" align=center cellpadding="4" cellspacing="0"  bordercolor="#111111" width="100%" id="AutoNumber1"> 
    <tr bgcolor=<?=$light?>>
    	<td  height="20" align="center" <? if(substr_count($_SERVER[PHP_SELF],"site.setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a  href='site.setting.php' class=<?=$class?>>Site Setting</a>
        </td>
    	<td align=center <? if(substr_count($_SERVER[PHP_SELF],"account_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a href='account_setting.php' class=<?=$class?>>Account Setting</a>
        </td>
    	<td align=center <? if(substr_count($_SERVER[PHP_SELF],"transfer_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a href='transfer_setting.php' class=<?=$class?>>Transfer Setting</a></td>
		
		<td height="20" width="25%" align=center <?php if(substr_count($_SERVER[PHP_SELF],"site_under_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href="site_under_setting.php" class=<?=$class?>>Site Under Maintainance</a></td>
    </tr>
    <tr bgcolor=<?=$light2?>><td colspan=8 height=6><img width=1 height=1></td></tr>
    </table>
    
    <br>
	<?php if($msg){echo $msg . "<br>";}?>
   <form name=register method=post action="<?=$_SERVER['PHP_SELF']?>" onSubmit="javscript:return ValidSet(this);">
    <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" class=table>
    <tr bgcolor="#b7b5b5" class=header_tr><td height=25 >&nbsp;Account Setting</td></tr>
    <tr><td align=center valign=top>
    <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?> >
	 
     <tr bgcolor="#ffffff" class=lnk>
        <td valign="top" width="25%"><b>Gold Member Charges :</b></td>
        <td><input type="text" name="gold_member_charges_txt" size="9" value="<?=$d[gold_member_charges]?>"><br>
         
         Example: 25.00  Note: If you want to keep this option inactive in frontend then <b>enter the charges as 0.00</b>.<br>
         </td>
     </tr>
     
     <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Discount on Commission Per Deposit (%):</b></td>
         <td><input type="text" name="gold_membership_commission_txt" size="9" value="<?=$d[gold_membership_commission]?>" /><br>
         
         Enter the discount on website commission in % that a gold member will benefit for each deposit.<br>
         </td>
     </tr>
     	 
     <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Gold Member Benefits:</b></td>
         <td><textarea name="gold_member_benefits_txt" cols=30 rows=3><?=$d[gold_member_benefits]?></textarea><br>
         
         Reduced project commissions , higher rankings and exclusive projects to bid on. 60% of projects are won by Gold members.<br>
         </td>
     </tr>
     
     <tr bgcolor="#ffffff" class=lnk>
     	<td valign="top" width="25%"><b>Silver Member Charges :</b></td>
        <td><input type="text" name="silver_member_charges_txt" size="9" value="<?=$d[silver_member_charges]?>"><br>
     
     Example: 25.00  Note: If you want to keep this option inactive in frontend then <b>enter the charges as 0.00</b>.<br>
     	</td>
     </tr>
     
	 <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Discount on Commission Per Deposit (%):</b></td>
         <td><input type="text" name="silver_membership_commission_txt" size="9" value="<?=$d[silver_membership_commission]?>"/><br>
         
         Enter the discount on website commission in % that a silver member will benefit for each deposit.<br>
         </td>
     </tr>
     
     <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Currency :</b></td>
         <td><input type="text" name="silver_member_currency_txt" size="9" value="<?=$d[silver_member_currency]?>"/><br>
         
        Multiple Currencies<br>
         </td>
     </tr>
     
     <tr bgcolor="#ffffff" class=lnk>
         <td valign="top" width="25%"><b>Silver Member Benefits:</b></td>
         <td><textarea name="silver_member_benefits_txt" cols=30 rows=3><?=$d[silver_member_benefits]?></textarea><br>
         
         Reduced project commissions , higher rankings and exclusive projects to bid on. 60% of projects are won by Gold members.<br>
         </td>
     </tr>
     
	 </table>
     </td></tr>
    <tr bgcolor=<?=$light?>><td>&nbsp;</td><td height=25 align=center><div align="left">
     <input type=submit class="button" name='SBMT_REG' value='Update'>
 </div></td></tr>
 
    </table>
	   </form>
<?php require_once("includes/footer.php");?>
