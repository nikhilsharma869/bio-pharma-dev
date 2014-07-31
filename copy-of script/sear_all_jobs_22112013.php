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
	
//$decoded_qstr = base64_decode($_GET[qstr]);
//$decoded_qstr_arr = explode("&",$decoded_qstr);
//list($cat_id,$cat_val) = explode("=",$decoded_qstr_arr[0]);$_GET['cat_id'] = $cat_val;
//$_REQUEST['cat_id'] = $cat_val;
//list($projectStatus,$projectStatus_val) = explode("=",$decoded_qstr_arr[1]);
//$_GET['projectStatus'] = $projectStatus_val;
//$_REQUEST['projectStatus'] = $projectStatus_val;
//list($budget_m,$budget_m_val) = explode("=",$decoded_qstr_arr[2]);
//$_GET['budget_min'] = $budget_m_val;
//$_REQUEST['budget_min'] = $budget_m_val;
//list($budget_mm,$budget_mm_val) = explode("=",$decoded_qstr_arr[3]);
//$_GET['budget_max'] = $budget_mm_val;$_REQUEST['budget_max'] = $budget_mm_val;
//$p_name=$_REQUEST['keyword'];	
//$p_cat=$_GET['cat_id'];
//$p_status=$_GET['projectStatus'];
//$budget_min=$_GET['budget_min'];
//$budget_max=$_GET['budget_max'];

if($_GET['cat_id']=='' && $_REQUEST['cat_id']==''){

//$_GET['cat_id']=195;$_REQUEST['cat_id']=195;
}
if(!$_GET['budget_min']){
$_GET['budget_min']=0;
}if(!$_GET['budget_max']){
$_GET['budget_max']=0;
}
$p_name=$_REQUEST['keyword'];	

$p_cat=$_GET['cat_id'];

$p_status=$_GET['projectStatus'];

$budget_min=$_GET['budget_min'];

$budget_max=$_GET['budget_max'];
?>
<link type="text/css" rel="stylesheet" href="css/searchPage_15042012.css">
<script language="JavaScript" src="js/search_framework.js" type="text/javascript"></script>



<script>
	$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false,
			navigation: true
		});
	});
	$("#findwork").addClass('select');
</script>

<div class="inner-middle"> 

<div class="clear"></div>
          
   <!--Inbox Left Start-->
<div class="inbox_left">
   <div class="inbox_left_box">
   <div class="inbox_left_text">
     <h1><?=$lang['NARROW_RESULT']?></h1>
   </div>
   <div class="inbox_left_link">
   <!--start-->

	<div id="accordion">

   <?php
  $f=0;
   $r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
	while($d=mysql_fetch_array($r))
	{
	$f++;
	if($f==1){
	$sy='style="height:auto!important;"';
	}else{
	$sy="";
	}
		if($_SESSION[lang_id])
		{
			$row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id='".$d['cat_id']."' and table_name='categories' and field_name='cat_name' and lang_id='".$_SESSION[lang_id]."'"));					
			$d['cat_name']=$row_content_lang['content'];
		 }

		echo "<div><h3 class='inboxtitle'>".$d['cat_name']."</h3></div>";
		echo '<div class="demo_left_link" id="sonu"><div>
		<ul>';
		$select_skills="select * from " . $prev . "categories where parent_id='".$d['cat_id']."' and status='Y' order by cat_name limit 0,17";
		$rec_skills=mysql_query($select_skills);
		$num_skills=mysql_num_rows($rec_skills);
		if($num_skills > 0)
		{
		$k=0;$flag=0;
		while($row_skills=mysql_fetch_array($rec_skills))
					{
							$select_count_project="select " . $prev . "projects_cats.*," . $prev . "projects.* from " . $prev . "projects_cats," . $prev . "projects where " . $prev . "projects_cats.cat_id='".$row_skills['cat_id']."' and " . $prev . "projects_cats.id=" . $prev . "projects.id and " . $prev . "projects.status='open'";

							$rec_count_project=mysql_query($select_count_project);

							$num_count_project=@mysql_num_rows($rec_count_project);
							
							$prm = "cat_id=".$row_skills['cat_id']."&projectStatus=".$_GET['projectStatus']."&budget_min=".$_GET['budget_min']."&budget_max=".$_GET['budget_max'];
							$newurl="";
							$newurl.=$row_skills['cat_id']."/".replacename($row_skills[cat_name])."/";
							if($_GET['projectStatus']!=''){
							$newurl.=$_GET['projectStatus']."/";
							}else{
							$newurl.="open/";
							}
							if($_GET['budget_min']!='' && $_GET['budget_min']!='0'){
							$newurl.=$_GET['budget_min']."/";
							}else{
							$newurl.="0/";
							}
							if($_GET['budget_max']!='' && $_GET['budget_max']!='0'){
							$newurl.=$_GET['budget_max']."/";
							}else{
							$newurl.="0/";
							}
					
		if($_SESSION[lang_id])
		{
			$row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id='".$row_skills['cat_id']."' and table_name='categories' and field_name='cat_name' and lang_id='".$_SESSION[lang_id]."'"));					
			$row_skills['cat_name']=$row_content_lang['content'];
		 }
						?>
						
						<li ><a href='<?=$vpath?>jobs/1/<?=$newurl?>'<? if($_GET[cat_id]==$row_skills['cat_id']){?> class="selected" <? }?> ><?php echo $row_skills['cat_name'];?>.&nbsp;(<?php echo $num_count_project;?>)</a></li>
					<?php
					$k++;
					}
		
		}
		echo '</ul>';
		echo '<div style="clear:both;"></div>';
		echo '</div></div>';
	}

	?>
	
	<?php
	if($_REQUEST[cat_id]!='' || $cat_id!=''){ 
	?>
	
	<h3 class="inboxtitle"> <?=$lang['JOB_CAT3']?> </h3>
		
		<div>
			<ul>
				<?
	
	 $rc2=mysql_query("select cat_name from " . $prev . "categories  where cat_id=" . $_REQUEST[cat_id] ."");
	 $cat_name2=mysql_result($rc2,0,"cat_name");
		 
	 $cat=$_GET['cat_id']."/".$cat_name2."/";
	
							
							if($_GET['budget_min']!='' && $_GET['budget_min']!='0'){
							$min=$_GET['budget_min']."/";
							}else{
							$min="0/";
							}
							if($_GET['budget_max']!='' && $_GET['budget_max']!='0'){
							$max=$_GET['budget_max']."/";
							}else{
							$max="0/";
							}
							
					?>			
					<li><a href='<?=$vpath?>jobs/1/<?=$cat."all/".$min.$max.$sr.$fe?>'><?=$lang['RIG1']?></a></li>							
					<li><a href='<?=$vpath?>jobs/1/<?=$cat."open/".$min.$max.$sr.$fe?>' ><?=$lang['STAT_OPEN']?></a></li>							<li><a href='<?=$vpath?>jobs/1/<?=$cat."frozen/".$min.$max.$sr.$fe?>' ><?=$lang['STAT_FROZ']?></a></li>							
					<!--<li><a href='<?=$vpath?>Jobs/1/<?=base64_encode("cat_id=".$_GET['cat_id']."&projectStatus=closed&budget_min=".$_GET['budget_min']."&budget_max=".$_GET['budget_max'])?>' >Closed</a></li>							
					<li><a href='<?=$vpath?>Jobs/1/<?=base64_encode("cat_id=".$_GET['cat_id']."&projectStatus=cancelled&budget_min=".$_GET['budget_min']."&budget_max=".$_GET['budget_max'])?>' >Cancelled</a></li> -->
				
			</ul>
		<div style="clear:both;"></div>
		</div>
		
		
		<h3 class="inboxtitle"> <?=$lang['JOB_CAT4']?> </h3>
		
		<div>
			<ul>
				<?
				if($_GET['projectStatus']!=''){
					$stat=$_GET['projectStatus']."/";
					}else{
					$stat="open/";
					}
					if($_GET['budget_max']!='' && $_GET['budget_max']!='0'){
					$max=$_GET['budget_max']."/";
					}else{
					$max="0/";
					}
					
	            ?>
				<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat."250/".$max?>' ><?=$lang['max_rs']?></a></li>							
				<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat."750/".$max.$sr.$fe?>' ><?=$lang['max_rs1']?></a></li>							
				<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat."1500/".$max.$sr.$fe?>' ><?=$lang['max_rs2']?></a></li>							<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat."3000/".$max.$sr.$fe?>' ><?=$lang['max_rs3']?></a></li>							<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat."5000/".$max.$sr.$fe?>' ><?=$lang['max_rs4']?></a></li>
			</ul>
			<div style="clear:both;"></div>
		</div>
		
			
		
		<h3 class="inboxtitle"> <?=$lang['JOB_CAT5']?> </h3>
		
		<div>
			<ul>
			
			<?
			if($_GET['projectStatus']!=''){
							$stat=$_GET['projectStatus']."/";
							}else{
							$stat="open/";
							}
							if($_GET['budget_min']!='' && $_GET['budget_min']!='0'){
							$min=$_GET['budget_min']."/";
							}else{
							$min="0/";
							}
			?>
				<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat.$min."250/"?>' ><?=$lang['max_rs']?></a></li>							
				<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat.$min."750/".$sr.$fe?>' ><?=$lang['max_rs1']?></a></li>							
				<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat.$min."1500/".$sr.$fe?>' ><?=$lang['max_rs2']?></a></li>							
				<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat.$min."3000/".$sr.$fe?>' ><?=$lang['max_rs3']?></a></li>							
				<li><a href='<?=$vpath?>jobs/1/<?=$cat.$stat.$min."5000/".$sr.$fe?>' ><?=$lang['max_rs4']?></a></li>
			</ul>
			<div style="clear:both;"></div>
		</div>
		<?php
		}
		?>
		
		
	</div>


	
	
	</div>
	</div>
	</div>

	
    <!--Inbox Left End-->
    
    
    
    
   <!--Inbox right Start-->
   <div class="inbox_right">
   <?php
$no_of_records=10;
if($_REQUEST['keyword']!="" || $_REQUEST['keyword']=='Search Job')
{
$conds="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
}
$conds=$prev ."projects.status='".$_GET['projectStatus']."'";
$conds=$prev ."projects.budgetmin='".$_GET['budget_min']."'";
$conds=$prev ."projects.budgetmax='".$_GET['budget_max']."'";
$conds=$prev ."projects_cats.cat_id='".$_GET['cat_id']."'";



$query=array();

if($_REQUEST['featured_jobs']!="")
{
		 $conds=$prev ."projects.special='featured'";	
		 $query[]=$prev ."projects.special='featured'";		
}


if($_REQUEST['keyword']!="Search Job" && $_REQUEST['keyword'])
	{
	    $query[]="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
	}
if($budget_min!="")
	{
		$query[]=$prev ."projects.budgetmin >='".$_REQUEST['budget_min']."'";
	}
if($budget_max!="")
	{
		$query[]=$prev ."projects.budgetmax <='".$_REQUEST['budget_max']."'";
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
	
	if(!empty($_REQUEST['cat_id']))
	{
		$cat_id= $_REQUEST['cat_id'];
		$query[]=$prev."projects_cats.cat_id=".$cat_id. " ";
	}
	
	
	if(!empty($query))
	{
		$MyQuery = implode(" and ", $query);	
	    $MyQuery = "where  " . $prev . "projects.id= ".$prev ."projects_cats.id and ".$MyQuery;	
	}
	else
	{
	 $MyQuery = "where  " . $prev . "projects.id= ".$prev ."projects_cats.id and " .$prev ."projects.status='open'";	
	}
	
	$query1="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";
	
	$result1=mysql_query($query1);
	$total_pages = @mysql_num_rows($result1);
	
	if($_GET['page'])
	{
		$query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
		
	}
	else
	{	
	$query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc limit 0,".$no_of_records."";
	
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
   <div class="inbox_right_box">
   <div class="inbox_right_text">
     <h2><?=$lang['j_ob']?>  (<?php echo  $start_pg .' - '. $end_pg .' of '.$total_pages; ?>)</h2>
     
   </div>
   
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

			$rr=mysql_query("select * from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id]);

			$txt="";

			while($dd=@mysql_fetch_array($rr)){
			  $pprm = base64_encode("cat_id=".$dd['cat_id']."&projectStatus=".$_GET['projectStatus']."&budget_min=".$_GET['budget_min']."&budget_max=".$_GET['budget_max']);			  
			  $txt.= "<a href='".$vpath."Jobs/1/".$dd['cat_id']."/".$dd[cat_name]."/'>".$dd[cat_name] . "</a> , ";
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
   
   
   <div class="article_box">
     <h1><!--<a href="<?=$vpath?>project-dtl.php?id=<?php print $row[id];?>" ><?php echo ucwords($row['project']);?></a>-->	 <a href="<?=$vpath?>project/<?php print $row[id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$row['project'])))?>.html" ><?php echo ucwords($row['project']);?> </a>	 </h1>
    <p><?=$lang['FXD_PRC']?>: <?=$lang[$budget_array1[$row[budget_id]]]?>  <span> |  <?=$lang['POSTED']?>: <?php print date('d-m-Y',strtotime($row[creation]));?> |  <?=$lang['ENDS']?>: <?=$datleft; ?>  | </span> <a  href="<?=$vpath?>project/<?php print $row[id];?>/<?=strtolower(str_replace("&",'+',str_replace(" ","-",$row['project'])))?>.html" ><?php echo $num_bids;?>  <?=$lang['PROPOSALS']?> </a></p>
    <p><span><?php if(strlen($row['description'])>250){echo substr($row['description'],0,250).'...';} else {echo $row['description'];} ?></span></p>
  <h1><span><?=$lang['SKILLS']?>: <?=$jobtype;?></span></h1>
  <div class="article_img_box">
  <?php 
  	$buyer_info = mysql_fetch_array(mysql_query("select user_id,username,country from ".$prev."user where user_id=".$row[user_id]));	
  ?>
    <p><a href="<?=$vpath?>publicprofile/<?=$buyer_info[username]?>/"><?=ucwords($buyer_info[username]);?></a>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="<?=$vpath?>cuntry_flag/<?=strtolower($buyer_info[country]);?>.png" title="France" width="16" height="11" > &nbsp;&nbsp;<?=$country_array[$buyer_info[country]];?></p>
  </div>
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
if($_GET['budget_min']>0){
$param.=$_GET['budget_min']."/";
}else{
$param.="0/";
}
if($_GET['budget_max']>0){
$param.=$_GET['budget_max']."/";
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
   </div>
   <!--Inbox  right End-->
   </div>

 <div style="clear:both; height:10px;"></div>
 <script type="text/javascript">
 	$(document).ready(function(){
		$("#sonu").removeAttr("style");
	});
 </script>
<?php include 'includes/footer.php';?> 