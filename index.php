<?php $current_page = "home"; ?>

<?php include ('includes/header.php'); ?>

<!--BANNER BOX-->

<?php include ('country.php'); ?>

<?php include 'includes/banner.php';
include 'includes/logo-stripe.php';
?>

<style>

    .option_section{

        /*border-bottom:1px solid #d7d7d7;

        border-top:1px solid #d7d7d7;*/

        margin:0px 10px 0px 10px;

        overflow:hidden;

    }



    .post_box{

        padding:5px 0px 10px 0px;

        margin:0px 6px 0px 8px;

        width:311px;

        float:left;	

        /*	border-right:1px solid #d7d7d7;	*/

    }

    .post_box.last{

        background: none;

    }





    .post_box h3{

        padding:10px 0px 10px 0px;

        margin:0px 0px 0px 0px;

        font-family: 'Open Sans', sans-serif;

        font-size:18px;

        color:#1b4471;

        text-shadow:0px 1px 0px #e2e2e2;

        float:none;

        width:auto;

        text-align:center;

    }

    .post_box h3 span{

        color:#22b14c;

    }



    .post_box p{

        /*background: url(images/bulet.png) no-repeat;*/

        color: #646464;

        font-family: 'Open Sans', sans-serif;

        font-size:13px;

        margin: 0px 0 2px 0px;

        padding: 0 0 0 15px;

        text-align:center;

    }



    .post_box p:hover{

        color: #005E8B;

    }



    .post_img{

        padding:0px 0px 0px 0px;width: auto;

        /*	margin:51px 10px 0px 0px;

                float: left;*/

    }

    .sign_up_panel{

        margin:10px 10px 10px 10px;

        background:#f7f7f7;

        -moz-box-shadow:    inset 0 0 20px #d8d8d8;

        -webkit-box-shadow: inset 0 0 20px #d8d8d8;

        box-shadow:         inset 0 0 20px #d8d8d8;

        padding:12px;

        overflow:hidden;



    }

    .sign_up_panel h3{

        color: #035c92;

        font-family: 'Open Sans', sans-serif;

        font-size:21px;

        padding:0px 0px 0px 10px;

        margin:0px;

        float:left;

    }



    .sign_up_bnt{

        margin:0px 10px 0px 20px;

        float:left;

    }

    .sign_up_bnt a{

        background:#026ecc;

        -moz-border-radius:7px;

        -webkit-border-radius:7px;

        -khtml-border-radius:7px;

        border-radius:7px;

        border:none;

        cursor:pointer;

        padding:4px 23px 3px 23px;

        -moz-box-shadow:    0px 3px 0px 0px #06589f;

        -webkit-box-shadow:  0px 3px 0px 0px #06589f;

        box-shadow:          0px 3px 0px 0px #06589f;

        font-size:18px;

        color:#f3f3f3;

        font-weight:normal;

        font-family: 'Open Sans', sans-serif;

        text-decoration:none;



    }

    .sign_up_bnt a:hover{

        box-shadow: 0 1px 0 #06589f;

        position: relative;

        top: 2px;

    }

    .logo_pannel{

        margin:10px 10px 0px 10px;

    }

    .news_heading{

        font-family: 'Open Sans', sans-serif;

        color:#265384;

        font-size:18px;

        border-right:1px solid #b9c9db;

        float:left;

        padding:10px 30px 10px 0px;

    }

    .logo_icon{

        float:left;

        margin:0px 11px;

    }

</style>  



<div class="main_div">

<div class="overlap_wrapper">
	<div class="big_search">
    	<div class="big_search_inner">
        	<form action="<?=$vpath?>sear_all_jobs.html"  method="POST" name="myform" id="myform">
            <input type="text" placeholder="Search Categories" class="input_txtbox" name="keyword">            
            <div class="drop_style">All Categories</div>
            <select class="input_drop" name="" onChange="this.form.action=this.options[this.selectedIndex].value;">
           		 <option value="browse-freelancers.php" ><?=$lang['FIND_TALENT']?></option>
                  <option value="sear_all_jobs.php" selected="selected" ><?=$lang['PROJECT_NAME']?></option>
                   <!-- <option>Skills</option> -->
            </select>
            <input type="submit" class="big_srch" name="">
            </form>
        </div>
       
    </div>
    <ul>
    	<li><a href="#">Post my Project</a></li>
        <li><a style="background:#be202e;" href="#">Are you an SME? Join Now</a></li>
    </ul>
</div>

    <div class="option_section">

        <h3 class="get_job_hdr">Services offered by our Subject Matter Expert (SMEs)!
        <br /><font>View available services by category</font>
        </h3>
		


        <?php

        $i = 0;

        $cat_qrry = mysql_query("SELECT * FROM `" . $prev . "categories` WHERE `parent_id`=0 AND `status`='Y' LIMIT 8");

        while ($cat_row = mysql_fetch_assoc($cat_qrry)) {

            $i++;

            ?>

            <div class="SecArea">

                <div class="talentbox">

                    <div class="ImgSec"><img src="<?= $vpath . $cat_row['cat_logo'] ?>" style="width: 174px; height: 140px;" /></div>

                    <div class="talentlink"><a href="#" style="color: #fff"><?= ucfirst($cat_row['cat_name']) ?></a></div>

                    <a href="<?= $vpath ?>browse-freelancers/1/<?= $cat_row['cat_id'] ?>">

                        <div class="talent_overlay" id="info_layer">

                            <h2><?= ucfirst($cat_row['cat_name']) ?></h2>

                            <p><?= nl2br($cat_row['cat_desc']) ?></p>

                            <a href="<?= $vpath ?>browse-freelancers/1/<?= $cat_row['cat_id'] ?>"><div class="freeBtn">Find frfeelancer</div></a>

                        </div>

                    </a>

                </div>

            </div>

            <?php

            if ($i % 4 != 0) {

                ?>

                <div class="blk_div2"></div><!--blank area 2-->

                <?php

            }

        }

        ?>

        <!--<input type="button"  class="viewCatBtn" value="View All Categorie" onclick="javascript: window.location = '<?= $vpath ?>find-talents/'" />-->



    </div>

    <?php /* ?><div class="sign_up_panel">

      <h3><?=$lang['ARE_U_PROFESSION']?></h3>

      <div class="sign_up_bnt"><a href="<?=$vpath?>signup.html"><?=$lang['SIGNUP_HERE']?></a></div>

      <h3> <?=$lang['AND_FIND_BEST_PROJECT']?></h3>



      </div><?php */ ?>





    <!--21-03-14-->





    <?php /* ?><div id="testimonials_div_area">

      <?php //echo "SELECT * FROM ".$prev."testimonial WHERE status= 'Y' ORDER BY post_date LIMIT 2";

      $r = mysql_query("SELECT * FROM ".$prev."testimonial WHERE status= 'Y' ORDER BY post_date LIMIT 2");

      while(@$d=mysql_fetch_assoc($r)){

      ?>



      <div class="testimonials_sec">

      <img src="<?=$vpath.$d['picture']?>" />

      <div class="testi_text"> &nbsp;

      <span >"</span>  <?=html_entity_decode(substr($d['comment'],0,50))?> <span >"</span>



      </div>

      <div class="testi_text2">&nbsp;

      <?=$d['client_name']?><br />

      </div>



      </div>



      <?php } ?>



      <!---->







      <div class="see_more_area">

      <h2 class="see_text">See more <span class="blue_text"><a href="<?=$vpath?>information/testimonial">real-life stories</a></span>of great work on Elance.</h2>

      </div>



      <div class="see_more_logo">

      <div class="news_heading"><?=$lang['FREELANCE4LESS'].' '.$lang['IN_THE_MEDIA']?></div>

      <div class="logo_icon">

      <img src="images/logo_icon.jpg" />

      </div>

      <div class="logo_icon">

      <img src="images/logo_icon2.jpg" />

      </div>

      <div class="logo_icon">

      <img src="images/logo_icon3.jpg" />

      </div>

      </div>











      </div><?php */ ?>





















    <div class="clear"></div>









</div>

<?

if ($_SESSION[lang_id]) {

    $row_content_lang = mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where content_field_id=51 and table_name='contents' and field_name='contents' and lang_id='" . $_SESSION[lang_id] . "'"));



    //echo "select * from ".$prev."language_content where content_field_id=22 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'";



    $row_content['contents'] = $row_content_lang[content];

} else {

    $row_content = mysql_fetch_array(mysql_query("select * from " . $prev . "contents where cont_title='Home'"));

}

?>





<div class="ClientArea"><!--client 100% area-->

    <div class="main_div2">



        <div class="ClientLft">

            <h2>Talent knows no boundaries.</h2>

            <p>Skills, integrity, and amazing results make

                Subject Matter Expert universally awesome.</p>

        </div>



        <div class="ClientRht">

            <?php

            $uqrry = mysql_query("SELECT `user_id`, `username`, `fname`, `lname`, `city`, `country`, `logo` FROM `" . $prev . "user` WHERE `logo`!='' AND `status`='Y' ORDER BY RAND() LIMIT 4");

            while ($urow = mysql_fetch_assoc($uqrry)) {

                ?>

                <div class="ClSec1">

                    <div class="Cimgarea" style="border-radius: 51.5px;overflow: hidden;text-align: center;">

                        <img src="<?= $vpath . 'viewimage.php?img=' . $urow['logo'] ?>&width=109&height=109" height="109px" width="109px" />

                    </div>

                    <h1><a href="<?= $vpath . 'publicprofile/' . $urow['username'] ?>/"><?= ucfirst($urow['fname']) ?><br><?= ucfirst($urow['lname']) ?></a></h1>

                    <p><?php

                        if ($urow['city'] != '') {

                            echo ucfirst(strtolower($urow['city'])) . ', ';

                        }

                        echo ucfirst($country_array[$urow['country']]);

                        ?></p>

                </div>    

                <?php

            }

            ?>

        </div>



    </div>

</div><!--end 100% area-->



<div class="TestiAreaDiv">

    <div class="main_div2">
    
<h3 class="get_job_hdr get_job_hdr_white">How it Works<br><font>Easily hire Subject Matter Experts (SMEs), Manage Projects, and Pay for work</font></h3>


        <div class="HowItSecArea">

            <div class="HowSec1">

                <div class="WorkIconarea"><img src="images/howitwork_icon1.png"></div>

                <h1>Hire Subject Matter Experts</h1>

                <p>Search our database to find the
specific services you need.</p>

                <!--<a href="<?php echo $vpath;?>howitworks.html"><input type="button" class="learnmore_btn" value="Learn More"/></a>-->

            </div>



            <div class="blk_area"></div><!--blank area div-->



            <div class="HowSec1">

                <div class="WorkIconarea"><img src="images/moneyback_icon1.png"></div>

                <h1>Manage Projects</h1>

                <p>Use the Work Room to keep
everything on track.</p>

                <!--<a href="<?php echo $vpath;?>moneyback.html"><input type="button" class="learnmore_btn" value="Learn More"/></a>-->

            </div>



            <div class="blk_area"></div><!--blank area div-->



            <div class="HowSec1">

                <div class="WorkIconarea"><img src="images/solution_icon1.png"></div>

                <h1>Pay for Work</h1>

                <p>Pay only for work you approve.
100% PCI Compliant Gateway.</p>

               <!-- <a href="<?php echo $vpath;?>enterpricesolution.html"><input type="button" class="learnmore_btn" value="Learn More"/></a>-->

            </div>



        </div>



        
    </div>

</div>


<div style="background:#fff;" class="TestiAreaDiv">

    <div class="main_div3">

        <h3 class="get_job_hdr get_job_hdr_new">What <span style="color:#2272ba">People Say</span> About Us</h3>

        
            <div class="testimonilas1">

                <div style="border-radius: 51.5px;overflow: hidden;text-align: center;" class="TImg">

                    <img width="104px" height="104px" src="<?php echo $vpath;?>viewimage.php?img=testimonial_images/photo1.png&amp;width=106&amp;height=106">

                </div>

                <div class="testTextArea">

                    <h3>Somnath</h3>

                    <h4>March 27, 2014</h4>

                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus
                        
                            <a style="color: #fda006;" href="<?php echo $vpath;?>alltestimonial.html#testimonial11"> View Details</a>

                            
                    </p>

                </div>

            </div>

            
            <div class="testimonilas2">

                <div style="border-radius: 51.5px;overflow: hidden;text-align: center;" class="TImg">

                    <img width="104px" height="104px" src="<?php echo $vpath;?>viewimage.php?img=testimonial_images/1400665792.JPG&amp;width=106&amp;height=106">

                </div>

                <div class="testTextArea">

                    <h3>Swarup Malgope</h3>

                    <h4>May 21, 2014</h4>

                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration
                        
                    </p>

                </div>

            </div>

            
       <div class="viewbtn_wrapper"> <input type="button" onclick="javascript: window.location = '<?php echo $vpath;?>alltestimonial.html'" value="View All Testimonial" class="viewCatBtn"></div>

    </div>

</div>




<?php /* ?><div class="main_div2">

  <div class="work_palace">

  <h3>Find freelancers at the world's most-trusted online workplace.</h3>

  <?php echo html_entity_decode($row_content['contents']);?>







  </div>

  </div><?php */ ?>







<?php include 'includes/footer.php'; ?>

