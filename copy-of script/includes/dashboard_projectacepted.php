 <?php

		$rs2 = mysql_query("SELECT ".$prev."projects.*, ".$prev."buyer_bids.* FROM ".$prev."projects, ".$prev."buyer_bids WHERE ".$prev."projects.id = ".$prev."buyer_bids.project_id and ".$prev."projects.user_id = '".$_SESSION[user_id]."' and ".$prev."buyer_bids.chose = 'Y' order by ".$prev."buyer_bids.id desc limit 0, 3");

	if(mysql_num_rows($rs2)>0)

	{ ?>
      <div class="notification">
        <div class="notification_text">
          <h1>
            <?=$lang['PROJECT_ACTION'  ]?>
          </h1>
        </div>
        <div class="notific_text">
          <?php 	while($rw3 = mysql_fetch_array($rs2))

			{

			$rw4 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw3[bidder_id]."'"));

				?>
          <h1>
            <?=$lang['CONGRULATIONS' ]?>
            , <strong><?php print $rw4[fname];?></strong>
            <?=$lang['MID3' ]?>
            <?php print $rw3[project];?></h1>
          <?php } ?>
        </div>
      </div>
      <?php }  ?>