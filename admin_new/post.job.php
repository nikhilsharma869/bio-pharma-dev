<?php 
include("includes/header_dashbord.php");
include("includes/access.php");
?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		





        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="project.list.php">Project Management</a></li>
                      <li class="active">Edit Project</li>
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Project Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>Edit Project&nbsp; &nbsp; <?php if($msg){echo  $msg ;} ?> </h4>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#b7b5b5">

<tr class="lnk" bgcolor="#ffffff">
	<td>
	<!--*********************main table start***********************-->
<table cellpadding="4" cellspacing="0" align="center" width="100%">
<tr><td valign=top width=80%>
<table cellpadding=4 cellspacing=0 align=center width=100%>
<tr bgcolor="#e5e5e5"><td class="title"><? if($_REQUEST[edit]){echo"Edit ";}else{echo"Post ";}?> Your Project</td><td align=right class=lnk>* fileds are mandatory </td></tr></table>

<table cellpadding="4" cellspacing="0" align="center" border="0"  width="100%"  class="table table-striped table-bordered table-hover" id="dataTable">
	
<script type="text/javascript">
var persistmenu="no" //"yes" or "no". Make sure each SPAN content contains an incrementing ID starting at 1 (id="sub1", id="sub2", etc)
var persisttype="sitewide" //enter "sitewide" for menu to persist across site, "local" for this page only

if (document.getElementById){ 
document.write('<style type="text/css">\n')
document.write('.submenu{display: none;}\n')
document.write('</style>\n')
}

function SwitchMenu(obj){
	if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv").getElementsByTagName("span"); 
		if(el.style.display != "block"){ 
			for (var i=0; i<ar.length; i++){
				if (ar[i].className=="submenu") 
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}

function get_cookie(Name) { 
var search = Name + "="
var returnvalue = "";
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search)
if (offset != -1) { 
offset += search.length
end = document.cookie.indexOf(";", offset);
if (end == -1) end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}

function onloadfunction(){
if (persistmenu=="yes"){
var cookiename=(persisttype=="sitewide")? "switchmenu" : window.location.pathname
var cookievalue=get_cookie(cookiename)
if (cookievalue!="")
document.getElementById(cookievalue).style.display="block"
}
}

function savemenustate(){
var inc=1, blockid=""
while (document.getElementById("sub"+inc)){
if (document.getElementById("sub"+inc).style.display=="block"){
blockid="sub"+inc
break
}
inc++
}
var cookiename=(persisttype=="sitewide")? "switchmenu" : window.location.pathname
var cookievalue=(persisttype=="sitewide")? blockid+";path=/" : blockid
document.cookie=cookiename+"="+cookievalue
}

if (window.addEventListener)
window.addEventListener("load", onloadfunction, false)
else if (window.attachEvent)
window.attachEvent("onload", onloadfunction)
else if (document.getElementById)
window.onload=onloadfunction

if (persistmenu=="yes" && document.getElementById)
window.onunload=savemenustate
</script>
<script>
function selectbudget(val){
document.getElementById("budget_id").value = val;
}
<!--
function RegValidate(frm)
{
  
    var txt="";
   
    if(!frm.project.value)
	{   
	   txt+="     Project name should not be blank.\n";
	}
	if(!frm.category.value)
	{
	   txt+="     Category should not be blank.\n";
	}
	if(!frm.description.value) 
	{
	   txt+="     Description should not be blank.\n";
	}
	if(!frm.budget_id.value) 
	{
	   txt+="     Budget should not be blank.\n";
 	}
	if(!frm.cdays.value) 
	{
	   txt+="     Bidding days should not be blank.\n";
 	}
	if(frm.featured.checked==true) 
	{
	   <?
	   $tyress = mysql_query("SELECT * FROM " . $prev . "transactions WHERE user_id='" . $_SESSION[user_id] . "' AND type='buyer' ORDER BY date2 DESC LIMIT 0,1");
	   $bal = @mysql_result($tyress,0,"balance");
	   if($bal<$setting[featuredcost]):
	   ?>
	   	   txt+="     You have not enough balance to cover the featured project fee $<?=$setting[featuredcost]?>.\n";
	   <?
	   endif;
	   ?>	   
 	}
	if(txt)
	{
   	  alert("Sorry!! Following errors has been occured :\n\n"+ txt +"\n     Please Check");
  	  return false
	}
    return true	
} 
//-->
</script>
<script>
<!--

function EditValidate(frm)
{
  
    var txt="";
   
    if(!frm.info.value)
	{   
	   txt+="     Aditional Information should not be blank.\n";
	}
	
	if(frm.featured.checked==true) 
	{
	   <?
	   $tyress = mysql_query("SELECT * FROM " . $prev . "transactions WHERE user_id='" . $_SESSION[user_id] . "' AND type='buyer' ORDER BY date2 DESC LIMIT 0,1");
	   $bal = @mysql_result($tyress,0,"balance");
	   if($bal<$setting[featuredcost]):
	   ?>
	   	   txt+="     You have not enough balance to cover the featured project fee $<?=$setting[featuredcost]?>.\n";
	   <?
	   endif;
	   ?>	   
 	}
	if(txt)
	{
   	  alert("Sorry!! Following errors has been occured :\n\n"+ txt +"\n     Please Check");
  	  return false
	}
    return true	
} 
//-->
</script>
<?php

if($_REQUEST['submit']=='Update Project')
{
 $project=$_REQUEST['project'];
 $budget_id=$_REQUEST['budget_id'];
 $cdays=$_REQUEST['cdays'];
 $featured=$_REQUEST['featured'];

 if($_REQUEST['budget_id']=="1")
		{
		   $budgetmin="250";
		   $budgetmax="250";
		
		}
		if($_REQUEST['budget_id']=="2")
		{
		   $budgetmin="250";
		   $budgetmax="500";
		
		}
		if($_REQUEST['budget_id']=="3")
		{
		   $budgetmin="500";
		   $budgetmax="1000";
		
		}
		if($_REQUEST['budget_id']=="4")
		{
		   $budgetmin="1000";
		   $budgetmax="2500";
		
		}
		if($_REQUEST['budget_id']=="5")
		{
		   $budgetmin="2500";
		   $budgetmax="5000";
		
		}
		if($_REQUEST['budget_id']=="6")
		{
		   $budgetmin="5000";
		   $budgetmax="10000";
		
		}
		if($_REQUEST['budget_id']=="7")
		{
		   $budgetmin="10000";
		   $budgetmax="25000";
		
		}
		if($_REQUEST['budget_id']=="8")
		{
		   $budgetmin="above $25000";
		  
		
		}
		if($_REQUEST['budget_id']=="9")
		{
		   $budgetmin="not sure";
		  
		
		}
   $q="update ". $prev . "projects set project='".$project."',budget_id=".$budget_id.",budgetmin='".$budgetmin."',budgetmax='".$budgetmax."',ctime='".$cdays."' where id=".$_REQUEST[id];

$d=mysql_query($q);
	$user_id=$_REQUEST['user_id'];
	$id=$_REQUEST['id'];

	if($d)
	{
		header("location:project.list.php?user_id=$user_id&msg=Data updated successfully..");
	}
	else
	{
		header("location:project.list.php?user_id=$user_id&id=$id&msg=Try again..");
	}

}
?>

<form name="pedit" method="post" action="" onSubmit="javascript:return EditValidate(this);">

<input type="hidden" name="id" value="<?=$_REQUEST[id]?>" />
<input type="hidden" name="user_id" value="<?=$_REQUEST[user_id]?>" />
<?

	$d=mysql_fetch_array(mysql_query("select * from  " . $prev . "projects where id=" . $_REQUEST[id] . ""));
	
	?>
	<tr class="form-group">
		<td><b>Project Name:*</b></td><td>
		<INPUT type='text' name='project' size='35' value="<?=$d[project]?>" />
		</td>
	</tr>
		<tr class="form-group">
		<td><b>Buyer:*</b></td><td>
		
		<?
		  $rr=mysql_query("select * from " . $prev . "user where user_id='" . $d[user_id] . "'");
	      $buyer=@mysql_result($rr,0,"username");
		   echo"<a href='edit.member.php?user_id=" . $d[user_id] . "' class=lnk>" . $buyer . "</a>";
		?>
		</td>
	</tr>
	<?php
		$rr=mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $d[id]);
		//print("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $d[id]);
		$txt="";
		while($cat=@mysql_fetch_array($rr))
		{
			$txt2.=$cat[cat_name] . " , ";
		}
		echo"<tr class='form-group'><td><b>Job Type:</b></td><td>" . substr($txt2,0,-2) . "</td></tr>";
	
	
		echo"<tr class='form-group'><td valign='top'><b>Project Description:</b></td><td>" . nl2br($d[description]) . "</td></tr>";

		
		if($d['attached_file'])
		{
			echo"<tr class='form-group' ><td><b>Attached file:</b></td><td><a href='" . $vpath . "attachment/" . $d['attached_file'] . "' class=lnk>" . $d[atachment] . "</a></td></tr>";
		}
		

		$r3=mysql_query("select count(*) as total from " . $prev . "projects_additional where  project_id=" . $_REQUEST[edit] . " and  user_id=" . $_SESSION[user_id]);
		$total2=@mysql_result($r3,0,"total");
		$r3=mysql_query("select * from " . $prev . "projects_additional where  project_id=" . $_REQUEST[edit] . " and  user_id=" . $_SESSION[user_id]);
		if($total2>0)
		{
			echo"<tr class=lnk bgcolor=whitesmoke><td valign='top'><b>Aditional Information:</b></td><td width='50%'><table width='100%' cellpadding='4' bgcolor='white'>";				
			while($dd=@mysql_fetch_array($r3))
			{				
				if($dd[info])
				{
					echo"<tr  class='lnk'><td><font sioze=1><b>Added on - " . date('F d,Y',$dd['date']) . " EST:</b>-</font><br><br> " . nl2br($dd[info]) . "</td></tr>";
				}					
			}
			echo"</tr></table></td></tr>";
		}		   
	?>
	<tr class="form-group"><td><b>Budget range:</b>*</td>
	<td class=lnk><input type="hidden" name="budget_id" value="<?=$d[budget_id]?>" id="budget_id" />
	<select id="budget_se" onchange="selectbudget(this.value);">
	<option value="">--- Please Select ---</option>
	<option value="1" <?if($d[budget_id]==1){echo "selected";}?>>Less than $250</option>
	<option value="2" <?if($d[budget_id]==2){echo "selected";}?>>Between $250 and $500</option>
	<option value="3" <?if($d[budget_id]==3){echo "selected";}?>>Between $500 and $1,000</option>
	<option value="4" <?if($d[budget_id]==4){echo "selected";}?>>Between $1,000 and $2,500</option>
	<option value="5" <?if($d[budget_id]==5){echo "selected";}?>>Between $2,500 and $5,000</option>
	<option value="6" <?if($d[budget_id]==6){echo "selected";}?>>Between $5,000 and $10,000</option>
	<option value="7" <?if($d[budget_id]==7){echo "selected";}?>>Between $10,000 and $25,000</option>
	<option value="8" <?if($d[budget_id]==8){echo "selected";}?>>Over $25,000</option>
	<option value="9" <?if($d[budget_id]==9){echo "selected";}?>>Not Sure/Confidential</option> 
	</select>
	
	</td></tr>
	<tr class="form-group"><td class="lnk" valign=top><b>How long would you like<br>to accept bids on this project?</b>*</td>
	<td>
	<?php
		$expire9 = $projectudays;
		$explod9 = explode("-", $expire9);
		$i9 = count($explod9);
		$i9 = $i9-1;
		?>
		<INPUT type="text" name="cdays" value="<?=$d['ctime']?>" maxlength="20" size="20"> <font size=1 color=red>(Maximum <? echo 14; ?> days)</font>
		</td></tr>

	 <tr class="form-group"><td class="lnk" valign=top colspan=2><INPUT type="checkbox" name="featured" value="featured" <?if($d[featured]){echo" checked";}?>> I want my project to be listed as a featured project
		(<? echo $setting[currencytype] . '' . $setting[currency] . '' . $setting[featuredcost]; ?> cost).
		</td></tr>
	 <tr class="form-group"><td colspan=2 align=center><INPUT class=headingdeepbrown type="submit" value="<?if($_REQUEST[id]){echo"Update Project";}else{echo"Submit Project";}?>" name="submit"></td></tr>
	<?php
	




 ?>

	
</form>
</table>
</td></tr>
</table>
<!--*********************main table end*************************-->
</td>
</tr>
</table>
                                </div><!-- End .panel-body -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-12  --> 
                    </div><!-- End .row-fluid  -->

                </div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    </div><!-- End .main  -->
	 

  </body>
</html>