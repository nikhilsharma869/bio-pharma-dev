<?php 
	include "configs/path.php"; 
	include("country.php");
	session_start();

	$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where id='41'"));
?>


<div>

<?=html_entity_decode($row_content['contents'])?>

</div>