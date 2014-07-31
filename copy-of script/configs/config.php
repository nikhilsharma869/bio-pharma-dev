<?php
ob_start();
@session_start();
ini_set("display_errors","OFF");
error_reporting(E_ALL & ~E_NOTICE);
//include("pod_connect.php");
if(($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.0.250"))
{
    //echo "aa";
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "redhat";
	$dbname = "odesk-clone";
	$vpath = "http://".$_SERVER['HTTP_HOST']."/serverc/odesk-clone/";
	$apath = $_SERVER['DOCUMENT_ROOT']."/serverc/odesk-clone/";
	$fckapath = $_SERVER['DOCUMENT_ROOT']."/serverc/odesk-clone/fckeditor/";
	$fckbasepath = $vpath. "fckeditor/";
	$captcha_path = "/serverc/odesk-clone/captcha/";
	$calendar_path = "/calendar_new/";
	$scriptaculous_path = "/scriptaculous/";
}
else
{
	$dbhost="localhost"; 

	$dbuser="lab21oneo_less"; //mysql username	

	$dbpass="y8f,Ue(L#,o3"; // mysql password	

	$dbname="lab2oneo_freelance4less"; //mysql database name

	$vpath="http://".$_SERVER['HTTP_HOST']."/freelancer4less/"; 
        $apath=$_SERVER['DOCUMENT_ROOT']."/freelancer4less/"; 

	$fckapath = $apath."fckeditor/";

	$fckbasepath = $vpath."fckeditor/";

	$captcha_path =  $_SERVER['DOCUMENT_ROOT']."/captcha/";

	$calendar_path = $_SERVER['DOCUMENT_ROOT']."/calendar/";

	$scriptaculous_path = $_SERVER['DOCUMENT_ROOT']."/scriptaculous/";
	
}

//database connection



$dbh=mysql_connect($dbhost, $dbuser, $dbpass) or die ('I cannot connect to the database because: ' . mysql_error());



$db=mysql_select_db($dbname, $dbh) or die ('I cannot select the database because: ' . mysql_error());



$prev="serv_"; // table perfix

$dotcom_site = "odesk-clone";

$dotcom="odesk-clone.com"; //site name

?>