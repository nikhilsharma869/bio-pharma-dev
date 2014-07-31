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
<script>
function validatepost(){
if(document.getElementById('message').value==""){
alert("<?=$lang['ENTER_MESSAGE']?>");
document.getElementById('message').focus();
return false;
}
return true;
}

</script>
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['MESSAGES']?></a></p></div>
<div class="clear"></div>

<div class="myproheading" style="width:99%">
<?=$lang['PROJECT_NAMEE']?>: <? if($_REQUEST[id]){echo strtoupper(substr($data[project],0,1)) .substr($data[project],1); }?>
</div>




<?php

if($_REQUEST[id]){
	
	


   if($_REQUEST['submit']){

		$ttoy = time();

		$attachment1="";

		

		if($_FILES['attachment']['name']!=""):

		   

		   $ext=strtolower(substr($_FILES['attachment']['name'],-3,3));

		   if($ext=="zip" || $ext=="rar" ||  $ext=="doc" ||  $ext=="ocx" ||  $ext=="pdf" ||  $ext=="txt" ||  $ext=="jpg" ||  $ext=="png" ||  $ext=="gif" ||  $ext=="peg" ||  $ext=="xls" ||  $ext=="lsx" ):

		   		copy($_FILES['attachment']['tmp_name'],"attachment/" . $ttoy . "." . $ext);

		   		$attachment1="attachment/" . $ttoy . "." . $ext;

		   else:

		       $err="<font color=red>".$lang['UPL_FAIL_H']."</font>";

		   endif;		

		endif;

		//echo "INSERT INTO " . $prev . "pmb (id, user_id,date,private_id,message,attachment) VALUES ('".$_REQUEST[id]."','" . $_SESSION['user_id'] . "','" . date("Y-m-d H:i:s") . "','" . $_REQUEST['private_id'] . "','" . $_REQUEST[message] . "','" . $attachment1 . "')";
		

		$rp=mysql_query("INSERT INTO " . $prev . "pmb (id, user_id,date,private_id,message,attachment) VALUES ('".$_REQUEST[id]."','" . $_SESSION['user_id'] . "','" . date("Y-m-d H:i:s") . "','" . $_REQUEST['private_id'] . "','" . $_REQUEST[message] . "','" . $attachment1 . "')");

		

		mysql_query("insert into ".$prev."messages set	receiver='".$_REQUEST['private_id']."',sender_id='".$_SESSION['user_id']."',	sender='".$_SESSION['email']."',subject='".$data[project]."',message='".$_REQUEST[message]."',user_type='reciver',sent_time=now(),	status='".$status."',message_type='A',read_status='N',view_user='U'	");

		



		$mymsg = getusername($_REQUEST[private_id]) . ''.$lang['MSG_U_CAN_RERLY_H'].''. $setting[site_url] . '/message_board/' . $_REQUEST[id];

		

		mysql_query("insert into ".$prev."messages set	receiver='".$_REQUEST['private_id']."',sender_id='".$_SESSION['user_id']."',	sender='".$_SESSION['email']."',subject='".$data[project]."',message='".$_REQUEST[message]."',user_type='reciver',sent_time=now(),	status='".$status."',message_type='A',read_status='N',view_user='U'	");

			

		mail(getemail($_REQUEST[private_id]),$dotcom ." " .$lang['MSG_BRD_PSTD_H']." ",$mymsg,"" .$lang['FROM_H']. " ". $dotcom ."<".$setting[admin_mail] .">");

		echo '<META HTTP-EQUIV=REFRESH CONTENT="12; URL='.$vpath.'message_board/' . $_REQUEST[id] . '/">

		<table border=0 cellspacing=0 cellpadding=4 width=98% align=center><tr ><td align=center><p  ><strong><font color=green>'.$lang['MSG_PSTD_H'].'</font></strong><br>' . $err . '</td></tr></table>';

		//if($_REQUEST[mid] && $rp):

		     //  mysql_query("insert into " . $prev . "reply set mid=" . $_REQUEST[mid] . ",user_id=" . $_SESSION[user_id]);

		//endif;	   

	}

	

	if($_REQUEST['id'] &&  $_REQUEST[private_id]!=$_SESSION[user_id]){

		echo'<br> <table border=0 cellspacing=0 cellpadding=0 width=100%  align=center bgcolor=#ffffff class=table_class >

		<tr><td><table border=0 cellspacing=0 cellpadding=4 width=100% align=center>

		<form method="POST" action="" enctype="multipart/form-data" onSubmit="javascript:return validatepost(this);">

		<input type="hidden" name="id" value="' . $_REQUEST[id] . '">

		<input type="hidden" name="mid" value="' . $_REQUEST[mid] . '">

		<input type="hidden" name="private_id" value="' . $_REQUEST[private_id]. '">

		<tr ><td align=right valign=top class="tdclass"><b>'.$lang['MSG1_PSTD_H'].'</b></td><td><textarea rows="8" name="message" id="message" cols="52" class="text_box"   style="
    width: 70%;
    height: 85px;
" ></textarea></td><tr>

		<tr ><td align=right valign=top class="tdclass"><b>'.$lang['ATTACH'].':</b></td><td><input type=file name=attachment size=35 class="text_box"><br><span style="color:red;width:100%;float:left">'.$lang['ZIP_RAR_H'].'</span></td><tr>

		<tr><td ></td><td><input type="submit" name="submit" value="'.$lang['SUBMIT'].'" class=submit_bott> &nbsp;&nbsp;&nbsp;<a href="javascript:history.go(-1);" class=submit_bott style="margin-left:20px;COLOR:#fff">'.$lang['CANCEL'].'</a></td></tr></table></form>';

		echo"</td></tr></table>"; 

	}

	$j=0;

	if($_REQUEST[id]){
	$newcond="";
	if($_REQUEST['con_id']!=''){
	 
	$rr = mysql_query("SELECT * FROM " . $prev . "pmb WHERE id=".$_REQUEST[id]." and ((user_id=".$_SESSION[user_id]."  and private_id='".$_REQUEST['con_id']."' )or (private_id=".$_SESSION[user_id]." and  user_id='".$_REQUEST['con_id']."' ))ORDER BY `date` desc");
	
	}else{

    	$rr = mysql_query("SELECT * FROM " . $prev . "pmb WHERE id=".$_REQUEST[id]." and (user_id=".$_SESSION[user_id]." or private_id=".$_SESSION[user_id].")  ORDER BY `date` desc");
		}
	}else{

    	$rr = mysql_query("SELECT * FROM " . $prev . "pmb WHERE  (user_id=".$_SESSION[user_id]." or private_id=".$_SESSION[user_id].") ORDER BY `date` desc");

	}

	$row=mysql_num_rows($rr);

	if($row){
?>

<div class="myproheading" style="width:99%">
<?=$lang['CONVERSATION']?>
</div>
<?
   		echo"<br><table   cellpadding=4 cellspacing=0 align=center border=0 width=100% class=message >

		<tr class=subtitle style='background-color:#f7f7f7;'>
		<td width=160 style='border-bottom:1px solid #b1ced9;'><b>".$lang['AUTHOR_H']."</b></td>
		<td style='border-bottom:1px solid #b1ced9;'><b>".$lang['MSG_JB_H']."</td></tr>";

    	while($dd=mysql_fetch_array($rr)){

	  		$j++;

	   		//mysql_query("update " . $prev . "pmb set readyet=1 where mid=" . $dd[mid]);
			
            $dd1 = mysql_fetch_array(mysql_query("SELECT * FROM " . $prev . "user where user_id='" . $dd[user_id] . "'"));
			$dd2 = mysql_fetch_array(mysql_query("SELECT * FROM " . $prev . "user where user_id='" . $dd[private_id] . "'"));
			
	   		if(!($j%2)){$bg="background-color:#ffffff;";}else{$bg="background-color:#ffffff";}

	   		if($buyer_id==$dd[user_id]){$user_id1=$dd[private_id];}else{$user_id1=$dd[user_id];}

	   		echo'<tr    style="'. $bg .'">
			<td valign=top style="border-right:1px solid #b1ced9;padding-top:10px;border-bottom:1px solid #b1ced9;">'.$lang['POSTED_BY'].'<a href="'.$vpath.'publicprofile/' .$dd1[username] .'/" ><b> '. getusername($dd[user_id]) . '</b></a> <br>'.$lang['TO'].' : <a href="'.$vpath.'publicprofile/' .$dd2[username] .'/" ><b> '. getusername($dd[private_id]) . '</b></a><br><b> ' . date('M d, Y H:i:s',strtotime($dd[date])) . '</b><br>';

	   		if(getspacial($row[user_id])):

				echo '<br><a href="' . $setting[urlspecial] . '"><img src="'.$vpath.'images/certificate.gif" alt="' . $setting[specialalt] . '" border=0></a>';

	   		endif;

	   		

	   		$rrr = mysql_query("SELECT * FROM " . $prev . "bids WHERE id='" . $_REQUEST[id] . "' and user_id=" . $dd[user_id]);

			

			if(@mysql_num_rows($rrr)):

		   		echo"<strong>".$lang['MY_BIDS']."</strong> $" . @mysql_result($rrr,0,"amount"); 

	   		endif;

	   		//endif;		

	   		echo"</td><td style='border-bottom:1px solid #b1ced9;padding-left:10px;padding-top:10px'>" .nl2br($dd[message]);

	   		if($dd[attachment]){echo "<br><br><strong>".$lang['ATTACH']."</strong> <a href='" . $dd[attachment] . "' >" . substr($dd[attachment],11) . "</a>";}

	   		if($_SESSION[user_id]!=$dd[user_id])

	   		{

	   			echo"<div align=right><a   href='".$vpath."message_board/" . $dd[id] . "/" . $dd[mid] . "/" . $dd[user_id]. "/" .$dd[private_id]. "/' ><img src='".$vpath."images/small_reply.gif' border=0 height='32' width='32'></a> 
				
				</div>";
				

	   		
			
			}

			else

	 		{

	      		echo"<div align=right><a   href='".$vpath."message_board/" . $dd[id] . "/" . $dd[mid] . "/" . $dd[private_id] . "/" . $_SESSION[user_id] . "/' ><img src='".$vpath."images/post_message.png' border=0 alt='Post Message' height='32' width='32'></a></div>";
				
			
	  		}

	   		echo"</td></tr>\n";

	   		

		}

		echo'</table>';

	}

 

}

?>
</div>
<?php include 'includes/footer.php';?> 

<style>
.message a{

color: #1b4471;
font-size: 16px;
font-weight: bold;
text-decoration: none;
font-size:12px;
}
.message a:hover{
text-decoration: underline;
}
.message{
background-color:#ffffff;
font-size: 12px;
}

</style>

