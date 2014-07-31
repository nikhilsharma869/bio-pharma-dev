<?php 
$current_page = "<p>Mailbox</p>";
include "includes/header.php"; 
CheckLogin();

	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

if($_GET['id'])
{
$red=mysql_query("update ".$prev."messages set read_status='Y' where id='".base64_decode($_GET['id'])."'");
}

$res=mysql_query("select * from ".$prev."messages where id='".base64_decode($_GET['id'])."'");
$row=mysql_fetch_array($res);


$res1=mysql_query("select * from ".$prev."user where user_id='".$row['sender_id']."'");
$row1=mysql_fetch_array($res1);

$res2=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row2=mysql_fetch_array($res2);

$res3=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
$row3=mysql_fetch_array($res3);


if($_POST['rep']=="Reply")
{

	$row_user_details=mysql_query("select user_id,username,email,fname,lname from ".$prev."user where user_id='".base64_decode($_GET['id'])."'");
	$res_user_details=mysql_fetch_array($row_user_details);

			$stringword = $_POST['txt'];
			$banned_words = explode(',',$setting[bad_words]);
			$err=0;
			$c_banned_words=count($banned_words);
			for($i=0;$i<$c_banned_words;$i++)
			{
				if(substr_count($stringword,$banned_words[$i]))
				{
					$err++;
					break;
				}
			}
			if($err!=0)
				{
					$_SESSION['error']="String contains some banned words.";
				}
				
				
	if($row2['status']=='Y')
	{
		$status='Y';
	}
	else
	{
		$status='N';
	}
	if($row['sender_id']==0)
	{
		$mtype = 'UA';
		$sndr = $row['sender'];
	}
	else
	{
		$mtype = 'A';
		$sndr = $row2['email'];
	}

	$res_selectuser=mysql_query("select * from ".$prev."messages where id='".$_REQUEST['id_con']."'");
	$row_selectuser=mysql_fetch_array($res_selectuser);

	$view_user=$row_selectuser['view_user'];

	$res3=mysql_query("insert into ".$prev."messages set
	receiver='".$row['sender_id']."',
	sender_id='".$_SESSION['user_id']."',
	sender='".$sndr."',
	subject='".$_POST['subject']."',
	message='".$_POST['txt']."',
	user_type='sender',
	sent_time=now(),
	status='".$status."',
	message_type='".$mtype."',
	read_status='N',
	view_user='".$view_user."'
	");
	if($res3)
	{
		$res4=mysql_query("insert into ".$prev."messages set
		receiver='".$row['sender_id']."',
		sender_id='".$_SESSION['user_id']."',
		sender='".$sndr."',
		subject='".$_POST['subject']."',
		message='".$_POST['txt']."',
		user_type='reciver',
		sent_time=now(),
		status='".$status."',
		message_type='".$mtype."',
		read_status='N',
		view_user='".$view_user."'
		");

		$res4=mysql_query("insert into ".$prev."notification set
		user_id='".$_SESSION['user_id']."',
		message='You have sent a Reply message to ".$row1['fname']." ".$row1['lname']."',
		date='".date('Y-m-d',time())."'");
		$sucs="success";
		$id=base64_encode($_REQUEST['id_con']);

		$message="You have sent a reply message to ".ucwords($row1['fname'])." ".ucwords($row1['lname'])."&nbsp;..";
		$message1=base64_encode($message);
		$_SESSION['succ']=$message;
		//header("location:showmessage.php?id=$id&sucs=$sucs&message=$message1");
	}
	else
	{
		$sucs="success";
		$id=base64_encode($_REQUEST['id_con']);

		$message="Try again&nbsp;..";
		$message1=base64_encode($message);
		//header("location:showmessage.php?id=$id&sucs=$sucs&message=$message1");
	}
}


$inbox_data="select * from  ".$prev."messages where receiver='".$_SESSION['user_id']."' and sender_id!='".$_SESSION['user_id']."' and status='Y' and user_type='reciver' and read_status='N'";

$rec_date=mysql_query($inbox_data);
$num_date=mysql_num_rows($rec_date);



?>


<script type="text/javascript">
function validate_form(x)
{
	if(x['cname_txt'].value =='')
	{
		alert('Please provide company name');
		document.getElementById('cname_txt').focus();
		return false;
	}
	if(x['comid'].value =='')
	{
		alert('Please provide company id');
		document.getElementById('comid').focus();
		return false;
	}
	if(x['country'].value =='select')
	{
		alert('Please select country');
		return false;
	}
	if(x['addr1_txt'].value =='')
	{
		alert('Please provide your address');
		document.getElementById('addr1_txt').focus();
		return false;
	}
	if(x['city_txt'].value =='')
	{
		alert('Please provide name of city');
		document.getElementById('city_txt').focus();
		return false;
	}
	if(x['zip_txt'].value =='')
	{
		alert('Please provide zip code');
		document.getElementById('zip_txt').focus();
		return false;
	}
	if(isNaN(x['zip_txt'].value))
	{
		alert('Invalid zip code, Please enter digits only');
		x['zip_txt'].value ='';
		document.getElementById('zip_txt').focus();
		return false;
	}
	if(x['ccode'].value =='')
	{
		alert('Please provide country code');
		document.getElementById('ccode').focus();
		return false;
	}
	if(isNaN(x['ccode'].value))
	{
		alert('Invalid country code, Please enter digits only');
		x['ccode'].value ='';
		document.getElementById('ccode').focus();
		return false;
	}
	if(x['acode'].value =='')
	{
		alert('Please provide area code');
		document.getElementById('acode').focus();
		return false;
	}
	if(isNaN(x['acode'].value))
	{
		alert('Invalid area code, Please enter digits only');
		x['acode'].value ='';
		document.getElementById('acode').focus();
		return false;
	}
	if(x['phone'].value =='')
	{
		alert('Please provide contact number');
		document.getElementById('phone').focus();
		return false;
	}
	if(isNaN(x['phone'].value))
	{
		alert('Invalid contact number, Please enter digits only');
		x['phone'].value ='';
		document.getElementById('phone').focus();
		return false;
	}
return true;
}

function check()
{
	if(document.frm.subject.value=="")
	{
		alert("Enter a Subject");
		document.frm.subject.focus();
		return false;	
	}
	if(document.frm.txt.value=="")
	{
		alert("Enter a reply message");
		document.frm.txt.focus();
		return false;
	}
return true;
}
</script>




<div class="browse_contract">
  <!--Profile-->
  <?php include 'includes/leftpanel1.php';?>

    <div class="profile_right">
	
      <div class="create_profile">
       <? include("includes/message_header.php");?>
    </div>
	 <div class="inbox_right_text1">
     <h2><?php print $row['subject'];?></h2>
     </div>
	 
	<table width="665" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td colspan="4"><div style="height:5px;"></div>
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
		</td>
		</tr>
	</table>
				
	 <div class="clear"></div>
     <table cellpadding="0" cellspacing="0" border="0" class="massage" width="100%">
        <tr>
        	<td width="6%" valign="top" class="name">Message </td>
            <td width="94%" align="left"><p><?php print nl2br($row['message']);?></p> </td>
        </tr>
        <tr>
        	<td class="name">From :</td>
            <td align="left"><p><a href="publicprofile.php?<?=base64_encode($row1['user_id'])?>"><?php
									if($row['view_user']=='AD')

						{

							print 'Admin';

						}

						else

						{

							print $row1['fname']." ".$row1['lname'];

						}

			?></a></p> </td>
        </tr>
     </table>
	 <div class="clear"></div>
<?php if(!isset($_GET['typ']))
{
?>
	 <form action="" method="post" name="frm" id="frm" onsubmit="return check();">
	 <table cellpadding="0" cellspacing="0" class="from">
     	<tr>
        	<td class="name" valign="top">Subject:</td>
            <td class="log_form input">
			<input type="hidden" name="id_con" value="<?php echo base64_decode($_GET['id']);?>" />
			<input type="text" name="subject" /></td>
        </tr>
        <tr>
        	<td  class="name" valign="top">Message: </td>
            <td><textarea name="txt" rows="10" cols="15" class="text_box"></textarea></td>
        </tr>
        <tr>
        	<td colspan="2" class="reply_bott"><input type="submit" name="rep" value="Reply" class="submit" id="mc_ctrl_delete" /></td>
        </tr>
       
     </table>
	 </form>
	 
<?php }?>	
				
      
      <!--end middle-->
      <!-- rightside-->
      <!-- end rightside-->
    </div>
	</div>
    <div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>