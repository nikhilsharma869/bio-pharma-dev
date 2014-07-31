<?php
include "configs/path.php"; 
	session_start();
$q = strtolower($_GET["q"]);
//if (!$q) return;
	$res_users=mysql_query("select * from ".$prev."user");
	while($row_users=mysql_fetch_array($res_users))
	{
		echo $row_users['username'].'<pre>';	
		print_r($row_users);
		echo '</pre>';
	}
	$items = array(
"Great Bittern"=>"Botaurus stellaris",
"Little Grebe"=>"Tachybaptus ruficollis",
"Black-necked Grebe"=>"Podiceps nigricollis",
"Heuglin's Gull"=>"Larus heuglini"
);

foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
	}
}

?>