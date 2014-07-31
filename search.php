<?php 

include "includes/header.php"; 

//CheckLogin();
	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
	if(isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput']!="")
	{//echo $_REQUEST['categoryinput'];die();
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
?>



<style type="text/css">

a:link {text-decoration: none}

a:visited {text-decoration: none}

a:active {text-decoration: none}

a:hover {text-decoration: underline; color: red;}

</style>	

 

<!-----------Header End----------------------------->



<div class="recent_projects">

     <div class="pbsection4">

<?php 
		  /////////////////////////////////////////  current file name  ///////////////////////////////
$currentFile = $_SERVER["SCRIPT_NAME"];
$parts = explode('/', $currentFile);
$currentFile = $parts[count($parts) - 1];
////////////////////////////////////////  end current file name  ///////////////////////////////

?>


<?php

if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}	
$select_project="";
$condition=array();
if($_REQUEST['featured_jobs'])
{
		 $condition[]=$prev ."projects.special='featured'";	
		 $parameter="&special=featured";
}
if(count($condition)){$cond=implode("and",$condition); }
$cond.="and ".$prev."projects.project LIKE '%".$_REQUEST['keyword']."%'";
$q="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open' " . $cond . " group by " . $prev . "projects.id";
//echo $q;
$r=mysql_query($q);
# total projects
//---------------------
//For Advance Search
//Gets the zip code of loggedInUser
$get_user_zip = @mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id =".$_SESSION['user_id'].""));
//Gets the Latitude & Longitude for above zip code
$get_user_geo = @mysql_fetch_array(mysql_query("select * from zip_codes where ZIPCode =".$get_user_zip['zip'].""));


//$user_lat = 33.603543;
//$user_lon = -86.466833;

$user_lat = $get_user_geo['Latitude'];
$user_lon = $get_user_geo['Longitude'];
$distance= $_POST['job_distance'];

$sql_zip_codes = "SELECT *,(((acos(sin((".$user_lat."*pi()/180)) *
sin((`Latitude`*pi()/180))+cos((".$user_lat."*pi()/180)) *
cos((`Latitude`*pi()/180)) * cos(((".$user_lon."- `Longitude`)
*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM
zip_codes HAVING distance <= ".$distance." 
ORDER BY distance";

$result_zip_codes=mysql_query($sql_zip_codes);
$zip_codes = '';
while($row_zip_codes = @mysql_fetch_array($result_zip_codes))
{
$zip_codes .= "'".$row_zip_codes['ZIPCode']. "',";
}
$zip_codes = substr($zip_codes,0,-1);

if($_POST['adv_search'])
{
	$conds="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
	$conds=$prev ."projects.status='".$_REQUEST['projectStatus']."'";
	$conds=$prev ."projects.budgetmin='".$_REQUEST['budget_min']."'";
	$conds=$prev ."projects.budgetmax='".$_REQUEST['budget_max']."'";
	$p_name=$_REQUEST['keyword'];
	$p_status=$_REQUEST['projectStatus'];
	$budget_min=$_REQUEST['budget_min'];
	$budget_max=$_REQUEST['budget_max'];
	$flag=$_REQUEST['featured_jobs'];
	$category=$_REQUEST['new_categories'];
	$_SESSION['owner']=$_REQUEST['owner'];

	$query=array();
	if($_REQUEST['owner']!="Search By Owner" && $_REQUEST['owner']!="")
	{
		$query[]=$prev ."projects.user_id in(select user_id from ".$prev."user where username rlike '".$_REQUEST['owner']."')";
	}
	if($_REQUEST['keyword']!="Search Project" && $_REQUEST['keyword'])
	{
	    $query[]="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
	}
	if($_REQUEST['job_distance']!="By distance" && $_REQUEST['job_distance'])
	{
	    $query[]=$prev ."projects.zip in(".$zip_codes.")";
	}
	if($budget_min!="")
	{
		$query[]=$prev ."projects.budgetmin >='".$_REQUEST['budget_min']."'";
	}
	if($budget_max!="")
	{
		$query[]=$prev ."projects.budgetmax <='".$_REQUEST['budget_max']."'";
	}
	
	if(!empty($flag))
	{
		$query[]=$prev ."projects.special='featured' ";
	}
	
	if($p_status!="")
	{
		if($p_status=='all')
			$query[]=$prev ."projects.status NOT IN('all') ";	
		else
			$query[]=$prev ."projects.status='$p_status' ";		
			//this part change by sourav
	}
	else
	{
		$query[]=$prev ."projects.status='open' ";
	}
	if(!empty($_REQUEST['new_categories']))
	{
		$cat_id= $_REQUEST['new_categories'];
	  	$query[]=$prev."projects_cats.cat_id=".$cat_id. ") ";
	}
	if(!empty($_REQUEST['biddingEnds']) )
	{
	   $dt=$_REQUEST['biddingEnds'];
		//$dt=strtotime($dt);
		$query[]=" date_format( FROM_UNIXTIME(".$prev ."projects.expires ) , '%Y%m%d' )='$dt' ";
	}
	if(!empty($query))
	{
		$MyQuery = implode(" and ", $query);	
	    $MyQuery = "where  " . $prev . "projects.id= ".$prev ."projects_cats.id and ".$MyQuery;	
	}
	else
	{
	 $MyQuery = " where  " . $prev . "projects.id= ".$prev ."projects_cats.id and " .$prev ."projects.status='open'";	
	}
	
	$query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";
  //die($query);
	$r=mysql_query($query);
    
}
//--------------------------
//End for advance search
$total_pages = @mysql_num_rows($r);
		  ?>
          <!--<ul id="tab" class="tab">
			<li ><a href="search.php?latest_jobs=yes">Latest Jobs </a></li>
			<li><a href="search.php?featured_jobs=yes">Featured Jobs</a></li>
            <li class="active"><a href="search.php?all_jobs=yes">All Jobs </a></li>
            
		</ul>-->
		
  <div id="usage2" class="content1">
  <div id="adv_src">      
  <table width="930" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="6" align="left" valign="top" class="topCarve"></td>
  </tr>
  <tr>
    <td align="left" valign="top "class="middleBg" >
	<div style="padding:12px 15px 12px 15px; border:1px solid #CCCCCC;" >
    <form action="search.php" method="post" name="myform" > 
	 <table width="100%" border="0" cellspacing="3" cellpadding="3">
        <tr>
          <td align="left" valign="top">
		  <input style="border:1px solid #CCCCCC; width:190px; color:#666666; height:15px;" type="text" name="owner" class="input" <? if (!empty($_REQUEST['owner'])){
		  ?>value="<?=$_REQUEST['owner']?>"<? } else{?>placeholder="Search By Owner" <? } ?> onClick="return clear1()"></td>
          <td align="left" valign="top">
		  
		  <input style="border:1px solid #CCCCCC; width:190px; color:#666666;  height:15px;"   type="text" name="keyword" class="input" <? if ($_REQUEST['keyword']){?>value="<?=$_REQUEST['keyword']?>"<? } else {?>  placeholder="Search Project" <? } ?> onclick="return clear2()"/>
		  
		  
		  </td>
          <td align="left" valign="top"><select style="border:1px solid #CCCCCC; width:190px; color:#666666; padding:2px;"  class="input" name="projectStatus">
           <option value='<?=$_REQUEST['projectStatus']?>' selected style='font-weight: bold'>
			<? if($_REQUEST['projectStatus']){ echo $_REQUEST['projectStatus']; } else{
			echo 'open';}
			?>
			</option>
                            <option value='' >----Open</option>
                            <option value='all'  style='font-weight: bold'>All</option>
                            <option value='frozen'  style='font-weight: bold'>Frozen</option>
                            <option value='close'  style='font-weight: bold'>Closed</option>
						    
                            <option value='closed_awarded' >--Awarded</option>
                            <option value='closed_canceled' >--Canceled</option>
          </select></td>
          <td align="left" valign="top"><select style="border:1px solid #CCCCCC; width:190px; color:#666666; padding:2px;" name="new_categories" class="input">
           		<option value="">Select category</option>
                              
                              <? if($_REQUEST['new_categories']!=''){
					$rs=mysql_query("select cat_name from " . $prev . "categories  where status='Y' and cat_id=".$_REQUEST['new_categories']);
					$cat_name=mysql_result($rs,0,"cat_name");
					echo "<option value='".$res['cat_id']."' selected='selected'>".$cat_name." </option>";
					  
					 }  
							$r=mysql_query("select * from " . $prev . "categories  where status='Y' order by cat_name");
						    while($res=mysql_fetch_array($r)){
							
							?>
							<option value="<?=$res['cat_id'];?>"><?=$res['cat_name'];?></option>
						   <? } ?>
					
					</select></td>
        </tr>
        <tr><td colspan="4">
        		  <input style="border:1px solid #CCCCCC; width:190px; color:#666666;  height:15px;"   type="text" name="job_distance" class="input" <? if ($_REQUEST['job_distance']){?>value="<?=$_REQUEST['job_distance']?>"<? } else {?>  value="By distance" <? } ?> onclick="return clear2()"/>
        </td></tr>
        <tr>
          <td align="left" valign="middle"><span style="color:#666666;">Budget :</span>  <select style="border:1px solid #CCCCCC; width:90px; color:#666666; padding:2px;" name="budget_min" class="input_01">
                                <option  
								
								value="<?=$_REQUEST['budget_min']?>" ><? if($_REQUEST['budget_min']){ echo '$'.$_REQUEST['budget_min'];} else{
								echo "Min";}
								?></option>
								<option value='250' >$250</option>
								<option value='750' >$750</option>
								<option value='1500' >$1500</option>
								<option value='3000' >$3000</option>
								<option value='5000' >$5000</option>
								</select>
                                
                                <select style="border:1px solid #CCCCCC; width:90px; color:#666666; padding:2px;" name="budget_max" class="input_01">
            
			<option  
			
			 value="<?=$_REQUEST['budget_max']?>" ><? if($_REQUEST['budget_max']){ echo '$'.$_REQUEST['budget_max'];} else{
			 echo "Max";}
			 ?></option>
			<option value='30' >$30</option>
			<option value='250' >$250</option>
			<option value='750' >$750</option>
			
			<option value='1500' >$1500</option>
			<option value='3000' >$3000</option>
			<option value='5000' >$5000</option>
            </select>
                                </td>
          <td align="left" valign="middle"><? 
						$today=date('Ymd');
						$temp=$today;
						$tomorrow=$today+1;
						$tomorrow=date('Ymd',strtotime($tomorrow));
						$dayaftertomorrow=$tomorrow+1;
						$dayaftertomorrow=date('Ymd',strtotime($dayaftertomorrow));
						$week1=$temp+7;
						$week1=date('Ymd',strtotime($week1));
						$week2=$temp+14;
						$week2=date('Ymd',strtotime($week2));
						$week3=$temp+21;
						$week3=date('Ymd',strtotime($week3));
						
		  ?>
		  <select style="border:1px solid #CCCCCC; width:130px; color:#666666; padding:2px;" name="biddingEnds" class="input">
            <option  value="<?=$_REQUEST['biddingEnds']?>">
			<? if($_REQUEST['biddingEnds']){
			      if($_REQUEST['biddingEnds']==$today){
				    echo "Today";
				  }
			      elseif($_REQUEST['biddingEnds']==$tomorrow){
				    echo "Tomorrow";
				  }
			      elseif($_REQUEST['biddingEnds']==$dayaftertomorrow){
			        echo "DayAfterTomrrow";
				  }
			       elseif($_REQUEST['biddingEnds']==$week1){
			        echo "1 Week";
				  }
			      elseif($_REQUEST['biddingEnds']==$week2){
			        echo "2 Week";
				  }
			      elseif($_REQUEST['biddingEnds']==$week3){
			        echo "3 Week";
				  }
			  
			  }
			  else{
			echo "Bidding Ends";
			}?></option>
			<option value='<?=$today?>' >Today</option>
			<option value='<?=$tomorrow?>' >Tomorrow</option>
			<option value='<?=$dayaftertomorrow?>' >DayAfterTomrrow</option>
			<option value='<?=$week1?>' >1 Week</option>
			<option value='<?=$week2?>' >2 Week</option>
			<option value='<?=$week3?>' >3 Week</option>
              </select></td>
          <td align="left" valign="middle"><label>
		  <input style="border:1px solid #CCCCCC; color:#666666;" type="checkbox" name='featured_jobs'   <?php if($_REQUEST['featured_jobs']) { ?>  checked="checked"    <?php } ?> value="1" >
			<span style="color:#666666;">Featured</span> 
          </label></td>
          <td align="left" valign="top">
		  <input type="hidden" name="adv_search" value="adv_search"/>          
		  <!-- <input type="hidden" name="flag" value="1"/>-->
          <input type="submit" value="adv_search" name="adv_search" class="submit_bott"/>
		  <div align=right><a href="javascript://"   onClick="document.getElementById('adv_src').style.display='none'" class="link" style='padding-right:22px;padding-top:10px'>[Close]</a></div></td>
        </tr>
      </table>
	</form>
    </div>
	</td>
  </tr>
  <tr>
    <td height="6" align="left" valign="top" class="bottomCarve"></td>
  </tr>
</table>
</div>
<?php
	if($_REQUEST['search_jobs'] && ($_REQUEST['keyword']!=""))
	{
		$cond="where id='".$_REQUEST['keyword']."' or project='".$_REQUEST['keyword']."'";		
	}
	if(!$_REQUEST[param]){$_REQUEST[param]="latest-jobs";}
?> 
<div align="center">     
<table width="935" border="0" cellspacing="0" cellpadding="0" style="font-size:14px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >
<tr>
   <td colspan="6"  height="10"></td>
</tr>
<tr><td colspan="6" class="btbrd sm bdn"> <b><?php if($total_pages>0) {echo $total_pages.' project(s) found';} else {echo 'No project found ..';}?></b> </td></tr>
 <tr>
   <td colspan="6"  height="10"></td>
   </tr>
 <tr>
    <td class="thtxt" width="285">Project Name</td>
    <td class="thtxt" width="80">Bid</td>
    <td class="thtxt" width="210">Job Type</td>
    <td class="thtxt"  width="130">Avg Bid</td>
    <td class="thtxt"  width="150">Time Left</td>
    <td class="thtxt" width="100" align="center">Action</td>
  </tr>
<tr>
	<td colspan="6" >
	<!-- Replacing include--><?php	//include("alljobs.php");?>
    <style type="text/css">
.classheader
{
text-align:left; font-size:14px; color:#333333; font-weight:bold; line-height:30px;
}
</style>
<style type="text/css">
/*pagination start*/

div.pagination {
	padding: 3px;
	margin: 3px;
}


div.pagination a {
font-size:12px;
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	text-decoration: none; /* no underline */
	color: #D7E3F3;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #D7E3F3;
	color:#666666;
}
div.pagination span.current {
	padding: 2px 4px 2px 5px;
	margin: 2px;
	border:1px solid #AAAADD;
	font-size:12px;	
		font-weight:normal;
		background-color:#D7E3F3;
		color:#021D9B;
		font-weight:bold;
	}
	div.pagination span.disabled {
	font-size:12px;	
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #666666;
		color:#666666;
	}
	.joinnow {
		width: 97px;
		text-align: center;
		background: url(../images/joinnow.gif) 7px 3px no-repeat;
	}

</style>

<table width="930" border="0" cellpadding="0" cellspacing="0" style=" font-size:12px;" >

<?php


 

# list of projects
//echo $q. " ORDER BY " . $prev . "projects.date2 desc Limit 0,25"; 		   
$result=mysql_query($q. " ORDER BY " . $prev . "projects.date2 desc Limit 0,25");
//echo $q. " ORDER BY " . $prev . "projects.date2 desc Limit 0,25";
//---------------------
//For Advance Search
//Gets the zip code of loggedInUser
$get_user_zip = @mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id =".$_SESSION['user_id'].""));
//Gets the Latitude & Longitude for above zip code
$get_user_geo = @mysql_fetch_array(mysql_query("select * from zip_codes where ZIPCode =".$get_user_zip['zip'].""));


//$user_lat = 33.603543;
//$user_lon = -86.466833;

$user_lat = $get_user_geo['Latitude'];
$user_lon = $get_user_geo['Longitude'];
$distance= $_POST['job_distance'];

$sql_zip_codes = "SELECT *,(((acos(sin((".$user_lat."*pi()/180)) *
sin((`Latitude`*pi()/180))+cos((".$user_lat."*pi()/180)) *
cos((`Latitude`*pi()/180)) * cos(((".$user_lon."- `Longitude`)
*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM
zip_codes HAVING distance <= ".$distance." 
ORDER BY distance";

$result_zip_codes=mysql_query($sql_zip_codes);
$zip_codes = '';
while($row_zip_codes = @mysql_fetch_array($result_zip_codes))
{
$zip_codes .= "'".$row_zip_codes['ZIPCode']. "',";
}
$zip_codes = substr($zip_codes,0,-1);
if($_POST['adv_search'])
{
	$conds="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
	$conds=$prev ."projects.status='".$_REQUEST['projectStatus']."'";
	$conds=$prev ."projects.budgetmin='".$_REQUEST['budget_min']."'";
	$conds=$prev ."projects.budgetmax='".$_REQUEST['budget_max']."'";
	$p_name=$_REQUEST['keyword'];
	$p_status=$_REQUEST['projectStatus'];
	$budget_min=$_REQUEST['budget_min'];
	$budget_max=$_REQUEST['budget_max'];
	$flag=$_REQUEST['featured_jobs'];
	$category=$_REQUEST['new_categories'];
	$_SESSION['owner']=$_REQUEST['owner'];

	$query=array();
	if($_REQUEST['owner']!="Search By Owner" && $_REQUEST['owner']!="")
	{
		$query[]=$prev ."projects.user_id in(select user_id from ".$prev."user where username rlike '".$_REQUEST['owner']."')";
	}
	if($_REQUEST['keyword']!="Search Project" && $_REQUEST['keyword'])
	{
	    $query[]="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
	}
	if($_REQUEST['job_distance']!="By distance" && $_REQUEST['job_distance'])
	{
	    $query[]=$prev ."projects.zip in(".$zip_codes.")";
	}
	if($budget_min!="")
	{
		$query[]=$prev ."projects.budgetmin >='".$_REQUEST['budget_min']."'";
	}
	if($budget_max!="")
	{
		$query[]=$prev ."projects.budgetmax <='".$_REQUEST['budget_max']."'";
	}
	
	if(!empty($flag))
	{
		$query[]=$prev ."projects.special='featured' ";
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
	
	if(!empty($_REQUEST['new_categories']))
	{
		$cat_id= $_REQUEST['new_categories'];
	  	$query[]=$prev."projects_cats.cat_id=".$cat_id. ") ";
	}
	if(!empty($_REQUEST['biddingEnds']) )
	{
	   $dt=$_REQUEST['biddingEnds'];
		//$dt=strtotime($dt);
		$query[]=" date_format( FROM_UNIXTIME(".$prev ."projects.expires ) , '%Y%m%d' )='$dt' ";
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
	$query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";
	//die($query);
	$result=mysql_query($query);
    
}
//--------------------------
//End for advance search

$pa=1;

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
	
	/*if($num_bids > 0)
	{
		$num_bids=$num_bids;
	}
	else
	{
		$num_bids='&nbsp;Bid&nbsp;Now!&nbsp;';
	}*/
	
	
	//////////////////////////////////////////// select bids //////////////////////////////////////////////////	
			$rr=mysql_query("select * from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id]);
			
			$txt="";
			while($dd=@mysql_fetch_array($rr)):
			  $txt.=$dd[cat_name] . " , ";
			endwhile;
			if($txt!=""){
			$jobtype=substr($txt,0,-2);
			}
			else
			{
			  $jobtype="not defined";
			}
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
	?>
	
	<?
	if($row[special]== "featured")
	{
		$fjobs="&nbsp;<img src='images/featured.gif' alt='Featured Project!' border=0>";
	}
	else
	{
		$fjobs="&nbsp;";
	}
	?>
	
	  <tr class="<?php echo $ca;?>">
		<td width="290" class="sm bdn"><p><a href="<?=$vpath?>project-dtl.php?id=<?php print $row[id];?>" style="text-decoration:none; color:#a1282c;"><?php echo $row['project'];?></a><?php echo $fjobs;?></p><p><span><?=ucwords(getusername($row["user_id"]));?> | Budget : <?=$budget_array[$row[budget_id]]?></span></p> </td>
		<td width="60" class="tdm" style="padding-left:10px;" ><?php echo $num_bids;?> </td>
	   <!-- <td width="99" class="tdm">$ 3000.00</td>-->
		<td width="200" class="tdm"><?php echo $jobtype;?></td>
		<td width="130" class="tdm" style="padding-left:40px;" ><?php echo $avgbids;?></td>
		<td width="150" class="tdm ">
		
		
		<?php
		
		//echo $row['id'];
		
		
					$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open' and ".$prev."projects.id='".$row['id']."'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";
					$result1=mysql_query($query);
						
						$secondsPerDay = ((24 * 60) * 60);
				
						$timeStamp = $result1["date2"];
						$timeStamp2 = time();
				
						$daysUntilExpiry = $result1["expires"];
						$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);
				
						echo genDate($daysUntilExpiry);
				
						if ((($daysUntilExpiry - $timeStamp2)/$secondsPerDay)<1 && (( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)>=0)
						{
							echo " (&nbsp;less than a day left&nbsp;)";
						}
						elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)
						{
						   echo " (&nbsp;" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) . " day";
						   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)
						   {
							  echo " ' s";
						   }
						   echo " left&nbsp;)";
						}
						else
						{
						   echo "<font color=red>(&nbsp;expired&nbsp;)</font>";
						}
						?>		</td>
       <td width="100" class="tdm" align="center" >
             <div style="padding-left:40px;">
            <?php
    if($row[user_id]!=$_SESSION[user_id])
	{
	?><a href="bid.php?id=<?php print base64_encode($row['id']);?>"><input type="button" name="bid" id="bid" value="Bid" class="submit_bott"  /></a><?php
	}
	else
	{
	?><input type="button" name="bid" id="bid" value="Bid" class="submit_bott1"  /><?php
	}
	?>
	</div>        </td>
	  </tr>
	 <?php
	 $pa++;
	 }
}
else
{	 
 ?>
 
 <tr>
 	<td colspan="6">
	<div style="height:50px;"></div>
	
	
	
	<div style="height:50px;"></div>	</td>
 </tr>
 <?php
 }
 ?>
 <?php
 if($total_pages>25)
 {
 ?> 
 <tr >
 <td colspan="6" >
 
 <div style="">
<?=pagination(3,"search.php",$parameter,25,$_REQUEST[page],$total_pages,$table_id="",$tbl_name="")?>
</div> </td>
 </tr>
 <?php
 }
 ?> 

<!-- End Replacing include -->
  </table>    </td>
</tr>



<tr><td colspan="6" class="btbrd2"></td></tr>
</table>

</div>



</div>



</div>

<!--end content-->



</div>

</div>





   </div>

<!--end content-->





</div>

</div>





<?php include 'includes/footer.php';?> 

</body>

</html>