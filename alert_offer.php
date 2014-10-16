<?php
$rs1 = mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'P'");

if(mysql_num_rows($rs1)>0)

{
?>
 <?php 	while($rw1 = mysql_fetch_array($rs1))

		{
			$rw2 = mysql_fetch_array(mysql_query("select description,project from ".$prev."projects where id = '".$rw1['project_id']."'"));
			if($rw2){
?>
		
		<div class="alert alert-success apllybid-success-page" role="alert">
			<div class="apllybid-success">
				<span><i class="fa fa-check"></i></span>
				<p class="succ-job-info">
					You have a offer of project <a href="<?=$vpath?>offer/<?=$rw1['project_id']; ?>"><?php print $rw2[project];?></a>
				</p>
			</div>
		</div>
  <?php 
		 
	}
 } 
 
 ?>
 
<?php }  ?>