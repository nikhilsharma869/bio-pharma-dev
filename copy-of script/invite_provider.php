<?php 
$current_page="Invite Provider";
include "includes/header.php"; 

include("country.php");
CheckLogin();

$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where username = '".$_REQUEST[username]."'"));

$_REQUEST[id]=$row_user[user_id];

$row_user1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION['user_id']."'"));

$_REQUEST['firstname']=$row_user1['fname'];
$_REQUEST['lastname']=$row_user1['lname'];


if($_REQUEST['send_submit'])
{
$fetch=@mysql_fetch_array(mysql_query("select * from ".$prev."projects where id=".$_REQUEST[proj]));
		$fname=$_REQUEST[f_name];
		$lname=$_REQUEST[l_name];
		$link=$vpath."project/".$_REQUEST[proj];
	$to=$_REQUEST['txtemail'];

	$subj=$lang['PROJ_INV'].$fetch[project];

	$body=$_REQUEST['txtmesg'].$lang['PROJ_FOR'].'<b>'.ucwords($fetch[project]).'</b>.
	<br>'.$lang['PROJ_LINK'].'
	<br>'.$link.'
	<br /><br /> '.$lang['FROM_H'].' '.$row_user1['fname'].' '.$row_user1['lname'];
	$from=getusername($_SESSION['user_id']);
	$mail_type = 'invitation';
	$r=genMailing($to,$subj,$body,$from, $reply = true, $mail_type,$fname,$lname);
	if($r==1)
	{
	  $_SESSION['succ'] = $lang['MAIL_SUC'];
	}
}

?>

<script language="javascript" type="text/javascript">
function Validsendmessage(frm)
{
	var str=frm.txtemail.value;
	var filter=/^.+@.+\..{2,3}$/;
	if (filter.test(str))
	{
		testresults=true;
	}
	else 
	{
		alert(<?=$lang['VALID_EMAIL_ADDRESS']?>);
		testresults=false;
	}
	return (testresults);
}
</script>



<!-----------Header End-----------------------------> 



<!-- content-->
<div class="browse_contract">
  <!--Profile Left Start-->
  <?php include 'includes/left_profile.php';?>
  <!--Profile Left End-->
  <!--Profile Right Start-->
  
  <div class="profile_right">
    <div class="create_profile">
	 <p><a href="<?=$vpath?>publicprofile/<?=base64_encode($row_user["user_id"])?>"><?=ucwords($row_user['fname']).'&nbsp;'.ucwords($row_user['lname']);?></a></p>
      <br />
    </div>
	
	<div class="create_profile2">
      <div class="create_profile2_left">
	  
	<div class="notification">
          <div class="notification_link1" style="width: 739px;">
            <h1><?=$lang['INVT_PROV']?> <?=ucwords($row_user['fname']).'&nbsp;'.ucwords($row_user['lname']);?></h1>
		 <div class="overview_text">
		<table cellpadding="5" cellspacing="0" border="0" width="100%" >
            <tr>
              <td height="10px;">
			  <?php 
			  if(isset($_SESSION['succ'])) 
					{ 
					include('includes/succ.php');
					unset($_SESSION['succ']); 
					}
				?>
				</td>
            </tr>
            <tr>
              <td><? $proj_sql_num=@mysql_num_rows(mysql_query("select * from ".$prev."projects where user_id='".$_SESSION[user_id]."' and status='open'"));
if($proj_sql_num>0){
?>
                  <form action="" method="post" name="mail" id="mail" onsubmit="javascript:return Validsendmessage(this);">
                    <table cellspacing="0" cellpadding="4" width="100%" border="0" align="center" >
                      <tr >
                        <td valign="top" >
                            <table align="left" cellspacing="0" cellpadding="5" width="100%" border="0">
                              <tr class="tbl_bg2" >
                                <td><h2><?=$lang['TO']?><font color="#FF0000">*</font></h2></td>
                                 <td align="left" ><b><?=ucwords($row_user['fname']." ".$row_user['lname']);?></b></td>
                              </tr>
                              
                              <tr class="tbl_bg2" >
                                <td  valign="top" ><h2><?=$lang['SELECT_PROJECT']?>:</h2></td>
                                  <td > 
                                    <select name="proj" class="from_input_box"  style="width:395px;">
                                      <?
  $proj_sql=@mysql_query("select * from ".$prev."projects where user_id='".$_SESSION[user_id]."' and status='open'");
  while($proj_fetch=@mysql_fetch_array($proj_sql)){
    
  ?>
                                      <option value="<?=$proj_fetch['id']?>">
                                        <?=$proj_fetch['project']?>
                                      </option>
                                      <? }?>
                                    </select>
                                 </td>
                              </tr>
                              <tr class="tbl_bg2" valign="top">
                                <td valign="top" style="vertical-align: top;"><h2><?=$lang['MSG']?> <?=$lang['OPT']?></h2></td>
                        		<td ><textarea name="txtmesg" rows="6" cols="40" class="text_box" ><?=$lang[$setting[invitation]]?> </textarea>
                                </td>
                              </tr>
                              <tr class="tbl_bg2" >
                                <td align="left">
								<input type="hidden" name="txtemail" size="52"  value="<? print $row_user[email];?>">
								<input type="hidden" name="f_name" size="52"  value="<? print $row_user[fname];?>">
                                 <input type="hidden" name="l_name" size="52"  value="<? print $row_user[lname];?>"></td>
								 <td>
								<input type='submit' border="0" class="submit_bott" value="<?=$lang['SEND']?>"  name="send_submit">
                                  &nbsp;&nbsp;</td>
                              </tr>
                          </table></td>
                      </tr>
                    </table>
                  </form>
                <? }else{?>
                <?=$lang['POST_NEW_PROJ']?> <a href="<?=$vpath?>postjob.html">
                  <input type="button" name="Button" value="Post a New Project"  class="submit_bott"/>
                  </a>
                <? }?>
              </td>
            </tr>
            <tr>
              <td height="10px;"></td>
            </tr>
          </table>
		</div>
		</div>
		</div>

	</div>
	</div>
    
  </div>
  <!-- end rightside-->
</div>

 <div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?> 