<?php 



include "includes/header.php"; 

CheckLogin();





$img_folder='disput_attach';

$r=mysql_query("select * from " . $prev . "user where user_id='".$_SESSION[user_id]."'");

$r1=mysql_fetch_array($r);

if($r1[user_type]=='W')

{

	$cond=$prev . "projects.chosen_id='".$_SESSION[user_id]."' and ";

	$userid='chosen_id';

}

if($r1[user_type]=='E')

{

	$cond=$prev . "projects.user_id='".$_SESSION[user_id]."' and ";

	$userid='user_id';

}



if(isset($_POST['Submit']))

{

	

	$claim_array=explode("|",$_REQUEST['claim_user']);

	$r=mysql_query("select * from " . $prev . "disputes where claim_proj_id='".$claim_array[0]."'");

	$r1=mysql_fetch_array($r);

	if($r1['round_stat']!='Y')

	{

		//echo "insert into  " . $prev . "disputes set disput_by='".$_SESSION['user_id']."',claim_proj_id='".$claim_array[0]."',disput_for='".$claim_array[1]."',claim_title='".$_REQUEST['dis_title']."',claim_desc='".$_REQUEST['claim_desc']."',claim_amount='".$_REQUEST['claim_amount']."',round_stat='Y',date=NOW()";

	$cuser=$claim_array[1];

	

	$a=mysql_query("update ".$prev."escrow set status = 'D' where escrow_id = '".$cuser."'");

	//echo "update ".$prev."escrow set status = 'D' where escrow_id = '".$cuser."'";

	$q=mysql_query("insert into  " . $prev . "disputes set disput_by='".$_SESSION['user_id']."',claim_proj_id='".$claim_array[2]."',disput_for='".$claim_array[3]."',claim_title='".$_REQUEST['dis_title']."',claim_desc='".$_REQUEST['claim_desc']."',claim_amount='".$_REQUEST['claim_amount']."',round_stat='Y',date=NOW()");

	

	

	$_SESSION['succ']=$lang['DISPUTE_POSTED'];

	$id=mysql_insert_id();

	

	if($_FILES['attach_file']['name'])

	{

		$pathinfo = pathinfo($_FILES['attach_file']['name'],PATHINFO_EXTENSION);

		$file_name=$id.".".$pathinfo;

		mysql_query("update " . $prev . "disputes set attach_file='".$file_name."' where disput_id='".$id."'");

		move_uploaded_file($_FILES['attach_file']['tmp_name'],$img_folder."/".$file_name);

	}

	

	

	

			$rw9 = mysql_query("select * from ".$prev."disputes where disput_id = '".$id."'");

			$rw3 = mysql_fetch_array($rw9);

			$rw5 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id ='".$rw3['disput_for']."'"));

			$rw6 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw3['disput_by']."'"));

			$rw7 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".$rw3[' claim_proj_id']."'"));

			

			$to  = $rw5['email'];

			$subject = ' '.$lang['DISPUTE_IN_YOUR_PROJECT']. ': '.ucwords($rw7['project']);

			$message = ' '.$lang['EMPLOYER_PROJECT']. ' :'.ucwords($rw6['fname']).' '.ucwords($rw6['lname']).' '.$lang['REPORTED_DISPUTE'].'<br>'.$lang['CHECK_ACCOUNT_DETAILS'].' ';

			$fname=$rw5['fname'];

			$lname=$rw5['lname'];

			$mail_type='dispute_mail';

			

			genMailing($to, $subject, $message, $from = '', $reply = true, $mail_type,$fname,$lname);

	}

	else

	{

		$_SESSION['error']=$lang['ALREADY_REPLIED'];

	}

}

?>



<script language="javascript" type="text/javascript">

function ValidateForm(frm) 

{

	var txt='';

	if(frm.dis_title.value=="")

	{

	   txt+="<?=$lang['VALIDATION_TITLE_H']?>";

	

	}

	if(frm.claim_user.value=="")

	{

		txt+="<?=$lang['VALIDATION_SLECT_CLAIM_H']?>";

	}

	if(frm.claim_desc.value=="")

	{

		txt+="<?=$lang['VALIDATION_SLECT_DESC_H']?>";

	}

	if(frm.claim_amount.value=="")

	{

	   txt+="<?=$lang['VALIDATION_ENT_CLM_AMT_H']?>";

	

	}

	if(txt)

	{

		alert('<?=$lang['VALIDATION_MANDATORY_H']?>'+txt);

		return false;

	}

	return true;

}



function change_amt(id)

{

	//alert (id);

	var amt=id.split("|");

	//alert (amt[0]);

	document.getElementById('claim_amount').value=amt[0];

	//alert(document.getElementById('claim_amount').value);

}







</script>

<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>">Home</a> | <a href="<?=$vpath?>active_dispute.html">Disputes</a> | <a href="javascript:void(0);" class="selected">Create Dispute</a></p></div>
<div class="clear"></div>
  <?php include 'includes/leftpanel1.php';?>

  

  

 <div class="profile_right">
<div id="wrapper_3">
              <ul class="tabs">      
                <li><a href="<?=$vpath?>active_dispute.html" class="" ><?=$lang['ACTIVE_DISPUTE']?></a></li>
                <li><a class="defaulttab " href="javascript:void(0);" ><?=$lang['CLOSE_DISPUTE']?> </a></li>
              </ul>

 <div class="browse_tab-content"> 
            	<div class="browse_job_middle">



<form action="" method="POST" name="_profile" id="_profile" enctype="multipart/form-data" onsubmit="javascript: return ValidateForm(this);">

	<div class="dispute_from">

	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

          <tr>

            <td align="left" valign="top"></td>

          </tr>

          <tr>

            <td align="left" valign="top" class="bx-border">

			<?php

				if($_SESSION['error']!="")

				{

					include('includes/err.php');

					unset($_SESSION['error']);

				unset($_SESSION['succ']);

				}

				if($_SESSION['succ']!="")

				{

					include('includes/succ.php');

					unset($_SESSION['error']);

				unset($_SESSION['succ']);

				}

				?>

			<table border="0" cellpadding="10" cellspacing="0" >

             

              <tr>

                <td width="30%"><p><b><?=$lang['TITLE_DUPLICATE']?>: * </b></p></td>

                <td class="grid"><input name="dis_title" type="text" value="" size="38" class="input_box" style="color:#000000;"/></td>

              </tr>

              <tr>

                <td> <p><b><?=$lang['CLAME_AGAINST_PROJECT']?>: * </b></p></td>

                <td class="grid"><select name='claim_user'  class="input_box" style="color:#000000;" onchange="change_amt(this.value)" >

                  <option value=""><?=$lang['SELECT_CLAME_PROJECT']?></option>

                  <?php	

			  		 		  	

				$resout_mile = mysql_query("select * from ".$prev."escrow where user_id = '".$_SESSION['user_id']."' and status='P' order by add_date desc");				

				    

				    while($rwout_mile=mysql_fetch_array($resout_mile))

					{

						$respr1 = mysql_fetch_array(mysql_query("SELECT project_id FROM ".$prev."buyer_bids WHERE  id='".$rwout_mile['bidid']."'"));

						$respr2 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".$respr1['project_id']."'"));

						$respr3 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rwout_mile['bidder_id']."'"));



			           echo"<option value='" .$rwout_mile[amount]."|".$rwout_mile[escrow_id]."|".$respr1[project_id]."|".$rwout_mile[bidder_id] ."'>" . $respr2[project] . "</option>\n";



			        }



					

			   ?>

                </select></td>

              </tr>

              <tr class="hilite1">

                <td align="left" valign="top"><p><b ><?=$lang['CLAME_DESCRIPOTION']?>: * </b></p></td>

                <td class="grid"><textarea name="claim_desc" cols="25" rows="7" class="disput_text_box" style="color:#000000;"></textarea>

                </td>

              </tr>

              <tr>

                <td width="30%"><p><b ><?=$lang['ATTACH_IF_ANY_H']?>: </b><p></td>

                <td class="grid"><input type="file" name="attach_file" size="30" class="input_box" style="color:#000000;">

                </td>

              </tr>

              <tr class="hilite1">

                <td width="30%"><p><b ><?=$lang['CLAIM_AMT_H']?> *</b>(<?=$lang['IN']?> <?=$curn?>)</p></td>

                <td class="grid">

                      <input readonly="readonly" name="claim_amount" id="claim_amount" type="text"  size="20" class="input_box" style="color:#000000;"/>

                </td>

              </tr>

              <tr class="hilite1">

                <td>&nbsp;</td>

                <td align="left" valign="top" ><input name="submit" type="submit" class="submit_bott" value="<?=$lang['SUBMIT']?> " />

                      <input type="hidden" name="Submit" value="1" />

                </td>

              </tr>

            </table></td>

          </tr>

          <tr>

            <td align="left" valign="top" class="inner_bx-bottom">&nbsp;</td>

          </tr>

        </table>

	</div>

	

</form>	

	

</div>



</div>	


</div>



</div>	</div>

<div style="clear:both; height:10px;"></div>



<?php include 'includes/footer.php';?>