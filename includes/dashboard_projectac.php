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
	<div class="testing_box">
  <h1>  <?php print $rw2[project];?> <br />
  <? echo substr($rw2['description'],0,100);?><br /><br />
</h1>
<div style="width:230px; float:right;">
<div class="decline_bott"><a href="<?=$vpath?>dashboard.php?mode=deny&id=<?php echo $rw1['project_id'] ?>&deny=<?php echo $rw1['project_id'] ?>"><?=$lang['DECLINE']?></a></div>           
<div class="accept_bott"><a href="<?=$vpath?>my-jobs.php?mode=accept&id=<?php echo $rw1['project_id'] ?>&confirm=<?php echo $rw1['project_id'] ?>"><?=$lang['ACCEPT']?></a></div>
</div>

</div>	
		
		
		
       
           
            
           
            <?php }} ?>
         
        <?php }  ?>