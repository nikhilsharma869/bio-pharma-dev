<?php
require_once("configs/config.php");
CheckLogin();

if($_GET['action'] == "validatePassword")
{
	$r=mysql_query("select user_id from ".$prev."user where password='".md5($_POST['oldPassword'])."' and user_id=".$_SESSION['user_id']);
	if(@mysql_num_rows($r))
	{
		echo "1";		
	}
	else
	{
		echo "0";
	}
	
}
if($_GET['action'] == "validateEmailId")
{
	$r=mysql_query("select user_id from ".$prev."user where email='".$_POST['email']."' and user_id!=".$_SESSION['user_id']);
	if(@mysql_num_rows($r))
	{
		echo "1";		
	}
	else
	{
		echo "0";
	}
	
}
?>