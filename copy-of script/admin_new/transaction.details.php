<?php 
include("includes/header_dashbord.php");
include("includes/access.php");
if(isset($_GET[del])&&$_GET[del]==1):

   $rs = mysql_fetch_array(mysql_query("select * from ".$prev."transactions where id=". $_GET[id]));
   
   $r=mysql_query("delete from " . $prev . "transactions where id=" . $_GET[id]);
   if($r)
   {
	   $rs1 = mysql_query("delete from ".$prev."paypal_transactions where odeskclone_txn_id = '".$rs[paypaltran_id]."'");
   }
endif;
?>

<link rel="stylesheet" href="../jquery/jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
	<script src="../jquery/jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
	<script src="../jquery/jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="../jquery/jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="../jquery/jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script>
	$j=$.noConflict();
	$j(function($) {
		$( "#datepicker_from" ).datepicker({
			showOn: "button",
			buttonImage: "../images/caln.png",
			buttonImageOnly: true
		});
	});
	$j(function($) {
		$( "#datepicker_to" ).datepicker({
			showOn: "button",
			buttonImage: "../images/caln.png",
			buttonImageOnly: true
		});
	});

	</script>
		<script src="js/jquery.genyxAdmin.js"></script>
    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="escrow.list.php">Fund Management</a></li>
                    
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
									<a  class="header">Deposit by Members</a>									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
	
<form method=post action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">

    <form name="trn_frm" action="" method="post"> 
    <table width="690">
    <tr>
    	<td width="150">
		<input type="text" id="datepicker_from" name="from_txt" readonly="readonly" size="15" style="margin-right: 6px;" <?php if(isset($_POST['sub_go'])){?> value="<?php print $_POST['from_txt'];?>"<?php }?>/></td>
        
		<td width="150">
		<input type="text" id="datepicker_to" name="to_txt" readonly="readonly" size="15" style="margin-right: 6px;" <?php if(isset($_POST['sub_go'])){?> value="<?php print $_POST['to_txt'];?>"<?php }?>/></td>
        
		<td width="35"><input type="submit" name="sub_go" value="Go" style="width:35px; height:20px;"/></td>
        
		<td width="218" align="right">
            <p class="lnk" align="right">
            <?php echo $main_icon_active_img; ?>&nbsp;= Completed
            &nbsp;|&nbsp;
            <?php echo $main_icon_inactive_img; ?>&nbsp;= Pending
            
            </p>
        </td>
    </tr>
    </table>
</form>
<table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr>
	<td><b>Date</b></td>
    <td><b>Details</b></td>
    <td align="center"><b>CR / DR</b></td>
    <td align="center"><b>Status</b></td>
    <td align=center><strong>Amount</strong></td>
    <td align=center><strong>Balance</strong></td>
</tr>
</thead>
<tbody>
<?
$tranbalance = 0;
if(isset($_POST['sub_go'])&&$_POST['sub_go']=='Go')
{
	$temp = mysql_query("select * from ".$prev."transactions_temp");
	if(mysql_num_rows($temp)>0)
	{
		mysql_query("TRUNCATE TABLE ".$prev."transactions_temp");
		
	}
	$restrnid1 = mysql_query("SELECT * FROM ".$prev."transactions WHERE substring( add_date, 1, 10 ) < '".$_POST['from_txt']."' order by add_date");
	if(mysql_num_rows($restrnid1)>0)
	{
		while($rowtrnid1 = mysql_fetch_array($restrnid1))
		{
			if(($rowtrnid1['status']=='Y')&&($rowtrnid1['amttype']=='CR'))
			{
				$tranbalance = number_format(($tranbalance + doubleval($rowtrnid1['balance'])),2);
			}
			elseif(($rowtrnid1['status']=='Y')&&($rowtrnid1['amttype']=='DR'))
			{
				$tranbalance = number_format(($tranbalance - doubleval($rowtrnid1['balance'])),2);
			}
		}
	}
	$restrnid = mysql_query("SELECT * FROM ".$prev."transactions WHERE substring( add_date, 1, 10 ) >= '".$_POST['from_txt']."' and substring( add_date, 1, 10 )<= '".$_POST['to_txt']."' order by add_date");
	if(mysql_num_rows($restrnid)>0)
	{
		$j=0;$k=0;$p=0;
		while($rowtrnid = mysql_fetch_array($restrnid))
		{
		
		$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$rowtrnid['user_id']."' and status = 'Y' and amttype='CR' and id <= '".$rowtrnid[id]."'"));
			
			$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$rowtrnid['user_id']."' and status = 'Y' and amttype='DR' and id <= '".$rowtrnid[id]."'"));
			
			$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);
			
			
		
			if(($rowtrnid['status']=='Y')&&($rowtrnid['amttype']=='CR'))
			{
				$tranbalance = number_format(($tranbalance + doubleval($rowtrnid['balance'])),2);
			}
			elseif(($rowtrnid['status']=='Y')&&($rowtrnid['amttype']=='DR'))
			{
				$tranbalance = number_format(($tranbalance - doubleval($rowtrnid['balance'])),2);
			}
	if(!($j%2)){$class="even";}else{$class="odd";}
	
    if($rowtrnid['status']=="Y"){$status=$main_icon_active_img;$status_str='Completed';}elseif($rowtrnid['status']=="P") {$status=$main_icon_inactive_img;$status_str='Pending';$p++;}
	$rsq = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rowtrnid['user_id']."'"));
    echo"<tr bgcolor='#ffffff' class='" . $class . "'>
	<td>" . date('d-m-Y H:i:s',strtotime($rowtrnid['add_date'])) . "</td>
	<td >
	<table width=\"100%\">
	<tr>
		<td style=\"width:100px;\">Transaction ID</td>
		<td>".$rowtrnid['paypaltran_id']."</td>
	</tr>
	<tr>
		<td style=\"width:100px;\">Description</td>
		<td>".$rowtrnid['details']."</td>
	</tr>
	<tr>
		<td style=\"width:100px;\">Name</td>
		<td>".ucwords($rsq['fname']).' '.ucwords($rsq['lname'])."</td>
	</tr>
	</table>
	</td>";
	
	echo"<td align=center>" . $rowtrnid['amttype'] . "</td>
	<td align=center>" . $status . "</td>
	<td align=center>$ " . $rowtrnid['balance'] . "</td>";
	
	echo"<td align=center>$ ".$balsum."</td></tr>\n";
		mysql_query("insert into ".$prev."transactions_temp set
		Date = '".date('d-m-Y H:i:s',strtotime($rowtrnid['add_date']))."',
		Transaction_ID = ' ".$rowtrnid['paypaltran_id']." ',
		Description = '".$rowtrnid['details']."',
		Name = '".ucwords($rsq['fname']).' '.ucwords($rsq['lname'])."',
		Credit_Debit = '".$rowtrnid['amttype']."',
		Status = '".$status_str."',
		Amount = '$ ".$rowtrnid['balance']."',
		Balance = '$ ".$balsum."'");
	$j++;
		}
	}
	else
	{
?>
		<tr>
			<td colspan="6">No transactions meet your selected criteria</td>
		</tr>
<?php
	}
	$table = "".$prev."transactions_temp";
	$file = 'export';
	/*$link = mysql_connect($host, $user, $pass) or die("Can not connect." . mysql_error());
	mysql_select_db($db) or die("Can not connect.");*/
	
	$result = mysql_query("SHOW COLUMNS FROM ".$table."");
	$i = 0;
	if (mysql_num_rows($result) > 0)
	{
		while ($row = mysql_fetch_assoc($result)) 
		{
			$csv_output .=$row['Field'].", ";
			$i++;
		}
	}
	//print substr($csv_output, 0, -1);
	//$csv_output = substr($csv_output, 0, -1);
	$csv_output .= "\n";
	
	$j=0;
	
	$values = mysql_query("SELECT * FROM ".$table."");
	while ($rowr = mysql_fetch_array($values))
	{//print_r($rowr);
		for ($j=0;$j<$i;$j++) 
		{
			$csv_output .=$rowr[$j].", ";
			//$j++;
		}
		//$csv_output = substr($csv_output, 0, -1);
		$csv_output .= "\n";
	}
	$filename = $file.'.csv';
	$handle = fopen($apath.'attachment/'.$filename, "w+");
	fwrite($handle, $csv_output);
	fclose($handle);
	 //print $csv_output;
	 //exit;
	 //$_SESSION['acntstmnt'] = $vpath.'upload/'.$filename;
	 ?>
     <!--<a href="<?php print $vpath.'attachment/'.$filename;?>">Download CSV File</a>-->
     <?php
}
$parama="&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
?>
</tbody>
</table>
<table  width="100%"  border="0" align="center" cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
<tr bgcolor="<?=$light?>">
  <td  align="right" height="25"><? if($total>20){echo paging($total,20,$parama,"lnk");}?></td>
  <td align=right><? //if($p){echo"<input type=submit value='Update' name='updt'>";}?></td>
</tr>
</table>
<!--<input type=hidden name=pending value=<? //=$p?>>-->
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