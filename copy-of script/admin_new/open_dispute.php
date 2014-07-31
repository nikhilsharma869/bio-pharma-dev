<?php 
include("includes/header_dashbord.php");
include("includes/access.php");

$r = mysql_query("select * from " . $prev . "disputes where `round_stat`='Y' and `resolve`='N'");
$total=@mysql_num_rows($r);


if($_GET[del]):
   mysql_query("delete from " . $prev . "disputes where disput_id=" . $_GET[id]);
   redirect('open_dispute.php');
endif;

?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			

			
			
			
			
		<?php
		if($_REQUEST['limit'])
	{
		$page = $_REQUEST['limit'];
	}
	else
	{
		$page = 1;
	}
	
	
		$r=mysql_query("select count(*) as total from ".$prev."disputes where round_stat='Y' and `resolve`='N'");
		$total=@mysql_result($r,0,"total");

		?>
			
 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a >Dispute Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Dispute Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="open_dispute.php" class="header">Open Dispute</a>&nbsp;&nbsp;&nbsp; (<?=$total?>)
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<form method=post action="<?=$_SERVER['PHP_SELF']?>">

  <p class="lnk" align="right">
<u><img src='images/view.png' border='0' height="20" width="20"></u>&nbsp;= View&nbsp;
  <?php echo $main_icon_del_img; ?>&nbsp;= Delete </p>
  <table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
    <thead>
      <tr>
        <td width=7%><b>ID</b></td>
        <td width="24%"><b>Claim Title</b></td>
        <td width="24%"><b>Claim Project</b></td>
        <td width="26%"><b>Disput By</b></td>
        <td width="13%" align="center"><b>Disput For</b></td>
        <td width="10%" align=center><b>Status</b></td>
        <td width="10%" align=center><b>Action</b></td>
      </tr>
    </thead>
    <tbody>
      <?php
	  
	  
	  $r=mysql_query("select * from " . $prev . "disputes where round_stat='Y' and `resolve`='N' 
	  order by  disput_id desc limit ".($page-1)*5 .", 5");
	  
	 
	if(!$total){ echo "<tr><td colspan=7 align=center valign=middle><font color=red>Not Found</font></td></tr>";}
	else{
	$j=0;
	
	$k=0;
	
	while($d=@mysql_fetch_array($r)):
		
		$r2=mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id='".$d['disput_by']."'"));
		$r3=mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id='".$d['disput_for']."'"));
		$r4=mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id='".$d['claim_proj_id']."'"));
				
		if(!($j%2)){$class="even";}else{$class="odd";}
		
		if($d[status]=='Y'){$status = "<font color='orange'><i>Active</i></font>";}
		
		if($d[status]=='N'){$status = "<font color='red'>Inactive</font>";}
		
		echo"<tr  class=" . $class . ">
		
			<td width=2% class=lnk><a class=lnk href='details.php?id=" . $d['disput_id'] ."'>" . $d['disput_id'] ."</a></td>
			
			<td align=left><a class=lnk href='details.php?id=" . $d['disput_id'] ."'>" . substr($d['claim_title'],0,20) . "..</a></td>"
			?>
			
			<td><? if($r4['project']!=''){ echo  substr($r4['project'],0,70);}else{ echo "Not define";}?></td>
			<? echo "<td align=left>" . $r2['fname'] . " " . $r2['lname'] . "</td>
			
			<td align=left>" . $r3['fname'] . " " . $r3['lname'] . "</td>
			
			<td align=center>" . $status . "</td>
			
			<td align=center><a class='lnk tip' title='View Open Dispute' href='details.php?id=" . $d['disput_id'] ."'><img src='images/view.png' border='0' height='20' width='20'/></a> | <a class='lnk tip' title='Delete Open Dispute'  href=\"javascript:if(confirm('Do you really want to delete the project?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d[disput_id] . "&del=1';}\"><img src='images/icon_del.png' alt='Delete' width='16' height='16' border='0'></a></td></tr>";
			$j++;			
	endwhile;
	}
	
?>
    </tbody>
  </table>
  
  <?php
if($total>5):
?>
<table  width="100%"  border="0" align="center" HEIGHT=25 cellspacing="0" cellpadding="4" style="border:1px solid #999999;">
<tr bgcolor=<?=$light?> ><td align="center">

  <?php echo paging($total,5);?>
</td></tr></table>
<?php 
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