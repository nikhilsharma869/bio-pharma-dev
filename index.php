<?php
$current_page = 'home';
include 'includes/header.php';

include 'country.php';

include 'includes/banner-slider.php';
include 'includes/logo-stripe.php';
?>
    <div class="search-area clear-fix">
        <form action="<?=$vpath?>sear_all_jobs.html" method="POST" name="home-search" >
            <input type="text" placeholder="Search by Name or Keyword" class="input_txtbox" name="keyword">
            <div class="drop_pseudo">All Categories</div>       
            <select class="input_drop" name="" onChange="this.form.action=this.options[this.selectedIndex].value;">
                <option value="browse-freelancers.php" ><?=$lang['FIND_TALENT']?></option>
                <option value="sear_all_jobs.php" selected="selected" ><?=$lang['PROJECT_NAME']?></option>
            </select>
            <input type="submit" class="btn-home-search" name="">
        </form>
    </div>

    <div class="buttons-post clear-fix">
        <ul>
            <li>
                <a href="" class="post-my-project">Post my Project</a>
            </li>
            <li>
                <a href="" class="sme-join-now">Are you an SME? Join Now</a>
            </li>
        </ul>
    </div>

    <div class="categories-section clear-fix">
        <h1>Services offered by our Subject Matter Expert (SMEs)!</h1>
        <p>View available services by category</p>
        <div class="cat-list">
            <div class="cat">
                <div class="cat-show">
                    <img src="images/homepage/logo_cat_1.png">
                    <p>Project Management</p>
                </div>
                <div class="cat-overlay">
                    <a href="">Find FreeLancer</a>
                </div>
            </div>
            <div class="cat">
                <div class="cat-show">
                    <img src="images/homepage/logo_cat_2.png" style="width: 35%;">
                    <p>Validation</p>
                </div>
                <div class="cat-overlay">
                    <a href="">Find FreeLancer</a>
                </div>
            </div>
            <div class="cat">
                <div class="cat-show">
                    <img src="images/homepage/logo_cat_3.png" style="width: 46%;">
                    <p>Calibration</p>
                </div>
                <div class="cat-overlay">
                    <a href="">Find FreeLancer</a>
                </div>
            </div>
            <div class="cat">
                <div class="cat-show">
                    <img src="images/homepage/logo_cat_4.png" style="width: 44%; padding-top: 22px; padding-bottom: 14px;">
                    <p>Regulatory Submissions</p>
                </div>
                <div class="cat-overlay">
                    <a href="">Find FreeLancer</a>
                </div>
            </div>
            <div class="cat">
                <div class="cat-show">
                    <img src="images/homepage/logo_cat_5.png" style="padding-top: 10px; padding-bottom: 3px;">
                    <p>Quality Assurance</p>
                </div>
                <div class="cat-overlay">
                    <a href="">Find FreeLancer</a>
                </div>
            </div>
            <div class="cat">
                <div class="cat-show">
                    <img src="images/homepage/logo_cat_6.png" style="width: 41%; padding-top: 17px;">
                    <p>Process Improvement</p>
                </div>
                <div class="cat-overlay">
                    <a href="">Find FreeLancer</a>
                </div>
            </div>
            <div class="cat">
                <div class="cat-show">
                    <img src="images/homepage/logo_cat_7.png" style="width: 37%;">
                    <p>Commissioning</p>
                </div>
                <div class="cat-overlay">
                    <a href="">Find FreeLancer</a>
                </div>
            </div>
            <div class="cat">
                <div class="cat-show">
                    <img src="images/homepage/logo_cat_8.png" style="padding-top: 12px; padding-bottom: 3px;">
                    <p>Analytical Testing</p>
                </div>
                <div class="cat-overlay">
                    <a href="">Find FreeLancer</a>
                </div>
            </div>
        </div>
    </div>

    <div class="talents-section clear-fix">
        <div class="talents-title">
            <h1>Talent knows no boundaries.</h1>
            <p>Skills, integrity, and amazing results make Subject Matter Expert universally awesome.</p>
        </div>
        <ul class="talents">
            <?php

            $uqrry = mysql_query("SELECT `user_id`, `username`, `fname`, `lname`, `city`, `country`, `logo` FROM `" . $prev . "user` WHERE `logo`!='' AND `status`='Y' ORDER BY RAND() LIMIT 4");

            while ($urow = mysql_fetch_assoc($uqrry)) {

                ?>

                <li class="talent">

                    <a href="<?= $vpath . 'publicprofile/' . $urow['username'] ?>/"><img src="<?= $vpath . 'viewimage.php?img=' . $urow['logo'] ?>&width=110&height=110" height="110" width="110" /></a>

                    <p class="talent-fname"><?= ucfirst($urow['fname']) ?></p>
                    <p class="talent-lname"><?= ucfirst($urow['lname']) ?></p>

                    <p class="talent-country"><?php

                        if ($urow['city'] != '') {

                            echo ucfirst(strtolower($urow['city'])) . ', ';

                        }

                        echo ucfirst($country_array[$urow['country']]);

                        ?></p>

                </li>    

                <?php

            }

            ?>            
        </ul>
    </div>

    <div class="howitworks-section clear-fix">
        <h2>How it Works</h2>
        <p>Easily hire Subject Matter Experts (SMEs), Manage Projects, and Pay for work</p>
        <ul>
            <li>
                <img src="images/howitwork_icon1.png">
                <h4>Hire Subject Matter Experts</h4>
                <p>Search our database to find the specific services you need.</p>
            </li>
            <li>
                <img src="images/moneyback_icon1.png">
                <h4>Manage Projects</h4>
                <p>Use the Work Room to keep everything on track.</p>
            </li>
            <li>
                <img src="images/solution_icon1.png">
                <h4>Pay for Work</h4>
                <p>Pay only for work you approve. 100% PCI Compliant Gateway.</p>
            </li>
        </ul>
    </div>

    <div class="testimonials-section clear-fix">
        <h1>What <span>People Say</span> About Us</h1>
        <div class="testimonials">
            <div class="testimonial">
               <div class="testimonial-user-avatar">
                    <img width="110" height="110" src="<?php echo $vpath;?>viewimage.php?img=testimonial_images/photo1.png&amp;width=110&amp;height=110">
               </div> 
               <div class="testimonial-user-content">
                    <p class="testimonial-user-fullname">Somnath</p>
                    <p class="testimonial-date">March 27, 2014</p>
                    <hr />
                    <p class="testimonial-user-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus</p>
               </div>
            </div>
            <div class="testimonial">
               <div class="testimonial-user-avatar">
                    <img width="110" height="110" src="<?php echo $vpath;?>viewimage.php?img=testimonial_images/photo1.png&amp;width=110&amp;height=110">
               </div> 
               <div class="testimonial-user-content">
                    <p class="testimonial-user-fullname">Somnath</p>
                    <p class="testimonial-date">March 27, 2014</p>
                    <hr />
                    <p class="testimonial-user-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus</p>
               </div>
            </div>
        </div>
        <div class="view-all-testimonials">
            <a href="<?php echo $vpath;?>alltestimonial.html">View All Testimonial</a>
        </div>        
    </div>

<?
include 'includes/footer.php';
?>