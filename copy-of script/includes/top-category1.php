
<table cellpadding=4 cellspacing=0 border=0 width=98% align=center>
<tr>

<?php
$j=0;
$select_count_project="SELECT `".$prev."categories`.`cat_id`,`".$prev."categories`.`cat_name`,count(`".$prev."projects`.`id`) as 'pnum' FROM `".$prev."projects`,`".$prev."projects_cats`,`".$prev."categories` WHERE `".$prev."projects`.`status`='open' and   `".$prev."projects_cats`.`id`=`".$prev."projects`.`id` and `".$prev."categories`.`cat_id`=`".$prev."projects_cats`.`cat_id` group by `".$prev."categories`.`cat_id` order by `".$prev."categories`.cat_name";

	$rec_skills=mysql_query($select_count_project);
	
	while($row_skills=mysql_fetch_array($rec_skills))
	{
		$ppm="cat_id=".$row_skills['cat_id']."&projectStatus=&budget_min=&budget_max=";
		{
		?>
		<td width=25%><a class="link_class" href="<?=$vpath?>Jobs/1/<?=$row_skills['cat_id']?>/<?=$row_skills['cat_name']?>/"><?php echo $row_skills['cat_name'];?>.&nbsp;(<?php echo $row_skills['pnum'];?>)</a></td>

		<?php
		$j++;
		}
		if(!($j%4)):
		   echo"</tr><tr>";
		endif;
	}
	
?>
</table>
