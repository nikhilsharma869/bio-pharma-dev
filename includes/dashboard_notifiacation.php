<div class="latest_worbox">
<div class="latest_text">
          <h1>
            <?=$lang['NOTIFICATION']?>
          </h1>
       </div>
<div class="latest_work">
<div class="notifications">
          <?php
$res_notificationcount=@mysql_num_rows(mysql_query("select * from ".$prev."notification where user_id='".$_SESSION['user_id']."' AND (type ='".$_SESSION['user_type']."' OR type='B' ) order by add_date desc "));
		 $res_notification = mysql_query("select * from ".$prev."notification where user_id='".$_SESSION['user_id']."' AND (type ='".$_SESSION['user_type']."' OR type='B' ) order by add_date desc limit 0,3");

		 if(mysql_num_rows($res_notification)>0)

		 {
?>
         
            <?php
			 while($row_notification = mysql_fetch_array($res_notification))

			 {	?>
            <h1><a href="<?=$vpath?>dashboard.php?del=<?php print base64_encode($row_notification[id]);?>" title="Delete" onclick="javascript:if(confirm('Do you really want to delete ?')){return true;} else {return false;};"></a> <?php print $row_notification[message];?><span><?php print date('F d-y', strtotime($row_notification[add_date]));?></span> </h1>
            <?php

			 }
			 ?>
           <div class="notifications_line"></div>
    <h2><a href="<?=$vpath?>notification.html"><?=$lang['ALL_NOTIFICATIONS'] ?> (<?=$res_notificationcount?>)</a>   |   <a href="<?=$vpath?>message.html"><?=$lang['INBOX']?> (<?=$unreadmsg[unread]?>)</a></h2>
         
          <?php

    	 }else{	?>
          <h3>
            <?=$lang['NO_RECORD_FOUND'  ]?>
          </h3>
          <? } ?>
        </div>
      </div>  </div>
	  	 