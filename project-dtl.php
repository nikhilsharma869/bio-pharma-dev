<?php
include "includes/header.php";


include("country.php");

//CheckLogindecode(base64_encode("project/".$_REQUEST['id']));
//CheckLogin('project-dtl.php?id='.$_GET['id']);



$res = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");

$row = mysql_fetch_array($res);

$row1 = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id = '" . $_GET[id] . "'"));



$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));



$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));



$balsum = number_format(($rwbal['balsum1'] - $rwbal2['baldeb']), 2);

$sum = 0;



$res4pend = mysql_query("select * from " . $prev . "escrow where bidder_id='" . $_SESSION['user_id'] . "' and status='P'");

while ($row4pend = mysql_fetch_array($res4pend)) {

    $sum+=$row4pend['amount'];
}

$sum1 = number_format($sum, 2);



if ($_REQUEST[id]) {

    $result = mysql_query("SELECT * FROM  " . $prev . "projects WHERE id='" . $_REQUEST[id] . "'");

    if (@mysql_num_rows($result) == 0) {

        $err = "<div align=center calss=red><strong>" . $lang['JOB_NO_FD_ID_H'] . "</strong></div>";
    } else {

        $d = mysql_fetch_array($result);
    }
}



$start_end = project_start_end_date_new($_REQUEST[id]);

$buyer = user_details($d['user_id']);

//Check user bided or not
$update_bid_user = @mysql_num_rows(mysql_query("select id from " . $prev . "buyer_bids where project_id='" . $_REQUEST[id] . "' and bidder_id='" . $_SESSION['user_id'] . "'"));
				
?>


<div class="spage-container">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="jobdtl_left">
                <!-- tabs left -->
                
				<div class="browse_contract_right">
					<div class="browse_right_text">
						<h1><?= $lang['CLIENT_DETAILS'] ?></h1>
					</div>
					
					<div class="clear"></div>
				
					<div class="jobdtl_panel_content">
						
						
						
						<table width="100%" align="right" style="font-size:13px; font-size:14px;">
							<tr>
								<td width="52%" height="24"><p style="padding:0; margin:0; color:#1b4471;"><img src="<?= $vpath ?>viewimage.php?img=<?php echo $buyer['logo']; ?>&width=99&height=88" style=" border:1px solid #666;float: left; margin-right: 10px;"/>
								</p></td>
								<td width="48%">
									<!--Button Ask and Bid-->
					
										<?php  if ($_SESSION['user_id'] != $d['user_id'] && $d['status'] == "open") { ?>
								
													<a  class="btn" href="javascript:void(0)" onclick="bid()">
														<?php
															if ($update_bid_user > 0) {
																echo $lang['Revise_Bid'];
															} else {
														?>
														<?= $lang['Place_Bid'] ?><? } ?>
													</a>
												
										<?php } elseif (($_SESSION['user_id'] == $d['user_id'] || $_SESSION['user_id'] == $d['chosen_id']) && $d['status'] == "process" && $d[project_type] == 'H') {?>
														<a  class="btn" href="<?= $vpath ?>snap/<?= $d['id'] ?>">View Progress</a>
										<?php } ?>
									<!--Button Ask and Bid-->	
										
								</td>
							</tr>
							<tr>
								<td width="52%" height="24"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['CLIENT_NAME'] ?> :</p></td>
								<td width="48%"><p style="padding:0; margin:0;"><?= $buyer['username']; ?></p></td>
							</tr>
							<tr>
								<td width="52%"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['REVIEW_STARS'] ?> :</p></td>
								<td width="48%"><p style="padding:0; margin:0;"><?= getrating($buyer[user_id]) ?></p></td>
							</tr>
							<tr>
								<td width="52%"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['LOCATION'] ?> :</p></td>
								<td width="48%"><p style="padding:0; margin:0;"><span><img src="<?= $vpath ?>cuntry_flag/<?= strtolower($buyer[country]); ?>.png" title="<?= $country_array[$buyer[country]]; ?>" width="16" height="11" >&nbsp;<?php print $country_array[$buyer[country]]; ?></span></p></td>
							</tr>

							<tr>
								<td width="52%"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['TOTAL_PROJECTS'] ?>  :</p></td>
								<td width="48%"><p style="padding:0; margin:0;"><?= getprojectcountforuser($buyer['user_id']) ?></p></td>
							</tr>
							<tr>
								<td width="52%"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['COMPLETE_PROJECTS'] ?>  :</p></td>
								<td width="48%" valign=top><p style="padding:0; margin:0;"><?= getprojectcompltedbyclient($buyer['user_id']) ?></p></td>
							</tr>
						</table>
						<div class="clear"></div>
						
					</div>
					
				
				</div>
				
				<div id="bidpanel">
					<?php
					if ($d['status'] == "open" && $_SESSION[user_id] != '') {

						if ($_SESSION['user_id'] == $d['user_id']) {
							echo "<div style='color:red;padding-top:30px'>You can't bid of your own project.</div>";
						} else {
							include("includes/bid_panel.php");
						}
					} else {
						?>
							<div style='color:red;padding-top:30px;float: left;width: 100%;'>
								<a href="<?= $vpath ?>login/<?= base64_encode("project/" . $_REQUEST[id]) ?>" class="submit_bottnew"><?= $lang['LOGIN_LANG'] ?></a>
							</div>
						<?
					}
					?>

					</div>
					<div id="askpanel">
						<? include("includes/message_box.php"); ?>
					</div>
				
				
            </div>
            <!-- Content right -->
            <div class="jobdtl_right">
                <!-- content data list -->
                <div class="content-right">
					 <div class="lft_area">
							<h2 class="opt_text"><?= ucfirst($d['project']) ?></h2>
						</div>     
						<div class="awd_area">

							<table class="jobdlt_panel_left">
								<tr>
									<td class="td_bd">
										<p class="opt_text1"> 
											<?php if (getprojecttype($d['id']) == "F") { ?><img src="<?= $vpath ?>images/fixed.png" alt="<?= $lang['FIXED'] ?>" title="<?= $lang['FIXED'] ?>" /><? } else { ?><img src="<?= $vpath ?>images/hourly.png" alt="<?= $lang['HOURLY'] ?>" title="<?= $lang['HOURLY'] ?>" />
											<? } ?>
										</p>
									</td>
									<td class="td_bd"><p class="opt_text1"><?= totalbid($d['id']) ?></p><p class="ago_text"><?= $lang['NO_OF_BIDS'] ?></p></td>
									<td class="td_bd"><p class="opt_text1">
										<?= $paypal_settings['silver_member_currency'] ?><?= avaragebid($d['id']) ?><?php
										if (getprojecttype($d['id']) == "H") {
											echo "/hr";
										}
										?></p>
										<p class="ago_text"><?= $lang['AVG_BIDS'] ?></p>
									</td>
									
									<td class="td_bd"><p class="opt_text1">
										<?php if ($d['project_type'] == "F") { ?>
												<?= $budget_array2[$d['budget_id']] ?>
											<?php } else { ?>
												<?= $curn . $d['budgetmin'] . " to " . $curn . $d['budgetmax'] ?>
											<? } ?></p>
											<p class="ago_text"><?= $lang['BUDGETT'] ?></p>
									</td>
								</tr>
							</table>
							<div class="jobdlt_panel_right">
									<div class="cal_area color_<?= $d[status] ?>">

										<?= $start_end['end'] ?>
									</div>
							</div>
							<p class="rbn1"><?= getfeatureicon($d['id'], '2') ?></p>
						</div>
						
						<div class="clear"></div>
						
					<p class="des_text"><span class="news_heading1"><?= $lang['DESCRIPTION'] ?> : </span>&nbsp;&nbsp;<?= $d['description']; ?></p>
				
					<?
					//Get Attachment
					$otherdet = mysql_query("select info from " . $prev . "projects_additional where project_id='" . $_REQUEST[id] . "'");
					$ui = 0;
					$uia = 0;
					while ($infp = @mysql_fetch_assoc($otherdet)) {
						if ($infp[info] != '') {
							$ui++;
							echo " <p class='des_text'><span class='news_heading1'>Addition info " . $ui . "</span> : " . nl2br($infp[info]) . "</p>";
						}
					}
					
					//Get list Skill
					$skills = get_list_skill_by_job_id($d[id]);
					$job_skills = "";
					foreach($skills as $skill){
						// $job_skills .=  "<span id='skill'>".$skill['skill_name']."</span>";
							
						$job_skills .= "	<li class='endorse-item'>";
						$job_skills .= "	<div>";
						$job_skills .= "	<span class='skill-pill'>";
						$job_skills .= "	<span class='endorse-item-name '>";
						$job_skills .= "	<a href='".$vpath."jobs/1/0/".$skill['skill_id']."/".$skill['url_skill']."/All/0/0/All/0/'";
						$job_skills .= "    class='endorse-item-name-text'>".$skill['skill_name']."</a>";
						$job_skills .= "	</span>";
						$job_skills .= "	</span>";
						$job_skills .= "	</div>";
						$job_skills .= "	</li>";
					}
					?>



					<span class="news_heading1"><?= $lang['SKILLS'] ?> : </span> <ul class='skills-section compact-view'  style="padding-left:0px;margin-top:5px;margin-bottom:5px;"><?=$job_skills;?></ul>
							
							
					<!--File Attachment-->	
					<? if ($d['attachment'] != "") { ?>     
								<div class="news_heading" style=" border:none;padding-right:0px; "><?= $lang['ATTACH'] ?> : </div>


								<div class="box-attachments" style="width:450px"><?php
									$no_of_att = explode(",", $d['attachment']);
									$x = 1;
									$uia = 0;
									foreach ($no_of_att as $atno) {
										list($nm1, $nm) = explode("-", $atno, 2);
										?>
										<a href="<?= $vpath . $atno ?>"  target="_blank"><?= ucfirst($nm) ?></a> <br />
										<?php
										$x++;
									}
									?></div>
								<?php
							}
							$otherdet1 = mysql_query("select attached_file from " . $prev . "projects_additional where project_id='" . $_REQUEST[id] . "'");

							while ($infp1 = @mysql_fetch_assoc($otherdet1)) {

								if ($infp1[attached_file] != '') {
									$uia++;
									echo "<div class='attach'><div class='news_heading' style='border:none;padding-right:0px '>Addition attach " . $uia . " : </div>";
									?>
									<div class="box-attachments" style="width:450px">
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
								<?
							}
						}
					?>		
					<!--File Attachment-->	
					
					<div class="clear"></div>
					<?php if ($_SESSION['user_id'] != $d['user_id'] && $update_bid_user == 0) { ?><a href="javascript:void(0)" class="ask" onclick="ask()"><img src="images/ques.jpg" width="30" height="30" alt="" style=" float:left;" />&nbsp;<?= $lang['ASK_A_QUESTION'] ?></a><? } ?>
						
					<!--List Bid-->		
					<table width="98%" align="left" style=" margin-top:20px; font-size:13px;padding:5px;">

						<tr>
							<td colspan="2" style="background: #2272ba;
									 box-shadow: 0 0 10px #2272ba inset;"><div  class="proposalcss" ><?= $lang['ATT_PROPOSAL'] ?></div></td></tr>
									 <?php
									 $j = 0;
									 $bees = mysql_query("SELECT * FROM  " . $prev . "buyer_bids WHERE project_id='" . $_REQUEST[id] . "' ORDER BY add_date ASC");
									 if (mysql_num_rows($bees) > 0) {
										 while ($row = mysql_fetch_array($bees)) {
											 $j++;
											 $provider = user_details($row[bidder_id]);
											 ?>
									<tr class="proposal">

										<td width="15%" valign="top"><a href="<?= $vpath ?>publicprofile/<?= $provider['username'] ?>/" > 
											<img src="<?= $vpath ?>viewimage.php?img=<?php echo $provider['logo']; ?>&width=70&height=70" style=" border:1px solid #666;" /></a>
										</td>
										<td width="85%" valign="top"><table width="100%">
												<tr>
													<td>
														<a href="<?= $vpath ?>publicprofile/<?= $provider['username'] ?>/" >
															<h2 class="new" style=" margin:0; padding:0;">
																<?= getfullname($row[bidder_id]); ?>&nbsp;
																<? if ($row[bidder_id] == $d['chosen_id'] && $d['status'] != "frozen") {?>
																	<img src="<?= $vpath ?>images/<?= $ln ?>/awarded_ic.jpg" alt="awarded" title="award" height=20>
																<? } ?>
															</h2>
														</a>
														<div style="position: relative;width: 200px;float: right;margin-top: -20px;text-align: right;">

															<?php if ($row[bidder_id] == $d['chosen_id'] && $d['status'] == "frozen") { ?>
																<span class="asdf" id="award_<?= $row[bidder_id] ?>"><img src='<?= $vpath ?>images/<?= $ln ?>/invited_ic.jpg' alt='invided' title='invited'/></span>
																<a href="javascript:void(0)" onclick="assignfreelancer(<?= $_REQUEST[id] ?>,<?= $row[bidder_id] ?>)" class=" allawd awardclass_<?= $row[bidder_id] ?>" style="display:none;"><img src="<?= $vpath ?>images/<?= $ln ?>/award_ic.jpg" alt="Award" title="Award"/></a>
															<?php } elseif ($_SESSION['user_id'] == $d['user_id'] && ($d['status'] == "open" || $d['status'] == "frozen")) { ?>
																<span class="asdf" id="award_<?= $row[bidder_id] ?>"></span>
																<a href="javascript:void(0)" onclick="assignfreelancer(<?= $_REQUEST[id] ?>,<?= $row[bidder_id] ?>)" class=" allawd awardclass_<?= $row[bidder_id] ?>" ><img src="<?= $vpath ?>images/<?= $ln ?>/award_ic.jpg" alt="Award" title="Award"/></a>
															<?php } ?>


															<?php if ($_SESSION['user_id'] == $d['user_id']) { ?>
																<a href="<?= $vpath ?>conversation/<?= $_REQUEST[id] ?>/<?= $row[bidder_id] ?>/"><img src="<?= $vpath ?>images/conversation.png" alt="conversation" title="conversation" height=25></a>
															<?php } ?>
															<?php if ($_SESSION['user_id'] == $row[bidder_id]) { ?>
																<a href="<?= $vpath ?>conversation/<?= $_REQUEST[id] ?>/<?= $d['user_id'] ?>/"><img src="<?= $vpath ?>images/conversation.png" alt="conversation" title="conversation" height=25></a>
															<?php } ?>
														</div>
														<p style="padding:0; margin:0;">
															<span>
															<img src="<?= $vpath ?>cuntry_flag/<?= strtolower($provider[country]); ?>.png" title="<?= $country_array[$provider[country]]; ?>" width="16" height="11" >	
															<?php print $country_array[$provider[country]]; ?>&nbsp;
															</span></p>
													</td>
												</tr>
												<tr>
													<td  class="newclass2">
																<!--<p style="padding:0; margin:0;"><span ><?= $lang['TOTAL_PROJECT_AMOUNT'] ?>: </span><b><?= $curn ?> <?= $row['emp_charge'] ?> </b></p>
														<p style="padding:0; margin:0; "><span ><?= $lang['DURATION'] ?>: </span><b><?= $row['duration'] ?> <?= $lang['day'] ?><? if ($row['duration'] > 1) { ?>s<? } ?></b></p>-->
														<p style="padding:0; margin:0; "><?= $row['cover_letter']; ?></p>

														
															<span ><?= $lang['SKILLS'] ?> : </span>
															 <?php 
																	$skill_q = "select skills from " . $prev . "user_profile where user_id=" . $d[user_id];

																	$res_skill = mysql_query($skill_q);
																	$data_skills = @mysql_result($res_skill,0,"skills");
																	$data_skills = explode(',', $data_skills);
																	$count = 1;
																	foreach ($data_skills as $skill) {
																		if($count > 5 ) break;
																		
																		$data_skill_name .= "	<li class='endorse-item'>";
																		$data_skill_name .= "	<div>";
																		$data_skill_name .= "	<span class='skill-pill'>";
																		$data_skill_name .= "	<span class='endorse-item-name '>";
																		$data_skill_name .= "	<a href='javascript:void(0)'";
																		$data_skill_name .= "    class='endorse-item-name-text'>".$skill."</a>";
																		$data_skill_name .= "	</span>";
																		$data_skill_name .= "	</span>";
																		$data_skill_name .= "	</div>";
																		$data_skill_name .= "	</li>";
																	
																		$count++;
																	}
																   
																	$skill_name = $data_skill_name;
																	
																?>
																<ul style="padding-left:0px;margin-top:5px;margin-bottom:5px;" class="skills-section compact-view">	
																	<?php echo  $skill_name;?>
																</ul>
														

														<p class="jobdtl_review"><?= $lang['REVIEWS'] ?>(<?= getreviewcount($row[bidder_id]) ?>) <?= getrating($row[bidder_id]) ?> | <?= $lang['j_ob'] ?> : (<?= getworkedprojectcountforuser($row[bidder_id]) ?>)</p>
													</td>
												</tr>


											</table>
										</td>
									</tr>
									<tr>
										<td colspan=2 style="background:#F5F4F6;border-radius:5px;height:30px;"> 
											<span style="padding:0px 10px" ><?= $lang['SUBMIT_ON'] ?> : <b>&nbsp;<?php print date('M d, Y H:i:s', strtotime($provider[ldate])); ?></b></span >|
											<span style="padding:0px 10px"><?= $lang['DURATION'] ?> : <b>&nbsp;<?= $row['duration'] ?> <?= $lang['day'] ?><? if ($row['duration'] > 1) { ?>s<? } ?> </b></span>
											<span style="padding:0px 10px; float:right"><?= $lang['BIDS'] ?> : <b>&nbsp;<?= $curn ?> <?php if ($d['project_type'] == "F") { ?><?= $row['emp_charge'] ?><?php } else { ?><?= $row['emp_charge'] ?>/hr <?php } ?></b></span></td></tr>
									<tr><td colspan=2 style="border-bottom: 1px solid #2272ba;"></td></tr>
									<?php
								}
							} else {
								echo ' <tr><td colspan=2 style="border-bottom: 1px solid #f0f0f0;" align=center height="50">' . $lang['NO_PROPOSAL_FOUND'] . '</td></tr>';
							}
							?> 


					</table>
					
					<!--List Bid-->		
					
					
					<div class="clear"></div>
                </div>
            </div>

        </div>
    </div>  
</div>

<script type="text/javascript">

    function getbid(amt)

    {

        var m = parseFloat(amt);

        var comm_type = document.getElementById('bid_commitype_hid_id').value

        var feeprcnt = parseFloat(document.getElementById('bid_commission_hid_id').value);

        if (isNaN(amt) || m < 1 || amt == '')

        {

            document.getElementById('bidamount1').value = '0.00';

            document.getElementById('bidamount').value = '0.00';

        }

        else if (m >= 1)

        {

            if (comm_type == 'P')

            {

                var fee = (m * feeprcnt) / 100;

            }

            else if (comm_type == 'F')

            {

                var fee = feeprcnt;

            }

            var chrg = m + fee;
            document.getElementById('site_fee_hid_id').value = fee.toFixed(2);

            document.getElementById('bidamount').value = chrg.toFixed(2);

        }

    }

    function bid_valid()

    {

        if (document.getElementById('bidamount').value == '0.00' || document.getElementById('bidamount').value == '')

        {

            alert('Please enter a valid bid amount');

            document.getElementById('bidamount1').focus();

            return false;

        }

        if (isNaN(document.getElementById('bidamount').value))

        {

            alert('Please enter a valid bid amount');

            document.getElementById('bidamount1').focus();

            return false;

        }

        if (document.getElementById('delivery').value == '')

        {

            alert('Please enter number of days');

            document.getElementById('delivery').focus();

            return false;

        }

        if (isNaN(document.getElementById('delivery').value) || parseInt(document.getElementById('delivery').value) < 1)

        {

            alert('Please enter a valid number of days');

            document.getElementById('delivery').focus();

            return false;

        }

        if (document.getElementById('details').value == '')

        {

            alert('Please enter bid details');

            document.getElementById('details').focus();

            return false;

        }

        document.bidform.submit();

    }
    function bid_valid1() {
        if (document.getElementById('details').value == '')
        {
            alert('Please enter bid details');
            document.getElementById('details').focus();
            return false;
        }
        if (document.getElementById('bidamount1').value == '0.00' || document.getElementById('bidamount1').value == '') {
            alert('Please enter a valid bid amount');
            document.getElementById('bidamount1').focus();
            return false;
        }
        if (isNaN(document.getElementById('bidamount1').value)) {
            alert('Please enter a valid bid amount');
            document.getElementById('bidamount1').focus();
            return false;
        }
        if (document.getElementById('delivery').value == '')
        {
            alert('Please enter number of days');
            document.getElementById('delivery').focus();
            return false;
        }
        if (isNaN(document.getElementById('delivery').value) || parseInt(document.getElementById('delivery').value) < 1) {
            alert('Please enter a valid number of days');
            document.getElementById('delivery').focus();
            return false;
        }

        document.bidform.submit();

    }
</script>
<script>
    function ask() {
        $("#bidpanel").slideUp('slow');
        $("#askpanel").slideDown('slow');

    }
    function bid() {
        $("#bidpanel").slideDown('slow');
        $("#askpanel").slideUp('slow');
        ;
    }

</script>
<script>
    function validatepost() {
        if (document.getElementById('message').value == "") {
            alert("Please Enter Message");
            document.getElementById('message').focus();
            return false;
        }
        return true;
    }
    function assignfreelancer(project_id, bider_id) {

        var info = "project_id=" + project_id + "&bidder_id=" + bider_id;
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>assichuserforproejct.php",
            data: info,
            beforeSend: function() {

                $(".asdf").html('');
                $(".allawd").show('slow');
                $(".awardclass_" + bider_id).hide('slow');

                $("#award_" + bider_id).html('<img src="<?= $vpath ?>images/login_loader2.GIF" height=22 width=22  />');
            },
            success: function(dd) {
                $("#award_" + bider_id).html(dd);

            }
        });

    }
</script>
<?php include 'includes/footer.php'; ?>