<?php
$current_page = "Message Board";
include "configs/config.php";
include "includes/header.php"; 

CheckLogin();

if($_REQUEST[id]):

	$result = mysql_query("select * from " . $prev . "projects WHERE id=" . $_REQUEST[id]);

	$data=@mysql_fetch_array($result);

	$buyer_id=$data[user_id];
	mysql_query("update " . $prev . "pmb set readyet=1 where id='$_GET[id]' and private_id='$_SESSION[user_id]'");

endif;

if(!$_REQUEST[private_id]){$_REQUEST[private_id]=$buyer_id;}

?>
<div class="browse_contract" style="float:none;">
<div class="project-desciript"><p>

<?=$lang['INBOX']?> <? if($_REQUEST[id]){echo" > " . strtoupper(substr($data[project],0,1)) .substr($data[project],1); }?>
</p></div>




<?php

if($_REQUEST[id]){
	
	$r=mysql_query("SELECT * from " . $prev . "buyer_bids bb,".$prev."projects p where p.id=bb.project_id and ((bb.project_id=" . $_REQUEST[id] . " and bb.bidder_id=" . $_SESSION[user_id].") OR p.user_id='$_SESSION[user_id]')");

	if(!@mysql_num_rows($r)){

    	echo"<p align=center class=red><font size=2>First submit bid on this project and then can post message here.</font> <br><a href='".$vpath."project/" .$_REQUEST[id] . "/' class=link> Back to Job</a></p>";

   }else{



   if($_REQUEST['submit']){

		$ttoy = time();

		$attachment1="";

		

		if($_FILES['attachment']['name']!=""):

		   

		   $ext=substr($_FILES['attachment']['name'],-3,3);

		   if($ext=="zip" || $ext=="rar"):

		   		copy($_FILES['attachment']['tmp_name'],"attachment/" . $ttoy . "." . $ext);

		   		$attachment1="attachment/" . $ttoy . "." . $ext;

		   else:

		       $err="<font color=red>Upload failure! File extention should zip or rar.</font>";

		   endif;		

		endif;

		//echo "INSERT INTO " . $prev . "pmb (id, user_id,date,private_id,message,attachment) VALUES ('".$_REQUEST[id]."','" . $_SESSION['user_id'] . "','" . date("Y-m-d H:i:s") . "','" . $_REQUEST['private_id'] . "','" . $_REQUEST[message] . "','" . $attachment1 . "')";
		

		$rp=mysql_query("INSERT INTO " . $prev . "pmb (id, user_id,date,private_id,message,attachment) VALUES ('".$_REQUEST[id]."','" . $_SESSION['user_id'] . "','" . date("Y-m-d H:i:s") . "','" . $_REQUEST['private_id'] . "','" . $_REQUEST[message] . "','" . $attachment1 . "')");

		

		mysql_query("insert into ".$prev."messages set	receiver='".$_REQUEST['private_id']."',sender_id='".$_SESSION['user_id']."',	sender='".$_SESSION['email']."',subject='".$data[project]."',message='".$_REQUEST[message]."',user_type='reciver',sent_time=now(),	status='".$status."',message_type='A',read_status='N',view_user='U'	");

		



		$mymsg = getusername($_REQUEST[private_id]) . ' has just posted the following private message for you on the message boards. You can reply to the message at ' . $setting[site_url] . '/?message.board&id=' . $_REQUEST[id] . '-----------' . $_REQUEST[message];

		

		mysql_query("insert into ".$prev."messages set	receiver='".$_REQUEST['private_id']."',sender_id='".$_SESSION['user_id']."',	sender='".$_SESSION['email']."',subject='".$data[project]."',message='".$_REQUEST[message]."',user_type='reciver',sent_time=now(),	status='".$status."',message_type='A',read_status='N',view_user='U'	");

			

		mail(getemail($_REQUEST[private_id]),$dotcom . " Message Board Post Notice",$mymsg,"From:" . getusername($_REQUEST[user_id])."<".$setting[admin_mail] .">");

		echo '<META HTTP-EQUIV=REFRESH CONTENT="12; URL='.$vpath.'message_board/' . $_REQUEST[id] . '/">

		<table border=0 cellspacing=0 cellpadding=4 width=98% align=center><tr ><td align=center><p class=link ><strong><font color=green>Your message has been posted.</font></strong><br>' . $err . '</td></tr></table>';

		//if($_REQUEST[mid] && $rp):

		     //  mysql_query("insert into " . $prev . "reply set mid=" . $_REQUEST[mid] . ",user_id=" . $_SESSION[user_id]);

		//endif;	   

	}

	

	if($_REQUEST['id'] &&  $_REQUEST[private_id]!=$_SESSION[user_id]){

		echo'<br> <table border=0 cellspacing=0 cellpadding=0 width=100%  align=center bgcolor=#ffffff >

		<tr><td><table border=0 cellspacing=0 cellpadding=4 width=100% align=center>

		<form method="POST" action="" enctype="multipart/form-data" onSubmit="javascript:return validatepost(this);">

		<input type="hidden" name="id" value="' . $_REQUEST[id] . '">

		<input type="hidden" name="mid" value="' . $_REQUEST[mid] . '">

		<input type="hidden" name="private_id" value="' . $_REQUEST[private_id]. '">

		<tr class=link><td align=right valign=top><b>Post Message :</b></td><td><textarea rows="8" name="message" cols="52"  ></textarea></td><tr>

		<tr class=link><td align=right valign=top><b>Attachement :</b></td><td><input type=file name=attachment size=35><br><span class=red>File must be zip or rar.</span></td><tr>

		<tr><td ></td><td><input type="submit" name="submit" value="Submit" class=submit_bott> &nbsp;&nbsp;&nbsp;<a href="javascript:history.go(-1);" class=submit_bott style="margin-left:20px;">cancel</a></td></tr></table></form>';

		echo"</td><td width=320 align=right>" .banner("300X250")."</td></tr></table>"; 

	}

	$j=0;

	if($_REQUEST[id]){

    	$rr = mysql_query("SELECT * FROM " . $prev . "pmb WHERE id= " . $_REQUEST[id] . " and (user_id=" . $_SESSION[user_id] . " or private_id=" . $_SESSION[user_id] . ") ORDER BY date desc");

	}else{

    	$rr = mysql_query("SELECT * FROM " . $prev . "pmb WHERE  (user_id=" . $_SESSION[user_id] . " or private_id=" . $_SESSION[user_id] . ") ORDER BY date desc");

	}

	$row=@mysql_num_rows($rr);

	if($row){

   		echo"<br><table   cellpadding=4 cellspacing=0 align=center border=0 width=100% class=message >

		<tr class=subtitle bgcolor=" . $light . "><td width=160 style='border-top:1px solid #b1ced9;border-bottom:1px solid #b1ced9;'><b>Author</b></td><td style='border-top:1px solid #b1ced9;border-bottom:1px solid #b1ced9;'><b>Job/Message</td></tr>";

    	while($dd=mysql_fetch_array($rr)){

	  		$j++;

	   		//mysql_query("update " . $prev . "pmb set readyet=1 where mid=" . $dd[mid]);
			
            $dd1 = mysql_fetch_array(mysql_query("SELECT * FROM " . $prev . "user where user_id='" . $dd[user_id] . "'"));
			$dd2 = mysql_fetch_array(mysql_query("SELECT * FROM " . $prev . "user where user_id='" . $dd[private_id] . "'"));
			
	   		if(!($j%2)){$bg="background-color:#ffffff;";}else{$bg="background-color:#ffffff";}

	   		if($buyer_id==$dd[user_id]){$user_id1=$dd[private_id];}else{$user_id1=$dd[user_id];}

	   		echo'<tr   class=link style="'. $bg .'"><td valign=top style="border-right:1px solid #b1ced9;padding-top:10px;border-bottom:1px solid #b1ced9;"><strong>Posted By :</strong><a href="'.$vpath.'publicprofile/' .$dd1[username] .'/" class=link><strong> '. getusername($dd[user_id]) . '</strong></a> <br><strong>To</strong> : <a href="'.$vpath.'publicprofile/' .$dd2[username] .'/" class=link><strong> '. getusername($dd[private_id]) . '</strong></a><br><strong> On dated : </strong>' . mysqldate_show($dd[date]) . '<br>';

	   		if(getspacial($row[user_id])):

				echo '<br><a href="' . $setting[urlspecial] . '"><img src="'.$vpath.'images/certificate.gif" alt="' . $setting[specialalt] . '" border=0></a>';

	   		endif;

	   		//if($_SESSION[user_id]==$dd[user_id]):	

	   		$rrr = mysql_query("SELECT * FROM " . $prev . "bids WHERE id='" . $_REQUEST[id] . "' and user_id=" . $dd[user_id]);

	   		//echo"SELECT * FROM " . $prev . "bids WHERE id='" . $_REQUEST[id] . "' and user_id=" . $_SESSION[user_id];

			

			if(@mysql_num_rows($rrr)):

		   		echo"<strong>My Bid :</strong> $" . @mysql_result($rrr,0,"amount"); 

	   		endif;

	   		//endif;		

	   		echo"</td><td style='border-bottom:1px solid #b1ced9;padding-left:10px;padding-top:10px'><strong><a href='".$vpath."project/" . $dd[id] ."/' class=link><strong>" .  getproject($dd[id]) . "</strong></a></strong><br><br>" .nl2br($dd[message]);

	   		if($dd[attachment]){echo "<br><br><strong>Attachement :</strong> <a href='" . $dd[attachment] . "' class=link>" . substr($dd[attachment],11) . "</a>";}

	   		if($_SESSION[user_id]!=$dd[user_id])

	   		{

	   			echo"<div align=right><a  class=link href='".$vpath."message_board/" . $dd[id] . "/" . $dd[mid] . "/" . $dd[user_id]. "/" .$dd[private_id]. "/' class=link><img src='".$vpath."images/small_reply.gif' border=0 height='32' width='32'></a> 
				
				</div>";
				
//echo "<a  class=link href='".$vpath."message_board/" . $dd[id] . "/" . $dd[mid] . "/" . $dd[private_id] . "/" . $dd[user_id] . "/' class=link><img src='".$vpath."images/report-violation.gif' border=0></a>";
	   		
			
			}

			else

	 		{

	      		echo"<div align=right><a  class=link href='".$vpath."message_board/" . $dd[id] . "/" . $dd[mid] . "/" . $dd[private_id] . "/" . $_SESSION[user_id] . "/' class=link><img src='".$vpath."images/post_message.png' border=0 alt='Post Message' height='32' width='32'></a></div>";
				
			
	  		}

	   		echo"</td></tr>\n";

	   		//if($j<$row)echo'<tr style="'. $bg .'"><td colspan=2 style="border-bottom:1px solid #b1ced9;">&nbsp;</td></tr>';

		}

		echo'</table>';

	}

  }

}

?>
</div>
<?php include 'includes/footer.php';?> 

<style>
.message a{
font-family: Georgia, "Times New Roman", Times, serif;
color: #0073a3;
font-size: 16px;
font-weight: bold;
text-decoration: none;
font-size:12px;
}
.message a:hover{
text-decoration: underline;
}
.message{
background-color:#ffffff
}

</style>

