<?php
if($_GET['addr'])
{
	$cid = $_GET['addrid'];
	print "<input type=\"submit\" name=\"sub".$cid."\" onclick=\"javascript:this.form.submit();\" value=\"Confirm\" style=\"width:50px; height:22px;\"/>";
	print "&nbsp;&nbsp;&nbsp;&nbsp;";
	print "<input type=\"submit\" name=\"subcan".$cid."\" value=\"Cancel\" style=\"width:50px; height:22px;\"/>";
}
?>