<?php
include "includes/header.php"; 
?>

<div class="spage-container job_work_diary" id="userSettings_ContactInfo">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
                <?php
                    if(check_Login_Worker($_SESSION['user_id'], $_SESSION['user_type'])) {
                        $parent = 'dashboard_sme';          
                        $current = 'notification_setting';
                        $current_sub = '';
                        get_child_menu($parent, $current, $current_sub);
                    } else {
                        $parent = 'dashboard_client';          
                        $current = 'notification_setting';
                        $current_sub = '';
                        get_child_menu($parent, $current, $current_sub);
                    }
                ?> 
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right"> 
                    <div class="userseting-notification">  
                        <p class="email-notification">Send email notification to kimoro2003@yahoo.com when...</p>
                        <div class="item">
                            <div class="title">
                                <p class="left-title">Message Center</p>
                                <p class="right-title">Email</p>
                            </div>
                            <div class="content someonce-send">
                                <p class="item-text">Someone sends me a message</p>
                                <P class="item-check"><span class="checkbox_icon"><input type="checkbox" class="sv-checkbox" value="" name="ended">
                                <i class="fa"></i></span></P>
                            </div>
                        </div>
                        <div class="item">
                            <div class="title">
                                <p>Recruiting</p>
                            </div>
                            <div class="content">
                                <div class="u-row">
                                    <p class="item-text">A job is posted or modified</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">A job application is received</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An interview is accepted or offer terms are modified </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An interview or offer is declined or withdrawn </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An offer is accepted</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">A job posting will expire soon </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">A job posting expired </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row bd-bt-0">
                                    <p class="item-text">No interviews have been initiated</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                            </div>
                        </div>                        

                        <div class="item">
                            <div class="title">
                                <p>Freelancer and Agency Job Applications</p>
                            </div>
                            <div class="content">
                                <div class="u-row">
                                    <p class="item-text">A job application is submitted</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An interview is initiated</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An offer or interview invitation is received </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An offer or interview invitation is withdrawn</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">A job application is rejected</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row bd-bt-0">
                                    <p class="item-text">A job I applied to is modified or canceled </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                
                            </div>
                        </div>

                        <div class="item">
                            <div class="title">
                                <p>Freelancer and Agency Job Applications</p>
                            </div>
                            <div class="content">
                                <div class="u-row">
                                    <p class="item-text">A job application is submitted</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An interview is initiated</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An offer or interview invitation is received </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">An offer or interview invitation is withdrawn</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">A job application is rejected</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">A job I applied to is modified or canceled </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                
                            </div>
                        </div>

                        <div class="item">
                            <div class="title">
                                <p>Contracts</p>
                            </div>
                            <div class="content">
                                <div class="u-row">
                                    <p class="item-text">A hire is made or a contract begins </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">Time logging begins</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">Contract terms are modified </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">A contract ends </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">A timelog is ready for review </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">Feedback changes are made </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">Daily snapshot of time recorded by your freelancers </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">Weekly billing digest </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row bd-bt-0">
                                    <p class="item-text">A contract is going to be automatically paused</p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>                                
                            </div>
                        </div>

                        <div class="item">
                            <div class="title">
                                <p>Groups & Invitations</p>
                            </div>
                            <div class="content">
                                <div class="u-row">
                                    <p class="item-text">Group membership events occur </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">Someone forwards me a freelancer's profile </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row">
                                    <p class="item-text">Someone sends me an invitation </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                                <div class="u-row bd-bt-0">
                                    <p class="item-text">Team access is revoked </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="title">
                                <p>Tips and Advice</p>
                            </div>
                            <div class="content">                                
                                <div class="u-row bd-bt-0">
                                    <p class="item-text">oDesk has a tip to help me start </p>
                                    <P class="item-check">
                                        <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended">
                                            <i class="fa"></i>
                                        </span>
                                    </P>
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
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>  
<?php include 'includes/footer.php'; ?>
