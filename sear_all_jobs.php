<?php
$current_page="Search Jobs"; 
include "includes/header.php"; 
include("country.php");
$row_settings=@mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));


if(isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput']!="")
{
	if($_REQUEST['categoryinput']!=0)
	{
		$categoryinput=$_REQUEST['categoryinput'];
		header("location:index.php?cat_id=$categoryinput&categoryform#");
	}
	else
	{
		$categoryinput=$_REQUEST['categoryinput'];
		header("location:index.php?categoryform#");
	}	
}


if($_REQUEST['cat_id']==''){
	$cat_id = 0;
}

if(!$_REQUEST['budget_min']){
$_REQUEST['budget_min']=0;
}if(!$_REQUEST['budget_max']){
$_REQUEST['budget_max']=0;
}
$p_name=$_REQUEST['keyword'];	

$p_cat=$_GET['cat_id'];

$p_status=$_GET['projectStatus'];

$budget_min=$_REQUEST['budget_min'];

$budget_max=$_REQUEST['budget_max'];

?>

<link type="text/css" rel="stylesheet" href="css/searchPage_15042012.css">
<link rel="stylesheet" href="<?= $vpath; ?>/jplugins/jslider/css/jslider.css" type="text/css">
<link rel="stylesheet" href="<?= $vpath; ?>/jplugins/jslider/css/jslider.blue.css" type="text/css">
<link rel="stylesheet" href="<?= $vpath; ?>/jplugins/jslider/css/jslider.plastic.css" type="text/css">
<link rel="stylesheet" href="<?= $vpath; ?>/jplugins/jslider/css/jslider.round.css" type="text/css">
<link rel="stylesheet" href="<?= $vpath; ?>/jplugins/jslider/css/jslider.round.plastic.css" type="text/css">

<script language="JavaScript" src="js/search_framework.js" type="text/javascript"></script>
<script type="text/javascript" src="<?= $vpath; ?>/jplugins/jslider/js/jshashtable-2.1_src.js"></script>
<script type="text/javascript" src="<?= $vpath; ?>/jplugins/jslider/js/jquery.numberformatter-1.2.3.js"></script>
<script type="text/javascript" src="<?= $vpath; ?>/jplugins/jslider/js/tmpl.js"></script>
<script type="text/javascript" src="<?= $vpath; ?>/jplugins/jslider/js/jquery.dependClass-0.1.js"></script>
<script type="text/javascript" src="<?= $vpath; ?>/jplugins/jslider/js/draggable-0.1.js"></script>
<script type="text/javascript" src="<?= $vpath; ?>/jplugins/jslider/js/jquery.slider.js"></script>


<script>

function get_posted_within(val){
 	document.postedwithin.action = val;
	document.postedwithin.submit();	
}

function get_country(val)
{
 	document.countryform.action = val;
	document.countryform.submit();		
}

function getprojecttypess(val)
{
 	document.projecttypess.action = val;
	document.projecttypess.submit();
	// alert(document.projecttypess.action);
}

function getProjectsByBudget(val) {
	var range = val.split(";");
	$('#budget_min').val(range[0]);
	$('#budget_max').val(range[1]);
	document.budgets_select.submit();
	// console.log(range);
}
$(document).ready(function(){
	var budget_min = $('#budget_min').val();
	// console.log(budget_min);
	var budget_max = $('#budget_max').val();
	// console.log(budget_max);
	var budget_range_config = {
		from: 0,
		to: 10000,
		scale: ['|', '|', '|', '|', '|', '|', '|', '|', '|', '|', '|'],
		limits: false,
		step: 100,
		before_n: '$&nbsp;',
		skin: "plastic",
		callback: function( value ){
	    	getProjectsByBudget(value);
	  	}
	};

	$('#budget_range').slider(budget_range_config);
	$('#budget_range').slider("value", budget_min, budget_max)
});
</script>
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

	<!--	Breadcums-->
	<div class="page_headding">
		<div class="dash_headding">
			<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0)" class="selected"><?=$lang['FIND_JOBB']?></a></p>
		</div>
	<!--	Breadcums-->
	<!--Search Bar -->
	<div class="search-area find-sme clear-fix">
		<form action="<?=$vpath?>sear_all_jobs.html" method="POST" name="home-search" >
			<input type="text" placeholder="Search Categories" class="input_txtbox" name="keyword">
			<div class="drop_pseudo"><?=$lang['PROJECT_NAME']?></div>       
			<select name="select2" class="input_drop" name="" onChange="this.form.action=this.options[this.selectedIndex].value;">
				<option value="browse-freelancers.php" <?php if(isset($_POST['select2']) && $_POST['select2'] == 'browse-freelancers.php') echo 'selected="selected"';?>><?=$lang['FIND_TALENT']?></option>
				<option value="sear_all_jobs.php" <?php if(isset($_POST['select2']) && $_POST['select2'] == 'sear_all_jobs.php') echo 'selected="selected"';?>><?=$lang['PROJECT_NAME']?></option>
			</select>
			<input type="submit" class="btn-home-search" name="">
		</form>
	</div>
	<!--Search Bar -->
	</div>
	
	<div class="clear"></div>

	<form name="postedwithin" id="postedwithin" action="" method="post">
	</form>
	
   <!--Inbox Left Start-->
	<div class="profile_left" >
		<div id="open-by-default-example">
								
			<?
				if($_REQUEST['skill_id']){
					
					if($cat_id != 0){
						$cat=$cat_id."/";
					}else{
						$cat="0/";
					}
					
					$skill = get_skill_by_id($_REQUEST['skill_id']);
					$url_skill = $skill['url_skill'];
					$cat .= $_REQUEST['skill_id']."/".replacename($url_skill)."/";
				
					$cat .= $_REQUEST['skill_id']."/".replacename($url_skill)."/";
				
				}else{
					$cat="0/0/All/";
				}
				
				if($_GET['project_type']!=''){
					$project_type=$_GET['project_type']."/";
				}else{
					$project_type="All/";
				}
				
				if($_REQUEST['budget_min']!='' && $_REQUEST['budget_min']!='0'){
					$min=$_GET['budget_min']."/";
				}else{
					$min="0/";
				}
				if($_REQUEST['budget_max']!='' && $_REQUEST['budget_max']!='0'){
					$max=$_REQUEST['budget_max']."/";
				}else{
					$max="0/";
				}
				if($_REQUEST['posted_time']!='' && $_REQUEST['posted_time']!='All'){
					$sr=$_REQUEST['posted_time']."/";
				}else{
					$sr="All/";
				}
				if($_REQUEST['country']!='' && $_REQUEST['country']!='0'){
					$fe=$_REQUEST['country']."/";
				}else{
					$fe="0/";
				}
				
			?>
			<div class="cat-listp ca-job">
			<h3 class='open'><?=$lang['PROJECT_TYPE']?> </h3>
			<form name="projecttypess" id="projecttypess" action="" method="post">
			
				<ul class="live-pro-list clearfix">
							
					<li>
						<input name="check_hour" id="check_hourall" type="radio" value="" onclick="getprojecttypess('/jobs/1/<?=$cat."All/".$min.$max.$sr.$fe?>')" <? if($_REQUEST[project_type]=="All"){?> checked=checked <? }?>>
						<label for="check_hourall" class="css-label"><?=$lang['RIG1']?></label>
					</li>							
					<li>
						<input name="check_hour" id="check_hourh" type="radio" value="" onclick="getprojecttypess('<?=$vpath?>jobs/1/<?=$cat."H/".$min.$max.$sr.$fe?>')" <? if($_REQUEST[project_type]=="H"){?> checked=checked <? }?>>
						<label for="check_hourh" class="css-label"><?=$lang['HOURLY']?></label>
					</li>			
					<li>
						<input name="check_hour" id="check_hourf" type="radio" value='' onclick="getprojecttypess('<?=$vpath?>jobs/1/<?=$cat."F/".$min.$max.$sr.$fe?>')" <? if($_REQUEST[project_type]=="F"){?> checked=checked <? }?>>
						<label for="check_hourf" class="css-label"><?=$lang['FIXED']?></label>
					</li>							

				</ul>
				
			</form>
			</div>	
			
			<div class="cat-listp ca-job budget_range">		
				<h3 class='open'><?=$lang['BUDGETT']?> </h3>
				<ul class="live-pro-list clearfix">
					<li>
						<form id="budgets_select" name="budgets_select" action="" method="post">
							<input id="budget_range" type="slider" name="budget" value="0;10000" style="display: none;">
							<input type="hidden" name="budget_min" id="budget_min" value="<?=$_REQUEST[budget_min]?>">
							<input type="hidden" name="budget_max" id="budget_max" value="<?=$_REQUEST[budget_max]?>">
							<input type="hidden" name="cat_id" value="<?=$_REQUEST[cat_id]?>">	
							<input type="hidden" name="posted_time" value="<?=$_REQUEST[posted_time]?>">	
							<input type="hidden" name="country" value="<?=$_REQUEST[country]?>">
							<input type="hidden" name="skill_id" value="<?=$_REQUEST[skill_id]?>">
						</form>
					</li>
				</ul>
			</div>
		
			<div class="cat-listp ca-job">
				<h3 class='open'><?=$lang['COUNTRY']?></h3>
				<ul class="live-pro-list clearfix"  id="">
					<li>
						<form name="countryform" id="countryform" action="" method="post">
				 
						<div class="select-box"> 
							<select name="country" class="selectyze2" onchange="get_country(this.value)">
								<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max.$sr."0/"?>'><?=$lang['RIG1']?></option>		
									<?php
										$arr=array_keys($country_array);
										for($i=0;$i<count($arr);$i++):
									?>
										<option value="<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max.$sr.$arr[$i]?>/" <? if($_REQUEST[country]==$arr[$i]){?> selected=selected <? }?>><?=$country_array[$arr[$i]]?></option>
									<?
										endfor; 

									?>

							
							</select>
						</div>
					</li>
				</ul>	
			</div>
		</div>
	</div>
	<!--Inbox Left End-->
    
    
    
    
   <!--Inbox right Start-->
   <div class="profile_right" style="margin-top:15px;">
		<div class="heading-select heading-job">
			<div>
				<div class="watch-job">
					<input name="check_watchsme" id="check_watch-sme" type="checkbox" value="" />
					<label for="check_watch-sme" class="css-label">Watch Job</label>
				</div>
				<div class="profile-types">
					<ul class="live-pro-list clearfix" >
						<li>
							<div class="select-box">
								<select name="postedwithin_sl" class="selectyze2" onchange="get_posted_within(this.value)">
									<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."All/".$fe?>' <? if($_REQUEST[posted_time]=="All"){?> selected=selected <? }?>>All</option>						
									<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."1/".$fe?>' <? if($_REQUEST[posted_time]=="1"){?> selected=selected <? }?>>In 24 hours</option>		
									<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."3/".$fe?>' <? if($_REQUEST[posted_time]=="3"){?> selected=selected <? }?>>In 3 days</option>								
									<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."7/".$fe?>' <? if($_REQUEST[posted_time]=="7"){?> selected=selected <? }?>>In 7 days</option>		
								  
								</select>
							</div>
						</li>
					</ul>
				</div>		
			</div>
		</div>   
   <?php
		$no_of_records=2;
		
		
		$query=array();
		
		//Search by Type	
		if($_REQUEST['project_type']!="" && $_REQUEST['project_type']!="All")
		{
					
				 $query[]=$prev ."projects.project_type='".$_REQUEST['project_type']."'";			
		}
		//Search by Nation	
		if($_REQUEST['country']!="" && $_REQUEST['country']!="0")
		{
			$select_cate=mysql_query("select user_id from ".$prev."user where country='".$_REQUEST['country']."'");
			
			while($dft=@mysql_fetch_assoc($select_cate)){
				$usercon[]=$dft['user_id'];
			}
			if(count($usercon)>0){
				$useridcontry=implode("','",$usercon);
			}	
			$query[]=$prev ."projects.user_id in ('".$useridcontry."')";			
		}

		//Search by Days
		if($_REQUEST['posted_time']!="" && $_REQUEST['posted_time']!="All")
		{
			$i=30;
			$newtime = strtotime(date("Y-m-d", time()) . " -".$_REQUEST['posted_time']."days");

			$query[]=$prev ."projects.date2 between '".$newtime."' and '".time()."'";			
		}

		//Search by Keyword
		if($_REQUEST['keyword']!="" || $_REQUEST['keyword']=='Search Job')
		{
			$query[]="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
		}
			
		//Search by Budget
		if($budget_min!="")
		{
			$query[]=" CONVERT(SUBSTRING_INDEX(".$prev ."projects.budgetmin,'$',-1),UNSIGNED INTEGER) >='".$_REQUEST['budget_min']."'";
		}
		if($budget_max!="")
		{
			$query[]=" CONVERT(SUBSTRING_INDEX(".$prev ."projects.budgetmax,'$',-1),UNSIGNED INTEGER) <='".$_REQUEST['budget_max']."' and CONVERT(SUBSTRING_INDEX(".$prev ."projects.budgetmax,'$',-1),UNSIGNED INTEGER) >'0'";
		}
		
		//Search by Status
		if($p_status!="")
		{
			if($p_status=='all')
				$query[]=$prev ."projects.status NOT IN('all') ";	
			else
				$query[]=$prev ."projects.status='$p_status' ";
		}
		else
		{
			$query[]=$prev ."projects.status='open' ";
		}
		
		//Search by Skill LINKED IN
		if(!empty($_REQUEST['skill_id']))
		{
			$skill_id=$_REQUEST['skill_id'];
		
			$query[]=$prev."projects_cats.cat_id=".$skill_id;
			
		}
		
		//Search by Category ID
		if(!empty($_REQUEST['cat_id']))
		{
			$cat_id= $_REQUEST['cat_id'];
			
			$query[]=$prev."projects.categories='".$cat_id. "' ";
		}
	
	
		if(!empty($query))
		{
			$MyQuery = implode(" and ", $query);
		}
		
	
	 $query1=" SELECT *,".$prev ."projects.id as job_id,".$prev ."projects.user_id as client_id FROM " . $prev . "projects 
					
				LEFT JOIN ".$prev ."categories ON " . $prev . "projects.categories = ".$prev ."categories.cat_id 
				
				LEFT JOIN ".$prev ."projects_cats ON " . $prev . "projects.id = ".$prev ."projects_cats.id 
				
				LEFT JOIN ".$prev ."skill_linkedin ON " . $prev . "projects_cats.cat_id = ".$prev ."skill_linkedin.id 
				
				WHERE $MyQuery  GROUP BY ". $prev . "projects.id  ORDER BY " . $prev . "projects.date2 desc
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
	
					$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  " . $prev . "projects.status='open' and ".$prev."projects.id='".$row['job_id']."'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";


					$result1=mysql_query($query);
					$secondsPerDay = ((24 * 60) * 60);
					$timeStamp =@mysql_result($result1,0,"date2");
					$timeStamp2 = time();
					$daysUntilExpiry =@mysql_result($result1,0,"expires");
					$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);			

						$datleft = '';
				

						if ((($daysUntilExpiry - $timeStamp2)/$secondsPerDay)<1 && (( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)>=0)
						{
							$datleft = " &nbsp;".$lang['LESS_DAY']."&nbsp;";
						}
						elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)
						{
						  $datleft = " &nbsp;" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)."&nbsp;" .$lang['day'];
						   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)
						   {
							 $datleft .= "s";
						   }
						   $datleft .= "&nbsp;".$lang['LFT']."&nbsp;";
						}
						else
						{
						   $datleft = "<font color=red>&nbsp;".$lang['EXPIRED']."&nbsp;</font>";
						}

	?>   
			<div style="position:absolute;margin-left: 652px;margin-top: 15px;"><?=getfeatureiconmain($row[job_id])?>
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
					<input id="check_user1" type="checkbox" />	
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
	  });
	</script>
<?php include 'includes/footer.php';?> 