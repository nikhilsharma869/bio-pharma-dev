<?php
$current_page = "Profile details";
include "includes/header.php";
CheckLogin();
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
<script>
    function removewistlist(id) {
        var info = "id=" + id;
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>removewishlist.php",
            data: info,
            success: function(dd) {

                $("#removediv_" + id).slideUp('slow');
            }
        });


    }

</script>
<!-----------Header End----------------------------->
<div style="width:100%; float:left; background:#FFF;">
    <div class="main_div2">
        <div class="inner-middle">
            <div class="dash_headding">
                <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="javascript:void(0)" class="selected"><?= $lang['FAV_PROF'] ?> </a></p></div>
            <div class="clear"></div>
            <!--Profile Left Start-->
            <?php include 'includes/leftpanel1.php'; ?>
            <!--Profile Left End-->
            <!--Profile Right Start-->
            <!--Dashboard Right Start-->
            <div class="profile_right">
                <div class="myproblock">	
                    <?php
                    $sql = "select * from  " . $prev . "user left join " . $prev . "wishlist on " . $prev . "wishlist.uid=" . $prev . "user.user_id  where  status='Y' and " . $prev . "wishlist.uid=" . $prev . "user.user_id and " . $prev . "wishlist.user_id=" . $_SESSION['user_id'] . " ";
                    $r = mysql_query($sql);
                    $total = @mysql_num_rows($r);
                    if ($total > 0) {
                        while ($d = @mysql_fetch_array($r)) {
                            $name = $d[fname] . " " . $d[lname];
                            if (!empty($d[logo])) {
                                $temp_logo = $d[logo];
                            } else {
                                $temp_logo = "images/face_icon.gif";
                            }
                            ?>
                            <div class="resutblock" id="removediv_<?= $d[id] ?>">

                                <div class="resultimgblock"><a href="<?= $vpath; ?>publicprofile/<?= $d[username] ?>/" > <img src="<?= $vapth ?>viewimage.php?img=<?php echo $temp_logo; ?>&amp;width=100&amp;height=100" /></a>
                                        <div><!--<img src="images/starone.png" alt=""> <img src="images/cup.png" alt="">--></div>
                                </div>
                                <div class="resulttxt">
                                    <a href="<?= $vpath; ?>publicprofile/<?= $d[username] ?>/" style="text-decoration: none;width:90%;float:left" > <h2> 
                                            <?= ucwords(txt_value_output($name)); ?><?= getrating($d[user_id]) ?>
                                        </h2></a>
                                    <div id="addlist" style="width:60px;float:right;margin-bottom:-30px">
                                        <a href="javascript:void(0);" onclick="removewistlist('<?= $d[id] ?>');"  style="cursor:pointer">
                                            <img src='<?= $vpath ?>images/user_delete.png' border=0 align=absmiddle alt='Remove form wishlist' title='Remove form wishlist'></a>
                                    </div>
                                    <div style="clear:both"></div>
                                    <h3><?= ucfirst($d['slogan']) ?></h3>
                                    <h4><?= $lang['COMPLETE_PROJECTS'] ?> <?= getprojectcomplted($d[user_id]) ?> | <?= $lang['HOURLY_RATE'] ?> <?= $d['rate'] ?></h4>
                                    <p>
                                        <? echo substr($d[profile], 0, 200); ?>
                                    </p>
                                    <div  style="padding-bottom:5px;">

                                        <?= $lang['TOP_SKILLS'] ?>
                                        :
                                        <?php
                                        
                                      $skill_q = "select c.parent_id,c.cat_id,c.cat_name from " . $prev . "categories c inner 

				join " . $prev . "user_cats u on c.cat_id=u.cat_id where user_id=" . $d[uid];

                                        $res_skill = mysql_query($skill_q);
                                        $u = 0;
                                        while ($data_skill = @mysql_fetch_array($res_skill)) {
                                            $u++;
                                            if ($u > 4) {
                                                $s = "style='display:none'";
                                            } else {
                                                $s = "";
                                            }
                                            $data_cat_name.= "<a class='skilslinks' href='javascript:void(0);'>" . $data_skill['cat_name'] . '</a>';
                                        }

//$cat_name=substr($data_cat_name,0,-1);

                                        echo $data_cat_name;

                                        $data_cat_name = "";
                                        ?>
                                    </div> 
                                    <div><p><img src="<?= $vpath ?>cuntry_flag/<?= strtolower($d[country]); ?>.png" title="France" width="16" height="11" > &nbsp;&nbsp;<?= $country_array[$d[country]]; ?> | <?= $lang['LAST_LOGIN'] ?>:<?php print date('M d, Y', strtotime($d[ldate])); ?> | <?= $lang['REGISTER_SINCE'] ?>:<?php print date('M-Y', strtotime($d[reg_date])); ?></p></div>
                                </div>

                            </div>

                            <?php
                            $j++;
                        }
                    } else {
                        echo $lang['NO_RECORD_FOUND'];
                    }
                    ?>
                </div>
            </div>  
            <div class="clr"></div>
        </div>
    </div></div>
<!--Dashboard Right End-->
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php'; ?>
