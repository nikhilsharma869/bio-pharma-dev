<?php
$current_page = "Project Description";

include "includes/header.php";

include("country.php");

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

function getName($uid) {
    global $prev;
    $r = mysql_fetch_assoc(mysql_query("select fname,lname from " . $prev . "user where user_id='" . $uid . "'"));
    return (ucfirst($r['fname']) . " " . ucfirst($r['lname']));
}

function getTotalHR($d) {
    global $prev;
    $r = mysql_query("SELECT time_to_sec(TIMEDIFF(`stop_time`,`start_time`)) as wt FROM " . $prev . "project_tracker WHERE `note`='' and `stop_time`<>'0000-00-00 00:00:00' and start_time >= '" . ($d . " 00:00:00") . "' and `stop_time`<='" . ($d . " 23:59:59") . "' AND project_id=" . $_GET[id]);
    $time = 0;
    while ($t = mysql_fetch_assoc($r)) {
        $time = $time + $t['wt'];
    }
    return $time;
}

function getTotalAMT($ts, $bid_amt) {
    return round((($bid_amt * $ts) / 3600), 2);
}

function getSubTotalHR($p) {
    global $prev;

// echo "SELECT time_to_sec(TIMEDIFF(`stop_time`,`start_time`)) as wt FROM ".$prev."project_tracker WHERE `note`='' and `stop_time`<>'0000-00-00 00:00:00' and project_id='".$p."'";

    $r = mysql_query("SELECT time_to_sec(TIMEDIFF(`stop_time`,`start_time`)) as wt FROM " . $prev . "project_tracker WHERE `note`='' and `stop_time`<>'0000-00-00 00:00:00' and project_id='" . $p . "'");
    $time = 0;
    while ($t = mysql_fetch_assoc($r)) {
        $time = $time + $t['wt'];
    }
    return $time;
}

function getPayAmount($bid) {
    global $prev;
    $r = mysql_fetch_assoc(mysql_query("select sum(amount) as tm from " . $prev . "escrow where bidid='" . $bid . "' and status='Y'"));
    if ($r['tm'] == "") {
        return 0;
    } else {
        return $r['tm'];
    }
}
?>

<link rel="stylesheet" type="text/css" href="<?= $vpath ?>highslide/highslide.css" /><script type="text/javascript" src="<?= $vpath ?>highslide/highslide-with-html.js"></script>
<script src="<?= $vpath ?>js/jquery-1.4.3.min.js"></script> 
<script type="text/javascript" src="<?= $vpath ?>fancybox/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $vpath ?>fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script>
    $(document).ready(function() {
        $(".fancyclass").fancybox();
    });

</script>
<script>
    function showDetails(v) {
        var vx = parseInt($("#hidx").val());
        var dataString = 'dt=' + v + '&bamt=' + $("#bidamt_" + v).val() + '&pid=<?php echo $_REQUEST['id']; ?>' + '&count=' + vx;
        //alert(dataString);
        $.ajax({
            type: "POST",
            data: dataString,
            url: "<?= $vpath ?>snap_ajax.php",
            success: function(return_data) {
                $("#" + v).html(return_data);
                $("#" + v).slideDown();
                $("#sw" + v).hide();
                $("#hd" + v).show();
                var x = parseInt(vx) + 1;
                $("#hidx").val(x);
                $('#spn' + v).hide();
            },
            beforeSend: function() {
                $('#spn' + v).show()
            },
            complete: function() {
                $('#spn' + v).hide();
            }

        });


    }
    function hideDetails(v) {

        $("#" + v).slideUp();
        $("#" + v).empty();
        $("#sw" + v).show();
        $("#hd" + v).hide();
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

                $skill_q = "select c.parent_id,c.cat_id,c.cat_name from " . $prev . "categories c inner join " . $prev . "user_cats u on c.cat_id=u.cat_id where user_id=" . $_SESSION[user_id];

                $res_skill = mysql_query($skill_q);
                $apply_project_skl = @mysql_num_rows($res_skill);
                if ($_SESSION['user_id'] == $d['user_id']) {
                    echo "<div style='color:red;padding-top:30px'>You can't bid of your own project.</div>";
                } else if ($apply_project_skl == '0') {
                    include("includes/bid_panel1.php");
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
        <div class="clr"></div>
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
                    <td class="td_bd"><p class="opt_text1"><?= avaragebid($d['id']) ?></p><p class="ago_text"><?= $lang['AVG_BIDS'] ?></p></td>
                    <td class="td_bd"><p class="opt_text1"><? if ($d['project_type'] == "F") { ?><?= $budget_array2[$d['budget_id']] ?><? } else { ?><?= $curn . $d['budgetmin'] . " to " . $curn . $d['budgetmax'] ?><? } ?></p><p class="ago_text"><?= $lang['BUDGETT'] ?></p></td>
                    <td class="td_bd"><p class="opt_text1"> <? if (getprojecttype($d['id']) == "F") { ?><img src="<?= $vpath ?>images/fixed.png" alt="<?= $lang['FIXED'] ?>" title="<?= $lang['FIXED'] ?>" /><? } else { ?><img src="<?= $vpath ?>images/hourly.png" alt="<?= $lang['HOURLY'] ?>" title="<?= $lang['HOURLY'] ?>" /><? } ?></p></td>
                </tr>
            </table>
            <p class="rbn1"><?= getfeatureicon($d['id'], '2') ?></p>
        </div>



        <table width="100%%" style=" font-size:13px; margin-bottom:20px; border-bottom:1px dotted #D9D5D6;">

            <tr>
                <td colspan="2">




                    <p class="des_text"><span class="news_heading1"><?= $lang['DESCRIPTION'] ?> : </span>&nbsp;&nbsp;<?= $d['description']; ?></p>

                    <?
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
                </div>
                <div class="clr"></div>
            </div>
            <?
        }
    }
    $update_bid_user = mysql_query("select * from " . $prev . "buyer_bids where project_id='" . $_REQUEST[id] . "' and chose='Y'");
    $biddetails = mysql_fetch_assoc($update_bid_user);
    ?>

    <!--snap list listing start-->

    <table width="98%" align="left" style=" margin-top:20px; font-size:13px;padding:5px;">
        <tr ><td colspan="4" style="background: #265384;box-shadow: 0 0 10px #12263E inset;">
                <div  class="proposalcss" >Work Details</div>
                <div  class="proposalcss" style="float: right;font-size: 13px;">Rate &dollar;<?php echo $biddetails['bid_amount']; ?>/Hr</div>
            </td></tr>
        <tr>
            <th style="background:#F5F4F6;border-radius:5px;height:30px;"> 
                <input type="hidden" name="hidx" id="hidx" value="1">
                Date</th>
            <th style="background:#F5F4F6;border-radius:5px;height:30px;"> 
                Work Time</th>
            <th style="background:#F5F4F6;border-radius:5px;height:30px;"> 
                Amount</th>
            <th style="background:#F5F4F6;border-radius:5px;height:30px;"> 
                Action</th>
        </tr>
        <?php

        $snapqrry = mysql_query("select distinct(DATE_FORMAT(`project_work_snap_time`,'%Y-%m-%d')) as workday,project_tracker_id from  " . $prev . "project_tracker_snap where project_tracker_id in (select id from  " . $prev . "project_tracker where project_id='" . $_REQUEST['id'] . "' order by date(start_time) asc)  order by date(project_work_snap_time) asc");
        if (mysql_num_rows($snapqrry) > 0) {
            while ($snaprow = mysql_fetch_assoc($snapqrry)) {
                ?>
                <tr>
                <input id="bidamt_<?php echo date("d_m_Y", strtotime($snaprow['workday'])); ?>" value="<?php echo $biddetails['bid_amount']; ?>" type="hidden" />
                <td class="p_d_teaxt"  height="28" width="24%" align="center" ><?php echo date("d M, Y", strtotime($snaprow['workday'])); ?></td>
                <td class="p_d_teaxt"  height="28" width="24%" align="center" ><?php echo gmdate("H:i:s", getTotalHR($snaprow['workday'])); ?></td>
                <td class="p_d_teaxt"  height="28" width="24%" align="center" >&#36; <?php echo getTotalAMT(getTotalHR($snaprow['workday']), $biddetails['bid_amount']) ?></td>
                <td class="p_d_teaxt"  height="28" width="24%" align="center" >
<?php 

$av=@mysql_num_rows(mysql_query("select id from ".$prev."project_tracker where id='".$snaprow['project_tracker_id']."' and time_added_by='M'"));
if($av>0){
echo "Manual Time";
}else{

?>
                    <span id="<?php echo "sw" . date("d_m_Y", strtotime($snaprow['workday'])); ?>">
                        <a href="javascript:void(0)" style="text-decoration:none; font-weight:bold;color: #FB773D;" onClick="showDetails('<?php echo date("d_m_Y", strtotime($snaprow['workday'])); ?>')">View Progress</a>
                    </span>
                    &nbsp;
                    <span id="<?php echo "hd" . date("d_m_Y", strtotime($snaprow['workday'])); ?>" style="display:none">
                        <a href="javascript:void(0)" style="text-decoration:none; font-weight:bold;color: #FB773D;" onClick="hideDetails('<?php echo date("d_m_Y", strtotime($snaprow['workday'])); ?>')">Hide Details</a>
                    </span>

                    <div class="spinner" id="spn<?= date("d_m_Y", strtotime($snaprow['workday'])) ?>" style="display:none">
                        <center>
                            <img class="loading-image" src="<?= $vpath ?>images/ajax-loader.gif" alt="loading..">
                        </center>
                    </div>
<?php }?>
                </td>
                </tr>
                <tr> 
                    <td colspan="4" id="<?php echo date("d_m_Y", strtotime($snaprow['workday'])); ?>"></td>
                </tr>
                <?php
            }
            $res4 = mysql_fetch_array(mysql_query("select sum(amount) as escrsum from " . $prev . "escrow where bidid = '" . $biddetails['id'] . "' and status!='C'"));
            $tamt = $biddetails['bid_amount'];
            $payamt = getPayAmount($biddetails['id']);
            $damt = floatval(getTotalAMT(getSubTotalHR($_REQUEST['id']), $biddetails['bid_amount']));
            $ramt = floatval($damt) - floatval($res4['escrsum']);
            ?>
            <tr>
                <th style="background: #265384;color: #fff;padding: 5px">Total Time: <?php echo gmdate("H:i:s", getSubTotalHR($_REQUEST['id'])); ?></th>
                <th style="background: #265384;color: #fff;padding: 5px">Total Cost: &dollar;<?php echo getTotalAMT(getSubTotalHR($_REQUEST['id']), $biddetails['bid_amount']); ?></th>
                <th style="background: #265384;color: #fff;padding: 5px">Paid: &dollar;<?php echo $res4['escrsum']; ?></th>
                <th style="background: #265384;color: #fff;padding: 5px">Remain: &dollar;<?php echo $ramt; ?></th>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="4" align="center">No record found</td>
            </tr>
            <?php
        }
        ?>
    </table>

    <!-- snap list listing end-->


    <div class="clr"></div>

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
<div class="clr"></div>
</div>
<?php include 'includes/footer.php'; ?>