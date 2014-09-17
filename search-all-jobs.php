<?php $current_page="All Jobs"; ?>
<?php
include("include/header.php");
?>
<?php
include("include/header_menu.php");
?>

<?php
include("country.php");
?>
<?php

$no_of_records=5;

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

	

	if(!empty($_GET['cat_id']))

	{

		$cat_id= $_GET['cat_id'];

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

	//echo $query1;

	

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

	//echo $query;

	$result=mysql_query($query);

	

			//$q="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  ".$prev ."projects.status='open' " . $cond . " group by " . $prev . "projects.id";

			//$r=mysql_query($q);

			# total projects

			//$total_pages = @mysql_num_rows($r);

			# list of projects

			//$result1=mysql_query($q. " ORDER BY " . $prev . "projects.date2 desc Limit 0,25");

			//$total_res=mysql_num_rows($result1);

			$pa=1;

			$start_pg=($_REQUEST['page']-1)* $no_of_records;

			if($start_pg<0)

			$start_pg=0;

			$end_pg=$start_pg+$no_of_records;

			if($no_of_records>$total_pages)

			$end_pg=$total_pages;

	?>
    
<!------Start-middle-------->
<div class="inner-middle">
<div class="dash_headding">
<h1>Live Projects</h1>
<!--<table width="75%" border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1%" height="23">&nbsp;</td>
    <td width="79%"><div class="serach_panne2">
        	<select name="style2" class="selectyze3">
              <option>Project</option>
              <option>Project</option>
            </select>
            <input type="text" class="search_input2" onfocus="if(this.value=='Search Keywords')this.value='';" onblur="if(this.value=='')this.value='Search Keywords';" value="Type search keywords" size="50" />
           <input name="" type="button" value="" class="search_bnt1"/>
        </div></td>
    <td width="20%">&nbsp;</td>
  </tr>
</table>-->

<div class="clear"></div>
</div>

<div class="clear"></div>



<!--Dashboard Left Start-->
<div class="profile_left"><div class="arrowlistmenu">

<h3 class="menuheader expandable selected" lang="en">All Categories</h3>
<ul class="categoryitems">
<table  width="201" border="0" cellspacing="0" cellpadding="0" class="leftmenu_tab" style="border-bottom:#CCCCCC 1px solid;">
  <tr>
    <td width="16">&nbsp;</td>
    <td width="185" align="left">
      <h1>
        <?php

   $r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");

	while($d=mysql_fetch_array($r))

	{
	?>
<a href="search-all-jobs.php?cat_id=<?php echo $d['cat_id'];?>&projectStatus=<?php echo $_REQUEST['projectStatus']; ?>&budget_min=<?php echo $_REQUEST['budget_min']; ?>&budget_max=<?php echo $_REQUEST['budget_max']; ?>"><?php print $d['cat_name'];?></a><br />
<?php
}
?>
    </h1></td>
    </tr>
  <tr>
    <td height="15"></td>
    <td align="left"></td>
    </tr>
</table>
</ul>

<h3 class="menuheader expandable selected" lang="en">All Job Types</h3>
<ul class="categoryitems">
<table  width="201" border="0" cellspacing="0" cellpadding="0" class="leftmenu_tab" style="border-bottom:#CCCCCC 1px solid;">
  <tr>
    <td width="16">&nbsp;</td>
    <td width="185" align="left">
     <h1><a href="#" lang="en">Fixed Price</a><br />
      <a href="#" lang="en">Hourly</a><br />
       </h1></td>
    </tr>
  <tr>
    <td height="15"></td>
    <td align="left"></td>
    </tr>
</table>
</ul>

<h3 class="menuheader expandable selected" lang="en">Hourly Rate</h3>
<ul class="categoryitems">
<table  width="201" border="0" cellspacing="0" cellpadding="0" class="leftmenu_tab" style="border-bottom:#CCCCCC 1px solid;">
  <tr>
    <td width="16">&nbsp;</td>
    <td width="185" align="left"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="6%">$</td>
        <td width="19%"><input class="leftmenu_input" name="" type="text" style="width:30px;" /></td>
        <td width="16%" align="center" lang="en">to $</td>
        <td width="18%"><input class="leftmenu_input" name="" type="text" style="width:30px;" /></td>
        <td width="5%">&nbsp;</td>
        <td width="36%"><input type="button" class="budget_bott" value="OK" /></td>
      </tr>
    </table>
     <h1>&nbsp;</h1></td>
    </tr>
  <tr>
    <td height="15"></td>
    <td align="left"></td>
    </tr>
</table>
</ul>


<h3 class="menuheader expandable selected" lang="en">Budget</h3>
<ul class="categoryitems">
<table  width="201" border="0" cellspacing="0" cellpadding="0" class="leftmenu_tab" style="border-bottom:#CCCCCC 1px solid;">
  <tr>
    <td width="16">&nbsp;</td>
    <td width="185" align="left"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td width="6%">$</td>
        <td width="19%"><input class="leftmenu_input" name="" type="text" style="width:30px;" /></td>
        <td width="16%" align="center" lang="en">to $</td>
        <td width="18%"><input class="leftmenu_input" name="" type="text" style="width:30px;" /></td>
        <td width="5%">&nbsp;</td>
        <td width="36%"><input type="button" class="budget_bott" value="OK" /></td>
      </tr>
    </table>
     <h1>&nbsp;</h1></td>
    </tr>
  <tr>
    <td height="15"></td>
    <td align="left"></td>
    </tr>
</table>
</ul>


<h3 class="menuheader expandable selected" lang="en">By Time Left</h3>
<ul class="categoryitems">
<table  width="201" border="0" cellspacing="0" cellpadding="0" class="leftmenu_tab" style="border-bottom:#CCCCCC 1px solid;">
  <tr>
    <td width="16">&nbsp;</td>
    <td width="185" align="left">
     <h1>
     <a href="#" lang="en">Less then 24 hours</a><br />
    <a href="#" lang="en"> Less then 3 days</a><br />
     <a href="#" lang="en">Less then  7 days</a><br />
       </h1></td>
    </tr>
  <tr>
    <td height="15"></td>
    <td align="left"></td>
    </tr>
</table>
</ul>


<h3 class="menuheader expandable selected" lang="en">By Posted Date</h3>
<ul class="categoryitems">
<table  width="201" border="0" cellspacing="0" cellpadding="0" class="leftmenu_tab" style="border-bottom:#CCCCCC 1px solid;">
  <tr>
    <td width="16">&nbsp;</td>
    <td width="185" align="left">
     <h1>
     


     <a href="#" lang="en">Posted within 24 hours</a><br />
    <a href="#" lang="en">Posted within 3 days</a><br />
     <a href="#" lang="en">Posted within  7 days</a><br />
       </h1></td>
    </tr>
  <tr>
    <td height="15"></td>
    <td align="left"></td>
    </tr>
</table>
</ul>


<h3 class="menuheader expandable selected" lang="en">Language</h3>
<ul class="categoryitems">
<table  width="201" border="0" cellspacing="0" cellpadding="0" class="leftmenu_tab" style="border-bottom:#CCCCCC 1px solid;">
  <tr>
    <td width="16">&nbsp;</td>
    <td width="185" align="left">
         	<select name="style2" class="selectyze6">
          <option lang="en">Select</option>
          <option lang="en">All</option>
        </select></td>
    </tr>
  <tr>
    <td height="15"></td>
    <td align="left"></td>
    </tr>
</table>
</ul>


<h3 class="menuheader expandable selected" lang="en">Country</h3>
<ul class="categoryitems">
<table  width="201" border="0" cellspacing="0" cellpadding="0" class="leftmenu_tab" style="border-bottom:#CCCCCC 1px solid;">
  <tr>
    <td width="16">&nbsp;</td>
    <td width="185" align="left">
         	<select name="style2" class="selectyze6">
          <option lang="en">Select</option>
          <option lang="en">All</option>
        </select></td>
    </tr>
  <tr>
    <td height="15"></td>
    <td align="left"></td>
    </tr>
</table>
</ul>

</div></div>



<!--Dashboard Left End-->

<?php
if(isset($_REQUEST['page']))
{
$p=$_REQUEST['page'];
}
else
{
$p=1;
}
?>
<!--Dashboard Right Start-->
<div class="profile_right">
  <div class="latest_worbox">
<div class="project_box"><table align="center" width="99%" border="0" cellspacing="0" cellpadding="0" class="tab_box" >
  <tr>
    <td width="54%"><p>&nbsp;&nbsp;(<?php print (($p - 1) * $no_of_records)+1;?> - <?php $np=(($p - 1) * $no_of_records)+ $no_of_records;
	if($total_pages >$np) {
	print $np;}else {  echo $total_pages;}?> <span lang="en">of</span> <?php print $total_pages;?> <span lang="en">results)</span> </p></td>
    <td width="3%" align="center" valign="bottom"><img src="images/subscribe-_icon.png" width="18" height="18" /></td>
    <td width="18%"><p><a href="#" lang="en">Subscribe</a></p></td>
    <td width="7%"><span lang="en">Sort By</span> :</td>
    <td width="18%">         	<select name="style2" class="selectyze7">
          <option lang="en">Select</option>
          <option lang="en">All</option>
        </select></td><td width="0%"></td>
  </tr>
</table>
</div>
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="12"></td>
  </tr>
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

			  $txt.= "<a href='search-all-jobs.php?cat_id=$dd[cat_id]' style='margin:3px;'>".$dd[cat_name] . "</a>";

			}



			if($txt!="")

			//$jobtype=substr($txt,0,-2);			
$jobtype=$txt;
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

							$fjobs='<img src="images/featured.png"  style=" position:absolute; padding-left:2px;" />';

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

							$datleft = " &nbsp;less than a day left&nbsp;";

						}

						elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)

						{

						  $datleft = " &nbsp;" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) . " day";

						   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)

						   {

							 $datleft .= "s";

						   }

						   $datleft .= " left&nbsp;";

						}

						else

						{

						   $datleft = "<font color=red>&nbsp;expired&nbsp;</font>";

						}

$rw=mysql_fech

	?>   

   

  <tr>
    <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border-bottom:#e4e6eb 1px solid;" class="tab_box" >
      <tr>
        <td><p><span><a href="<?php print $vpath?>project-dtl.php?id=<?php print $row[id];?>" ><?php echo ucwords($row['project']);?></a></span></p></td>
      </tr>
      <tr>
        <td><p><span lang="en">Fixed Price</span>: <?php print $budget_array[$row[budget_id]]?>  | <span lang="en">Posted</span>: <?php print date('d-m-Y',strtotime($row[creation]));?>  |  <span lang="en">Ends</span>: <?php print $datleft; ?>  | <a href="<?php print $vpath?>project-dtl.php?id=<?php print $row[id];?>"><strong><?php echo $num_bids;?></strong><span lang="en" style="font-size:12px;"> Proposals</span></a></p></td>
      </tr>
      <tr>
        <td><h2><?php if(strlen($row['description'])>250){echo substr($row['description'],0,250).'...';} else {echo $row['description'];} ?></h2></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td valign="top" width="40%" align="right"><span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#0099FF;padding-top:4px; margin-top:15px;" lang="en">Skill Required</span> <span style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#0099FF;padding-top:4px; margin-top:15px; "> :</span></td>
            <td width="80%" colspan="2">  <div class="edit_bott2"><?php print $jobtype;?></div></td>
         </tr>
        </table></td>
      </tr>
      <tr>
        <td height="12"></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
        <?php 

  	$buyer_info = mysql_fetch_array(mysql_query("select user_id,username,country from ".$prev."user where user_id=".$row[user_id]));	

  ?>
          <tr>
        <td  align="left" width="7%" valign="middle"><h3 lang="en">Posted by</h3></td>
            <td width="43%" align="left"><h3><a href="publicprofile.php?id=<?php print base64_encode($buyer_info[user_id]);?>">&nbsp;&nbsp;<?php print ucwords($buyer_info[username]);?></a></h3></td>
            <td width="3%" valign="middle"><img src="cuntry_flag/<?php print strtolower($buyer_info[country]);?>.png" title="France" width="16" height="11" > </td>
            <td width="41%"><?php print $country_array[$buyer_info[country]];?></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="12"></td>
  </tr>
  <?php
  }
  }
  ?>
 
 
  <tr>
    <td><div class="pagination">
          <?php
			if($total_pages>$no_of_records)
			{
			
			echo "<div align=right>" .new_pagingnew(0,$vpath.'search-all-jobs.html?page=','',$no_of_records,$_REQUEST['page'],$total_pages,$table_id='',$tbl_name='') . "</div>";}?>
          </div></td>
  </tr>
  <tr>
    <td height="30"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="52%">&nbsp;</td>
    <td width="48%"><img src="images/four_squares.jpg" width="356" height="164" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</div>






</div>
<!--Dashboard Right End-->


</div>


<!------end_middle-------->
<?php
include("include/footer.php");
?>