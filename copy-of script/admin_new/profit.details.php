<?php 

include("includes/header_dashbord.php");
include("includes/access.php");

?>
					<?php
if(isset($_REQUEST['m'])&&isset($_REQUEST['y']))
{
	$rs1 = mysql_query("select * from ".$prev."earnings_temp where month = '".$_REQUEST['m']."' and year = '".$_REQUEST['y']."' order by add_date desc");
}
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
                      <li><a href="escrow.ist.php">Fund Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Fund Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="profit.php" class="header">Month Wise Profit</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;Profit details</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
<form method=post action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">


<table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4" class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr>
	<td width="153"><b>Transaction ID</b></td>
    <td width="270"><b>Details</b></td>
    <td width="124"><b>Date</b></td>
    <td align="center" width=157><b>Amount (USD)</b></td>
    <td align="center" width="96"><b>Status</b></td>
    <td align="center" width=122><b>Action</b></td>
</tr>
</thead>
<tbody>
<?
$i = 1;
while($rw1 = mysql_fetch_array($rs1))
{
    if(!($i%2)){$class="even";}else{$class="odd";}
	if($rw1[status]=='Y')
	{ $status = "<font color='green'>Completed</font>"; }
	elseif($rw1[status]=='N')
	{ $status = "<font color='red'>Pending</font>"; }
	elseif($rw1[status]=='R')
	{ $status = "<font color='orange'>Refunded</font>"; }
	echo"<tr bgcolor='#ffffff' class='" . $class . "' style=\"height: 25px;\">
	<td>" . $rw1[paypaltran_id] . "</td>
	<td>" . $rw1[details]  . "</td>
	<td>" . date('d-M-y', strtotime($rw1[add_date])) . "</td>
	<td align=center>$ " . $rw1[amount] . "</td>
	<td align=center>" . $status . "</td><td align=center>";
	echo"<a class='lnk'  href='#' class=lnk><u>View Details</u></a></td></tr>\n";
$i++;
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