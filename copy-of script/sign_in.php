<?php $current_page="Login"; ?>
<?php ob_start();?>
<?php
include("include/header.php");
include("country.php");
?>
<?php
include("include/header_menu.php");
?>
<?php
if(isset($_SESSION['user_id']))

{

	header('Location: dashboard.html');

}





if(isset($_POST['username']) && isset($_POST['password']))

{
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

	if($n)



	{	



		session_regenerate_id();



		$fname=txt_value_output(@mysql_result($r,0,"fname"));



		$lname=txt_value_output(@mysql_result($r,0,"lname"));



		 $_SESSION['fullname'] = $fname.' '.$lname;			



		$_SESSION['user_id']	=@mysql_result($r,0,"user_id");



		$_SESSION['username']	=txt_value_output(@mysql_result($r,0,"username"));



		$_SESSION['email']		=txt_value_output(@mysql_result($r,0,"email"));



		$_SESSION['user_type']	=txt_value_output(@mysql_result($r,0,"user_type"));



		$_SESSION['ldate']	    =@mysql_result($r,0,"ldate");



		$_SESSION['gold_member']	    =@mysql_result($r,0,"gold_member");



		$_SESSION['ip']	        =@mysql_result($r,0,"ip");



		$user_type              =txt_value_output(@mysql_result($r,0,"user_type"));



		$profile                =txt_value_output(@mysql_result($r,0,"profile"));		



		


          
		$r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);													



		if($user_type=="W" || $user_type=="B")

		{

		    $n=@mysql_num_rows(mysql_query("select user_id from ".$prev."user_cats  where user_id=".$_SESSION['user_id']." limit 1"));	   



		    if(!$n || !$profile){ header('Location: dashboard.php');} 

		}	



		if($_REQUEST['referer'])

		{

		   redirect($vpath.txt_value($_REQUEST['referer']));

		}

		else

		{
	

		   header('Location: dashboard.php');

		}



	}	

	else

	{

		$msg="<p style='color:red; font-family: Arial,Helvetica,sans-serif; font-size: 13px; margin: 0 0 0 7px;'>Please enter a valid username and password</p>";	

	}	

}



?>

<link href="highslide/highslide.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<script type="text/javascript">



	hs.graphicsDir = 'highslide/graphics/';



	hs.outlineType = 'rounded-white';



	hs.wrapperClassName = 'draggable-header';



	hs.minWidth = 400;



	hs.creditsText = '<i>Upload your Valid Account Email Id For Withdrawal of Funds</i>';



</script>
<script language="javascript" type="text/javascript">

function validateLogin(){



	if (document.getElementById('username').value == false){



        alert("Please enter a valid user name.");



        document.getElementById('username').focus();



        return false;



	} 



	if (document.getElementById('password').value == false){



        alert("Please enter password.");



        document.getElementById('password').focus();



        return false;



	} 



   document.getElementById('login_form').submit();



}



function chktype()

{

	//if(document.getElementById('radio').selected==true)

	//$("input[name=radio_group]:checked").val();  

	

	//alert (document.getElementsByName('radio').checked.value);

	var cnt=0;

	var oRadio = document.getElementsByName('radio_name');

	for(var i = 0; i < oRadio.length; i++)

   {      

	  if(oRadio[i].checked)

      {

         if(oRadio[i].value=='W')

		 {

		 	location.replace('signup.html?type=W');

		 }

		  if(oRadio[i].value=='E')

		 {

		 	location.replace('signup.html?type=E');

		 }

		 cnt++;

      }	 

	  

   }

   if(cnt==0)

   {

   	  	alert("Please select one type for creating an account.");

   }

   

   

	/*if(document.getElementById('radio').value=='W')

	{

	alert ('fdgdfg');

		location.replace('singup.php?type=W');

	}

	if(document.getElementById('radio1').value=='E')

	{

		location.replace('singup.php?type=E');

	}

	}*/

}




</script>
<!------Start-middle-------->
<div class="inner-middle">
<div class="page_headding">
    <div class="clear"></div>
    <div class="click_panel"><table align="left" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="16%"></td>
    <td width="23%"><h3 lang="en">Sign in to HiredEASY</h3></td>
    <td width="19%">&nbsp;</td>
    <td width="19%"><div>
      <p><span lang="en">Not registered yet</span>?<br />
        <a href="<?=$vpath?>register.html"><span lang="en">Sign up now</span>!</a></p>
    </div></td>
    <td width="20%">&nbsp;</td>
  </tr>
</table></div>
</div>

<div class="clear"></div>
<div class="register_panel">


<!--Register Form Start-->
<div class="signin-form_box">
  <form action="sign_in.php" method="POST" name="login_form" id="login_form" onsubmit="return validateLogin(this);" >
  
<input type=hidden name='mode' value="login">
  
  <input type="hidden" name="hiddLogin" value="1" />

  <input type="hidden" name="referer" value="<?php print txt_value($_REQUEST['referer'])?>" />
<div class="register-form">&nbsp;&nbsp;<?php if($msg){ echo $msg;}?></div>

<div class="register-form"><p><span lang="en">Email</span>:</p>
<input class="reg_input" name="username"  id="username" type="text" <?php if ($_COOKIE['cookname']) { ?> value="<?=$_COOKIE['cookname']?>" <?php } ?> /></div>

<div class="register-form"><p><span lang="en">Password</span>:</p>
<input class="reg_input" name="password" id="password" type="password" <?php if ($_COOKIE['password']) { ?> value="<?=$_COOKIE['password']?>" <?php } ?>/></div>

<div class="register-form">
<input type="checkbox" name="remember" id="remember" value="1" <?php if (($_COOKIE['cookname']) && $_COOKIE['password']) { echo 'checked'; } ?> >Remember Me!</div>





<div class="register-form">


 
      <input type="submit" class="creatbnt" name="sub" value="Sign in" /><br />

        <h1>&nbsp;&nbsp; <a href="forget_password.php" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="link" lang="en">Forgot your password?</a></h1>
</div>
</form>
</div>   
<!--Register Form End-->


</div>

</div>


<!------end_middle-------->
<?php
include("include/footer.php");
?>