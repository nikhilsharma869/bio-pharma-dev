<?php
$current_page = "Profile details";
include "includes/header.php";
include("country.php");
$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user, " . $prev . "user_profile where " . $prev . "user_profile.user_id=" . $prev . "user.user_id and " . $prev . "user.username = '" . $_GET[username] . "'"));
if (!empty($row_user[logo])) {
    $temp_logo = $row_user[logo];
} else {
    $temp_logo = "images/face_icon.gif";
}

?>


<div class="user-profile-area">
    <div class="user-profile-banner">
        <img src="<?= $vpath ?>/images/profile_banner.jpg">
    </div>
    <div class="user-profile-container">
        <div class="user-profile-header">
            <div class="up-avatar">
                <img src="<?= $vpath ?>viewimage.php?img=<?php echo $temp_logo; ?>&width=200&height=200" alt="" />
            </div>
            <div class="up-infors">
                <h1 class="up-name"><?= ucwords($row_user['fname']) . '&nbsp;' . ucwords($row_user['lname']); ?></h1>
                <p class="up-slogan"><?= ucfirst($row_user[slogan]) ?></p>
                <div class="the-gru-of">
                    <h4>The guru of</h4>
                    <?php 
                        $skill_q = "select skills from " . $prev . "user_profile where user_id=" . $row_user[user_id];

                        $res_skill = mysql_query($skill_q);
                        $data_skills = @mysql_result($res_skill,0,"skills");
                        $data_skills = explode(',', $data_skills);
                        $count = 1;
                        foreach ($data_skills as $skill) {
                            if($count > 5 ) break;
                            $data_skill_name.= "<span><a href='javascript:;'>". $skill . '</a></span>';
                            $count++;
                        }
                       
                        $skill_name = $data_skill_name;
                        echo $skill_name;
                    ?>
                </div>
            </div>            
        </div>
        <div class="clear-fix"></div>
        <div class="user-profile-sidebar">
            <?php if(!empty($_SESSION['user_id'])) { ?>
                <?php if($_SESSION['user_type'] == 'E' && $_SESSION['user_id'] != $row_user['user_id']) { ?>
                <a class="up-contact" href="javascript:;" onclick="getinvite()">Invite</a>
                <?php } else { ?>
                <a class="up-contact" href="javascript:;">Contact</a>
                <?php } ?>
            <?php } ?>
            
            <ul id="up-tabs" class="nav nav-tabs" role="tablist">
              <li class="active"><a class="up-icon-overview" href="#up-overview">Overview</a></li>
              <?php if(!empty($_SESSION['user_id'])) { ?>
              <li><a class="up-icon-portfolio" href="#up-portfolio">Portfolio</a></li>
              <li><a class="up-icon-feedback" href="#up-feedback">Feedback</a></li>
              <?php } ?>
              <li><a class="up-icon-skills" href="#up-overview">Skills</a></li>
            </ul>
            <?php if(!empty($_SESSION['user_id'])) { ?>
            <div class="boxright" id="invidebox">
                <h2><?= $lang['INVT_PROV'] ?></h2>
                <div id="addinvite" align="center"></div>

                <?php
                $proj_sql_num = @mysql_num_rows(mysql_query("select id from " . $prev . "projects where user_id='" . $_SESSION[user_id] . "' and status='open'"));
                if ($proj_sql_num > 0) {
                    ?>
                    <div class="invitebox_section">
                        <span><?= $lang['SELECT_PROJECT'] ?>:</span>
                    </div>
                    <div class="invitebox_section">
                        <select name="proj" class="from_input_box" style="width:200px" id="project_id_val">
                            <?php
                            $proj_sql = @mysql_query("select * from " . $prev . "projects where user_id='" . $_SESSION[user_id] . "' and status='open'");
                            while ($proj_fetch = @mysql_fetch_array($proj_sql)) {
                                ?>
                                <option value="<?= $proj_fetch['id'] ?>"><?= $proj_fetch['project'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="invitebox_section">
                        <input type="hidden" id="txtemail" name="txtemail" size="52"  value="<? print $row_user[email]; ?>">
                        <input type="hidden" id="f_name" name="f_name" size="52"  value="<? print $row_user[fname]; ?>">
                        <input type="hidden" id="l_name" name="l_name" size="52"  value="<? print $row_user[lname]; ?>">
                        <input type='button' border="0" class="submit_bott" value="<?= $lang['SEND'] ?>"  name="send_submit" onclick="invideuser();">
                    </div>
                    <div style="padding-left:10px;margin: 10px 0px;">
                        <div id="addinvite_post" align="center">
                            <a href="javascript:void(0)" onclick="postprojectinvite()">
                                <input type="button" name="Button" value="Post a New Project"  class="submit_bott"/>
                            </a>
                        </div>            
                    </div>
                <?php } else { ?>
                    <p style="margin-left: 20px;">You don't have any project to invite</p>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <div class="user-profile-data-area">
            <h2>Profile</h2>
            <div id="up-content" class="tab-content">
                <?php if(!empty($_SESSION['user_id'])) { ?>
                <div class="up-content-section tab-pane" id="up-portfolio">
                    <div class="upps">
                        <h3>Portfolios</h3> 
                        <?php if($_SESSION['user_id'] == $row_user['user_id']) { ?>
                            <div class="upload_bott"><a href="<?= $vpath ?>upload-portfolio.html">+&nbsp;<?= $lang['UPLOAD_NEW'] ?></a></div>                   
                        <?php } ?>
                    </div>
                    <ul id="slider">

                        <?php
                        $rr = mysql_query("select *  from " . $prev . "portfolio where user_id=" . $row_user['user_id'] . " and `status`='Y' order by id desc limit 20");
                        $pro = mysql_num_rows($rr);
                        if ($pro == "") {
                            echo '<div style="width:736px;padding:5px;float:left;"  align="center">';
                            echo $lang['PORTF_NOT_UPD'];
                            echo '</div>';
                        } else {
                            $j = 0;
                            while ($f = mysql_fetch_array($rr)) {
                                $j++;
                                $date_up = explode('-', $f[add_date]);
                                $date = $date_up[2] . '-' . $date_up[1] . '-' . $date_up[0];
                                ?>  

                                <li>
                                    <div class="prosl1"><img src="<?= $vpath ?>viewimage.php?img=<?= $f[image]; ?>&width=287&height=240" alt="" style="width: 295px;height: 242px;" /></div>
                                    <div class="slidetxt">
                                        <h2><?= substr($f[project_title], 0, 20); ?></h2>
                                        <p style="font-size:12px;"><?= substr(nl2br($f[description]), 0, 200); ?></p>
                                        <a href="http://<?= str_replace("http://", "", str_replace("https://", "", $f[link])) ?>" target="_blank"><?= $f[link] ?></a>
                                        <?php if($f[attachment]): 
                                            $attachment_link = $vpath.$f[attachment];
                                        ?>
                                            <a class="portfolio_attm" href="http://<?= str_replace("http://", "", str_replace("https://", "", $attachment_link)) ?>" target="_blank">Attachment</a>
                                        <?php endif; ?>
                                        <?php if($_SESSION['user_id'] == $row_user['user_id']) { ?>
                                            <a class="portfolio_edit_btn" href="<?= $vpath ?>edit-portfolio/1/<?= $f['id'] ?>/"><span>Edit</span></a>
                                        <?php } ?>
                                    </div>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="up-content-section tab-pane" id="up-feedback">
                    <h3>Feedback</h3>
                    <?php include("includes/puplic_review.php"); ?>
                </div>
                <?php } ?>
                <div class="tab-pane active" id="up-overview">
                    <div class="up-content-section up-summary">
                        <h3>Summary</h3>
                        <p><?= $row_user['profile'] ?></p>
                    </div>
                    <div class="up-content-section up-experience">
                        <h3>Experience</h3>
                        <?php
                            $data_exps = $row_user['experience'];
                            $data_exps = json_decode($data_exps);
                            // echo "<pre>";
                            // var_dump($data_exps);
                            for($i=0;$i<count($data_exps->values);$i++) {
                                ?>
                                <div class="up-content-view">
                                    <h4><?php echo $data_exps->values[$i]->title; ?></h4>
                                    <h5><?php echo $data_exps->values[$i]->company->name; ?></h5>                                   
                                    <span>
                                        <?php                                            
                                            $begin = array ('year' => $data_exps->values[$i]->startDate->year, 'month' => $data_exps->values[$i]->startDate->month, 'day' => 1);                                            
                                            if($data_exps->values[$i]->isCurrent) {
                                                $end = array ('year' => date('Y'), 'month' => date('m'), 'day' => 1);    
                                            } else {
                                                $end = array ('year' => $data_exps->values[$i]->endDate->year, 'month' => $data_exps->values[$i]->endDate->month, 'day' => 1);                                            
                                            }
                                             
                                            $date_diff = date_difference ($begin, $end);
                                            echo date("F Y", mktime(0, 0, 0, $data_exps->values[$i]->startDate->month, 1 , $data_exps->values[$i]->startDate->year)); ?> 
                                            -
                                            <?php if($data_exps->values[$i]->isCurrent) {
                                                echo "Present";
                                            } else {
                                                echo date("F Y", mktime(0, 0, 0, $data_exps->values[$i]->endDate->month, 1 , $data_exps->values[$i]->endDate->year)); 
                                            } ?>
                                            &nbsp;
                                            <?php
                                            // var_dump($date_diff);
                                            if($date_diff['years'] == 1) {
                                                echo '(' . $date_diff['years'] . ' year ';
                                            } else if($date_diff['years'] > 1) {
                                                echo '(' . $date_diff['years'] . ' years ';
                                            } else if($date_diff['years'] == 0) {
                                                echo '(';
                                            } 
                                            if($date_diff['months'] == 0) {
                                                echo '' . $date_diff['months']+1 . ' month)';
                                            } else if($date_diff['months'] > 0) {
                                                echo '' . $date_diff['months']+1 . ' months)';
                                            }
                                        ?>                                            
                                    </span>                                    
                                    <?php if(isset($data_exps->values[$i]->summary)) { ?>
                                        <p>
                                        <?php echo $data_exps->values[$i]->summary; ?>
                                        </p>
                                    <?php } ?>                                    
                                </div>
                                <?php                        
                            }
                        ?>
                    </div>
                    <div class="up-content-section up-skills-endor">
                        <h3>Skills and Endorsements</h3>

                        <div id="profile-skills">
                            <h5>Top Skills</h5>

                            <ul class="skills-section">
                                <?php
                                    $skills_linkedin = get_list_skill_linkedin();
                                    
                                    foreach ($skills_linkedin['top_skill_skill'] as $sval) :
                                        if (check_user_skill($sval['skill_name'], $row_user['user_id'])) :                                           
                                        
                                    ?>
                                        <li class="endorse-item">
                                            <span class="skill-pill">
                                                <a class="endorse-count" href="javascript:void(0)">
                                                    <span class="num-endorsements" data-count="1"><?php echo (int)$sval['skill_count'] - 1; ?></span>
                                                </a>
                                                <span class="endorse-item-name">
                                                    <a href="#" class="endorse-item-name-text"><?php echo $sval['skill_name']; ?></a>
                                                </span>
                                            </span>
                                            <div class="endorsers-container">
                                                <ul class="endorsers-pics">
                                                    <?php 
                                                        $luser = get_list_user_by_skl($sval['skill_name'], $row_user['user_id']);
                                                        foreach ($luser as $user_data) :                                                            
                                                    ?>
                                                        <li class="viewer-pic-container">
                                                            <span class="new-miniprofile-container">
                                                                <strong>
                                                                    <img class="viewer-pic" src="<?= $vpath ?>viewimage.php?img=<?php echo $user_data['logo']; ?>&width=30&height=30" alt="" />
                                                                </strong>
                                                            </span>
                                                        </li>
                                                    
                                                    <?php endforeach; ?>    

                                                    <li class="endorsers-action">
                                                        <a class="see-all-endorsers" href="javascript:void(0)">
                                                            <span class="loader"></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <span class="line-container"><span class="hr-line"></span></span>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                    <?php endforeach; ?>    
                            </ul>

                            <h5><?php echo $row_user['fname']; ?> also knows about...</h5>
                            <ul class="skills-section compact-view">
                                <?php foreach ($skills_linkedin['one_know_skill'] as $sval) :
                                        if (check_user_skill($sval['skill_name'], $row_user['user_id'])) :
                                    ?>
                                        <li class="endorse-item">
                                            <div>
                                                <span class="skill-pill">                                           
                                                    <span class="endorse-item-name ">
                                                        <a href="#" class="endorse-item-name-text"><?php echo $sval['skill_name']; ?></a>
                                                    </span>
                                                </span>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>                        
                    </div>

                    <div class="up-content-section up-education">
                        <h3>Education</h3>
                        <?php
                            $data_edus = $row_user['educations'];
                            $data_edus = json_decode($data_edus);
                            for($i=0;$i<count($data_edus->values);$i++) {
                                ?>
                                <div class="up-content-view">
                                    <h4><?php echo $data_edus->values[$i]->schoolName; ?></h4>
                                    <h5><?php echo $data_edus->values[$i]->degree; ?></h5>                                   
                                    <span>
                                        <?php                                            
                                            $begin = array ('year' => $data_edus->values[$i]->startDate->year, 'month' => $data_edus->values[$i]->startDate->month, 'day' => 1);                                            
                                            if($data_edus->values[$i]->isCurrent) {
                                                $end = array ('year' => date('Y'), 'month' => date('m'), 'day' => 1);    
                                            } else {
                                                $end = array ('year' => $data_edus->values[$i]->endDate->year, 'month' => $data_edus->values[$i]->endDate->month, 'day' => 1);                                            
                                            }
                                             
                                            $date_diff = date_difference ($begin, $end);
                                            echo date("F Y", mktime(0, 0, 0, $data_edus->values[$i]->startDate->month, 1 , $data_edus->values[$i]->startDate->year)); ?> 
                                            -
                                            <?php if($data_edus->values[$i]->isCurrent) {
                                                echo "Present";
                                            } else {
                                                echo date("F Y", mktime(0, 0, 0, $data_edus->values[$i]->endDate->month, 1 , $data_edus->values[$i]->endDate->year)); 
                                            } ?>
                                            &nbsp;
                                            <?php
                                            // var_dump($date_diff);
                                            if($date_diff['years'] == 1) {
                                                echo '(' . $date_diff['years'] . ' year ';
                                            } else if($date_diff['years'] > 1) {
                                                echo '(' . $date_diff['years'] . ' years ';
                                            } else if($date_diff['years'] == 0) {
                                                echo '(';
                                            } 
                                            if($date_diff['months'] == 0) {
                                                echo '' . $date_diff['months']+1 . ' month)';
                                            } else if($date_diff['months'] > 0) {
                                                echo '' . $date_diff['months']+1 . ' months)';
                                            }
                                        ?>                                            
                                    </span>                                    
                                </div>
                                <?php                        
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#up-tabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
        if($(this).hasClass('up-icon-skills')) {
            $('body').animate({
                scrollTop: $(".up-skills-endor").offset().top
            },'slow');
        }
    })
    $(function() {
        $('#slider').anythingSlider({
            hashTags: false
        });
    });

    function getinvite() {
        $("#invidebox").slideDown('slow');
    }

    function postprojectinvite() {
        var txtemail = $("#txtemail").val();
        var info = "txtemail=" + txtemail + "&inviteuser=inviteuser";
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>addtoinvite_post.php",
            data: info,
            beforeSend: function() {
                $('#addinvite_post').html('<img src="<?= $vpath ?>images/login_loader2.GIF" height=22 width=22  />');
            },
            success: function(dd) {

                $("#addinvite_post").html(dd);

            }
        });
    }
</script>

<?php include 'includes/footer.php'; ?>
