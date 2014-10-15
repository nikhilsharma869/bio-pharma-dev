<?php
include "includes/header.php";


include("country.php");

CheckLogin();

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
		
$rs = @mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'P' AND project_id='".$_REQUEST[id]."'");

if(mysql_num_rows($rs)<=0){
	header("Location: /Jobs/");
}

$rs1 = mysql_fetch_array($rs);
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
								
								</td>
							</tr>
							<tr>
								<td width="52%" height="24"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['CLIENT_NAME'] ?> :</p></td>
								<td width="48%"><p style="padding:0; margin:0;"><b><?= $buyer['fname']; ?> <?= $buyer['lname']; ?></b></p></td>
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
				
				
				
            </div>
            <!-- Content right -->
            <div class="jobdtl_right">
                <!-- content data list -->
                <div class="content-right">
					 <div class="lft_area">
							<a href="<?= $vpath ?>project/<?=$d['id']?>" target="_blank"><h2 class="opt_text">OFFER : <?= ucfirst($d['project']) ?></h2></a>
						</div>     
						<div class="awd_area">

							<table class="jobdlt_panel_left" style="width:70%">
								<tr>
									<td class="td_bd">
										<p class="opt_text1"> 
										
											
											<?php if ($d[project_type] == "F") { ?><img src="<?= $vpath ?>images/fixed.png" alt="<?= $lang['FIXED'] ?>" title="<?= $lang['FIXED'] ?>" /><? } else { ?><img src="<?= $vpath ?>images/hourly.png" alt="<?= $lang['HOURLY'] ?>" title="<?= $lang['HOURLY'] ?>" />
											<? } ?>
										</p>
									</td>
									<td class="td_bd">
											<p class="opt_text1">
										
												<?= $curn . $rs1['bid_amount']?>
												<?php	
													if ($d[project_type] == "H") {
														echo "/hr";
													}
												?></p>
											
											<p class="ago_text"><?= $lang['BUDGETT'] ?></p>
									</td>
									<?php if ($d[project_type] == "H") { ?>
									<td class="td_bd"><p class="opt_text1"><?= totalbid($d['hour_limit']) ?></p><p class="ago_text"><?= $lang['HOUR_LIMIT'] ?></p></td>
									<?php } ?>
									
									<?php if ($d[project_type] == "H") { ?>
									<td class="td_bd">
										<p class="opt_text1">
											<?php 
												if($d['enabled_manual_time']=='Y') echo $lang['FR_LB_JOB_MANUAL_TIME_YES'];
												else $lang['FR_LB_JOB_MANUAL_TIME_NO'];
												
											?>
										</p>
										<p class="ago_text"><?= $lang['FR_LB_JOB_ALLOW_MANUAL_TIME'] ?></p>
									</td>
									<?php }?>
									
									<td class="td_bd">
										<p class="opt_text1">
											<?php 
												echo $rs1['duration'];
											?>
										</p>
										<p class="ago_text"><?= $lang['DURATION'] ?></p>
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
						
						<div class="decline_bott" ><a href="<?=$vpath?>dashboard.php?mode=deny&id=<?php echo $d['id'] ?>&deny=<?php echo $d['id'] ?>"><?=$lang['DECLINE']?></a></div>
						
						<div class="accept_bott" ><a href="<?=$vpath?>my-jobs.php?mode=accept&id=<?php echo $d['id'] ?>&confirm=<?php echo $d['id'] ?>"><?=$lang['ACCEPT']?></a></div>
						
						<div class="clear"></div>
						
						
				
					<div class="clear"></div>
					<!--List Bid-->		
						
					
					
					<div class="clear"></div>
                </div>
            </div>

        </div>
    </div>  
</div>

<?php include 'includes/footer.php'; ?>