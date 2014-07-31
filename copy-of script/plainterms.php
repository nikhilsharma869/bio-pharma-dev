<? include("configs/path.php")?>

<body left-margin=0 right-mareing=0>
<span class=h2><b><?=$dotcom?></b> Terms of Service</h2>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
				
				<tr><td><?php
$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='Terms'"));
echo html_entity_decode($row_content['contents']);
?>
</td>
			</tr>
			</table>
			<p >Please <a href="#" onClick="javascript:window.parent.location='contact_us.php';">contact us</a> to report violations of terms and conditions.</p>
</body>

