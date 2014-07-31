<?php 
	include "configs/path.php"; 
	include("country.php");
//CheckLogin();


	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Browse Projects</title>
<link rel="stylesheet" href="css/style.css"/>
<link rel="shortcut icon" href="images/favicon.ico">
<style type="text/css">
/*....................................................................navi_style....................................................................*/
.glossymenu{
	position: relative;
	list-style: none;
}
.glossymenu li{
	float:left;
	padding-right:10px;
}
.glossymenu li a{
	float:left;
	display:block;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	font-weight:normal;
	color:#FFFFFF;
	background:url(images/header-tab-left2.jpg);
	background-repeat:no-repeat;
	font-style:normal;
	text-decoration:none;
	padding:0px 0px 0px 13px; /*Padding to accomodate left tab image. Do not change*/
	line-height:32px;
	cursor: pointer;	
}
.glossymenu li a b{
	float: left;
	display: block;
	background:url(images/header-tab-right2.jpg);
	background-repeat:no-repeat;
	background-position:right;
	padding-left:8px;
	padding-right:15px; /*Padding of menu items*/
	height:32px;
}
.glossymenu li.current a, .glossymenu li a:hover{
    color:#FFFFFF;
	background:url(images/header-tab-left3.jpg);
	background-repeat:no-repeat;
	background-position:left top;
}
.glossymenu li.current a b, .glossymenu li a:hover b{
	background:url(images/header-tab-right3.jpg);
	background-position:right top;
}
/*....................................................................navi_style....................................................................*/



.marketplace {
    background-color: #E9F3FB;
    border-radius: 6px 6px 6px 6px;
    color: #111111;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: bold;
    line-height: 20px;
    padding: 6px;
    text-decoration: none;
}
.bid_heading_txt {
    color: #6BB528;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 22px;
    font-style: normal;
    font-weight: normal;
    line-height: 45px;
    padding-left: 6px;
    text-decoration: none;
}
</style>

<div class="clear"></div>
<!-- content-->
<div id="content">
	<div id="about_cotent">
    <!--leftside-->
   
    <!-- left side-->
    <!-- rightside-->
	
	
	
	
	
	
    <div style="margin:20px 0 10px 0;" class="">
	
	
		<div style='padding-left:10px;padding-right:10px; '>

<!--/////////////////////////////////////////////////////////////// start search section  ///////////////////////////////////////////////////-->
			
		
<script language="javascript" type="text/javascript">
function showDiv(){
//alert('test');
if(document.getElementById("new_id").style.display=='none')
{
document.getElementById("new_id").style.display='block';
//document.getElementById("adv_search").style.display='none';
}
else
{
document.getElementById("new_id").style.display='none';
}

}
function doSubmit()
{
 document.myform.submit();
 

}

function clear1()
{
document.myform.owner.value='';

}
function clear2()
{
document.myform.keyword.value='';

}
</script>
<?

if($_REQUEST['param']):
    $cat_name=str_replace("-"," ",str_replace("and","&",substr($_REQUEST['param'],0,-4)));
    $r=mysql_query("select * from " . $prev . "categories  where cat_name=\"" . $cat_name . "\"");
	//echo "select * from " . $prev . "categories  where cat_name=\"" . $cat_name . "\"";
	if(@mysql_num_rows($r)){$_REQUEST['cat_id']=mysql_result($r,0,"cat_id");}
endif;

if($_REQUEST['cat_id'])
{
require_once("jobs-category-index.php");
}
?><form action="index.php?mode=projects" method="post">
<table align="center" width="96%" border="0">
	<tr>
		<td align="left" class="bid_heading_txt" style="padding-left:6px;">
			<b>
			<?php
			if($_REQUEST['cat_id'])
			{
			$q=mysql_fetch_array(mysql_query("select * from " . $prev . "categories where cat_id='".$_REQUEST['cat_id']."'"));
			echo $q[cat_name]." Jobs";
			}
			
			if($_REQUEST['param']=='featured-jobs')
			{
			//echo 'Browse Featured Jobs';
			$Featured='current';
			}
			
			if($_REQUEST['param']=='latest-jobs')
			{
			//echo 'Browse Latest Jobs';
			$Latest='current';
			}
			if($_REQUEST['search_jobs'])
			{
			echo 'Search Jobs';
			}
			if(!$_REQUEST['param'] && !$_REQUEST['cat_id'] && !$_REQUEST['search_jobs'])
			{
			//echo 'Browse Jobs';
			$Browse='current';
			}
			?>
			</b>
		</td>
		
	</tr>
</table></form>
<div style="display:none;" id="new_id" >
<table width="949" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="6" align="left" valign="top" class="topCarve"></td>
  </tr>
  <tr>
    <td align="left" valign="top "class="middleBg" ><div style="padding:12px 15px 12px 15px; border:1px solid #CCCCCC;" >
    <form action="search.php" method="post" name="myform" >  <table width="100%" border="0" cellspacing="3" cellpadding="3">
        <tr>
          <td align="left" valign="top">
		  <input style="border:1px solid #CCCCCC; width:190px; color:#666666; height:15px;" type="text" name="owner" class="input" <? if (!empty($_REQUEST['owner'])){
		  ?>value="<?=$_REQUEST['owner']?>"<? } else{?>value="Search By Owner" <? } ?> onClick="return clear1()"></td>
          <td align="left" valign="top">
		  
		  <input style="border:1px solid #CCCCCC; width:190px; color:#666666;  height:15px;"   type="text" name="keyword" class="input" <? if ($_REQUEST['keyword']){?>value="<?=$_REQUEST['keyword']?>"<? } else {?>  value="Search Project" <? } ?> onclick="return clear2()"/>
		  
		  
		  </td>
          <td align="left" valign="top"><select style="border:1px solid #CCCCCC; width:190px; color:#666666; padding:2px;"  class="input" name="projectStatus">
           <option value='<?=$_REQUEST['projectStatus']?>' selected style='font-weight: bold'>
			<? if($_REQUEST['projectStatus']){ echo $_REQUEST['projectStatus']; } else{
			echo 'open';}
			?>
			</option>
                            <option value='' >----</option>
                            <option value='all'  style='font-weight: bold'>All</option>
                            <option value='frozen'  style='font-weight: bold'>Frozen</option>
                            <option value='closed'  style='font-weight: bold'>Closed</option>
						    
                            <option value='closed_awarded' >--Awarded</option>
                            <option value='closed_canceled' >--Canceled</option>
          </select></td>
          <td align="left" valign="top"><select style="border:1px solid #CCCCCC; width:190px; color:#666666; padding:2px;" name="new_categories" class="input">
           
                    <option 
					
					value="<?=$res['cat_id'];?>" ><? if($_REQUEST['new_categories']){
					$rs=mysql_query("select cat_name from " . $prev . "categories  where status='Y' and cat_id=".$_REQUEST['new_categories']);
					$cat_name=mysql_result($rs,0,"cat_name");
					echo $cat_name;
					  
					 } else{
					    echo "Categories";
					 }?></option>
						
						<? 
							$r=mysql_query("select * from " . $prev . "categories  where status='Y' order by cat_name");
						    while($res=mysql_fetch_array($r)){
							
							?>
							<option value="<?=$res['cat_id'];?>"><?=$res['cat_name'];?></option>
						   <? } ?>
					
					</select></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><span style="color:#666666;">Budget :</span> <select style="border:1px solid #CCCCCC; width:90px; color:#666666; padding:2px;" name="budget_max" class="input_01">
            
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
            </select> <select style="border:1px solid #CCCCCC; width:90px; color:#666666; padding:2px;" name="budget_min" class="input_01">
                                <option  
								
								value="<?=$_REQUEST['budget_min']?>" ><? if($_REQUEST['budget_min']){ echo '$'.$_REQUEST['budget_min'];} else{
								echo "Min";}
								?></option>
								<option value='250' >$250</option>
								<option value='750' >$750</option>
								<option value='1500' >$1500</option>
								<option value='3000' >$3000</option>
								<option value='5000' >$5000</option>
								</select></td>
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
		  ?><select style="border:1px solid #CCCCCC; width:130px; color:#666666; padding:2px;" name="biddingEnds" class="input">
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
            <input style="border:1px solid #CCCCCC; color:#666666;" type="checkbox" name='f'   <?php if($_REQUEST['f'])
			{?>
			value="<?=$_REQUEST['f']?> " checked="checked"
            <? } 
			else{?> 
			value="1"
			<? } ?>>
			<span style="color:#666666;">Featured</span> 
          </label></td>
          <td align="left" valign="top">
		  <input type="hidden" name="adv_search" value="adv_search"/>
		  <!-- <input type="hidden" name="flag" value="1"/>-->
		  <a href="javascript:doSubmit()"><img src="images/advanced-search.gif" alt="" width="190" height="35" border="0" /></a><div align=right><a href="javascript://"   onClick="document.getElementById('new_id').style.display='none'" class=link style='padding-right:22px;padding-top:10px'>[Close]</div></td>
        </tr>
      </table></form>
    </div></td>
  </tr>
  <tr>
    <td height="6" align="left" valign="top" class="bottomCarve"></td>
  </tr>
</table>
</div>
<?php
	if($_REQUEST['search_jobs'] && ($_REQUEST['search']!=""))
	{
		$cond="where id='".$_REQUEST['search']."' or project='".$_REQUEST['search']."'";		
	}
	if(!$_REQUEST[param]){$_REQUEST[param]="latest-jobs";}
?>

<!--....................MIDDLE START....................-->
<? echo"<table cellpadding=4 cellspacing=0 border=0 align=center width=98% >
	 <td width=600  valign=top style='padding-top:22px'>";?>
<!--<div class="middle_listing_box">
				<div class="middle_listing_up">-->
					<ul class="glossymenu" style="margin-left:0px;">
                  	<li <? if($_REQUEST[param]=="latest-jobs"){echo"class='current'";}?>><a href="<?=$vpath?>search.php?param=latest-jobs"><b style="font-weight:normal;">Latest Jobs</b></a></li>
                  	<li <? if($_REQUEST[param]=="featured-jobs"){echo"class='current'";}?>><a href="<?=$vpath?>search.php?param=featured-jobs"><b style="font-weight:normal;">Featured Jobs</b></a></li>        
                  	<!--<li <? if($_REQUEST[param]=="all-jobs"){echo"class='current'";}?>><a href="<?=$vpath?>projects/all-jobs"><b style="font-weight:normal;">All Jobs</b></a></li>-->
                  	<li <? if($_REQUEST[param]=="ending-jobs"){echo"class='current'";}?>><a href="<?=$vpath?>search.php?param=ending-jobs"><b style="font-weight:normal;">Ending Soon</b></a></li>
				  <!--	<li <? if($_REQUEST[param]=="jobs-by-category" || $_REQUEST[param]=="search-jobs"){echo"class='current'";}?>><a href="<?=$vpath?>projects/jobs-by-category"><b style="font-weight:normal;">Jobs By Category</b></a></li>-->
				  	<!--<li style="float:right;" ><a href="index.php?mode=site-list"><b style="font-weight:normal;">Browse Buy/Sell</b></a></li>-->
                   <li style='float:right;'><a href="javascript://"  id="adv_search" onClick="showDiv()"><b style="font-weight:normal;">Advance Search</b></a></li>
				</ul>
				<!--</div>
				    <div class="middle_listing_middle">
					<div class="middle_listing_T"></div>
					<div class="middle_listing_M">-->
					<table width="100%" border="0" cellspacing="0" cellpadding="0" style='border-top:solid 1px #87b0b1'>
					<tr>
					  <td align="left" valign="top"><!--<img src="images/topCarve.gif" alt="" width="855" height="10" />--></td>
					</tr>
					<tr>
					  <td align="left" valign="top" class="border">
                       <!--<input type="button" value="Advanced Search"  onclick="showDiv()"  />-->
					<?
					if($_REQUEST[param]=="jobs-by-category"):
					   require_once("jobs-by-category.php");
					else:
                       require_once("project-list.php");
                    endif;
					?>
					</td>
						</tr>
						<tr>
						  <td align="left" valign="top"><!--<img src="images/bottomCarve.gif" alt="" width="855" height="12" />--></td>
						</tr>
					  </table>
                   <!-- </div>
   
				</div><div class="middle_listing_L" align=center></div>
				</div>--></td>
	 <td width=300   valign=top style='padding-left:10px' >
	 <table width="100%" border="0" align=center cellspacing="0" cellpadding="0" style="background-color:whitesmoke;" class=marketplace>
<tr><td valign=top class="bid_heading_txt" style="border-bottom:solid 1px #87b0b1;">Marketplace</td></tr>
<tr><td  >---</td></tr></table>
	 
	 
	 </td></table>
	 

<? if($_REQUEST['adv_search'])
{?>
<script>
document.getElementById("new_id").style.display='block';
document.getElementById("adv_search").style.display='none';
</script>

<? } ?>


                 
	
	
	
<!--/////////////////////////////////////////////////////////////// end search section  ///////////////////////////////////////////////////-->	
	
		</div>
    
    </div>
    <!-- end rightside-->
    <div class="clear"></div>
    </div>
  
    <div class="clear"></div>
    
 <!-----------Footer----------------------------->
<?php include 'includes/footer.php';?> 
<!-----------Footer End----------------------------->
     <div class="clear"></div>
      <!-- end job listing chart-->
</div>
<!--end content-->
<div class="clear"></div>
</div>
 </body>
</html>

