<?php
include "includes/header.php";
?>
    <div class="spage-container managemyteam">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <?php
                        $parent = 'manage_my_team';
                        $current = 'my_team';
                        $current_sub = 'saved';
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
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim M.</strong></span>
                                <span class="mt-address">Senior Adobe Illustrator, Photoshop<br/>and InDesign</span>
                                </p>
                                <p class="j-col2">
                                    <span>Saved Nov 20 2012</span>
                                    <a href="#" class="c-blue edit-remove">Edit or Remove</a>
                                </p>
                                <p class="j-col3"></p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim M.</strong></span>
                                <span class="mt-address">Senior Adobe Illustrator, Photoshop<br/>and InDesign</span>
                                </p>
                                <p class="j-col2">
                                    <span>Saved Nov 20 2012</span>
                                    <a href="#" class="c-blue edit-remove">Edit or Remove</a>
                                </p>
                                <p class="j-col3"></p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim M.</strong></span>
                                <span class="mt-address">Senior Adobe Illustrator, Photoshop<br/>and InDesign</span>
                                </p>
                                <p class="j-col2">
                                    <span>Saved Nov 20 2012</span>
                                    <a href="#" class="c-blue edit-remove">Edit or Remove</a>
                                </p>
                                <p class="j-col3"></p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim M.</strong></span>
                                <span class="mt-address">Senior Adobe Illustrator, Photoshop<br/>and InDesign</span>
                                </p>
                                <p class="j-col2">
                                    <span>Saved Nov 20 2012</span>
                                    <a href="#" class="c-blue edit-remove">Edit or Remove</a>
                                </p>
                                <p class="j-col3"></p>
                                <p class="j-col4"><a href="#" class="mt-action">Actions</a></p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="images/myteam/budget_bott.jpg" alt=""/>
                                <span class="mt-title"><strong class="c-blue">Kim M.</strong></span>
                                <span class="mt-address">Senior Adobe Illustrator, Photoshop<br/>and InDesign</span>
                                </p>
                                <p class="j-col2">
                                    <span>Saved Nov 20 2012</span>
                                    <a href="#" class="c-blue edit-remove">Edit or Remove</a>
                                </p>
                                <p class="j-col3"></p>
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