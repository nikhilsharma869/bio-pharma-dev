<?php
$current_page = "<p>Running Jobs</p>";

include "includes/header.php";

CheckLogin();

if(isset($_POST['msubmit']) && $_POST['msubmit']!=''){

	 $checkrow=mysql_query("select id from ".$prev."projects where chosen_id='".$_SESSION['user_id']."' and id='".mysql_real_escape_string($_POST['addproject_id'])."'");
$rty=@mysql_num_rows($checkrow);
	if($rty==1){

	mysql_query("insert into ".$prev."project_tracker set project_id='".mysql_real_escape_string($_POST['addproject_id'])."',worker_id='".mysql_real_escape_string($_SESSION['user_id'])."',start_time='".mysql_real_escape_string($_POST['sdate'])."',stop_time='".mysql_real_escape_string($_POST['edate'])."',status='1',time_added_by='M'")or die(mysql_error());
		$inds=mysql_insert_id();
			if($inds){
mysql_query("insert into ".$prev."project_tracker_snap set project_tracker_id='".$inds."',project_work_snap_time='".mysql_real_escape_string($_POST['sdate'])."'");
mysql_query("insert into ".$prev."project_tracker_snap set project_tracker_id='".$inds."',project_work_snap_time='".mysql_real_escape_string($_POST['edate'])."'");
				$_SESSION['succ']="Update Success";


			}
	}else{
	$_SESSION['error']="Error in update";
	}
}
?>
<!-----------Header End-----------------------------> 
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['WORKING_PROJECTS']?></a></p></div>
<div class="clear"></div>

<?php

$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION['user_id']."'"));

$type=$row_user['user_type'];
?>
<script>
function setdatetime(id){
$("#setdivtime_"+id).slideDown('slow');

}
</script>
<link rel="stylesheet" href="<?=$vpath?>jquery/jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
<link rel="stylesheet" media="all" type="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery-ui-timepicker-addon.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>


	<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery-ui.min.js"></script>

<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery-ui-timepicker-addon.js"></script>
<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery-ui-sliderAccess.js"></script>

	<script>

	$(function() {

		$( ".sdate" ).datetimepicker({

	dateFormat: "yy-mm-dd",		
timeFormat: "hh:mm:ss",
addSliderAccess: true,
	sliderAccessArgs: { touchonly: false }
			

		});

$( ".edate" ).datetimepicker({

	dateFormat: "yy-mm-dd",		
timeFormat: "hh:mm:ss",
addSliderAccess: true,
	sliderAccessArgs: { touchonly: false }
			

		});


	});

	

	</script>
<!-- content-->


<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 

    <!-- left side-->

    <!--middle -->

<div class="profile_right">
   <div id="wrapper_3">
           <? echo getprojecttab(7,'1');?>
<div style="width: 743px;float:left">
            <?php
            if ($_SESSION['error']!= "") {
                include('includes/err.php');
                unset($_SESSION['error']);
                unset($_SESSION['succ']);
            }
            if ($_SESSION['succ']!= "") {
                include('includes/succ.php');
                unset($_SESSION['error']);
                unset($_SESSION['succ']);
            }
            ?>
</div>
			 <div class="browse_tab-content"> 
            	<div class="browse_job_middle">
        

					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr class="tbl_bg_4">
                        <td width="200" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="150" align="center"><?=$lang['POSTER_BY']?></td>
			<td width="150" align="center"><?=$lang['POST_DATE']?></td>
                         <td width="150" align="center">Manual Time</td>
                       </tr>

<?php
$no_of_records=10;

if(!$_REQUEST[page]){$_REQUEST[page]=1;}
$res21=mysql_query("SELECT * FROM " . $prev . "projects WHERE chosen_id='" . $_SESSION[user_id] . "' and status IN ('process') ORDER BY id,date2 DESC");
$total =@mysql_num_rows($res21);

$tinyres = mysql_query("SELECT * FROM " . $prev . "projects WHERE chosen_id='" . $_SESSION[user_id] . "' and status IN ('process') ORDER BY id,date2 DESC limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."");

$i=0;

while($kikrow=mysql_fetch_array($tinyres))

{
$user=getuserdetl($kikrow['user_id'],"fname,lname,username");
?>
<tr class="tbl_bg2" >
<?php 

	if(!($i%2)){$bg="#ffffff";}else{$bg="whitesmoke";}

	echo '<td align="left" class="space" style="border-right:none;"><a class="font_bold2" href="'.$vpath.'project/' . $kikrow[id] . '">' . ucwords($kikrow[project]) . '</a></td>';
	?>
	

    <td align="center"><a href="<?=$vpath?>publicprofile/<?=$user['username']?>/"><?php 
	echo $user['fname']." ".$user['lname']; 
	?></a></td>

	<td align=center><?php echo date('M d, Y',$kikrow[date2]); ?></td>

	<td align=center><?php 

$av=@mysql_num_rows(mysql_query("select id from ".$prev."projects where id='".$kikrow['id']."' and enabled_manual_time='Y'"));
if($av>0){?><a href="javascript:void(0)" onclick="setdatetime('<?=$kikrow['id']?>')"  class="submit_bottnew" style="float:none">Add</a><?php }?></td>

</tr>
<?
if($av>0){
?>
<tr><td style="display:none" id="setdivtime_<?=$kikrow['id']?>" colspan="4">
<form action="" method="post" name="adddate">
<input type="hidden" name="addproject_id" value="<?=$kikrow['id']?>"/>
<div align="center" style="color:#000"><div style="float:left;width:40%">Start Time:<input type="text" name="sdate" id="sdate" value="" readonly="true" class="from_input_box sdate" style="float: none;width:auto"/></div>
<div style="float:left;width:40%">End Time:<input type="text" name="edate" value="" readonly="true" id="edate" class="from_input_box edate" style="float: none;width:auto"/></div>
<div style="float:left;width:10%"><input type="submit" name="msubmit" value="Submit" class="submit_bott" style=" margin: 5px;"/></div>
</div>
</form>
</td></tr>
<? 
}
?>
<?php 

	$i++;	

} 

if($total<1)
{?>

<tr class="tbl_bg2" >

	 <td colspan="6" align="center"><strong><?=$lang['NO_RUNNING_PRO']?></strong></td>

	</tr>
	<? }?>

<tr><td colspan="6">
<?
if($total>$no_of_records)
{          echo"<div align=right>". new_pagingnew(0,$vpath.'working_jobs/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
}
?>



</td></tr>

</tbody>

</table>



        </div>
	

<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->

 </div>

</div>
</div>

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>