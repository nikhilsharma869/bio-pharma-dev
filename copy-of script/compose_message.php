<?php 
$current_page = "<p>Mailbox</p>";
include "includes/header.php"; 
CheckLogin();
	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
	$res2=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
	$row2=mysql_fetch_array($res2);
	$res4=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
	$row3=mysql_fetch_array($res4);
	$res_users=mysql_query("select * from ".$prev."user");

	if($_POST['rep']=="Send Message")
	{
	//echo "select user_id,username,email,fname,lname from ".$prev."user where user_id='".$_POST['to']."'";
	$row_user_details=mysql_query("select user_id,username,email,fname,lname from ".$prev."user where user_id='".$_POST['to']."'");
	$res_user_details=mysql_fetch_array($row_user_details);

			$stringword = $_POST['txt'];
			$banned_words = explode(',',$setting[bad_words]);
			$err=0;
			$c_banned_words=count($banned_words);
			for($i=0;$i<$c_banned_words;$i++)
			{
				if(substr_count($stringword,$banned_words[$i]))
				{
					$err++;
					break;
				}
			}
			if($err!=0)
				{
					$_SESSION['error']="String contains some banned words.";
				}

	if($row2['status']=='Y')
	{
		$status='Y';
	}
	else
	{
		$status='N';
	}
	if($err==0)
	{
	$sndr = mysql_fetch_array(mysql_query("select email from ".$prev."user where user_id='".$_SESSION['user_id']."'"));
	if(mysql_query("insert into ".$prev."messages set
	receiver='".$res_user_details['user_id']."',
	sender_id='".$_SESSION['user_id']."',
	sender='".$sndr['email']."',
	subject='".$_POST['subject']."',
	message='".$_POST['txt']."',
	user_type='sender',
	sent_time=now(),
	status='".$status."',
	message_type='A',
	read_status='N',
	view_user='U'
	")){
			$to=$res_user_details['email'];
			$subject=$_POST['subject'];
			$message=$_POST['txt'];
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: '.$sndr["email"].' <'.$sndr["email"].'>' . "\r\n";

			mail($to, $subject, $message, $headers);

	mysql_query("insert into ".$prev."messages set
	receiver='".$res_user_details['user_id']."',
	sender_id='".$_SESSION['user_id']."',
	sender='".$sndr['email']."',
	subject='".$_POST['subject']."',
	message='".$_POST['txt']."',
	user_type='reciver',
	sent_time=now(),
	status='".$status."',
	message_type='A',
	read_status='N',
	view_user='U'
	");

		$message="You have sent a message to ".ucwords($res_user_details['fname'])." ".ucwords($res_user_details['lname'])."&nbsp;";
		$message1=base64_encode($message);
		$_SESSION['succ']=$message;
		
		//header("location:compose_message.php?sucs=success&message=$message1");	
	}
	}
	}


$inbox_data="select * from  ".$prev."messages where receiver='".$_SESSION['user_id']."' and sender_id!='".$_SESSION['user_id']."' and status='Y' and user_type='reciver' and read_status='N'";
$rec_date=mysql_query($inbox_data);
$num_date=mysql_num_rows($rec_date);
//echo $_SESSION['succ'];
?>


<script type="text/javascript" src="<?=$vpath?>js/autocomplete.jquery.js"></script>
<script type="text/javascript" src="<?=$vpath?>js/jquery.autocomplete.js"></script>
<link rel="stylesheet" href="<?=$vpath?>css/jquery.autocomplete.css" type="text/css" />

<script type="text/javascript">
function findValue(li) {
	if( li == null ) return alert("No match!");
	if( !!li.extra ) var sValue = li.extra[0];
	else var sValue = li.selectValue;
}


function selectItem(li) {
	findValue(li);
}

function formatItem(row) {
	return row[0] + " (id: " + row[1] + ")";
}

function lookupAjax(){
	var oSuggest = $("#CityAjax")[0].autocompleter;
	oSuggest.findValue();
	return false;
}

function lookupLocal(){
	var oSuggest = $("#CityLocal")[0].autocompleter;
	oSuggest.findValue();
	return false;
}

$(document).ready(function() {
	$("#CityAjax").autocomplete(
		"autocomplete_ajax.cfm",
		{
			delay:10,
			minChars:2,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			onFindValue:findValue,
			formatItem:formatItem,
			autoFill:true
		}
	);

	$("#CityLocal").autocompleteArray(
		[
		<?php 
		while($row_users=mysql_fetch_array($res_users))
		{
		echo '"'.$row_users[username].'",';	
		}?>
		],
		{
			delay:10,
			minChars:1,
			matchSubset:1,
			onItemSelect:selectItem,
			onFindValue:findValue,
			autoFill:true,
			maxItemsToShow:4
		}
	);
});
</script>


<script>

function check()
{
	if(document.frm.to.value=="")
	{
		alert("Select Any Username");
		document.frm.to.focus();
		return false;	
	}
	if(document.frm.subject.value=="")
	{
		alert("Enter a Subject");
		document.frm.subject.focus();
		return false;	
	}
	if(document.frm.txt.value=="")
	{
		alert("Enter a reply message");
		document.frm.txt.focus();
		return false;
	}
	return true;
}

</script>




<div class="browse_contract">
  <!--Profile-->
  <?php include 'includes/leftpanel1.php';?>
  <!-- left side-->
  <!--middle -->
    <div class="profile_right">
  <form action="" method="post" name="frm" id="frm" onsubmit="return check();">
    <div class="create_profile">
        <? include("includes/message_header.php");?>
    </div>
	
	<div class="inbox_right_text1">
      <div class="inbox_text_link">
	  	<input type="submit" name="rep" value="Send Message" class="whit" id="mc_ctrl_delete" />
      </div>
    </div>
	
	
 	<div class="create_profile2">
      <table width="100%" border="0" cellspacing="0" cellpadding="10" class="table_class">
	  			<tr><td colspan="2">
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
				</td></tr>
				<tr>
                <td><strong> To:</strong>
                    <input type="hidden" name="id_con" value="<?php echo base64_decode($_GET['id']);?>" />
                
                </td>
				<td ><select name="to" id="to" class="from_input_box"  style="width:395px;">
				<?php
					if($row2[user_type]=="E") 
					{ 
					?>
								
								  <option value="">Username</option>
								  <?php
						//$equery="SELECT distinct(u.user_id),u.username FROM ".$prev."user u inner join ".$prev."projects p on u.user_id=p.chosen_id inner join ".$prev."buyer_bids b on p.id=b.project_id where p.user_id='".$_SESSION['user_id']."' and p.status!='expired' and p.status!='cancelled'";
						$equery="SELECT distinct(u.user_id),u.username FROM ".$prev."projects p inner join ".$prev."buyer_bids b on p.id=b.project_id inner join ".$prev."user u on u.user_id=b.bidder_id where p.user_id='".$_SESSION['user_id']."' and p.status!='expired' and p.status!='cancelled'";
						//echo $equery;
						$resequery=mysql_query($equery);
						$eno=@mysql_num_rows($resequery);
						if($eno>0)
							{
								while($erow=mysql_fetch_array($resequery))
									{
									?>
								  <option value="<?php echo $erow['user_id']; ?>"><?php echo $erow['username'];?></option>
								  <?php
									}
							}
							?>
								
								<?php		
					}
					else if($row2[user_type]=="W")
					{ ?>
								
								  <option value="">Username</option>
								  <?php
						$wquery="SELECT distinct(u.user_id),u.username FROM ".$prev."user u inner join ".$prev."projects p on u.user_id=p.user_id inner join ".$prev."buyer_bids b on p.id=b.project_id where bidder_id='".$_SESSION['user_id']."'";
						//echo $wquery;
						$reswquery=mysql_query($wquery);
						$no=@mysql_num_rows($reswquery);
						if($no>0)
							{
								while($wrow=mysql_fetch_array($reswquery))
									{
									?>
								  <option value="<?php echo $wrow['user_id']; ?>"><?php echo $wrow['username'];?></option>
								  <?php
									}
							}
							?>
								
								<?php
					}
					else
					{
					?>
								
								<option value="">Username</option>
								<?php
						$equery="SELECT distinct(u.user_id),u.username FROM ".$prev."projects p inner join ".$prev."buyer_bids b on p.id=b.project_id inner join ".$prev."user u on u.user_id=b.bidder_id where p.user_id='".$_SESSION['user_id']."' and p.status!='expired' and p.status!='cancelled'";
						$resequery=mysql_query($equery);
						$eno=@mysql_num_rows($resequery);
						
						$wquery="SELECT distinct(u.user_id),u.username FROM ".$prev."user u inner join ".$prev."projects p on u.user_id=p.user_id inner join ".$prev."buyer_bids b on p.id=b.project_id where bidder_id='".$_SESSION['user_id']."'";
						$reswquery=mysql_query($wquery);
						$no=@mysql_num_rows($reswquery);
						if($no>0 || $eno>0)
						{
							while($erow=mysql_fetch_array($resequery))
									{
									?>
								<option value="<?php echo $erow['user_id']; ?>"><?php echo $erow['username'];?></option>
								<?php
									$euser_id=$erow['user_id'].',';
									}
									
							while($wrow=mysql_fetch_array($reswquery))
									{
										$eusers=explode($euser_id,',');
										if(!in_array($wrow['user_id'],$eusers))
										{
									?>
								<option value="<?php echo $wrow['user_id']; ?>"><?php echo $wrow['username'];?></option>
								<?php
										}
									}
						}
						?>
						
						<?php
						
					}
					?></select>
				</td>
				</tr>
                
                <tr>
                  <td><strong>Subject:</strong></td>
                  <td ><input type="text" autocomplete="off" name="subject" class="from_input_box">
				  <input type="hidden" name="id_con" value="<?php echo base64_decode($_GET['id']);?>"></td>
                </tr>

                <tr>
                  <td><strong>Message:</strong></td>
                  <td><textarea name="txt" rows="10" cols="20" class="text_box"></textarea></td>
                </tr>
		</table>
	</div>
	
 </form>
         
  </div>
  
</div>
<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>