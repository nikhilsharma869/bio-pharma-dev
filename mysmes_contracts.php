<?php
include "includes/header.php";
?>
    <div class="spage-container manageMyTeam_contracts">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <?php
                        $parent = 'manage_my_team';
                        $current = 'my_team';
                        $current_sub = 'contracts';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right sv-plus">
                        <div class="search" id="ds-team">       
                            <label class="lb-team">Team</label>         
                            <div class="sv-dropdown">                                
                                <div class="sv-dropSelect">MyCS</div>
                                <ul>
                                    <li>1</li>
                                    <li>2</li>
                                    <li>3</li>
                                    <li>4</li>
                                </ul>
                            </div>
                            <form name="search-frm" action="" method="post">
                                <input type='text' name="s" placeholder="Enter Name, Title or Team">
                                <span class="checkbox_icon"><input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                <i class="fa"></i></span>
                                <label>Ended Contacts</label>
                            </form>
                        </div>
                        <div class="page-nav">
                            <ul class="nav-top">
                                <li class="nav-prev"><a href="#">Previous</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">...</a></li>
                                <li><a href="#">9</a></li>
                                <li><a href="#">10</a></li>
                                <li class="nav-next"><a href="#">Next</a></li>
                            </ul>
                        </div>
                        <div class="row-title">                            
                            <p class="j-col1 text-bold">Freelancer</p>
                            <p class="j-col2 text-bold">Time Period</p>
                            <p class="j-col3 text-bold">Terms</p>
                        </div>
                        <div class="row-content">
                            <div class="j-row">
                                <p class="j-col1">Larry Cueto<br/><span class="small-text">Excel Data Entry</span></p>
                                <p class="j-col2">Aug 03, 2014 - Present</p>
                                <p class="j-col3"><span>$2.22/hour<br/>20 maximum hours/week</span>
                                <a href="" class="work-diary">Work Diary</a></p>
                            </div>
                             <div class="j-row">
                                <p class="j-col1">Larry Cueto<br/><span class="small-text">Excel Data Entry</span></p>
                                <p class="j-col2">Aug 03, 2014 - Present</p>
                                <p class="j-col3"><span>$2.22/hour<br/>20 maximum hours/week</span>
                                <a href="" class="work-diary">Work Diary</a></p>
                            </div>
                             <div class="j-row">
                                <p class="j-col1">Larry Cueto<br/><span class="small-text">Excel Data Entry</span></p>
                                <p class="j-col2">Aug 03, 2014 - Present</p>
                                <p class="j-col3"><span>$2.22/hour<br/>20 maximum hours/week</span>
                                <a href="" class="work-diary">Work Diary</a></p>
                            </div>
                             <div class="j-row">
                                <p class="j-col1">Larry Cueto<br/><span class="small-text">Excel Data Entry</span></p>
                                <p class="j-col2">Aug 03, 2014 - Present</p>
                                <p class="j-col3"><span>$2.22/hour<br/>20 maximum hours/week</span>
                                <a href="" class="work-diary">Work Diary</a></p>
                            </div>
                             <div class="j-row">
                                <p class="j-col1">Larry Cueto<br/><span class="small-text">Excel Data Entry</span></p>
                                <p class="j-col2">Aug 03, 2014 - Present</p>
                                <p class="j-col3"><span>$2.22/hour<br/>20 maximum hours/week</span>
                                <a href="" class="work-diary">Work Diary</a></p>
                            </div>
                             <div class="j-row">
                                <p class="j-col1">Larry Cueto<br/><span class="small-text">Excel Data Entry</span></p>
                                <p class="j-col2">Aug 03, 2014 - Present</p>
                                <p class="j-col3"><span>$2.22/hour<br/>20 maximum hours/week</span>
                                <a href="" class="work-diary">Work Diary</a></p>
                            </div>
                             <div class="j-row">
                                <p class="j-col1">Larry Cueto<br/><span class="small-text">Excel Data Entry</span></p>
                                <p class="j-col2">Aug 03, 2014 - Present</p>
                                <p class="j-col3"><span>$2.22/hour<br/>20 maximum hours/week</span>
                                <a href="" class="work-diary">Work Diary</a></p>
                            </div>
                        </div>
                        <div class="page-nav">
                            <ul class="nav-bottom">
                                <li class="nav-prev"><a href="#">Previous</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">...</a></li>
                                <li><a href="#">9</a></li>
                                <li><a href="#">10</a></li>
                                <li class="nav-next"><a href="#">Next</a></li>
                            </ul>
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