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

//if(!$_REQUEST[private_id]){$_REQUEST[private_id]=$buyer_id;}

$err='';
if($_REQUEST['submit']){
		$ttoy = time();
		$attachment1="";
		if($_FILES['attachment']['name']!=""):

 $ext=strtolower(end(explode(".",$_FILES['attachment']['name'])));

 if($ext=="zip" || $ext=="rar" ||  $ext=="doc" ||  $ext=="docx" ||  $ext=="pdf" ||  $ext=="txt" ||  $ext=="jpg" ||  $ext=="png" ||  $ext=="gif" ||  $ext=="jpeg" ||  $ext=="xls" ||  $ext=="xlsx" ):

copy($_FILES['attachment']['tmp_name'],"attachment/" . $ttoy . "." . $ext);

$attachment1="attachment/" . $ttoy . "." . $ext;

 else:

 $err.="<font color=red>".$lang['UPL_FAIL_H']."</font><br>";

  endif;		

endif;


$rp=mysql_query("INSERT INTO " . $prev . "pmb (id, user_id,date,private_id,message,attachment) VALUES ('".$_REQUEST[id]."','" . $_SESSION['user_id'] . "','" . date("Y-m-d H:i:s") . "','" . $_REQUEST['con_id'] . "','" . $_REQUEST[message] . "','" . $attachment1 . "')");

		
mysql_query("insert into ".$prev."messages set	receiver='".$_REQUEST['con_id']."',sender_id='".$_SESSION['user_id']."',	sender='".$_SESSION['email']."',subject='".$data[project]."',message='".$_REQUEST[message]."',user_type='reciver',sent_time=now(),	status='".$status."',message_type='A',read_status='N',view_user='U'	");

		
$mymsg = getusername($_REQUEST[con_id]) . ''.$lang['MSG_U_CAN_RERLY_H'].''. $setting[site_url] . '/message_board/' . $_REQUEST[id];

mysql_query("insert into ".$prev."messages set	receiver='".$_REQUEST['con_id']."',sender_id='".$_SESSION['user_id']."',	sender='".$_SESSION['email']."',subject='".$data[project]."',message='".$_REQUEST[message]."',user_type='reciver',sent_time=now(),	status='".$status."',message_type='A',read_status='N',view_user='U'	");

mail(getemail($_REQUEST[con_id]),$dotcom ." " .$lang['MSG_BRD_PSTD_H']." ",$mymsg,"" .$lang['FROM_H']. " ". $dotcom ."<".$setting[admin_mail] .">");


 $err.="<font color=green>".$lang['MSG_PSTD_H']."</font>";
		   

	}
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
<style>
.conversation_outer{
border:1px solid #B1CED9; border-radius:6px; float:left; margin:4px 0px 8px 0px; width:100%; padding:0px 0px 30px 0px;
}
.conversation_loop{
float:left; padding:7px 15px; border-bottom:#cde0e7 1px solid; width:97%; margin:5px 0px 5px 0px;
}
.posted_by{
font-size:13px; float:left; margin:-2px 4px;
}
.posted_by_name{
font-size:13px; font-weight: bold; float:left;
}
.messge_body{
font-size:13px; font-weight: normal; float:left; width:96%; margin:0px 0px 0px 27px;
}
.attachmentcls{
font-size:13px; font-weight: normal; float:left; width:96%;
}
.conver_date{
font-size:13px; font-weight: normal; float: left; text-align:right; width:96%;
}
</style>
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['MESSAGES']?></a></p></div>
<div class="clear"></div>

<div style="width:99%" class="myproheading"><?=$lang['CONVERSATION']?></div><br />

<div class="conversation_outer">
<?
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

	$row=@mysql_num_rows($rr);

	if($row>0){
while($dd=mysql_fetch_array($rr)){

	  		$j++;

	   		//mysql_query("update " . $prev . "pmb set readyet=1 where mid=" . $dd[mid]);
			
            $dd1 = mysql_fetch_array(mysql_query("SELECT * FROM " . $prev . "user where user_id='" . $dd[user_id] . "'"));
			$dd2 = mysql_fetch_array(mysql_query("SELECT * FROM " . $prev . "user where user_id='" . $dd[private_id] . "'"));
			
	   		if(!($j%2)){$bg="background-color:#ffffff;";}else{$bg="background-color:#ffffff";}

	   		if($buyer_id==$dd[user_id]){$user_id1=$dd[private_id];}else{$user_id1=$dd[user_id];}
?>
<div  class="conversation_loop">
<label class="posted_by"><img src="images/posted_icon.png" /></label><label class="posted_by_name"><font color="#3fbb64"><a href="<?=$vpath?>publicprofile/<?=$dd1[username]?>/" style="color:#3fbb64" ><?=getusername($dd[user_id])?></a></font></label>
<div style="clear:both; height:12px;"></div>

<div class="messge_body"><?=nl2br($dd[message])?></div>
<div style="clear:both; height:6px;"></div>
<? if($dd[attachment]){?>
<label class="posted_by"><img src="images/attachment_icon.png" /></label><label class="attachmentcls"><strong><?=$lang['ATTACH']?></strong> <a href='<?=$dd[attachment]?>' style="color:#1B4471" target="_blank"><?=substr($dd[attachment],11)?></a></label>
<div style="clear:both; height:4px;"></div>
<? }?>
<label class="conver_date"><em><?=date('M d, Y H:i:s',strtotime($dd[date]))?></em></label>

</div>
<? }}else{ echo '<div align="center" style="padding-top:20px;">'.$lang['NO_RECORD_FOUND'].'</div>'; }?>
</div>






        
        
        
        

<div class="clear"></div>
<div style="width:99%" class="myproheading"><?=$lang['PROJECT_NAMEE']?>: <? if($_REQUEST[id]){echo strtoupper(substr($data[project],0,1)) .substr($data[project],1); }?></div><br />
<? 	if($err){
echo $err;
}
if($_REQUEST['id'] &&  $_SESSION[user_id]!=''){?>
<form onsubmit="javascript:return validatepost(this);" enctype="multipart/form-data" action="" method="POST">
<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" class="table_class">

		<tbody><tr><td><table width="100%" cellspacing="0" cellpadding="4" border="0" align="center">

		

		<input type="hidden" name="id" value="<?=$_REQUEST[id]?>">

		<input type="hidden" name="mid" value="<?=$_REQUEST[mid]?>">

		<input type="hidden" name="private_id" value="<?=$_REQUEST[private_id]?>">

		<tbody><tr><td valign="top" align="right" class="tdclass"><b><?=$lang['MSG1_PSTD_H']?> :</b></td><td><textarea style="width: 70%; height: 85px;" class="text_box" cols="52" id="message" name="message" rows="8"></textarea></td></tr><tr>

		</tr>
		<tr><td valign="top" align="right" class="tdclass"><b><?=$lang['ATTACH']?> :</b></td><td><input type="file" class="text_box" size="35" name="attachment"><br><span style="color:red;width:100%;float:left"><?=$lang['ZIP_RAR_H']?></span></td></tr><tr>

		</tr><tr><td></td><td><input type="submit" class="submit_bott" value="<?=$lang['SUBMIT']?>" name="submit"> &nbsp;&nbsp;&nbsp;<input type="button" class="submit_bott" value="<?=$lang['CANCEL']?>" name="submit" onclick="avascript:history.go(-1);" style="margin-left:20px;">
		
		</td></tr></tbody></table></td></tr></tbody></table>
</form>
		<? }?>
		


		
		
		
		
		
		
		
		
		
</div>
<?php include 'includes/footer.php';?> 