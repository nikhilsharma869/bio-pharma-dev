<?php 
include("includes/header_dashbord.php");
include("includes/access.php");
?>
    <div class="main">
        <?php include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->

<!-- End #sidebar  -->


        <section id="content">
<div class="wrapper">
<div class="crumb">
<ul class="breadcrumb">
<li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
<li><a href="member.list.php">Member Management</a></li>
<li class="active">Member List</li>
</ul>
</div>

<div class="container-fluid">
<div id="heading" class="page-header">
<h1><i class="icon20 i-list-4"></i>Member Management</h1>
</div>

<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">

	<div class="panel-body">
	<?php
require_once("../country.php");
if($_GET[del]):
    $r=mysql_query("select * from " . $prev . "transactions where user_id=" . $_GET[del]);
	//echo "user_name=".getusername( $_GET[del]);
	if(!@mysql_num_rows($r)):
    	mysql_query("delete from " . $prev . "user where user_id=" . $_GET[del]);
		mysql_query("delete from " . $prev . "projects where user_id=" . $_GET[del]);
		mysql_query("delete from " . $prev . "bid where user_id=" . $_GET[del]);
		mysql_query("delete from " . $prev . "billing where user_id=" . $_GET[del]);
		mysql_query("delete from " . $prev . "cats where user_id=" . $_GET[del]);
		mysql_query("delete from " . $prev . "cats where user_id=" . $_GET[del]);
		$q1=mysql_query("select * from ".$prev."mail_template where id=1");
		$mem_delete_email=mysql_result($q1,0,"mem_delete_email");
		$to=getusername( $_GET[del]);
		$subj="Member deletion email";
		$body=$mem_delete_email;
		genMailing($to,$subj,$body);
	else:
	   echo"<p align=center><font color=red size=2>There are transaction records under this memebr,so system does not allow to delete this member.</font>"; 
	endif;	
endif;?>
<?
	if($_REQUEST['limit'])
	{
		$page = $_REQUEST['limit'];
	}
	else
	{
		$page = 1;
	}
	if($_REQUEST[param] && $_REQUEST[search]):
   		$cond=$_REQUEST[param]  . " rlike '" . $_REQUEST[search] . "'";
		$parama="&search=".$_REQUEST[search]."&param=".$_REQUEST[param];
	endif;
	if($_REQUEST['status']=='N')
	{
	    $cond="status='".$_REQUEST['status']."'";
	}
	if($_REQUEST['status']&&!$_REQUEST['gold_member'])
	{
		$cond="status='".$_REQUEST['status']."'";
	}
	if($_REQUEST['gold_member'])
	{
		$cond="gold_member='".$_REQUEST['gold_member']."'";
	}
	if($cond){$cond2=" where " . $cond;}


	if(isset($_REQUEST[alpha]) && $_REQUEST[alpha] != '') {
		$cond = "fname rlike '".$_REQUEST[alpha]."'";
		$parama = "&alpha=".$_REQUEST[alpha];
	}
	if($cond) {
		$cond2 = " where  " . $cond;
	}
	else{
		$cond2 = '';
	}
	
$r=mysql_query("select `user_id` from ".$prev."user ".$cond2."");
$total=mysql_num_rows($r);
?>
<form method=post action="<?=$_SERVER[PHP_SELF]?>">
<table width="100%" style="border:1px solid #999999;" border="0" align="center" cellspacing="0" cellpadding="4" bgcolor=<?=$light?> class="table">
	<tr bgcolor="#b7b5b5">
		<td width="47%" height="30" class=header>Member Management&nbsp;&nbsp;&nbsp;(<?=$total?>)</td>
		<!--<td align="right"><input type="button" value="Add New" class="button" onclick="javascript:window.location.href='edit_member.php'"></td>
		
		<td width="8%">
		
			<select name="param" size=1  class=lnk>
			
			<option value='user_id' <?php if($param=="user_id"){echo" selected";}?>>ID</option>
			
			<option value='email' <?php if($param=="email"){echo" selected";}?>>Email</option>
			
			<option value='fname' <?php if($param=="fname"){echo" selected";}?>>Name</option>
			
			</select>
			
		</td>
		
		<td width="16%">==<input type=text size=8 name="search" value="<?=$_POST["search"];?>" class=lnk> &nbsp;</td>
		
		<td width="8%"><input type=submit class="button" name='SBMT_SEARCH'  value='Search'></td>
		
		<td width="1%"></td>-->
		
	</tr>
	
</table>

<br />
<div align="center" style="margin:auto;" class="lnk">
<strong>Browse By First Name</strong>: <a href='<?=$_SERVER['PHP_SELF']?>' class="lnk">All</a>&nbsp;|&nbsp;
<?php
	for($i=65;$i<=90;$i++)
	{
		echo"<a href='".$_SERVER['PHP_SELF']."?alpha=".chr($i)."' class='lnk'>".chr($i)."</a>";
		if($i!=100)
		{
			echo"&nbsp;|&nbsp;";
		}
	}
?>
</div>
<br />


<table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
	
	<tr>
		<td width="5%"><strong>Logo</strong></td>
		
		<td width="18%"><b>Id:Username/Email</b></td>
		
		<td ><b>Join Date/ Last Login</b></td>
		
		<td ><b>Balance[$]</b></td>
		
		<td width="17%"><b>Activitis</b></td>
		
		<td width="12%" align="center"><strong>Status</strong></td>
		
		<td width="10%" align="center"><strong>Actions</strong></td>
	
	</tr>

</thead>

<tbody>

<?php

$r=mysql_query("select * from  ".$prev."user ".$cond2." order by user_id desc limit ".($page-1)*10 .", 10");
if(!$total):

	echo"<tr class='lnkred'><td colspan='8' align='center'>No Result found.</td></tr>";

endif;

$j=0;
while($d=@mysql_fetch_array($r)):
	
	$name = $d[fname]." ".$d[lname];
	
	if($d[status] == 'Y')
	
		{$status = 'Active';}
	
	else if($d[status] == 'N')
		
		{$status = '<font color="red">Inactive</font>';}
	else
		
		{$status = '<font color="red">Suspended</font>';}
    
	if(!($j % 2)){$class="even";}else{$class="odd";}
	
										
	$find_num_project_exe = mysql_query("SELECT id FROM ".$prev."projects
											WHERE user_id = ".$d[user_id]."
											AND status = 'open'"
										);									
										
										
	$num_projects = @mysql_num_rows($find_num_project_exe);	
	
    
	$gettrar = mysql_query("SELECT SUM(balance) as credit FROM ". $prev ."transactions WHERE user_id='" . $d[user_id] . "' and amttype='CR' and status='Y' ORDER BY date2");
    $dd= @mysql_fetch_array($gettrar);
	$gettrar1 = mysql_query("SELECT SUM(balance) as debit FROM ". $prev ."transactions WHERE user_id='" . $d[user_id] . "' and amttype='DR' and status='Y' ORDER BY date2");
    $dd1= @mysql_fetch_array($gettrar1);	
	$balnc = $dd[credit] - $dd1[debit];
	$openjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $d[user_id] . "' and status='open'"));
    $closejobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $d[user_id] . "' and status='frozen'"));
    $closedjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $d[user_id] . "' and status='closed'"));
    $cancelledjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $d[user_id] . "' and status='cancelled'"));
    if(!empty($d[logo]))
	{
	 $temp_logo=$d[logo];
	
	}
    else
	{
	
	   $temp_logo="images/blankpic.jpg";
	}
	echo"<tr class=" . $class . " bgcolor='#ffffff' >
	<td ><a href='edit_member.php?user_id=" . $d[user_id]."' class=lnk><img src=".$vpath."viewimage.php?img=".$temp_logo."&width=60&height=60 border=0></a></td>
	<td >" . $d[user_id] . " : " . $d[username]." (". $d[fname]." ".$d[lname] .")";
	/*if($d[gold_member]){echo"&nbsp;<img src='../images/gold-membership.png' width=25>";}*/
	echo"<br>" . $d[email] . "<br>" . $country_array[$d[country]]."</td>
   
	<td >" . mysqldate_show($d[reg_date]) . "<br>" . mysqldate_show($d[ldate]) ."</td>
	<td>" .$balnc . "</td><td>		Op/Cl/Ca/Won Jobs (" . $openjobs . "/" . ($closejobs+$closedjobs) ."/". $cancelledjobs.")
	</td><td >" . $status . "<br>";
	
	echo"<br>Reviews :";
	echo"</td>";
	echo "<td align=center><a class=lnk  href='edit_member.php?user_id=$d[user_id]'><u>".$main_icon_edit_img."</u></a> | <a class=lnk  href='add_fund.php?user_id=$d[user_id]'><u>Add Fund</u></a> </td>";
	echo "</tr>";
    $j++;
endwhile;s
?></tbody></table>
<div style="height:5px;"></div>
<?php
if($total>10):
?>
<table  width="100%"  border="0" align="center" HEIGHT=25 cellspacing="0" cellpadding="4" style="border:1px solid #999999;">
<tr bgcolor=<?=$light?> ><td align="center">

  <?PHP echo paging($total,10,$parama);?>
</td></tr></table>
<?PHP 
endif;?>
</form></td>
<script type="text/javascript">
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
["None","Number","String","String","String","String","String","Date","String","String","None"]);
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

</tbody>
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