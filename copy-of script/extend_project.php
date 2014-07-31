<?php
$current_page = "<p>Running Jobs</p>";

include "includes/header.php";

CheckLogin();

?>
<!-----------Header End-----------------------------> 
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['EXTEND_PROJ']?></a></p></div>
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
           <? echo getprojecttab(0);?>
			 <div class="browse_tab-content"> 
            	<div class="browse_job_middle create_profile2">
				<?
				if($_POST['submit']==$lang['EXTEND']){
				$ii = mysql_result(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" .$_REQUEST[extend] . "'"),0,"expires")+ (14 * 86400);	
				if($ii>(time() + 14 * 86400)):	
						$_SESSION['error']=$lang['PROJ_EXT_CANT']. "14". $lang['DAYS_SORRY'];
						include('includes/err.php');
						unset($_SESSION['error']);
						else:
						mysql_query("UPDATE " . $prev . "projects SET expires=". $ii ." WHERE id='" . $_REQUEST[extend] . "'");
						$_SESSION['succ']=$lang['PROJ_XTND'] . "14" .$lang['DAYS'];
						include('includes/succ.php');
						unset($_SESSION['succ']);
						echo '<tr class=link_class><td class=link_class><br>

						<a href="'.$vpath.'active_jobs.html" class="link_class">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a>';
						endif;
				}
				?>
            <table width="97%" border="0" align="center" cellpadding="5" cellspacing="0" class="table_class">
                  <tr>
                    <td >  

						<form method="POST" action="">
						<input type="hidden" name="manage" value="2">
						<input type="hidden" name="extend" value="<?=$_REQUEST[extend]?>">
						<div class="tdclass" style="padding-top: 10px;"><b><?=$lang['PROJ_EXT']?></b></div>
						<input type="text" name="cdays" value="14" maxlength="3" size="3" class="from_input_box1" readonly><div style="padding-top: 10px;">
						days (max 14)</div>
						<br >
						<div>
						<br >
						<br >
						<input align="right" type="submit" class="submit_bott" value="<?=$lang['EXTEND']?>" name="submit"></div></form>
						

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