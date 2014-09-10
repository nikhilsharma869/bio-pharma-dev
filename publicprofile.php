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
                    <span>com</span>
                    <span>drupal</span>
                    <span>joomla</span>
                    <span>http</span>
                    <span>mysql</span>
                    <span>opencart</span>
                    <span>php</span>
                    <span>wordpress</span>
                </div>
            </div>            
        </div>
        <div class="clear-fix"></div>
        <div class="user-profile-sidebar">
            <a class="up-contact" href="javascript:;">Contact</a>
            <ul id="up-tabs" class="nav nav-tabs" role="tablist">
              <li class="active"><a class="up-icon-overview" href="#up-overview">Overview</a></li>
              <li><a class="up-icon-portfolio" href="#up-portfolio">Portfolio</a></li>
              <li><a class="up-icon-feedback" href="#up-feedback">Feedback</a></li>
              <li><a class="up-icon-skills" href="#up-overview">Skills</a></li>
            </ul>
        </div>
        <div class="user-profile-data-area">
            <h2>Profile</h2>
            <div id="up-content" class="tab-content">
                <div class="up-content-section tab-pane" id="up-portfolio">
                    <h3>Portfolios</h3>
                </div>
                <div class="up-content-section tab-pane" id="up-feedback">
                    <h3>Feedback</h3>
                </div>
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
</script>

<?php include 'includes/footer.php'; ?>
