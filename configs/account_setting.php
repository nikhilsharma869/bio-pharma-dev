<?php
require_once("includes/access.php");
require_once("includes/header.php");
$light2="#16559c";

if($_POST[SBMT_REG]):
   $r=mysql_query("update " . $prev . "setup set
   fsbamount=\"" . $_REQUEST[fsbamount] . "\",gold_member_charges=\"" . $_REQUEST[gold_member_charges] . "\",gold_member_benefits=\"" . $_REQUEST[gold_member_benefits] . "\",
   bsbamount=\"" . $_REQUEST[bsbamount] . "\",
   frefamount=\"" . $_REQUEST[frefamount] . "\",featuredcost=\"" . $_REQUEST[featuredcost] . "\",
   brefamount=\"" . $_REQUEST[brefamount] . "\"");
   if($r):
      $msg="<p align=center class=header_tr><br><br>Update Successful.</p>";
   else:
      $msg="<p align=center class=lnkred><br><br>Update failure.</p>";
   endif;	
endif;
    $r=mysql_query("select * from " . $prev . "setup");
    $d=@mysql_fetch_array($r);
	$class="lnk";
    ?>
    <table border="0" align=center cellpadding="4" cellspacing="0"  bordercolor="#111111" width="100%" id="AutoNumber1"> 
    <tr bgcolor=<?=$light?>><td  height="20" align="center" <?if(substr_count($_SERVER[PHP_SELF],"site.setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a  href='site.setting.php' class=<?=$class?>>Site Setting</a></td>
	<td align=center <?if(substr_count($_SERVER[PHP_SELF],"email_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href='email_setting.php'class=<?=$class?>>Email Setting</a></td>
    <td align=center <?if(substr_count($_SERVER[PHP_SELF],"account_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href='account_setting.php' class=<?=$class?>>Account Setting</a></td>
	<!--<td align=center <?if(substr_count($_SERVER[PHP_SELF],"static_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href='static_setting.php' class=<?=$class?>>Statistics Setting</a></td>-->
    <td align=center <?if(substr_count($_SERVER[PHP_SELF],"transfer_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href='transfer_setting.php' class=<?=$class?>>Transfer Setting</a></td></tr>
    <tr bgcolor=<?=$light2?>><td colspan=8 height=6><img width=1 height=1></td></tr></table>
    
    <br>
	<?php if($msg){echo $msg . "<br>";}?>
   <form name=register method=post action="<?=$_SERVER['PHP_SELF']?>" onSubmit="javscript:return ValidSet(this);">
    <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" class=table>
    <tr bgcolor=<?=$light?> class=header_tr><td height=25 >&nbsp;Account Setting</td></tr>
    <tr><td align=center valign=top>
    <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?> >
    <!--<tr class=lnk bgcolor=#ffffff><td valign="top" width=23%><b>% of commission For a project :</b></td><td ><?=$setting[currencytype]?>  <?=$setting[currency]?><input type="text" name="commission" size="9" value="<?=$d[commission]?>">%<br>
     Description: The account chargeable to "freelancers"  when they win a project .<br>
     </td></tr>
	
    <tr bgcolor="#ffffff" class=lnk><td valign="top"><b>Webamster Signup Bonus:</b></td><td ><?=$setting[currencytype]?>  <?=$setting[currency]?><input type="text" name="bsbamount" size="9" value="<?=$d[bsbamount]?>"><br>
     Description: The account signup bonus that "buyers" will receive when they create an account at your website (a decimal is allowed).<br>
     Example: 2.50<br></td></tr>-->
     <tr bgcolor="#ffffff" class=lnk><td valign="top"><b>Referal Commission for Member Join:</b></td><td><?=$setting[currencytype]?>  <?=$setting[currency]?><input type="text" name="frefamount" size="9" value="<?=$d[frefamount]?>"><br>
     Description: The referal amount a user will receive when they refer a "freelancer" and the "freelancer" successfully creates an account at your website (a decimal is allowed).<br>
     Example: 0.25<br></td></tr>
	 <tr bgcolor="#ffffff" class=lnk><td valign="top"><b>Featured Job Cost:</b></td><td><?=$setting[currencytype]?>  <?=$setting[currency]?><input type="text" name="featuredcost" size="9" value="<?=$d[featuredcost]?>"><br>
	  
	 <tr bgcolor="#ffffff" class=lnk><td valign="top"><b>Gold Member Charges per Month:</b></td><td><?=$setting[currencytype]?>  <?=$setting[currency]?><input type="text" name="gold_member_charges" size="9" value="<?=$d[gold_member_charges]?>"><br>
     
     Example: 25<br></td></tr>
	 <tr bgcolor="#ffffff" class=lnk><td valign="top"><b>Gold Member Benefits:</b></td><td><textarea name="gold_member_benefits" cols=30 rows=3><?=$d[gold_member_benefits]?></textarea><br>
     
     Reduced project commissions , higher rankings and exclusive projects to bid on. 60% of projects are won by Gold members.<br></td></tr>
	 
     <!--<tr bgcolor="#ffffff" class=lnk><td valign="top"><b>Referal Commission for Webmaster Join</b></td><td><?=$setting[currencytype]?>  <?=$setting[currency]?><input type="text" name="brefamount" size="9" value="<?=$d[brefamount]?>"><br>
     Description: The referal amount a user will receive when they refer a "buyer" and the "buyer" successfully creates at your website (a decimal is allowed).<br>
     Example: 1<br></td></tr>-->
      
	 </table>
     </td></tr>
    <tr bgcolor=<?=$light?>><td colspan=2 height=25 align=center><div align="center">
      <input type=submit class="button" name='SBMT_REG' value='Update'>
    </div></td></tr>
 
    </table>
	   </form>
<?php require_once("includes/footer.php");?>
