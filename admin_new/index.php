<?php
session_start();
require_once("includes/header.php");

?>
 <body>
  <?php
if($_GET['logout']==1){
$_SESSION['logged_in']=NULL;
        $_COOKIE['remember']=NULL;
		echo "<script> window.location='".$vpath."admin_new/index.php'; </script>";
}

if($_SESSION['logged_in']){
	 if($_SESSION['logged_in']==1){echo "<script>window.location='".$vpath."admin_new/dashboard.php'; </script>";
	 }
	
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	if($_POST['code']==$_SESSION['captcha']){
     $sql = "SELECT admin_id,type FROM ".$prev."admin WHERE password='".md5($_POST['password'])."'  AND username='".mysql_real_escape_string($_POST['user'])."' AND `type`='X'";

	$qry = mysql_query($sql);
	$total = @mysql_num_rows($qry);
    $chk_user= @mysql_fetch_assoc($qry);
	

//print_r($chk_user);exit;

if($_POST['remember']==1){
    setcookie("remmeber","1",time()+3600*24*2);
}

if($chk_user['admin_id']!=NULL){
	$_SESSION['logged_in']=1;
  $_SESSION['admin_id']=$chk_user['admin_id'];
   $_SESSION['type']=$chk_user['type'];
 
  	if($_SESSION['logged_in']==1){
	   	   echo "<script> window.location='dashboard.php'; </script>";
		  
	}
}
else {$_SESSION['error_msg'] = 'Username Or Password Does Not Match'; }
}else{$_SESSION['error_msg'] ='wrong security code. Try again';}
}
?>
   <div class="container-fluid">
        <div id="login">
            <div class="login-wrapper" data-active="log">
               <a class="navbar-brand" href="<?=$vpath?>"><?=$dotcom_site?> </a>
                <div id="log">
                    <div id="avatar">
                        <img src="images/logo.png" alt="admin" class="img-responsive" style="width:90px; height:80px">
                    </div>
                    <div class="page-header">
                        <h3 class="center">Please login</h3>
                    </div>
                    <form  id="login-form" class="form-horizontal" action="" method="post">
                        <div class="row">
						<?php if ($_SESSION['error_msg'] != '') { ?>
                    <div id="error" style="background-color:red; border-radius:4px; width:99%; float:left; margin:0 17px 7px 0; padding:5px; color:#FFF; font-size:14px; font-weight:600; text-align:center; box-shadow:4px 4px 4px #999999;">
    <?php echo $_SESSION['error_msg'];
    $_SESSION['error_msg'] = ''; ?>
                    </div>
    <?php
}
?>
                            <div class="form-group relative">
                                <div class="icon"><i class="icon20 i-user"></i></div>
                                <input class="form-control" type="text" name="user" id="user" placeholder="Username" value="" />
                                
                            </div><!-- End .control-group  -->
                            <div class="form-group relative">
                                <div class="icon"><i class="icon20 i-key"></i></div>
                                <input class="form-control" type="password" name="password" id="password" placeholder="Password" value="" />
                                
                            </div><!-- End .control-group  -->
						  <div class="form-group relative">
                            <img src="<?=$vpath?>captcha/captcha.php" id="captcha" name="captcha" alt="Captcha" />
                             <a onClick="ChnageCaptchText('captcha','captcha-form','');" id="change_image" style="position:absolute;top:20px;left:239px;cursor:pointer"> Change Security code  </a>
						 </div><!-- End .control-group  -->
						 <div class="form-group relative"> 
                           <div class="icon"><i class="icon20 i-key"></i></div>
                            <input type="text" value="" name="code" id="code" class="form-control" placeholder="Security Code"  />   &nbsp; &nbsp; &nbsp; &nbsp;
                             <!--<label> Enter Security Code </label>-->
							 <br/>    
	
								<?php  if($captchaerror){echo"<br /><span class='lnkred'><b>".$captchaerror."</b></span><br>";}?>
                            </div>
                            <div class="form-group relative">
                                <button id="loginBtn" type="submit" name="SBMT" class="btn btn-primary pull-left col-lg-5">Login</button>
                            </div>
                        </div><!-- End .row-fluid  -->
                    </form>
                    
                </div>
                
            </div>
           
            <div class="clearfix"></div>
        </div>
    </div>
  </body>
 
