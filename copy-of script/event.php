<?php 
	include "configs/path.php";
	session_start();
	CheckLogin();
	include("country.php");
	//print_r($_GET);
	//echo "select * from ".$prev."events where reminder_on='$_GET[y]-$_GET[m]-$_GET[cdate]'"; exit;
	//$sql="select * from ".$prev."events where reminder_on='$_GET[y]-$_GET[m]-$_GET[cdate]'";
	$sql="select * from ".$prev."projects where expires between ".mktime(0,0,0,$_GET[m],$_GET[cdate],$_GET[y])." and ".mktime(23,59,59,$_GET[m],$_GET[cdate],$_GET[y])."";
	
	$result=mysql_query($sql);
	echo '<ul>';
	while($row = mysql_fetch_array($result))
	  {
	  	echo '<li><span class="reminder">'.$row['project'].'<br></span></li>';
	  }
	 
	  
	  $rr=mysql_query("select * from " . $prev . "events where user_id='" . $_SESSION['user_id']."' and reminder_on='".$_GET[y]."-".$_GET[m]."-".$_GET[cdate]."'");
	
	 
	  if(mysql_num_rows($rr)!=0)
	  {
		  while($row = mysql_fetch_array($rr))
		  {
			echo '<li><span class="reminder"> '.$row['reminder'].'<br></span></li>';
		  }
	  }
	  echo '</ul>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>