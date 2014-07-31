<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
mysql_query("TRUNCATE TABLE ".$prev."earnings_temp");
$rs1 = mysql_query("select * from ".$prev."deposits where amount > 0.00 and status='Y'");

$rs2 = mysql_query("select * from ".$prev."profits where amount > 0.00 and status='Y'");
$rtest = mysql_query("select * from ".$prev."earnings_temp");
if(mysql_num_rows($rtest)==0)
{
	while($rw1 = mysql_fetch_array($rs1))
	{
		$month = date('F', strtotime($rw1[add_date]));
		$year = date('Y', strtotime($rw1[add_date]));
		mysql_query("insert into ".$prev."earnings_temp set
		details = '".$rw1[details]."',
		amount = '".$rw1[amount]."',
		add_date = '".$rw1[add_date]."',
		status = '".$rw1[status]."',
		month = '".$month."',
		year = '".$year."',
		paypaltran_id = '".$rw1[paypaltran_id]."',
		amttype = '".$rw1[amttype]."',
		ref = 'Dep',
		ref_id = '".$rw1[id]."'");
	}
	while($rw2 = mysql_fetch_array($rs2))
	{
		$month = date('F', strtotime($rw2[add_date]));
		$year = date('Y', strtotime($rw2[add_date]));
		mysql_query("insert into ".$prev."earnings_temp set
		details = '".$rw2[descrip]."',
		amount = '".$rw2[amount]."',
		add_date = '".$rw2[add_date]."',
		status = '".$rw2[status]."',
		month = '".$month."',
		year = '".$year."',
		paypaltran_id = '".$rw2[paypaltran_id]."',
		amttype = 'CR',
		ref = 'Pro',
		ref_id = '".$rw2[pid]."'");
	}
}
?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="profit.php">Membership Plan Management</a></li>
                    
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
									<a href="membership_plan.php" class="header">Month Wise Profit</a>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">


<form method=post action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">


<table id="table1" width="100%"  border="0" align="center" cellspacing="1" cellpadding="4" class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr>
	<td><b>Month</b></td>
    <td align="center" width=100><b>Amount (USD)</b></td>
    <td align="center" width=100><b>Action</b></td>
</tr>
</thead>
<tbody>
<?
$i = 1;
//print "SELECT sum( amount ) AS p, month , year FROM ".$prev."earnings_temp GROUP BY month , year";
$rs3 = mysql_query("SELECT sum( amount ) AS p, month , year FROM ".$prev."earnings_temp where status='Y' GROUP BY month , year order by add_date desc");
if(mysql_num_rows($rs3)>0)
{
	while($rw3 = mysql_fetch_array($rs3))
	{
		if(!($i%2)){$class="even";}else{$class="odd";}
		echo"<tr bgcolor='#ffffff' class='" . $class . "' style=\"height: 25px;\">
		<td>" . $rw3[month] . "  -  " . $rw3[year]."</td><td align=center>$ " . $rw3[p]."</td><td align=center>";
		echo"<a class='lnk'  href='profit.details.php?m=$rw3[month]&y=$rw3[year]' class=lnk><u><img src='images/view.gif' border='0'></u></a></td></tr>\n";
	$i++;
	}
}
else
{
	echo"<tr bgcolor='#ffffff' class='" . $class . "' style=\"height: 25px;\">
		<td align=center><font color=\"#FF0000\" size=\"-1\">No Record Found</font></td></tr>\n";
}

?>
</tbody>
</table>
</form>
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