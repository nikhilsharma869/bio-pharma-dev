<?php 
$current_page = "Message posted ";

include "includes/header.php";
CheckLogindecode(base64_encode("project/".$_REQUEST['id']));
//CheckLogin();
$err='';
if($_REQUEST['submit']){

$result = mysql_query("select user_id from " . $prev . "projects WHERE id=" . $_REQUEST[id]);
	$data=@mysql_fetch_array($result);
	$buyer_id=$data[user_id];
		$ttoy = time();
		$attachment1="";
		if($_FILES['attachment']['name']!=""):
   $ext=strtolower(end(explode(".",$_FILES['attachment']['name'])));
 if($ext=="zip" || $ext=="rar" ||  $ext=="doc" ||  $ext=="docx" ||  $ext=="pdf" ||  $ext=="txt" ||  $ext=="jpg" ||  $ext=="png" ||  $ext=="gif" ||  $ext=="jpeg" ||  $ext=="xls" ||  $ext=="xlsx" ):
copy($_FILES['attachment']['tmp_name'],"attachment/" . $ttoy . "." . $ext);

$attachment1="attachment/" . $ttoy . "." . $ext;
 else:
 $err.="<font color=red>".$lang['UPL_FAIL_H']."</font>";

 endif;		

endif;

$rp=mysql_query("INSERT INTO " . $prev . "pmb (id, user_id,date,private_id,message,attachment) VALUES ('".$_REQUEST[id]."','" . $_SESSION['user_id'] . "','" . date("Y-m-d H:i:s") . "','" . $buyer_id . "','" . $_REQUEST[message] . "','" . $attachment1 . "')");

mysql_query("insert into ".$prev."messages set	receiver='".$buyer_id."',sender_id='".$_SESSION['user_id']."',	sender='".$_SESSION['email']."',subject='".$data[project]."',message='".$_REQUEST[message]."',user_type='reciver',sent_time=now(),	status='".$status."',message_type='A',read_status='N',view_user='U'	");

$mymsg = getusername($buyer_id) . ''.$lang['MSG_U_CAN_RERLY_H'].''. $setting[site_url] . '/message_board/' . $_REQUEST[id];

mysql_query("insert into ".$prev."messages set	receiver='".$buyer_id."',sender_id='".$_SESSION['user_id']."',	sender='".$_SESSION['email']."',subject='".$data[project]."',message='".$_REQUEST[message]."',user_type='reciver',sent_time=now(),	status='".$status."',message_type='A',read_status='N',view_user='U'	");



$message='<table border=0 cellspacing=0 cellpadding=4 width=98% align=center><tr ><td align=center><p  ><strong><font color=green>'.$lang['MSG_PSTD_H'].'</font></strong><br>' . $err . '</td></tr></table>';
	}

?>
<div class="browse_contract">

  <div class="howitworks_box">
    <div class="howitworks_text">
      <h1><?=$lang['MESSAGE']?></h1>
      <p><?php echo $message; ?></p>
      <br clear="all" />
      <a href="<?=$vpath?>project/<?=$_POST['id'];?>/" class="submit_bott" style="text-decoration:none; margin:6px 14px;">	<?=$lang['BACK']?></a> </div>
  </div>
  <!--Howitworkst End-->
</div>
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php'; ?> 