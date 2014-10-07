<?php
include "includes/header.php";
?>
    <div class="spage-container my_jobs_My_Jobs_SME_After">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <h3 class="title-page">My Jobs</h3>
                    <?php
                        $parent = 'my_job';
                        $current = 'my_job';
                        $current_sub = '';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right">
                    <?php 
                        $my_jobs = get_my_job('FBO:COMBINE:darpa-baa-14-28','F');
                        if($my_jobs!=NULL):?>                            
                            <div class="job-item">    
                                <h4 class="job-title">Hourly</h4>
                                <div class="job-content">
                                <?php     
                                    foreach ($my_jobs as $job): {?>
                                        <div class="box">
                                            <div class="left-box">
                                                <p class="name-member"><?php echo $job['project'];?></p>
                                                <p class="small-text">Hired by <?php echo $job['username'];?></p>
                                                <p><a href="#">job Details</a><span class="line">|</span><a href="#">Send Message</a></p>
                                            </div>
                                            <div class="right-box">
                                                <p class="time-week">4:00 of 20 hrs this week</p>
                                                <p class="small-text">@$12.00/hr = $48.00</p>
                                                <a href="#" class="view-load">view work load</a>
                                            </div>
                                        </div>
                                <?php } endforeach; ?>
                                </div>
                            </div>
                    <?php endif;?>                        

                        <div class="job-item">
                            <h4 class="job-title">Fixed Price</h4>                        
                            <div class="job-content">
                                <div class="box">
                                    <div class="left-box">
                                        <p class="name-member">SDBC - Supernova Media</p>
                                        <p class="small-text">Hired by Raj Desai</p>
                                        <p><a href="#">job Details</a><span class="line">|</span><a href="#">Send Message</a></p>
                                    </div>
                                    <div class="right-box">
                                        <p class="time-of-price">$50.20 paid of $22.50 </p>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="left-box">
                                        <p class="name-member">SDBC - Supernova Media</p>
                                        <p class="small-text">Hired by Raj Desai</p>
                                        <p><a href="#">job Details</a><span class="line">|</span><a href="#">Send Message</a></p>
                                    </div>
                                    <div class="right-box">
                                        <p class="time-of-price">$50.20 paid of $22.50 </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>