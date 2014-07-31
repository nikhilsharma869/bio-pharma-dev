<?php
$current_page = "<p>My Jobs</p>"; 

include "includes/header.php"; 

CheckLogin();

$openjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='open'"));
$closejobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='frozen'"));
$closedjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='complete'"));
$cancelledjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='cancelled'"));


$r4=mysql_query("select * from ".$prev."user where user_id=".$_SESSION['user_id']);

$d=@mysql_fetch_array($r4);
$type=$d['user_type'];
$no_of_records=20;
?>
<script type="text/javascript" src="<?=$vpath?>js/general_functions.js"></script>
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

		alert(<?=$lang['ALERT_P12']?>);

		form1.elements['firstname'].focus();

		return false;

	}

	else if (!isWithLegalCharachters(form1.elements['firstname'].value))

	{

		alert(<?=$lang['ENTER_PROPER_NAME']?>);

		form1.elements['firstname'].focus();

		return false;

	}

	if (form1.elements['lastname'].value == '')

	{

		alert(<?=$lang['ALERT_P13']?>);

		form1.elements['lastname'].focus();

		return false;

	}

	if (form1.elements['country'].value == '')

	{

		alert(<?=$lang['ALERT_P15']?>);

		form1.elements['country'].focus();

		return false;

	}

	else if (!isWithLegalCharachters(form1.elements['lastname'].value))

	{

		alert(<?=$lang['ENTER_PROPER_LAST_NAME']?>);

		form1.elements['lastname'].focus();

		return false;

	}

	if (form1.elements['email'].value == '') {

		alert(<?=$lang['ALERT_P14']?>);

		form1.elements['email'].focus();

		return false;

	}

	else if (!ValidEmail(form1.elements['email'].value)) {

		alert(<?=$lang['ALERT_P16']?>);

		form1.elements['email'].focus();

		return false;

	}

	else if(emailValidFlag == 0)

	{

		alert(<?=$lang['ALERT_P17']?>);

		form1.elements['email'].focus();

		return false;

	}

	if(form1.elements['chkChangePassword'].checked == true)

	{

		if(form1.elements['oldPassword'].value == "")

		{

			alert(<?=$lang['ALERT_P18']?>);

			form1.elements['oldPassword'].focus();

			return false;

		}

		else if(passwordValidFlag == -1 || passwordValidFlag == 0)

		{

			alert(<?=$lang['PASSWORD_ENTERED_NOT_CORRECT']?>);

			form1.elements['oldPassword'].focus();

			return false;

		}

		if(form1.elements['password'].value == "")

		{

			alert(<?=$lang['ALERT_P19']?>);

			form1.elements['password'].focus();

			return false;

		}

		if (form1.elements['password1'].value == '') {

			alert(<?=$lang['ALERT_P20']?>);

			form1.elements['password'].focus();

			return false;

		}

		if (form1.elements['password'].value != form1.elements['password1'].value) 

		{

			alert(<?=$lang['ALERT_P21']?>);

			form1.elements['password'].focus();

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

					{alert("sdrsrer");

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

		}		

		else

		{

			document.getElementById("olspass").style.display="none";

			document.getElementById("newpass").style.display="none";

			document.getElementById("confpass").style.display="none";

		}

	}

</script>
<script type="text/javascript" src="<?=$vpath?>domcollapse.js"></script>

<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['MY_ASS_JOBS']?></a></p></div>
<div class="clear"></div>

<?php include 'includes/leftpanel1.php';?>

<!-- left side--> 

<!--middle -->


  
  <!--Profile Right Start-->
  <div class="profile_right">
    <div id="wrapper_3">
      <ul class="tabs">      
                 <?php /*if($type == 'W'){	?>
				
				<li><a href="<?=$vpath?>mybids.html" rel="tabs2"><?=$lang['MY_BIDS']?></a></li>
				
				<li><a href="<?=$vpath?>lostbids.html" rel="tabs2"><?=$lang['LOST_BIDS']?></a></li>
				
				<li><a href="<?=$vpath?>closedbids.html" rel="tabs2" class="selected"><?=$lang['COMPLETE_JOBS']?></a></li>
			  
			  	<? } */?>
			  
			  	<?php /*if($type == 'E'){ ?>      
                
				<li><a href="<?=$vpath?>my-jobs.html"  rel="tabs1"><?=$lang['MY_JOBS']?></a></li>
				
				<li><a href="<?=$vpath?>active_jobs.html" rel="tabs2"><?=$lang['ACTIVE_JOB']?></a></li>
        		
				<li><a href="<?=$vpath?>running_jobs.html" rel="tabs2"><?=$lang['RUNNING_JOBS']?></a></li>
				
				<li><a href="<?=$vpath?>closed_jobs.html" rel="tabs2"><?=$lang['CLOSED_JOBS']?></a></li>
				
				<li><a href="<?=$vpath?>bidhistory.html" rel="tabs2"><?=$lang['JOB_HISTRY']?></a></li>
				
				<? } */?>
				
				
            	<?php //if($type == 'B') {  ?>
				
				<li><a href="<?=$vpath?>my-jobs.html" class="selected" rel="tabs1">
          <?=$lang['MY_PROJECTS']?>
          </a></li>
        <li><a href="<?=$vpath?>active_jobs.html" rel="tabs2">
          <?=$lang['OPEN_PROJECTS']?>
          </a></li>
        <li><a href="<?=$vpath?>running_jobs.html" rel="tabs2">
          <?=$lang['WORKING_PROJECTS']?>
          </a></li>
        <li><a href="<?=$vpath?>closed_jobs.html" rel="tabs2">
          <?=$lang['CANCELED_PROJECTS']?>
          </a></li>
           <li><a href="<?=$vpath?>closedbids.html" rel="tabs2">
          <?=$lang['COMPLETE_PROJECTS']?>
          </a></li>
        <li><a href="<?=$vpath?>mybids.html" rel="tabs2">
          <?=$lang['MY_BIDS']?>
          </a></li>
        <li><a href="<?=$vpath?>lostbids.html" rel="tabs2">
          <?=$lang['LOST_BIDS']?>
          </a></li>
		
		
				<!--<li><a href="<?//=$vpath?>bidhistory.html" rel="tabs2"><?//=$lang['JOB_HISTRY']?></a></li>-->
				
				<? //} ?>
              </ul>
      <div class="browse_tab-content">
        <div class="browse_job_middle"> 
          
          <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  -->
          
          <table width="743" border="0" align="center" cellpadding="0" cellspacing="0" >
            
              <td><!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                
                <table  class="space_left2" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php
						if(isset($_SESSION['select_provider']))
						{
						?>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><?php
							$_SESSION['error']=$_SESSION['select_provider'];
							include('includes/err.php');
							unset($_SESSION['error']);
							unset($_SESSION['select_provider']);
						?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <?php
						}
						?>
                  <tr>
                    <td align="left" valign="top" class="bx-border"><?

						//---------------------------------------

						//Avijit

						if($_REQUEST[confirm] && $_REQUEST[mode])
						{
							
						
								

						if(mysql_query("UPDATE " . $prev . "buyer_bids SET chose='Y' WHERE project_id='$_REQUEST[confirm]' and bidder_id='$_SESSION[user_id]'"))

						{

							mysql_query("UPDATE " . $prev . "projects SET status='process' WHERE id='$_REQUEST[confirm]' and chosen_id='$_SESSION[user_id]'");

							

							

							

					$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$_SESSION['user_id']));

					$proj = mysql_fetch_array(mysql_query("SELECT * from ".$prev."projects where id=".$_GET['id']));

					$emp = 	mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$proj['user_id']));	
					

					$message = $lang['BID_ACCPT']."<br /><br />".

								$lang['PROJECT_NAMEE'].": ".$proj['project'];

					//exit;

					$msg = mysql_query("INSERT into ".$prev."messages set 

					receiver=".$emp['user_id'].",

					sender_id=".$_SESSION['user_id'].",

					sender='".$usr['email']."' ,

					subject='".$lang['BID_ACCPT']."',

					message='".$message."',

					user_type='sender',

					sent_time='".date('Y-m-d h:i:s')."',

					status='Y',

					message_type='A'");

					

					$msg2 = mysql_query("INSERT into ".$prev."messages set 

					receiver=".$emp['user_id'].",

					sender_id=".$_SESSION['user_id'].",

					sender='".$usr['email']."' ,

					subject='".$lang['BID_ACCPT']."',

					message='".$message."',

					user_type='reciver',

					sent_time='".date('Y-m-d h:i:s')."',

					status='Y',

					message_type='A'");

			

		

			$notify = mysql_query("INSERT into ".$prev."notification set user_id=".$emp['user_id'].", message='".$lang['BID_ACCPT']."', add_date='".date('Y-m-d')."'");

			$to  = $emp['email'];
			$to1=$usr['email'];

			////////////////////////////////////////////////////////////////////////////////////////

			////////////////////////////////////////////////////////////////////////////////////////

					/* $res2=mysql_query("select * from ".$prev."mailsetup where mail_type=\"hire_contract_begins\"");

					$row=mysql_fetch_array($res2);

					

					//$email = mysql_fetch_assoc(mysql_query("select * from ".$prev."user where user_id=".$_GET['id']));

					$admin = mysql_fetch_assoc(mysql_query("select * from ".$prev."paypal_settings"));

					$to  = $emp['email'];

					$subject = $lang['MYJOBS_EM_SUB1'];

					$message = '

					<html>

					<head>

					<title>'.$dotcom.$lang['NOTIFICATION'].'</title>

					</head>

					<body>

					<p>&nbsp;</p>

					<table cellpadding="0" cellspacing="0" border="0" width="100%">

					<tbody>

						<tr>

							<td>'.$lang['DET_PROVDR'].':'.$usr['fname'].' '.$usr['lname'].'</td>

						</tr>

						<tr>

							<td>'.$lang['PROVDR_NAME'].':'.$usr['username'].'</td>

						</tr>

						<tr>

							<td>'.$lang['PROVDR_EMAIL'].':'.$usr['email'].'</td>

						</tr>

						<tr>

							<td>'.$lang['PROVDR_COMP_NM'].':'.$usr['company'].'</td>

						</tr>

					</tbody>

					</table>

					<p>

					<br />

					'.html_entity_decode($row['body']).'

					<br />

					'.html_entity_decode($row['footer']).'

					</body>

					</html>

					';  */                                                    $prurl = $vpath . "project/" . $proj['id'] . "/" . str_replace("/", "", str_replace(" ", "-", getproject($proj['id']))) . ".html";
																			 $from = $setting['admin_mail'];
																			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='accept_project_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
																			if (mysql_num_rows($mailqf) == 0) {
																			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='accept_project_for_freelancer' AND `langid`='en'");
																			}

																			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='accept_project_for_employe' AND `langid`='" . getUserLastLang($proj['user_id']) . "'");
																			if (mysql_num_rows($mailqe) == 0) {
																			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='accept_project_for_employe' AND `langid`='en'");
																			}

																			$mailrf = mysql_fetch_assoc($mailqf);
																			$mailre = mysql_fetch_assoc($mailqe);

																			$mailbodyf = html_entity_decode($mailrf['body']);
																			$mailbodye = html_entity_decode($mailre['body']);
                                                                        $subjectf = html_entity_decode($mailrf['subject']);
                                                                        $mailbodyf = str_replace("{username}", $emp['username'], $mailbodyf);
                                                                        $mailbodyf = str_replace("{project}","<a href='" . $prurl . "'>" . $proj[project].'</a>', $mailbodyf);
																		$mailbodyf = str_replace("{employer}", $usr['username'], $mailbodyf);
																	    $headers = "MIME-Version: 1.0\r\n";
                                                                        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                                                                        $headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
                                                                        $headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
																		
																		
																		$subjecte = html_entity_decode($mailre['subject']);
																		$mailbodye = str_replace("{username}", $usr['username'], $mailbodye);
																		$mailbodye = str_replace("{project}", "<a href='" . $prurl . "'>" .$proj[project].'</a>', $mailbodye);
																		$mailbodye = str_replace("{freelancer}", $emp['username'], $mailbodye);
																		

                                                                        mail($to, $subjectf, $mailbodyf, $headers);

                                                                         mail($to1, $subjecte, $mailbodye, $headers);


				

					

					//$email1 = mysql_fetch_assoc(mysql_query("select * from ".$prev."user where user_id=".$_SESSION['user_id']));



					/* $res_tlog=mysql_query("select * from ".$prev."mailsetup where mail_type=\"login_begins\"");

					$row_tlog=mysql_fetch_array($res2);

					

					

					$subject1 = $lang['MYJOBS_EM_SUB2'];

					$message1 = '

					<html>

					<head>

					<title>'.$dotcom.$lang['NOTIFICATION'].'</title>

					</head>

					<body>

					<p>&nbsp;</p>

					<table cellpadding="0" cellspacing="0" border="0" width="100%">

					<tbody>

						<tr>

							<td>'.$lang['DET_EMP'].':'.$emp['fname'].' '.$emp['lname'].'</td>

						</tr>

						<tr>

							<td>'.$lang['EMP_NAME'].':'.$emp['username'].'</td>

						</tr>

						<tr>

							<td>'.$lang['EMP_EMAIL'].':'.$emp['email'].'</td>

						</tr>

						<tr>

							<td>'.$lang['EMP_COMP_NM'].':'.$emp['company'].'</td>

						</tr>

					</tbody>

					</table>

					<p>

					<br />

					'.html_entity_decode($row_tlog['body']).'

					<br />

					'.html_entity_decode($row_tlog['footer']).'

					</body>

					</html>

					';

					$headers1 = "MIME-Version: 1.0\r\n";
						$headers1 .= "Content-type: text/html; charset=iso-8859-1\r\n";
						$headers1 .= $lang['FROM_H'].":$dotcom <" . $setting['admin_mail'] . ">\r\n";
						$headers1 .= $lang['REPLY_TO'].": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
					

					//mail($to, $subject1, $message1, $headers1);

					mail($to1, $subject1, $message1, $headers1); */

					//////////////////////////////////////////////////////////////////////////////////////////

					//////////////////////////////////////////////////////////////////////////////////////////

			

			

						

						/*echo '<script language="javascript">

							  alert("Accept project succesfull.");

							  window.location.href="mybids.php";

							</script>';
*/
							

							
							header($lang['LOCATION'].": ".$vpath."mybids.html");
							

						}

						exit;

						
							
						}

						//----------------------------------------

						if($_REQUEST[close]):

						echo"<table cellpadding=4 cellspacing=1 align=center width=100%  border=0>

						<tr bgcolor='" . $light . "' style='height:35px; background-color:#f6f6f6; '>

						<td ><a  href='".$vpath."my-jobs.html' style='color:#a1282c;' ><u><b>".$lang['MY_JOBS']."</b></u></a><b> > ".$lang['CLOSED_JOBS']." :" . getproject($_REQUEST[close]) . " </b></td></tr>";

						

						if (mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" . $_REQUEST[close] . "' AND user_id='" . $_SESSION[user_id] . "'"))==0): 

						echo '<tr><td class=red height=50 valign=middle align=center>'.$lang['PROJECT_SPECIFIED_NUMBER'].'.<br>

						<a href="'.$vpath.'my-jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';

						else:

						if(!$_REQUEST[submit]):

						echo '<tr class=link_class><td height=100 valign=middle><center>

						<form method="POST" action="'.$vpath.'my-jobs.php">

						<input type="hidden" name="close" value="' . $_REQUEST[close] . '">

						'.$lang['PROJ_CANCEL'].' <b>' . getproject($_REQUEST[close]) . '</b>?

						<br><br>

						<div align="center">

						<input type="submit" class="submit_bott" value="'.$lang['YES_CANCEL'].'" name="submit">

						</div>

						<br><br>

						<font face=verdana size=1 color=red>'.$lang['CAUTION_MYJOBS'].'<br><br>

						'.$lang['CAUTION_REOPEN'].'</font face=verdana size=1 >

						</form></center></td></tr></table>';

						else:

						mysql_query("UPDATE " . $prev . "projects SET status='cancelled' WHERE id='" . $_REQUEST[close] . "'");

						mysql_query("UPDATE " . $prev . "bids SET status='cancelled' WHERE id='" . $_REQUEST[close] . "'");

						echo '<tr class=link_class><td><center>'.$lang['PROJ_NMD'].' <b>' . getproject($_REQUEST[close]) . '</b> has been closed.<br>

						<a href="'.$vpath.'my-jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';

						endif;

						endif;

						elseif($_REQUEST[extend]):

						echo"<table cellpadding=4 cellspacing=1 align=center width=100% border=0>
						<tr><td>&nbsp;</td></tr>
						<tr class='tbl_bg_4'><td ><a href='".$vpath."my-jobs.html' class=link_class><u><b>".$lang['MY_JOBS']."</b></u></a><b> > ".$lang['OPEN_H1']." :" . getproject($_REQUEST[extend]) . " </b></td></tr>";

						if(mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" . $_REQUEST[extend] . "' AND user_id='" . $_SESSION[user_id] . "'"))==0):

						echo '<tr class="tbl_bg2"><td class=red height=50 valign=middle align=center>'.$lang['PROJ_NOT_FND'].'<br>

						<a href="'.$vpath.'my-jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';
						
						

						else:

						if(!$_REQUEST[submit]):

						echo '<tr class=tbl_bg2><td>
						<form method="POST" action="'.$vpath.'my-jobs.html">
						<input type="hidden" name="manage" value="2">
						<input type="hidden" name="extend" value="'. $_REQUEST[extend] . '">
						&nbsp;&nbsp; '.$lang['PROJ_EXT'].' <input type="text" name="cdays" value="' . $setting[maxextend] . '" maxlength="3" size="3" class="from_input_box1">
						days (max ' . $setting[maxextend] . ')...
						<br >
						<div>
						<br >
						<br >
						<input align="right" type="submit" class="submit_bott" value="'.$lang['EXTEND'].'" name="submit"></div></form>
						</td></tr></table>';						

						else:

						$ii = mysql_result(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" .$_REQUEST[extend] . "'"),0,"expires")+ ($_REQUEST[cdays] * 86400);

						

						//echo (time() + $setting[mprojectdays] * 86400);						

						//echo mktime(date("h"), date("i"), date("s"), date("m"), date("d") + $setting[mprojectdays], date("y"));

						//Cheking if your entension request greater than maximum extension limit(Here 45 days)

						

						if($ii>(time() + $setting[mprojectdays] * 86400)):
						echo '<tr><td>&nbsp;</td></tr>';
						echo '<tr><td>';
						$_SESSION['error']=$lang['PROJ_EXT_CANT']. $setting[mprojectdays]. $lang['DAYS_SORRY'];
						include('includes/err.php');
						unset($_SESSION['error']);
						echo '</td></tr>';
						echo '<tr><td>&nbsp;</td></tr></table>';

						else:

						//Extend the project update query executes here.

						

						mysql_query("UPDATE " . $prev . "projects SET expires=". $ii ." WHERE id='" . $_REQUEST[extend] . "'");
						$_SESSION['succ']=$lang['PROJ_XTND'] . $_REQUEST[cdays] .$lang['DAYS'];
						include('includes/succ.php');
						unset($_SESSION['succ']);
						echo '<tr class=link_class><td class=link_class><br>

						<a href="'.$vpath.'my-jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';

						endif;

						endif;

						endif;	

						elseif($_REQUEST[pick]):

						echo"<table cellpadding=4 cellspacing=1 align=center width=100% style='color:#4E4D4D;'>

						<tr class='tbl_bg_4'><td colspan=2><a href='".$vpath."my-jobs.html' class=link_class><u><b>".$lang['MY_JOBS']."</b></u></a><b> > ".$lang['SELECT_PROVIDER']."</b></td></tr>";

						if(@mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='$_REQUEST[pick]' AND user_id=" . $_SESSION[user_id]))==0):

						echo "<tr class='tbl_bg2'><td height=100 valign=middle colspan=2><span class=red>".$lang['PROJECT_SPECIFIED_NUMBER']."<br>

						<a href='".$vpath."my-jobs.html' class=link_class>".$lang['RETURN_TO_PREVIOUS_PAGE']."</a></td></tr></table>";

						else:

						if(!$_REQUEST[submit]):

						echo'<tr class="tbl_bg_4"><td class=link_class colspan=2><strong>'.$lang['PROJECT'].' : ' . getproject($_REQUEST[pick]) . '</strong></td></tr>

						<tr class="tbl_bg2" ><td class="link_class" colspan="2" style="text-decoration:none;text-align: justify;">

						'.str_replace("\\","",html_entity_decode($lang['MY_JOBS_MSG'])).'</td></tr>

						<tr ><td class=link_class>

						<form method="POST" action="my-jobs.html">

						<input type="hidden" name="pick" value="' . $_REQUEST[pick] . '">

						<input type="hidden" name="submit" value="select"></td></tr>

						</table><br>

						<table width="100%" border=0 cellspacing=1 cellpadding=4 bgcolor=whitesmoke>

						<tr class="tbl_bg_4"><td ><b>'.$lang['SLCT'].'</b></td><td><b>'.$lang['PROV_H'].'</b></td><td><b>'.$lang['BID'].'</b></td><td><b>'.$lang['DLV_WTN'].'</b></td><td><b>'.$lang['TIME_BID_H'].'</b></td><td><b>'.$lang['REVIEWS'].'</td></tr>';

						$rez_t = mysql_query("SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick]);
						$total=@mysql_num_rows($rez_t);
						//echo "SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick];
						if($_GET['page'])
						{
							$sql="SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick]." limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
						}
						else
						{	
							$sql="SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick]." limit 0,".$no_of_records."";
						}
						//echo $sql;
						$rez=mysql_query($sql);
						


						if($total==0):

						echo'<tr><td  class="red" valign=middle align=center colspan=6>'.$lang['NO_BDS_YT'].'</td></tr>';

						else:

						$i=0;

						while($row=@mysql_fetch_array($rez))
						{

						$i++;

						if(!($i%2)){$bg='whitesmoke';}else{$bg='#ffffff';}

						$result4 = mysql_query("SELECT AVG(avg_rate) as avg_rate FROM " . $prev . "feedback WHERE feedback_to=" . $row[bidder_id]);

						if($_REQUEST[select]==$row[user_id]):

						//$bg="yellow";

						echo"<tr class=link_class bgcolor=".$bg."><td><input type=radio name=chosen value=" . $row[bidder_id ] . "></td><td><a href='".$vpath."publicprofile/" . getusername($row[bidder_id]) . "' class=link_class><u>" . getusername($row[bidder_id ]) . "</u></a></td><td>".$curn . $row[bid_amount] ."</td><td>" . $row[duration] . " days</td><td>" . $row[add_date] . "</td><td>";

						else:

						echo"<tr class=link_class bgcolor=" .$bg ."><td><input type=radio name=chosen value=" . $row[user_id] . "></td><td><a href='".$vpath."publicprofile/" . getusername($row[user_id]) . "' class=link_class><u>" . getusername($row[bidder_id]) . "</u></a></td><td>".$curn . $row[bid_amount] ."</td><td>" . $row[duration] . " days</td><td>" . $row[add_date] . "</td><td>";

						endif;

						if (mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to=" . $row[bidder_id] ))==0):

						echo $lang['NO_FDB_YT'];

						else:

						echo '<a href="'.$vpath.'review/' . getusername($row[bidder_id]) . '/" class=link_class>';

						$avgratin = round(mysql_result($result4,0,"avg_rate"), 2);

						

						$avgrating = explode(".", $avgratin);

						//echo $avgratin.'hi';

						for ($t2=0;$t2<$avgrating[0]-5;$t2++):

						//echo '<img src="images/img_52.jpg" border=0 alt="' . $avgratin . '/5">';

						endfor;

						$numeric2 = 10-$avgrating[0];

						if($numeric2):

						for ($b2=0;$b2<$numeric2-5;$b2++): 

						//echo '<img src="images/img_54.jpg" border=0 alt="' . $avgratin . '/5">';

						endfor;

						endif;

						if(mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to='" . $row[bidder_id] . "'"))==1):

						echo ' (<b>1</b>'.$lang['REVIEW'].' )';

						else:						

						echo "<span class=\"starsSmall rating". $avgrating[0]."\">&nbsp;</span>";

						echo ' (<b>' . mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to='" . $row[bidder_id] . "'")) . '</b> reviews)';

						endif;

						echo '</a>';

						endif;

						echo '</td></tr>

						<tr bgcolor=' .$bg .'><td  colspan="6" class="link_class" style="border-bottom:solid 1px">' . $row[cover_letter] .'</td></tr>';

						}

						endif;

						echo '<tr class=link_class bgcolor="' . $light . '"><td colspan=5 ><input type=button OnClick="javascript:history.back();" class="submit_bott" value=" '.$lang['BACK'].' "></td>

						<td   align=right><input type="submit" class="submit_bott"  value="'.$lang['SELECT_PROVIDER'].'"></td></tr></form></table>';

						else:

			if(!isset($_POST['chosen']))
			{
				$_SESSION['select_provider'] = $lang['MSG_NO_PRV'];	
				header($lang['LOCATION'].": ".$vpath."my-jobs/pick/".$_REQUEST['pick']."/");
			}
			else
			{
						mysql_query("UPDATE " . $prev . "projects SET chosen_id='$_REQUEST[chosen]', status='frozen' WHERE id='$_REQUEST[pick]'");

						//mysql_query("UPDATE " . $prev . "bids SET chosen_id='$_REQUEST[chosen]', status='frozen' WHERE id='$_REQUEST[pick]'");						

						mysql_query("UPDATE " . $prev . "buyer_bids SET chose='P', chosen_id='$_REQUEST[chosen]' WHERE project_id='$_REQUEST[pick]' and bidder_id='$_REQUEST[chosen]'");

						$msg = $setting[emailheader] .$lang['MSG_JOB'] . getproject($_REQUEST[pick]) . $lang['MSG_JOB_IMP'] . $setting[site_url] . 'my-jobs.php?mode=accept&id=' . $_REQUEST[pick] . '&confirm=' . $_REQUEST[pick] . $lang['MSG_JOB_2'] . $setting[emailaddress] . '

--------------------

' . $setting[emailfooter];

						//echo $msg;

						//echo '<br>Choosen: '.$_REQUEST[chosen];

						//echo '<br>Company: '.$setting[companyname];

						//echo '<br>Choosen: '.getemail($_REQUEST[chosen]);

						//echo 'From: '.$setting[retemailaddress];
						$from="test.com";
						
						$mail_id=getemail($_REQUEST[chosen]);
						
						$mail_type = 'select_provider';
						
						
						$row_mail_type = mysql_fetch_array(mysql_query("select * from ".$prev."mailsetup where mail_type = '".$mail_type."'"));
						
						$body = html_entity_decode($row_mail_type['header']) . $msg . html_entity_decode($row_mail_type['footer']);
						
						$body1=str_replace("{first_name}",$_REQUEST['firstname'],$body);
						$body1=str_replace("{last_name}",$_REQUEST['lastname'],$body1);
						
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
						$headers .= $lang['FROM_H'].":$dotcom <" . $from . ">\r\n";
						$headers .= $lang['REPLY_TO'].": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
						
						mail($mail_id,$setting[companyname] . $lang['BID_WON'],$body1,$headers);
						
						//echo $mail_id;
//						echo $setting[companyname];
//						echo $headers;
//						echo $body1;
						
						
						//genMailing($mail_id,$setting[companyname] . " Job Bid Won", $msg, $from = '', $reply = true, $mail_type);
						//mail(getemail($_REQUEST[chosen]),$setting[companyname] . " Job Bid Won",$msg,$mail_type);

						

						$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$_SESSION['user_id']));

						$proj = mysql_fetch_array(mysql_query("SELECT * from ".$prev."projects where id=".$_REQUEST['pick']));  

						$message = $lang['HIRD_PROJ'].'<br /><br />

						'.$lang['NEW_RT'].': $'.$_POST['rate'].'<br />

						'.$lang['PROJECT_NAMEE'].': '.$proj['project'];

						//exit;

						$msg = mysql_query("INSERT into ".$prev."messages set 

						receiver=".$_GET['id'].",

						sender_id=".$_SESSION['user_id'].",

						sender='".$usr['email']."' ,

						subject='".$lang['HIRE_INFO']."',

						message='".$message."',

						user_type='sender',

						sent_time='".date('Y-m-d h:i:s')."',

						status='Y',

						message_type='A'");

						

						$msg2 = mysql_query("INSERT into ".$prev."messages set 

						receiver=".$_GET['id'].",

						sender_id=".$_SESSION['user_id'].",

						sender='".$usr['email']."' ,

						subject='".$lang['HIRE_INFO']."',

						message='".$message."',

						user_type='reciver',

						sent_time='".date('Y-m-d h:i:s')."',

						status='Y',

						message_type='A'");

						

						

						$notify = mysql_query("INSERT into ".$prev."notification set user_id=".$_GET['id'].", message='".$lang['HIRE_INFO']."', date='".date('Y-m-d')."'");

   						echo '<tr><td colspan="6" class="link_class" style="text-decoration: none;text-align: justify;">'.$lang['MSG_JOB_3'].' <b>' . getusername($_REQUEST[chosen]) . '</b> '.$lang['MSG_JOB_4'].' <b>' . getproject($_REQUEST[pick]) . '</b> '.$lang['MSG_JOB_5'].'<br><br>

						'.$lang['MSG_JOB_6'].' <b>' . getusername($_REQUEST[chosen]) . '</b> '.$lang['DOES_NOT_RES'].'.<br><br>

						'.$lang['MSG_JOB_8'].'<br><br>

						<div align=right>

						<a href="'.$vpath.'my-jobs.html" class=link_class>'.$lang['GO_BK'].'</a></div></td></tr></table>';
				}
						endif;

						endif;

						

						else:

						echo"<table width='743' border='0' align='left' cellpadding='0' cellspacing='0'>

						<tr class='tbl_bg_4'>
                        	<td width='200' align='left'class='space's>".$lang['PROJECT_NAMEE']."</td>
							<td width='70' align='center'>".$lang['BIDS']."</td>
                        	<td width='150' align='center'>".$lang['STATUS']."</td>
                        	<td width='300' align='center'>".$lang['ACTION']."</td>
						</tr>";
						

						$tinyres_t = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id,date2 DESC");

						//echo"SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id DESC";

						$total = @mysql_num_rows($tinyres_t);
						
						if($_GET['page'])
						{
							$sql="SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id,date2 DESC limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
						}
						else
						{	
							$sql="SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id,date2 DESC limit 0,".$no_of_records."";
						}
						$tinyres=mysql_query($sql);
						

						if($total==0):

						echo '<tr class="tbl_bg2"><td  colspan=4 height=50 valign=middle class=red><center><strong>'.$lang['NO_JOBS_DISPLAY'].'</strong></td></tr>';

						else:

						$i=0;

						while($kikrow=mysql_fetch_array($tinyres)){

						if(!($i%2)){$bg="#ffffff";}else{$bg="whitesmoke";}

						echo '<tr class="tbl_bg2" ><td align="left" class="space" style="border-right:none;"><a class="font_bold2" href="'.$vpath.'project/' . $kikrow[id] . '/">' . ucwords($kikrow[project]) . '</a>';

						if($kikrow[special] == "featured"):

						//echo' <img src="images/featured.gif" alt="Featured Project!" border=0>';

						endif;

						echo '</td> <td align="center">' . totalbid($kikrow[id]) . '</td><td align="center" class="job_type" style="border-right:none;">';

						if($kikrow[status] == "open"):

						echo '<font face=verdana size=1 color=green><b>' .  Ucwords($kikrow[status]) . '</td> <td style="padding-right:12px;">';

						if(totalbid($kikrow[id])):

						echo'<a href="'.$vpath.'my-jobs/pick/' . $kikrow[id] . '/" class=link_class><u>'.$lang['SELECT_PROVIDER'].'</u></a>';

						//else:

						

						//echo'<a href="#" class=link_class onclick="javascript:alert(\'No Bid yet\');"><u>Select a Provider</u></a>|';

						endif;

						echo'  <a href="'.$vpath.'my-jobs/extend/' . $kikrow[id] . '/" class=link_class><u>'.$lang['EXTEND'].'</u></a> | <a href="'.$vpath.'editjob/' . $kikrow[id] . '/" class=link_class><u>'.$lang['EDIT'].'</u></a> | <a href="my-jobs/close/' . $kikrow[id] . '/" class=link_class><u>'.$lang['CANCEL'].'</u></a></td></tr>';

						elseif ($kikrow[status] == "frozen"):

						echo '<span class=link_class>' .  Ucwords($kikrow[status]) . '</span></td> <td style="color:#a1282c; font-size:13px; font-family:Tahoma,Arial,Verdana,Sans-serif; padding-right:12px;">

						<a href="'.$vpath.'my-jobs/pick/' . $kikrow[id] . '/" class=link_class><u>'.$lang['PICK_PROVIDER'].'</u></a> | <a href="'.$vpath.'my-jobs/extend/' . $kikrow[id] . '/" class=link_class><u>'.$lang['EXTEND'].'</u></a> |  <a href="'.$vpath.'my-jobs/close/' . $kikrow[id] . '/" class=link_class><u>'.$lang['CANCEL'].'</u></a><br>

						'.$lang['AWAIT_RESP'].' <i><a href="'.$vpath.'publicprofile/' . getusername($kikrow[chosen_id]) . '" class=link_class><u>' . getusername($kikrow[chosen_id]) . '</u></a></i>)</td></tr>';

						elseif($kikrow[status] == "cancelled"):

						echo '<font face=verdana size=1 color=red><strong>'.$lang['STAT_CNCL'].'</strong></td><td >('.$lang['PROJECT_CANCELLED'].')</td></tr>';

						elseif($kikrow[status] == "expired"):

						echo '<font face=verdana size=1 color=red><strong>'.$lang['EXPIRED'].'</strong></td><td >('.$lang['PROJECT_EXPIRED'].')</td></tr>';

						else:
//echo '<font face=verdana size=1 color=orange><b>' . Ucwords($kikrow[status]) . '</td> <td >You picked <a href="'.$vpath.'publicprofile/' .base64_encode( $kikrow[chosen_id] ). '">' . getusername($kikrow[chosen_id]) . '</a> (click here to pay <a href="'.$vpath.'payment.php?transfer=money&transfer2=' . $kikrow[chosen_id] . '&tamount=' . @mysql_result(mysql_query("SELECT * FROM " . $prev . "bids WHERE id='" . $kikrow[id] . "' AND user_id='" . $kikrow[chosen_id] . "'"),0,"amount") . '">' . getusername($kikrow[chosen_id]) . '</a>...)</td></tr>';
						echo '<font face=verdana size=1 color=orange><b>' . Ucwords($kikrow[status]) . '</td> <td >'.$lang['YOU_PICKED'].' <a href="'.$vpath.'publicprofile/' .getusername( $kikrow[chosen_id] ). '">' . getusername($kikrow[chosen_id]) . '</a> ('.$lang['CLICK_HERE_PAY'].' <a href="'.$vpath.'milestone.html">' . getusername($kikrow[chosen_id]) . '</a>...)</td></tr>';

						endif;

						$i++;	

						}

						endif;

						echo "</table>";

						endif;

						

						

						?></td>
                  </tr>
                  <tr>
                    <td ><?php
						if($total>$no_of_records)
						{
						   //echo"<div align=right>" .new_paging(0,'my-jobs.php','',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
						   
						    echo"<div align=right>". new_pagingnew(0,$vpath.'my-jobs/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
						}
						?></td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?>
