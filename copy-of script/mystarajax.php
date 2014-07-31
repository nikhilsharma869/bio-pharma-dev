<?php
if(isset($_GET['mid']))
{
	$str = '';
	$str1 = '';
	for($i=1;$i<=$_GET['mid'];$i++)
	{
		$str.="<td><img src=\"images/star_fill.png\"/></td>";
	}
	for($j=$_GET['mid']+1;$j<=5;$j++)
	{
		$str1.="<td><img src=\"images/star_unfill.png\"/></td>";
	}
	
}
print " <table><tr>".$str.$str1."</tr></table>";
?>