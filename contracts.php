<?php
include "includes/header.php";
?>
    <div class="spage-container contracts">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <h3 class="title-page">Contracts</h3>
                    <?php
                        $parent = 'my_job';
                        $current = 'contracts';
                        $current_sub = '';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right">
                        <div class="search">
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
                        <div class="contract-title">                            
                            <p class="j-col1 text-bold">Contracts</p>
                            <p class="j-col2 text-bold">Time Period</p>
                            <p class="j-col3 text-bold">Terms</p>
                        </div>
                        <div class="contract-content">
                            <div class="j-row">
                                <p class="j-col1">Sr. Designer - myCS</p>
                                <p class="j-col2">May 14, 2014 - Present</p>
                                <p class="j-col3"><span>$13.50/hour 1 maximum hours/week</span>
                                <a href="">Work Diary</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Sr. Designer - myCS</p>
                                <p class="j-col2">May 14, 2014 - Present</p>
                                <p class="j-col3"><span>$13.50/hour 1 maximum hours/week</span>
                                <a href="">Work Diary</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Sr. Designer - myCS</p>
                                <p class="j-col2">May 14, 2014 - Present</p>
                                <p class="j-col3"><span>$13.50/hour 1 maximum hours/week</span>
                                <a href="">Work Diary</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Sr. Designer - myCS</p>
                                <p class="j-col2">May 14, 2014 - Present</p>
                                <p class="j-col3"><span>$13.50/hour 1 maximum hours/week</span>
                                <a href="">Work Diary</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Sr. Designer - myCS</p>
                                <p class="j-col2">May 14, 2014 - Present</p>
                                <p class="j-col3"><span>$13.50/hour 1 maximum hours/week</span>
                                <a href="">Work Diary</a></p>
                            </div>
                            <div class="j-row last-item">
                                <p class="j-col1">Sr. Designer - myCS</p>
                                <p class="j-col2">May 14, 2014 - Present</p>
                                <p class="j-col3"><span>$13.50/hour 1 maximum hours/week</span>
                                <a href="">Work Diary</a></p>
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
<?php include 'includes/footer.php'; ?>