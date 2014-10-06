<?php 
include "includes/header.php"; 
include("country.php");
?>
<!--accordian-start-->

<script type="text/javascript" src="<?=$vpath?>js/jquery_3.js"></script>
<script src="<?=$vpath?>js/jquery.collapse.js"></script>
<script src="<?=$vpath?>js/jquery.collapse_storage.js"></script>
<script>
jQuery.noConflict();
// Code that uses other library's $ can follow here.
</script>
		
<!--accordian-end-->
<div style="width:100%; float:left; background:#ebebeb;padding-bottom: 60px;">
<div class="main_div2">
<div class="inner-middle"> 
	
   <!--Inbox Left Start-->
	<div class="profile_left" >
		<?php
			$parent = 'find_work';
			$current = 'save_job';
			$current_sub = '';
			get_child_menu($parent, $current, $current_sub);
		?>		
	</div>
	<!--Inbox Left End-->
    
    
    
    
   <!--Inbox right Start-->
   <div class="profile_right" style="margin-top:15px;">
		  
   <?php
	$no_of_records=10;
	
	$query1=" SELECT *,".$prev ."projects.id as job_id,".$prev ."projects.user_id as client_id FROM " . $prev . "job_save 
				
				LEFT JOIN ".$prev ."projects ON " . $prev . "job_save.project_id = ".$prev ."projects.id 	
				
				LEFT JOIN ".$prev ."categories ON " . $prev . "projects.categories = ".$prev ."categories.cat_id 
				
				LEFT JOIN ".$prev ."projects_cats ON " . $prev . "projects.id = ".$prev ."projects_cats.id 
				
				LEFT JOIN ".$prev ."skill_linkedin ON " . $prev . "projects_cats.cat_id = ".$prev ."skill_linkedin.id 
				
				GROUP BY ". $prev . "projects.id  ORDER BY " . $prev . "projects.date2 desc
				";
	
	if($_REQUEST['page']){
		$page=$_REQUEST['page'];
	}else{
		$page=0;
	}
	
	$parr=array();
	$parr=paging_new($query1,$no_of_records,$page);
	
	$limitvalue  = $parr[1];
	$total_pages = $parr[2]+1;
	$total_item  = $parr[3];
	
	$query1 .= " LIMIT $limitvalue, $no_of_records";
	
	$result=mysql_query($query1);
	
	?>
	
	
   
   <div class="latest_worbox" id="member_right_box">
   <?php
   if($total_item > 0)
	{
	while($row=@mysql_fetch_array($result))
	{

			
		
			//////////////////////////////////////////// select bids //////////////////////////////////////////////////

			$select_bids="select " . $prev . "buyer_bids.*," . $prev . "projects.* from " . $prev . "buyer_bids," . $prev . "projects where " . $prev . "buyer_bids.project_id=" . $prev . "projects.id and " . $prev . "buyer_bids.project_id='".$row[job_id]."'";


			$rec_bids=mysql_query($select_bids);

			$num_bids=mysql_num_rows($rec_bids);

				
			//////////////////////////////////////////// select bids //////////////////////////////////////////////////	

		
			$skills = get_list_skill_by_job_id($row[job_id]);
			$job_skills = "";
			foreach($skills as $skill){
				// $job_skills .=  "<span id='skill'>".$skill['skill_name']."</span>";
					
				$job_skills .= "	<li class='endorse-item'>";
				$job_skills .= "	<div>";
				$job_skills .= "	<span class='skill-pill'>";
				$job_skills .= "	<span class='endorse-item-name '>";
				$job_skills .= "	<a href='".$vpath."jobs/1/0/".$skill['skill_id']."/".$skill['url_skill']."/".$project_type.$min.$max."All/".$fe."'";
				$job_skills .= "    class='endorse-item-name-text'>".$skill['skill_name']."</a>";
				$job_skills .= "	</span>";
				$job_skills .= "	</span>";
				$job_skills .= "	</div>";
				$job_skills .= "	</li>";
			}
			
						 $totalbid=totalbid($row[job_id]);

						 $avaragebid=avaragebid($row[job_id]);

						 $avaragebid=ceil($avaragebid);

						 if($avaragebid!=0)
						 {
						 	$avgbids=$setting[currency].'&nbsp;'.$avaragebid;
						 }
						else
						{
							$avgbids='-';
						}	

	
						if($row[special]== "featured")
						{
							$fjobs='<img src="'.$vpath.'images/featured.png"  style=" position:absolute; padding-left:2px;" />';
						}
						else
						{
							$fjobs="&nbsp;";
						}
	
					$datleft = get_DatLeft_Of_Project($row[job_id]);

	?>   
			<div class="rbn3"><?=getfeatureiconmain($row[job_id])?>
			</div>
		   <div class="search-job-content clearfix">
				<div class="resultinfor">
					<a href="<?=$vpath?>project/<?php print $row[job_id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$row['project'])))?>.html" > <?php echo ucwords($row['project']);?></a>
					
					<ul class="search-job-content-minili">
						
						<li><? if($row['project_type']=="F"){?><?=$lang['FXD_PRC']?>: <b><?=$lang[$budget_array1[$row[budget_id]]]?> </b> <? }else{?><?=$lang['HOURLY']?>: <b><?=$curn.$row['budgetmin']." to ".$curn.$row['budgetmax']?> </b><?} ?></li>
						
						<li><?=$lang['POSTED']?>: <b><?php print date('M d, Y',strtotime($row[creation]));?></b>  </li>
						
						<li><?=$lang['ENDS']?>: <b><?=$datleft; ?></b>   </li>
						
						<a  href="<?=$vpath?>project/<?php print $row[job_id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$row['project'])))?>.html" >
							<li class="bor-right"> <b><?php echo $num_bids;?></b> <?=$lang['PROPOSALS']?></li>  
						</a>
					</ul>
				</div>
			
				<div class="resultcheckbox">
					<input id="check_user1" type="checkbox" class="css-input" />	
					<label for="check_user1" class="css-label"></label>        
				</div>
			
				<div class="job-des">
						<p class=""><?php if(strlen($row['description'])>250){echo substr($row['description'],0,250).'...';} else {echo $row['description'];} ?></p>
					<!--	Category : <b><?=$row['cat_name']?></li>-->
						<ul class='skills-section compact-view'  style="padding-left:0px;margin-top:5px;margin-bottom:5px;"><?=$job_skills;?></ul>
				</div>

				<div class="client-inforss">
					<?php
					
						$clients_info = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id=".$row[client_id]));
						if(!empty($clients_info[logo])) {
							$temp_logo=$clients_info[logo];
						} else {
							$temp_logo="images/face_icon.gif";
						} ?>
						<a href="<?=$vpath;?>publicprofile/<?=$clients_info[username]?>/" > <img src="<?=$vpath?>viewimage.php?img=<?php echo $temp_logo;?>&amp;width=60&amp;height=60" /></a>
						<p class="client-name"><?php echo $clients_info[fname].' '.$clients_info[lname]; ?></p>
						<p>
							<span><img src="<?=$vpath?>cuntry_flag/<?=strtolower($clients_info['country']);?>.png" title="<?=$country_array[$clients_info[country]];?>" width="16" height="11" > <?=$country_array[$clients_info[country]];?></span>
							<span>$0 Spent</span>
							<span><?= getrating($row[client_id]) ?></span>
						</p>
				</div>
		   </div>     
			 
   <?php

			$pa++;

		 }

	}
	else	
	{	
	?> 
		<div align="center" style="color:#999999; font-size:14px; height:200px; margin:200px;"><?=$lang['NO_PRODUCT_FOUND']?></div>
	<?php	
	}
	?>	
	
	<?php	
		if($total_item > $no_of_records)
		{

			if($_REQUEST['skill_id']){
					
				if($cat_id != 0){
					$param .= $cat_id."/";
				}else{
					$param .= "0/";
				}
				$url_skill = $skill['url_skill'];
				$param .= $_REQUEST['skill_id']."/".replacename($url_skill)."/";
			}else{
				$cat="0/0/All/";
			}
				
			if($_GET['projectStatus']){
				$param.=$_GET['projectStatus']."/";
			}else{
				$param.="open/";
			}
			if($_REQUEST['budget_min']>0){
				$param.=$_REQUEST['budget_min']."/";
			}else{
				$param.="0/";
			}
			if($_REQUEST['budget_max']>0){
				$param.=$_REQUEST['budget_max']."/";
			}else{
				$param.="0/";
			}
			if($_REQUEST['keyword']!=''){
				$param.=$_REQUEST['keyword']."/";
			}else{
				$param.="Search/";
			}
			if($_GET['featured_jobs']!=''){
				$param.=$_GET['featured_jobs']."/";
			}
			  
	
			echo "<div align=right>" .new_pagingnew(5,$vpath.'Jobs/','/'.$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='') . "</div>";
		}
	 ?>
 
		</div>
		<!--Inbox  right End-->
	</div>
		

	 <div style="clear:both; height:10px;"></div>
	 <script type="text/javascript">
		$(document).ready(function(){
			$("#sonu").removeAttr("style");
		});
	 </script>
	 <style>
	 .live-pro-list li a.active{
	 font-weight:bold;
	 }
	 </style>
	 
	<link href="<?=$vpath?>js/perfect-scrollbar.css" rel="stylesheet">
	<script src="<?=$vpath?>js/jquery.mousewheel.js"></script>
	<script src="<?=$vpath?>js/perfect-scrollbar.js"></script>
	<style>
	  #description {
		
		height:200px;
		width: 230px;
		overflow: hidden;
	 /*   position: absolute;*/
	 overflow:auto;
	  }
	</style>
	<style>

	p.mar-top a {
	font-size: 12px;
	line-height: 9.5px;
	padding: 4px 10px;
	}

	</style>
	<script type="text/javascript">
	  jQuery(document).ready(function ($) {
		$('#description').perfectScrollbar({
		  wheelSpeed: 20,
		  wheelPropagation: false
		});

		$('span.save-job-btn').click(function(){
			var id = $(this).data('save');
			var user_id = $(this).data('user');
			$.ajax({
			   url: '<?= $vpath; ?>ajax_action.php',
			   data: {action: 'save_job', user_id: user_id, project_id: id},
			   success: function(data) {
			      alert(data);
			   }
			});
		})
	  });
	</script>


<?php include 'includes/footer.php';?> 