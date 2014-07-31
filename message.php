<?php 
$current_page = "Mailbox";

include "includes/header.php"; 

CheckLogin();



	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

	$res2=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

	$row2=mysql_fetch_array($res2);

	$res4=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");

	$row3=mysql_fetch_array($res4);

	

	$no_of_records=10;

	$select_project="";	

	

	$q = "SELECT * FROM (

				SELECT *

				FROM ".$prev."pmb

				WHERE private_id = '$_SESSION[user_id]'

				ORDER BY mid DESC

				) AS tmp_table

				GROUP BY id, user_id";

    //$q = "SELECT * from ".$prev."pmb where private_id='$_SESSION[user_id]' group by id,user_id order by mid DESC";

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

		$msg=$lang['MSG_DELETED'];

		$msg1=base64_encode($msg);

		//header("location:message.php?page=$page&msg='".$msg1."'");

	}

	else

	{

		$page=$_REQUEST['page'];

		$msg=$lang['NO_CONVERSATION_SELECT'];

		$msg1=base64_encode($msg);

		//header("location:message.php?page=$page&msg='".$msg1."'");

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

		//header("location:message.php?page=$page");

	}

	else

	{

		$page=$_REQUEST['page'];

		$msg=$lang['NO_CONVERSATION_SELECT'];

		$msg1=base64_encode($msg);

		//header("location:message.php?page=$page&msg='".$msg1."'");

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

		//header("location:message.php?page=$page");

	}

	else

	{

		$page=$_REQUEST['page'];

		$msg=$lang['NO_CONVERSATION_SELECT'];

		$msg1=base64_encode($msg);

		//header("location:message.php?page=$page&msg='".$msg1."'");

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

	$msg=$lang['MSG_DELETED'];

	$msg1=base64_encode($msg);

	//header("location:messages.php?msg='".$msg1."'");

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

		alert("<?=$lang['SELECT_CHECKBOX']?>");

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
<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">

<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['INBOX']?></a></p></div>
<div class="clear"></div>

  <!--Profile-->

  <?php include 'includes/leftpanel1.php';?>

  <!-- left side-->

  <!--middle -->

  <div class="profile_right">
 <ul class="tabs">
  <li><a href="javascript:void(0)" class="selected"><?=$lang['INBOX']?></a></li>
  </ul>

<div class="newclassborder">
   <form action="" method="post" name="frm" id="frm">

 

	



	

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

                      <td align="center" >

                      </td>

                      <td align="left"><strong><?=$lang['MESSAGE_FRM']?></strong></td>

                      <td align="left"><strong><?=$lang['MESSAGE_PROJ']?></strong></td>

                      <td  align="center"><strong><?=$lang['MESSAGE_DT']?></strong></td>

                    </tr>

                    <?php

					$i=1;

					if($num>0)

					{

						$index=10;

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

							//echo "select * from ".$prev."user where user_id='".$row['user_id']."'";

							

							$res1=mysql_query("select * from ".$prev."user where user_id='".$row['user_id']."'");

							$row1=mysql_fetch_array($res1);

							$sendernm = $row1['fname']." ".$row1['lname'];

						

							?>

										<tr style="height: 40px; <?php if($row['readyet']=='0'){ print "background-color:#CCDDB9";}else{echo "background-color:#fff";}?>">

										 

										  <td align="center"></td>

										  <td align="left" valign="center" style="font-size:12px; color:#6d6d6d; padding-left:5px;"><?php print $sendernm;?> </td>

										  <td align="left" style="padding-left:5px;">

							<?php

								$proj_nm = mysql_fetch_array(mysql_query("SELECT project from ".$prev."projects where id='$row[id]'"));

								

								?>			  

										<a class="font_bold2" style="font-weight: inherit;" href="<?=$vpath?>conversation/<?php echo $row['id'];?>/<?=$row['user_id']?>/" title="Click Here to view Message"><?php if($proj_nm[project]!=''){print ucwords($proj_nm[project]);}else{echo "Not defined";}?></a>

							

								

										  </td>

										  <td align="center" ><?php echo date('M d, Y H:i:s ',strtotime($row['date']));?>

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

						<td colspan="4" style="color:#999999;padding-left: 250px;padding-top: 20px; font-size:12px; font-weight:bold;"><?=$lang['NO_MESSAGE']?></td>

						</tr>

						<?php

					}



				  ?>

                  </table>





           

		</td>

		</tr>

		<tr>

		<td>

		<?php

		if($total>$no_of_records)

		{			 			 echo "<div align=right>" .new_pagingnew(0,$vpath.'message/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>"; 

		}

		?> </td>

        </tr>

      </table>

    </div>



 </form>

  </div>

 </div>  

</div>

</div>
</div>



<?php include 'includes/footer.php';?>