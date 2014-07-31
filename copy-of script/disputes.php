<?php
include "includes/header.php";
CheckLogin();
?>





<script type="text/javascript" src="js/general_functions.js"></script>
<script language="javascript" type="text/javascript">
function ValidateForm(frm) 
{
	var txt='';
	if(frm.dis_title.value=="")
	{
	   txt+="please enter title.\n";
	
	}
	if(frm.claim_user.value=="")
	{
		txt+="please select claim against.\n";
	}
	if(frm.claim_desc.value=="")
	{
		txt+="please enter claim description.\n";
	}
	if(frm.claim_amount.value=="")
	{
	   txt+="please enter claim amount.\n";
	
	}
	if(txt)
	{
		alert('following feild are mandatory.\n\n'+txt);
		return false;
	}
	return true;
}


</script>

<style type="text/css">
#process_waiting_dialog
{
  width:640px;
  height:100px;
  background:#eee;
  border:2px solid #aaa;
  position: absolute;
  margin-left: -170px; 
 }
</style>
		

<!-----------Header End-----------------------------> 


<!-- content-->
<div class="freelancer">


<!--Profile-->
<?php include 'includes/leftpanel1.php';?> 


<?php
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
	$q=mysql_query("insert into  " . $prev . "disputes set disput_by='".$_SESSION['user_id']."',claim_proj_id='".$claim_array[0]."',disput_for='".$claim_array[1]."',claim_title='".$_REQUEST['dis_title']."',claim_desc='".$_REQUEST['claim_desc']."',claim_amount='".$_REQUEST['claim_amount']."',round_stat='Y',date=NOW()");
	
	$msg2='Dispute successfully posted.';
	$id=mysql_insert_id();
	
	if($_FILES['attach_file']['name'])
	{
		$pathinfo = pathinfo($_FILES['attach_file']['name'],PATHINFO_EXTENSION);
		$file_name=$id.".".$pathinfo;
		mysql_query("update " . $prev . "disputes set attach_file='".$file_name."' where disput_id='".$id."'");
		move_uploaded_file($_FILES['attach_file']['tmp_name'],$img_folder."/".$file_name);
	}
	}
	else
	{
		$msg2='<p class=red_text>Error. Other person did not replied.</p>';
	}
	$msg3=true;
}

?>

<div class="profile_right">

<div class="edit_profile">
	<h2>New Dispute 
	</h2>
	
	<div align="right" style="padding-right:10px;">
	Balance  :  $ <strong><?php print $balsum;?></strong><br />
	Pending Transactions  :  $ <strong><?php print $sum1;?></strong>
	</div>
	<!--<ul>
	<li ><a href="profile.php">Update Profile</a></li>
	<li ><a href="select-expertise.php">Update Expertise</a></li>
	<li ><a href="upload-portfolio.php">Update Portfoolio</a></li>
	
	
	</ul>-->
	</div>
   
   
    
	
	
<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->
<div class="edit_form_box">

<form action="disputes.php" method="POST" name="_profile" id="_profile" enctype="multipart/form-data" onsubmit="javascript: return ValidateForm(this);">
<table width="651" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
    	<td align="left" valign="top"><img src="images/inner_bx-top.jpg" alt="image" width="651" height="10" /></td>
    </tr>
    <tr>
    	<td align="left" valign="top" class="bx-border">
			<table border="0" cellpadding="10" cellspacing="0" width="100%" >
	    <tr valign="top" class="title">
					<td style="border-bottom:1px solid #A1282C; color:#A1282C;">					
					  <strong>Create Dispute</strong></td>
				  <td align=right valign="middle" style="border-bottom:1px solid #A1282C;">&nbsp;</td>
				</tr>
				
          <?php
		  if($msg3)
		  {
		  ?>
		  <tr class="hilite2">
		    <td colspan="2" align="center" class="h22" height="30"><?php echo $msg2;?></td>
		  </tr>
			<?php
			}
			?>
          <tr class="hilite1">
            <td width="30%"><b>Title of  Dispute: * </b></td>
            <td class="grid">
			<input name="dis_title" type="text" value="" size="38" /></td>
          </tr>
          <tr><td><b>Claim against: * </b></td>
            <td class="grid">
			<select name='claim_user'>
			  <option value="">Select claim Project</option>
			  <?php			 		  	
				if($_SESSION['user_type']=="E" || $_SESSION['user_type']=="B"){
				
				 	$r1=mysql_query("SELECT " . $prev . "buyer_bids.*," . $prev . "projects.project FROM  " . $prev . "buyer_bids," . $prev . "projects WHERE " . $prev . "buyer_bids.project_id=" . $prev . "projects.id and " . $cond . " " . $prev . "projects.status IN ('frozen','close')");					
				    
				    while($d=mysql_fetch_array($r1))
				    {
			           echo"<option value='" .$d[project_id]."|".$d[bidder_id] ."'>" . $d[project] . "</option>\n";
			        }
					
				}else{
				    $r1=mysql_query("SELECT " . $prev . "buyer_bids.*," . $prev . "projects.* FROM  " . $prev . "buyer_bids," . $prev . "projects WHERE " . $prev . "buyer_bids.project_id=" . $prev . "projects.id and " . $cond . " " . $prev . "projects.status IN ('frozen','close')");
					
				    while($d=mysql_fetch_array($r1))
				    {
			           echo"<option value='" .$d[project_id]."|".$d[user_id] ."'>" . $d[project] . "</option>\n";
			        }
				}
			   ?>
               </select>			  </td>
          </tr>
		  
		   <tr class="hilite1">
            <td><b>Claim Description: * </b></td>
            <td class="grid">
              	<textarea name="claim_desc" style="width:340px; height:180px"></textarea>			  </td>
          </tr>
		  <tr>
            <td width="30%"><b>Attachment (if any):  </b></td>
            <td class="grid">
			<input type="file" name="attach_file" size="30" />			</td>
          </tr>
		   <tr class="hilite1">
				<td width="30%"><b>Claim Amount  *</b></td>
				<td class="grid"><?=$setting[currency]?>
				<input name="claim_amount" type="text"  size="20" />				</td>
         	 </tr>
		   <tr >
		     <td colspan="2" height="10"></td>
		     </tr>
		   <tr class="hilite1">
		     <td>&nbsp;</td>
		     <td >
             
             <input type="image" class="submit_bott" src="images/nxt_bt.jpg"  />
			<input type="hidden" name="Submit" value="1">             </td>
		     </tr>
  </table>
  </td>
	</tr>
	
	<tr>
		<td align="left" valign="top" class="inner_bx-bottom">&nbsp;		  </td>
	</tr>
</table>
</form><p>&nbsp;</p>
<!--</div>-->
<div id="process_waiting_dialog" style="display:none; "><br><img src="images/rotating_arrow.gif">&nbsp;&nbsp;Please wait..Saving data in progress</div>

</div>

</div>
</div>


</div>
</div>
</div>
</div>
<?php include 'includes/footer.php';?> 
</body>
</html>