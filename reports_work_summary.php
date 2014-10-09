<?php
include "includes/header.php";
?>

<div class="spage-container job_work_diary" id="reports_activity_summary_after">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
				<?php
					$parent = 'client_report';
					$current = 'reports_work_summary';
					$current_sub = '';
					get_child_menu($parent, $current, $current_sub);
				?>
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">
                    <div class="container">
                        <div class="time-zone">
                            <div class="from-time">
                                <p class="t-from">From</p>
                                <div class="datetime">
                                    <input type="text" id="form-time">
                                    <img class="clander-img" src="css/img/calender_icon.png" alt="">
                                </div>
                            </div>
                            <div class="to-time">
                                <p class="t-to">To</p>
                                <div class="datetime">
                                    <input type="text" id="to-time">
                                    <img class="clander-img" src="css/img/calender_icon.png" alt="">
                                </div>
                            </div>
                            <button class="bt-go">Go</button>
                        </div>
                    </div>
                    <div class="container">
                        <div class="team-period">
                            <p><span>Team:</span><span>myCS</span></p>
                            <p><span>Period:</span><span>18 August 2014 - 31 August 2014</span></p>
                        </div>
                        <div class="freelancer-active" id="report-work-summary">
                            <div class="row-title">                            
                                <p class="j-col1 text-bold">Activity</p>
                                <p class="j-col2 text-bold">Freelancer</p>
                                <p class="j-col3 text-bold">Total Hours</p>
                                <p class="j-col4 text-bold">Total $</p>
                            </div>
                            <div class="row-content">
                                <div class="left-box">Kim Moro</div>
                                <div class="right-box">
                                    <div class="j-row">
                                        <p class="j-col1">Working with website pages</p>
                                        <p class="j-col2">0:40</p>
                                        <p class="j-col3">$3.00</p>
                                    </div>
                                    <div class="j-row">
                                        <p class="j-col1">Working with website pages</p>
                                        <p class="j-col2">2:40</p>
                                        <p class="j-col3">$15.00</p>
                                    </div>
                                    <div class="j-row">
                                        <p class="j-col1">Working with website pages</p>
                                        <p class="j-col2">6:40</p>
                                        <p class="j-col3">$48.00</p>
                                    </div>  
                                    <div class="j-row bdbottom-0">
                                        <p class="j-col1">Working with website pages</p>
                                        <p class="j-col2">0:40</p>
                                        <p class="j-col3">$3.00</p>
                                    </div>
                                    <div id="report-total" class="j-row">
                                        <p class="j-col1"><span>Total for all activities</span></p>
                                        <p class="j-col2">6:40</p>
                                        <p class="j-col3">$48.00</p>
                                    </div>                              
                                </div>
                            </div>
                            <div class="row-content">
                            <div class="left-box">Kim Moro</div>
                            <div class="right-box">
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">0:40</p>
                                    <p class="j-col3">$3.00</p>
                                </div>
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">2:40</p>
                                    <p class="j-col3">$15.00</p>
                                </div>
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">6:40</p>
                                    <p class="j-col3">$48.00</p>
                                </div>  
                                <div class="j-row bdbottom-0">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">0:40</p>
                                    <p class="j-col3">$3.00</p>
                                </div>
                                <div id="report-total" class="j-row">
                                    <p class="j-col1"><span>Total for all activities</span></p>
                                    <p class="j-col2">6:40</p>
                                    <p class="j-col3">$48.00</p>
                                </div>                              
                            </div>
                        </div>
                        <div class="row-content">
                            <div class="left-box">Kim Moro</div>
                            <div class="right-box">
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">0:40</p>
                                    <p class="j-col3">$3.00</p>
                                </div>
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">2:40</p>
                                    <p class="j-col3">$15.00</p>
                                </div>
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">6:40</p>
                                    <p class="j-col3">$48.00</p>
                                </div>  
                                <div class="j-row bdbottom-0">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">0:40</p>
                                    <p class="j-col3">$3.00</p>
                                </div>
                                <div id="report-total" class="j-row">
                                    <p class="j-col1"><span>Total for all activities</span></p>
                                    <p class="j-col2">6:40</p>
                                    <p class="j-col3">$48.00</p>
                                </div>                              
                            </div>
                        </div>
                        <div class="row-content mrb-0">
                            <div class="left-box">Kim Moro</div>
                            <div class="right-box">
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">0:40</p>
                                    <p class="j-col3">$3.00</p>
                                </div>
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">2:40</p>
                                    <p class="j-col3">$15.00</p>
                                </div>
                                <div class="j-row">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">6:40</p>
                                    <p class="j-col3">$48.00</p>
                                </div>  
                                <div class="j-row bdbottom-0">
                                    <p class="j-col1">Working with website pages</p>
                                    <p class="j-col2">0:40</p>
                                    <p class="j-col3">$3.00</p>
                                </div>
                                <div id="report-total" class="j-row">
                                    <p class="j-col1"><span>Total for all activities</span></p>
                                    <p class="j-col2">6:40</p>
                                    <p class="j-col3">$48.00</p>
                                </div>                              
                            </div>
                        </div>
                            <div class="total-active">
                                <p class="j-col1">Total for all activities</p>
                                <p class="j-col2 text-bold">6:40</p>
                                <p class="j-col3 text-bold">$48.00</p>
                            </div>
                            <p class="report-note">Note: this report is updated every 30 minutes</p>
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