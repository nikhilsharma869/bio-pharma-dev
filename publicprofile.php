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
        <!-- <img src="<?= $vpath ?>/images/profile_banner.jpg"> -->
        <?php if(empty($row_user['banner'])) { ?>
            <img src="http://placehold.it/1260x320"> 
        <?php } else { ?>
            <img src="<?= $vpath ?>viewimage.php?img=<?php echo $row_user['banner']; ?>&width=1260&height=320">
            <!-- <img src="<?= $vpath.$row_user['banner'] ?>"> -->
        <?php } ?>
        <?php if(!empty($_SESSION['user_id']) && $_SESSION['user_id'] == $row_user['user_id']) { ?>
        <div class="up-banner-manage">
            <a href="#" class="up-banner-edit" data-toggle="modal" data-target="#md-edit-banner"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a>            
        </div>
        <?php } ?>
    </div>
    <div class="user-profile-container">
        <div class="user-profile-header">
            <div class="up-avatar">
                <img src="<?= $vpath ?>viewimage.php?img=<?php echo $temp_logo; ?>&width=200&height=200" alt="" />
            </div>
            <div class="up-infors">
                <h1 class="up-name"><?= ucwords($row_user['fname']) . '&nbsp;' . ucwords($row_user['lname']); ?></h1>
                <p class="up-slogan"><?= ucfirst($row_user[slogan]) ?></p>                
            </div>            
        </div>
        <div class="clear-fix"></div>
        <div class="user-profile-sidebar">
            <?php if(!empty($_SESSION['user_id'])) { ?>
                <?php if($_SESSION['user_type'] == 'E' && $_SESSION['user_id'] != $row_user['user_id']) { ?>
					<div class="dropdown pb-drd">
                      <a id="dLabel" class="mt-action-profile" data-toggle="dropdown" data-target="#" href="/page.html">
                        Action
                      </a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li><a href="javascript:;" onclick="getinvite()">Invite</a></li>
                      </ul>
                    </div>
					<?php
						$n = mysql_num_rows(mysql_query("select *  from " . $prev . "wishlist where user_id='" . $_SESSION['user_id'] . "' and uid='" . $row_user['user_id'] . "'"));
					?>
					<a href="javascript:void(0);" onclick="addwistlist('<?= $row_user['user_id'] ?>');"  style="cursor:pointer"><span id="addlist">

							<?php if ($n == 0) { ?>
								<img src='<?= $vpath ?>images/unfill.png' border=0 align=absmiddle alt='add to wishlist' title='add to wishlist'>
							<?php } else { ?>
								<img src='<?= $vpath ?>images/fill.png' border=0 align=absmiddle alt='added to wishlist' title='added to wishlist'>
							<?php } ?>

						</span>
					</a>

                <?php } else { ?>
					<a class="up-contact" href="javascript:;">Contact</a>
                <?php } ?>
            <?php } ?>
            
            <ul id="up-tabs" class="nav nav-tabs" role="tablist" style="margin-top: 30px;">
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
                        <input type="hidden" id="f_name" name="f_name" size="52"  value="<? print $row_user[fname]; ?>">
                        <input type="hidden" id="l_name" name="l_name" size="52"  value="<? print $row_user[lname]; ?>">
                        <input type='button' border="0" class="submit_bott" value="<?= $lang['SEND'] ?>"  name="send_submit" onclick="invideuser();">
                    </div>
                   
                <?php } else { ?>                    
                     <div style="margin: 10px auto;">
                        <div id="addinvite_post" align="center">
                            <a href="javascript:void(0)" onclick="postprojectinvite()">
                                <input type="button" name="Button" value="Post a New Project"  class="submit_bott"/>
                            </a>
                        </div>            
                    </div>
                <?php } ?>
                    <input type="hidden" id="txtemail" name="txtemail" size="52"  value="<? print $row_user[email]; ?>">
            </div>
            <?php } ?>
        </div>
        <div class="user-profile-data-area">
            <div class="the-gru-of">
                <h4>The Subject Matter Expert of</h4>
                <?php 
                    $skill_q = "select skills from " . $prev . "user_profile where user_id=" . $row_user[user_id];

                    $res_skill = mysql_query($skill_q);
                    $data_skills = @mysql_result($res_skill,0,"skills");
                    $data_skills = explode(',', $data_skills);
                    $count = 1;
                    foreach ($data_skills as $skill) {
                        if($count > 4 ) break;
                        $data_skill_name.= "<span><a href='javascript:;'>". $skill . '</a></span>';
                        $count++;
                    }
                   
                    $skill_name = $data_skill_name;
                    echo $skill_name;
                ?>
            </div>
            <div id="up-content" class="tab-content">
                <?php if(!empty($_SESSION['user_id'])) { ?>
                <div class="up-content-section tab-pane" id="up-portfolio">
                    <div class="upps">
                        <h3>Portfolios</h3> 
                        <?php if($_SESSION['user_id'] == $row_user['user_id']) { ?>
                            <div class="upload_bott"><a href="#" data-toggle="modal" data-target="#md-upload-folio">+&nbsp;<?= $lang['UPLOAD_NEW'] ?></a></div>                   
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

<!-- Upload Banner Modal -->
<div class="modal fade" id="md-edit-banner" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Banner Manager</h4>
      </div>
      <div class="modal-body">        
        <form role="form" name="upb-upload" id="upb-upload" method="post" enctype="multipart/form-data" action="<?=$vpath;?>bannerupload.php"> 
            <div class="alert alert-success hide" role="alert"></div>
            <div class="alert alert-warning hide" role="alert"></div>
            <div class="form-group">
                <label for="upb-upload-file">Upload Banner (1260x320)</label>
                <input type="file" name="upb_upload_file" id="upb-upload-file">            
            </div>
            <input type="hidden" name="upb_upload_userid" value="<?=$row_user['user_id']?>"> 
        </form>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary upb-btn-submit">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Upload Portfolio -->
<div class="modal fade" id="md-upload-folio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="">Upload Folio</h4>
      </div>
      <div class="modal-body">        
        <form action="<?= $vpath ?>upload-portfolio.html" method="post" enctype="multipart/form-data" name="exp_form" id="exp_form" onsubmit="return ValidateAndSubmit();">
            <div class="alert alert-success hide" role="alert"></div>
            <div class="alert alert-warning hide" role="alert"></div>
            <table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                    <td align="center" valign="top" class="bx-border">
                        <table width="100%" border="0" cellpadding="4" cellspacing="0" align="center" >

                            <tr class='link'>
                                <td ><?= $lang['PROJECT_TITLE'] ?> : *</td>
                                <td><input type="text" name="project_title" id="project_title" style='width:300px' value="" size="100" class="from_input_box" /></td>
                            </tr>
                            <tr class='link'>
                                <td ><?= $lang['DESCRIBING_SHORT'] ?> : *</td>
                                <td><textarea name="description" id="description" rows="5" cols="10" class="text_box"></textarea>
                                    <br />
                                    <div style="
                                         float: left;
                                         width: 200px;
                                         "> <small><?= $lang['NOT_MORE_THAN'] ?></small></div></td>
                            </tr>
                            <tr class='link'>
                                <td >Tags: </td>
                                <td><input type="text" name="tags" style='width:300px' value="" size="100" class="from_input_box" /></td>
                            </tr>
                            <tr class='link'>
                                <td >Link: </td>
                                <td><input type="text" name="link" style='width:300px' value="" size="100" class="from_input_box" /></td>
                            </tr>
                            <tr class='link'>
                                <td ><?= $lang['PICTURES_EXAMPLES'] ?> : </td>
                                <td><input type="file" name="thumb"  size="30" class="from_input_box" />
                                </td>
                            </tr>

                            <tr class='link'>
                                <td ><?= $lang['PORTFOLIO_ATTACHMENT'] ?> : </td>
                                <td><input type="file" id="portfolio_attachment" name="portfolio_attachment"  size="30" class="from_input_box" />
                                </td>
                            </tr>



                            <tr class='link'>
                                <td ></td>
                                
                                    <input type="hidden" name='SBMT'  value='Submit' /></td>
                            </tr>
                        </table></td>
                </tr>
            </table>
        </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-submit-folio">Save changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

        $('.upb-btn-submit').click(function(){
            $('#upb-upload').ajaxSubmit({
                success:function(data) {
                    
                    if(data.trim() == 'success') {
                        $('#upb-upload .alert-success').html('Upload successfully.');
                        $('#upb-upload .alert-success').removeClass('hide');
                        location.reload();
                    }
                    if (data.trim() == 'empty_img') {
                        $('#upb-upload .alert-warning').html('Please select image to upload!');
                        $('#upb-upload .alert-warning').removeClass('hide');
                    } 
                    if(data.trim() == 'error') {
                        $('#upb-upload .alert-warning').html('Could not upload!');
                        $('#upb-upload .alert-warning').removeClass('hide');
                    }

                    setTimeout(function(){
                        $('#upb-upload .alert').addClass('hide');
                    }, 4000);
                }
             });
        })
        $('#btn-submit-folio').click(function(){
            if(document.getElementById("project_title").value=="") {
               $('#exp_form .alert-warning').html("please enter project title");
               $('#exp_form .alert-warning').removeClass('hide');
                document.getElementById("project_title").focus();
                setTimeout(function(){
                        $('#exp_form .alert').addClass('hide');
                    }, 3000);
                return false;
            }
            if(document.getElementById("description").value=="") {
                $('#exp_form .alert-warning').html("please enter description");
                $('#exp_form .alert-warning').removeClass('hide');
                document.getElementById("description").focus();
               setTimeout(function(){
                        $('#exp_form .alert').addClass('hide');
                    }, 3000);
                return false;
            }
            if(document.getElementById('portfolio_attachment').value!='') {
                var filename = document.getElementById('portfolio_attachment').value;
                var ext = filename.split('.');
                var allow_exts = ["xls", "xlsx", "doc", "docx", "pdf"];
                if(allow_exts.indexOf(ext[1]) == -1) {
                    $('#exp_form .alert-warning').html("Attachment allows only word, excel and pdf file!");
                    $('#exp_form .alert-warning').removeClass('hide');
                    setTimeout(function(){
                        $('#exp_form .alert').addClass('hide');
                    }, 3000);
                    return false;
                }
            }
            $('#exp_form').ajaxSubmit({
                success:function(data) {
                    var text = $(data).find('.mess-info > td > table > tbody > tr > td').text();
                    if(text == 'Portfolio details has been updated') {
                        $('#exp_form .alert-success').html(text);
                        $('#exp_form .alert-success').removeClass('hide');
                        location.reload();
                    } else {
                        $('#exp_form .alert-warning').html(text);
                        $('#exp_form .alert-warning').removeClass('hide');
                    }
                    
                    
                    setTimeout(function(){
                        $('#exp_form .alert').addClass('hide');
                    }, 4000);
                }
            })
        });

         
    });

    function getinvite() {
        $("#invidebox").slideDown('slow');
    }

    function invideuser() {
        var txtemail = $("#txtemail").val();
        var f_name = $("#f_name").val();
        var l_name = $("#l_name").val();
        var project_id_val = $("#project_id_val").val();
        var info = "project_id_val=" + project_id_val + "&txtemail=" + txtemail + "&f_name=" + f_name + "&l_name" + l_name;
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>addtoinvite.php",
            data: info,
            beforeSend: function() {
                $('#addinvite').html('<img src="<?= $vpath ?>images/login_loader2.GIF" height=22 width=22  />');
            },
            success: function(dd) {

                $("#addinvite").html(dd);
            }
        });
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

    function centerModal() {
        $(this).css('display', 'block');
        var $dialog = $(this).find(".modal-dialog");
        var offset = ($(window).height() - $dialog.height()) / 2;
        // Center modal vertically in window
        $dialog.css("margin-top", offset);
    }

    $('.modal').on('show.bs.modal', centerModal);
    $(window).on("resize", function () {
        $('.modal:visible').each(centerModal);
    });
		
	function addwistlist(id) {
		var info = "uid=" + id;
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>addtowishlist.php",
            data: info,
            beforeSend: function() {
                $('#addlist').html('<img src="<?= $vpath ?>images/login_loader2.GIF" height=22 width=22  />');
            },
            success: function(dd) {

                $("#addlist").html(dd);
            }
	});	
	}

</script>

<?php include 'includes/footer.php'; ?>
