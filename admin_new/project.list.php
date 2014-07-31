<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		

<script src="js/jquery.genyxAdmin.js"></script>


        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="project.list.php">Project List</li>
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
                                    <div class="icon"><i class="icon20 i-table"></i></div>
                                    <h4>project List</h4>   <?php if($_REQUEST['msg']!=""){echo $_REQUEST['msg'];}?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
								  <div class="panel-body">
								<?php
								if($_GET[del]):
   mysql_query("delete from " . $prev . "projects  where id=" . $_GET[id]);
endif;
if($_GET[action]=="s"):
   $d=mysql_query("update " . $prev . "projects  set special='Y' where id=" . $_GET[id]);
   
   $user_id=$_REQUEST['user_id'];
	$status=$_REQUEST['status'];
	if($d)
	{
		header("location:project.list.php?user_id=$user_id&status=$status&msg=Data updated successfully..");
	}
	else
	{
		header("location:project.list.php?user_id=$user_id&status=$status&msg=Try again..");
	}
   
   
endif;
if($_GET[action]=="c"):
   $d=mysql_query("update " . $prev . "projects  set status='close' where id=" . $_GET[id]);
   $user_id=$_REQUEST['user_id'];
   $status=$_REQUEST['status'];

	if($d)
	{
		header("location:project.list.php?user_id=$user_id&status=$status&msg=Data updated successfully..");
	}
	else
	{
		header("location:project.list.php?user_id=$user_id&status=$status&msg=Try again..");
	}
endif;

if($_REQUEST[user_id]):
    $rr=mysql_query("select * from ".$prev."user  where user_id=".$_REQUEST[user_id]);
    $data=mysql_fetch_array($rr);
	$gettrar = mysql_query("SELECT * FROM ". $prev ."transactions WHERE user_id='" . $_REQUEST[user_id] . "'  ORDER BY date2 DESC LIMIT 0,1");
    $dd= @mysql_fetch_array($gettrar);
	$balance=$dd[balance];
#counter ========================================================================================	

    $find_num_websites_exe = mysql_query("SELECT id FROM ".$prev."sell_website
											WHERE user_id = ".$_REQUEST[user_id]."
											AND sell_type = 'W'"
										);
	$num_websites = @mysql_num_rows( $find_num_websites_exe );
	
	$find_num_domains_exe = mysql_query("SELECT id FROM ".$prev."sell_website
											WHERE user_id = ".$_REQUEST[user_id]."
											AND sell_type = 'D'"
										);
	$num_domains = @mysql_num_rows($find_num_domains_exe );									
	$find_num_mos_exe = mysql_query("SELECT id FROM ".$prev."sell_website
											WHERE user_id = ".$_REQUEST[user_id]."
											AND sell_type = 'MOS'"
										);
	$num_mos = @mysql_num_rows($find_num_mos_exe);	
	
		$find_post_job = mysql_query("SELECT id FROM ".$prev."projects
											WHERE user_id = ".$_REQUEST[user_id]."
											AND status = 'open'"
										);
	$num_post_job = @mysql_num_rows($find_post_job);	
	
	
	$find_num_project_exe = mysql_query("SELECT id FROM ".$prev."projects
											WHERE user_id = ".$_REQUEST[user_id]."
											AND expires> = '" . date("Y-m-d") . "'"
										);
	$num_projects = @mysql_num_rows($find_num_project_exe);	
	$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_REQUEST['user_id']."' and status = 'Y' and amttype='CR'"));
	
	$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_REQUEST['user_id']."' and status = 'Y' and amttype='DR'"));
	
	$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);
#========================================================================================	
?>
<br>
<table  border="0" width="100%"  cellpadding="4" cellspacing="1">
<tr>
<td  style="border:solid 1px gray;padding:5px"><a href="edit_member.php?user_id=<?=$_REQUEST[user_id]?>" class=lnk>Edit Profile</a></td>
<!--<td style="border:solid 1px gray;padding:5px" ><a href="website.list.php?user_id=<?=$_REQUEST[user_id]?>"  class=lnk><strong>Manage Websites</strong> (<?=$num_websites?>)</a></td>-->
<!--<td style="border:solid 1px gray;padding:5px"><a href="domain.list.php?user_id=<?=$_REQUEST[user_id]?>"  class=lnk>Manage Domains (<?=$num_domains?>)</a></td>-->
<!--<td style="border:solid 1px gray;padding:5px"><a href="mobapp.list.php?user_id=<?=$_REQUEST[user_id]?>"  class=lnk>Manage Mobile App. (<?=$num_domains?>)</a></td>-->
<td style="border:solid 1px gray;padding:5px" bgcolor="#e5e5e5"><a href="project.list.php?user_id=<?=$_REQUEST[user_id]?>&user_id=<?=$_REQUEST[user_id]?>"  class=lnk>Manage Post Jobs (<?=$num_post_job?>)</a></td>
<!--<td style="border:solid 1px gray;padding:5px"><a href="project.bid.list.php?user_id=<?=$_REQUEST[user_id]?>"  class=lnk>Manage Submit Bids (<?=$num_domains?>)</a></td>-->
<td style="border:solid 1px gray;padding:5px"><a href="transaction.dtl.php?user_id=<?=$_REQUEST[user_id]?>"  class=lnk>Payment (Balance $<?=$balsum?>)</a></td>

<td style="border:solid 1px gray;padding:5px; width:600px;" ></td>

</tr>
</table><br>
<?
endif;
?>

<form method=post action="">
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" bgcolor=<?=$dark?> class="table" style="border:1px solid #999999;">
<tr><td height=25 class=header><span style="color:#AA0000; font-size:12px;"><?php
if($_GET['cat_id']){
?>
 Category Name : <?=getSubCategory($_GET['cat_id'])?>
<?php
}
?></span>         </td>
<td bgcolor="<?=$light?>" width=45% align=right>
<table>
<tr class=lnk>

<td style="width:150px;"><select name=param  style="width:150px;">
<option value='' >Select</option>
<option value='id' <? if($_POST['param']=="id"){echo" selected";}?>>Project Id</option>
<option value='username' <? if($_POST['param']=="username"){echo" selected";}?>>Creator</option>
<option value='project'   <? if($_POST['param']=="project"){echo" selected";}?>>Project Name</option>
</select></td><td> == <input type=text  name=search value="<?=$_POST['search']?>" > &nbsp;</td>
<td><input type="hidden" name='cat_id'  value='<?=$_GET['cat_id']?>' />
<input type=submit class="button" name='SBMT_SEARCH'  value='  Search  ' /></td>
</tr></table>
</td></tr></table><br />

<?
 $st = '';
	 if($_GET['cat_id']!=''){
		$st = "AND ". $prev ."projects.categories=".$_GET['cat_id'];
	 }
$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.creation='".date("Y-m-d") . "' ".$st." group by ".$prev ."projects.id");
$total=@mysql_num_rows($r);

$r=mysql_query("select *  from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='open' ".$st." group by ".$prev ."projects.id");
$total_open=@mysql_num_rows($r);   


$r=mysql_query("select *  from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='process' ".$st." group by ".$prev ."projects.id");
$total_process=@mysql_num_rows($r);


$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where  ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='frozen' ".$st." group by ".$prev ."projects.id");
$total_frozen=@mysql_num_rows($r);

$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='complete' ".$st." group by ".$prev ."projects.id");
$total_delevered=@mysql_num_rows($r);

$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='expired' ".$st." group by ".$prev ."projects.id");
$total_expired=@mysql_num_rows($r);

$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='close' ".$st." group by ".$prev ."projects.id");
$total_cancelled=@mysql_num_rows($r);

//$cond[]=$prev ."projects.id=" .$prev ."buyer_bids.project_id";

//if(count($cond)){$cond2= " where " . implode (" and ",$cond);}
//$r=mysql_query("select " . $prev . "projects.* from " . $prev . "projects,".$prev ."buyer_bids  " . $cond2 . " group by ".$prev ."projects.id");
//$total_bids=@mysql_num_rows($r);

//echo "SELECT COUNT(*) FROM ". $prev ."projects,".$prev ."buyer_bids  WHERE ".$prev ."projects.id=" .$prev ."buyer_bids.project_id  ";
	// $r= mysql_query("SELECT COUNT(*) FROM ". $prev ."projects,".$prev ."buyer_bids  WHERE ".$prev ."projects.id=" .$prev ."buyer_bids.project_id  ");
//$r =	mysql_query("SELECT COUNT(*) FROM ". $prev ."projects,".$prev ."buyer_bids  WHERE ".$prev ."projects.id=" .$prev ."buyer_bids.project_id  ");
	
 $st = '';
	 if($_GET['cat_id']!=''){
		$st = "&cat_id=".$_GET['cat_id'];
	 }

?>

<table  border="0" width="100%"  cellpadding="4" cellspacing="1">
<tr class=link><td style="border:solid 1px gray;padding:5px" <?if($_REQUEST[creation]){echo"bgcolor='#e5e5e5'";}?>><a href='<?=$_SERVER[PHP_SELF]?>?creation=<?=date("Y-m-d").$st?>' class=lnk>Today's Post : <?=$total?></a></td>
<td style="border:solid 1px gray;padding:5px" <?if($_REQUEST[status]=="open"){echo"bgcolor='#e5e5e5'";}?>><a href='<?=$_SERVER[PHP_SELF]?>?status=open<?=$st?>' class=lnk>Open Projects : <?=$total_open?></a></td>
<td style="border:solid 1px gray;padding:5px" <?if($_REQUEST[status]=="process"){echo"bgcolor='#e5e5e5'";}?>><a href='<?=$_SERVER[PHP_SELF]?>?status=process<?=$st?>' class=lnk>Running Projects : <?=$total_process?></a></td>
<td style="border:solid 1px gray;padding:5px" <?if($_REQUEST[status]=="complete"){echo"bgcolor='#e5e5e5'";}?>><a href='<?=$_SERVER[PHP_SELF]?>?status=complete<?=$st?>' class=lnk>Completed Projects : <?=$total_delevered?></a></td>
<td style="border:solid 1px gray;padding:5px" <?if($_REQUEST[status]=="expired"){echo"bgcolor='#e5e5e5'";}?>><a href='<?=$_SERVER[PHP_SELF]?>?status=expired<?=$st?>' class=lnk>Expired : <?=$total_expired?></a></td>
<td style="border:solid 1px gray;padding:5px" <?if($_REQUEST[status]=="close"){echo"bgcolor='#e5e5e5'";}?>><a href='<?=$_SERVER[PHP_SELF]?>?status=close<?=$st?>' class=lnk>Closed Projects : <?=$total_cancelled?></a></td>
<td style="border:solid 1px gray;padding:5px" <?if($_REQUEST[status]=="frozen"){echo"bgcolor='#e5e5e5'";}?>><a href='<?=$_SERVER[PHP_SELF]?>?status=frozen<?=$st?>' class=lnk>Frozen Projects : <?=$total_frozen?></a></td>
</tr></table>
<br>
<table id="table-1" width="100%"  border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr >
<td width=7%><b>ID</b></td>
<td width="10%"><b>Project Title</b></td>
<td width="10%"><b>Project Type</b></td>
<td width="13%" align="center"><b>Budget</b></td>
<td width="10%" align="center"><b>Creator</b></td>
<td width="12%"  align=center><b>Date</b></td>
<td width="3%"  align=center><b>No of Bids</b></td>
<td width="10%"  align=center><b>Status</b></td>
<td width="25%"  align=center><b>Action</b></td>
</tr>
</thead><tbody>
<?
if(!$_GET[limit]){$_GET[limit]=1;}
$cond=array();
if($_POST[param]):
 $std = '';
	 if($_GET['cat_id']!=''){
		$std = " AND ".$prev . "projects.categories=".$_GET['cat_id'];
	 }
if($_POST[param]=='username'){
  $u=mysql_fetch_assoc(mysql_query("select user_id from " . $prev . "user where username='" . $_POST[search]."'"));
  $cond[]=$prev . "projects.user_id = '" . $u[user_id] .$std ."'";
  }else{
   $cond[]=$prev . "projects.".$_POST[param]  . " rlike " . addslashes($_POST[search]) .$std. "";
   }
   $param="&" .$_POST[param] . "=" . $_POST[search];
endif;
$cond[]=$prev ."projects.id=" .$prev ."projects_cats.id";
if($_REQUEST['status'])
{
	$cond[]=$prev . "projects.status='".$_REQUEST['status']."'";
}
if($_REQUEST['status'] && $_REQUEST['cat_id'])
{
	$cond[]=$prev . "projects.status='".$_REQUEST['status']."'" AND $prev . "projects.categories='".$_REQUEST['cat_id']."'";
}
if($_REQUEST['creation'] && $_REQUEST['cat_id'])
{
	$cond[]=$prev ."projects.creation='".$_REQUEST['creation']."'" AND $prev . "projects.categories='".$_REQUEST['cat_id']."'";
}
if($_REQUEST['user_id'])
{
	$cond[]=$prev . "projects.user_id='".$_REQUEST['user_id']."'";
}
if($_REQUEST['creation'])
{
	$cond[]=$prev ."projects.creation='".$_REQUEST['creation']."'";
}
if($_REQUEST['cat_id'])
{
	$cond[]=$prev ."projects_cats.cat_id='".$_REQUEST['cat_id']."'";
}


if(count($cond)){$cond2= " where " . implode (" and ",$cond);}
$r=mysql_query("select " . $prev . "projects.* from " . $prev . "projects,".$prev ."projects_cats  " . $cond2 . " group by ".$prev ."projects.id");
$total=@mysql_num_rows($r);
if(!$total):
   echo"<tr><td align=center colspan=10 align=center class=lnkred>No project found</td></tr>";
endif;
//echo "select " . $prev . "projects.* from " . $prev . "projects,".$prev ."projects_cats " . $cond2 . " group by ".$prev ."projects.id limit " . ($_GET[limit]-1)*20 . ",20";
$r=mysql_query("select " . $prev . "projects.* from " . $prev . "projects,".$prev ."projects_cats " . $cond2 . " group by ".$prev ."projects.id limit " . ($_GET[limit]-1)*20 . ",20");
//echo"select " . $prev . "projects.* from " . $prev . "projects,".$prev ."projects_cats " . $cond2 . " group by ".$prev ."projects.id limit " . ($_GET[limit]-1)*20 . ",20";
$j=0;$k=0;
while($d=@mysql_fetch_array($r)):

 $sr= mysql_query("SELECT COUNT(*) AS TOTAL FROM ".$prev ."buyer_bids  WHERE " .$prev ."buyer_bids.project_id ='".$d[id]."'");
	 
	 $total_bids =mysql_fetch_assoc($sr);
	 
	 

	if(!($j%2)){$class="even";}else{$class="odd";}
    $rr=mysql_query("select * from " . $prev . "user where user_id=" . $d[user_id]);
	$buyer=@mysql_result($rr,0,"username");
	if($d[status]=="cancelled" || $d[status]=="expired")
		{$cl="class='lnkred'";}
	elseif($d[status]=="complete")
		{$cl="class='lnkgreen'";}
	else{$cl="";}
	if(empty($d[budgetmax ]))
	{
	    $budgetmax="";
	}
	else
	{
	
	    $budgetmax="/$".$d[budgetmax ];
	}
	if($d[budgetmin]=="above $25000" || $d[budgetmin]=="not sure")
	{
	    $budgetmin=$d[budgetmin];
	}
	else{
	       $budgetmin="$".$d[budgetmin];
	}
	
if($d[project_type]=='F')
	{
	    $projecttype='Fixed Price';
	}
	else{
	       $projecttype='Hourly Price';
	}
	 
	 
	
    echo"<tr  class=" . $class . ">
		<td width=2% class=lnk>" . $d[id] ."</td>
		<td><a class=lnk  href='post.job.php?id=" . $d[id] . "&edit=".$d[id]."&user_id=".$d[user_id]."'><u>" . $d[project] . "</u></a></td>
		<td>" . $projecttype . "</td>
		<td>" . $budgetmin .   $budgetmax  . "</td>
		<td><a href='edit_member.php?user_id=".$d[user_id]."' class=lnk>" . $buyer. "</a></td>
		<td>" . date('jS F, Y',$d[date2])."</td>
		<td><a class=lnk  href='bid_list.php?id=".$d['id']."' >" .$total_bids['TOTAL']."</a></td>
		<td " . $cl . ">" . $d[status] . "</td>
		<td><a class=lnk  href='bid_list.php?id=".$d['id']."' ><u>Bid List</u></a> | <a class=lnk  href='../project-dtl.php?id=" . $d[id] . "' target=_new><u>View</u></a> | <a class=lnk  href='post.job.php?id=" . $d[id] . "&edit=".$d[id]."&user_id=".$d[user_id]."'><u>Edit</u></a>";
		if($d[status]=='open' || $d[status]=='frozen') { 
		echo "| <a class=lnk  href='" . $_SERVER['PHP_SELF'] . "?id=" . $d[id] . "&user_id=".$d[user_id]."&action=c&status=".$d[status]."'><u>Close</u></a>";
		} 
		echo "| <a class=lnk  href=\"javascript:if(confirm('Are you sure whish to delete?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d[id] . "&del=1';}\"><u>Delete</u></a></td></tr>";
	    $j++;
endwhile;
?>
</tbody>
</table>
<?
if($total>20):
?>
  <table  width="100%"  border="0" align="center" HEIGHT=25 cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
  <tr bgcolor=<?=$light?>><td  align=center ><? echo paging($total,20,$param)?></td></tr></table>
<?
endif;
?>
</form>
<script type="text/javascript">
//<![CDATA[
function addClassName(el, sClassName) {
	var s = el.className;
	var p = s.split(" ");
	var l = p.length;
	for (var i = 0; i < l; i++) {
		if (p[i] == sClassName)
			return;
	}
	p[p.length] = sClassName;
	el.className = p.join(" ");

}

function removeClassName(el, sClassName) {
	var s = el.className;
	var p = s.split(" ");
	var np = [];
	var l = p.length;
	var j = 0;
	for (var i = 0; i < l; i++) {
		if (p[i] != sClassName)
			np[j++] = p[i];
	}
	el.className = np.join(" ");
}
var st = new SortableTable(document.getElementById("table-1"),
	["Number","String","String","String","String","String","String","String","String"]);
	// restore the class names
st.onsort = function () {
	var rows = st.tBody.rows;
	var l = rows.length;
	for (var i = 0; i < l; i++) {
		removeClassName(rows[i], i % 2 ? "odd" : "even");
		addClassName(rows[i], i % 2 ? "even" : "odd");
	}
};
//]]>
</script>
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