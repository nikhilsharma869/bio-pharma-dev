<?php
include "includes/header.php";
?>

<div class="spage-container" id="userSettings_Teams">
    <div class="main_div2">
        <div class="inner-middle">    
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
                <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                    <p class="billing text-bold">Billing</p>
                    <li ><a href="<?= $vpath ?>UserSettings_PaymentMethods.html">Payment Methods</a></li>                        
                    <P class="company-seting text-bold">Company Setting</P>
                    <li><a href="<?= $vpath ?>postjob.html">Company Info</a></li>
                    <li class="active"><a href="<?= $vpath ?>UserSettings_Teams.html">Teams</a></li>
                    <li><a href="<?= $vpath ?>UserSettings_StaffPermissions.html">Staff & Permissions</a></li>   
                    <P class="company-seting text-bold">User Settings</P>                     
                    <li><a href="<?= $vpath ?>postjob.html">Contact Info</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">My Freelancer Profile</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">My Teams</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">Notification Settings</a></li>
                    <a href="#" class="create-companay">Create a Company</a>
                </ul>                
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">                    
                    <div class="usersetting-csteams">
                        <div class="tree-teams">
                            <ul class="t-root">
                                <li>
                                    <span class="v-t-team-hr v-t-bottom v-t-first"></span> 
                                    <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                    <ul class="t-sub">
                                        <li>
                                            <span class="t-team-hr t-right-hr"></span>                                               
                                            <span class="v-t-team-hr v-t-top"></span> 
                                            <span class="v-t-team-hr v-t-bottom"></span>                                        
                                            <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                            <ul>
                                                <li>
                                                    <span class="v-t-team-hr v-t-top"></span>
                                                    <span class="t-team-hr t-right-hr"></span>
                                                    <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                                </li>
                                                <li>
                                                    <span class="v-t-team-hr v-t-top"></span>
                                                    <span class="t-team-hr t-left-hr"></span>
                                                    <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <span class="v-t-team-hr v-t-top"></span>
                                            <span class="t-team-hr t-right-hr"></span>
                                            <span class="t-team-hr t-left-hr"></span>
                                            <span class="v-t-team-hr v-t-bottom"></span> 
                                            <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                            <ul>
                                                <li>
                                                    <span class="v-t-team-hr v-t-top"></span>
                                                    <span class="t-team-hr t-right-hr"></span>
                                                    <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                                </li>
                                                <li>
                                                    <span class="v-t-team-hr v-t-top"></span>
                                                    <span class="t-team-hr t-left-hr"></span>
                                                    <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <span class="v-t-team-hr v-t-top"></span>
                                            <span class="t-team-hr t-left-hr"></span>
                                            <span class="v-t-team-hr v-t-bottom"></span> 
                                            <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                            <ul>
                                                <li>
                                                    <span class="v-t-team-hr v-t-top"></span>
                                                    <span class="t-team-hr t-right-hr"></span>
                                                    <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                                </li>
                                                <li>
                                                    <span class="v-t-team-hr v-t-top"></span>
                                                    <span class="t-team-hr t-left-hr"></span>
                                                    <img src="<?= $vpath ?>images/ava_team_default.jpg">
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <p style="text-align: center; clear:both;">
                            Need to hire freelancers into departments with different managers?
                            <br>Want to assign visibility of freelancers to individual colleagues?
                            <br>Have recruiters that are responsible for specific sets of job postings?
                        </p>
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
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>  
<?php include 'includes/footer.php'; ?>
