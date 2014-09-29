<?php
include "includes/header.php";
?>
<div class="spage-container recruit_savedFreelancers">
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
                    <div class="manageActive_content">    
                        <p class="track-contractor">Track contractor hours according to project, product or customer.</p>                       
                        <div class="box box1">
                            <img class="box-img" src="images/myteam/img1.png" alt=""/>
                            <p class="text-bold">Your Contracts</p>
                            <p class="box-icon plug_icon"><img src="images/myteam/plug.png" alt=""></p>
                        </div>
                         <div class="box box2">
                            <img class="box-img" src="images/myteam/img2.png" alt=""/>
                            <p class="text-bold">Track time to actives you create</p>
                            <p class="small-text">(Such as "custom ABC", "Project XYZ" or "Desgin")</p>                            
                        </div>
                         <div class="box box3">
                            <img class="box-img" src="images/myteam/img3.png" alt=""/>
                            <p class="text-bold">Give you better reports!</p>
                            <p class="box-icon equal_icon"><img src="images/myteam/equal.png" alt=""></p>
                        </div>
                        <p class="add-active"><a href="#">Add Actives</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>