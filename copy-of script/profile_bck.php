<?php $current_page="Profile"; ?>
<?php ob_start();?>
<!--<link rel="stylesheet" href="<?php print $vpath;?>css/layout.css" type="text/css" media="screen" charset="utf-8" />
-->		<link rel="stylesheet" href="<?php print $vpath;?>css/jd.gallery.css" type="text/css" media="screen" charset="utf-8" />
 
<?php
include("include/header.php");
include("country.php");
?>
<?php
include("include/header_menu.php");

CheckLogin();
if($_SESSION['user_id']){$user_id=$_SESSION['user_id'];}else{$user_id=$_SESSION['usre_id'];}

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");



$row=mysql_fetch_array($res);



			if($row['gold_member']=='Y')

			{

				$mem=mysql_query("select * from ".$prev."membership where id=2");

				$rowmem=mysql_fetch_array($mem);

			}

			else

			{

				$mem=mysql_query("select * from ".$prev."membership where id=1");

				$rowmem=mysql_fetch_array($mem);		

			}

			$contnu=0;

			for($cn=0;$cn<=50;$cn++)

			{

				if($row[$cn]!='')

				{

					$contnu++;	

				}

			}

			$prfcomplt = ($contnu*100)/40;


if(empty($user_id)){header("Location: ".$vpath."login.php"); exit();}





if(isset($_POST['hiddProfileSubmit']))

{

	$e=explode("@",$_POST['email']);

	$valid_email=$e[1];

	if((empty($_REQUEST['email'])) || (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_REQUEST['email'])))

	{$emailerror="Please enter your valid email address.";}

	if(!emailerror)

	{

		if((checkdnsrr($valid_email)==false))

		{

			$emailerror="Please enter your valid email address.";

		}

		if(!$emailerror && (@mysql_num_rows(mysql_query("select user_id from ".$prev."user where email='".$_REQUEST['email']."' and user_id!=".$_SESSION['user_id']))))

		{

			$emailerror="This email address already used by another user.";

		}

	}

	$_SESSION['error'].=$emailerror;

	if(empty($_REQUEST['firstname'])){$fnameerror="Please enter your first name.";}

	$_SESSION['error'].=$fnameerror;

	if(empty($_REQUEST['lastname'])){$lnameerror="Please enter your last name.";}

	$_SESSION['error'].=$lnameerror;

	if(($_REQUEST['chkChangePassword']==1) && ((strlen(trim($_REQUEST['password']))<4) || (strlen(trim($_REQUEST['password']))>25))){$passerror="Please enter 4-25 charcter password.";$r2=false;}

	if(($_REQUEST['chkChangePassword']==1) && ($_REQUEST['password']!=$_REQUEST['password1'])){$cpasserror="Please enter correct confirm password.";$r2=false;}

	$_SESSION['error'].=$cpasserror;

	if(!$cpasserror && !$passerror && ($_REQUEST['oldPassword']!=""))

	{

		$r2=false;

		$r3=mysql_query("select user_id from ".$prev."user where password='".md5($_POST['oldPassword'])."' and user_id=".$_SESSION['user_id']);

		if(@mysql_num_rows($r3))

		{

			$r2=mysql_query("update ".$prev."user set password='".md5($_POST['password'])."' where user_id=".$_SESSION['user_id']);

			$subject="Password Changed";

			$mail_msg="Your password has been changed successfully. <br>

			Your New Password : ".$_POST['password']."<br>";

			$mail_type = 'change_password';

			

			genMailing($_REQUEST['email'], $subject, $mail_msg, $from = '', $reply = true, $mail_type,$_REQUEST['firstname'],$_REQUEST['lastname']);

		}

		else

		{

			$opasserror="Please enter correct old password.";

			$_SESSION['error'].=$opasserror;				

		}

	}

	elseif($_REQUEST['oldPassword']=="" && $_REQUEST['chkChangePassword']!=1)

	{

		$r2=true;

	}

	

	if(isset($_POST['trans_pass'])){

		mysql_query("update ".$prev."user set trans_pass='".md5($_POST['trans_pass'])."' where user_id=".$_SESSION['user_id']);

	}

	//echo '$emailerror: '.$emailerror.'$fnameerror:'.$fnameerror.'$lnameerror'.$lnameerror.'$r2:'.$r2. $_SESSION['error'];

	if(!$emailerror && !$fnameerror && !$lnameerror && $r2 && $_SESSION['error']=="")

	{



		$r=mysql_query("update ".$prev."user set 

		email=\"".$_REQUEST['email']."\",country=\"".$_REQUEST['country']."\",

		fname=\"".addslashes($_REQUEST['firstname'])."\",

		lname=\"".addslashes($_REQUEST['lastname'])."\",

		show_adult=\"".addslashes($_REQUEST['lstAdultPref'])."\",

		user_type=\"".addslashes($_REQUEST['user_type'])."\",company=\"" . $_REQUEST[company] . "\",rate=\"" . $_REQUEST[rate] . "\",profile=\"" . $_REQUEST[profile] . "\",

		edit_date=now()

		where user_id=".$_SESSION['user_id']);

	

	}

	

	

	if($r && $r2)

	{			

		if($_FILES['logo']['name']):

		   @copy($_FILES['logo']['tmp_name'],"portfolio/logo_" . $_SESSION['user_id'] ."." .substr($_FILES['logo']['name'],-3,3));

		   $r=mysql_query("update ".$prev."user set logo=\"portfolio/logo_" . $_SESSION['user_id'] ."." .substr($_FILES['logo']['name'],-3,3) . "\" where user_id=".$_SESSION['user_id']);

		endif;

		$_SESSION['succ']="Profile updated successfully.";

		$_SESSION['fullname']=addslashes($_REQUEST['firstname'])." ".addslashes($_REQUEST['lastname']);

	}

	else

	{

		$_SESSION['error'].="Update was unsuccessful.Please try again. ";

	}

}



$r4=mysql_query("select * from ".$prev."user where user_id=".$_SESSION['user_id']);

$d=@mysql_fetch_array($r4);



?>

<!--<script type="text/javascript" src="js/jquery.js"></script>-->





<script type="text/javascript">

<!--

/*$(document).ready(function() {

 

	$('.job_tab a').click(function(){

		switch_tabs($(this));

	});

 

	switch_tabs($('.defaulttab'));

 

});*/

 

function switch_tabs(obj)

{

	$('.work_box').hide();

	$('.job_tab a').removeClass("selected");

	var id = obj.attr("rel");

 

	$('#'+id).show();

	obj.addClass("selected");

}

//-->

</script>







<script type="text/javascript" src="js/tabcontent.js">



/***********************************************

* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)

* This notice MUST stay intact for legal use

* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code

***********************************************/



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

</script>





<script>



function ValidateForm() {

	

	form1 = document.forms['_profile'];

	

	if (form1.elements['firstname'].value == '') {

		alert('Please fill *First Name* field!');

		form1.elements['firstname'].focus();

		return false;

	}



	if (form1.elements['lastname'].value == '')

	{

		alert('Please fill *Last Name* field!');

		form1.elements['lastname'].focus();

		return false;

	}

	if (form1.elements['country'].value == '')

	{

		alert('Enter Country name!');

		form1.elements['country'].focus();

		return false;

	}



	if (form1.elements['email'].value == '') {

		alert('Please fill *E-Mail* field!');

		form1.elements['email'].focus();

		return false;

	}

	else if (!ValidEmail(form1.elements['email'].value)) {

		alert('Wrong *E-Mail* field!');

		form1.elements['email'].focus();

		return false;

	}

	else if(emailValidFlag == 0)

	{

		alert('Email Id already in use');

		form1.elements['email'].focus();

		return false;

	}

	if(form1.elements['chkChangePassword'].checked == true)

	{

		if(form1.elements['oldPassword'].value == "")

		{

			alert("Please enter old password");

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

			alert("Please enter new password");

			form1.elements['password'].focus();

			return false;

		}

		if (form1.elements['password1'].value == '') {

			alert('Please fill *Confirm password* field.');

			form1.elements['password1'].focus();

			return false;

		}

		if (form1.elements['password'].value != form1.elements['password1'].value) 

		{

			alert("Two passwords don't match");

			form1.elements['password'].focus();

			return false;

		}

		if (form1.elements['trans_pass'].value == '') {

			alert('Please fill *Transaction password* field.');

			form1.elements['trans_pass'].focus();

			return false;

		}

	}



	return true;

}

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

	<script src="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"></script>

	<script src="<?=$vpath?>js/slides.min.jquery.js"></script>

	<script>

		$(function(){

			$('#slides').slides({

				preload: true,

				preloadImage: '<?=$vpath?>img/loading.gif',

				play: 5000,

				pause: 2500,

				hoverPause: true

			});

		});

	</script>

	<style>.next {

margin: 0px;

padding: 0px;

float: right;

}

.project_title{



   	color:#0099FF;



	font-family:Arial, Helvetica, sans-serif;



	font-size:17px;



	font-weight:bold;



    float: left;



    margin: 0 0 6px;



    padding:0px 0px 6px 0px;



    width: 745px;



	text-decoration:none;



    }



	



.project_title h1{



    margin:12px 0px 12px 0px;



    padding:0px 0px 0px 0px;



    width: 745px;



   	color: #999999;



	font-family:Arial, Helvetica, sans-serif;



	font-size:13px;



	float:left;



	font-weight: normal;



    }

	

.portfolio_box_pic_box{



    float: left;



    margin: 18px;



    padding: 0;



    width: 150px;



   }



   



.portfolio_box_pic_box h1{



    margin:4px 0px 4px 0px;



    padding:0px 0px 0px 0px;



    width:100%;



   	color: #999999;



	text-align:center;



	font-family:Arial, Helvetica, sans-serif;



	font-size:13px;



	float:left;



	font-weight: normal;



    }

.pagination{

display:none;

}





</style>

<!------Start-middle-------->
<div class="inner-middle">
<div class="dash_headding">
<p><a href="#">Home</a> | <a href="#" class="selected">My Profile</a></p></div>
<div class="clear"></div>



<!--Dashboard Left Start-->
<div class="profile_left">
<div class="user_box">
<div class="user_text"><h1>Profile completeness</h1></div>
  <?php include("include/right_completeness.php");?>
  <div class="improve_bnt"><a href="#">Improve&nbsp;your&nbsp;Profile</a></div>
</div><br />

<?php include("include/leftpanel.php");?>

</div>



<!--Dashboard Left End-->


<!--Dashboard Right Start-->
<div class="profile_right">
<div class="profile_text">
  <p>“Please note that Individual Profile must be completed 100% to enjoy the benefits of no markup fees or commission charges on<br />
    all proposals.”</p>
    </div>

<div class="latest_worbox">
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_box" >
  
  <tr>
    <td height="28" style="padding-bottom:4px; border-bottom:#a8caeb 1px solid;">
    <table align="left" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="19%" align="left" style=" padding-left:8px;"><p><span><?=ucfirst(stripslashes($d['fname']))?>&nbsp;<?=ucfirst(stripslashes($d['lname']))?></span></p></td>
    <td width="15%" align="left"><a href="#"><img src="images/get-verified_icon.png" width="98" height="24" /></a></td>
    <td width="30%">&nbsp;</td>
    <td width="36%"><div class="edit_bott" style="margin-top:5px;"><a class="selected" href="#">Edit&nbsp;&nbsp;<img src="images/edit_icon1.png" /></a></div></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td height="12"></td>
  </tr>
  
  <tr>
    <td><table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="tab_box" >
      <tr>
        <td width="17%" align="center" valign="top"><img src="images/profile_img.jpg" style="border:#bddeff 1px solid; padding:4px;" /></td>
        <td width="2%" align="left" valign="top"></td>
        <td width="81%" align="left" valign="top"><h3>
          Joined: <span><?=stripslashes($d['reg_date'])?></span><br />
          Location:  <span><img src="cuntry_flag/<?=strtolower($d[country]);?>.png" title="<?=$country_array[$d[country]];?>" width="16" height="11" ></span> <?php print $country_array[$d[country]];?><br/>
          City: <span><?=stripslashes($d['city'])?>, <?=stripslashes($d['state'])?></span><br />
          Last sign-in: <span><?php print date('d-M-Y, h:i:s a', strtotime($_SESSION['ldate']));?></p></a></span><br />
          Specialty: <span>Design &amp; multimedia</span><br />
          Minimum Hourly Rate : <span>$<?=stripslashes($d['rate'])?></span><br />
          
			<?php if($d['user_type']=='E'){echo 'Looking to hire & buy';}?> 



			<?php if($d['user_type']=='B'){echo 'Looking to both work , hire & buy';}?></p>

          </span></h3></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="12"></td>
  </tr>
  <tr>
    <td><p><span>Overview </span></p></td>
  </tr>
  <tr>
    <td height="22" class="edit_tab"><h3><?=stripslashes($d['profile'])?><br />
<br />
</h3><br /></td>
  </tr>
  <tr>
    <td><p><span>Service description</span></p></td>
  </tr>
  <tr>
    <td height="12"></td>
  </tr>
    <?php
  $skill_q="select c.cat_name,c.cat_id from ".$prev."categories c inner join ".$prev."user_cats u on c.cat_id=u.cat_id where user_id=".$_SESSION[user_id];



$res_skill=mysql_query($skill_q);



while($data_skill=@mysql_fetch_array($res_skill))



{



	$data_cat_name.=  " <tr>
        <td width=\"3%\" height=\"22\" valign=\"middle\"><p><img src=\"images/service-description_icon.png\" width=\"10\" height=\"7\" /></p></td>
        <td width=\"64%\"><p><a class='text_hover' href='browse-freelancers.php?user=W&skills=".$data_skill[cat_id]."'>".ucfirst(strtolower($data_skill['cat_name'])).'</a></p></td>
        <td width="33%">&nbsp;</td>
      </tr> ';



}



$cat_name=substr($data_cat_name,0,-1);

?>
  <tr>
    <td height="22"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">

  <?php echo $cat_name;?>
     
      <tr>
        <td height="22">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="22"></td>
  </tr>
  <tr>
    <td style="padding-bottom:4px; border-bottom:#a8caeb 1px solid;">
    <table align="left" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="28%" height="48" align="left" style=" padding-left:8px;"><p><span>My portfolio</span></p></td>
    <td width="72%"><div class="edit_bott" style="margin-top:5px;"><a class="selected" href="#">Edit&nbsp;&nbsp;<img src="images/edit_icon1.png" /></a></div></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td height="22"></td>
  </tr>
  <tr>
    <td><div id="myGallery">
				<div class="imageElement">
					<h3>Item 1 Title</h3>
					<p>Item 1 Description</p>
					<a href="#" title="open image" class="open"></a>
					<img src="images/brugges2006/1.jpg" class="full" />
					<img src="images/brugges2006/1-mini.jpg" class="thumbnail" />				</div>
				<div class="imageElement">
					<h3>Item 2 Title</h3>
					<p>Item 2 Description</p>
					<a href="#" title="open image" class="open"></a>
					<img src="images/brugges2006/2.jpg" class="full" />
					<img src="images/brugges2006/2-mini.jpg" class="thumbnail" />				</div>
				<div class="imageElement">
					<h3>Item 3 Title</h3>
					<p>Item 3 Description</p>
					<a href="#" title="open image" class="open"></a>
					<img src="images/brugges2006/1.jpg" class="full" />
					<img src="images/brugges2006/1-mini.jpg" class="thumbnail" />				</div>
				<div class="imageElement">
					<h3>Item 4 Title</h3>
					<p>Item 4 Description</p>
					<a href="#" title="open image" class="open"></a>
					<img src="images/brugges2006/2.jpg" class="full" />
					<img src="images/brugges2006/2-mini.jpg" class="thumbnail" />				</div>
				<div class="imageElement">
					<h3>Item 5 Title</h3>
					<p>Item 5 Description</p>
					<a href="#" title="open image" class="open"></a>
					<img src="images/brugges2006/1.jpg" class="full" />
					<img src="images/brugges2006/1-mini.jpg" class="thumbnail" />				</div>
				<div class="imageElement">
					<h3>Item 6 Title</h3>
					<p>Item 6 Description</p>
					<a href="#" title="open image" class="open"></a>
					<img src="images/brugges2006/2.jpg" class="full" />
					<img src="images/brugges2006/2-mini.jpg" class="thumbnail" />				</div>
				<div class="imageElement">
					<h3>Item 7 Title</h3>
					<p>Item 7 Description</p>
					<a href="#" title="open image" class="open"></a>
					<img src="images/brugges2006/1.jpg" class="full" />
					<img src="images/brugges2006/1-mini.jpg" class="thumbnail" />				</div>
				<div class="imageElement">
					<h3>Item 8 Title</h3>
					<p>Item 8 Description</p>
					<a href="#" title="open image" class="open"></a>
					<img src="images/brugges2006/2.jpg" class="full" />
					<img src="images/brugges2006/2-mini.jpg" class="thumbnail" />				</div>
			</div></td>
  </tr>
  <tr>
    <td height="22"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="10%">&nbsp;</td>
        <td width="49%"><div class="edit_bott" style="margin-top:5px;"><a class="selected" href="#">View&nbsp;All&nbsp;»</a></div></td>
        <td width="41%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="12"></td>
  </tr>
  <tr>
    <td style="padding-bottom:4px; border-bottom:#a8caeb 1px solid;"><table align="left" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="28%" height="48" align="left" style=" padding-left:8px;"><p><span>My Skills</span></p></td>
    <td width="72%"><div class="edit_bott" style="margin-top:5px;"><a class="selected" href="#">Add&nbsp;skill&nbsp;+</a></div></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td height="22"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="80%" height="30">&nbsp;</td>
        <td width="2%"><img src="images/tested1.jpg" width="8" height="8" /></td>
        <td width="7%">Tested</td>
        <td width="2%"><img src="images/tested2.jpg" width="8" height="8" /></td>
        <td width="9%"> Self-rated</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="22"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="background:#d6e8fa;">
      <tr>
        <td width="16" height="28"></td>
        <td width="387"><strong>Skill 						       					   </strong></td>
        <td width="342"><strong>Score</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="95%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#CCCCCC dotted 1px; padding-bottom:6px; margin-left:15px; margin-top:12px;">
      <tr>
        <td width="66%"><p>HTML</p> </td>
        <td width="17%"><img src="images/test-now_icon.jpg" width="102" height="10" /></td>
        <td width="17%"><p>Test Now</p></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td ><table width="95%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#CCCCCC dotted 1px; padding-bottom:6px; margin-left:15px; margin-top:12px;">
      <tr>
        <td width="66%"><p>HTML</p> </td>
        <td width="17%"><img src="images/test-now_icon.jpg" width="102" height="10" /></td>
        <td width="17%"><p>Test Now</p></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="95%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#CCCCCC dotted 1px; padding-bottom:6px; margin-left:15px; margin-top:12px;">
      <tr>
        <td width="66%"><p>HTML</p> </td>
        <td width="17%"><img src="images/test-now_icon.jpg" width="102" height="10" /></td>
        <td width="17%"><p>Test Now</p></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="95%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#CCCCCC dotted 1px; padding-bottom:6px; margin-left:15px; margin-top:12px;">
      <tr>
        <td width="66%"><p>HTML</p> </td>
        <td width="17%"><img src="images/test-now_icon.jpg" width="102" height="10" /></td>
        <td width="17%"><p>Test Now</p></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="22"></td>
  </tr>
  <tr>
    <td height="22"></td>
  </tr>
</table>

</div>


</div>
<!--Dashboard Right End-->


</div>
	<script src="<?php print $vpath;?>js/mootools-1.2.1-core-yc.js" type="text/javascript"></script>
		<script src="<?php print $vpath;?>js/mootools-1.2-more.js" type="text/javascript"></script>
		<script src="<?php print $vpath;?>js/jd.gallery.js" type="text/javascript"></script>
		<script type="text/javascript">
			function startGallery() {
				var myGallery = new gallery($('myGallery'), {
					timed: true
				});
			}
			window.addEvent('domready',startGallery);
		</script>


<!------end_middle-------->
<?php
include("include/footer.php");
?>
