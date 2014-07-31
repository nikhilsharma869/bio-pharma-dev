<?php
if(substr_count($_SERVER['HTTP_HOST'],"localhost")):
    $dbh=mysql_connect("localhost","root","password") or die ('I cannot connect to the database because 1: ' . mysql_error());
    $db=mysql_select_db("oneoutsource",$dbh) or die ('I cannot connect to the database because 2: ' . mysql_error());
	$vpath="http://localhost/oneoutsource/";

elseif(substr_count($_SERVER['HTTP_HOST'],"serverl")):
    $dbh=mysql_connect("localhost","root","") or die ('I cannot connect to the database because 1: ' . mysql_error());
    $db=mysql_select_db("spts",$dbh) or die ('I cannot connect to the database because 2: ' . mysql_error());
	$vpath="http://serverl/o/oneoutsource/";
else:
	$dbh=@mysql_connect ("localhost", "oneoutso_source", "eH1BIlbB7dgz") or die ('I cannot connect to the database because: ' . mysql_error());
    $db=@mysql_select_db ("oneoutso_outsource"); 
	$vpath="http://www.oneoutsource.com/";
	$apath=$_SERVER['DOCUMENT_ROOT']."/";
endif;
$prev="oo_";
$dotcom="Oneoutsource.com";
$source_ar[1]="GAF";
$source_ar[2]="GAC";
$source_ar[3]="SL";
$source_ar[4]="EU";
?>