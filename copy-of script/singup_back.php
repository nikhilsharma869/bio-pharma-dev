<?php 
$current_page="Create an Account"; 
include ('includes/header.php');
include("country.php");

$reg_date=date("Y-m-d");
$mailbody="<p><b>".$lang['USRNM']." : </b>".$lang['USERNAME1']."<br><b>".$lang['PASSWORD']." : </b>".$lang['PASSWORD1']."<br><b>".$lang['REGISTRATION_DATE']." : </b>{".$lang['REG_DATE1']."}<br><b>".$lang['REGISTRATION_IP_ADDRESS']." : </b>{ip}</p>\n";
$mailbody.='<p><a href="{lnk}" style="text-decoration:none; color:#fff;"><div style="background:#0B7398; padding:5px 10px 5px 10px; border-radius: 5px; text-decoration:none; width:245px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#fff; text-align:center;"><strong>'.$lang['CONFIRM_ADDRESS_LINK'].'</strong></div></a><br><br>'.$lang['COPY_PASTE_BROWSER'].'<br>{lnk}</p>';
//$mailbody.="<p><b>".$lang['NOTE']. ": </b><br>".$lang['IF_THIS_LINK']." $dotcom. </p>\n";

if(isset($_REQUEST['hiddRegister']))
{
	$errormsg=false;
	if(trim(strtolower($_REQUEST['captchatext'])) != $_SESSION['captcha'])
	{
		$captchaerror=$lang['SECURITY_CODE1'];
		$errormsg=$lang['SECURITY_CODE1'];
		unset($_SESSION['captcha']);
		$_SESSION['error'].=$errormsg;
	}
	if((empty($_REQUEST['email'])) || (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_REQUEST['email'])))
	{$emailerror=$lang['ALERT_P1'];
	$errormsg=true;
	$_SESSION['error'].=$emailerror;}
	if(!$emailerror)
	{

		if(!$emailerror && (@mysql_num_rows(mysql_query("select user_id from ".$prev."user where email='".txt_value($_REQUEST['email'])."'"))))
		{
			$emailerror=" ".$lang['ALERT_P2']." ".$errormsg=true;
			$_SESSION['error'].=$emailerror;
		}
	}
	$pattern = "/[!|@|#|$|%|^|&|*|(|)|_|\-|=|+|\||,|.|\/|;|:|\'|\"|\[|\]|\{|\}]/i";
	if(empty($_REQUEST['username'])){$usererror=$lang['PLEASE_ENTER_USERNAME'];$_SESSION['error'].=$usererror;}
	if(preg_match("/^[A-Z,a-z,0-9]{0,25}$/i", stripslashes(trim($_REQUEST['username'])))){echo"";}else{$usererror=$lang['ILLEGAL_CHARACTER'];$errormsg=true;$_SESSION['error'].=$usererror;}
	if((empty($_REQUEST['username'])) || (strlen($_REQUEST['username'])<6) || (strlen($_REQUEST['username'])>25)){$usererror=$lang['CHOSE_USERNAMEE'];$errormsg=true;$_SESSION['error'].=$usererror;}
	if(preg_match($pattern, $_REQUEST['username'])) {$usererror=$lang['VALID_CHARACTER'];$errormsg=true;$_SESSION['error'].=$usererror;}
	if(!$usererror)
	{

		if(@mysql_num_rows(mysql_query("select user_id from ".$prev."user where username='".txt_value($_REQUEST['username'])."'")))
		{
			$usererror=$lang['ALREADY_USERNAME_USED'];$errormsg=true;$_SESSION['error'].=$usererror;
		}
	}
	if(empty($_REQUEST['firstname'])){$fnameerror=$lang['ALERT_P3'];$errormsg=true;$_SESSION['error'].=$fnameerror;}
	if(empty($_REQUEST['lastname'])){$lnameerror=$lang['ALERT_P4'];$errormsg=true;$_SESSION['error'].=$lnameerror;}
	if(empty($_REQUEST['password']) || (strlen(trim($_REQUEST['password']))<4) || (strlen(trim($_REQUEST['password']))>25)){$passerror=$lang['ALERT_P5'];$errormsg=true;$_SESSION['error'].=$passerror;}
	if(empty($_REQUEST['password1']) || ($_REQUEST['password']!=$_REQUEST['password1'])){$cpasserror=$lang['ALERT_P6'];$errormsg=true;$_SESSION['error'].=$cpasserror;}
	if($_POST['agree']!="Y"){$termserror=$lang['AGREE_TERMS_CONDITION1'];$errormsg=true;$_SESSION['error'].=$termserror;}
	
	if($errormsg==false || $_SESSION['error']=="")
	{
		$r=mysql_query("insert into ".$prev."user set
		username=\"".txt_value($_REQUEST['username'])."\",email=\"".txt_value($_REQUEST['email'])."\",
		password=\"".md5($_REQUEST['password'])."\",user_type=\"".$_REQUEST['user_type']."\",ip=\"".$_SERVER['REMOTE_ADDR']."\",
		fname=\"".addslashes($_REQUEST['firstname'])."\",gold_member=\"".$_REQUEST['gold_member']."\",
		lname=\"".addslashes($_REQUEST['lastname'])."\",country=\"".addslashes($_REQUEST['country'])."\",
		zip=\"".$_REQUEST['zip']."\",
		phone=\"".$_POST['phone']."\",
		reg_date=now(),
		edit_date=now(),
		ldate=now(),
		status='N',
	  	v_stat='N',
		v_key=\"".md5($_REQUEST['username'])."\",

		state=\"".addslashes($_REQUEST['state'])."\",

		city=\"".addslashes($_REQUEST['city'])."\"") or die("error : ".mysql_error());
		$user_id=mysql_insert_id();				
		if($_POST['newsletter']){			
		mysql_query("insert into messenger_users set 
					firstname=\"".$_REQUEST['firstname']."\",
					lastname=\"".$_REQUEST['lastname']."\",
					signup_date=now(),
					email_address=\"".$_REQUEST['email']."\"");	
		}

		if($r)
		{
			
			$url="<a href='" . $vpath . "activate/?v_key=".md5($_REQUEST['username'])."&user=" . ($user_id) . "'>Verify Email Address</a>";
			$lnk=$vpath . "activate.php?v_key=".md5($_REQUEST['username'])."&user=" . ($user_id);
			$mailbody=str_replace("{link}",$url,$mailbody);
			$mailbody=str_replace("{lnk}",$lnk,$mailbody);
			$mailbody=str_replace("{fname}",$_REQUEST['firstname'],$mailbody);
			
			$mailbody=str_replace("{".$lang['USERNAME1']."}",$_REQUEST['username'],$mailbody);
			$mailbody=str_replace("{".$lang['PASSWORD1']."}",$_REQUEST['password'],$mailbody);
			
			$mailbody=str_replace("{reg_date}",date("F j, Y, g:i a"),$mailbody);
			$mailbody=str_replace("{ip}",$_SERVER['REMOTE_ADDR'],$mailbody);
			$subject=$dotcom;
			$to = $_REQUEST['email'];
			$subj = $subject;
			$body = $mailbody;
			$mail_type = 'registration';
			if(genMailing($to, $subj, $body, $from = '', $reply = true, $mail_type))
			{
			
				$msg1=$lang['REGISTRATION_SUCCESSFULL'];
				$_SESSION['succ']=$msg1;
			//$msg2=base64_encode($msg1);
			
				header("location:singup_success.php?succ='succ'");
			}
			
			
		}
		else
		{
			$_SESSION['error']=$lang['REGIRTRATION_ERROR'];
		}
	}
}
?>

<script type="text/javascript">
<!--

function ValidateAndSubmit()
{
	form1 = document.forms['_register'];
	if(ValidateForm())
	{
		form1.submit();
		return true;
	}
	else
	{
		return false;
	}
}

function ValidateForm() {
	if(nameCheck() && emailCheck() && countryCheck() && cityCheck() && zipcodeCheck() && phoneCheck() && usernameCheck() && passwordCheck() && capchaTest() && termCheck()){
		return true;
	}
	else{
		return false;
	}
}
	
function nameCheck(){
	form1 = document.forms['_register'];
	if (form1.elements['firstname'].value == '' || form1.elements['lastname'].value == '') 
	{
		if (form1.elements['firstname'].value == ''){
			alert("<?=$lang['ALERT_P3']?>");
			form1.elements['firstname'].focus();
			return false;
		}
		if (form1.elements['lastname'].value == '') 
		{
			alert("<?=$lang['ALERT_P4']?>");
			form1.elements['lastname'].focus();
			return false;
		}
	}
	else{
		return true;
	}
}
function emailCheck(){	
	form1 = document.forms['_register'];
	
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form1.elements['email'].value) == false || form1.elements['email'].value == '')
	{
        alert("<?=$lang['VALID_EMAIL_ADDRESS']?>");
        form1.elements['email'].focus();
        return false;
	}
	else{
		return true;
	}
}
function countryCheck(){
form1 = document.forms['_register'];
	if (form1.elements['country'].value == '')
	{
		alert("<?=$lang['ALERT_P15']?>");
		form1.elements['country'].focus();
		return false;
	}
	else{
		return true;
	}
}
function stateCheck(){
form1 = document.forms['_register'];
	if (form1.elements['state'].value == '') 
	{
		alert("<?=$lang['ENTER_YOUR_STATE']?>");
		form1.elements['state'].focus();
		return false;
	}
	else{
		return true;
	}
}
function cityCheck(){
form1 = document.forms['_register'];
	if (form1.elements['city'].value == '') 
	{
		alert("<?=$lang['ENTER_YOUR_CITY']?>");
		form1.elements['city'].focus();
		return false;
	}
	else{
		return true;
	}
}
function zipcodeCheck(){
form1 = document.forms['_register'];
	if (form1.elements['zip'].value == '') 
	{
		alert("<?=$lang['ENTER_YOUR_ZIP']?>");
		form1.elements['zip'].focus();
		return false;
	}
	else{
	return true;
	}
}
function phoneCheck(){
form1 = document.forms['_register'];
	if(form1.elements['phone'].value=='')
	{
		alert("<?=$lang['ENTER_PHONE_NUMBER']?>");
		return false;
	}
	else{
		return true;
	}
}

function usernameCheck(){
 form1 = document.forms['_register'];
	if (form1.elements['username'].value == '') 
	{
		alert("<?=$lang['MUST_ENTER_USERNAME']?>");
		form1.elements['username'].focus();
		return false;
	}
	else{
		return true;
	}
}
function passwordCheck(){
form1 = document.forms['_register'];
	if(form1.elements['password'].value !='' && form1.elements['password1'].value!=''){
		if (form1.elements['password'].value != form1.elements['password1'].value) 
		{
			alert("<?=$lang['PASSWORD_CONFIRMATION_FAILED']?>");
			form1.elements['password'].focus();
			return false;
		}
		else{
		return true;
		}
	}
	else{
		if (form1.elements['password'].value == '') 
		{
			alert('You must enter and confirm your password.');
			form1.elements['password'].focus();
			return false;
		}
		if (form1.elements['password1'].value == '') 
		{
			alert("<?=$lang['ENTER_CONFIRM_PASSWORD1']?>");
			form1.elements['password'].focus();
			return false;
		} 
	}
}
function capchaTest(){
form1 = document.forms['_register'];
	if (!form1.elements['captchatext'].value)
	{
		alert("<?=$lang['CORRECT_CONFIRMATION_CODE']?>");
		form1.elements['captchatext'].focus();
		return false;
	}
	else{
		return true;
	}
}
function termCheck(){
form1 = document.forms['_register'];
	if (form1.elements['agree'].checked == false) {
		alert("<?=$lang['TERMS_CONDITION']?>");
		form1.elements['agree'].focus();
		return false;
	}
	else{
		return true;
		}
}
// -->
function ChnageCaptchText(captchaid,captchaform,sell)
{
	document.getElementById(captchaid).src='captcha/captcha.php?'+Math.random();
	document.getElementById(captchaform).focus();
	return true;
}
</script>

 <div class="browse_contract">
 <?php
				if($_SESSION['error']!="")
				{
					include('includes/err.php');
					unset($_SESSION['error']);
					unset($_SESSION['succ']);
				}
				if($_SESSION['succ']!="")
				{
					include('includes/succ.php');
					unset($_SESSION['error']);
					unset($_SESSION['succ']);
				}
		?>
<?php
	 if($_REQUEST['msg']=="")
	 {
	 ?>
<form method="post" enctype="multipart/form-data" name="_register" id="_register" action="">
  <input type="hidden" name='mode' value="signup" />
 
    <!--Post Contract-->
    <div class="post_contract" >
      <!--Post Left-->
      <div class="post_left" style=" margin-top:6px;">
        <div class="post_box">
          <div class="post_form_box">
		  
            <div class="register_form">
			
			<table width="90%" border="0" cellpadding="0" cellspacing="0" class="create_account">
   		<tr height="50px">
        	<td width="32%" valign="top"><p><?=$lang['F_NAME'] ?> :</p></td>
            <td width="450"  valign="top"><input name="firstname" type="text" value="<?=txt_value_output($_REQUEST['firstname'])?>" />
                <? if($fnameerror){echo"<br /><span style=\"color:#3268a3;\" class='lnkred'><b>".$fnameerror."</b></span>";}?>			</td>
        </tr>
        <tr height="50px">
        	<td valign="top"><p><?=$lang['L_NAME'] ?> :</p></td>
            <td valign="top"><input name="lastname" type="text" value="<?=txt_value_output($_REQUEST['lastname'])?>" />
                <? if($lnameerror){echo"<br /><span style=\"color:#3268a3;\" class='lnkred'><b>".$lnameerror."</b></span>";}?>			</td>
        </tr>
        <tr height="50px">
        	<td valign="top"><p><?=$lang['EMAIL_ADDRESS'] ?> :</p></td>
            <td valign="top"><input name="email" type="text" value="<?=txt_value_output($_REQUEST['email'])?>">
                <? if($emailerror){echo"<br /><span style=\"color:#3268a3;\" class='lnkred'><b>".$emailerror."</b></span>";}?>			</td>
        </tr>
        <tr height="50px">
        	<td valign="top"><p><?=$lang['COMPANY_NAME_OPTIONAL'] ?> :</p></td>
            <td valign="top"><input name="Input" type="text" /></td>
        </tr>
        <tr height="50px">
        	<td valign="top" ><p><?=$lang['ALERT_P15'] ?> :</p></td>
            <td valign="top">
			<select name="country"   id="country" >
                <option value=''><?=$lang['CON_SL'] ?></option>
                <?php

							$arr=array_keys($country_array);

							for($i=0;$i<count($arr);$i++):

							   echo"<option value='" . $arr[$i] . "'>" . $country_array[$arr[$i]] . "</option>\n";

							endfor; 

					?>
                </select>
			<? if($countryerror){echo"<br /><span style=\"color:#3268a3;\" class='lnkred'><b>".$countryerror."</b></span>";}?></td>
        </tr>
        <!--<tr height="50px">
        	<td valign="top"><p><?=$lang['STATE'] ?> :</p></td>
            <td valign="top"> <input id="state" name="state" type="text" value="" style="width: 181px;" />            </td>
        </tr>-->
        <tr height="50px">
        	<td valign="top"><p><?=$lang['CITY'] ?> :</p></td>
            <td valign="top"> <input id="city" name="city" type="text" value="" style="width: 181px;" /></td>
        </tr>
		<tr height="50px">
        	<td valign="top"><p><?=$lang['ZIP'] ?> :</p></td>
            <td valign="top"><input id="zip" name="zip" type="text" value="" style="width: 181px;" /></td>
        </tr>
		<tr height="50px">
        	<td valign="top"><p><?=$lang['PHONE_NO'] ?> :</p></td>
            <td valign="top"> <input id="phone" name="phone" type="text" value="" style="width: 181px;" /></td>
        </tr>
        <tr height="50px">
        	<td valign="top"><p><?=$lang['USERNAME1'] ?> :</p></td>
            <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#3268a3; padding-bottom:6px;"> <input name="username" type="text" value="<?=txt_value_output($_REQUEST['username'])?>" /><br />
                <? if($usererror){echo"<br /><span style=\"color:#3268a3;\" class='lnkred'><b>".$usererror."</b></span>";} else
				{?>
				<?=$lang['CHOSE_USERNAME'] ?>
				<?php } ?>			</td>
        </tr>
        <tr height="50px">
        	<td valign="top"><p><?=$lang['PASSWORD1'] ?> :</p></td>
            <td valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#3268a3; padding-bottom:6px;"> <input name="password" type="password" value="" /><br />
                <? if($passerror){echo"<br /><span style='color:#3268a3;' class='lnkred'><b>".$passerror."</b></span>";} else {
				?>
				<?=$lang['ENTER_CHARACTER_IN_PASSWORD'] ?>		
				<?php
				} ?>			</td>
        </tr>
        <tr height="50px">
        	<td valign="top"><p><?=$lang['RETYPE_PASSWORD'] ?> :</p></td>
            <td valign="top"> <input name="password1" type="password" value="" />
              <? if($cpasserror){echo"<br /><span style='color:#3268a3;' class='lnkred'><b>".$cpasserror."</b></span>";}?></td>
        </tr>
		<tr height="50px">
        	<td valign="top"><p><?=$lang['USER_TYPE'] ?> :</p></td>
            <td valign="top"> 
				<select name="user_type">
                  <option value="W" <?php if($_GET['type']=='W') echo "selected='selected'"; ?>><?=$lang['WORK'] ?></option>
                  <option value="E" <?php if($_GET['type']=='E') echo "selected='selected'";?>><?=$lang['HIRE'] ?></option>
                  <option value="B" <?php if($_GET['type']=='B') echo "selected='selected'"; ?>><?=$lang['HIRE_AND_WORK'] ?></option>
                </select>			</td>
        </tr>
		<tr height="50px">
        	<td valign="top"></td>
            <td valign="top"> <img src="captcha/captcha.php" id="captcha" name="captcha" alt="Captcha" /><br/>
                  <a onclick="ChnageCaptchText('captcha','captcha-form','');" id="change-image"  style="cursor:pointer; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#3268a3;"><u><?=$lang['Not_readable']?></u></a><br/>			</td>
        </tr>
		<tr height="50px">
        	<td valign="top"><p><?=$lang['SECURITY_CODE'] ?> :</p></td>
            <td valign="top"> <input type="text" name="captchatext" id="captcha-form" />
                  <? if($captchaerror){echo"<br /><span style=\"color:#3268a3;\" class='lnkred'><b>".$captchaerror."</b></span><br>";}?>			</td>
        </tr>
		
		<tr height="50px">
        	<td valign="top" colspan="2"><span style="float:left; padding-top:6px; padding-left:168px;"><input type="checkbox" id="agree" name="agree" value="Y" size="5" style="width:20px; " /></span>
               <h2 style="padding-left: 185px; color:#3268a3;"><?=$lang['AGREE_TERMS_CONDITION2'] ?> <a href="<?=$vpath?>terms.html" target="_blank" style=" text-decoration: underline;color:#3268a3;"><?=$lang['AGREE_TERMS_CONDITION3'] ?></a></h2>
                  <? if($termserror){echo"<br /><<span style=\"color:#3268a3;\" class='lnkred'><b>".$termserror."</b></span><br />";}?>			</td>
        </tr>
		<tr height="50px">
        	<td valign="top" colspan="2">
                <span style="float:left; padding-top:6px; padding-left:168px; color:#3268a3;">
                  <input type="checkbox" name="newsletter" id="checkbox" style="width:20px;" />
                </span>
                <h2 style="color:#3268a3;"><?=$lang['MONTHLY_NEWSLETTER'] ?> :</h2></td>
        </tr>
		<tr height="50px">
        	<td valign="top"> <input type='hidden' name='hiddRegister' value='1' /></td>
            <td valign="top">&nbsp;			</td>
        </tr>
   </table>
             
            </div>
			
          </div>
          <div class="pos_my_job"> <a href='javascript:void(0)'  onclick='return ValidateAndSubmit();'><strong> <?=$lang['Reg']?></strong></a> </div>
         <a href="<?=$vpath?>login.html"  style=" text-decoration: none; color:#3268a3;"> <h3 style="width:340px; color:#3268a3;"><?=$lang['ALREADY_ACCOUNT'] ?></h3></a>
        </div>
      </div>
      <!--Post Left End-->
      <!--Post Right-->
      <div class="post_right" style=" margin-top:6px;">
        <div class="post_right_box">
          <div class="post_link_box">
            <div class="post_link_box_img"><img src="images/privacy_policy.png" /></div>
            <p><?=$lang['VALUE_PRIVACY'] ?><br />
              <?=$lang['PRIVACY_POLICY'] ?></p>
            <h2><?=$lang['Elance_msg'] ?></h2>
            <div class="posted">
			<? 
			$today=date("Y-m-d");
			$prevdate= date("Y-m-d", strtotime ('-30day',strtotime($today)));
			$p=@mysql_fetch_array(mysql_query("select count(id) as ct from ".$prev."projects where creation between '$prevdate' and '$today' "));?>
              <h2><?=$p[ct]?></h2>
              <h4><?=$lang['Elance_msg1'] ?> </h4>
              <br />
            </div>
            <a href="<?=$vpath?>signup/W/"><h1><?=$lang['PR_MSG1'] ?></h1></a>
          </div>
        </div>
        <div class="post_right_box">
          <div class="post_link_box">
            <div class="post_link_box_img"><img src="images/register_client.png" /></div>
            <p><?=$lang['reg_as_client'] ?><br />
                <br />
            </p>
            <div class="client_pic"><img src="images/client_img.png" width="239" height="179" /></div>
            <div class="posted">
			<? $pc=@mysql_fetch_array(mysql_query("select count(user_id) as ctcu from ".$prev."user where date(reg_date) between '$prevdate' and '$today' and (user_type='W' or user_type='B')"));?>
              <h2><?=$pc[ctcu]?></h2>
              <h4><?=$lang['New_freelancer'] ?> </h4>
              <br />
            </div>
             <a href="<?=$vpath?>signup/E/"><h1><?=$lang['Looking_for_Hire'] ?></h1></a>
          </div>
        </div>
      </div>
    </div>
    <!--Post Right End-->
   
</form>
<?php
	 }
	 else
	 {
	 ?>
 <div class="howitworks_box">
     <div class="howitworks_text">
    <?php	echo base64_decode($_REQUEST['msg']); ?>
  </div>
</div>

<?php } ?>
</div>
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?>
</body></html>