<?
include("includes/access.php");

include("includes/header.php");

$reg_date=date("Y-m-d");
$msg="";$admin_body="";

if($_REQUEST[SBMT_REG]):
      $reg_date=date("Y-m-d");
   	  if(!$_REQUEST[id]):
//	  	echo "insert into " . $prev . "car set cat=\"".$_REQUEST[cat]."\",name='".$_REQUEST['name']."',description=\"".$_REQUEST[description]."\",kilo='".$_REQUEST['kilo']."',power='".$_REQUEST['power']."',fuel='".$_REQUEST['fuel']."',change='".$_REQUEST['change']."',status=\"".$_REQUEST[status]."\"";
	    $r=mysql_query("insert into " . $prev . "car set hotlist='".$_REQUEST['hotlist']."',price='".$_REQUEST['price']."', cat=\"".$_REQUEST[cat]."\",name='".$_REQUEST['name']."',description=\"".$_REQUEST[description]."\",kilo='".$_REQUEST['kilo']."',power='".$_REQUEST['power']."',fuel='".$_REQUEST['fuel']."',chnge='".$_REQUEST['change']."',status=\"".$_REQUEST[status]."\"");
		
	else:
		$id=$_REQUEST[id];
		//echo "update " . $prev . "car set username=\"".$_REQUEST[username]."\",password=\"".$_REQUEST[password]."\",pass_hint=\"".$_REQUEST[pass_hint]."\",	email=\"".$_REQUEST[email]."\",	reg_date=\"".$reg_date."\",	ip=\"".$ip."\",	user_agent=\"".$_REQUEST[user_agent]."\",profile=\"".$_REQUEST[profile]."\",user_type=\"".$_REQUEST[user_type]."\",	status=\"".$_REQUEST[status]."\" where id=" . $id."";
	    $r=mysql_query("update " . $prev . "car set hotlist='".$_REQUEST['hotlist']."',price='".$_REQUEST['price']."',cat=\"".$_REQUEST[cat]."\",name='".$_REQUEST['name']."',description=\"".$_REQUEST[description]."\",kilo='".$_REQUEST['kilo']."',power='".$_REQUEST['power']."',fuel='".$_REQUEST['fuel']."',chnge='".$_REQUEST['change']."',status=\"".$_REQUEST[status]."\" where id=" . $id."");
	endif;
		
	 if($r):
	      echo"<p align=center><br><br><font face=verdana size=2 color=$dark><b>Update successful.</b></font><br><br><br><br><a href=\"car.list.php\" class=lnk><u>Back to car Management</u></a> | <a href=\"car.add.php?id=" . $id . "\" class=lnk><u>Back to car Profile</u></a></p>";
	 else:
	  	echo"<p align=center><br><br><font face=verdana size=2 color=red><b>Error ! Some fields are duplicate.</b></font><br><br><br><br><a href='javascript:history.back();' class=lnk>Back</a></p>";
	 endif;
else:
if($_REQUEST[id]){$id=$_REQUEST[id];}
$r=mysql_query("select * from " . $prev . "car where id=" . $id);
//echo "select * from " . $prev . "car where id=" . $id;
$d=@mysql_fetch_array($r);

?>
   
  
 <script language="javascript" type="text/javascript">
<!--
function isEmail(Ml)
{
  if(!Ml){return true}
  if(Ml.indexOf("@")<=0 || Ml.indexOf("@")==Ml.length-1 || Ml.indexOf(".")<=0 || Ml.indexOf(".")==Ml.length-1 || Ml.indexOf("..")!=-1 || Ml.indexOf("@@")!=-1 || Ml.indexOf("@.")!=-1 || Ml.indexOf(".@")!=-1)
  {
      return false
  }
  else
  {
      return true
  }
}


function ValidUser(register)
{
    var txt="";
		if(!register.username.value)
	{
		txt+="     Username should not be empty.\n"
	}
	if(!register.password.value)
	{
		txt+="     Password should not be empty.\n"
	}
	if(!register.email.value || !isEmail(register.email.value))
	{
	   txt+="     Enter valid Email address.\n"
       
 	}	

   	if(txt)
	{
   		alert("Sorry!! Following errors has been occured :\n\n"+ txt +"\n     Please Check");
  	 	return false
	}
    return true	
}//-->
</script>
<style type="text/css">
<!--
.style1 {color: <?=$dark?>}
-->
</style>


 <form name=register method=post action="<?=$_SERVER[PHP_SELF]?>" enctype="multipart/form-data" onSubmit="javascript:return ValidUser(this);">
 <input type=hidden name=id value=<?=$id?>>
 <table width="100%
" border="0" align="center" cellspacing="0" cellpadding="0" style="border:solid 1px <?=$dark?>">
 <tr bgcolor=<?=$light?> class=header>
   <td height=30 >&nbsp;<a href='car.list.php' class=header><u>Car Details </u></a></td>
 </tr>
 <tr><td align=center valign=top>
 <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?> >
 <tr  bgcolor=#ffffff class=lnk>
   <td align="left">Category <font color="#FF0000">*</font></td>
   <td align="left" >
   
   <select name="cat" id="cat">
   <?
   	
   	$rws=mysql_query("select * from " . $prev. "car_cat order by id asc");
	while($rw=mysql_fetch_array($rws))
	{
		if($rw[id]==$d[cat]){ $str=" selected "; }
		echo "<option value='".$rw[id]."' ".$str." >".$rw['category']."</option>";
	}
   
   ?>
   </select>   </td>
 </tr>
 <tr  bgcolor=#ffffff class=lnk>
   <td align="left">Name</td>
   <td align="left" ><input name="name" type="text" id="name" value="<?=$d['name']?>" /></td>
 </tr>
 <tr  bgcolor=#ffffff class=lnk>
   <td align="left">Description</td>
   <td align="left" ><input name="description" type="text" id="description" value="<?=$d['description']?>" size="40" /></td>
 </tr>
 <tr  bgcolor=#ffffff class=lnk>
   <td align="left">Kilometer</td>
   <td align="left" ><input name="kilo" type="text" id="kilo" value="<?=$d['kilo']?>" size="15" /></td>
 </tr>
 <tr  bgcolor=#ffffff class=lnk>
   <td align="left">Power</td>
   <td align="left" ><input name="power" type="text" id="power" value="<?=$d['power']?>" size="15" /></td>
 </tr>
 <tr  bgcolor=#ffffff class=lnk>
   <td align="left">Change</td>
   <td align="left" ><select name="change" id="change">
     <option value="automatic"  <? if($d[change]=="change"){ echo " selected"; } ?> >Automatic</option>
     <option value="manual"  <? if($d[change]!="change"){ echo " selected"; } ?>>Manual</option>
         </select></td>
 </tr>
 
 <tr bgcolor=#ffffff class=lnk>
   <td align="left">Fuel</td>
   <td align="left" ><select name="fuel" id="fuel">
     <option value="diesel"  <? if($d[change]=="diesel"){ echo " selected"; } ?> >Diesel</option>
     <option value="petrol" <? if($d[change]!="diesel"){ echo " selected"; } ?> >Petrol</option>
      </select></td>
 </tr>
 <tr bgcolor=#ffffff class=lnk>
   <td align="left">Price</td>
   <td align="left" ><input name="price" type="text" id="price" value="<?=$d['price']?>" size="15" /></td>
 </tr>
 <tr bgcolor=#ffffff class=lnk>
  <td align="left">Status</td>
<td align="left" ><input type=radio name="status" value="Y" <? if($d["status"]=="Y" or $d["status"]==" "){echo" checked";}?> >Active  <input type=radio name=status value='F' <? if($d["status"]=="S"){echo" checked";}?>> Suspended </td></tr>
</table>
</td></tr>
 <tr >
   <td bgcolor="#FFFFFF" height=25 colspan=2 align=center style="padding:10px 10px 10px 10px" ><br />
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td><input name="file" type="file" style="opacity:0;position:absolute" size="1" maxlength="1" /><img src="images/button.JPG" width="86" style="z-index:"></td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
     </table>
     <br />
     <br /></td>
 </tr>
 <tr >
   <td bgcolor="#FFFFFF" height=25 colspan=2 align=center style="padding:10px 10px 10px 10px" ><div class="style1" style="padding:5px 5px 5px 5px ; border:1px solid #999999; background:<?=$dark?>">
     <input name="hotlist" type="checkbox" id="hotlist" value="Y" <? if($d[hotlist]=="Y") echo " checked='checked'" ;  ?> />
     <strong><font color="<?=$light?>" face="Verdana, Arial, Helvetica, sans-serif">Add this car in Hottest Deal</font></strong></div></td>
 </tr>
 <tr bgcolor=<?=$light?>><td colspan=2 height=25 align=center ><input type=submit class=lnk name='SBMT_REG' value='Update'>&nbsp;&nbsp;<input type=button class=lnk  value='Cancel' onClick="javascript:window.location.href='car.list.php'"></td></tr>
</table>
</form>
<?  endif; ?>
</td>
</tr></table>
</td>
</tr></table>
<?
include("includes/footer.php");

?>