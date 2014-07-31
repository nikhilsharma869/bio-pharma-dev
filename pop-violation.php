<?php 
	include "configs/path.php"; 
	session_start();
	//$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
?>
<?php
//include("configs/path.php");
if(!$_SESSION[user_id]):
	echo"<script>alert('You are not Login!');javascript:window.opener.location='sign.in.php?referer=project-dtl.php?id=" . $_REQUEST[project_id] . "';window.close();</script>";    
   //redirect("sign.in.php?referer=" .$_SERVER[PHP_SELF] . "?" . $QUERY_STRING);
endif;
?>


<script type="text/javascript">
window.focus();
function VioValidate(frm) 
{

	var txt="";
    if(!frm.reason.value)
	{   
	   txt+="     Please select any Reason.\n";
	}
    if(!frm.comments.value)
	{   
	   txt+="     Comments should not be blank.\n";
	}
	if(txt)
	{
   	  alert("Sorry!! Following errors has been occured :\n\n"+ txt +"\n     Please Check");
  	  return false
	}
    return true	


}
</script>




<div class="recent_projects">    


			<?
			$r2=mysql_query("select * from " . $prev . "user where user_id='" . $_REQUEST['bidder_id'] . "'");
			$username=@mysql_result($r2,0,"username");
			$r3=mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION[user_id] . "'");
			$username2=@mysql_result($r3,0,"username");
			$email=@mysql_result($r3,0,"email");
			if($_REQUEST[report]):
				$r4=mysql_query("insert into " . $prev . "report set project_id=\"" . $_REQUEST[project_id] . "\",user_id=\"" . $_SESSION[user_id] . "\",violation_by=\"" . $_POST[user_id] . "\",reason=\"" . $_POST[reason] . "\",comments=\"" . $_POST[comments] . "\"");
				$to=$setting['admin_mail'];
				$subject="Report Violation on OneOutsource.com";
				$message="Violation by : " . getusername($_POST[user_id]) . "\nUrl of violation : " . $_POST[url] ."\nReason :" . $_POST[reason] . "\nComment violation : " . $_POST[comments] . "\nReported by :" . $username2;
				$headers="From:$email";
				if($r4):
					mail($to,$subject,$message,$headers);
					echo"<p align=center><br><br>Your comment successfuly updated<br><br></p>";
				else:
					echo"<p align=center><br><br><font color='#008000'>You already sent a report for this project<br><br></font></p>";
				endif;
			else:	
			?>
			<table width="100%" cellspacing="0" cellpadding="4" class=lnk align=center style='border:solid 1px #3387b1' height=100%>
	
   			<tr bgcolor=#eaeaea><td style="color: #3387B1; font-size: 20px;">Violation Report</td></tr>
			<tr class="header_text2"><td>This form is used to report violations of Elance-clone.com service. Please fill in the following fields.</td></tr>
			<tr class=link><td>
			<form action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="javascript:return VioValidate(this);">
			<input type='hidden' name=user_id value="<?=$_REQUEST['bidder_id']?>">
			<input type='hidden' name=project_id value="<?=$_REQUEST[project_id]?>">
			<input type='hidden' name="report" value=1>
			<table cellpadding=4 cellspacing=0 border=0 class=link width=100%>
			<tr><td><b>Violation by:</b></td><td><strong>  <?=$username?></strong></td></tr>
			<tr><td><b>Url of violation:</b></td><td> <input type="text" size="40" name="url" value="<?=$vpath?>index.php?mode=<?if(!$_REQUEST[project_id]){echo"viewprofile&user_id=" . $_REQUEST[bidder_id];}else{echo"project-dtl&id=" . $_REQUEST[project_id];}?>" class="link" readonly></td></tr>
			<tr><td><b>Reason: </b></td><td>
				<select name="reason">
      				<option value="">(Please choose one)</option>
      				<option value="advertising" >Advertising another website</option>
      				<option value="fake" >Fake project posted</option>
      				<option value="harassment" >Obscenities or harassing behaviour</option>
					<option value="profile" >Issue on profile</option>
      				<option value="other" >Other</option>     		
      			</select></td></tr>
				
		<tr><td><b>Comment violation:</b></td><td><textarea cols=30 rows=3 name="comments"></textarea></td></tr>
      	<tr><td></td><td><input type="submit" id="submit" name="submit" value="Submit" class="submit_bott" /></td></tr></table>
      </form>
	  <?endif;?>
			</td></tr>
			
		</td>
	</tr>	
	</table>
	
</div>
