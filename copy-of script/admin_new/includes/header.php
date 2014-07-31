<?php
require_once("../configs/config.php");
require_once("../configs/path.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
   <title><?php echo $dotcom; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="scriptgiant" />
    <meta name="description" content="just dial clone" />
    <meta name="keywords" content="just, admin template, admin theme, responsive, responsive admin, responsive admin template, clone" />
    <meta name="application-name" content="just dial clone" />

    <!-- Headings -->
    <link href="<?=$vpath?>/favicon.ico" rel="shortcut icon" />
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
   <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap/bootstrap.js"></script>  
    <script src="js/conditionizr.min.js"></script>  
    <script src="js/plugins/core/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="js/plugins/core/jrespond/jRespond.min.js"></script>
    <!-- Form plugins -->
	<script src="js/jquery.genyxAdmin.js"></script>
    <script src="js/plugins/forms/uniform/jquery.uniform.min.js"></script>
    <script src="js/plugins/forms/validation/jquery.validate.js"></script>
	
	<script src="js/jquery.easy-pie-chart.js"></script>

    <!-- Init plugins -->
    <script src="js/app.js"></script><!-- Core js functions -->
    <script src="js/pages/login.js"></script><!-- Init plugins only for page -->
    <script type="text/javascript" language="javascript">
function ChnageCaptchText(captchaid,captchaform,sell)
{
	document.getElementById(captchaid).src='<?= $vpath?>captcha/captcha.php?'+Math.random();
	document.getElementById(captchaform).focus();
	return true;
}
</script>

  </head>