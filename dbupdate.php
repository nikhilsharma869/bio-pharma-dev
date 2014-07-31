<?php 
	include "configs/path.php";
	session_start();
	//$sql = "ALTER TABLE freelan_buyer_bids ADD (chosen_id int(11) NOT NULL);";
	$sql="SELECT * FROM freelan_transactions";
	/*if(mysql_query($sql))
	{?>
		<script language="javascript">
		  alert("Table altered Successfully.");
		  window.location.href="index.php";
		</script>
	<?php }*/
	$row = mysql_query($sql);
	while($result = mysql_fetch_array($row)){
	echo '<pre>';
	print_r($result);
	echo '</pre>';
	}
	?>
