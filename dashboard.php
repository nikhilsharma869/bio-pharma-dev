<?php 

	$current_page = "Dashboard";

	include "includes/header.php";

	CheckLogin();

	

	if(isset($_GET[del]))

	{

		mysql_query("delete from ".$prev."notification where id='".base64_decode($_GET[del])."'");

		header("location:dashboard.html");

	}



if($_REQUEST[deny] && $_REQUEST[mode])

			{
					$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$_SESSION['user_id']));

					$proj = mysql_fetch_array(mysql_query("SELECT * from ".$prev."projects where id=".$_GET['id']));

					$emp = 	mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$proj['user_id']));	

				$tuu=mysql_query("UPDATE " . $prev . "buyer_bids SET chose='D' WHERE project_id='$_REQUEST[deny]' and bidder_id='$_SESSION[user_id]' and chose='P'");
				if($tuu){
				
mysql_query("UPDATE " . $prev . "projects SET chosen_id='0',status='open' WHERE id='$_REQUEST[deny]' and status='frozen'");
$to=$emp[email];
$to1=$usr[email];                                                            $prurl = $vpath . "project/" . $proj['id'] . "/" . str_replace("/", "", str_replace(" ", "-", $proj['id'])) . ".html";
																				 $from = $setting['admin_mail'];
																			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='reject_project_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
																			if (mysql_num_rows($mailqf) == 0) {
																			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='reject_project_for_freelancer' AND `langid`='en'");
																			}

																			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='reject_project_for_employe' AND `langid`='" . getUserLastLang($proj['user_id']) . "'");
																			if (mysql_num_rows($mailqe) == 0) {
																			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='reject_project_for_employe' AND `langid`='en'");
																			}

																			$mailrf = mysql_fetch_assoc($mailqf);
																			$mailre = mysql_fetch_assoc($mailqe);

																			$mailbodyf = html_entity_decode($mailrf['body']);
																			$mailbodye = html_entity_decode($mailre['body']);
                                                                        $subjectf = html_entity_decode($mailrf['subject']);
                                                                        $mailbodyf = str_replace("{username}", $emp['username'], $mailbodyf);
                                                                        $mailbodyf = str_replace("{project}", "<a href='" . $prurl . "'>" .  $proj[project].'</a>', $mailbodyf);
																		$mailbodyf = str_replace("{employer}", $usr[username], $mailbodyf);
																	
																	    $headers = "MIME-Version: 1.0\r\n";
                                                                        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                                                                        $headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
                                                                        $headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
																		
																		
																		$subjecte = html_entity_decode($mailre['subject']);
																		$mailbodye = str_replace("{username}", $usr['username'], $mailbodye);
																		$mailbodye = str_replace("{project}", "<a href='" . $prurl . "'>" . $proj[project].'</a>', $mailbodye);
																		$mailbodye = str_replace("{freelancer}", $emp[username], $mailbodye);
																												

                                                                        mail($to, $subjectf, $mailbodyf, $headers);

                                                                         mail($to1, $subjecte, $mailbodye, $headers);
}
				header("Location: Jobs/");

			}

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");



$row=mysql_fetch_array($res);
$_SESSION['username']	=$row['username'];


			

			$row1 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".base64_decode($_GET[id])."'"));

			

			$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));

			

			$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));

			

			$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);

			

			$sum=0;

			$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");

			

	while($row4pend=mysql_fetch_array($res4pend))

	{

		$sum+=$row4pend['amount'];

	}

	$sum1=number_format($sum,2);

?>
<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['DASH_PGNM']?></a></p></div>
<div class="clear"></div>
  
  <!--Profile Left Start-->
  
  <?php include 'includes/dashboard_menu.php';?>
  
  <!--Profile Left End--> 
  
  <!--Profile Right Start-->
  
  <div class="profile_right">
   
	  <div class="profile_righttext"><div class="view_bnt"><a class="btn-custom-blue" href="<?=$vpath?>publicprofile/<?=$_SESSION[username]?>/"><?=$lang['VIEW_PROFILE']?></a></div><h1><?=$lang['BALANCE']?> : <?=$curn?> <?=$balsum?></h1> </div>
	   <!--**************Worker****************************************************************-->
   
 
  
  <!--**************both****************************************************************-->
  
  <!-----------skills-------------->	
<? //include("includes/dashboard_skills.php")?>
<!-----------skills-------------->

<!-----------Notification-------------->
<? include("includes/dashboard_notifiacation.php")?>				  
<!-----------Notification-------------->

 <!-----------project status-------------->	
     <? include("includes/dashboard_projectac.php")?>
	 <!-----------project status-------------->	
	 
	<!-----------project statusaccept-------------->	
     <? include("includes/dashboard_projectacepted.php")?>
	 <!-----------project statusaccept-------------->	 
  
	<!-----------project dashboard_status-------------->
     <? include("includes/dashboard_status.php")?>
	  <!-----------project dashboard_status-------------->
    
	
  <div class="latest_worbox">
<div class="latest_text">
        <h1>
          <?=$lang['FUSION_CHART']?>
        </h1>
      </div>
<div class="latest_work">
<div class="notifications">
      <?php

		if($row['user_type']=="E")

		{

		?>
      <span style='color: #535353;font-family: Arial,Helvetica,sans-serif;'>
      <?=$lang['pr_m6']?>
      </span>
      <div class="fution_chrt" style="float:none; padding-left: 96px;width: 420px;"><img src="<?=$vpath?>pie.php"  /></div>
      <?php

		 }

		 else if($row['user_type']=="W")

		 {

		 ?>
      <span style='color: #535353;font-family: Arial,Helvetica,sans-serif;'>
      <?=$lang['pr_m5']?>
      </span>
	  <?
	  $querych=mysql_query("select * from ".$prev."projects p inner join ".$prev."buyer_bids b on p.id=b.project_id where b.bidder_id='".$_SESSION['user_id']."' group by b.project_id");
	   $query1=@mysql_num_rows($query);
	   if($query1>0){
	  ?>
      <div class="fution_chrt" style="float:none; padding-left: 96px;width: 420px;"><img src="<?=$vpath?>pieb.php"  /></div>
      <?php
		}else{
	echo '<p style="padding-left: 20px;">No Chart</p>';
		}
		  }

		  else

		  {

		 $qry= mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");

		 $resqry=mysql_num_rows($qry);

		 if( $resqry>0)

		 {

		  ?>
      <span style='color: #535353;font-family: Arial,Helvetica,sans-serif;'>
      <?=$lang['pr_m6']?>
      </span>
      <div class="fution_chrt" style="float:none; padding-left: 96px;width: 420px;"><img src="<?=$vpath?>pie.php"  /></div>
      <div class="clear" style="height:20px;"></div>
      <?php

		}

		?>
      <span style='color: #535353;font-family: Arial,Helvetica,sans-serif;'>
      <?=$lang['pr_m5']?>
      </span>
	  <?
	  $querych=mysql_query("select * from ".$prev."projects p inner join ".$prev."buyer_bids b on p.id=b.project_id where b.bidder_id='".$_SESSION['user_id']."' group by b.project_id");
	   $query1=mysql_num_rows($query);
	   if($query1>0){
	  ?>
      <div class="fution_chrt" style="float:none; padding-left: 96px;width: 420px;"><img src="<?=$vpath?>pieb.php"  /></div>
      <?php
		}else{
		echo '<p style="padding-left: 20px;">No Chart</p>';
		}
		  }

		  ?>
      <div class="clear" style="height:20px;"></div>
    </div>  </div>
  </div>
</div>


<!--Profile Right End-->

</div>
</div></div>
<!--<div style="clear:both; height:10px;"></div>-->
<?php include 'includes/footer.php';?>
