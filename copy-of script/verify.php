<?php 
	include "configs/path.php"; 
	include("country.php");
	session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
	$r=mysql_query("select * from  ". $prev . "user where  (username=\"" . txt_value($_POST['username']) . "\" or email=\"".txt_value($_POST['username']). "\") and  strcmp(\"" . md5($_POST['password']) . "\", password)=0 and status='Y'");
//	echo"select * from  ". $prev . "user where  (username=\"" . txt_value($_POST['username']) . "\" or email=\"".txt_value($_POST['username']). "\") and  strcmp(\"" . md5($_POST['password']) . "\", password)=0 and status='Y'";
	$n=@mysql_num_rows($r);
	if($n)
	{	
		session_regenerate_id();
		$fname=txt_value_output(@mysql_result($r,0,"fname"));
		$lname=txt_value_output(@mysql_result($r,0,"lname"));
		$_SESSION['fullname'] = $fname.' '.$lname;
		$_SESSION['user_id']	=@mysql_result($r,0,"user_id");
		$_SESSION['username']	=txt_value_output(@mysql_result($r,0,"username"));
		$_SESSION['email']		=txt_value_output(@mysql_result($r,0,"email"));
		$_SESSION['zip']		=txt_value_output(@mysql_result($r,0,"zip"));
		$_SESSION['user_type']	=txt_value_output(@mysql_result($r,0,"user_type"));
		$_SESSION['ldate']	    =@mysql_result($r,0,"ldate");
		$_SESSION['gold_member']	    =@mysql_result($r,0,"gold_member");
		$_SESSION['ip']	        =@mysql_result($r,0,"ip");
		$user_type              =txt_value_output(@mysql_result($r,0,"user_type"));
		$profile                =txt_value_output(@mysql_result($r,0,"profile"));
		
		
		$r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);
		//echo "update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . ", ldate=NOW() where user_id=".$_SESSION['user_id'];die();													
		if($user_type=="W" || $user_type=="B")
		{
		    $n=@mysql_num_rows(mysql_query("select user_id from ".$prev."user_cats  where user_id=".$_SESSION['user_id']." limit 1"));
		   /* if(!$n || !$profile){ pageRedirect($vpath."profile.php");}*/
		   
		    if(!$n || !$profile){ pageRedirect($vpath."dashboard.php");}
		}
		
		if($_REQUEST['referer'])
		{
		   redirect($vpath.txt_value($_REQUEST['referer']));
		}
		else
		{
		   redirect($vpath."dashboard.php");
		}
	}					
	else
	{
		redirect($vpath."login.php?msg=Please enter a valid username and password");						
	}	
}