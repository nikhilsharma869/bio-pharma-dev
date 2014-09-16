<?php
$current_page = "Project Description";

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

$project_cats = project_category($_REQUEST[id]);
?>

<link rel="stylesheet" type="text/css" href="<?= $vpath ?>highslide/highslide.css" /><script type="text/javascript" src="<?= $vpath ?>highslide/highslide-with-html.js"></script>

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
<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="<?= $vpath ?>sear_all_jobs.html"><?= $lang['FIND_JOBB'] ?></a> | <a href="javascript:void(0);" class="selected"><?= $lang['PROJECT_DETAILS'] ?></a></p></div>
    <div class="clear"></div>






    <div class="profile_right" style="width:315px;">
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=582881015093707";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <div class="social_pannel">
            <ul class="share">
                <li style="display:inline">
                    <!-- SMARTADDON BEGIN -->
                    <script type="text/javascript">
                        (function() {
                            var s = document.createElement('script');
                            s.type = 'text/javascript';
                            s.async = true;
                            s.src = 'http://s1.smartaddon.com/share_addon.js';
                            var j = document.getElementsByTagName('script')[0];
                            j.parentNode.insertBefore(s, j);
                        })();
                    </script>

                    <a href="http://www.smartaddon.com/?share" title="Share Button" onclick="return sa_tellafriend('', 'email')"><img alt="Share" src="<?= $vpath ?>images/email.png" border="0" /></a>
                    <!-- SMARTADDON END -->
                </li>
                <li style="display:inline">
                    <div class="fb-like" data-href="http://<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>


                </li>
                <li style="display:inline">
                    <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
                    <script>!function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = p + '://platform.twitter.com/widgets.js';
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, 'script', 'twitter-wjs');</script>
                </li>
                <li style="display:inline;margin-left: -25px;">
                    <script src="//platform.linkedin.com/in.js" type="text/javascript">
                        lang: en_US
                    </script>
                    <script type="IN/Share" data-counter="right"></script>
                </li>
            </ul>
        </div>

        <div class="desciript-text_box1"><h3 class="post_box" style=" border:none;width: 285px;"><?= $lang['CLIENT_DETAILS'] ?></h3>
            <a href="<?= $vpath ?>publicprofile/<?= $buyer['username'] ?>/" ><img src="<?= $vpath ?>viewimage.php?img=<?php echo $buyer['logo']; ?>&width=99&height=88" style=" border:1px solid #666;float: left;
                                                                                  margin-right: 10px;"/></a>


            <table width="200" align="right" style="font-size:13px; font-size:14px;">
                <tr>
                    <td width="52%" height="24"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['CLIENT_NAME'] ?> :</p></td>
                    <td width="48%"><a href="<?= $vpath ?>publicprofile/<?= $buyer['username'] ?>/" ><p style="padding:0; margin:0;"><?= $buyer['username']; ?></p></a></td>
                </tr>
                <tr>
                    <td width="52%"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['REVIEW_STARS'] ?> :</p></td>
                    <td width="48%"><p style="padding:0; margin:0;"><?= getrating($buyer[user_id]) ?></p></td>
                </tr>
                <tr>
                    <td width="52%"><p style="padding:0; margin:0; color:#1b4471;"><?= $lang['LOCATION'] ?> :</p></td>
                    <td width="48%"><p style="padding:0; margin:0;"><span><?php print $country_array[$buyer[country]]; ?>&nbsp;<img src="<?= $vpath ?>cuntry_flag/<?= strtolower($buyer[country]); ?>.png" title="<?= $country_array[$buyer[country]]; ?>" width="16" height="11" ></span></p></td>
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
                ?><div style='color:red;padding-top:30px;float: left;width: 100%;'>
                    <a href="<?= $vpath ?>login/<?= base64_encode("project/" . $_REQUEST[id]) ?>" class="submit_bottnew"><?= $lang['LOGIN_LANG'] ?></a></div>
                <?
            }
            ?>

        </div>
        <div id="askpanel">
            <? include("includes/message_box.php"); ?>

        </div>
    </div>

    <div class="profile_left" style="width:650px; border-right:1px dashed #CCC; padding:5px;">


        <div class="lft_area">
            <h2 class="opt_text"><?= ucfirst($d['project']) ?></h2>
            <p class="ago_text"><?= getcategory($d[main_cat_id]) ?></p>
        </div>     
        <div class="rht_area">
            <div class="cal_area color_<?= $d[status] ?>">

                <?= $start_end['end'] ?>
            </div>
        </div>

        <div class="awd_area">

            <table>
                <tr>
                    <td class="td_bd"><p class="opt_text1"><?= totalbid($d['id']) ?></p><p class="ago_text"><?= $lang['NO_OF_BIDS'] ?></p></td>
                    <td class="td_bd"><p class="opt_text1"><?= $paypal_settings['silver_member_currency'] ?><?= avaragebid($d['id']) ?><?php
                            if (getprojecttype($d['id']) == "H") {
                                echo "/hr";
                            }
                            ?></p><p class="ago_text"><?= $lang['AVG_BIDS'] ?></p></td>
                    <td class="td_bd"><p class="opt_text1"><?php if ($d['project_type'] == "F") { ?><?= $budget_array2[$d['budget_id']] ?><?php } else { ?><?= $curn . $d['budgetmin'] . " to " . $curn . $d['budgetmax'] ?><? } ?></p><p class="ago_text"><?= $lang['BUDGETT'] ?></p></td>
                    <td class="td_bd"><p class="opt_text1"> <?php if (getprojecttype($d['id']) == "F") { ?><img src="<?= $vpath ?>images/fixed.png" alt="<?= $lang['FIXED'] ?>" title="<?= $lang['FIXED'] ?>" /><? } else { ?><img src="<?= $vpath ?>images/hourly.png" alt="<?= $lang['HOURLY'] ?>" title="<?= $lang['HOURLY'] ?>" /><? } ?></p></td>
                </tr>
            </table>
            <p class="rbn1"><?= getfeatureicon($d['id'], '2') ?></p>
        </div>



        <table width="100%%" style=" font-size:13px; margin-bottom:20px; border-bottom:1px dotted #D9D5D6;">

            <tr>
                <td colspan="2">



					<?php 
					$fbo_query = "Select * from serv_projects_fbo where project_id = '".$_GET['id']."'";
					$fbo_res = mysql_query($fbo_query);
					$fbo_row = mysql_fetch_assoc($fbo_res);
					//print'<pre>';print_r($fbo_row);print'</pre>';
					?>
                    <p class="des_text"><span class="news_heading1">Solicitation Number : </span><?= $fbo_row['solnbr'];?> &nbsp;<span class="news_heading1">Notice Type : </span><?= $fbo_row['notice_type'];?></p>
                    <p class="des_text"><span class="news_heading1"><?= $lang['DESCRIPTION'] ?> : </span>&nbsp;&nbsp;<?= $d['description']; ?></p>
					
					<p class="des_text"><span class="news_heading1">
                    Contracting Office Address : </span><br />					
                    <?= $fbo_row['fbo_offadd'] ?>
                    </p>


					<p class="des_text"><span class="news_heading1">
                    Place of Performance : </span><br />					
                    <?= $fbo_row['agency'] ?><br />
                    <?= $fbo_row['office'] ?><br />
                    <?= $fbo_row['location'] ?>&nbsp;<?= $fbo_row['zipcode'] ?><br />
                    <?= $fbo_row['fbo_pop_country'] ?>
                    </p>

					<p class="des_text"><span class="news_heading1">
                    Primary Point of Contact.:</span><br />					
                    <?= html_entity_decode($fbo_row['fbo_contact']) ?>
                    </p>
                    
                    <?php if(isset($fbo_row['fbo_email_address']) && $fbo_row['fbo_email_address']<>'' ){?>
                    <p class="des_text"><span class="news_heading1">
                    Secondary Point of Contact : </span><br />					
                    <?= $fbo_row['fbo_email_desc'] ?>
                    <?= $fbo_row['fbo_email_address'] ?>
                    </p>
                    <?
					}
                    $otherdet = mysql_query("select info from " . $prev . "projects_additional where project_id='" . $_REQUEST[id] . "'");
                    $ui = 0;
                    $uia = 0;
                    while ($infp = @mysql_fetch_assoc($otherdet)) {
                        if ($infp[info] != '') {
                            $ui++;
                            echo " <p class='des_text'><span class='news_heading1'>Addition info " . $ui . "</span> : " . nl2br($infp[info]) . "</p>";
                        }
                    }
                    ?>



                    <span class="news_heading1"><?= $lang['SKILLS'] ?> : </span><?= $project_cats; ?>
            </tr>
        </table>

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
    $update_bid_user = @mysql_num_rows(mysql_query("select id from " . $prev . "buyer_bids where project_id='" . $_REQUEST[id] . "' and bidder_id='" . $_SESSION['user_id'] . "'"));
    ?>



    <table width="100%" align="left";>
        <tr>
            
<td><?php if ($_SESSION['user_id'] != $d['user_id'] && $update_bid_user == 0) { ?><a href="javascript:void(0)" class="ask" onclick="ask()"><img src="images/ques.jpg" width="30" height="30" alt="" style=" float:left;" />&nbsp;<?= $lang['ASK_A_QUESTION'] ?></a><? } ?></td>
			
            <td style="color:red">		<?php  if ($_SESSION['user_id'] != $d['user_id'] && $d['status'] == "open") { ?>
			
							<a  class="submit_bottnew" href="javascript:void(0)" onclick="bid()"><?
							if ($update_bid_user > 0) {
								echo $lang['Revise_Bid'];
							} else {
						?>
							
								<?= $lang['Place_Bid'] ?><? } ?></a>
							
						<? } elseif (($_SESSION['user_id'] == $d['user_id'] || $_SESSION['user_id'] == $d['chosen_id']) && $d['status'] == "process" && $d[project_type] == 'H') {
                        ?>
									<a  class="submit_bottnew" href="<?= $vpath ?>snap/<?= $d['id'] ?>">View Progress</a>
                        <?php
							} 
						?></td>
            <td></td>
        </tr>
    </table>


    <table width="98%" align="left" style=" margin-top:20px; font-size:13px;padding:5px;">

        <tr ><td colspan="2" style="background: #265384;
                 box-shadow: 0 0 10px #12263E inset;"><div  class="proposalcss" ><?= $lang['ATT_PROPOSAL'] ?></div></td></tr>
                 <?php
                 $j = 0;
                 $bees = mysql_query("SELECT * FROM  " . $prev . "buyer_bids WHERE project_id='" . $_REQUEST[id] . "' ORDER BY add_date ASC");
                 if (mysql_num_rows($bees) > 0) {
                     while ($row = mysql_fetch_array($bees)) {
                         $j++;
                         $provider = user_details($row[bidder_id]);
                         ?>
                <tr class="proposal">

                    <td width="15%" valign="top"><a href="<?= $vpath ?>publicprofile/<?= $provider['username'] ?>/" > <img src="<?= $vpath ?>viewimage.php?img=<?php echo $provider['logo']; ?>&width=70&height=70" style=" border:1px solid #666;" /></a>
                    </td>
                    <td width="85%" valign="top"><table width="100%">
                            <tr>
                                <td><a href="<?= $vpath ?>publicprofile/<?= $provider['username'] ?>/" ><h2 class="new" style=" margin:0; padding:0;"><?= getfullname($row[bidder_id]); ?>&nbsp;<? if ($row[bidder_id] == $d['chosen_id'] && $d['status'] != "frozen") { ?><img src="<?= $vpath ?>images/<?= $ln ?>/awarded_ic.jpg" alt="awarded" title="award" height=20><? } ?>
                                        </h2></a>
                                    <div style="position: relative;width: 200px;float: right;margin-top: -25px;text-align: right;">

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
                                    <p style="padding:0; margin:0;"><span><?php print $country_array[$provider[country]]; ?>&nbsp;<img src="<?= $vpath ?>cuntry_flag/<?= strtolower($provider[country]); ?>.png" title="<?= $country_array[$provider[country]]; ?>" width="16" height="11" ></span></p>
                                </td>
                            </tr>
                            <tr>
                                <td  class="newclass2">
                                            <!--<p style="padding:0; margin:0;"><span ><?= $lang['TOTAL_PROJECT_AMOUNT'] ?>: </span><b><?= $curn ?> <?= $row['emp_charge'] ?> </b></p>
                                    <p style="padding:0; margin:0; "><span ><?= $lang['DURATION'] ?>: </span><b><?= $row['duration'] ?> <?= $lang['day'] ?><? if ($row['duration'] > 1) { ?>s<? } ?></b></p>-->
                                    <p style="padding:0; margin:0; "><?= $row['cover_letter']; ?></p>

                                    <p style="padding:0; margin:0; "><span ><?= $lang['SKILLS'] ?> : </span><?= getuserskills($row[bidder_id], "/", "skilslinks2", "a") ?></p>

                                    <p style="padding:0; margin:0; "><?= getreviewcount($row[bidder_id]) ?> <?= getrating($row[bidder_id]) ?> | <?= $lang['j_ob'] ?> : <b>&nbsp;&nbsp;<?= getworkedprojectcountforuser($row[bidder_id]) ?></b></p>
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
                <tr><td colspan=2 style="border-bottom: 1px solid #265384;"></td></tr>
                <?php
            }
        } else {
            echo ' <tr><td colspan=2 style="border-bottom: 1px solid #265384;" align=center height="50">' . $lang['NO_PROPOSAL_FOUND'] . '</td></tr>';
        }
        ?> 


    </table>








</div>
<style>
    .stButton .st-pinterest-counter, .stButton .st-email-counter,.stButton .st-twitter-counter, .stButton .st-facebook-counter,.stButton .st-twitter-counter, .stButton .st-facebook-counter,.stButton .st-yahoo-counter, .stButton .st-linkedin-counter{
        width: 50px !important;
        background-size: contain;
    }
</style>


<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "65c97021-d2c7-44ae-9f77-4aeb88e213c9", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</div>
<?php include 'includes/footer.php'; ?>