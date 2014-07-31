<?php $current_page="Register form work"; ?>
<?php ob_start();?>
<?php
include("include/header.php");
include("country.php");
?>
<?php
include("include/header_menu.php");
?>
<?php
$reg_date=date("Y-m-d");

$mailbody="<p><b>Username : </b>{username}<br><b>Password : </b>{password}<br><b>Registration Date : </b>{reg_date}<br><b>Registration from IP Address  : </b>{ip}</p>\n";

$mailbody.='<p><a href="{lnk}" style="text-decoration:none; color:#fff;"><div style="background:#0B7398; padding:5px 10px 5px 10px; border-radius: 5px; text-decoration:none; width:245px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#fff; text-align:center;"><strong>Click to verify your email address</strong></div></a><br><br> or copy and paste this link in your browser<br>{lnk}</p>\n';

$mailbody.="<p><b>Note : </b><br>If this link doesn't work, then copy and paste the link into your Web browser and hit enter.This email message has been sent to you with the password you entered in case you forget it. Thank you for registering with $dotcom. </p>\n";



if(isset($_REQUEST['hiddRegister']))
    { 
        $errormsg=false;
	if(trim(strtolower($_REQUEST['captchatext'])) != $_SESSION['captcha'])
            {
                $captchaerror="Please enter correct security code.";
                $errormsg="Please enter correct security code.";
                unset($_SESSION['captcha']);
                $_SESSION['error'].=$errormsg;
            }
        if((empty($_REQUEST['email'])) || (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_REQUEST['email'])))
             {
                $emailerror="Please enter your valid email address.";
                $errormsg=true;
                $_SESSION['error'].=$emailerror;}
                if(!$emailerror)
                        {



		if(!$emailerror && (@mysql_num_rows(mysql_query("select user_id from ".$prev."user where email='".txt_value($_REQUEST['email'])."'"))))

		{

			$emailerror="This email address already used by another user.";$errormsg=true;

			$_SESSION['error'].=$emailerror;

		}

	}

	$pattern = "/[!|@|#|$|%|^|&|*|(|)|_|\-|=|+|\||,|.|\/|;|:|\'|\"|\[|\]|\{|\}]/i";

	if(empty($_REQUEST['username'])){$usererror="Please enter your username.";$_SESSION['error'].=$usererror;}

	if(preg_match("/^[A-Z,a-z,0-9]{0,25}$/i", stripslashes(trim($_REQUEST['username'])))){echo"";}else{$usererror="The username contains illegal characters.";$errormsg=true;$_SESSION['error'].=$usererror;}

	if((empty($_REQUEST['username'])) || (strlen($_REQUEST['username'])<6) || (strlen($_REQUEST['username'])>25)){$usererror="Please choose a username that's at least 6 - 25 characters long.";$errormsg=true;$_SESSION['error'].=$usererror;}

	if(preg_match($pattern, $_REQUEST['username'])) {$usererror="Please enter valid character.";$errormsg=true;$_SESSION['error'].=$usererror;}

	if(!$usererror)

	{



		if(@mysql_num_rows(mysql_query("select user_id from ".$prev."user where username='".txt_value($_REQUEST['username'])."'")))

		{

			$usererror="This username already used by another user.";$errormsg=true;$_SESSION['error'].=$usererror;

		}

	}

	if(empty($_REQUEST['firstname'])){$fnameerror="Please enter your first name.";$errormsg=true;$_SESSION['error'].=$fnameerror;}

	if(empty($_REQUEST['lastname'])){$lnameerror="Please enter your last name.";$errormsg=true;$_SESSION['error'].=$lnameerror;}

	if(empty($_REQUEST['password']) || (strlen(trim($_REQUEST['password']))<4) || (strlen(trim($_REQUEST['password']))>25)){$passerror="Please enter 4-25 charcter password.";$errormsg=true;$_SESSION['error'].=$passerror;}

	if(empty($_REQUEST['password1']) || ($_REQUEST['password']!=$_REQUEST['password1'])){$cpasserror="Please enter correct confirm password.";$errormsg=true;$_SESSION['error'].=$cpasserror;}

	/*if($_POST['agree']!="Y"){$termserror="You must agreed our terms and conditions.";$errormsg=true;$_SESSION['error'].=$termserror;}*/

	

	if($errormsg==false || $_SESSION['error']=="")

	{

		$r=mysql_query("insert into ".$prev."user set

		username=\"".txt_value($_REQUEST['username'])."\",email=\"".txt_value($_REQUEST['email'])."\",

		password=\"".md5($_REQUEST['password'])."\",user_type=\"".$_REQUEST['user_type']."\",ip=\"".$_SERVER['REMOTE_ADDR']."\",

		fname=\"".addslashes($_REQUEST['firstname'])."\",gold_member=\"".$_REQUEST['gold_member']."\",

		lname=\"".addslashes($_REQUEST['lastname'])."\",country=\"".addslashes($_REQUEST['country'])."\",

		reg_date=now(),

		edit_date=now(),

		ldate=now(),

		status='N',

	  	v_stat='N',

		v_key=\"".md5($_REQUEST['username'])."\"") or die("error : ".mysql_error());
		$user_id=mysql_insert_id();
           $rr=mysql_query("insert into ".$prev."cats set user_id='".$user_id."',cat_id='".$_POST['category']."'");     
           /* echo  "insert into ".$prev."user set

		username=\"".txt_value($_REQUEST['username'])."\",email=\"".txt_value($_REQUEST['email'])."\",

		password=\"".md5($_REQUEST['password'])."\",user_type=\"".$_REQUEST['user_type']."\",ip=\"".$_SERVER['REMOTE_ADDR']."\",

		fname=\"".addslashes($_REQUEST['firstname'])."\",gold_member=\"".$_REQUEST['gold_member']."\",

		lname=\"".addslashes($_REQUEST['lastname'])."\",country=\"".addslashes($_REQUEST['country'])."\",

		reg_date=now(),

		edit_date=now(),

		ldate=now(),

		status='N',

	  	v_stat='N',

		v_key=\"".md5($_REQUEST['username'])."\"";*/



		if($r)

		{

			$user_id=mysql_insert_id();

	

			$url="<a href='" . $vpath . "activate/?v_key=".md5($_REQUEST['username'])."&user=" . ($user_id) . "'>Verify Email Address</a>";

			$lnk=$vpath . "activate.php?v_key=".md5($_REQUEST['username'])."&user=" . ($user_id);

			$mailbody=str_replace("{link}",$url,$mailbody);

			$mailbody=str_replace("{lnk}",$lnk,$mailbody);

			$mailbody=str_replace("{username}",$_REQUEST['username'],$mailbody);

			$mailbody=str_replace("{fname}",$_REQUEST['firstname'],$mailbody);

			$mailbody=str_replace("{password}",$_REQUEST['password'],$mailbody);

			$mailbody=str_replace("{reg_date}",date("F j, Y, g:i a"),$mailbody);

			$mailbody=str_replace("{ip}",$_SERVER['REMOTE_ADDR'],$mailbody);

			$subject="Registration Confirmation from ".$dotcom;

			$to = $_REQUEST['email'];

			$subj = $subject;

			$body = $mailbody;

			$mail_type = 'registration';

			if(genMailing($to, $subj, $body, $from = '', $reply = true, $mail_type))

			{

			

			$msg1='Registration Successful.<br>Congratulation !!.<br><span lang="en">Your profile has been successfully created and thanking you for being a registered member . Please check your e-mail to activate your account</span>.<br>';

			$_SESSION['succ']=$msg1;

			//$msg2=base64_encode($msg1);

			

			header("location:singup_success.php?succ='succ'");

			}

			

			

		}

		else

		{

			$_SESSION['error']="There is some problem in storing your data.Please try to register again.";

		}

	}

}

?>



<script type="text/javascript">

<!--




function ValidateForm() {
 form1 = document.forms['_register'];
    if (form1.elements['username'].value == '') 
        {
                alert('You must enter username.');
                form1.elements['username'].focus();
                return false;

	}
   if (form1.elements['password'].value == '') 
      {
          alert('You must enter your password.');

	  form1.elements['password'].focus();

	   return false;

      }

	if (form1.elements['password1'].value == '') 

	{

		alert('You must enter and confirm your password.');

		form1.elements['password1'].focus();

		return false;

	} 

	else if (form1.elements['password'].value != form1.elements['password1'].value) 

	{

		alert('Password confirmation failed.  Please retype your password.');

		form1.elements['password'].focus();

		return false;

	}
        
        if (form1.elements['email'].value == '') 

	{

		alert('Please enter your email address.');

		form1.elements['email'].focus();

		return false;

	}

	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form1.elements['email'].value) == false)

	{

        alert("Please enter a valid email address.");

        form1.elements['email'].focus();

        return false;

	}
	if (form1.elements['firstname'].value == '') 

	{

		alert('Please enter your first name.');

		form1.elements['firstname'].focus();

		return false;

	}

	if (form1.elements['lastname'].value == '') 

	{

		alert('Please enter your last name.');

		form1.elements['lastname'].focus();

		return false;

	}
       /* if (form1.elements['state'].value == '') 

	{

		alert('Please enter your state.');

		form1.elements['state'].focus();

		return false;

	}

	if (form1.elements['city'].value == '') 

	{

		alert('Please enter your city.');

		form1.elements['city'].focus();

		return false;

	}

	if (form1.elements['zip'].value == '') 

	{

		alert('Please enter your zip.');

		form1.elements['zip'].focus();

		return false;

	}
*/
	if (form1.elements['country'].value == '')

	{

		alert('Enter Country name!');

		form1.elements['country'].focus();

		return false;

	}
        
        if (form1.elements['user_type'].value == '')

	{

		alert('Choose type!');

		form1.elements['user_type'].focus();

		return false;

	}

	if (!form1.elements['captcha-form'].value)

	{

		alert('Please enter the correct Confirmation Code.');

		form1.elements['captcha-form'].focus();

		return false;

	}



/*	if (form1.elements['agree'].checked == false) {

		alert('You must agree with our terms & conditions.');

		form1.elements['agree'].focus();

		return false;

	}
*/


	return true;

}


function ChnageCaptchText(captchaid,captchaform,sell)

{

	document.getElementById(captchaid).src='captcha/captcha.php?'+Math.random();

	document.getElementById(captchaform).focus();

	return true;

}

</script>

<!------Start-middle-------->
<div class="inner-middle">
<div class="page_headding">
	<h3 lang="en">Create account as a professional</h3>
    <div class="clear"></div>
    <div class="click_panel"><span lang="en">Do you want to Sign up as a client</span>? <a href="register-form-client.php"><span lang="en">Click here</span></a></div>
</div>
<div class="sign_pane">
  <h1><span lang="en">Sign-in using</span>:</h1>
  <div class="sign_icon"><img src="images/link_icon.png" /></div></div>
<div class="clear"></div>
<div class="register_panel">


<!--Register Form Start-->
<div class="register-form_box">
<form method="post" enctype="multipart/form-data" name="register" id="register" onsubmit='return ValidateAndSubmit();'>
 <?php

        if($_SESSION['error']!="")

        {

                include('include/err.php');

                unset($_SESSION['error']);

                unset($_SESSION['succ']);

        }

        if($_SESSION['succ']!="")

        {

                include('include/succ.php');

                unset($_SESSION['error']);

                unset($_SESSION['succ']);

        }

		?>
<input type="hidden" name='mode' value="signup" />
<input type='hidden' name='hiddRegister' value='1' />
<input type='hidden' name='user_type' value='W' />
<div class="register-form"><p><span lang="en">Display Name</span>:</p>
<input class="reg_input" name="username" id="username" type="text" /></div>
<div class="register-form"><p><span lang="en">First name</span>:</p>
<input class="reg_input" name="firstname" id="firstname" type="text" /></div>

<div class="register-form"><p><span lang="en">Last name</span>:</p>
<input class="reg_input" name="lastname" id="lastname" type="text" /></div>

<div class="register-form"><p><span lang="en">Email</span>:</p>
<input class="reg_input" name="email" id="email" type="text" /></div>

<div class="register-form"><p><span lang="en">Password</span>:</p>
<input class="reg_input" name="password" id="password" type="password" /></div>

<div class="register-form"><p><span lang="en">Retype password</span>:</p>
<input class="reg_input" name="password1" id="password1" type="password" /></div>
<div class="register-form"><p><span lang="en">Country</span></p>
<select name="country" id="country" class="reg_input">
              <option value=''><span lang="en">Select Country</span></option>
                  <?php
                  $arr=array_keys($country_array);
                  for($i=0;$i<count($arr);$i++):
                      echo"<option value='" . $arr[$i] . "'>" . $country_array[$arr[$i]] . "</option>\n";
                  endfor; 
                  ?>
          </select></div>

<div class="register-form">
	<div class="capta"><img src="captcha/captcha.php" id="captcha" name="captcha" alt="Captcha" /></div>
              <div class="cng_capta"><a onclick="ChnageCaptchText('captcha','captcha-form','');" id="change-image" style="cursor:pointer;"><span lang="en">Not readable</span>?<span lang="en">Change text</span>.</a><br/> <span lang="en">Security code</span></div>
           
          <input name="captchatext" id="captcha-form" class="reg_input" type="text" style="width:204px;" /><br><?php if($captchaerror){echo"<br /><span style=\"color:#EA0000;\" class='lnkred'><b>".$captchaerror."</b></span><br>";}?></div>


<div class="register-form"><p><span lang="en">What is your professional activity</span>?</p>
<?php
$r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
?>
<select name="category" class="reg_input" style="width:232px;" >
                    <option value="0"><span lang="en">Choose an activity</span>&nbsp;</option>



          <?php



							  while($d=mysql_fetch_array($r))



							  {



							  ?>



          <option value="<?php echo $d['cat_id'];?>" <?php if($row_cate['parent_id']==$d['cat_id']){echo "selected";}?> <?php if($_REQUEST['cate_id']==$d['cat_id']){echo "selected";}?>><?php echo $d['cat_name'];?></option>



          <?php



							  }







							  ?>



        </select>
</div>

<!--<div class="register-form"><p>Account Type<br />
How do you want to represent yourself?</p>
<div class="register-form"><input name="" type="radio" value="" />Individual           <input name="" type="radio" value="" /> Company  </div>
</div>-->


<!--<div class="register-form"><input name="" type="checkbox" value="" />Send me updates, in addition to must read stuff</div>
-->

<div class="register-form">

     <input type="submit" class="creatbnt" name="sub" value="Create Your account" /><br /><br />
       </form>
 <h1><span lang="en">By clicking, i agree to the freelance4less.com </span> <a href="info.html?id=31"><span lang="en"> terms of service</span></a>, <br />
<a href="info.html?id=32"><span lang="en"><span lang="en"> privacy policy</span></a><span lang="en"> and user agreement</span></h1>
</div>

</div>   
<!--Register Form End-->


<!--Register Right Start-->
<div class="regisform-right">
  <h1>“<span lang="en">The home of individual freelancers</span>,<br />
        <span lang="en">welcome to the family</span>”</h1><br />
<br />
<table align="left" width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38"></td>
  </tr>
  <tr>
    <td height="368" align="center"><img src="images/register-right-img.jpg" /></td>
  </tr>
  <tr>
    <td height="372"></td>
  </tr>
  <tr>
    <td><table width="64%" border="0" cellspacing="0" cellpadding="0" align="right" style="background:#f4f4f4;" class="registab"  >
      <tr>
        <td height="12"></td>
      </tr>
      <tr>
        <td><p><em>“<span lang="en">Freelance4less is designed to benefit the individual freelancer, this is our foundations</span>”</em></p></td>
      </tr>
        <tr>
        <td height="15"></td>
      </tr>
      
           <tr>
        <td ><h2><span lang="en">Ujjal Saha</span>,<br />
  <span lang="en">Webdesign Freelancer,Kolkata India</span></h2></td>
      </tr>
      <tr>
        <td height="12"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
<!--Register Right End-->
</div>

</div>


<!------end_middle-------->
<?php
include("include/footer.php");
?>