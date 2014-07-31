<?php
include("../configs/path.php");
if(isset($_REQUEST[submit])) {		
	$project_id=$_REQUEST['project_id'];
	$bidder=$_REQUEST['bidder'];

	$r="UPDATE ".$prev."buyer_bids SET `chose`='N',`chosen_id`='0' WHERE project_id='".$project_id."'";
	 mysql_query($r);
	$r1="UPDATE ".$prev."buyer_bids SET `chose`='P',`chosen_id`='".$bidder."' WHERE project_id='".$project_id."' AND bidder_id='".$bidder."'";
	mysql_query($r1);


  $r="UPDATE ".$prev."projects SET `chosen_id`='".$bidder."' WHERE id='".$project_id."'";

mysql_query($r);
if($r){
$fetch_user=mysql_fetch_assoc(mysql_query("SELECT `fname`,`lname`,`email` FROM ".$prev."user WHERE user_id='".$bidder."'"));
				$from=$setting['admin_mail'];
						
						$mail_id=$fetch_user['email'];
						
						$mail_type = 'select_provider';
						
						
					 $row_mail_type = mysql_fetch_array(mysql_query("select * from ".$prev."mailsetup where mail_type = '".$mail_type."'"));
						
						$body = html_entity_decode($row_mail_type['header']) . $msg . html_entity_decode($row_mail_type['footer']);
						
						 $body1=str_replace("{first_name}",$fetch_user['fname'],$body);
						 $body1=str_replace("{last_name}",$fetch_user['lname'],$body1);
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
						$headers .= "From:$dotcom <" . $from . ">\r\n";
						$headers .= "Reply to: $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
						
						mail($mail_id,$setting[companyname] . 'bid won by admin',$body1,$headers);
					
}
	 $_SESSION['msg']="<font face=verdana size=1 color=green><b style='margin-left:30px;'>Bid won Successful.</b></font>";
	 echo"<script>window.location.href='bid_list.php?id=".$project_id."';</script>";
  }
			
?>
