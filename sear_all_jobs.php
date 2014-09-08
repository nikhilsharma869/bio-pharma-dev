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


if($_GET['cat_id']=='' && $_REQUEST['cat_id']==''){

//$_GET['cat_id']=195;$_REQUEST['cat_id']=195;
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
	/*$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false,
			navigation: true
		});
	});
	$("#findwork").addClass('select');*/
function get_posted_within(val){
 // $("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	document.postedwithin.action = val;
	document.postedwithin.submit();	
}

function get_country(val)
{
 // $("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	document.countryform.action = val;
	document.countryform.submit();		
}

function getprojecttypess(val)
{
 // $("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
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


  <div class="page_headding"><div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0)" class="selected"><?=$lang['FIND_JOBB']?></a></p></div>

<!-- <form action="<?=$vpath?>sear_all_jobs.html"  method="POST" name="myform" id="myform">
<div class="serach_pannel" style="float:none; margin:0px auto; width:430px; height:33px; border:1px solid #CCCCCC;">
<select name="select2" id="tech1" class="selectyze3" onChange="this.form.action=this.options[this.selectedIndex].value;">
  <option value="browse-freelancers.php" ><?=$lang['FIND_TALENT']?></option>
   <option value="sear_all_jobs.php" selected="selected" ><?=$lang['PROJECT_NAME']?></option> -->
<!-- <option value="sear_all_jobs.php" ><?=$lang['SKILLS']?></option> -->
<!-- </select>
 <input name="keyword" id="keyword" type="text" size="20px" class="search_input" onblur="if(this.value=='')this.value='<? if($_REQUEST['keyword']!=""){ echo $_REQUEST['keyword'];}else{?><?=$lang['CONTRATER3']?><? }?>';" onfocus="if(this.value=='<? if($_REQUEST['keyword']!=""){ echo $_REQUEST['keyword'];}else{?><?=$lang['CONTRATER3']?><? }?>')this.value='';" style="width:250px;" value="<? if($_REQUEST['keyword']!=""){ echo $_REQUEST['keyword'];}else{?><?=$lang['CONTRATER3']?><? }?>">
           <input name="submit2" type="submit" value="" class="search_bnt1">
        </div>
		</form> -->
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
</div>
<div class="clear"></div>

          <form name="postedwithin" id="postedwithin" action="" method="post">
          </form>
   <!--Inbox Left Start-->
<div class="profile_left" >

<!-- <div id="open-by-default-example" class="accordian" data-collapse> -->
<div id="open-by-default-example">

   <?php
 //  $f=0;
 //   $rt=mysql_query("select cat_id,cat_name from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
 //   while($p_f=@mysql_fetch_array($rt)){
 //   echo ' <h3 class="open">'.languagechagevalue($p_f['cat_id'],'cat_name','categories',$p_f['cat_name']).'</h3>
 //   <ul class="live-pro-list clearfix" >';
 //   $r=mysql_query("select * from " . $prev . "categories  where parent_id='".$p_f['cat_id']."' and status='Y' order by cat_name");
	// while($d=mysql_fetch_array($r))
	// {
	// $f++;
	// if($f==1){
	// $sy='style="height:auto!important;"';
	// }else{
	// $sy="";
	// }
	// $catnm=$d['cat_name'];
	// 	if($_SESSION[lang_id])
	// 	{
	// 		$row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id='".$d['cat_id']."' and table_name='categories' and field_name='cat_name' and lang_id='".$_SESSION[lang_id]."'"));					
	// 		$d['cat_name']=$row_content_lang['content'];
	// 	 }

		
							
	// 	$prm = "cat_id=".$d['cat_id']."&projectStatus=".$_GET['projectStatus']."&budget_min=".$_REQUEST['budget_min']."&budget_max=".$_REQUEST['budget_max'];
	// 	$newurl="";
	// 	$newurl.=$p_f['cat_id']."/".$d['cat_id']."/".replacename($catnm)."/";
	// 	if($_GET['project_type']!=''){
	// 	$newurl.=$_GET['project_type']."/";
	// 	}else{
	// 	$newurl.="All/";
	// 	}
	// 	if($_REQUEST['budget_min']!='' && $_REQUEST['budget_min']!='0'){
	// 	$newurl.=$_REQUEST['budget_min']."/";
	// 	}else{
	// 	$newurl.="0/";
	// 	}
	// 	if($_REQUEST['budget_max']!='' && $_REQUEST['budget_max']!='0'){
	// 	$newurl.=$_REQUEST['budget_max']."/";
	// 	}else{
	// 	$newurl.="0/";
	// 	}
	// 	if($_REQUEST['posted_time']!='' && $_REQUEST['posted_time']!='All'){
	// 	$newurl.=$_REQUEST['posted_time']."/";
	// 	}else{
	// 	$newurl.="All/";
	// 	}
	// 	if($_REQUEST['country']!='' && $_REQUEST['country']!='0'){
	// 	$newurl.=$_REQUEST['country']."/";
	// 	}else{
	// 	$newurl.="0/";
	// 	}
		
					
		
						?>
							
						<!-- <li ><a href='<?=$vpath?>jobs/1/<?=$newurl?>'<? if($_GET[sub_cat_id]==$d['cat_id']){?> class="active" <? }?> ><?php echo $d['cat_name'];?>&nbsp;</a></li> -->
					<?php
					
		
		// }
		// echo '</ul>';
	// }
	?>
<?
		if($_REQUEST[sub_cat_id]){
			 $rc2=mysql_query("select cat_name,parent_id from " . $prev . "categories  where cat_id=" . $_REQUEST[sub_cat_id] ."");
			 $cat_name2=mysql_result($rc2,0,"cat_name");
				$cat_parent=mysql_result($rc2,0,"parent_id"); 
			 $cat=$cat_parent."/".$_GET['sub_cat_id']."/".replacename($cat_name2)."/";
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
	<!-- <a href='<?=$vpath?>jobs/1/<?=$cat."All/".$min.$max.$sr.$fe?>' <? if($_REQUEST[project_type]=="All"){?> class="active" <? }?>><?=$lang['RIG1']?></a> -->
	<input name="check_hour" id="check_hourall" type="radio" value="" onclick="getprojecttypess('/jobs/1/<?=$cat."All/".$min.$max.$sr.$fe?>')" <? if($_REQUEST[project_type]=="All"){?> checked=checked <? }?>>
    <label for="check_hourall" class="css-label"><?=$lang['RIG1']?></label>
</li>							
<li>
	<!-- <a href='<?=$vpath?>jobs/1/<?=$cat."H/".$min.$max.$sr.$fe?>' <? if($_REQUEST[project_type]=="H"){?> class="active" <? }?>><?=$lang['HOURLY']?></a> -->
	<input name="check_hour" id="check_hourh" type="radio" value="" onclick="getprojecttypess('<?=$vpath?>jobs/1/<?=$cat."H/".$min.$max.$sr.$fe?>')" <? if($_REQUEST[project_type]=="H"){?> checked=checked <? }?>>
    <label for="check_hourh" class="css-label"><?=$lang['HOURLY']?></label>
</li>			
<li>
	<!-- <a href='<?=$vpath?>jobs/1/<?=$cat."F/".$min.$max.$sr.$fe?>' <? if($_REQUEST[project_type]=="F"){?> class="active" <? }?>><?=$lang['FIXED']?></a> -->
	<input name="check_hour" id="check_hourf" type="radio" value='' onclick="getprojecttypess('<?=$vpath?>jobs/1/<?=$cat."F/".$min.$max.$sr.$fe?>')" <? if($_REQUEST[project_type]=="F"){?> checked=checked <? }?>>
    <label for="check_hourf" class="css-label"><?=$lang['FIXED']?></label>
</li>							
					
				
			</ul>
		</form>
			</div>	
			<!-- <div class="cat-listp ca-job">		
		<h3 class='open'><?=$lang['BUDGETT']?> </h3>
		<ul class="live-pro-list clearfix"><li>
		<form action="" method="post">
		
		<div class="doller budgetss clearfix" aria-hidden="false" style="display: block;"> -->
         <!-- <label> <?=$lang[DOLLAR]?> </label> -->
         <!-- <input class="mini-inp" type="text" name="budget_min" value="<?=$_REQUEST[budget_min]?>"> -->
         <!-- <label> to <?=$lang[DOLLAR]?> </label> -->
         <!-- <label>-</label>
         <input class="mini-inp" type="text" name="budget_max" value="<?=$_REQUEST[budget_max]?>">
		 <input  type="hidden" name="cat_id" value="<?=$_REQUEST[cat_id]?>">	
						 <input  type="hidden" name="posted_time" value="<?=$_REQUEST[posted_time]?>">	
						<input  type="hidden" name="country" value="<?=$_REQUEST[country]?>">	
         <input value="Ok" class="ok-btn" type="submit" >
         </div>
		 </form>
		</li>
		</ul>
	</div> -->
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
				</form>
			</li>
		</ul>
	</div>
	<!-- <div class="cat-listp">	
<h3 class='open'><?=$lang['POSTED_WITHIN']?></h3>
<ul class="live-pro-list clearfix">
					
<li><a href='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."All/".$fe?>' <? if($_REQUEST[posted_time]=="All"){?> class="active" <? }?>><?=$lang['RIG1']?></a></li>							
<li><a href='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."1/".$fe?>' <? if($_REQUEST[posted_time]=="1"){?> class="active" <? }?>><?=$lang['POSTED24']?></a></li>			
<li><a href='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."3/".$fe?>' <? if($_REQUEST[posted_time]=="3"){?> class="active" <? }?>><?=$lang['POSTED3']?></a></li>							
<li><a href='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."7/".$fe?>' <? if($_REQUEST[posted_time]=="7"){?> class="active" <? }?>><?=$lang['POSTED7']?></a></li>		
				
			</ul>
			</div> -->
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

          <!-- 	<?php
$arr=array_keys($country_array);
for($i=0;$i<count($arr);$i++):
?>
<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max.$sr.$arr[$i]?>/' <? if($_REQUEST[country]==$arr[$i]){?> selected=selected <? }?>><?=$country_array[$arr[$i]]?></option>		
<?
endfor; 
?>		 -->
        </select>
        </div>
						
<!-- <li><a href='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max.$sr."0/"?>' <? if($_REQUEST[country]==0){?> class="active" <? }?>><?=$lang['RIG1']?></a></li>		 -->


  			
											
					
				</li>
			</ul>	
		</div>
	</div>


	
	
	</div>
	

	
    <!--Inbox Left End-->
    
    
    
    
   <!--Inbox right Start-->
   <div class="profile_right" style="margin-top:15px;">
   	<div class="heading-select heading-job">
	<!-- <div class="cpseudo"></div> -->
	<div>
		<div class="watch-job">
			<input name="check_watchsme" id="check_watch-sme" type="checkbox" value="" />
        	<label for="check_watch-sme" class="css-label">Watch Job</label>
		</div>
		<div class="profile-types">
			<ul class="live-pro-list clearfix" >
				<li>
					<!-- <form name="postedwithin" id="postedwithin" action="" method="post"> -->
			 			<div class="select-box">
			        		<select name="postedwithin_sl" class="selectyze2" onchange="get_posted_within(this.value)">
							  	<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."All/".$fe?>' <? if($_REQUEST[posted_time]=="All"){?> selected=selected <? }?>>All</option>						
								<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."1/".$fe?>' <? if($_REQUEST[posted_time]=="1"){?> selected=selected <? }?>>In 24 hours</option>		
								<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."3/".$fe?>' <? if($_REQUEST[posted_time]=="3"){?> selected=selected <? }?>>In 3 days</option>								
								<option value='<?=$vpath?>jobs/1/<?=$cat.$project_type.$min.$max."7/".$fe?>' <? if($_REQUEST[posted_time]=="7"){?> selected=selected <? }?>>In 7 days</option>		
							  
					        </select>
					    </div>
					<!-- </form> -->
				</li>
			</ul>
		</div>		
	</div>
</div>   
   <?php
$no_of_records=10;
if($_REQUEST['keyword']!="" || $_REQUEST['keyword']=='Search Job')
{
// $conds="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
	$query[]="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."' or " .$prev ."categories.cat_name rlike '".$_REQUEST['keyword']."' or " .$prev ."categories.cat_desc rlike '".$_REQUEST['keyword']."')";
}
$conds=$prev ."projects.status='".$_GET['projectStatus']."'";
$conds=$prev ."projects.budgetmin='".$_REQUEST['budget_min']."'";
$conds=$prev ."projects.budgetmax='".$_REQUEST['budget_max']."'";
$conds=$prev ."projects_cats.cat_id='".$_GET['cat_id']."'";



$query=array();

if($_REQUEST['project_type']!="" && $_REQUEST['project_type']!="All")
{
		 	
		 $query[]=$prev ."projects.project_type='".$_REQUEST['project_type']."'";			
}
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



if($_REQUEST['posted_time']!="" && $_REQUEST['posted_time']!="All")
{
$i=30;
 $newtime = strtotime(date("Y-m-d", time()) . " -".$_REQUEST['posted_time']."days");


		 $conds=$prev ."projects.date2 between '".$newtime."' and '".time()."'";	
		 $query[]=$prev ."projects.date2 between '".$newtime."' and '".time()."'";			
}


if($_REQUEST['keyword']!="Search Job" && $_REQUEST['keyword'])
	{
	    // $query[]="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."' or " .$prev ."categories.cat_name rlike '".$_REQUEST['keyword']."' or " .$prev ."categories.cat_desc rlike '".$_REQUEST['keyword']."')";
	    $query[]="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."' or " .$prev ."categories.cat_name rlike '".$_REQUEST['keyword']."' or " .$prev ."categories.cat_desc rlike '".$_REQUEST['keyword']."')";
	}
if($budget_min!="")
	{
		//$query[]=" cast(".$prev ."projects.budgetmin AS INT) >='".$_REQUEST['budget_min']."'";
		$query[]=" CONVERT(SUBSTRING_INDEX(".$prev ."projects.budgetmin,'$',-1),UNSIGNED INTEGER) >='".$_REQUEST['budget_min']."'";
	
	}
if($budget_max!="")
	{
		//$query[]=" cast(".$prev ."projects.budgetmax AS INT) <='".$_REQUEST['budget_max']."'";
		$query[]=" CONVERT(SUBSTRING_INDEX(".$prev ."projects.budgetmax,'$',-1),UNSIGNED INTEGER) <='".$_REQUEST['budget_max']."' and CONVERT(SUBSTRING_INDEX(".$prev ."projects.budgetmax,'$',-1),UNSIGNED INTEGER) >'0'";
	}
	
	
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
	if(!empty($_REQUEST['sub_cat_id']))
	{
		$cat_id=$_REQUEST['sub_cat_id'];
		
		$query[]=$prev."projects_cats.cat_id in('".$cat_id. "') ";
		//$query[]=$prev."projects_cats.cat_id=".$cat_id. " ";
	}elseif(!empty($_REQUEST['cat_id']))
	{
		$cat_id= $_REQUEST['cat_id'];
		$rty=mysql_query("select cat_id from ".$prev."categories where parent_id='".$cat_id."'");
		while($sdr=@mysql_fetch_assoc($rty)){
		$dre[]=$sdr[cat_id];
		}
		if(count($dre)>0){
		$cat_id_new=@implode("','",$dre);
		}
		$query[]=$prev."projects_cats.cat_id in('".$cat_id_new. "') ";
		//$query[]=$prev."projects_cats.cat_id=".$cat_id. " ";
	}
	
	
	if(!empty($query))
	{
		$MyQuery = implode(" and ", $query);	
	    $MyQuery = "where  " . $prev . "projects.id= ".$prev ."projects_cats.id and ".$prev ."projects_cats.cat_id= ".$prev ."categories.cat_id and ".$MyQuery;	
	}
	else
	{
	 $MyQuery = "where  " . $prev . "projects.id= ".$prev ."projects_cats.id and ".$prev ."projects_cats.cat_id= ".$prev ."categories.cat_id and " .$prev ."projects.status='open'";	
	}
	
	 $query1="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats,".$prev ."categories  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";
	
	$result1=mysql_query($query1);
	$total_pages = @mysql_num_rows($result1);
	
	if($_GET['page'])
	{
		  $query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats,".$prev ."categories  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
		
	}
	else
	{	
	 $query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats,".$prev ."categories  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc limit 0,".$no_of_records."";
	
	}
	$result=mysql_query($query);
	
			$pa=1;
			$start_pg=($_REQUEST['page']-1)* $no_of_records;
			if($start_pg<0)
			$start_pg=0;
			$end_pg=$start_pg+$no_of_records;
			if($no_of_records>$total_pages)
			$end_pg=$total_pages;			else if($end_pg>$total_pages)			$end_pg=$total_pages;
	?>
   <!-- <div class="subdcribe-bar"> -->
   
     <!-- <ul class="subdcribe-bar-left"><li><?=$lang['j_ob']?>  (<?php echo  $start_pg .' - '. $end_pg .' of '.$total_pages; ?>)</li></ul>
     
  <div class="subdcribe-bar-right"></div> -->
   <div class="latest_worbox" id="member_right_box">
   <?php
   if($total_pages > 0)
	{
	while($row=@mysql_fetch_array($result))
	{

	if($pa % 2 == 0){$ca='tr2';}else{$ca='tr1';}

	$rr=mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id] . " limit 0, 1");

		while($dd=@mysql_fetch_array($rr))
		{
			$txt.=$dd[cat_name] . " , ";
		}
	//////////////////////////////////////////// select bids //////////////////////////////////////////////////

	$select_bids="select " . $prev . "buyer_bids.*," . $prev . "projects.* from " . $prev . "buyer_bids," . $prev . "projects where " . $prev . "buyer_bids.project_id=" . $prev . "projects.id and " . $prev . "buyer_bids.project_id='".$row[id]."'";


	$rec_bids=mysql_query($select_bids);

	$num_bids=mysql_num_rows($rec_bids);

		
	//////////////////////////////////////////// select bids //////////////////////////////////////////////////	

			// $rr=mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id]." and " . $prev . "categories.parent_id='".$row[main_cat_id]."' limit 3");
			$rr=mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id]." limit 3");

			$txt="";

			while($dd=@mysql_fetch_array($rr)){
			  $pprm = base64_encode("cat_id=".$dd['cat_id']."&projectStatus=".$_GET['projectStatus']."&budget_min=".$_REQUEST['budget_min']."&budget_max=".$_REQUEST['budget_max']);
$mncat[]=$dd['cat_id'];			  
			 $caturlforproject=$dd['parent_id']."/".$dd['cat_id']."/".replacename($dd['cat_name'])."/All/0/0/All/0/";
			  
			  $txt.= "<a href='".$vpath."jobs/1/".$caturlforproject."'>".$dd[cat_name] . "</a>  ";
			}
			$maincat="";
if(count($mncat)>0){
$rtu=implode(",",$mncat);

$as=mysql_query("select cat_name,cat_id from ".$prev."categories where cat_id in ($rtu) ");
while($cv=@mysql_fetch_assoc($as)){
if($_SESSION[lang_id])
		{
			$row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id='".$cv['cat_id']."' and table_name='categories' and field_name='cat_name' and lang_id='".$_SESSION[lang_id]."'"));					
			$cv['cat_name']=$row_content_lang['content'];
		 }
$maincat.=$cv[cat_name];
}

}
			if($txt!="")
			$jobtype=substr($txt,0,-2);			
			else			
			  $jobtype="not defined";		

						 $totalbid=totalbid($row[id]);

						 $avaragebid=avaragebid($row[id]);

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
	
	$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  " . $prev . "projects.status='open' and ".$prev."projects.id='".$row['id']."'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";


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
     	<div style="position:absolute;margin-left: 652px;margin-top: 15px;"><?=getfeatureiconmain($row[id])?>
   </div>
   <div class="search-job-content clearfix">
   	<div class="resultinfor">
    <a href="<?=$vpath?>project/<?php print $row[id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$row['project'])))?>.html" > <?php echo ucwords($row['project']);?> 	
    	<!-- <br> <?=getfeatureicon($row[id],'1')?> -->
    </a>

	<ul class="search-job-content-minili">
    <li><? if($row['project_type']=="F"){?><?=$lang['FXD_PRC']?>: <b><?=$lang[$budget_array1[$row[budget_id]]]?> </b> <? }else{?><?=$lang['HOURLY']?>: <b><?=$curn.$row['budgetmin']." to ".$curn.$row['budgetmax']?> </b><?} ?></li>
	<li>  <?=$lang['POSTED']?>: <b><?php print date('M d, Y',strtotime($row[creation]));?></b>  </li>
	<li>  <?=$lang['ENDS']?>: <b><?=$datleft; ?></b>   </li>
	<a  href="<?=$vpath?>project/<?php print $row[id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$row['project'])))?>.html" ><li class="bor-right"> <b><?php echo $num_bids;?></b> <?=$lang['PROPOSALS']?></li>  </a>
	</ul>
	</div>
	<div class="resultcheckbox">
  		<input id="check_user1" type="checkbox" />	
    	<label for="check_user1" class="css-label"></label>        
  	</div>
  	<div class="job-des">
    <p class=""><?php if(strlen($row['description'])>250){echo substr($row['description'],0,250).'...';} else {echo $row['description'];} ?></p>
  <p class="mar-top"><!--Category: <span><?=$maincat?></span>--> <?=$jobtype;?></span></p>
</div>

<div class="client-inforss">
	<?php
		$clients_info = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id=".$row[user_id]));
		if(!empty($clients_info[logo])) {
	   		$temp_logo=$clients_info[logo];
	   	} else {
			$temp_logo="images/face_icon.gif";
		} ?>
		<a href="<?=$vpath;?>publicprofile/<?=$clients_info[username]?>/" > <img src="<?=$vpath?>viewimage.php?img=<?php echo $temp_logo;?>&amp;width=60&amp;height=60" /></a>
		<p class="client-name"><?php echo $clients_info[fname].' '.$clients_info[lname]; ?></p>
		<p>
			<span>United States</span>
			<span>$0 Spent</span>
			<span>No Feedback</span>
		</p>
</div>

<!--   <p >
  <?php 
  	$buyer_info = mysql_fetch_array(mysql_query("select user_id,username,country from ".$prev."user where user_id=".$row[user_id]));	
  ?>
   <?=$lang['ACTIVATE_BY']?>: <a href="<?=$vpath?>publicprofile/<?=$buyer_info[username]?>/" style=" color: #205691;text-decoration: none;
"><?=ucwords($buyer_info[username]);?></a>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="<?=$vpath?>cuntry_flag/<?=strtolower($buyer_info[country]);?>.png" title="France" width="16" height="11" > &nbsp;&nbsp;<?=$country_array[$buyer_info[country]];?>
  <? if(getprojecttype($row['id'])=="F"){?><img src="<?=$vpath?>images/fixed.png" alt="<?=$lang['FIXED']?>" title="<?=$lang['FIXED']?>" /><? }else{?><img src="<?=$vpath?>images/hourly.png" alt="<?=$lang['HOURLY']?>" title="<?=$lang['HOURLY']?>" /><? }?></p> -->
   </div>     
 
   <?php

	 $pa++;

	 }

   }
	else	
	{	?> 
				<div align="center" style="color:#999999; font-size:14px; height:200px; margin:200px;"><?=$lang['NO_PRODUCT_FOUND']?></div>
<?php	
	}
if($total_pages > $no_of_records)
{ //$param = base64_encode("cat_id=".$_GET['cat_id']."&projectStatus=".$_GET['projectStatus']."&budget_min=".$_GET['budget_min']."&budget_max=".$_GET['budget_max']."&country=".$_GET['country']);

if($_GET['cat_id']){
$param.=$_GET['cat_id']."/";

$rc=mysql_query("select cat_name from " . $prev . "categories  where cat_id=" . $_GET[cat_id] ."");
$cat_name=mysql_result($rc,0,"cat_name");

$param.=replacename($cat_name)."/";
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
  

echo "<div align=right>" .new_pagingnew(5,$vpath.'Jobs/','/'.$param,$no_of_records,$_REQUEST['page'],$total_pages,$table_id='',$tbl_name='') . "</div>";
}
 ?>
 
   </div>
   <!-- </div> -->
   <!--Inbox  right End-->
   </div>
   </div></div>

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