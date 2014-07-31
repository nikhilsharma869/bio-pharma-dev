<?php 
include "includes/header.php"; 
CheckLogin();
	//CheckLogin();
	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
	
	
	if(isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput']!="")
	{//echo $_REQUEST['categoryinput'];die();
		if($_REQUEST['categoryinput']!=0)
		{
			$categoryinput=$_REQUEST['categoryinput'];
			header("location:home.php?cat_id=$categoryinput&categoryform#");
		}
		else
		{
			$categoryinput=$_REQUEST['categoryinput'];
			header("location:home.php?categoryform#");
		}	
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php print $setting[meta_keys];?>" />
<meta name="description" content="<?php print $setting[meta_desc];?>" /> 
<title><?php print $setting[site_title];?></title>
<link rel="stylesheet" href="css/style.css"/>
<link rel="shortcut icon" href="images/favicon.ico">
		
</head>

<body>
<div id="container">
<!-----------Header----------------------------->
<?php include 'includes/header.php';?> 
<!-----------Header End----------------------------->
<div class="clear"></div>
<!-- content-->
<div id="content">
	<div class="main_head">
    <!-- main head left part-->
<!--////////////////////////////////////////////////////////////////////////// Find your jobs category  Z-index part ///////////////////////////////////-->	
	<div align="left" style="height:75px; width:413px; z-index:1px;   margin:232px 0 0 11px; position:absolute; ">
	   
	    <h3 class="jc">Find Your job Category</h3>
        <h2 class="scat">
		<script type="text/javascript">
function funonchangecategory(val)
{
	document.getElementById("categoryinput").value = val;
	if(document.getElementById("categoryinput").value != "")
	{
		document.categoryform.submit();	
	}
}


</script>
<form name="categoryform" id="categoryform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<?php
	
	$r1=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
	
	?>
		
        <select name="category" class="stl" onchange='funonchangecategory(this.value);'>
        	<option value="0">All&nbsp;</option>
			<?php
			while($d1=mysql_fetch_array($r1))
			{
			?>
			<option value="<?php echo $d1['cat_id'];?>"<?php if($_REQUEST['cat_id']==$d1['cat_id']){echo "selected";}?>><?php echo $d1['cat_name'];?></option>
			<?php
			}
			?>
        </select>
		
		 <input name="categoryinput" type="hidden" id="categoryinput" />
		</form>
        </h2>
	   
	   </div>
	   
<!--////////////////////////////////////////////////////////////////////////// Find your jobs category ///////////////////////////////////-->		   
	
    	<div style="width:413px; height:407px; float:left; margin:20px 0px 0px 10px;">
        	<h1 class="hl">Hire online for a
fraction of the cost!</h1>
		<ul>
        	<li class="cap"><span>Outsource anything you can think of!</span></li>
            <li class="cap"><span>Projects start at $30 and the average job is under $200</span></li>
            <li class="cap"><span>Programmers, designers, content writers are ready now!</span></li>
            <li class="cap"><span>Only pay freelancers once you are happy with their work</span></li>
        </ul>
        <hr />
<!--////////////////////////////////////////////////////////////////////////// Find your jobs category ///////////////////////////////////-->		
       <div style="height:75px;"></div>
<!--////////////////////////////////////////////////////////////////////////// Find your jobs category ///////////////////////////////////-->	   
        <p style="text-align:center; margin:6px 0px 0px 0px;"><img src="images/post_job_btn.png" /></p>
        </div>
        
        
        
        <div style="width:438px; height:407px; float:left; margin:20px 0px 0px 50px;"><img src="images/header.gif" /></div>
         <div class="clear"></div>
    </div>
    <!-- end main head left part-->
    <!-- main haed right part-->
    
     <!-- end main haed right part-->
    <div class="clear"></div>
    
    <!-- category sec-->
    <div id="category">
<?php
	if($_REQUEST['cat_id']!="")
	{
		$r=mysql_query("select * from " . $prev . "categories  where cat_id=".$_REQUEST['cat_id']." and status='Y' order by cat_name");
	}
	else
	{
		$r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
	}
	?>
	
    <div id="category">
    <table width="980" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="6" style="border-bottom:2px solid #99CCCC; padding:10px 0px 10px 0px;"><h3>Jobs Category</h3></td>
    
  </tr>
   <?php
    while($d=mysql_fetch_array($r))
    {
	?>
 <tr>
    <td colspan="6" style="padding:10px 0px 10px 0px; letter-spacing:0.5px;"><p><?php echo $d['cat_name'];?></p></td>
    
  </tr>
  	<?php
	//	$rr=mysql_query("select * from " . $prev . "categories where parent_id='".$d['cate_id']."' and status='Y' order by cat_name");
	?>
  <tr valign="top">
    <td>
	
		<?php
					
					$select_skills="select * from " . $prev . "categories where parent_id='".$d['cat_id']."' and status='Y' order by cat_name";
					$rec_skills=mysql_query($select_skills);
					$num_skills=mysql_num_rows($rec_skills);
					if($num_skills > 0)
					{
						$a=1;
						?>
						<div style="width:242px; float:left;">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<?php
							if($num_skills >= 4)
							{
								$cou=$num_skills/4;
								$a1=(int)$cou;
							}
							else
							{
								$a1=1;
							}
						while($row_skills=mysql_fetch_array($rec_skills))
						{
							$select_count_project="select " . $prev . "projects_cats.*," . $prev . "projects.* from " . $prev . "projects_cats," . $prev . "projects where " . $prev . "projects_cats.cat_id='".$row_skills['cat_id']."' and " . $prev . "projects_cats.id=" . $prev . "projects.id and " . $prev . "projects.status='open'";
							$rec_count_project=mysql_query($select_count_project);
							$num_count_project=mysql_num_rows($rec_count_project);
						?>
							 <tr>
								<td width="20" class="cblt" valign="top">&nbsp;</td>
								<td width="176" class="ctxt" valign="top"><a href="details.php?cat_id=<?php echo $row_skills['cat_id'] ?>" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; font-style:normal; font-weight:normal; text-decoration:none;"><?php echo $row_skills['cat_name'];?>.&nbsp;(<?php echo $num_count_project;?>)</a></td>
							  </tr>
						<?php
							if($a == $a1)
							{
								echo "</table>";
								echo "</div>";
								echo "<div style=\"width:243px; float:left;\">
							<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
							$a=0;	
							}
						$a++;	
						}
						?>
						</table>
						</div>
					<?php
					}
					else
					{
					?>
						<td style="padding:2px 9px 2px 2px;">
							<div style=" width:220px; margin:0 8px 0 0;  float:left; border:1px solid #CCCCCC;  line-height:25px;  font-weight:bold;">
							<div style="height:20px;">
							</div>
							<div align="center" style="color:#999999; font-size:10px;">
							Category not found..
							</div>
							<div style="height:20px;">
							</div>
							</div>
						</td>
					<?php
					
					}
					?>		
	
	
		<!--<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="196">
				<table width="196" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="20" class="cblt">&nbsp;</td>
			<td width="176" class="ctxt">Article Writing(1)</td>
		  </tr>
		  <tr>
			<td width="20" class="cblt">&nbsp;</td>
			<td width="176" class="ctxt">Blogs(1)</td>
		  </tr>
		  <tr>
			<td width="20" class="cblt">&nbsp;</td>
			<td width="176" class="ctxt">Bulk Mailing(2)</td>
		  </tr>
		  <tr>
			<td width="20" class="cblt">&nbsp;</td>
			<td width="176" class="ctxt">Event Planning(1)</td>
		  </tr>
		  <tr>
			<td width="20" class="cblt">&nbsp;</td>
			<td width="176" class="ctxt">Medical Billing/Coding(1)</td>
		  </tr>
		</table>
		
			</td>
		</tr>
		</table>-->
	</td>
  </tr>
  <?php
  }
  ?>
</table>
<!--end first table-->

<!-- end second table-->

<!-- end third table-->

<!-- end four table-->

<!-- end four table-->
    </div>
     <!--end category sec-->
     <div class="clear"></div>
     <!-- job listing chart-->
     <div>
     <div class="pbsection4">
          
          <ul id="tab" class="tab">
			<li class="active"><a href="#description">Latest Jobs </a></li>
			<li><a href="#usage">Featured Jobs</a></li>
            <li><a href="#usage2">All Jobs </a></li>
            <li><a href="#usage3"> Ending Soon</a></li>
            
		</ul>
		<div id="description" class="content1">
			<table width="980" border="0" cellspacing="0" cellpadding="0"  >
            <tr><td colspan="6" class="btbrd"></td></tr>
			
<!--///////////////////////////////////////////////////////// start latest jobs ////////////////////////////////////////////////////////////////-->			
		
 <tr>
    <td class="thtxt">Project Name</td>
    <td class="thtxt">Bid</td>
    <td class="thtxt" align="center">Job Type</td>
    <td class="thtxt" align="center">Avg Bid</td>
    <td class="thtxt"  align="center">Time Left</td>
    <td class="thtxt">Action</td>
  </tr>

 <tr>
    <td colspan="6" >
	
	<?php
	include("latestjobs.php");
	?>
	
	</td>
  </tr>

<!--///////////////////////////////////////////////////////// end latest jobs ////////////////////////////////////////////////////////////////-->	

  
  <tr><td colspan="6" class="btbrd2"></td></tr>
</table>

         </div>
		<div id="usage" class="content1">
			<table width="980" border="0" cellspacing="0" cellpadding="0"  >
            <tr><td colspan="6" class="btbrd"></td></tr>
 <tr>
    <td class="thtxt">Project Name</td>
    <td class="thtxt">Bid</td>
    <td class="thtxt" align="center">Job Type</td>
    <td class="thtxt" align="center">Avg Bid</td>
    <td class="thtxt" align="center">Time Left</td>
    <td class="thtxt">Action</td>
  </tr>
   <tr>
    <td colspan="6" >
	
	<?php
	include("featuredjobs.php");
	?>
	
	</td>
  </tr>
 
<tr><td colspan="6" class="btbrd2"></td></tr>
</table>
		</div>
        <div id="usage2" class="content1">
			<table width="980" border="0" cellspacing="0" cellpadding="0"  >
            <tr><td colspan="6" class="btbrd"></td></tr>
 <tr>
    <td class="thtxt">Project Name</td>
    <td class="thtxt">Bid</td>
    <td class="thtxt" align="center">Job Type</td>
    <td class="thtxt" align="center">Avg Bid</td>
    <td class="thtxt" align="center">Time Left</td>
    <td class="thtxt">Action</td>
  </tr>
   <tr>
    <td colspan="6" >
	
	<?php
	include("alljobs.php");
	?>
	
	</td>
  </tr>
 <tr><td colspan="6" class="btbrd2"></td></tr>
</table>
		</div>
        <div id="usage3" class="content1">
		<table width="980" border="0" cellspacing="0" cellpadding="0"  >
        <tr><td colspan="6" class="btbrd"></td></tr>
 <tr>
  <td class="thtxt">Project Name</td>
    <td class="thtxt">Bid</td>
    <td class="thtxt"  align="center">Job Type</td>
    <td class="thtxt"  align="center">Avg Bid</td>
    <td class="thtxt" align="center">Time Left</td>
    <td class="thtxt">Action</td>
  </tr>
   <tr>
    <td colspan="6" >
	
	<?php
	include("endingsoon.php");
	?>
	
	</td>
  </tr>
  <tr><td colspan="6" class="btbrd2"></td></tr>
</table>
		</div>

		
     	<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			// <![CDATA[
				
			$(document).ready(function () {
				$('#tab').tabify();
				
			});
					
			// ]]>
		</script>
          
          
         </div>	
     </div>
     <div class="clear"></div>
     <p style="font-size:12px; color:#002541; margin:0px 0px 20px 0px; padding-top:10px;">IT Outsourcing Services is a KPO and BPO freelance service One Outsource provider that offers one stop solution by finding IT- solutions to your most pressing needs. We provide high quality, time bound, cost effective outsourcing IT services through our offshore outsourcing services facilities in India. Changing and challenging IT business environment and technological and legislative changes act as a catalyst to this trend. Payment for freelance work also varies greatly. By custom, payment arrangements may be upfront, percentage upfront, or upon completion.</p>
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

<!-- Mirrored from easy2remind.com/designs/freelancerclone/ by HTTrack Website Copier/3.x [XR&CO'2010], Tue, 29 Nov 2011 15:08:32 GMT -->
</html>
