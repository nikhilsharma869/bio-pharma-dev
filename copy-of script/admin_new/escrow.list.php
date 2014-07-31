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
                      <li><a href="category_list.php">Membership Plan Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Membership Plan Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="membership_plan.php" class="header">Membership Plan</a>&nbsp;&nbsp;&nbsp; (<?=$total?>)
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
<form method=post action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="<?=$light?>" class="table">
<tr bgcolor="<?=$light?>">
	<td width="54%" height="28" class="header">&nbsp;Escrow by Members</td>
	<td bgcolor="<?=$light?>" width="46%" align="right">

	</td>
</tr>
</table><br />
<!--------------------------------------------------------------------------------------------------------->
<table id="table-1" width="100%"  border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
  <tr>
    <td>ID</td>
    <td>DETAILS</td>
    <td>REASON</td>
    <td>DATE</td>
    <td>ACTION</td>
  </tr>
</thead>
<?
if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
if($_REQUEST[user_id]):
     $cond="user_id='" . $_REQUEST[user_id] . "'";
endif;
if($_REQUEST[SBMT_SEARCH]):
     $cond="buyer_id='" . $_REQUEST[search] . "'";
endif;

if($cond){$cond2=" where  " . $cond;}
$r=mysql_query("select count(escrow_id) as total from " . $prev . "escrow " . $cond2." order by add_date desc");
//print "select count(id) as total from " . $prev . "escrow " . $cond2;
$total=@mysql_result($r,0,"total");

if(!$total):
   echo"<tr class='lnkred'><td colspan='8' align='center'>No Record Found.</td></tr>";
endif;

$r=mysql_query("select * from " . $prev . "escrow " . $cond2 . " order by add_date desc limit " . ($_REQUEST['limit']-1)*5 . ",5");

$j=0;$k=0;$p=0;

while($d=@mysql_fetch_array($r)):

$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$d['bidder_id']."'"));

$rw2 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$d['user_id']."'"));

$rw3 = mysql_fetch_array(mysql_query("SELECT ".$prev."projects . * FROM ".$prev."projects, ".$prev."buyer_bids WHERE ".$prev."projects.id = ".$prev."buyer_bids.project_id AND ".$prev."buyer_bids.id ='".$d[bidid]."'"));
	if(!($j%2)){$class="even";}else{$class="odd";}
	

  echo"<tr bgcolor='#ffffff' class='" . $class . "'>
    <td align=center>
		<a href='escrow_release.php?escrow_id=" . $d[escrow_id]."' class=lnk><font color=\"blue\">".$d[escrow_id]."</font></a>
	</td>
    <td>
  <table width=\"300\">
  <tr>
    <th align=\"left\" width=\"40%\">ESCROW BY :</th>
    <td align=\"left\">
		<a href='edit_member.php?user_id=" . $rw2[user_id]."' class=lnk>
		<strong><font color=\"blue\">" . ucwords($rw2[fname])." ".ucwords($rw2[lname]) . "</font></strong>
		</a>
	</td>
  </tr>
  <tr>
    <th align=\"left\" width=\"40%\">ESCROW TO :</th>
    <td align=\"left\">
		<a href='edit_member.php?user_id=" . $rw1[user_id]."' class=lnk>
		<strong><font color=\"blue\">" . ucwords($rw1[fname])." ".ucwords($rw2[fname]) . "</font></strong></a>
	</td>
  </tr>
  <tr>
    <th align=\"left\" width=\"40%\">PROJECT :</th>
    <td align=\"left\">
		<a href='project.detail.php?pid=" . $rw3[id]."' class=lnk><font color=\"blue\">" . ucwords($rw3[project]) . "</font></a>
	</td>
  </tr>
  <tr>
    <th align=\"left\" width=\"40%\">AMOUNT (USD):</th>
    <td align=\"left\">$ ". $d[amount] ."</td>
  </tr>
</table>
</td>
    <td width=\"25%\">". $d[reason] ."</td>
    <td>". date('d-M-y',strtotime($d[add_date])) ."</td>
    <td>";
	if($d[status]=='P')
	{
		echo "<a class='lnk'  href='escrow_release.php?escrow_id=" . $d[escrow_id] . "'>
			<u>Release to <strong>" . getusername($d[bidder_id]) . "</strong> Account</u>
		</a> ";
	}
	elseif($d[status]=='Y')
	{
		if($d[released_by]=='employer')
		{
			echo "<font color='green'>Done by employer</font>";
		}
		else
		{
			echo "<font color='green'>Done by admin</font>";
		}
	}
	elseif($d[status]=='D')
	{
		echo "<font color=\"#FF0000\">Disputed</font><br>";
		echo "<a class='lnk'  href='escrow_release.php?escrow_id=" . $d[escrow_id] . "'>
			<u>Release to <strong>" . getusername($d[bidder_id]) . "</strong> Account</u>
		</a> ";
	}
	elseif($d[status]=='R')
	{
		
		if($d[released_by]=='employer')
		{
			echo "<font color='green'>Disputed release by employer</font>";
		}
		else
		{
			echo "<font color='green'>Disputed release by admin</font>";
		}
		
	}
	elseif($d[status]=='C')
	{
		echo 'Cancelled by contractor';
	}
	echo "</td>
  </tr>\n";
  	$j++;
endwhile;
$parama="&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
?>
</table>


<!--------------------------------------------------------------------------------------------------------->

<table  width="100%"  border="0" align="center" cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
  <tr bgcolor="<?=$light?>"><td  align="right" height="25"><? if($total>5){echo paging($total,5,$parama,"lnk");}?></td><td align=right><?if($p){echo"<input type=submit value='Update' name='updt'>";}?></td></tr>
</table>
<input type=hidden name=pending value=<?=$p?>>
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
	["Number","String","String","String","String","String","String","String","Number","String","None"]);
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