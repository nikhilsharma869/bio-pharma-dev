<?php
$current_page = "Profile details";
include "includes/header.php";
include("country.php");
$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'"));
if (!empty($row_user[logo])) {
    $temp_logo = $row_user[logo];
} else {
    $temp_logo = "images/face_icon.gif";
}
if ($_POST[hiddskillSubmit] == 1) {
    if ($_POST[skilid] != '') {

        mysql_query("update  " . $prev . "user_skills set skills_id='" . $_POST['skill'] . "' , rating='" . $_POST[rate] . "' where user_id='" . $_SESSION[user_id] . "' and id='" . $_POST['skilid'] . "'");
    } else {

        mysql_query("insert into " . $prev . "user_skills set user_id='" . $_SESSION['user_id'] . "',skills_id='" . $_POST['skill'] . "',rating='" . $_POST[rate] . "'");
    }
}
if ($_GET[skid] != '' && $_GET[delete] != '') {

    mysql_query("delete from " . $prev . "user_skills where user_id='" . $_SESSION['user_id'] . "' and id='" . $_GET[skid] . "'");
    header("location:myprofile.html");
}
?>


<script type="text/javascript" src="<?= $vpath ?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<link rel="stylesheet" type="text/css" href="<?= $vpath ?>fancybox/jquery.fancybox-1.3.4.css" media="screen" />


<script type="text/javascript">
    $(document).ready(function() {
        $('.addskill').fancybox();
    });
</script>

<?php /* ?><script type="text/javascript" src="<?=$vpath;?>js/jquery_tab.js" ></script><?php */ ?>


<!-----------Header End----------------------------->
<div style="width:100%; float:left; background:#FFF;">
    <div class="main_div2">
        <div class="inner-middle">
            <div class="dash_headding">
                <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="javascript:void(0)" class="selected"><?= $lang['PROFESSIONAL_PROFILE'] ?></a></p></div>
            <div class="clear"></div>
            <!--Profile Left Start-->
            <?php include 'includes/leftpanel1.php'; ?>
            <!--Profile Left End-->
            <!--Profile Right Start-->
            <!--Dashboard Right Start-->
            <div class="profile_right" style="margin-top:16px;">


                <div class="myproheading"><h3><img src="images/profile1.png" align="left" style="margin-right:8px; margin-left:4px;" /><?= $lang['MY_PROF_PROFILE'] ?></h3><a href="<?= $vpath ?>profile.html" class="myedit">Edit</a></div>

                <div class="myproblock">
                    <div class="myproblockleft">
                        <div class="myproblockleft">
                            <div class="myproimg"><img src="<?= $vpath ?>viewimage.php?img=<?php echo $temp_logo; ?>&width=120&height=120" alt="" /></div>
                            <div class="myprotext">
                                <table width="310" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="25" align="left" valign="middle"><?= $lang['USRNM'] ?>: <span><?= $row_user[username] ?></span><?= getrating($row_user[user_id]) ?></td>
                                    </tr>
                                    <tr>
                                        <td height="25" align="left" valign="middle"  style="padding-left:10px;"><?= ucfirst($row_user[slogan]) ?></td>
                                    </tr>
                                    <tr>
                                        <td height="25" align="left" valign="middle"><span><?php print $country_array[$row_user[country]]; ?>&nbsp;<img src="<?= $vpath ?>cuntry_flag/<?= strtolower($row_user[country]); ?>.png" title="<?= $country_array[$row_user[country]]; ?>" width="16" height="11" ></span></td>
                                    </tr>
                                    <tr>
                                        <td height="25" align="left" valign="middle"><?= $lang['LST_LGGD'] ?>: <span><?php print date('M d,Y', strtotime($_SESSION['ldate'])); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td height="25" align="left" valign="middle"><?= $lang['PR_MIN_RT'] ?>: <span> $<?= $row_user['rate'] ?></span></td>
                                    </tr>
                                </table>

                            </div>
                        </div>

                        <div class="myproblockleft">
                            <strong style="padding:12px 0; display:block;"><?= $lang['PR_OVR'] ?></strong>
                            <p><?= $row_user['profile'] ?></p>
                            <strong style="padding:12px 0; display:block;"><?= $lang['WORK_EXP'] ?></strong>
                            <p><?= $row_user['work_experience'] ?></p>
                        </div>
                    </div>

                </div>
                <div class="myproheading"><h3><img src="images/skill.png" align="left" style="margin-right:10px; margin-top:-6px;" /><?= $lang['SKILLS'] ?></h3><a href="<?= $vpath ?>select-expertise.html" class="myedit"><?= $lang['EDIT'] ?></a></div>
                <div class="myproblock"><p>
                        <?php
                        $skill_q = "select c.parent_id,c.cat_id,c.cat_name from " . $prev . "categories c inner 

				join " . $prev . "user_cats u on c.cat_id=u.cat_id where user_id=" . $_SESSION[user_id];

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
                <div class="myproheading"><h3><img src="images/profile.png" align="left" style="margin-right:10px; margin-top:-3px;"  /><?= $lang['PRTFLO'] ?></h3><a href="<?= $vpath ?>userportfolio.html" class="myedit"><?= $lang['EDIT'] ?></a></div>

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
                    $rr = mysql_query("select *  from " . $prev . "portfolio where user_id=" . $_SESSION['user_id'] . " AND `status`='Y' ORDER BY `id` DESC");
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
                                <div class="prosl1"><img src="<?= $vpath ?>viewimage.php?img=<?= $f[image]; ?>&width=287&height=240" alt="" /></div>
                                <div class="slidetxt">
                                    <h2><?= $f[project_title]; ?></h2>
                                    <p style="font-size:12px;"><?= substr(nl2br($f[description]), 0, 200); ?></p>
                                    <a href="http://<?= str_replace("http://", "", str_replace("https://", "",$f[link])) ?>" target="_blank"><?= $f[link] ?></a>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>





                </ul>



            </div>
        </div>
        <!--Dashboard Right End-->
    </div>
</div>
<?php include 'includes/footer.php'; ?>
