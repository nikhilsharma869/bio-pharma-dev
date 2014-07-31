<?php
include "configs/config.php";
$rsu =mysql_query("SELECT maintenance_msg,maintenance_desc,maintenance_status FROM ".$prev."setting LIMIT 1");
$undermain = @mysql_fetch_array($rsu);
?>
<div align=center style="color:red"><h2><?=$undermain[maintenance_msg]?></h2></div>
<div align=center><p><?=nl2br($undermain[maintenance_desc])?></p></div>