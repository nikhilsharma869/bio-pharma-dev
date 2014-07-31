<? include("configs/path.php");
if($_POST[project_id]!='' && $_SESSION[user_id]!='' && $_POST[bidder_id]!=''){

$rowcheck = mysql_num_rows(mysql_query("select id from ".$prev."projects where id = '".$_POST[project_id]."' and user_id='".$_SESSION['user_id']."'"));
if($rowcheck==1){
/****************************/
mysql_query("UPDATE " . $prev . "projects SET chosen_id='".$_POST[bidder_id]."', status='frozen' WHERE id='".$_POST[project_id]."' and user_id='".$_SESSION['user_id']."'");

mysql_query("UPDATE " . $prev . "buyer_bids SET chose='N', chosen_id='0' WHERE project_id='".$_POST[project_id]."'");
					
mysql_query("UPDATE " . $prev . "buyer_bids SET chose='P', chosen_id='".$_POST[bidder_id]."' WHERE project_id='".$_POST[project_id]."' and bidder_id='".$_POST[bidder_id]."'");

 $msg = $setting[emailheader] .$lang['MSG_JOB'] . getproject($_POST[project_id]) . $lang['MSG_JOB_IMP'] . $setting[site_url] . 'my-jobs.php?mode=accept&id=' . $_POST[project_id] . '&confirm=' . $_POST[project_id] . $lang['MSG_JOB_2'] . $setting[emailaddress] . '

--------------------

' . $setting[emailfooter];

$from=stripslashes($setting['admin_mail']);

 $mail_id=getemail($_POST[bidder_id]);

$mail_type = 'select_provider';

$usr = mysql_fetch_array(mysql_query("SELECT fname,lname from ".$prev."user where user_id=".$_POST[bidder_id]));
					
$row_mail_type = mysql_fetch_array(mysql_query("select * from ".$prev."mailsetup where mail_type = '".$mail_type."'"));

$body = html_entity_decode($row_mail_type['header']) . $msg . html_entity_decode($row_mail_type['footer']);

$body1=str_replace("{first_name}",$usr['fname'],$body);
$body1=str_replace("{last_name}",$usr['lname'],$body1);

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= $lang['FROM_H'].":$dotcom <" . $from . ">\r\n";
$headers .= $lang['REPLY_TO'].": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
						
mail($mail_id,$setting[companyname] . $lang['BID_WON'],$body1,$headers);
						

 

$notify = mysql_query("INSERT into ".$prev."notification set user_id=".$_POST['bidder_id'].", message='".$lang['HIRE_INFO']."', add_date='".date('Y-m-d')."'");

/***************************/
echo "<img src='".$vpath."images/".$ln."/invited_ic.jpg' alt='invided' title='invited'/>";

}else{
echo "<font color=red>Error</font>";
}

}else{
echo "<font color=red>Error</font>";
}
?>