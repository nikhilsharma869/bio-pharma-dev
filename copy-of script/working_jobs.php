<?php
$current_page = "<p>Running Jobs</p>";

include "includes/header.php";

CheckLogin();

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


<!-- content-->


<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 

    <!-- left side-->

    <!--middle -->

<div class="profile_right">
   <div id="wrapper_3">
           <? echo getprojecttab(7,'1');?>
			 <div class="browse_tab-content"> 
            	<div class="browse_job_middle">
        

					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr class="tbl_bg_4">
                        <td width="200" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="150" align="center"><?=$lang['POSTER_BY']?></td>
						
						<td width="150" align="center"><?=$lang['POST_DATE']?></td>
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

	

</tr>

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