<?php
session_start();
include "configs/path.php";
CheckLogin();
$err1 = '';
$succ = '';
$avg_star_rate = 0;
if(isset($_POST['rate_sub'])&&($_POST['rate_sub']=='Submit'))
{
	$err1 = '';
	$avg_star_rate = 0;
	if($_POST['comment_txt']!='')
	{
		$avg_star_rate = round((intval($_POST['my_txt'])+intval($_POST['com_txt'])+intval($_POST['pay_txt'])+intval($_POST['prf_txt'])+intval($_POST['wld_txt']))/5);
		$res = mysql_query("insert into ".$prev."feedback set
		project_id = '".$_POST['projhid']."',
		bidid = '".$_POST['bidhid']."',
		feedback_from = '".$_POST['emphid']."',
		feedback_to = '".$_POST['bidderhid']."',
		comments = '".$_POST['comment_txt']."',
		avg_rate = '".$avg_star_rate."',
		rate1 = '".$_POST['my_txt']."',
		rate2 = '".$_POST['com_txt']."',
		rate3 = '".$_POST['pay_txt']."',
		rate4 = '".$_POST['prf_txt']."',
		rate5 = '".$_POST['wld_txt']."', add_date=now()");
		if($res)
		{
			print '<script>parent.location.href=\'closed_jobs.html\';</script>';
		}
		else
		{
			$err1 = 'DB Error , Please try later . . .';
		}
	}
	else
	{
		$err1 = 'Please provide comments . . .';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
 <script type="text/javascript" src="js/starrating.js"></script> 
</head>
<body>
<?php
if((isset($err1))&&($err1!=''))
{
?>
<table width="380" height="30" style="border:solid 1px #F00; background-color:#FCC;-webkit-border-radius:6px;-moz-border-radius:6px">
    <tr>
    	<td style="padding-left: 20px;"><font size="-2"><strong><?php print $err1;?></strong></font></td>
    </tr>
    </table>
<?php
}
?>
<form name="ratingtest_frm" action="" method="post">
<table width="400" height="200">
<tr>
	<th colspan="8" bgcolor="#CCCCCC" height="35" style="-webkit-border-radius:6px; -moz-border-radius:6px;">
    Employer Rating</th>
</tr>
<tr>
	<td style="width:160px;"><strong>Average Rating</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="staravg_rate1">
    <table><tr>
    <td>
    <img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
    </td>
    <td>
    <img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
    </td>
    <td>
    <img src="images/star_unfill.png"style="width:21px; height:21px;"/> 
    </td>
    <td>
    <img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
    </td>
    <td>
    <img src="images/star_unfill.png" style="width:21px; height:21px;"/> 
    </td>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ver" size="2" value="0.00" style="border:none;" readonly="readonly"/></td>
</tr>
<tr><td colspan="8"><hr style="color:#CCC;" /></td></tr>
<tr>
	<td><strong>Quality of Work</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate1">
    <table><tr>
    <td>
    <img src="images/star_unfill.png" id="my1" style="width:21px; height:21px;" onmouseover="fun_mouseover('my', 1)" onmouseout="fun_mouseout('my', 1)" onclick="fun_onclick('my', 1, 1)"/> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="my2" style="width:21px; height:21px;" onmouseover="fun_mouseover('my', 2)" onmouseout="fun_mouseout('my', 2)" onclick="fun_onclick('my', 2, 1)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="my3" style="width:21px; height:21px;" onmouseover="fun_mouseover('my', 3)" onmouseout="fun_mouseout('my', 3)" onclick="fun_onclick('my', 3, 1)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="my4" style="width:21px; height:21px;" onmouseover="fun_mouseover('my', 4)" onmouseout="fun_mouseout('my', 4)" onclick="fun_onclick('my', 4, 1)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="my5" style="width:21px; height:21px;" onmouseover="fun_mouseover('my', 5)" onmouseout="fun_mouseout('my', 5)" onclick="fun_onclick('my', 5, 1)" /> 
    </td>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve1" name="my_txt" value="0.00" size="2" style="border:none;" readonly="readonly"/></td>
</tr>
<tr>
	<td><strong>Communication</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate2">
    <table><tr>
    <td>
    <img src="images/star_unfill.png" id="com1" style="width:21px; height:21px;" onmouseover="fun_mouseover('com', 1)" onmouseout="fun_mouseout('com', 1)" onclick="fun_onclick('com', 1, 2)"/> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="com2" style="width:21px; height:21px;" onmouseover="fun_mouseover('com', 2)" onmouseout="fun_mouseout('com', 2)" onclick="fun_onclick('com', 2, 2)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="com3" style="width:21px; height:21px;" onmouseover="fun_mouseover('com', 3)" onmouseout="fun_mouseout('com', 3)" onclick="fun_onclick('com', 3, 2)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="com4" style="width:21px; height:21px;" onmouseover="fun_mouseover('com', 4)" onmouseout="fun_mouseout('com', 4)" onclick="fun_onclick('com', 4, 2)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="com5" style="width:21px; height:21px;" onmouseover="fun_mouseover('com', 5)" onmouseout="fun_mouseout('com', 5)" onclick="fun_onclick('com', 5, 2)" /> 
    </td>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve2" name="com_txt" value="0.00" size="2" style="border:none;" readonly="readonly"/></td>
</tr>
<tr>
	<td><strong>Expertise</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate3">
    <table><tr>
    <td>
    <img src="images/star_unfill.png" id="pay1" style="width:21px; height:21px;" onmouseover="fun_mouseover('pay', 1)" onmouseout="fun_mouseout('pay', 1)" onclick="fun_onclick('pay', 1, 3)"/> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="pay2" style="width:21px; height:21px;" onmouseover="fun_mouseover('pay', 2)" onmouseout="fun_mouseout('pay', 2)" onclick="fun_onclick('pay', 2, 3)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="pay3" style="width:21px; height:21px;" onmouseover="fun_mouseover('pay', 3)" onmouseout="fun_mouseout('pay', 3)" onclick="fun_onclick('pay', 3, 3)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="pay4" style="width:21px; height:21px;" onmouseover="fun_mouseover('pay', 4)" onmouseout="fun_mouseout('pay', 4)" onclick="fun_onclick('pay', 4, 3)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="pay5" style="width:21px; height:21px;" onmouseover="fun_mouseover('pay', 5)" onmouseout="fun_mouseout('pay', 5)" onclick="fun_onclick('pay', 5, 3)" /> 
    </td>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve3" name="pay_txt" value="0.00" size="2" style="border:none;" readonly="readonly"/></td>
</tr>
<tr>
	<td><strong>Professionalism</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate4">
    <table><tr>
    <td>
    <img src="images/star_unfill.png" id="prf1" style="width:21px; height:21px;" onmouseover="fun_mouseover('prf', 1)" onmouseout="fun_mouseout('prf', 1)" onclick="fun_onclick('prf', 1, 4)"/> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="prf2" style="width:21px; height:21px;" onmouseover="fun_mouseover('prf', 2)" onmouseout="fun_mouseout('prf', 2)" onclick="fun_onclick('prf', 2, 4)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="prf3" style="width:21px; height:21px;" onmouseover="fun_mouseover('prf', 3)" onmouseout="fun_mouseout('prf', 3)" onclick="fun_onclick('prf', 3, 4)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="prf4" style="width:21px; height:21px;" onmouseover="fun_mouseover('prf', 4)" onmouseout="fun_mouseout('prf', 4)" onclick="fun_onclick('prf', 4, 4)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="prf5" style="width:21px; height:21px;" onmouseover="fun_mouseover('prf', 5)" onmouseout="fun_mouseout('prf', 5)" onclick="fun_onclick('prf', 5, 4)" /> 
    </td>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve4" name="prf_txt" value="0.00" size="2" style="border:none;" readonly="readonly"/></td>
</tr>
<tr>
	<td><strong>Would work with again</strong></td>
    <td>&nbsp;</td>
    <td colspan="5">
    <div id="star_rate5">
    <table><tr>
    <td>
    <img src="images/star_unfill.png" id="wld1" style="width:21px; height:21px;" onmouseover="fun_mouseover('wld', 1)" onmouseout="fun_mouseout('wld', 1)" onclick="fun_onclick('wld', 1, 5)"/> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="wld2" style="width:21px; height:21px;" onmouseover="fun_mouseover('wld', 2)" onmouseout="fun_mouseout('wld', 2)" onclick="fun_onclick('wld', 2, 5)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="wld3" style="width:21px; height:21px;" onmouseover="fun_mouseover('wld', 3)" onmouseout="fun_mouseout('wld', 3)" onclick="fun_onclick('wld', 3, 5)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="wld4" style="width:21px; height:21px;" onmouseover="fun_mouseover('wld', 4)" onmouseout="fun_mouseout('wld', 4)" onclick="fun_onclick('wld', 4, 5)" /> 
    </td>
    <td>
    <img src="images/star_unfill.png" id="wld5" style="width:21px; height:21px;" onmouseover="fun_mouseover('wld', 5)" onmouseout="fun_mouseout('wld', 5)" onclick="fun_onclick('wld', 5, 5)" /> 
    </td>
    </tr></table>
    
    </div>
    </td>
    <td align="right" style="border-left:#999 1px dotted;"><input type="text" id="ve5" name="wld_txt" value="0.00" size="2" style="border:none;" readonly="readonly" /></td>
</tr>
<tr>
	<td valign="top"><strong>Comments</strong></td>
    <td>&nbsp;</td>
    <td colspan="6"><textarea name="comment_txt" rows="6" cols="25"></textarea></td>
</tr>
<tr><td colspan="8" align="center">
<input type="hidden" name="projhid" value="<?php print $_GET['pid'];?>" />
<input type="hidden" name="bidhid" value="<?php print $_GET['bid'];?>" />
<input type="hidden" name="emphid" value="<?php print $_GET['eid'];?>" />
<input type="hidden" name="bidderhid" value="<?php print $_GET['cid'];?>" />
<input type="submit" name="rate_sub" value="Submit" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" onclick="return resfun();" /></td></tr>
</table>
</form>
</body>
</html>