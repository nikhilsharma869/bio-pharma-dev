<?php

require_once("includes/access.php");
require_once("includes/header.php");

$r=mysql_query("select * from  ".$prev."membership where id=".$_GET['id']);
$data=@mysql_fetch_array($r);

if($_POST['SBMT'])
{
echo "update ".$prev."membership set membership_name='$_POST[membership_name]',price=$_POST[price],skills=$_POST[skills],bids=$_POST[bids],portfolio=$_POST[portfolio] where id= ".$_GET['id'];
$query=mysql_query("update ".$prev."membership set membership_name='$_POST[membership_name]',price=$_POST[price],skills=$_POST[skills],bids=$_POST[bids],portfolio=$_POST[portfolio] where id= ".$_GET['id']);
}

?>
<form action="" method="post" id="frm1" name="frm1">
<table width="100%" border="0" cellspacing="1" bgcolor="#e5e5e5" style="border:1px solid #999999;" cellpadding="4" align="center" class="table">
<tr class="header" bgcolor=<?=$light?>>
		<td class="header"><b> Edit Member : </b></td>
		<td class="header"><b>  </b></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Plan Name </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="membership_name" id="membership_name" size=25 class=lnk  value="<?=$data[membership_name]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Price </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="price" id="price" size=25 class=lnk  value="<?=$data[price]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left width=30%><b>Skill</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="skills" id="skills" size=25 class=lnk  value="<?=$data[skills]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Bids</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="bids" id="bids"  size=25 class=lnk  value="<?=$data[bids]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Portfolio</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="portfolio" id="portfolio"  size=25 class=lnk  value="<?=$data[portfolio]?>"></td>
	</tr>
	<tr bgcolor="#e5e5e5">
		<td>* Fields are Mandatory</td>
		<td align=left><div align="center">
	      <input type="submit" name="SBMT"  class="button" value="Update">
	      &nbsp;
	      <input type="button"  class="button" value="Back" onClick="javascript:window.location.href='membership_plan.php'">
		</div></td>
	</tr>
</table>
</form>

<? include("includes/footer.php"); ?>