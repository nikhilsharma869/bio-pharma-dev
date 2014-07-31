<?php
require_once("includes/header.php");
if(isset($_POST[recoverpassword]))
{
  //print_r($_POST);exit;
    $flag="";
	//echo "select * from " . $prev . "admin where  email=". $_POST[email] ." and username=".$_POST[user];exit;
	$r=mysql_query("select * from " . $prev . "admin where  email='".mysql_real_escape_string($_POST['emailid']) ."' and username='".mysql_real_escape_string($_POST['username'])."'");
    echo mysql_error();
	if(@mysql_num_rows($r))
	 {
         $a=mt_rand();

		 $r=mysql_query("update " . $prev . "admin set password ='" .md5( $a ). "' where email='" . mysql_real_escape_string($_POST[emailid]) . "'");
		// echo mysql_error();
		 //$rr=mysql_query("select * from " . $prev . "admin");
	  	 //$pass=@mysql_result($rr,0,"pass");
         $flag="Q";
		 $admin_mail= $setting[admin_mail];
		 $email=$_POST[emailid];
         $subject="Admin Password : " . $dotcom;
         $message="Admin Password for " . $dotcom . "/admin : " . $a;
		 mail($email,$subject,$message,"From:$admin_mail");
		// require_once("includes/header.php");
         echo"<p align=center><br><br><br><b>Password sent to your admin email. Please Check mail.</b><br><br><br></p>"; 
        // require_once("includes/footer.php");
         ///exit();
	 }else
	 { 
	     $msg="Wong Admin Email Id!!";
	 }	 
}
if(!$flag){

	require_once("includes/header.php");
}
	?> 
<div id="forgot">
                    <div class="page-header">
                        <h3 class="center">Forgot password</h3>
                    </div>
                    <form class="form-horizontal" name="forgotpass" method="post" action="" id="forgotpass">
                        <div class="row">
                            <div class="form-group relative">
                                <div class="icon"><i class="icon20 i-user"></i></div>
                                <input class="form-control" type="text" name="username" id="username" placeholder="Username">
                            </div><!-- End .control-group  -->
                            <div class="form-group relative">
                                <div class="icon"><i class="icon20 i-envelop-2"></i></div>
                                <input class="form-control" type="text" name="emailid" id="emailid" placeholder="Your email">
                            </div><!-- End .control-group  -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-block btn-success" name="recoverpassword">Recover my password</button>
                            </div>
                        </div><!-- End .row-fluid  -->
                    </form>
</div>