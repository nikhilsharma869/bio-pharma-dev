<?php 
$current_page="Contact Us";
include "includes/header.php"; 
if($_SESSION[lang_id]){
    $row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id=23 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));

	
	$row_content['contents']=$row_content_lang[content]; 
} else {
	$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='Contact Us'"));
	}
?>

<script>
function ValidMember()
{
if(document.getElementById('name').value.search(/\S/)==-1)
	{
		alert("<?=$lang['NAME_SHOULD_NOT_EMPTY']?>");
		document.getElementById('name').focus();
		return false;
	}
	if(document.getElementById('phone').value.search(/\S/)==-1)
	{
		alert("<?=$lang['PHONE_SHOULD_NOT_EMPTY']?>");
		document.getElementById('phone').focus();
		return false;
	}
	var z=document.getElementById('phone').value;
		if(isNaN(z)||z.indexOf(" ")!=-1)
		    {
				alert("<?=$lang['PLEASE_ENTER_PHONE_SHOULD_NUMBER']?>");
				return false;
			}
			if(document.getElementById("phone").value!='')
				{
					if (document.getElementById("phone").value.length > 10) 
					{
						alert("<?=$lang['YOUR_PHONE_SHOULD_TEN_NUMBER']?>");
						return false;
					}
					}

	
	if(document.getElementById('email').value.search(/\S/)==-1)
	{
		alert("<?=$lang['EMAIL_SHOULD_NOT_EMPTY']?>");
		document.getElementById('email').focus();
		return false;
	}
	var x=document.forms["myForm"]["email"].value;
    var atpos=x.indexOf("@");
    var dotpos=x.lastIndexOf(".");
   if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("<?=$lang['NOT_VALID_EMAIL_ADDRESS']?>");
  return false;
  }
  		
if(document.getElementById('message').value.search(/\S/)==-1)
	{
		alert("<?=$lang['MESSAGE_SHOULD_NOT_EMPTY']?>");
		document.getElementById('message').focus();
		return false;
	}		
	
}
</script>
<!-----------Header End----------------------------->
<div class="inner-middle">

    
   <!--Howitworks Start-->
   <div class="howitworks_box ">
     <div class="howitworks_text">

    <?php echo html_entity_decode($row_content['contents']);?>
 
</div>
<div style="width:600px;">
<?php
if($_POST['submit']!='' && $_POST['submit']=='Submit')
{
$flag=0;
if((empty($_REQUEST['email'])) || (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_REQUEST['email'])))
				{ 

				$emailerror="Please enter your valid email address.";

				$flag=1;

				}
		
				if(empty($_REQUEST['name'])){$nameerror="Please enter your first name."; $flag=1;}
				
				if(empty($_REQUEST['phone'])){$phoneerror="Please enter your phone number."; $flag=1;}

				 if(empty($_REQUEST['message'])){$msgerror="Please enter description."; $flag=1;}

				if(!$emailerror && !$nameerror && !$phoneerror)
				{

				if($flag==0)

				{
             
					$to=$setting[admin_mail];
				
                   	$subject=" Freelancer4less  :".stripslashes($_POST['enqu_admi'])."\n";



					$message=" ".stripslashes($_POST['enqu_admi']).":\r\n\nName : ".stripslashes($_POST['name'])."\nPhone : ".stripslashes($_POST['phone'])."\nEmail : ".stripslashes($_POST['email'])."\nComments : ".stripslashes($_POST['message'])."\n\nIP : ".$_SERVER['REMOTE_ADDR']."\nUser Agent : ".$_SERVER['HTTP_USER_AGENT']."\n".$_REQUEST['captchatext']." = ". $captchatext;


					$headers  = 'MIME-Version: 1.0' . "\r\n";

					$headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";

					// Additional headers

					$headers .= 'From: '.$_POST['name'].'<'.$_POST['email'].'>' . "\r\n";
					
				     $header1=$headers;


					$headers .= 'Reply-To:'.$_POST['name'].'<'.$_POST['email'].'>' . "\r\n".'X-Mailer: Manthan';

					$r=mail($to,$subject,$message,$headers);
					$subject1='Reply from Freelancer4less';
					$message1='Thank you for your query.Our expert will contact you soon';
					
					$r=mail($_POST['email'],$subject1,$message1,$header1);

					$sucmsg=true;

				}
			//unset($_SESSION['captcha']);
			}

			}

			if($sucmsg==true) {
				$_SESSION['succ_msg']="You have successfully send.";
			    //echo"<script>window.location.href='contact_us.php';</script>";
			
			}

		  if($_SESSION['succ_msg']!='') { 
   ?>
   <div id="error" style="background-color:#2cb4da; border-radius:4px; width:63%; float:right; margin:0 17px 7px 0; padding:5px; color:#FFF; font-size:18px; font-weight:600; text-align:center; box-shadow:4px 4px 4px #999999">
   <?php echo $_SESSION['succ_msg'];$_SESSION['succ_msg']=''; ?>
 </div> 
 <?php 
}
?>
	<form name="myForm" id="myForm" action="" method="post" onsubmit="return ValidMember();">
<table align="left" width="100%" cellspacing="5" cellpadding="10" border="0">
<tr>
<td valign=top class="tdclass" >
<?=$lang['FULL_NAME']?><span style="color:red">*</span>:</td>
<td>
<input id="name" class="from_input_box" type="text" value="" name="name" size="55"></td>
</tr>

<tr>
<td valign=top class="tdclass" >
<?=$lang['PHONE_NO']?> <span style="color:red">*</span>:</td>

<td>
<input id="phone" class="from_input_box" type="text" value="" name="phone" size="55" ></td>
</tr>
<tr>
<td valign=top class="tdclass" >
<?=$lang['Email']?><span style="color:red">*</span>:</td>

<td>
<input id="email" type="text" value="" name="email" size="55" class="from_input_box"></td>
</tr>
<tr>
<td valign=top class="tdclass" >
<?=$lang['ENQUIRY_DETAILS']?> <span style="color:red">*</span> :</td>
<td valign="top">
<textarea id="message" class="text_box" name="message"  rows="5" cols="42"></textarea></td>
</tr>
<tr>
<td> </td>
<td><input type="submit" value="<?=$lang['SUBMIT']?>" class="submit_bott" name="submit"></td>
</tr>
<tr>
  <td></td>
  <td></td>
  </tr>
</table>
</form>
</div>   
</div></div>
 <div style="clear:both; height:10px;"></div>
<!--FOOTER BOX-->
<?php include 'includes/footer.php';?> 
<!--FOOTER BOX END-->