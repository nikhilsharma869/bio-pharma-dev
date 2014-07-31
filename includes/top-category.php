<?php
	if($_REQUEST['cat_id']!="")
	{
		$r=mysql_query("select * from " . $prev . "categories  where cat_id=".$_REQUEST['cat_id']." and status='Y' order by cat_name");
	}
	else
	{
		$r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
	}
	?>



<div class="recent_projects_middle">

<?php
    while($d=mysql_fetch_array($r))
    {
	?>
<div class="categories_box">
<h1>
<?php echo $d['cat_name'];?>
</h1>
<ul>

<?
	$select_skills="select * from " . $prev . "categories where parent_id='".$d['cat_id']."' and status='Y' order by cat_name limit 0,15";
	$rec_skills=mysql_query($select_skills);
	$num_skills=mysql_num_rows($rec_skills);
	if($num_skills > 0)
	{
					while($row_skills=mysql_fetch_array($rec_skills))
					{
							$select_count_project="select freelan_projects_cats.*,freelan_projects.* from freelan_projects_cats,freelan_projects where 						freelan_projects_cats.cat_id='".$row_skills['cat_id']."' and freelan_projects_cats.id=freelan_projects.id and freelan_projects.status='open'";
							$rec_count_project=mysql_query($select_count_project);
							$num_count_project=mysql_num_rows($rec_count_project);
							
                           
							 
?>
<li><a href="details.php?cat_id=<?php echo $row_skills['cat_id'] ?>"><?php echo $row_skills['cat_name'];?>.&nbsp;(<?php echo $num_count_project;?>)</a></li>

<?

				}
	}
?>


</ul>
</div>

<?
}
?>




</div>