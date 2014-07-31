<?php

$host="localhost";
$user="root";
$pass="redhat";
//$user_db='life2atz_tracker';

$user_db='freelancer-pinoy';


$sql_con=mysql_connect($host,$user,$pass);
$sql_db=mysql_select_db($user_db);
?>
