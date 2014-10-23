<?php
$current_page = "<p>My Jobs Posting</p>";
$cur_par_menu = "job_posting";
$cur_child_menu = "my_projects";

include "includes/header.php";
CheckLogin();

$alert = "";
?>

<?php

$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION['user_id']."'"));

$type=$row_user['user_type'];



if($_REQUEST[confirm] && $_REQUEST[mode])
{
		if(mysql_query("UPDATE " . $prev . "buyer_bids SET chose='Y' WHERE project_id='$_REQUEST[confirm]' and bidder_id='$_SESSION[user_id]'"))

			{

				mysql_query("UPDATE " . $prev . "projects SET status='process' WHERE id='$_REQUEST[confirm]' and chosen_id='$_SESSION[user_id]'");

						$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$_SESSION['user_id']));

						$proj = mysql_fetch_array(mysql_query("SELECT * from ".$prev."projects where id=".$_GET['id']));

						$emp = 	mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$proj['user_id']));	
						

						$message = $lang['BID_ACCPT']."<br /><br />".

									$lang['PROJECT_NAMEE'].": ".$proj['project'];

						//exit;

						$msg = mysql_query("INSERT into ".$prev."messages set 

																	receiver=".$emp['user_id'].",

																	sender_id=".$_SESSION['user_id'].",

																	sender='".$usr['email']."' ,

																	subject='".$lang['BID_ACCPT']."',

																	message='".$message."',

																	user_type='sender',

																	sent_time='".date('Y-m-d h:i:s')."',

																	status='Y',

																	message_type='A'");

						

						$msg2 = mysql_query("INSERT into ".$prev."messages set 

																	receiver=".$emp['user_id'].",

																	sender_id=".$_SESSION['user_id'].",

																	sender='".$usr['email']."' ,

																	subject='".$lang['BID_ACCPT']."',

																	message='".$message."',

																	user_type='reciver',

																	sent_time='".date('Y-m-d h:i:s')."',

																	status='Y',

																	message_type='A'");

				

			

						// $notify = mysql_query("INSERT into ".$prev."notification set user_id=".$emp['user_id'].", message='".$lang['BID_ACCPT']."', add_date='".date('Y-m-d')."'");
						$link = $vpath.'contract/'.$proj['id'];
						$notify = add_notification($emp['user_id'], $lang['BID_ACCPT'], 'E', $link);

						$to  = $emp['email'];
						$to1=$usr['email'];

						$prurl = $vpath . "project/" . $proj['id'] . "/" . str_replace("/", "", str_replace(" ", "-", getproject($proj['id']))) . ".html";
						$from = $setting['admin_mail'];
						$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='accept_project_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
						if (mysql_num_rows($mailqf) == 0) {
							$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='accept_project_for_freelancer' AND `langid`='en'");
						}

						$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='accept_project_for_employe' AND `langid`='" . getUserLastLang($proj['user_id']) . "'");
						
						if (mysql_num_rows($mailqe) == 0) {
							$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='accept_project_for_employe' AND `langid`='en'");
						}

							$mailrf = mysql_fetch_assoc($mailqf);
							$mailre = mysql_fetch_assoc($mailqe);

							$mailbodyf = html_entity_decode($mailrf['body']);
							$mailbodye = html_entity_decode($mailre['body']);
							
							$subjectf = html_entity_decode($mailrf['subject']);
							$mailbodyf = str_replace("{username}", $emp['username'], $mailbodyf);
							$mailbodyf = str_replace("{project}","<a href='" . $prurl . "'>" . $proj[project].'</a>', $mailbodyf);
							$mailbodyf = str_replace("{employer}", $usr['username'], $mailbodyf);
							$headers = "MIME-Version: 1.0\r\n";
							$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
							$headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
							$headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
							
							
							$subjecte = html_entity_decode($mailre['subject']);
							$mailbodye = str_replace("{username}", $usr['username'], $mailbodye);
							$mailbodye = str_replace("{project}", "<a href='" . $prurl . "'>" .$proj[project].'</a>', $mailbodye);
							$mailbodye = str_replace("{freelancer}", $emp['username'], $mailbodye);
							

							mail($to, $subjectf, $mailbodyf, $headers);

							mail($to1, $subjecte, $mailbodye, $headers);


						header($lang['LOCATION'].": ".$vpath."my_jobs_sme.html");
						//my bid

			}

		exit;
}

	//------- CLOSE JOB---------------------------------

	if($_REQUEST[close]){

			$alert = "<table cellpadding=4 cellspacing=1 align=center width=100%  border=0>

					<tr bgcolor='" . $light . "' style='height:35px; background-color:#f6f6f6; '>

					<td ><a  href='".$vpath."my-jobs.html' style='color:#a1282c;' ><u><b>".$lang['MY_JOBS']."</b></u></a><b> > ".$lang['CLOSED_JOBS']." :" . getproject($_REQUEST[close]) . " </b></td></tr>";

					if (mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" . $_REQUEST[close] . "' AND user_id='" . $_SESSION[user_id] . "'"))==0){

						$alert .= '<tr><td class=red height=50 valign=middle align=center>'.$lang['PROJECT_SPECIFIED_NUMBER'].'.<br>

									<a href="'.$vpath.'my-jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';

					}else{

								if(!$_REQUEST[submit]){

									$alert .= '<tr class=link_class><td height=100 valign=middle><center>

													<form method="POST" action="'.$vpath.'my-jobs.php">

													<input type="hidden" name="close" value="' . $_REQUEST[close] . '">

													'.$lang['PROJ_CANCEL'].' <b>' . getproject($_REQUEST[close]) . '</b>?

													<br><br>

													<div align="center">

													<input type="submit" class="submit_bott" value="'.$lang['YES_CANCEL'].'" name="submit">

													</div>

													<br><br>

													<font face=verdana size=1 color=red>'.$lang['CAUTION_MYJOBS'].'<br><br>

													'.$lang['CAUTION_REOPEN'].'</font face=verdana size=1 >

													</form></center></td></tr></table>';

								}else{

										mysql_query("UPDATE " . $prev . "projects SET status='cancelled' WHERE id='" . $_REQUEST[close] . "'");

										mysql_query("UPDATE " . $prev . "bids SET status='cancelled' WHERE id='" . $_REQUEST[close] . "'");

										$alert .= '<tr class=link_class><td><center>'.$lang['PROJ_NMD'].' <b>' . getproject($_REQUEST[close]) . '</b> has been closed.<br>

										<a href="'.$vpath.'my-jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';

								}

					}

	}elseif($_REQUEST[extend]){

			$alert = "<table cellpadding=4 cellspacing=1 align=center width=100% border=0>
			<tr><td>&nbsp;</td></tr>
			<tr class='tbl_bg_4'><td ><a href='".$vpath."my-jobs.html' class=link_class><u><b>".$lang['MY_JOBS']."</b></u></a><b> > ".$lang['OPEN_H1']." :" . getproject($_REQUEST[extend]) . " </b></td></tr>";

			if(mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" . $_REQUEST[extend] . "' AND user_id='" . $_SESSION[user_id] . "'"))==0){

						$alert .= '<tr class="tbl_bg2"><td class=red height=50 valign=middle align=center>'.$lang['PROJ_NOT_FND'].'<br>

						<a href="'.$vpath.'my-jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';
						
			}else{

						if(!$_REQUEST[submit]){

							$alert .= '<tr class=tbl_bg2><td>
											<form method="POST" action="'.$vpath.'my-jobs.html">
											<input type="hidden" name="manage" value="2">
											<input type="hidden" name="extend" value="'. $_REQUEST[extend] . '">
											&nbsp;&nbsp; '.$lang['PROJ_EXT'].' <input type="text" name="cdays" value="' . $setting[maxextend] . '" maxlength="3" size="3" class="from_input_box1">
											days (max ' . $setting[maxextend] . ')...
											<br >
											<div>
											<br >
											<br >
											<input align="right" type="submit" class="submit_bott" value="'.$lang['EXTEND'].'" name="submit"></div></form>
											</td></tr></table>';						

						}else{

							$ii = mysql_result(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" .$_REQUEST[extend] . "'"),0,"expires")+ ($_REQUEST[cdays] * 86400);

		
							if($ii>(time() + $setting[mprojectdays] * 86400)){
									$alert  .=  '<tr><td>&nbsp;</td></tr>';
									$alert .= '<tr><td>';
									$_SESSION['error']=$lang['PROJ_EXT_CANT']. $setting[mprojectdays]. $lang['DAYS_SORRY'];
									include('includes/err.php');
									unset($_SESSION['error']);
									$alert .=  '</td></tr>';
									$alert .=  '<tr><td>&nbsp;</td></tr></table>';

							}else{

								//Extend the project update query executes here.

								mysql_query("UPDATE " . $prev . "projects SET expires=". $ii ." WHERE id='" . $_REQUEST[extend] . "'");
								$_SESSION['succ']=$lang['PROJ_XTND'] . $_REQUEST[cdays] .$lang['DAYS'];
								include('includes/succ.php');
								unset($_SESSION['succ']);
								$alert .= '<tr class=link_class><td class=link_class><br>

											<a href="'.$vpath.'my-jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';

							}

						}

			}	

	}elseif($_REQUEST[pick]){
			/**-- Action Pick --**/
			$alert = "<table cellpadding=4 cellspacing=1 align=center width=100% style='color:#4E4D4D;'>

			<tr class='tbl_bg_4'><td colspan=2><a href='".$vpath."my-jobs.html' class=link_class><u><b>".$lang['MY_JOBS']."</b></u></a><b> > ".$lang['SELECT_PROVIDER']."</b></td></tr>";

			if(@mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='$_REQUEST[pick]' AND user_id=" . $_SESSION[user_id]))==0){

				$alert .=  "<tr class='tbl_bg2'><td height=100 valign=middle colspan=2><span class=red>".$lang['PROJECT_SPECIFIED_NUMBER']."<br>

				<a href='".$vpath."my-jobs.html' class=link_class>".$lang['RETURN_TO_PREVIOUS_PAGE']."</a></td></tr></table>";

			}else{

						if(!$_REQUEST[submit]){

							$alert .= '<tr class="tbl_bg_4"><td class=link_class colspan=2><strong>'.$lang['PROJECT'].' : ' . getproject($_REQUEST[pick]) . '</strong></td></tr>

							<tr class="tbl_bg2" ><td class="link_class" colspan="2" style="text-decoration:none;text-align: justify;">

							'.str_replace("\\","",html_entity_decode($lang['MY_JOBS_MSG'])).'</td></tr>

							<tr ><td class=link_class>

							<form method="POST" action="my-jobs.html">

							<input type="hidden" name="pick" value="' . $_REQUEST[pick] . '">

							<input type="hidden" name="submit" value="select"></td></tr>

							</table><br>

							<table width="100%" border=0 cellspacing=1 cellpadding=4 bgcolor=whitesmoke>

							<tr class="tbl_bg_4"><td ><b>'.$lang['SLCT'].'</b></td><td><b>'.$lang['PROV_H'].'</b></td><td><b>'.$lang['BID'].'</b></td><td><b>'.$lang['DLV_WTN'].'</b></td><td><b>'.$lang['TIME_BID_H'].'</b></td><td><b>'.$lang['REVIEWS'].'</td></tr>';

							$rez_t = mysql_query("SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick]);
							$total=@mysql_num_rows($rez_t);
							//echo "SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick];
							if($_GET['page'])
							{
								$sql="SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick]." limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
							}
							else
							{	
								$sql="SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick]." limit 0,".$no_of_records."";
							}
							//echo $sql;
							$rez=mysql_query($sql);
			


							if($total==0){

								$alert .=  '<tr><td  class="red" valign=middle align=center colspan=6>'.$lang['NO_BDS_YT'].'</td></tr>';

							}else{

								$i=0;

								while($row=@mysql_fetch_array($rez))
								{

									$i++;

									if(!($i%2)){$bg='whitesmoke';}else{$bg='#ffffff';}

									$result4 = mysql_query("SELECT AVG(avg_rate) as avg_rate FROM " . $prev . "feedback WHERE feedback_to=" . $row[bidder_id]);

									if($_REQUEST[select]==$row[user_id]){

										$alert .=  "<tr class=link_class bgcolor=".$bg."><td><input type=radio name=chosen value=" . $row[bidder_id ] . "></td><td><a href='".$vpath."publicprofile/" . getusername($row[bidder_id]) . "' class=link_class><u>" . getusername($row[bidder_id ]) . "</u></a></td><td>".$curn . $row[bid_amount] ."</td><td>" . $row[duration] . " days</td><td>" . $row[add_date] . "</td><td>";

									}else{

										$alert .=  "<tr class=link_class bgcolor=" .$bg ."><td><input type=radio name=chosen value=" . $row[user_id] . "></td><td><a href='".$vpath."publicprofile/" . getusername($row[user_id]) . "' class=link_class><u>" . getusername($row[bidder_id]) . "</u></a></td><td>".$curn . $row[bid_amount] ."</td><td>" . $row[duration] . " days</td><td>" . $row[add_date] . "</td><td>";

									}

									if (mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to=" . $row[bidder_id] ))==0){

										$alert .= $lang['NO_FDB_YT'];

									}else{

										$alert .= '<a href="'.$vpath.'review/' . getusername($row[bidder_id]) . '/" class=link_class>';

										$avgratin = round(mysql_result($result4,0,"avg_rate"), 2);

										$avgrating = explode(".", $avgratin);

										for ($t2=0;$t2<$avgrating[0]-5;$t2++){

												//echo '<img src="images/img_52.jpg" border=0 alt="' . $avgratin . '/5">';

										}

										$numeric2 = 10-$avgrating[0];

										if($numeric2){

											for ($b2=0;$b2<$numeric2-5;$b2++){

												//echo '<img src="images/img_54.jpg" border=0 alt="' . $avgratin . '/5">';

											}

										}

										if(mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to='" . $row[bidder_id] . "'"))==1){

											$alert .= ' (<b>1</b>'.$lang['REVIEW'].' )';

										}else{

											$alert .= "<span class=\"starsSmall rating". $avgrating[0]."\">&nbsp;</span>";

											$alert .= ' (<b>' . mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to='" . $row[bidder_id] . "'")) . '</b> reviews)';

										}

											$alert .= '</a>';

									}

									$alert .= '</td></tr>

									<tr bgcolor=' .$bg .'><td  colspan="6" class="link_class" style="border-bottom:solid 1px">' . $row[cover_letter] .'</td></tr>';

								}

			}

			$alert .= '<tr class=link_class bgcolor="' . $light . '"><td colspan=5 ><input type=button OnClick="javascript:history.back();" class="submit_bott" value=" '.$lang['BACK'].' "></td>

			<td   align=right><input type="submit" class="submit_bott"  value="'.$lang['SELECT_PROVIDER'].'"></td></tr></form></table>';

			}else{

				if(!isset($_POST['chosen']))
				{
					$_SESSION['select_provider'] = $lang['MSG_NO_PRV'];	
					header($lang['LOCATION'].": ".$vpath."my-jobs/pick/".$_REQUEST['pick']."/");
				}
				else
				{
					mysql_query("UPDATE " . $prev . "projects SET chosen_id='$_REQUEST[chosen]', status='frozen' WHERE id='$_REQUEST[pick]'");

					//mysql_query("UPDATE " . $prev . "bids SET chosen_id='$_REQUEST[chosen]', status='frozen' WHERE id='$_REQUEST[pick]'");						

					mysql_query("UPDATE " . $prev . "buyer_bids SET chose='P', chosen_id='$_REQUEST[chosen]' WHERE project_id='$_REQUEST[pick]' and bidder_id='$_REQUEST[chosen]'");

					$msg = $setting[emailheader] .$lang['MSG_JOB'] . getproject($_REQUEST[pick]) . $lang['MSG_JOB_IMP'] . $setting[site_url] . 'my-jobs.php?mode=accept&id=' . $_REQUEST[pick] . '&confirm=' . $_REQUEST[pick] . $lang['MSG_JOB_2'] . $setting[emailaddress] . '--------------------' . $setting[emailfooter];

					$from="test.com";
					
					$mail_id=getemail($_REQUEST[chosen]);
					
					$mail_type = 'select_provider';
					
					
					$row_mail_type = mysql_fetch_array(mysql_query("select * from ".$prev."mailsetup where mail_type = '".$mail_type."'"));
					
					$body = html_entity_decode($row_mail_type['header']) . $msg . html_entity_decode($row_mail_type['footer']);
					
					$body1=str_replace("{first_name}",$_REQUEST['firstname'],$body);
					$body1=str_replace("{last_name}",$_REQUEST['lastname'],$body1);
					
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$headers .= $lang['FROM_H'].":$dotcom <" . $from . ">\r\n";
					$headers .= $lang['REPLY_TO'].": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
					
					mail($mail_id,$setting[companyname] . $lang['BID_WON'],$body1,$headers);
			
					$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$_SESSION['user_id']));

					$proj = mysql_fetch_array(mysql_query("SELECT * from ".$prev."projects where id=".$_REQUEST['pick']));  

					$message = $lang['HIRD_PROJ'].'<br /><br />

					'.$lang['NEW_RT'].': $'.$_POST['rate'].'<br />

					'.$lang['PROJECT_NAMEE'].': '.$proj['project'];

		
					$msg = mysql_query("INSERT into ".$prev."messages set 

																receiver=".$_GET['id'].",

																sender_id=".$_SESSION['user_id'].",

																sender='".$usr['email']."' ,

																subject='".$lang['HIRE_INFO']."',

																message='".$message."',

																user_type='sender',

																sent_time='".date('Y-m-d h:i:s')."',

																status='Y',

																message_type='A'");

					

					$msg2 = mysql_query("INSERT into ".$prev."messages set 

																receiver=".$_GET['id'].",

																sender_id=".$_SESSION['user_id'].",

																sender='".$usr['email']."' ,

																subject='".$lang['HIRE_INFO']."',

																message='".$message."',

																user_type='reciver',

																sent_time='".date('Y-m-d h:i:s')."',

																status='Y',

																message_type='A'");

			
					// $notify = mysql_query("INSERT into ".$prev."notification set user_id=".$_GET['id'].", message='".$lang['HIRE_INFO']."', date='".date('Y-m-d')."'");
					$link = $vpath.'offer/'.$_POST[project_id];
					$notify = add_notification($_GET['id'], $lang['HIRE_INFO'], 'W', $link);

					$alert .= '<tr><td colspan="6" class="link_class" style="text-decoration: none;text-align: justify;">'.$lang['MSG_JOB_3'].' <b>' . getusername($_REQUEST[chosen]) . '</b> '.$lang['MSG_JOB_4'].' <b>' . getproject($_REQUEST[pick]) . '</b> '.$lang['MSG_JOB_5'].'<br><br>

					'.$lang['MSG_JOB_6'].' <b>' . getusername($_REQUEST[chosen]) . '</b> '.$lang['DOES_NOT_RES'].'.<br><br>

					'.$lang['MSG_JOB_8'].'<br><br>

					<div align=right>

					<a href="'.$vpath.'my-jobs.html" class=link_class>'.$lang['GO_BK'].'</a></div></td></tr></table>';
				}
			}

		}

	

	}


?>

<div class="spage-container">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left">
                <!-- tabs left -->
				 <?php require("includes/left_menu_job_client.php");?>
                <!-- tabs left -->
           </div>
            <!-- Content right -->
            <div class="profile_right">
			
					<?php if($alert != ''){ ?>
						<div class="search-job-content clearfix">
							<?php echo $alert; ?>
						</div>		
							
					<?php		}else{	?>
							
							<div class="heading_right"><?=$lang['MY_PROJECTS']?></div>
							<!-- content data list -->
						
							<?php
							
							$no_of_records=10;

							if(!$_REQUEST[page]){$_REQUEST[page]=1;}
							
							$res21=mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "'  ORDER BY id,date2 DESC");
							$total =@mysql_num_rows($res21);

							$tinyres = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id,date2 DESC limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."");

							$i=0;

							while($kikrow=mysql_fetch_array($tinyres))

							{
								$datleft = get_DatLeft_Of_Project($kikrow[id]);

							?>
							
							<div class="rbn3"><?=getfeatureiconmain($kikrow[id])?>
							</div>
						   <div class="search-job-content clearfix">
								<div class="resultinfor">
									<a href="<?=$vpath?>project/<?php print $kikrow[id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$kikrow['project'])))?>.html" > <?php echo ucwords($kikrow['project']);?></a>

									<ul class="search-job-content-minili">
										
										<li><? if($kikrow['project_type']=="F"){?><?=$lang['FXD_PRC']?>: <b><?=$lang[$budget_array1[$kikrow[budget_id]]]?> </b> <? }else{?><?=$lang['HOURLY']?>: <b><?=$curn.$kikrow['budgetmin']." to ".$curn.$kikrow['budgetmax']?> </b><?} ?></li>
										
										<li><?=$lang['POSTED']?>: <b><?php print date('M d, Y',strtotime($kikrow[creation]));?></b>  </li>
										
										<li><?=$lang['ENDS']?>: <b><?=$datleft; ?></b>   </li>
										
										<a  href="<?=$vpath?>project/<?php print $kikrow[id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$kikrow['project'])))?>.html" >
											<li class="bor-right"> <b><?php echo totalbid($kikrow[id]);?></b> <?=$lang['PROPOSALS']?></li>  
										</a>
									</ul>
								</div>
							
								<div class="resultcheckbox">
									<input id="check_user1" type="checkbox" class="css-input" />	
									<label for="check_user1" class="css-label"></label>        
								</div>
							
								<div class="job-des">
										<p class=""><?php if(strlen($kikrow['description'])>250){echo substr($kikrow['description'],0,250).'...';} else {echo $kikrow['description'];} ?></p>
								
										<ul class='skills-section compact-view'  style="padding-left:0px;margin-top:5px;margin-bottom:5px;"><?=$job_skills;?></ul>
								</div>
								<?php 
									$class_stype = set_Color_for_Status($kikrow[status]);
								?>
								<div class="joblist_status <?=$class_stype?>">
									 <?=Ucwords($kikrow[status])?>
								</div>
								<div class="joblist_button_group">
									<?php
									if($kikrow[status]=="open"){
										if(totalbid($kikrow[id])){
											echo '<a href="'.$vpath.'my-jobs/pick/' . $kikrow[id] . '/" class=link_class><u>'.$lang['SELECT_PROVIDER'].'</u></a>';
										}else{
											echo'<img src="images/extend.png"><a href="'.$vpath.'extend_project/' . $kikrow[id] . '/" class=link_class><u>'.$lang['EXTEND'].'</u></a> 
											&nbsp; | &nbsp; <img src="images/clo.png"> <a href="'.$vpath.'my-jobs/close/' . $kikrow[id] . '/" class=link_class><u>'.$lang['CANCEL'].'</u></a><br>';
										}
									}else if($kikrow[status]=="frozen"){
									
										echo '<img src="images/register_icon.png">&nbsp;<a href="'.$vpath.'my-jobs/pick/' . $kikrow[id] . '/" class=link_class><u>'.$lang['PICK_PROVIDER'].'</u></a> &nbsp; | &nbsp;<img src="images/extend.png"><a href="'.$vpath.'my-jobs/extend/' . $kikrow[id] . '/" class=link_class><u>'.$lang['EXTEND'].'</u></a> &nbsp; | &nbsp; <img src="images/clo.png"><a href="'.$vpath.'my-jobs/close/' . $kikrow[id] . '/" class=link_class><u>'.$lang['CANCEL'].'</u></a><br>

										'.$lang['AWAIT_RESP'].' <i><a href="'.$vpath.'publicprofile/' . getusername($kikrow[chosen_id]) . '" class=link_class><u>' . getusername($kikrow[chosen_id]) . '</u></a></i>)';
										
									}else if($kikrow[status]=="cancelled"){
									
										
									}else if($kikrow[status]=="expire"){
									
										
									}else{
									
										echo' '.$lang['YOU_PICKED'].' <a href="'.$vpath.'publicprofile/' .getusername( $kikrow[chosen_id] ). '">' . getusername($kikrow[chosen_id]) . '</a> ('.$lang['CLICK_HERE_PAY'].' <a href="'.$vpath.'milestone.html">' . getusername($kikrow[chosen_id]) . '</a>)'; 
									
									}
									?>
								</div>
						
							</div>
								
				
							<?php $i++;} if($total<1){?>

								<div class="alert alert-warning" role="alert"><?=$lang['NO_RUNNING_PRO']?></div>

							<? }?>

						
							<?
							if($total>$no_of_records){
								echo"<div align=right>". new_pagingnew(0,$vpath.'my-jobs/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";  
							}
							?>
					
						
                </div>
				<?php } ?>
            </div>

    </div>  
</div>

<?php include 'includes/footer.php'; ?>