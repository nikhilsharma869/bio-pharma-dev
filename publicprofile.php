<?php
$current_page = "Profile details";
include "includes/header.php";
include("country.php");
$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where username = '" . $_GET[username] . "'"));
if (!empty($row_user[logo])) {
    $temp_logo = $row_user[logo];
} else {
    $temp_logo = "images/face_icon.gif";
}
?>
<script>
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
</script>
<div class="inner-middle">
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="<?= $vpath ?>find-talents/"><?= $lang['FIND_TALENT'] ?></a> | <a href="javascript:void(0)" class="selected"><?= $_GET[username] ?> <?= $lang['PROFL'] ?></a></p></div>
    <div class="clear"></div>
    <div class="newlwft">
        <div class="create_profile1">
            <div class="myproheading"><h3><?= ucwords($row_user['fname']) . '&nbsp;' . ucwords($row_user['lname']); ?> <?= $lang['PROFL'] ?>
                </h3><?php if ($_SESSION['user_id'] && $_SESSION['user_id'] != $row_user['user_id']) { ?>
                    <?php
                    $n = mysql_num_rows(mysql_query("select *  from " . $prev . "wishlist where user_id='" . $_SESSION[user_id] . "' and uid='" . $row_user[user_id] . "'"));
                    ?>
                    <a href="javascript:void(0);" onclick="addwistlist('<?= $row_user[user_id] ?>');"  style="cursor:pointer"><span id="addlist">

                            <?php if ($n == 0) { ?><img src='<?= $vpath ?>images/unfill.png' border=0 align=absmiddle alt='add to wishlist' title='add to wishlist'>
                            <?php } else { ?>
                                <img src='<?= $vpath ?>images/fill.png' border=0 align=absmiddle alt='added to wishlist' title='added to wishlist'>
                            <?php } ?>

                        </span></a>

                <?php } ?>
                <?php if ($_SESSION['user_id'] != $row_user['user_id']) { ?>

                    <a <?php if ($_SESSION['user_id'] != '') { ?>href="javascript:void(0)" onclick="getinvite()"<?php } else { ?>href="<?= $vpath ?>login.html"<?php } ?> class="invite_freelancer">
                        <?= $lang['INVITE'] ?>            </a><?php } ?>
            </div>
            <div class="myproblock">
                <div class="myproblockleft">
                    <div class="myproblockleft">
                        <div class="myproimg"><img src="<?= $vpath ?>viewimage.php?img=<?php echo $temp_logo; ?>&width=120&height=120" alt="" /></div>
                        <div class="myprotext">
                            <table width="310" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="25" align="left" valign="middle"><?= $lang['USER_NAM'] ?>: <span><?= $row_user[username] ?></span><?= getrating($row_user[user_id]) ?></td>
                                </tr>
                                <tr>
                                    <td height="25" align="left" valign="middle"  ><?= $lang['SlOGAN'] ?>: <span><?= ucfirst($row_user[slogan]) ?></span></td>
                                </tr>
                                <tr>
                                    <td height="25" align="left" valign="middle"><span><?php print $country_array[$row_user[country]]; ?>&nbsp;<img src="<?= $vpath ?>cuntry_flag/<?= strtolower($row_user[country]); ?>.png" title="<?= $country_array[$row_user[country]]; ?>" width="16" height="11" ></span></td>
                                </tr>
                                <tr>
                                    <td height="25" align="left" valign="middle"><?= $lang['LST_LGGD'] ?>: <span><?php print date('M d,Y', strtotime($row_user['ldate'])); ?></span></td>
                                </tr>
                                <tr>
                                    <td height="25" align="left" valign="middle"><?= $lang['PR_MIN_RT'] ?>: <span> $<?= $row_user['rate'] ?></span></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <?php 
                        $lang_dob = "select dateofbirth from " . $prev . "user_profile where user_id=" . $row_user[user_id];
                        $res_dob = mysql_query($lang_dob);
                        $dob = json_decode(@mysql_result($res_dob,0,"dateofbirth"));
                        if(!empty($dob)) { ?>
                            <div class="myproblockleft">
                                <strong style="padding:12px 0; display:block;"><?= 'Date Of Birth' ?></strong>
                                <p>                                    
                                  <?php 
                                    echo date("F", mktime(0, 0, 0, $dob->month, 1 , 0));
                                    echo " ".$dob->day." ";
                                    if(isset($dob->year)) {
                                        echo date("Y", mktime(0, 0, 0, 0, 1, $dob->year));
                                    } 
                                  ?>
                                </p>                    

                            </div>
                    <?php } ?>
                    <div class="myproblockleft">
                        <strong style="padding:12px 0; display:block;"><?= $lang['CM_PRFL'] ?></strong>
                        <p><?= $row_user['profile'] ?></p>


                    </div>
                    <div class="myproblockleft">
                        <strong style="padding:12px 0; display:block;"><?= 'Languages' ?></strong>
                        <p>
                            <?php 
                            $lang_q = "select languages from " . $prev . "user_profile where user_id=" . $row_user[user_id];
                            $res_lang = mysql_query($lang_q);
                            echo @mysql_result($res_lang,0,"languages");
                            ?>
                        </p>


                    </div>
                    <?php 
                        $lang_ins = "select interests from " . $prev . "user_profile where user_id=" . $row_user[user_id];
                        $res_ins = mysql_query($lang_ins);
                        $interests = json_decode(@mysql_result($res_ins,0,"interests"));
                        if(!empty($interests)) { ?>
                            <div class="myproblockleft">
                                <strong style="padding:12px 0; display:block;"><?= 'Interests' ?></strong>
                                <p>                                    
                                  <?php 
                                    echo $interests;
                                  ?>
                                </p>                    

                            </div>
                    <?php } ?>
                    <!-- <div class="myproblockleft">
                        <strong style="padding:12px 0; display:block;"><?= $lang['WORK_EXP'] ?></strong>
                        <p><?= $row_user['work_experience'] ?></p>


                    </div> -->

                    
                </div>

            </div>
            <div class="myproheading"><h3><?= $lang['WORK_EXP'] ?></h3></div>
            <div class="myproblock">                
                <?php
                    $exp_q = "select experience from " . $prev . "user_profile where user_id=" . $row_user[user_id];

                    $res_exp = mysql_query($exp_q);
                    $data_exps = @mysql_result($res_exp,0,"experience");
                    $data_exps = json_decode($data_exps);
                    // echo "<pre>";
                    // var_dump($data_exps);
                    for($i=0;$i<count($data_exps->values);$i++){
                        ?>
                        <p>
                            <strong><?php echo $data_exps->values[$i]->title.' at '.$data_exps->values[$i]->company->name; ?></strong><br />
                            <span style="font-size:12px;">
                                <?php echo date("F Y", mktime(0, 0, 0, $data_exps->values[$i]->startDate->month, 1 , $data_exps->values[$i]->startDate->year)); ?> 
                                -
                                <?php if($data_exps->values[$i]->isCurrent) {
                                    echo "Present";
                                } else {
                                    echo date("F Y", mktime(0, 0, 0, $data_exps->values[$i]->endDate->month, 1 , $data_exps->values[$i]->endDate->year)); 
                                } ?>
                            </span>
                            <p style="font-size:14px; padding-left: 10px;">
                                <?php if(isset($data_exps->values[$i]->summary)) { ?>
                                <?php echo $data_exps->values[$i]->summary; ?>
                                <?php } ?>
                            </p>
                        </p>
                        <?php                        
                    }
                    
                ?>                
            </div>

            <div class="myproheading"><h3><?= 'Skills' ?></h3></div>
            <div class="myproblock">
                <p>
                    <?php
                        $skill_q = "select skills from " . $prev . "user_profile where user_id=" . $row_user[user_id];

                        $res_skill = mysql_query($skill_q);
                        $data_skills = @mysql_result($res_skill,0,"skills");
                        $data_skills = explode(',', $data_skills);

                        foreach ($data_skills as $skill) {
                            $data_skill_name.= "<a class='skilslinks'>". $skill . '</a>  ';
                        }
                       
                        $skill_name = $data_skill_name;
                        echo $skill_name;
                        
                    ?>
                </p>
            </div>
            <div class="myproheading"><h3><?= 'Educations' ?></h3></div>
            <div class="myproblock">                
                <?php
                    $edu_q = "select educations from " . $prev . "user_profile where user_id=" . $row_user[user_id];

                    $res_edu = mysql_query($edu_q);
                    $data_edus = @mysql_result($res_edu,0,"educations");
                    $data_edus = json_decode($data_edus);
                    // echo "<pre>";
                    // var_dump($data_edus);
                    for($i=0;$i<count($data_edus->values);$i++){
                        ?>
                        <p>
                            <strong><?php echo $data_edus->values[$i]->schoolName; ?></strong><br />
                            <span style="font-size:12px;">
                                <?php if(isset($data_edus->values[$i]->startDate)) { ?>
                                <?php echo $data_edus->values[$i]->startDate->year; ?>
                                <?php } ?>
                                <?php if(isset($data_edus->values[$i]->endDate)) { ?>
                                <?php echo ' - '.$data_edus->values[$i]->endDate->year; ?>
                                <?php } ?>
                            </span>                            
                        </p>
                        <?php                        
                    }
                    
                ?>                
            </div>
            <div class="myproheading"><h3><?= 'Recommend' ?></h3></div>
            <div class="myproblock">                
                <?php
                    $edu_rec = "select recommendations from " . $prev . "user_profile where user_id=" . $row_user[user_id];

                    $res_rec = mysql_query($edu_rec);
                    $data_recs = @mysql_result($res_rec,0,"recommendations");
                    $data_recs = json_decode($data_recs);
                    // echo "<pre>";
                    // var_dump($data_edus);
                    for($i=0;$i<count($data_recs->values);$i++){
                        ?>
                        <p>
                            <strong><?php echo $data_recs->values[$i]->recommender->firstName." ".$data_recs->values[$i]->recommender->lastName; ?></strong><br />
                            <span style="font-size:12px;">
                                <?php echo  $data_recs->values[$i]->recommendationText; ?>
                            </span>                            
                        </p>
                        <?php                        
                    }
                    
                ?>                
            </div>

            <div class="myproheading"><h3><?= $lang['Category'] ?></h3></div>
            <div class="myproblock"><p>
                    <?php
                    $skill_q = "select c.parent_id,c.cat_id,c.cat_name from " . $prev . "categories c inner 

				join " . $prev . "user_cats u on c.cat_id=u.cat_id where user_id=" . $row_user[user_id];

                    $res_skill = mysql_query($skill_q);

                    while ($data_skill = @mysql_fetch_array($res_skill)) {

                        $data_cat_name.= "<a class='skilslinks' href='" . $vpath . "browse-freelancers/1/" . $data_skill[cat_id] . "/" . $data_skill[parent_id] . "/'>"
                                . $data_skill['cat_name'] . '</a>  ';
                    }
                    $cat_name = $data_cat_name;

                    echo $cat_name;

                    if ($cat_name == "") {

                        echo $lang['SKILL_NOT_SET'];
                    }
                    ?></p>

            </div>

            <div class="myproheading" id="review"><h3><?= $lang['REVIEWS'] ?></h3></div>
            <div class="myproblock">
                <?php include("includes/puplic_review.php"); ?>
            </div>
            <div class="myproheading"><h3><?= $lang['PRTFLO'] ?></h3></div>


            <br clear="all" />


            <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
            <link rel="stylesheet" href="css/anythingslider.css">
            <script src="js/jquery.anythingslider.js"></script>
            <script>
                // DOM Ready
                $(function() {
                    $('#slider').anythingSlider({
                        hashTags: false
                    });
                });
            </script>
            <style>
                #slider { width: 612px; height:250px; }
            </style>

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
                            </div>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <br />
    </div>
    <div class="boxright">
        <h2><?= $lang['ID'] ?></h2>
        <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" height="10"></td>
            </tr>
            <tr>
                <td class="tblborder"><span><?= $lang['USER_NAM'] ?></span></td>
                <td class="tblborder"> <b><?= ucwords($row_user['username']); ?> </b></td>
            </tr>
            <tr>
                <td class="tblborder"  ><span><?= $lang['PROJECT_COMPLETED'] ?></span></td>
                <td class="tblborder" ><?= $lang['CLIENT'] ?>: <b><?= getprojectcompltedbyclient($row_user[user_id]) ?> </b><br/>
                    <?= $lang['AS_FREELANCER'] ?>: <b><?= getprojectcomplted($row_user[user_id]) ?> </b>
                </td>
            </tr>
            <tr>
                <td class="tblborder"><span><?= $lang['WORKING_PROJECTS'] ?></span></td>
                <td class="tblborder"> <b><?= getprojectworking($row_user[user_id]) ?> </b></td>
            </tr>
            <tr>
            <tr>
                <td class="tblborder"><span><?= $lang['LOCATION'] ?></span></td>
                <td class="tblborder"> <b><?php print $country_array[$row_user[country]]; ?> </b>&nbsp;<img src="<?= $vpath ?>cuntry_flag/<?= strtolower($row_user[country]); ?>.png" title="<?= $country_array[$row_user[country]]; ?>" width="16" height="11" ></td>
            </tr>
            <tr>
                <td colspan="2" height="7"></td>
            </tr>
            <tr>
                <td class="tblborder"><span><?= $lang['MEMB'] ?></span></td>
                <td class="tblborder"> <b><?php print date('M d, Y', strtotime($row_user[reg_date])); ?> </b></td>
            </tr>
            <tr>
                <td colspan="2" height="7"></td>
            </tr>
            <tr>
                <td width="89" class="tblborder"><span><?= $lang['LAST_SGN'] ?></span></td>
                <td width="111" class="tblborder"> <b><?php print date('M d, Y', strtotime($row_user[ldate])); ?> </b></td>
            </tr>
            <tr>
                <td width="89" class="tblborder"><span><?= $lang['RATED_BY'] ?></span></td>
                <td width="111" class="tblborder">
                    <b><a href="javascript:void(0)" class="rev" id="review"><?= $clientname ?></a></b>

                </td>

            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <br>
    </div>

    <div class="boxright" id="invidebox" style="margin:10px 0;display:none;">
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
        <?php } ?>
        <div style="padding-left:10px;margin: 10px 0px;">
            <div id="addinvite_post" align="center">
                <a href="javascript:void(0)" onclick="postprojectinvite()">
                    <input type="button" name="Button" value="Post a New Project"  class="submit_bott"/>
                </a>
            </div>            
        </div>
    </div>
</div>

<!--Profile Right End-->

<div style="clear:both; height:10px;"></div>
<style>
    .create_profile1{
        width: 743px;
        float: left;
    }
    .newlwft{
        float:left;
    }
    #addlist{
        padding-left:10px;
    }
    .invite_freelancer{
        background: url(<?= $vpath ?>images/invite.png) 6% 50% no-repeat #5bb25b;
        color: #fff;
        background-size: contain;
        font-size: 14px;
        font-family: Arial, Helvetica, sans-serif;

        padding: 4px 10px 4px 35px;
        text-decoration: none;
        float:right;
        margin-top: -4px;
    }
    .invite_freelancer:hover{background: url(<?= $vpath ?>images/invite.png) 6% 50% no-repeat ;background-size: initial;padding: 14px 10px 13px 55px;margin-top: -14px;}
    .myproblock strong{
        font-size:12px;
    }
    .invitebox_section {

        padding-left:10px;width:100%;float:left
    }
</style>
<script>
    $('.rev').bind('click', function(event) {
        var divID = '#' + this.id;
        $('html, body').animate({
            scrollTop: $(divID).offset().top
        }, 1000);
    });
</script>
<?php include 'includes/footer.php'; ?>
