<?php 
$current_page = "Mailbox";
include "includes/header.php"; 
CheckLogin();

	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
	$res2=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
	$row2=mysql_fetch_array($res2);
	$res4=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
	$row3=mysql_fetch_array($res4);


session_start();
 	
	$no_of_records=10;
	$select_project="";
	
			$rt=mysql_query("select * from  ".$prev."messages where sender_id='".$_SESSION['user_id']."' and status='Y' and user_type='sender' order by sent_time desc");
			$total = @mysql_num_rows($rt);

			  $page = $_GET['page'];

			  	if($_GET['page'])
				{
					$q="select * from  ".$prev."messages where sender_id='".$_SESSION['user_id']."' and status='Y' and user_type='sender' order by sent_time desc limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
				}
				else
				{	
					$q="select * from  ".$prev."messages where sender_id='".$_SESSION['user_id']."' and status='Y' and user_type='sender' order by sent_time desc limit 0,".$no_of_records."";
				}
				
				$r=mysql_query($q);
				$j=0; 

			

			$parameter="";
			$page_num=@mysql_num_rows($r);
			$a=1;
			 $num=mysql_num_rows($r);


if($_POST['del']=="Delete")
{
	$id=$_POST['chk'];
	if($id!=null)
	{
		foreach($id as $val)
		{
			$res3=mysql_query("delete from  ".$prev."messages  where id='".$val."'");
		}
		$page=$_REQUEST['page'];
		$msg='* Message deleted successfully ..';
		$msg1=base64_encode($msg);
		//header("location:sent_message.php?page=$page&msg='".$msg1."'");
	}
	else
	{
		$page=$_REQUEST['page'];
		$msg='* No conversations selected .';
		$msg1=base64_encode($msg);
		//header("location:sent_message.php?page=$page&msg='".$msg1."'");
	}
}

if($_POST['unread']=="Mark as Unread")
{
	$id=$_POST['chk'];
	if($id!=null)
	{
		foreach($id as $val)
		{
			$res3=mysql_query("update ".$prev."messages set read_status='N' where id='".$val."'");
		}
		$page=$_REQUEST['page'];
		//header("location:sent_message.php?page=$page");
	}
}

if($_POST['read']=="Mark as Read")
{
	$id=$_POST['chk'];
	if($id!=null)
	{
		foreach($id as $val)
		{
			$res3=mysql_query("update ".$prev."messages set read_status='Y' where id='".$val."'");
		}
		$page=$_REQUEST['page'];
		//header("location:sent_message.php?page=$page");
	}
}


if(isset($_REQUEST['bookers_inbox']) && $_POST['checkboxmsg']!="")
{
$checkbox = $_POST['checkboxmsg']; //from name="checkbox[]"
$countCheck = count($_POST['checkboxmsg']);
$del_id='';
	for($i=0;$i<$countCheck;$i++)	 
	{
	$del_id= $checkbox[$i];
	$sql = "DELETE from ".$prev."messages where id='".$del_id."'";
	$result = mysql_query($sql) or die (mysql_error());
	}
	$msg='* Message deleted successfully ..';
	$msg1=base64_encode($msg);
	//header("location:sent_message.php?msg='".$msg1."'");
}

$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION['user_id']."'"));

$inbox_data="select * from  ".$prev."messages where receiver='".$_SESSION['user_id']."' and sender_id!='".$_SESSION['user_id']."' and status='Y' and user_type='reciver' and read_status='N'";
$rec_date=mysql_query($inbox_data);
$num_date=mysql_num_rows($rec_date);
?>


<script type="text/javascript">
function validate()
{
var chks = document.getElementsByName('checkboxmsg[]');
var hasChecked = false;
	for (var i = 0; i < chks.length; i++)
	{
		if(chks[i].checked)
		{
			hasChecked = true;
			break;
		}
	}
	if (hasChecked == false)
	{
		alert("Please select at least one checkbox.");
		return false;
	}
return true;
}


function modify_boxes(to_be_checked,total_boxes)
{
 for ( i=0 ; i < total_boxes ; i++ )
 {
   if(to_be_checked)
   {//alert(document.frm.chk[i]);  
 		document.frm.chk[i].checked=true;
		document.getElementById('checkboxtrue').style.display = 'none';
		document.getElementById('checkboxfalse').style.display = '';
		document.getElementById('checkboxfalse').checked = true;
   }
   else
   {
   		document.frm.chk[i].checked=false;
		document.getElementById('checkboxtrue').style.display = '';
		document.getElementById('checkboxfalse').style.display = 'none';
		document.getElementById('checkboxtrue').checked=false;
   }
 }  
}

</script>


<div class="browse_contract">
  <!--Profile-->
  <?php include 'includes/leftpanel1.php';?>
  <!-- left side-->
  <!--middle -->
  <div class="profile_right">
  <form action="" method="post" name="frm" id="frm">
    <div class="create_profile"> <? include("includes/message_header.php");?>
    </div>
	
    <div class="inbox_right_text1">
      <div class="inbox_text_link">
	  
        <input type="submit" name="del" value="Delete" class="whit" id="mc_ctrl_delete" />
      </div>
    </div>
	
	    <?php
	if($_REQUEST['msg']!="")
	{ 
		?>
    <div class="sort_text_box">
      <div class="sort_text_left">
        <?php
			echo '<p>'. base64_decode($msg1) .'</p>';
			?>
      </div>
    </div>
    <?php
	}
?>

	 <div class="create_profile2">
	 
		 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_class">
        <tr>
          <td colspan="4">
           


                  <table width="100%" border="0" cellspacing="0" cellpadding="5">
                             <tr style="height: 40px;  background-color:#f7f7f7;">
                                <td style="width: 20px;" align="center"><?php

								if($num > 1)
								{
								?>
									<input type="checkbox" id="checkboxtrue" name="CheckAll" value="checkbox" onclick="modify_boxes(true,<?php echo $num;?>);" />
									<input type="checkbox" id="checkboxfalse" style="display:none;" name="CheckAll" value="checkbox" onclick="modify_boxes(false,<?php echo $num;?>);" />
														<?php
								}
								?>
                                </td>
								 <td align="left"><strong>SENT TO</strong></td>
                     			 <td align="left"><strong>SUBJECT</strong></td>
                     			 <td  align="center"><strong>DATE</strong></td>
                              </tr>
                              <?php

								$i=1;
								if($total>0)
								{
									/*$index=10;
									$no_page=ceil($no/$index);
									if($_GET['pg'])
									{
										$page=$_GET['pg'];
									}
									else
									{
										$page=1;
									}
									$upper=($page-1)*$index;
									$res=mysql_query("select * from ".$prev."messages where receiver='".$_SESSION['user_id']."' and status='Y' and  (message_type='A' or message_type='AU' ) order by id desc limit ".$upper.",".$index."");*/
									$i=1;
									while($row=mysql_fetch_array($r))
									{
										if($i%2==0)
										{
											$c1='#f7f7f7';
										}
										else
										{
											$c1='white';
										}
										if($row['sender_id']!=0)
										{
											$res1=mysql_query("select * from ".$prev."user where user_id='".$row['sender_id']."'");
											$row1=mysql_fetch_array($res1);
											$sendernm = $row1['fname']." ".$row1['lname'];
										}
										else
										{
											$sendernm = 'Admin';
										}
										?>
										<tr style="height: 40px; background-color:<?= $c1;?>; <?php if($row['read_status']=='N'){ print "font-weight:bold";}?>">
										<td align="center"><input type="checkbox" name="chk[]" id="chk" value="<?php print $row['id'];?>" /></td>
										<td align="left" ><?php //print $sendernm;?>
										<?php
										$select_to="select * from ".$prev."messages where id='".$row['id']."'";
										$rec_to=mysql_query($select_to);
										$row_to=mysql_fetch_array($rec_to);

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
										</td>
										<td align="left" style="padding-left:5px;"><a style="font-size:12px; color:#0073A3; font-weight:bold; text-decoration:none;" href="<?=$vpath?>showsentmessage/<?php print base64_encode($row['id']);?>" title="Click Here to view Message"><?php print $row['subject'];?></a> </td>
										<td align="center" ><?php //print $row['sent_time'];?>
										<?php
										$sent_time=explode(' ',$row['sent_time']);
										$sent_time1=$sent_time[0];
										$sent_time2=explode('-',$sent_time1);
										$sent_time3=$sent_time2[2].'-'.$sent_time2[1].'-'.$sent_time2[0].'&nbsp;'.$sent_time[1];
										echo date('d-m-Y h i:s a',strtotime($row['sent_time'])); 
										?>
										</td>
										</tr>
										<?php
										$i++;
									}
								}
								else
								{
								?>
									  <tr>
										<td colspan="4" style="color:#999999;padding-left: 250px;padding-top: 20px; font-size:12px; font-weight:bold;">No Message Found</td>
									  </tr>
									  <?php
								}
								?>
								<tr>
										<td colspan="4">
								<?php
								if($total>$no_of_records)
									{
									//echo "aaa";
									  echo"<div align=right>" .new_pagingnew(0,$vpath.'Sent/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
									
									}
								?>
								</td>
								</tr>

                            </table>

			</td>
        </tr>
      </table>
    </div>

</form>
</div>

</div>
<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>