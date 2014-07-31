<?php 

$current_page = "My Profile";

include "includes/header.php";

include("country.php");



CheckLogin();

?>

<?php

//if(!$link){header("Location: ./index.php"); exit();}



if($_SESSION['user_id']){$user_id=$_SESSION['user_id'];}else{$user_id=$_SESSION['usre_id'];}



if(empty($user_id)){header("Location: ".$vpath."login.php"); exit();}

if(isset($_POST['hiddProfileSubmit']))

{

	

	if(empty($_REQUEST['firstname'])){$fnameerror=$lang['ALERT_P3'];}

	$_SESSION['error'].=$fnameerror;

	if(empty($_REQUEST['lastname'])){$lnameerror=$lang['ALERT_P4'];}

	$_SESSION['error'].=$lnameerror;

	


	if(!$emailerror && !$fnameerror && !$lnameerror &&  $_SESSION['error']=="")

	{



		$r=mysql_query("update ".$prev."user set 

		country=\"".$_REQUEST['country']."\",
		
		fname=\"".addslashes($_REQUEST['firstname'])."\",

		lname=\"".addslashes($_REQUEST['lastname'])."\",
		slogan=\"".addslashes($_REQUEST['slogan'])."\",

		show_adult=\"".addslashes($_REQUEST['lstAdultPref'])."\",

		company=\"" . $_REQUEST[company] . "\",rate=\"" . $_REQUEST[rate] . "\",profile=\"" . $_REQUEST[profile] . "\",work_experience=\"" . $_REQUEST[work_experience] . "\",

		edit_date=now()

		where user_id=".$_SESSION['user_id']);

	

	}

	

	

	if($r)

	{			

		if($_FILES['logo']['name']):

		   @copy($_FILES['logo']['tmp_name'],"portfolio/logo_" . $_SESSION['user_id'] ."." .substr($_FILES['logo']['name'],-3,3));

		   $r=mysql_query("update ".$prev."user set logo=\"portfolio/logo_" . $_SESSION['user_id'] ."." .substr($_FILES['logo']['name'],-3,3) . "\" where user_id=".$_SESSION['user_id']);

		endif;

		$_SESSION['succ']=$lang['ALERT_P10'];

		$_SESSION['fullname']=addslashes($_REQUEST['firstname'])." ".addslashes($_REQUEST['lastname']);
		$_SESSION[user_type]=addslashes($_REQUEST['user_type']);

	}

	else

	{

		$_SESSION['error'].=$lang['ALERT_P11'];

	}

}



$r4=mysql_query("select * from ".$prev."user where user_id=".$_SESSION['user_id']);

$d=@mysql_fetch_array($r4);

?>



<script>

<!--



//Enter-listener

if (document.layers)

  document.captureEvents(Event.KEYDOWN);

  document.onkeydown =

    function (evt) 

    { 

      var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;

      if (keyCode == 13)   //13 = the code for pressing ENTER

      {

         sendRequest();

      }

    }

var passwordValidFlag=-1,emailValidFlag=-1;

function ValidEmail(EmailAddress)

 {

  if ((EmailAddress.indexOf(' ') >= 0) || (EmailAddress.indexOf(';') >= 0) || (EmailAddress.indexOf(',') >= 0) || (EmailAddress.indexOf('@') < 1)) return false;

  if (EmailAddress.substr(EmailAddress.indexOf('@')).indexOf('.') < 2) return false;

  if (EmailAddress.substr(EmailAddress.indexOf('.',EmailAddress.indexOf('@'))).length < 3) return false;

  return true 

 }



function ValidateForm() {

	

	form1 = document.forms['_profile'];

	

	if (form1.elements['firstname'].value == '') {

		alert("<?=$lang['ALERT_P12']?>");

		form1.elements['firstname'].focus();

		return false;

	}



	if (form1.elements['lastname'].value == '')

	{

		alert("<?=$lang['ALERT_P13']?>");

		form1.elements['lastname'].focus();

		return false;

	}

	if (form1.elements['country'].value == '')

	{

		alert("<?=$lang['ALERT_P15']?>");

		form1.elements['country'].focus();

		return false;

	}



	if (form1.elements['email'].value == '') {

		alert("<?=$lang['ALERT_P14']?>");

		form1.elements['email'].focus();

		return false;

	}

	else if (!ValidEmail(form1.elements['email'].value)) {

		alert("<?=$lang['ALERT_P16']?>");

		form1.elements['email'].focus();

		return false;

	}

	else if(emailValidFlag == 0)

	{

		alert("<?=$lang['ALERT_P17']?>");

		form1.elements['email'].focus();

		return false;

	}

	if(form1.elements['chkChangePassword'].checked == true)

	{

		if(form1.elements['oldPassword'].value == "")

		{

			alert("<?=$lang['ALERT_P18']?>");

			form1.elements['oldPassword'].focus();

			return false;

		}

		/*else if(passwordValidFlag == -1 || passwordValidFlag == 0)

		{

			alert("Password entered is not correct");

			form1.elements['oldPassword'].focus();

			return false;

		}*/

		if(form1.elements['password'].value == "")

		{

			alert("<?=$lang['ALERT_P19']?>");

			form1.elements['password'].focus();

			return false;

		}

		if (form1.elements['password1'].value == '') {

			alert("<?=$lang['ALERT_P20']?>");

			form1.elements['password1'].focus();

			return false;

		}

		if (form1.elements['password'].value != form1.elements['password1'].value) 

		{

			alert("<?=$lang['ALERT_P21']?>");

			form1.elements['password'].focus();

			return false;

		}

		if (form1.elements['trans_pass'].value == '') {

			alert("<?=$lang['ALERT_P22']?>");

			form1.elements['trans_pass'].focus();

			return false;

		}

	}



	return true;

}

function fnDisplayWaitPopUp()

{

	//alert("kalpesh");

	$('process_waiting_dialog').style.top = Math.round((document.body.clientHeight/2)-50+document.body.scrollTop)+'px';

	$('process_waiting_dialog').style.left =Math.round((document.body.clientWidth/2)-150)+"px";

	new Effect.Appear('process_waiting_dialog',{duration:.1});

}

function sendRequest()

{

	if(ValidateForm())

	{

		//new Effect.DropOut('mainContent'); 

		fnDisplayWaitPopUp();

		//window.setTimeout('Effect.Appear(\'mainContent\', {duration:.3})',2500);

		var form1 = document.forms['_profile'];

		new Ajax.Updater("mainContent","profile.php?action=updateProfile",{method:'post',parameters:Form.serialize(form1),asynchronous:false, onSuccess:function(t){ new Effect.toggle('process_waiting_dialog','appear');}});

	}

}



function checkForOldPassword()

{//alert("sdfsdf");

	var form1 = document.forms['_profile'];

	

	if(form1.elements['chkChangePassword'].checked == true)

	{

		var requestOptions;

		requestOptions = {

					method:'post',

					parameters:'oldPassword='+form1.elements['oldPassword'].value+'',

					onSuccess: function(t)

					{//alert("sdrsrer");

						passwordValidFlag = t.responseText;

						//$('passwordErrorMessage').innerHTML = t.responseText;

						if(t.responseText == '0')

						{

							passwordValidFlag = 0;

							$('passwordErrorMessage').innerHTML = $lang['ALRT_30_H'];

						}

						else

						{

							passwordValidFlag = 1;

							$('passwordErrorMessage').innerHTML = "";

						}

						

					},

					onFailure: function(t) {

						alert($lang['ALRT_31_H'] + t.statusText);

					}

				}

		

		new 

		Ajax.Request("profilechk.php?action=validatePassword",requestOptions);

	}

}

function checkForEmailId()

{

	var form1 = document.forms['_profile'];

//	alert("here");

	var requestOptions;

		requestOptions = {

					method:'post',

					parameters:'email='+form1.elements['email'].value+'',

					onSuccess: function(t)

					{

					

						

						$('divEmailErrorMessage').innerHTML = t.responseText;

						if(t.responseText == 1)

						{

							emailValidFlag = 0;

							$('divEmailErrorMessage').innerHTML = $lang['ALERT_P17'];

						}

						else

						{

							emailValidFlag = 1;

							$('divEmailErrorMessage').innerHTML = "";

						}

					}

				}

		

		new 

		Ajax.Request("profilechk.php?action=validateEmailId",requestOptions);

}

// -->



</script>



<script language="javascript" type="text/javascript">

var browser=navigator.appName;

	if(browser=="Microsoft Internet Explorer")

	{

		var displaystyle="block";

	}

	else

	{

		var displaystyle="table-row";

	}

function showpass()

	{

		if(document.getElementById("chkChangePassword").checked==true)

		{

			document.getElementById("olspass").style.display=displaystyle;

			document.getElementById("newpass").style.display=displaystyle;

			document.getElementById("confpass").style.display=displaystyle;

			document.getElementById("transpass").style.display=displaystyle;

		}		

		else

		{

			document.getElementById("olspass").style.display="none";

			document.getElementById("newpass").style.display="none";

			document.getElementById("confpass").style.display="none";

			document.getElementById("transpass").style.display="none";

		}

	}

	function gtec(id){
	$('.asd').toggle();
	}
</script>





<!-----------Header End-----------------------------> 



<!-- content-->
<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="<?=$vpath?>myprofile.html"><?=$lang['PROFESSIONAL_PROFILE']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['EDIT_PROF_PROFILE']?></a></p></div>
<div class="clear"></div>

<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 

    <!-- left side-->

    <!--middle -->

	

  <div class="profile_right">



  

  



  

   <ul class="tabs">
  <li><a href="javascript:void(0)" class="selected"><?=$lang['EDIT_PROF_PROFILE']?></a></li>
  </ul>

<div class="newclassborder">

<div class="create_profile2">





 	

  

    <form  method="post" name="_profile" id="_profile" enctype="multipart/form-data">

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_class">

    



    <tr>

    <td align="left" valign="top" class="bx-border">

    <table border="0" cellpadding="4" cellspacing="0" align="center" width="97%"  >



        <tr><td colspan="2" align="center" >

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

		</td></tr>



    <tr ><td class="tdclass" width="264" ><b><?=$lang['USER_NAM']?>: </b></td>

    <td  ><?=stripslashes($d['username'])?></td></tr>
 <tr>

      <td valign=top  class="tdclass"><strong><?=$lang['SlOGAN']?> : </strong></td>

      <td ><input type=text name=slogan  value="<?=$d[slogan]?>" size="30" class="from_input_box"/></td>

    </tr>
    <tr >

    <td class="tdclass" ><b><?=$lang['F_NAME']?>: * </b></td>

    <td >

    <input name="firstname" type="text" value="<?=stripslashes($d['fname'])?>" size="30" class="from_input_box"/>

    <?php if($fnamerror){echo"<br /><span class='lnkred'><b>".$fnamerror."</b></span>";}?>		

    </td>

    </tr>

    <tr>

    <td class="tdclass"><b><?=$lang['L_NAME']?>: * </b></td>

    <td class="grid"><input name="lastname" type="text" value="<?=stripslashes($d['lname'])?>" size="30" class="from_input_box"/>

    <?php if($lnamerror){echo"<br /><span class='lnkred'><b>".$lnamerror."</b></span>";}?>		</td>

    </tr>

    

  



  

    



   
  

   
	<? if($d[account_type]=='C'){?>
    <tr>

      <td valign=top  class="tdclass"><strong><?=$lang['CM_NAME']?> : </strong></td>

      <td ><input type=text name=company  value="<?=$d[company]?>" size="30" class="from_input_box"/></td>

    </tr>
<? }?>
    <tr  ><td valign=top  class="tdclass"><strong><?=$lang['CN_NAME']?>: *</strong></td><td ><select name="country" id="country" size="1" class="from_input_box" style="width:351px;">

    <option value=""><?=$lang['CON_SL']?></option>

    <?php

    $arr=array_keys($country_array);

    for($i=0;$i<count($arr);$i++):

    if($arr[$i]==$d['country']):

    echo"<option value='" . $arr[$i] . "' selected>" . $country_array[$arr[$i]] . "</option>\n";

    else:

    echo"<option value='" . $arr[$i] . "' >" . $country_array[$arr[$i]] . "</option>\n"; 

    endif;	  

    endfor;

    ?>

    </select>

    </td></tr>

    <tr>

      <td  class="tdclass" valign=top ></td>

      <td >

    

    <?php

    

    if(!empty($d[logo]))

    {

    $temp_logo=$d[logo];

    }

    else

    {

    $temp_logo="images/face_icon.gif";

    }

    

    ?>

    

    

    

     <img src="viewimage.php?img=<?php echo $temp_logo;?>&width=60&height=60" title=""  alt="" /><br />

    

    <input type="file" name="logo" size="30" class="from_input_box"></td></tr>

    <tr  >

      <td valign=top class="tdclass"><strong><?=$lang['CM_PRFL']?>: </strong></td>

	

      <td >

	 <?php if($d[profile]!="")

	 {?>

	 <textarea rows="3" id="profile"  name="profile" class="text_box" ><?=$d[profile]?></textarea>

	 <?php

	 }

	 else

	 {

	 ?>

	 <textarea rows="3" id="profile"  name="profile" class="text_box" ></textarea>

	 <?php

	 }

	 ?>

    <br><span class=boldfont_con style="float:left"><?=$lang['PUB_INFO']?></span></td></tr>
 <tr  >

      <td valign=top class="tdclass"><strong><?=$lang['WORK_EXP']?>: </strong></td>

	

      <td >


	 <textarea rows="3" id="work_experience"  name="work_experience" class="text_box" ><?=$d[work_experience]?></textarea>


	 

    <br><span class=boldfont_con style="float:left"><?=$lang['PUB_INFO']?></span></td></tr>
    <tr ><td class="tdclass" ><strong><?=$lang['AVS_HOURLY_RATE']?> : *</strong></td>

	<td ><INPUT type="text" id=rate name="rate" value="<?=$d[rate]?>" maxlength="5" size="3" class="from_input_box">&nbsp; <span class="boldfont_con" style="float:left;width: 100px;"><?=$lang['USD_HR']?></span></td></tr>

    </table>

    </td></tr>

    <tr><td>&nbsp;</td></tr>

    <tr>

    <td align="left" valign="top" class="inner_bx-bottom">

    <table align="center" width="100%" cellpadding="0" cellspacing="0">

    <tr class="lnk"><td width=39%></td>

    <td >

    <input type="submit"  class="submit_bott" value="<?=$lang['UPD_PRF']?>" onClick="return ValidateForm();"  />

  

   <!-- <input type="image" src="images/update.jpg"  onClick="return ValidateForm();" />-->

    <input type="hidden" name="hiddProfileSubmit" value="1"> 

    <br />

    </td>

    </tr>

    </table>

    </td>

    </tr>

    </table>

    </form>



										

  </div>



</div>



  </div>



   

</div>

</div></div>



<?php include 'includes/footer.php';?>