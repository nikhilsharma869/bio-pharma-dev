<?php
$current_page = "<p>Frozen Jobs</p>";
$cur_par_menu = "job_posting";
$cur_child_menu = "expire_project";

include "includes/header.php";
CheckLogin();

?>

<?php

$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION['user_id']."'"));

$type=$row_user['user_type'];
?>

<div class="spage-container">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left">
                <!-- tabs left -->
				 <?php require("includes/left_menu_job_client.php");?>
                <!-- tabs left -->
           </div>
            <!-- Content right -->
            <div class="profile_right">
			
					<div class="heading_right"><?=$lang['FROZEN_PROJECTS']?></div>
					<!-- content data list -->
                
					<?php

					$no_of_records=10;

					if(!$_REQUEST[page]){$_REQUEST[page]=1;}
					
					$res21=mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status IN ('expire') ORDER BY id,date2 DESC");
					$total =@mysql_num_rows($res21);

					$tinyres = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status IN ('expire') ORDER BY id,date2 DESC limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."");


					$i=0;

					while($kikrow=mysql_fetch_array($tinyres))

					{
						$datleft = get_DatLeft_Of_Project($kikrow[id]);

					?>
					
					<div class="rbn3"><?=getfeatureiconmain($kikrow[id])?>
					</div>
				   <div class="search-job-content clearfix">
						<div class="resultinfor">
							<a href="<?=$vpath?>project/<?php print $kikrow[id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$kikrow['project'])))?>.html" > <?php echo ucwords($kikrow['project']);?></a>

							<ul class="search-job-content-minili">
								
								<li><? if($kikrow['project_type']=="F"){?><?=$lang['FXD_PRC']?>: <b><?=$lang[$budget_array1[$kikrow[budget_id]]]?> </b> <? }else{?><?=$lang['HOURLY']?>: <b><?=$curn.$kikrow['budgetmin']." to ".$curn.$kikrow['budgetmax']?> </b><?} ?></li>
								
								<li><?=$lang['POSTED']?>: <b><?php print date('M d, Y',strtotime($kikrow[creation]));?></b>  </li>
								
								<li><?=$lang['ENDS']?>: <b><?=$datleft; ?></b>   </li>
								
								<a  href="<?=$vpath?>project/<?php print $kikrow[id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$kikrow['project'])))?>.html" >
									<li class="bor-right"> <b><?php echo totalbid($kikrow[id]);?></b> <?=$lang['PROPOSALS']?></li>  
								</a>
							</ul>
						</div>
					
						<div class="resultcheckbox">
							<input id="check_user1" type="checkbox" class="css-input" />	
							<label for="check_user1" class="css-label"></label>        
						</div>
					
						<div class="job-des">
								<p class=""><?php if(strlen($kikrow['description'])>250){echo substr($kikrow['description'],0,250).'...';} else {echo $kikrow['description'];} ?></p>
						
								<ul class='skills-section compact-view'  style="padding-left:0px;margin-top:5px;margin-bottom:5px;"><?=$job_skills;?></ul>
						</div>
						<?php 
							$class_stype = set_Color_for_Status($kikrow[status]);
						?>
						<div class="joblist_status <?=$class_stype?>">
							 <?=Ucwords($kikrow[status])?>
						</div>
						<div class="joblist_button_group">
							
						</div>
				
					</div>
						
		
					<?php $i++;} if($total<1){?>

						<div align="center" style="color:#999999; font-size:14px; height:200px; margin:200px;"><?=$lang['NO_RUNNING_PRO']?></div>

					<? }?>

				
					<?
					if($total>$no_of_records){
						echo"<div align=right>". new_pagingnew(0,$vpath.'expire_project/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";  
					}
					?>

						
                </div>
            </div>

    </div>  
</div>

<?php include 'includes/footer.php'; ?>