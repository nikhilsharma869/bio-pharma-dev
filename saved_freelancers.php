<?php
include "includes/header.php";
$current_page = "Saved Freelancers";
$cur_par_menu = "saved_freelancers";
$cur_child_menu = "";



   // $sql = "select * from  " . $prev . "user left join " . $prev . "wishlist on " . $prev . "wishlist.uid=" . $prev . "user.user_id  where  status='Y' and " . $prev . "wishlist.uid=" . $prev . "user.user_id and " . $prev . "wishlist.user_id=" . $_SESSION['user_id'] . " ";
?>
<div class="spage-container recruit_savedFreelancers">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
                <?php require("includes/left_menu_job_client.php");?>
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">                                                              
                    <div class="recruit_saved_content">    
                        <div class="item">
                            <div class="left-item">
                                <img src="images/myteam/budget_bott.jpg" alt=""/>
                            </div>
                            <div class="right-item">
                                <p class="bt-contact"><a href="#">Contact</a></p>
                                <h4 class="title-h4">Kim M.</h4>
                                <p class="text-bold">Senior Adobe Illustrator, Photoshop and InDesign</p>
                                <p>To provide my clients the best of my designs. My strengths are Adobe based
                                    applications especially Adobe Illustrator, Photoshop and Indesign. I have a wide
                                    knowledge in Pre-Press technology and also in large format printers.</p>
                                    <div id="recruit_saved_tabs">
                                        <ul>
                                            <li class="active"><a data-toggle="tab" href="#tabs-1">adobe-photoshop  </a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-2">adobe-illustrator</a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-3">corel-draw</a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-4">adobe-flash</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="tabs-1" class="tab-pane fade tab-first active in">                                   
                                                <p>$15.00 /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago  -  Tests: 28  - </p>
                                                <p>Portfolio: 67<br/>Groups: PBwiki Professionals, Yahoo Web Hosting Designer</p> 
                                            </div>
                                            <div id="tabs-2" class="tab-pane fade">                                   
                                                <p>$15.00 /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago  -  Tests: 28  - </p>
                                                <p>Portfolio: 67<br/>Groups: PBwiki Professionals, Yahoo Web Hosting Designer</p> 
                                            </div>
                                            <div id="tabs-3" class="tab-pane fade">                                   
                                                <p>$15.00 /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago  -  Tests: 28  - </p>
                                                <p>Portfolio: 67<br/>Groups: PBwiki Professionals, Yahoo Web Hosting Designer</p> 
                                            </div>
                                            <div id="tabs-4" class="tab-pane fade">                                   
                                                <p>$15.00 /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago  -  Tests: 28  - </p>
                                                <p>Portfolio: 67<br/>Groups: PBwiki Professionals, Yahoo Web Hosting Designer</p> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        <div class="item">
                            <div class="left-item">
                                <img src="images/myteam/budget_bott.jpg" alt=""/>
                            </div>
                            <div class="right-item">
                                <p class="bt-contact"><a href="#">Contact</a></p>                               
                                <h4 class="title-h4">Kim M.</h4>
                                <p class="text-bold">Senior Adobe Illustrator, Photoshop and InDesign</p>
                                <p>To provide my clients the best of my designs. My strengths are Adobe based
                                    applications especially Adobe Illustrator, Photoshop and Indesign. I have a wide
                                    knowledge in Pre-Press technology and also in large format printers.</p>
                                    <div id="recruit_saved_tabs">
                                        <ul>
                                            <li class="active"><a data-toggle="tab" href="#tabs-5">adobe-photoshop  </a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-6">adobe-illustrator</a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-7">corel-draw</a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-8">adobe-flash</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="tabs-5" class="tab-pane fade tab-first active in">                                   
                                                <p>$15.00 /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago  -  Tests: 28  -<br/>
                                                Portfolio: 67<br/>Groups: PBwiki Professionals, Yahoo Web Hosting Designer</p> 
                                            </div>
                                            <div id="tabs-6" class="tab-pane fade">                                   
                                                <p>$15.00 /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago  -  Tests: 28  -<br/>
                                                Portfolio: 67<br/>Groups: PBwiki Professionals, Yahoo Web Hosting Designer</p> 
                                            </div>
                                            <div id="tabs-7" class="tab-pane fade">                                   
                                                <p>$15.00 /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago  -  Tests: 28  -<br/>
                                                Portfolio: 67<br/>Groups: PBwiki Professionals, Yahoo Web Hosting Designer</p> 
                                            </div>
                                            <div id="tabs-8" class="tab-pane fade">                                   
                                                <p>$15.00 /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago  -  Tests: 28  -<br/>
                                                Portfolio: 67<br/>Groups: PBwiki Professionals, Yahoo Web Hosting Designer</p> 
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
    </div>  
</div>
<?php include 'includes/footer.php'; ?>