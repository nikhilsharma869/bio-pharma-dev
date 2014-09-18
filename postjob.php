<?php
$current_page = "Post your job";
$cur_par_menu = "post_job";
$cur_child_menu = "";

include "includes/header.php";
CheckLogin();
$expdays = 14; /* * *****Project Expire days********* */
$restest = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");
$rowtest = mysql_fetch_array($restest);
$_REQUEST['firstname'] = $rowtest['fname'];
$_REQUEST['lastname'] = $rowtest['lname'];
$job_id_edit==0;
//Check Edit 
 if (isset($_REQUEST['edit'])) {
	$job_id_edit = $_REQUEST['edit'] ;
	
	$row_edit = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id = '" . $job_id_edit. "'"));

	$list_skills = get_list_skill_by_job_id($row_edit[id]);
	
	$ENABLE_EDIT = 'DISABLED';
	$STYLE = 'style="display:none"';
	
}

function check_Selected_Skills($current_skill,$list_skills){
	if(count($list_skills)>0){
		foreach($list_skills as $skill){
			if($current_skill==$skill['skill_id']) return true;
		}
	}else{
		return false;
	}	

}
//Check Edit 

 if ($_POST[submit] == $lang['FR_LB_JOB_BUTTON_ADD'] && $_REQUEST['id_edit']==0) {

	echo '<div class="post_left">';

	$err_msg = "";
	if (count($_REQUEST[attachfile])):

		$attach = "";

		for ($i = 0; $i < count($_REQUEST[attachfile]); $i++):

			$attach.= $_REQUEST[attachfile][$i] . ",";

		endfor;

		$rud = substr($attach, 0, -1);

	endif;

	////////////////////////////////////////////////// start  insert amount in transaction table //////////////// feature project  ///////////////////////////////		

	if ($_REQUEST[featured] && $_REQUEST[featured] == "featured") {
		if ($balsum >= $setting['featuredcost']) {
			$special = $_POST[featured];

			if ($_POST[urgent] == 'urgent') {
				$special.="," . $_POST[urgent];
			}
			if ($_POST[sealed] == 'sealed') {
				$special.="," . $_POST[sealed];
			}
			if ($_POST[privacy] == 'privacy') {
				$special.="," . $_POST[privacy];
			}
			$today = getdate();

			$month = $today['mon'];

			$day = $today['mday'];

			$year = $today['year'];

			$hours = $today['hours'];

			$minutes = $today['minutes'];

			$payment_id = rand(1000, 9999) . time();

			$sql = "INSERT INTO " . $prev . "transactions set

						details = 'Posted Featured Project',

						user_id = '" . $_SESSION['user_id'] . "',

						balance = '" . $setting[featuredcost] . "',

						add_date = now(),

						date2 = '" . time() . "',

						paypaltran_id = '" . $payment_id . "',

						status = 'Y', amttype = 'DR'";



			mysql_query($sql);
		} else {
			$_SESSION['error'].=$lang['NOT_SUFF_BALNC'];
			include("includes/err.php");
			unset($_SESSION['succ']);
			unset($_SESSION['error']);
		}
	}
	/////// start  insert amount in transaction table /////// feature project  

	$secondsPerDay = ((24 * 60) * 60);

	$ttoy = time();

	$tttoy = genDate(time());

	$expires = $ttoy + ($secondsPerDay * $expdays);

	$txt = "";
	$flag = 0;
	$no_err = "";
	
	//Change to Skill LINKED IN
	$array_skill = $_POST['skills'];
	if (count($array_skill) > 0) {
		foreach ($array_skill as $id => $val) {
			$no_err = "no err";
			$err_msg = "";
			$flag++;
			$a = mysql_query("insert into " . $prev . "projects_cats set id=" . $ttoy . ",cat_id=" . $val);

		}
	}
	//Change to Skill LINKED IN
	
	// if ($flag == 0) {

		// $_SESSION['error'].=$lang['POSTJOB_ERR'];
		// $err_msg = "err";
	// }
	
	if ($err_msg == "" && $flag > 0) {
		
		if ($_POST['project_type'] == "F") {
			if ($_REQUEST['budget_id'] == "1") {
				$budgetmin = "250";
				$budgetmax = "250";
			}
			if ($_REQUEST['budget_id'] == "2") {
				$budgetmin = "250";
				$budgetmax = "500";
			}
			if ($_REQUEST['budget_id'] == "3") {
				$budgetmin = "500";
				$budgetmax = "1000";
			}
			if ($_REQUEST['budget_id'] == "4") {
				$budgetmin = "1000";
				$budgetmax = "2500";
			}
			if ($_REQUEST['budget_id'] == "5") {
				$budgetmin = "2500";
				$budgetmax = "5000";
			}
			if ($_REQUEST['budget_id'] == "6") {
				$budgetmin = "5000";
				$budgetmax = "10000";
			}
			if ($_REQUEST['budget_id'] == "7") {
				$budgetmin = "10000";
				$budgetmax = "25000";
			}
			if ($_REQUEST['budget_id'] == "8") {
				$budgetmin = "above $25000";
			}
			if ($_REQUEST['budget_id'] == "9") {
				$budgetmin = "not sure";
			}
		} else {
			$ptype = " / hr";
			$_REQUEST[budget_id] = 0;
			$budgetmin = $_POST['budget_min'];
			$budgetmax = $_POST['budget_max'];
		}
		$amnt = $setting['currency'] . $budgetmin;
		if ($budgetmax != '') {
			$amnt .= "-" . $setting['currency'] . $budgetmax;
		}
		$amnt .=$ptype;
		
		//Fixed category don't use it
		
		$main_cat_id = 126;
		$categories = 242;
		
		//Fixed category don't use it
		
		$sql_inser_project = mysql_query("insert into " . $prev . "projects set chosen_id='',status='open',id='" . $ttoy . "',date2='" . $ttoy . "',project='" . mysql_real_escape_string($_REQUEST[project]) . "',special='" . $special . "',categories='" . $categories . "',expires='" . $expires . "',budget_id='" . $_REQUEST[budget_id] . "',budgetmin='" . $budgetmin . "',budgetmax='" . $budgetmax . "',creation='" . date("Y-m-d") . "',ctime='" . date("h:i") . "',user_id='" . $_SESSION[user_id] . "',project_type='" . $_POST['project_type'] . "',description='" . mysql_real_escape_string($_REQUEST[description]) . "',attachment='" . $rud . "',opsys='" . $_REQUEST[opsys] . "',datasys='" . $_REQUEST[datasys] . "',zip='" . $_REQUEST[zip] ."', enabled_manual_time='" . $_REQUEST[enabled_manual_time] . "',main_cat_id='" . $main_cat_id . "'");

		if ($sql_inser_project) {

			/** Send Email **/
			$res_user = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");

			$row_user = mysql_fetch_array($res_user);

			$purl = $vpath . "project/" . $ttoy . "/" . str_replace(" ", "-", $_REQUEST[project]) . ".html";

			$mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='post_job_for_employe' AND `langid`='" . $_SESSION['lang_code'] . "'");
			if (mysql_num_rows($mailq) == 0) {
				$mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='post_job_for_employe' AND `langid`='en'");
			}
			$mailr = mysql_fetch_assoc($mailq);
			$mailbody = html_entity_decode($mailr['body']);

			$mailbody = str_replace("{username}", $row_user['username'], $mailbody);
			$mailbody = str_replace("{project}", "<a href='" . $purl . "'>" . $_REQUEST[project] . "</a>", $mailbody);
			$mailbody = str_replace("{project_url}", $purl, $mailbody);
			$mailbody = str_replace("{amount}", $amnt, $mailbody);

			$subject = html_entity_decode($mailr['subject']);

			$headers = "MIME-Version: 1.0 \r\n";
			$headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
			$headers.="From: " . $setting['admin_mail'] . "\r\n";
			if ($setting['cc_mail'] != '') {
				$headers.="Cc: " . $setting['cc_mail'] . "\r\n";
			}

			mail($row_user['email'], $subject, $mailbody, $headers);
			/** Send Email **/	
		}

		$project = $stat[project] + 1;

		mysql_query("update " . $prev . "stat set project=" . $project . "");
		/** view messages and tr **/
		$_SESSION['succ'] = $lang['job_posted_successfully'];
	}

		/////////////////////////////////////////////////////////////////////////////// end view messages and tr ////////////////////////////////////////////////////////////////
		echo '</div>';
}else if ($_POST[submit] == $lang['FR_LB_JOB_BUTTON_EDIT'] && $_REQUEST['id_edit']!=0) {


		if (count($_REQUEST[attachfile])):
			$attach = "";
			for ($i = 0; $i < count($_REQUEST[attachfile]); $i++):
				$attach.= $_REQUEST[attachfile][$i] . ",";
			endfor;

			$rud = substr($attach, 0, -1);

		endif;

		if ($_REQUEST[featured] && $_REQUEST[featured] == "featured"):

			$tyress = mysql_query("SELECT * FROM " . $prev . "transactions WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY date2 DESC LIMIT 0,1");

			$bal = mysql_result($tyress, 0, "balance");

			if ($bal >= $setting[featuredcost]):

				$dadj2 = $bal - $setting[featuredcost];

				$today = getdate();

				$month = $today['mon'];

				$day = $today['mday'];

				$year = $today['year'];

				$hours = $today['hours'];

				$minutes = $today['minutes'];

				mysql_query("INSERT INTO " . $prev . "transactions (amount, details, user_id, balance, date, date2) VALUES ('-$setting[featuredcost]', 'Featured Project Fee', '" . $_SESSION[user_id] . "', '$dadj2', '" . genDate(time()) . "', '" . time() . "')");

			endif;

		endif;

		$mymess = $setting[emailheader] . '

				----------

				' . $lang['This_is_to_confirm_that_your_new_project'] . ' (' . $_REQUEST[project] . ') ' . $lang['has_been_added_to'] . ' ' . $setting[companyname] . '

				

				' . $lang['postmail3'] . ' ' . $vpath . 'login.html

				----------

				' . $setting[emailfooter];



		mail($setting[admin_mail], $lang['NEW'] . $setting[companyname] . $lang['PROJECT_NAME'] . ": " . $_REQUEST[project], $mymess, "From:$setting[retemailaddress]");




		mysql_query("insert into " . $prev . "projects_additional set project_id=\"" . $_REQUEST[id_edit] . "\",user_id=\"" . $_SESSION[user_id] . "\",date='" . time() . "',info=\"" . $_REQUEST[info] . "\",attached_file=\"" . $rud . "\"");


		$msg3 = $lang['ADDITIONAL_INFO'] . '<b>' . $_REQUEST[project] . '</b>' . $lang['VIEW_BY_ALL'] . '<br><br> <a href="' . $vpath . 'project/' . $_REQUEST[id_edit] . '/" class=link><b>' . $lang['CLICK_HERE'] . '</b></a> ' . $lang['VIEW_UR_PROJ'];
		
		
  
}
	


?>
<div class="spage-container">
    <div class="main_div2">
        <div class="inner-middle"> 
            <div class="profile_left">
                  <?php require("includes/left_menu_job_client.php");?>
            </div>
            <div class="profile_right">
				<!-- ALERT -->
				<div>
					<?php
						if ($_SESSION['succ'] != "" && $err_msg == "" && $flag > 0) {

							$_SESSION['succ'].='<br> ' . $lang["The_job_named"] . ' <b>' . $_REQUEST[project] . '</b> ' . $lang["has_been_added_to"] . ' <strong>' . $dotcom . '</strong> ' . $lang["and_can_now_be_viewed_by_all_service_providers"] . '.<br><br>
								<a href="' . $vpath . 'project/' . $ttoy . '/"><font color="#FFF"><b>' . $lang["CLICK_HERE"] . '</b></font></a> ' . $lang["to_view_your_project"] . '.';
							include("includes/succ.php");

							//echo"<tr class='link'><td colspan=2 align=center  height=30>" . $msg3 . "</td></tr>";
							unset($_SESSION['succ']);
							unset($_SESSION['error']);

							/*                                 * **********invitaion************* */


							if ($_POST['invtxtemail'] != '' && $_POST['invtxtemail_post'] == 'inviteuser' && $_POST['txtemail_stat'] == "open") {
								$link = $vpath . "project/" . $ttoy;
								$to = $_POST['invtxtemail'];

								$subj = $lang['PROJ_INV'] . $_REQUEST[project];

								$body = $lang[$setting[invitation]] . $lang['PROJ_FOR'] . '<b>' . ucwords($_REQUEST[project]) . '</b>.
								<br>' . $lang['PROJ_LINK'] . '
								<br>' . $link . '
								<br /><br /> ' . $lang['FROM_H'] . ' ' . $row_user['fname'] . ' ' . $row_user['lname'];
								$from = getusername($_SESSION['user_id']);
								$mail_type = 'invitation';
								$r = genMailing($to, $subj, $body, $from, $reply = true, $mail_type, $fname, $lname);
							}
							/*                                 * ************************ */
						} else if ($_SESSION['error'] != "" && $err_msg == "" && $flag > 0)  {
							$_SESSION['error'].="<br>" . $lang['job_not_posted_successfully'] .
									"<br> <a href='postjob.html'><font color='#FFF'><strong>" . $lang['CLICK_HERE'] . "</strong></font> </a>" . $lang['submit_project_again'];
							include("includes/err.php");
							unset($_SESSION['succ']);
							unset($_SESSION['error']);
						}
					?>
				</div>
				<!-- ALERT -->
				
                <div class="form-post-a-job">
                    <form class="form-horizontal" role="form" id="postproject" name="postjob" method="post" action="<?= $vpath ?>postjob.html" enctype="multipart/form-data" onSubmit="javascript:return RegValidate(this);">
                        <div class="form-group" style="display:none">
                            <label for="" class="col-sm-3 control-label"><?= $lang['SEL_CAT_TITLE'] ?></label>
                            <div class="col-sm-4">
                                	<div class="select-box">
										<select name="category_id"   name="category_id" id="category_id" size="1" class="from_input_box selectyze2">
												<option value=""><?= $lang['SELECT_PARENT_CAT'] ?></option>
												<?php
												$r = mysql_query("select cat_name,cat_id from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
												$j = 0;
												$n = 0;
												while ($d = mysql_fetch_array($r)) {
													if ($_SESSION[lang_id]) {
														$row_content_lang = mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where content_field_id='" . $d['cat_id'] . "' and table_name='categories' and field_name='cat_name' and lang_id='" . $_SESSION[lang_id] . "'"));
														$d['cat_name'] = $row_content_lang['content'];
													}
												?>
												<option value="<?= $d['cat_id'] ?>" <?php if($d['cat_id']==$categories) echo "SELECTED";?>><?= $d['cat_name'] ?></option>
											<?php }
											?>
										</select>
									</div>
                            </div>
							<div class="col-sm-4">
                                	<div class="select-box">
										<select name="child_category_id" id="child_category_id" size="1" class="from_input_box selectyze2">
												<option value=""><?= $lang['SELECT_CHILD_CAT'] ?></option>
												<?php
												$r = mysql_query("select cat_name,cat_id,parent_id from " . $prev . "categories  where parent_id !=0 and status='Y' order by cat_name");
												$j = 0;
												$n = 0;
												while ($d = mysql_fetch_array($r)) {
													if ($_SESSION[lang_id]) {
														$row_content_lang = mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where content_field_id='" . $d['cat_id'] . "' and table_name='categories' and field_name='cat_name' and lang_id='" . $_SESSION[lang_id] . "'"));
														$d['cat_name'] = $row_content_lang['content'];
													}
												?>
												<option <?php if($d['cat_id']==$main_cat_id) echo "SELECTED";?> type_id='<?=$d['parent_id']?>' id="child_type_<?=$d['cat_id']?>" value="<?= $d['cat_id'] ?>"><?= $d['cat_name'] ?></option>
											<?php }
											?>
										</select>
									</div>
                            </div>
                        </div>   
						
						<div class="form-group">
                            <label for="" class="col-sm-3 control-label"><?= $lang['FR_LB_JOB_TITLE'] ?></label>
                            <div class="col-sm-9">
                              <input  type="text" class="form-control" name="project" id="project" value="<?= $row_edit['project'] ?>" <?=$ENABLE_EDIT?>>
                            </div>
                        </div>  
						
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"><?= $lang['FR_LB_JOB_DESCRIPTION'] ?></label>
                            <div class="col-sm-9">
                              <textarea class="form-control" rows="10" name="description" <?=$STYLE?>><?= $row_edit['description'] ?></textarea>
							 
								<!--- INFO EDIT -->
								<?php if($job_id_edit != 0){ ?>
										<?php echo nl2br($row_edit['description'] ); ?><br  /><br  />
                                            <?php
                                            $otherdet = mysql_query("select info from " . $prev . "projects_additional where project_id='" . $job_id_edit . "'");
                                            $ui = 0;
                                            $uia = 0;
                                            while ($infp = @mysql_fetch_assoc($otherdet)) {
                                                if ($infp[info] != '') {
                                                    $ui++;
                                                    echo "<b>".$lang['ADDITION'] . $ui . " :</b> <br  />" . nl2br($infp[info]) . "<br  /><br  />";
                                                }
                                            }
										?>
										 <div class="edit_bott"><a href="javascript:void(0)" onclick="edittext()" >Edit</a></div>
										 <textarea class="form-control" rows="5" name="info" id="descriptclass" style="display:none;"></textarea>
								<?php } ?>
							  
                            </div>
                        </div> 
						
						<div class="form-group"  <?=$STYLE?>>
                            <label for="" class="col-sm-3 control-label"><?= $lang['FR_LB_JOB_SKILLS'] ?></label>
                            <div class="col-sm-9">
                                <select data-placeholder="<?= $lang['FR_LB_JOB_SKILLS'] ?>" name="skills[]" id="skills" value='' multiple class="from_input_box" <?=$ENABLE_EDIT?>>
								<!-- <input type="text" id="skills" name="blah2" class="form-control"/> -->
								<?php
                                    $skills_r = mysql_query("select * from " . $prev . "skill_linkedin group by skill_name");
                                    while ($skills_d = mysql_fetch_array($skills_r)) {                                        
                                    ?>
                                        <option value="<?= $skills_d['id'] ?>" <?php if(check_Selected_Skills($skills_d['id'],$list_skills)== true) echo "SELECTED";?>><?= $skills_d['skill_name'] ?></option>
                                <?php } ?>
							    </select> 
                            </div>
                        </div>  
						<div class="form-group" <?=$STYLE?>>
                            <label for="" class="col-sm-3 control-label"><?= $lang['FR_LB_JOB_PAYMENT_TYPE'] ?></label>
							<div class="col-sm-6">
								<div class="select-box" >
                                    <select name="project_type" id="project_type" size="1" class="from_input_box selectyze2" >
    									<option value="F" <?php if($row_edit['project_type']=='F') echo 'SELECTED';?>><?= $lang['FR_LB_JOB_PAYMENT_FIXED'] ?></option>
    									<option value="H" <?php if($row_edit['project_type']=='H') echo 'SELECTED';?>><?= $lang['FR_LB_JOB_PAYMENT_HOURLY'] ?></option>
    								</select>
						        </div>
							</div>
					     </div>  
						
						<div class="form-group fixed" <?=$STYLE?>>
                            <label for="" class="col-sm-3 control-label"><?= $lang['BUDGET'] ?></label>
							<div class="col-sm-6">
								<div class="select-box">
									<select name="budget_id" size="1" class="from_input_box selectyze2" <?=$ENABLE_EDIT?>>
											<option selected value="">--- <?= $lang['BUDGET_SL1'] ?> ---</option>
											<option value="1" <?
											if ($row_edit[budget_id] == 1) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL2'] ?></option>
											<option value="2" <?
											if ($row_edit[budget_id] == 2) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL3'] ?></option>
											<option value="3" <?
											if ($row_edit[budget_id] == 3) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL4'] ?></option>
											<option value="4" <?
											if ($row_edit[budget_id] == 4) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL5'] ?></option>
											<option value="5" <?
											if ($row_edit[budget_id] == 5) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL6'] ?></option>
											<option value="6" <?
											if ($row_edit[budget_id] == 6) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL7'] ?></option>
											<option value="7" <?
											if ($row_edit[budget_id] == 7) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL8'] ?></option>
											<option value="8" <?
											if ($row_edit[budget_id] == 8) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL9'] ?></option>
											<option value="9" <?
											if ($row_edit[budget_id] == 9) {
												echo "selected";
											}
											?>><?= $lang['BUDGET_SL10'] ?></option>
									</select>
								</div>	
							</div>
						</div>
						<!--
                        <div class="form-group desired-exp-level">
                            <label for="" class="col-sm-3 control-label"><?= $lang['D_EXP_LV'] ?></label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" name="d_exp_level" id="d_exp_level1" value="d_exp_level1" checked>
                                    <h4><?= $lang['D_EXP_LV_1_T'] ?><span>&#36;</span></h4>
                                    <p><?= $lang['D_EXP_LV_1_D'] ?></p>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="d_exp_level" id="d_exp_level2" value="d_exp_level2">
                                    <h4><?= $lang['D_EXP_LV_2_T'] ?><span>&#36;&#36;</span></h4>
                                    <p><?= $lang['D_EXP_LV_2_D'] ?></p>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="d_exp_level" id="d_exp_level3" value="d_exp_level3">
                                    <h4><?= $lang['D_EXP_LV_3_T'] ?><span>&#36;&#36;&#36;</span></h4>
                                    <p><?= $lang['D_EXP_LV_3_D'] ?></p>
                                </label>
                            </div>
                        </div>
						-->
						<div class="form-group hourly" <?=$STYLE?>>
                            <label for="" class="col-sm-3 control-label"><?= $lang['AVS_HOURLY_RATE'] ?></label>
							<div class="col-sm-6">
								<div class="doller clearfix "  style="display: block;">
									<label style="width:auto;padding-top: 8px;"> <?= $lang['MIN'] ?> <?= $curn ?> </label>
									<input class="mini-inp form-control" type="text" name="budget_min" value="<?=$row_edit['budgetmin']?>" <?=$ENABLE_EDIT?>>
									<label style="width:auto;padding-top: 8px;">  <?= $lang['MAX'] ?> <?= $curn ?> </label>
									<input class="mini-inp form-control" type="text" name="budget_max" value="<?=$row_edit['budgetmax']?>" <?=$ENABLE_EDIT?>>
									<label style="width:auto;padding-top: 8px;">  <?= $lang['FR_LB_JOB_ALLOW_MANUAL_TIME'] ?> </label>
									
									<div class="select-box" style="width:100px;float:left;padding-left:25px">
									<select name="enabled_manual_time" id="enabled_manual_time" size="1" class="from_input_box selectyze2" style="width:100px">
    									<option value="Y" <?php if($row_edit['enabled_manual_time']=='Y') echo 'SELECTED';?>><?= $lang['FR_LB_JOB_MANUAL_TIME_YES'] ?></option>
    									<option value="N" <?php if($row_edit['enabled_manual_time']=='N') echo 'SELECTED';?>><?= $lang['FR_LB_JOB_MANUAL_TIME_NO'] ?></option>
    								</select>
									</div>
								</div>
							</div>
					     </div>  
						
						
						<div class="form-group hourly_price">
                            <label for="" class="col-sm-3 control-label"><?= $lang['FR_LB_JOB_ATTACHMENT'] ?></label>
						
							<div class="col-sm-6">
									<!--- ATTACMENT EDIT -->
									<?php if($job_id_edit != 0){ ?>
									 <div class="attach">

										<?php
										$no_of_att = @explode(",", $row_edit['attachment']);
										$x = 1;
										if (count($no_of_att) > 0) {
											?>
											<div class='news_heading'><?= $lang['Attach'] ?>  :</div>
											<div class="box-attachments">
												<?php
												foreach ($no_of_att as $atno) {
													list($nm1, $nm) = explode("-", $atno, 2);
													?>
													<a href="<?= $vpath . $atno ?>"  target="_blank"><?= ucfirst($nm) ?></a> <br />
													<?php
													$x++;
												}
												?>
											</div>
										<?php }?>	
									</div>
									<div class="clear"></div>
									<?php
									 $otherdet1 = mysql_query("select attached_file from " . $prev . "projects_additional where project_id='" . $job_id_edit . "'");

                                        while ($infp1 = @mysql_fetch_assoc($otherdet1)) {

                                            if ($infp1[attached_file] != '') {
                                                $uia++;
                                                echo "<div class='attach'><div class='news_heading'>" . $lang['Addition_attach'] . $uia . " :</div>";
                                                ?>
                                                <div class="box-attachments">
                                                    <?php
                                                    $no_of_att1 = explode(",", $infp1['attached_file']);
                                                    $x = 1;
                                                    foreach ($no_of_att1 as $atno1) {
                                                        list($nm11, $nm1) = explode("-", $atno1, 2);
                                                        ?>
                                                        <a href="<?= $vpath . $atno1 ?>"  target="_blank"><?= ucfirst($nm1) ?></a> <br />
                                                        <?php
                                                        $x++;
                                                    }
                                                    ?>
                                                </div></div >
                                            <?php
                                        }
										}
										?>
								<?php } ?>
								<div class="clear"></div>
							
								<select  name='attachfile[]' id="attachfile" size=5 style='width:300px' multiple class="text_box"> </select></td>
								<td width="180" style="padding-left:10px;"><input type='button' name='Upload' class="submit_bott" value='<?= $lang['UPLOAD'] ?>' style='width:100px;margin-bottom:10px;'   onClick="javascript:window.open('<?= $vpath ?>pop.upload.php', '_new', 'width=400,height=300,addressbar=no,scrollbars=no');">

									<input type='button' name='Remove' class="submit_bott" Value='<?= $lang['REMOVE'] ?>' style='width:100px;'  onClick="javascript:Delete();">

									<? if ($_SESSION['invite_email_id_user'] != '' && $_SESSION['invite_inviteuser_id_user'] == 'inviteuser' && $_SESSION['invite_status_id_user'] == "open") { ?>
										<input type='hidden' name='invtxtemail' Value='<?= $_SESSION['invite_email_id_user'] ?>' >
										<input type='hidden' name='invtxtemail_post' Value='<?= $_SESSION['invite_inviteuser_id_user'] ?>' >
										<input type='hidden' name='txtemail_stat' Value='<?= $_SESSION['invite_status_id_user'] ?>' >			                                                 
										<?
										unset($_SESSION['invite_email_id_user']);
										unset($_SESSION['invite_inviteuser_id_user']);
										unset($_SESSION['invite_status_id_user']);
									}
									?>
									<? if ($_POST['invtxtemail'] != '' && $_POST['invtxtemail_post'] == 'inviteuser' && $_POST['txtemail_stat'] == "open") { ?>
										<input type='hidden' name='invtxtemail' Value='<?= $_POST['invtxtemail'] ?>' >
										<input type='hidden' name='invtxtemail_post' Value='<?= $_POST['invtxtemail_post'] ?>' >
										<input type='hidden' name='txtemail_stat' Value='<?= $_POST['txtemail_stat'] ?>' >															
									<? } ?>
									
								
							</div>
						</div>
						
						
					    <div class="screen-quest" <?=$STYLE?>>
                            <h2>Screening Questions</h2>
                            <p>Add a few questions you'd like you candidates to answer when applying to your job.</p>
                            <div class="screen-question-list">
                                <div class="col-sm-8 screen-question-input clear-fix">
                                    <input type="text" class="form-control" name="question_1" id="question_1">
                                    <p class="sq-limit-text">200 characters left</p>                                
                                </div>
                            </div>
                            <p class="clear-fix">
                                <button type="button" class="btn btn-link btn-add-more-sq"><i class="fa fa-plus"></i>&nbsp;Add Another Question</button>
                            </p>
                        </div>
						
						
					<div class="form-group">
                            <label for="" class="col-sm-3 control-label"><?= $lang['PRMT_LSTNG'] ?></label>
							<div class="col-sm-9">
								
                                        <div class="arrangemen_form" style="width:100%">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="option">

                                                <tbody><tr><td colspan="5">
                                                        </td></tr>

                                                    <tr>
                                                        <td align="center" >

                                                            <INPUT type="checkbox" name="featured" id="featured" value="featured" <?
                                                            if ($d[featured]) {
                                                                echo" checked";
                                                            }
                                                            ?> onclick="getfeature(this.id)" />
                                                        </td>
                                                        <td align="center"><img src="<?= $vpath ?>/images/<?= $ln ?>/fratured.jpg" alt="fratured"></td>
                                                        <td align="left"><p><?= $lang['FEATURED_PROJ'] ?></p></td>
                                                        <td style="width:100px;"><p><b><? echo $curn . " " . $setting[featuredcost]; ?> </b></p></td>
                                                        <td></td>
                                                    </tr>

                                                </tbody></table>
                                        </div>

                                   
							</div>
					     </div> 
						
						
                        <div>
							<input type="hidden" value="<?=$job_id_edit?>" name="id_edit"/>
							<? if (!$msg3) { ?>
								<?php if($job_id_edit != 0){ ?>
									<input  type="submit" name="submit" value='<?= $lang['FR_LB_JOB_BUTTON_EDIT'] ?>'  class="btn btn-primary"/>
								
								<?php }else{ ?>
									<input  type="submit" name="submit" value='<?= $lang['FR_LB_JOB_BUTTON_ADD'] ?>'  class="btn btn-primary"/>
								<?php } ?>
							<?php } ?>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>

<script type="text/javascript">

	$(document).ready(function() {
        $("#skills").chosen();

        var d_exp_level_checked = $('input[name="d_exp_level"]:checked');
        d_exp_level_checked.parent().addClass('dexplv-checked');
        $('input[name="d_exp_level"]').change(function(){
            $('input[name="d_exp_level"]').parent().removeClass('dexplv-checked');
            $(this).parent().addClass('dexplv-checked');
        })

        $('.btn-add-more-sq').click(function(){
            var clone = $('.screen-question-input:first-child').clone();
            clone.appendTo('.screen-question-list');
        })


		$('select[name=category_id]').change(  function(){
			  
			var category_id = parseInt($(this).val());	
			var i = 0;
			
			var option_child_selected_arr = [];
			$('select[name=child_category_id] option').each(function () {
			
				var id_opt = $(this).attr("id");
				var type_id = parseInt($(this).attr("type_id"));
			
				var id_css = "#"+id_opt;
				
				if(category_id != 0){
				
					if(type_id==category_id){
						$(id_css).show();
						$(id_css).attr('selected', 'selected');
						option_child_selected_arr.push($(id_css).val());
					}else{
						$(id_css).hide();	
					}
				}else{
					$(id_css).show();	
				}
				
			});
			// console.log(option_child_selected_arr);
			var parent = $('select[name=child_category_id]').parent();
			parent.find('.DivSelectyze').remove();
			$('select[name=child_category_id]').Selectyze({theme : 'mac'});

			var selectize_list = parent.find('.UlSelectize li');

			if(option_child_selected_arr.length > 0) {
				selectize_list.find('a').hide();

				for (i = 0; i < option_child_selected_arr.length; i++) { 
					selectize_list.find('a[rel='+option_child_selected_arr[i]+']').show();
				}
			} else {
				selectize_list.find('a').show();
			}	
		});
		<?php if($job_id_edit == 0){ ?>
		var project = $('select[name=project_type]').val();
		if (project == 'F') {
			$(".hourly").hide();
			$(".fixed").show();
		} else {
			$(".fixed").hide();
			$(".hourly").show();

		}
		<?php } ?>
		$('select[name=project_type]').change(function () {
				
				var project = $(this).val();
				if (project == 'F') {
					$(".hourly").hide();
					$(".fixed").show();
				} else {
					$(".fixed").hide();
					$(".hourly").show();

				}

		});
			
	});
	
	function deleteOption(selectObject, optionRank) {

        if (selectObject.options.length != 0) {
            selectObject.options[optionRank] = null
        }

    }

    function Delete() {

        var formObject = document.forms['postjob']

        if (formObject.attachfile.selectedIndex != -1) {

            deleteOption(formObject.attachfile, formObject.attachfile.selectedIndex)



            selectBox = document.getElementById('attachfile');



            for (var i = 0; i < selectBox.options.length; i++) {

                selectBox.options[i].selected = true;

            }

        } else {

            alert("<?= $lang['ALERT1'] ?>");

        }

    }

	
    function RegValidate(frm)

    {

        var txt = "";

        if (document.getElementById("project").value == '')
        {
            txt += "<?= $lang['ALERT2'] ?>.\n";
        }

        if (document.postjob.description.value == '')
        {
            txt += "<?= $lang['ALERT3'] ?>.\n";
        }
     
        if (document.postjob.skills.value == '')
        {
            txt += "<?= $lang['ALERT4'] ?>.\n";
        }
		
        if (document.postjob.project_type.value == "F") {
            if (document.postjob.budget_id.value == '')

            {

                txt += "<?= $lang['ALERT7'] ?>.\n";

            }
        } else {
            if (document.postjob.budget_min.value < 1 || document.postjob.budget_max.value < 1)

            {

                txt += "Enter budget price.\n";

            }

        }
      
        if (document.postjob.featured.checked == true)

        {

			<?php
			$res = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");

			$row = mysql_fetch_array($res);

			$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));

			$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));

			$balsum = $rwbal['balsum1'] - $rwbal2['baldeb'];



			if ($balsum < $setting['featuredcost']) {
				?>

							txt += "<?= $lang['unsufficientamount'] ?>.<?php echo $setting['featuredcost']; ?>.\n";

				<?php
			}
			?>
		}

        if (txt)
		{
			alert(txt);
			return false
		}

        return true

    }
	 function getfeature() {

        if ($('#featured').is(':checked')) {
            $('.sfeature').removeAttr("disabled");
        } else {
            $('.sfeature').prop("disabled", true);
        }
    }
	function edittext() {

        $("#descriptclass").slideDown('slow');
       
    }
	
</script>	