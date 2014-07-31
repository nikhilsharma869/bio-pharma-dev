<!--<script type="text/javascript" src="<?= $vpath ?>jquery.js"></script>

<script src="http://code.jquery.com/jquery.js"></script>-->
<script src="src1/skdslider.js"></script>
<link href="src/skdslider.css" rel="stylesheet">
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('#demo1').skdslider({'delay': 5000, 'animationSpeed': 2000, 'showNextPrev': true, 'showPlayButton': true, 'autoSlide': true, 'animationType': 'fading'});
        jQuery('#demo2').skdslider({'delay': 5000, 'animationSpeed': 1000, 'showNextPrev': true, 'showPlayButton': false, 'autoSlide': true, 'animationType': 'sliding'});
        jQuery('#demo3').skdslider({'delay': 5000, 'animationSpeed': 2000, 'showNextPrev': true, 'showPlayButton': true, 'autoSlide': true, 'animationType': 'fading'});

        jQuery('#responsive').change(function() {
            $('#responsive_wrapper').width(jQuery(this).val());
        });

    });
</script>


<div class="banner_section">
    <ul id="demo2">
        <?php
        $bnrqrry = mysql_query("SELECT * FROM `" . $prev . "banner` WHERE `status`='Y'");
        while ($bannerrow = mysql_fetch_assoc($bnrqrry)) {
            ?>
            <li>
                <div class = "sld_bd_text_area">
                    <h2 class="s_text" style = " background:#333; width:360px; padding-left:10px;"><?= ucwords($bannerrow['title']) ?></h2>
                    <p class = "s_textbg"><?= $bannerrow['sub_title'] ?></p>
                    <p class = "bnrtext"><?= nl2br($bannerrow['desc']) ?></p>
                    <div class="PostBtnArea">
                        <a href="<?= $vpath . $bannerrow['link1'] ?>" class="select"><?= ucwords($bannerrow['link1_text']) ?></a>
                        <a href="<?= $vpath . $bannerrow['link2'] ?>"><?= ucwords($bannerrow['link2_text']) ?></a>
                    </div>
                </div>
                <img src="<?= $vpath . $bannerrow['img'] ?>" />
            </li>
            <?php
        }
        ?>
    </ul>



    <?php /* ?><div class="banner_left">
      <div class="vedio_img"><img src="images/vedio_img.png" /></div>
      <h1><?=$lang['GET_TO_KNOW_ABOUT']?> FREELANCE<font color="#22b14c">4</font>LESS</h1>
      <p><? = $lang['PLZ_TAKE_MOMENT_HELP_U_DONE']
      ?></p>
      </div><?php */ ?>
    <!--<div class="banner">
        <img src="images/banner.jpg" />
    </div>-->
</div>
<!--start_banner-->
<div style="clear:both; height:0px;"></div>