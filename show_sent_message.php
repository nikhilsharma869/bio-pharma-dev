<?php 
$current_page = "<p>Mailbox</p>";
include "includes/header.php"; 
CheckLogin();

	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
	$res2=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
	$row2=mysql_fetch_array($res2);
	$res4=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
	$row3=mysql_fetch_array($res4);

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

$inbox_data="select * from  ".$prev."messages where receiver='".$_SESSION['user_id']."' and sender_id!='".$_SESSION['user_id']."' and status='Y' and user_type='reciver' and read_status='N'";
$rec_date=mysql_query($inbox_data);
$num_date=mysql_num_rows($rec_date);
?>

<!-----------Header End-----------------------------> 



<!-- content-->
<div class="freelancer">
  <!--Profile-->
  <?php include 'includes/leftpanel1.php';?>
  <!-- left side-->
  <!--middle -->
  <div class="profile_right">
    <div class="create_profile"> <? include("includes/message_header.php");?>
    </div>
    <div class="inbox_right_text1">
      <h2><?php print $row['subject'];?></h2>
    </div>
	
<?php
if($_REQUEST['sucs']=="success")
{
 if($row2['status']=='Y')
 {
?>
                    <table width="701" height="50" style="border:solid 3px #063; background-color:#A8E39D;-webkit-border-radius:6px;-moz-border-radius:6px">
                      <tr>
                        <td class="padding-top:10px;"><img src="images/checked_v.gif" />&nbsp;&nbsp;&nbsp;<strong><?php print $dbsucc;?></strong></td>
                      </tr>
                    </table>
<?php
  }
  if($row2['status']=='N')
  {
 ?>
                    <table width="701" height="50" style="border:solid 3px #063; background-color:#CCCCCC;-webkit-border-radius:6px;-moz-border-radius:6px">
                      <tr>
                        <td style="padding-left: 20px;"><img src="images/checked_v.gif" />&nbsp;&nbsp;&nbsp;<strong><?php print $dbsucc;?></strong></td>
                      </tr>
                    </table>
<?php
  }
}
?>
	
	 <div class="clear"></div>
     <table cellpadding="0" cellspacing="0" border="0" class="massage" width="100%">
        <tr>
        	<td width="6%" valign="top" class="name">Message </td>
            <td width="94%" align="left"><p><?php print nl2br($row['message']);?></p> </td>
        </tr>
        <tr>
        	<td class="name">From :</td>
            <td align="left"><p>
			<?php
				$select_to="select * from ".$prev."messages where id='".base64_decode($_GET['id'])."'";
				$rec_to=mysql_query($select_to);
				$row_to=mysql_fetch_array($rec_to);
				print $row2['fname']." ".$row2['lname'];
				echo ' to ';
				if($row_to['view_user']=='AD')
					{
					print Admin;
					}
				else
					{
					$res_user=mysql_query("select * from ".$prev."user where user_id='".$row_to['receiver']."'");
					$row_user=mysql_fetch_array($res_user);
					echo	$sendernm = $row_user['fname']." ".$row_user['lname'];
					}
			?>
			</p> </td>
        </tr>
     </table>
	<div class="clear"></div>
	
    

    </div>
	</div>
    <div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>