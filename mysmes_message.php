<?php
include "includes/header.php";
?>
    <div class="spage-container managemyteam_message">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                     <?php
                        $parent = 'manage_my_team';
                        $current = 'my_team';
                        $current_sub = 'messages';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
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
                                <img class="mt-img" src="images/myteam/person.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Victor Jr San Lorenzo</strong></span>
                                <span class="mt-address">E-Commerce Manager/Data Entry Professional / Recruitment Assistant </span>
                                </p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/person.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Victor Jr San Lorenzo</strong></span>
                                <span class="mt-address">E-Commerce Manager/Data Entry Professional / Recruitment Assistant </span>
                                </p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/person.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Victor Jr San Lorenzo</strong></span>
                                <span class="mt-address">E-Commerce Manager/Data Entry Professional / Recruitment Assistant </span>
                                </p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/person.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Victor Jr San Lorenzo</strong></span>
                                <span class="mt-address">E-Commerce Manager/Data Entry Professional / Recruitment Assistant </span>
                                </p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/person.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Victor Jr San Lorenzo</strong></span>
                                <span class="mt-address">E-Commerce Manager/Data Entry Professional / Recruitment Assistant </span>
                                </p>
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
<?php include 'includes/footer.php'; ?>