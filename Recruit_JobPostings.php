<?php
include "includes/header.php";
?>
    <div class="spage-container recruit_findFreelancers">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="<?= $vpath ?>postjob.html">Job Postings</a>
                            
                        </li>                        
                        <li><a href="<?= $vpath ?>postjob.html">Post a Job</a></li>
                        <li><a href="<?= $vpath ?>postjob.html">Find Freelancers</a></li>
                        <li><a href="<?= $vpath ?>postjob.html">Saved Freelancers</a></li>                        
                    </ul>
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right">
                        <div class="search-team">
                            <form name="search-frm" action="" method="post">
                                <input type='text' name="s" placeholder="Search for Freelancers">                                
                                <input type="submit" value="" name="submit">
                            </form>
                        </div>                      
                        <div class="open-jobs">My Open Jobs</div>
                        <div class="jobPosting-content">    
                            <div class="item">
                                <h3 class="title-h3">Excel Data Entry</h3>
                                <p class="fixed-price">Fixed Price<span class="line">|</span>$25
                                <span class="line">|</span>1 day ago
                                <span class="line">|</span>29 days left
                                <span class="line">|</span>20 proposals</p>
                                <p>Need an efficient Photoshop and illustrator personnel for long term jobs especially illustrator
based! Will hire by tomorrow.</p>
                                <a href="#" class="more">More</a>
                            </div>
                            <div class="item">
                                <h3 class="title-h3">Excel Data Entry</h3>
                                <p class="fixed-price">Fixed Price<span class="line">|</span>$25
                                <span class="line">|</span>1 day ago
                                <span class="line">|</span>29 days left
                                <span class="line">|</span>20 proposals</p>
                                <p>Need an efficient Photoshop and illustrator personnel for long term jobs especially illustrator
based! Will hire by tomorrow.</p>
                                <a href="#" class="more">More</a>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>