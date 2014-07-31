<?php
$current_page = "<p>Running Jobs</p>";

include "includes/header.php";

CheckLogin();
if($_POST['update_manual_time']==1 && $_POST['project_manual']>0){
if($_POST['project_manual_option']==1){
$upd=mysql_query("update ".$prev."projects set enabled_manual_time='Y' where user_id='".mysql_real_escape_string($_SESSION['user_id'])."' and id='".mysql_real_escape_string($_POST['project_manual'])."'");
}else{
$upd=mysql_query("update ".$prev."projects set enabled_manual_time='N' where user_id='".mysql_real_escape_string($_SESSION['user_id'])."' and id='".mysql_real_escape_string($_POST['project_manual'])."'");
}
if($upd){
$_SESSION['succ']="Update Success";
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


<!-- content-->


<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 

    <!-- left side-->

    <!--middle -->

<div class="profile_right">
   <div id="wrapper_3">
           <? echo getprojecttab(3);?>
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
            <table width="750" border="0" align="center" cellpadding="0" cellspacing="0" >
                  <tr>
                    <td>  

<!----------------------------------------------------------------------------------------------------------->



					<table width="750" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr class="tbl_bg_4">
                        <td width="290" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="54" align="center"><?=$lang['BIDS']?></td>
						
                        <td width="170" align="center"><?=$lang['ACTION']?></td>
						<td width="185" align="center"><?=$lang['POST_DATE']?></td>
<td width="185" align="center">Manual Time</td>
                       </tr>

<?php
$no_of_records=10;

if(!$_REQUEST[page]){$_REQUEST[page]=1;}
$res21=mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status IN ('process') ORDER BY id,date2 DESC");
$total =@mysql_num_rows($res21);

$tinyres = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status IN ('process') ORDER BY id,date2 DESC limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."");

$i=0;

while($kikrow=mysql_fetch_array($tinyres))

{

?>
<tr class="tbl_bg2" >
<?php 

	if(!($i%2)){$bg="#ffffff";}else{$bg="whitesmoke";}

	echo '<td align="left" class="space" style="border-right:none;"><a class="font_bold2" href="'.$vpath.'project/' . $kikrow[id] . '">' . ucwords($kikrow[project]) . '</a></td>';
	?>
	

    <td align="center"><?php echo totalbid($kikrow[id]);?></td>

    

	

	

	<?php 


	echo ' <td >'.$lang['YOU_PICKED'].' <a class="link_class" href="'.$vpath.'publicprofile/' .getusername($kikrow[chosen_id]). '/">' . getusername($kikrow[chosen_id]) . '</a> ('.$lang['CLICK_HERE_PAY'].' <a class="link_class" href="'.$vpath.'milestone.html">' . getusername($kikrow[chosen_id]) . '</a>)</td>';



	?>

	

	

	<td align=center><?php echo date('M d, Y',$kikrow[date2]); ?></td>
<td align=center>
<form action="" name="mtime" method="post">
<input type="hidden" name="update_manual_time" value='1'/>
<input type="hidden" name="project_manual" value="<?php echo $kikrow[id];?>"/>

<input type="checkbox" name="project_manual_option" value="1"  onclick="form.submit()" <?php if($kikrow['enabled_manual_time']=='Y'){?>checked="true"<?php }?> />
</form>
</td>
	

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
{          echo"<div align=right>". new_pagingnew(0,$vpath.'running_jobs/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
}
?>



</td></tr>

</tbody>

</table>



<!----------------------------------------------------------------------------------------------------------->

										

										

<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->			

                </td>

            </tr>

<!------------------------------------------------Middle Body End---------------------------------------------------------->

            </table>

        </div>
	

<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->

 </div>

</div>
</div>

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>