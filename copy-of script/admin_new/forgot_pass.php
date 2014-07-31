<?php include("includes/header.php"); ?>
<?php
/* if($_SESSION['logged_in']==1){echo "<script> window.location='dashboard.php'; </script>";}else{echo "<script> window.location='index.php'; </script>";}
*/?>

<script language="javascript">
function ChnageCaptchText(captchaid,captchaform,sell)
{
	document.getElementById(captchaid).src='<?=$vpath?>captcha/captcha.php?'+Math.random();
	//document.getElementById(captchaform).focus();
	return true;
}</script>

  <head>
    <meta charset="utf-8">
    <title>Genyx admin v1.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="SuggeElson" />
    <meta name="description" content="Genyx admin template - new premium responsive admin template. This template is designed to help you build the site administration without losing valuable time.Template contains all the important functions which must have one backend system.Build on great twitter boostrap framework" />
    <meta name="keywords" content="admin, admin template, admin theme, responsive, responsive admin, responsive admin template, responsive theme, themeforest, 960 grid system, grid, grid theme, liquid, jquery, administration, administration template, administration theme, mobile, touch , responsive layout, boostrap, twitter boostrap" />
    <meta name="application-name" content="Genyx admin template" />

    <!-- Headings -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700' rel='stylesheet' type='text/css'>
    <!-- Text -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' />

     <!--[if lt IE 9]>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:800" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:400" rel="stylesheet" type="text/css" />
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans:700" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!-- Core stylesheets do not remove -->
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="css/bootstrap/bootstrap-theme.css" rel="stylesheet" />
    <link href="css/icons.css" rel="stylesheet" />

    <!-- Plugins stylesheets -->
    <link href="js/plugins/forms/uniform/uniform.default.css" rel="stylesheet" /> 

    <!-- app stylesheets -->
    <link href="css/app.css" rel="stylesheet" /> 

    <!-- Custom stylesheets ( Put your own changes here ) -->
    <link href="css/custom.css" rel="stylesheet" /> 

    <!--[if IE 8]><link href="css/ie8.css" rel="stylesheet" type="text/css" /><![endif]-->

    <!-- Force IE9 to render in normal mode -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="images/ico/favicon.png">
    
    <!-- Le javascript
    ================================================== -->
    <!-- Important plugins put in all pages -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>  
    <script src="js/conditionizr.min.js"></script>  
    <script src="js/plugins/core/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="js/plugins/core/jrespond/jRespond.min.js"></script>
    <script src="js/jquery.genyxAdmin.js"></script>

    <!-- Form plugins -->
    <script src="js/plugins/forms/uniform/jquery.uniform.min.js"></script>
    <script src="js/plugins/forms/validation/jquery.validate.js"></script>

    <!-- Init plugins -->
    <script src="js/app.js"></script><!-- Core js functions -->
    <script src="js/pages/login.js"></script><!-- Init plugins only for page -->
<!--- Validation-------->
<!--<script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
<script language="javascript" type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script>
<script>
$(function() {
$( "#validate" ).validate({
rules: {
email: {
required: true,

},


},

messages: {
email: {
required: "Please Enter User Id",
},

}
});

});
</script>


<!----------- validation ------------->  
<script type="text/javascript" src="<?=$vpath?>fancybox/jquery.fancybox-1.3.4.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$vpath?>fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script>
//jQuery.noConflict();
$(document).ready( function () {
$(".fancybox").fancybox();
});
</script>

  </head>
  <body>
    <div class="container-fluid">
        <div id="login">
            <div class="login-wrapper" data-active="log">
               <a class="navbar-brand" href="dashboard.php"><img src="images/logodark.png" alt="Genyx admin" class="img-responsive"></a>
                <div id="log">
                
                <!--    <div id="avatar">
                        <img src="images/avatars/suggebig.jpg" alt="SuggeElson" class="img-responsive">-->
                    </div>
                    <div class="page-header">
                        <h3 class="center">Forgot Password</h3>
                    </div>
                    <form role="form" id="validate" class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>" method="post">
                        <div class="row">
                            <div class="form-group relative">
                                <div class="icon"><i class="icon20 i-user"></i></div>
                                <input class="form-control" type="email" name="email" id="user" placeholder="Email Id " value="">
                                
                            </div><!-- End .control-group  -->
                            
                         
                            
                            <div class="form-group relative">
                             
                                <button id="loginBtn" type="submit" class="btn btn-primary pull-right col-lg-5">Send</button>
                            </div>
                        </div><!-- End .row-fluid  -->
                        
                    </form>
              
                
           <div id="bar" data-active="log">
         
            </div>
            <div class="clearfix"></div>
        </div>
  
    </div>
 
    </div>
  </body>    
</html>
<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
	if($_POST['code']==$_SESSION['captcha']){
$chk_user=mysql_fetch_assoc(mysql_query("select admin_id from ".$prev."admin where password='".md5($_POST['password'])."'  and username='".$_POST['user']."'"));

if($_POST['remember']==1){
    setcookie("remmeber","1",time()+3600*24*2);
}

if($chk_user['admin_id']!=NULL){
	$_SESSION['logged_in']=1;
	if($_SESSION['logged_in']=1){
	   	   echo "<script> window.location='dashboard.php'; </script>";
	}
}
	}
}
?>