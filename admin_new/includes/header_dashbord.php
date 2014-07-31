   <?php include("includes/header.php"); ?>
    <script src="js/pages/dashboard.js"></script>
   
    <!-- Init plugins only for page -->
 <body>
    <header id="header">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <a class="navbar-brand" href="<?=$vpath?>"><img src="<?=$vpath?>images/logo.png" alt="<?=$dotcom?>"  style="margin-left:-6px; width:110px; height:50px;"></a>
            <button type="button" class="navbar-toggle btn-danger" data-toggle="collapse" data-target="#navbar-to-collapse">
                <span class="sr-only">Toggle right menu</span>
                <i class="icon16 i-arrow-8"></i>
            </button>          
			
            <div class="collapse navbar-collapse" id="navbar-to-collapse">  
          
                <ul class="nav navbar-nav pull-right">
           
                    <li class="divider-vertical"></li>
                    <li class="dropdown user">
                         <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                            <img src="images/avatars/admin.jpg" alt="sugge">
                            <span class="more"><i class="icon16 i-arrow-down-2"></i></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a href="<?=$vpath?>" target="_blank" class=""><i class="icon16 i-cogs"></i> View Site</a></li>
                            
                           <li role="presentation"><a href="<?=$vpath.$admin_folder?>/changepassword.php" class=""><i class="icon16 i-exit"></i> Change Password</a></li>
                           
                            <li role="presentation"><a href="<?=$vpath.$admin_folder?>/index.php?logout=1" class=""><i class="icon16 i-exit"></i> Logout</a></li>
                        </ul>
                    </li>
                    <li class="divider-vertical"></li>
                </ul>
            </div><!--/.nav-collapse -->
        </nav>
    </header> <!-- End #header  -->