<?php
$current_page = "All Testimonials";
include "includes/header.php";
$tstmqry = mysql_query("SELECT * FROM `" . $prev . "testimonial` WHERE `status`='Y' ORDER BY `post_date` DESC");
?>

<!-----------Header End-----------------------------> 

<div class="container" style=" width: 1000px; margin: 0 auto; ">


    <!--Howitworks Start-->
    <div class="containt">
        <?php
        while ($tstrow = mysql_fetch_assoc($tstmqry)) {
            ?>
        <div class="testimonilas1" style="width: 900px;" id="testimonial<?=$tstrow['testi_id']?>">
                <div class="TImg" style="border-radius: 51.5px;overflow: hidden;text-align: center;">
                    <img src="<?= $vpath ?>viewimage.php?img=<?= $tstrow['picture'] ?>&amp;width=106&amp;height=106" height="104px" width="104px">
                </div>
                <div class="testTextArea" style="float: left; margin-left: 15px;width: 780px;">
                    <h3><?= ucwords($tstrow['client_name']) ?></h3>
                    <h4 style="margin-left: 17px;"><?= date('F d, Y', strtotime($tstrow['post_date'])) ?></h4>
                    <p><?= $tstrow['comment']; ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

</div>
<div style="clear:both"></div>

<!--FOOTER BOX-->
<?php include 'includes/footer.php'; ?> 
<!--FOOTER BOX END-->