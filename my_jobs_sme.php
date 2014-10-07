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
                        $my_jobs = get_my_job($_SESSION['user_id'],'H');?>                            
                            <div class="job-item">    
                                <h4 class="job-title">Hourly</h4>
                                <div class="job-content">
                                <?php     
                                    if($my_jobs!=NULL):
                                    foreach ($my_jobs as $job): {?>
                                        <div class="box">
                                            <div class="left-box">
                                                <p class="name-member"><a href='<?= $vpath ?>project/<?php echo $job['project_id'];?>'><?php echo $job['project'];?></a></p>
                                                <p class="small-text">Hired by <?php echo $job['username'];?></p>
                                                <p><a href="#">Job Details</a><span class="line">|</span><a href="<?= $vpath ?>conversation/<?= $job['project_id']?>/<?= $job['user_id'] ?>/">Send Message</a></p>
                                            </div>
                                            <div class="right-box">
                                                <p class="time-week">4:00 of 20 hrs this week</p>
                                                <p class="small-text">@$<?php echo $job['bid_amount'];?>/hr = $<?php echo $job['paid_amount'];?></p>
                                                <a href="<?= $vpath ?>work_diary/<?= $job['project_id']?>" class="view-load">view work diary</a>
                                            </div>
                                        </div>
                                <?php } endforeach;else: echo 'no project';endif; ?>
                                </div>
                            </div>                      
                            <?php $my_jobs2 = get_my_job($_SESSION['user_id'],'F');?>                    
                            <div class="job-item">    
                                <h4 class="job-title">Fixed Price</h4>
                                <div class="job-content">
                                <?php     
                                    if($my_jobs2!=NULL):
                                        foreach ($my_jobs2 as $job): {?>
                                        <div class="box">
                                            <div class="left-box">
												<p class="name-member"><a href='<?= $vpath ?>project/<?php echo $job['project_id'];?>'><?php echo $job['project'];?></a></p>
                                                <p class="small-text">Hired by <?php echo $job['username'];?></p>
                                                <p><a href="#">Job Details</a><span class="line">|</span><a href="<?= $vpath ?>conversation/<?= $job['project_id']?>/<?= $job['user_id'] ?>/">Send Message</a></p>
                                            </div>
                                            <div class="right-box">
                                                <p class="time-of-price">$<?php echo $job['paid_amount'];?> paid of $<?php echo $job['bid_amount'];?> </p>
                                            </div>
                                        </div>
                                <?php } endforeach; else: echo 'no project';endif; ?>
                                </div>
                            </div>             
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>