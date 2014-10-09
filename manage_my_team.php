<?php
include "includes/header.php";
?>
    <div class="spage-container managemyteam">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
				   <!-- tabs left -->
                    <?php
                        $parent = 'manage_my_team';
                        $current = 'my_team';
                        $current_sub = 'hired';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
                    <!-- tabs left -->
                 
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
                        <div class="managemyteam-content">
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim Moro</strong> Sr. Designer</span>
                                <span class="mt-address">It's Mon 12:46 AM<br/>in Philippines </span>
                                </p>
                                <p class="j-col2">
                                    <img src="css/img/ratesskill.jpg" alt=""/>
                                    <span class="c-blue">Last Worked about an hour ago</span>
                                    working with Raj
                                </p>
                                <p class="j-col3"><span class="c-blue">7:10 (95.33)</span>This week</p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim Moro</strong> Sr. Designer</span>
                                <span class="mt-address">It's Mon 12:46 AM<br/>in Philippines </span>
                                </p>
                                <p class="j-col2">
                                    <img src="css/img/ratesskill.jpg" alt=""/>
                                    <span class="c-blue">Last Worked about an hour ago</span>
                                    working with Raj
                                </p>
                                <p class="j-col3"><span class="c-blue">7:10 (95.33)</span>This week</p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim Moro</strong> Sr. Designer</span>
                                <span class="mt-address">It's Mon 12:46 AM<br/>in Philippines </span>
                                </p>
                                <p class="j-col2">
                                    <img src="css/img/ratesskill.jpg" alt=""/>
                                    <span class="c-blue">Last Worked about an hour ago</span>
                                    working with Raj
                                </p>
                                <p class="j-col3"><span class="c-blue">7:10 (95.33)</span>This week</p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim Moro</strong> Sr. Designer</span>
                                <span class="mt-address">It's Mon 12:46 AM<br/>in Philippines </span>
                                </p>
                                <p class="j-col2">
                                    <img src="css/img/ratesskill.jpg" alt=""/>
                                    <span class="c-blue">Last Worked about an hour ago</span>
                                    working with Raj
                                </p>
                                <p class="j-col3"><span class="c-blue">7:10 (95.33)</span>This week</p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim Moro</strong> Sr. Designer</span>
                                <span class="mt-address">It's Mon 12:46 AM<br/>in Philippines </span>
                                </p>
                                <p class="j-col2">
                                    <img src="css/img/ratesskill.jpg" alt=""/>
                                    <span class="c-blue">Last Worked about an hour ago</span>
                                    working with Raj
                                </p>
                                <p class="j-col3"><span class="c-blue">7:10 (95.33)</span>This week</p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
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
<script>
    $(function() {
        $('#job_tabs li a').click(function (e) {
            e.preventDefault()
            $(this).tab('show');            
        });
        $(".checkbox_icon input[type='checkbox']").click(function(){ //alert('true');
            $(".checkbox_icon .fa").addClass("fa-chevron-down");
        });
        $(".checkbox_icon .fa").click(function(){
            $(this).removeClass("fa-chevron-down");
             $(".checkbox_icon input[type='checkbox']").attr('checked', false); 
        })
    });
</script>
<?php include 'includes/footer.php'; ?>