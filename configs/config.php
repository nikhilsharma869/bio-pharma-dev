<?php
ob_start();
@session_start();
ini_set("display_errors","OFF");
error_reporting(E_ALL & ~E_NOTICE);
//include("pod_connect.php");

	$dbhost="localhost"; 

	$dbuser="biophar4_Uodesk"; //mysql username	

	$dbpass="KeP2mtSQvk&c"; // mysql password	

	$dbname="biophar4_odesk-clone"; //mysql database name

	$vpath="http://".$_SERVER['HTTP_HOST']."/"; 
        $apath=$_SERVER['DOCUMENT_ROOT']."/"; 

	$fckapath = $apath."fckeditor/";

	$fckbasepath = $vpath."fckeditor/";

	$captcha_path =  $_SERVER['DOCUMENT_ROOT']."/captcha/";

	$calendar_path = $_SERVER['DOCUMENT_ROOT']."/calendar/";

	$scriptaculous_path = $_SERVER['DOCUMENT_ROOT']."/scriptaculous/";
	


//database connection



$dbh=mysql_connect($dbhost, $dbuser, $dbpass) or die ('I cannot connect to the database because: ' . mysql_error());



$db=mysql_select_db($dbname, $dbh) or die ('I cannot select the database because: ' . mysql_error());



$prev="serv_"; // table perfix

$dotcom_site = "bio-pharma";

$dotcom="bio-pharma.com"; //site name

?>