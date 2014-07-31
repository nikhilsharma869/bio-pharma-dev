<?php
session_start();
include "configs/path.php";
CheckLogin();
if(isset($_GET['rid']))
{
	$rw = mysql_fetch_array(mysql_query("select * from ".$prev."feedback where id = '".$_GET['rid']."'"));
	$avg_rate=$rw['avg_rate'];
	$rate1=$rw['rate1'];
	$rate2=$rw['rate2'];
	$rate3=$rw['rate3'];
	$rate4=$rw['rate4'];
	$rate5=$rw['rate5'];
	//echo $avg_rate;
	$user_detail= mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw['feedback_to']."'"));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Start Rating</title>
<link href="css/globals__visitor.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<table width="400" height="200" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#6D6D6D;">
<tr>
	<th colspan="8" bgcolor="#CCCCCC" height="35" style="-webkit-border-radius:6px; -moz-border-radius:6px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#6D6D6D;">
    Feedback to Employer <?php echo $user_detail['fname'] .' '.$user_detail['lname'];?></th>
</tr>
<tr>
	<td style="width:160px;"><strong>Average Rating</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="staravg_rate1">
    <table><tr>

			<?php
			for($i=0;$i<$avg_rate;$i++)
			{
			?>
				<td>
				<img src="images/star_fill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			for($j=5;$j>$avg_rate;$j--)
			{
			?>
				<td>
				<img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			?>
			
    </tr></table>   
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ver" size="2" value="<?php print $rw['avg_rate'];?>.00" style="border:none;" readonly="readonly"/></td>
</tr>
<tr><td colspan="8"><hr style="color:#CCC;" /></td></tr>
<tr>
	<td><strong>Clarity in Specification</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate1">
    <table><tr>
			<?php
			for($i=0;$i<$rate1;$i++)
			{
			?>
				<td>
				<img src="images/star_fill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			for($j=5;$j>$rate1;$j--)
			{
			?>
				<td>
				<img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			?>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve1" name="my_txt" value="<?php print $rw['rate1'];?>.00" size="2" style="border:none;" readonly="readonly"/></td>
</tr>
<tr>
	<td><strong>Communication</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate2">
    <table><tr>
			<?php
			for($i=0;$i<$rate2;$i++)
			{
			?>
				<td>
				<img src="images/star_fill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			for($j=5;$j>$rate2;$j--)
			{
			?>
				<td>
				<img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			?>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve2" name="com_txt" value="<?php print $rw['rate2'];?>.00" size="2" style="border:none;" readonly="readonly"/></td>
</tr>
<tr>
	<td><strong>Payment Promptness</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate3">
    <table><tr>
   			<?php
			for($i=0;$i<$rate3;$i++)
			{
			?>
				<td>
				<img src="images/star_fill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			for($j=5;$j>$rate3;$j--)
			{
			?>
				<td>
				<img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			?>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve3" name="pay_txt" value="<?php print $rw['rate3'];?>.00" size="2" style="border:none;" readonly="readonly"/></td>
</tr>
<tr>
	<td><strong>Professionalism</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate4">
    <table><tr>
			<?php
			for($i=0;$i<$rate4;$i++)
			{
			?>
				<td>
				<img src="images/star_fill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			for($j=5;$j>$rate4;$j--)
			{
			?>
				<td>
				<img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			?>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve4" name="prf_txt" value="<?php print $rw['rate4'];?>.00" size="2" style="border:none;" readonly="readonly"/></td>
</tr>
<tr>
	<td><strong>Would work with again</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate5">
    <table><tr>
			<?php
			for($i=0;$i<$rate5;$i++)
			{
			?>
				<td>
				<img src="images/star_fill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			for($j=5;$j>$rate5;$j--)
			{
			?>
				<td>
				<img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
				</td>
			<?php
			}
			?>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve5" name="wld_txt" value="<?php print $rw['rate5'];?>.00" size="2" style="border:none;" readonly="readonly" /></td>
</tr>
<tr>
	<td valign="top"><strong>Comments</strong></td>
    <td>&nbsp;</td>
    <td colspan="6"><textarea name="comment_txt" rows="6" cols="25" readonly="readonly" style="border:none;"><?php print $rw['comments'];?></textarea></td>
</tr>
</table>
</body>
</html>