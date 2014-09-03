<?php ob_start();
$current_page="Sign In";

 ?>

<?php include ('includes/header.php');
$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='About Us'"));
if(isset($_SESSION['user_id'])){
	header('Location: dashboard.php');
}


if(isset($_POST['username']) && isset($_POST['password'])){

if($_POST['remember']!='')
			{
				setcookie("cookname", $_POST['username'], time() + 3600);
				setcookie("password", $_POST['password'], time() + 3600);
			 } 
			
			if($_POST['remember']=='')
			{
				setcookie("cookname", $_POST['username'], time() - 3600);
				setcookie("password", $_POST['password'], time() - 3600);
			 }
	$r=mysql_query("select * from  ". $prev . "user where  (username=\"" . txt_value($_POST['username']) . "\" or email=\"".txt_value($_POST['username']). "\") and  strcmp(\"" . md5($_POST['password']) . "\", password)=0 and status='Y'");

	$n=@mysql_num_rows($r);
	if($n>0){	
		session_regenerate_id();
		
		$fname=txt_value_output(@mysql_result($r,0,"fname"));
		$lname=txt_value_output(@mysql_result($r,0,"lname"));
		$_SESSION['fullname'] = $fname.' '.$lname;					
		$_SESSION['user_id']	=@mysql_result($r,0,"user_id");
		$_SESSION['username']	=txt_value_output(@mysql_result($r,0,"username"));
		$_SESSION['email']		=txt_value_output(@mysql_result($r,0,"email"));
		$_SESSION['user_type']	=txt_value_output(@mysql_result($r,0,"user_type"));
		$_SESSION['ldate']	    =@mysql_result($r,0,"ldate");
		$_SESSION['gold_member']=@mysql_result($r,0,"gold_member");
		$_SESSION['ip']	        =@mysql_result($r,0,"ip");
		$user_type              =txt_value_output(@mysql_result($r,0,"user_type"));
		$profile                =txt_value_output(@mysql_result($r,0,"profile"));		

		$r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);													
		if($user_type=="W" || $user_type=="B"){
			
		    $n=@mysql_num_rows(mysql_query("select user_id from ".$prev."user_cats  where user_id=".$_SESSION['user_id']." limit 1"));	   
			if(!$n && !$profile){
				if($_REQUEST['referer']){	
					redir($vpath.txt_value($_REQUEST['referer']));
				}
				elseif($_REQUEST['referer2']!=''){
					redir($vpath.base64_decode($_REQUEST['referer2']));
				}									
			}
			else{
				redir('dashboard.php');
			}
		}	



		if($_REQUEST['referer']){

		   redirect($vpath.txt_value($_REQUEST['referer']));
		}
		elseif($_REQUEST['referer2']!=''){
			header("Location:".$vpath.base64_decode($_REQUEST['referer2']));
		}
		else{

		   header('Location: dashboard.html');
		}
	}	

	else{

		$msg="<h4 style='color:red;'>".$lang['PLEASE_ENTER_VALID_EMAIL']."</h4>";	
	}
}

?>

<link href="<?=$vpath?>highslide/highslide.css" type="text/css" rel="stylesheet">

<script language="javascript" type="text/javascript">

function validateLogin(){



	if (document.getElementById('username').value == false){



        alert("<?=$lang['PLEASE_ENTER_VALID_USER']?>");



        document.getElementById('username').focus();



        return false;



	} 



	if (document.getElementById('password').value == false){



        alert("<?=$lang['PLEASE_ENTER_PASSWORD']?>");



        document.getElementById('password').focus();



        return false;



	} 



   document.getElementById('login_form').submit();



}



function chktype()

{

	
	var cnt=0;

	var oRadio = document.getElementsByName('radio_name');

	for(var i = 0; i < oRadio.length; i++)

   {      

	  if(oRadio[i].checked)

      {

         if(oRadio[i].value=='W')

		 {

		 	location.replace('singup.php?type=W');

		 }

		  if(oRadio[i].value=='E')

		 {

		 	location.replace('singup.php?type=E');

		 }

		 cnt++;

      }	 

	  

   }

   if(cnt==0)

   {

   	  	alert("<?=$lang['PLZ_SELECT_ONE_TYPE']?>");

   }

   


	

}


function openLinkedinLogin() {
	window.open('/includes/linkedin.php', 'linkedin_login', 'resizable=no,width=780,height=640');
}

</script>


<div id="loginPage">
 <form onsubmit="return validateLogin(this);" id="login_form" name="login_form" method="POST" action="">
  

  <input type=hidden name='mode' value="login">

 
  
  <div class="inner-middle">


<div class="clear"></div>
<div class="register_panel">


<!--Register Form Start-->
<div class="signin-form_box">
<?=$msg?>
 
<input type="hidden" value="login" name="mode">
  
  <input type="hidden" value="1" name="hiddLogin">

  <input type="hidden" value="<?=$_GET[referer2]?>" name="referer2">

<div class="height20"></div>
<!-- <div class="register-form" style="font-size:17.3px;">Log in and get to work</div> -->
<div class="register-form" style="font-size:17.3px;"><input type="button" value="Log in with Linkedin" name="login_linkedin" onclick="openLinkedinLogin();" class="login_linkedin_btn"></div>

<div class="height20"></div>

<div class="register-form infor-site">
	<div style="width:42%; float:left;">
		<h2>Log in, post a job free and begin contracting SMEs right away</h3>
		<p>No Startup fees.  No Commitment.</p>
		<p>High quality SMEs with certified skills.</p>
		<p>Cost effective "On Demand" Resources.</p>
		<p>Convenient Billing and Payment.</p>
	</div>
	<div style="width:46%; float:right;">
		<h2>Login to gain access to thousands of contracting opportunites all around US.</h3>
		<p>No fees, No commitment.</p>
		<p>Create your SME brand and obtain industry leading certifications.</p>
		<p>Hundreds of exciting projects every day.</p>
		<p>Guranteed payment for your hourly work.</p>
	</div>
</div>
<div class="height20"></div>
<!-- <div class="register-form">
<input type="text" id="username" name="username" class="reg_input" <?php if ($_COOKIE['cookname']) { ?> value="<?=$_COOKIE['cookname']?>" <?php } ?> placeholder="Email"></div>
<div class="height10"></div>

<div class="register-form">
<input type="password" id="password" name="password" class="reg_input" <?php if ($_COOKIE['password']) { ?> value="<?=$_COOKIE['password']?>" <?php } ?>  placeholder="Password"></div>
<div class="height20"></div>
	    
<div class="register-form">
	<input type="checkbox" name="remember" id="remember" value="1" <?php if (($_COOKIE['cookname']) && $_COOKIE['password']) { echo 'checked'; } ?> >&nbsp;Remember me next time
</div> -->
<!-- <div class="register-form"> -->
    <!-- <div style="width:35%; float:left;">
    	<input type="submit" value="&nbsp;&nbsp;&nbsp;Log in&nbsp;&nbsp;&nbsp;" name="sub" class="creatbnt"><br clear="all">
	</div> -->
    <!-- <div style="width:50%; float:left;">
	    <input type="button" value="Log in with Linkedin" name="login_linkedin" onclick="openLinkedinLogin();" class="login_linkedin_btn"><br clear="all">
	</div>
</div> -->


<!-- <div class="height20"></div>
<div class="register-form" id="forgetPass">
    <a lang="en" class="link" href="#">Join Bio Pharma</a>
</div>

<div class="height20"></div><div class="height10"></div> -->

<div class="register-form" id="forgetPass">
    <a lang="en" class="link" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" href="forget_password.php">Forgot Your Password?</a>
</div>
<div class="height20"></div>
<div class="register-form" id="forgetPass">
    <a lang="en" class="link" href="#">Terms</a>&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;
    <a lang="en" class="link" href="#">FAQ</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a lang="en" class="link" href="#">Support</a>
</div>



</div>   
<!--Register Form End-->


</div>

</div>

</form>
</div><!--LoginPage DIV-->

<?php include 'includes/footer.php';?>