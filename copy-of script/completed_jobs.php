<?php
$current_page = "<p>Completed Jobs</p>";


include "includes/header.php";



CheckLogin();
?>

<?php
$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = '" . $_SESSION['user_id'] . "'"));

$type = $row_user['user_type'];
?>

<link rel="stylesheet" type="text/css" href="<?= $vpath ?>highslide/highslide.css" />

<script type="text/javascript" src="<?= $vpath ?>highslide/highslide-with-html.js"></script>

<script type="text/javascript">

    hs.graphicsDir = '<?= $vpath ?>highslide/graphics/';

    hs.outlineType = 'rounded-white';

    hs.wrapperClassName = 'draggable-header';

    hs.minHeight = 300;

    hs.minWidth = 450;

    hs.creditsText = '<i>Feedback Rating</i>';

</script>


<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="javascript:void(0);" class="selected"><?= $lang['COMPLETE_PROJECTS'] ?> </a></p></div>
    <div class="clear"></div>

    <?php include 'includes/leftpanel1.php'; ?> 
    <div class="profile_right">
        <div id="wrapper_3">
            <? echo getprojecttab(8, '1'); ?>
            <div class="browse_tab-content"> 
                <div class="browse_job_middle">



                    <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" align="left">
                        <tr class="tbl_bg_4">
                            <td width="250" align="left" class="space"><?= $lang['PROJECT_NAMEE'] ?></td>
                            <td width="123" align="center"><?= $lang['POSTER_BY'] ?></td>

                            <td width="170" align="center"><?= $lang['ACTION'] ?></td>
                            <td width="185" align="center"><?= $lang['POST_DATE'] ?></td>
                        </tr>



                        <?php
                       $rw2 = mysql_query("SELECT * FROM " . $prev . "projects WHERE chosen_id='" . $_SESSION[user_id] . "' and status='complete' ORDER BY id DESC ");
                        $totalp = @mysql_num_rows($rw2);
                        if ($totalp > 0) {
                            $found = 0;
                            while ($rw3 = mysql_fetch_array($rw2)) {
                                $rw5 = mysql_fetch_array(mysql_query("select sum(amount) as escrow_amount from " . $prev . "escrow where bidid = '" . $rw3['id'] . "' and status = 'Y'"));
                                $bid_amount = floatval($rw3['bid_amount']);


                                $rs_user = mysql_fetch_array(mysql_query("select username,fname,lname from " . $prev . "user where user_id = '" . $rw3['user_id'] . "'"));
                                $employer_id = ucwords($rs_user['fname']) . ' ' . ucwords($rs_user['lname']);
                                ?>
                                <tr class="tbl_bg2">
                                    <td align="left" class="space" style="border-right:none;"><?php echo '<a class=font_bold2 href="' . $vpath . 'project/' . $rw3[id] . '"><u>' . ucwords($rw3[project]) . '</u></a>'; ?></td>

                                    <td align="center"><a href="<?= $vpath ?>publicprofile/<?= $rs_user['username'] ?>/"><?php print $employer_id; ?></a></td>

                                    <td align=center>
                                        <?php
                                        $rw6 = mysql_query("select * from " . $prev . "feedback where project_id = '" . $rw3['project_id'] . "' and bidid = '" . $rw3['id'] . "' and feedback_from = '" . $_SESSION['user_id'] . "' and feedback_to = '" . $temp['user_id'] . "'");
                                        if (mysql_num_rows($rw6) > 0) {

                                            $rw7 = mysql_fetch_array($rw6);
                                            ?>
                                            <span class="feedbackRating starsMedium rating<?php print $rw7['avg_rate']; ?> __ppDone" title="" > </span>&nbsp;&nbsp;&nbsp;
                                            <a href="<?= $vpath ?>contractor_rating_view.php?rid=<?php print $rw7['id']; ?>" onclick="return hs.htmlExpand(this, {objectType: 'iframe'})" style="color:#0066FF"><?= $lang['VIEW'] ?></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?= $vpath ?>contractor_rating.php?pid=<?php print $rw3['project_id']; ?>&bid=<?php print $rw3['id']; ?>&eid=<?php print $temp['user_id']; ?>&cid=<?php print $_SESSION['user_id']; ?>" onclick="return hs.htmlExpand(this, {objectType: 'iframe'})" style="color:#0066FF"><?= $lang['GIVE_FEEDBACK'] ?></a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td align=center><?php print date('M d, Y', $rw3['date2']); ?></td>
                                </tr>
                                <?php
                                $found++;
                            }
                        }

                        if ($found == 0) {
                            ?>
                            <tr class="tbl_bg2" >
                                <td colspan="5" align="center"><strong><?= $lang['NO_COMP'] ?></strong></td>
                            </tr>
                            <?php
                        }
                        ?>  </table>

                </div>
            </div>
        </div>

    </div>


</div>		  

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php'; ?>