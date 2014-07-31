<?php 
include("includes/header_dashbord.php");
include("includes/access.php");
?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script><script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script><script type="text/javascript" src="js/jquery.flot.min.js"></script>
<script>$.noConflict();</script>

	
	
<div class="main">
<?php include("includes/left_side.php"); ?>
<!-- End #sidebar  -->
<section id="content">
<div class="wrapper">

<!---- breadcrumb ---->
<div class="crumb">
<ul class="breadcrumb">
<li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
<!--   <li><a href="#">Library</a></li>
<li class="active">Data</li>-->
</ul>

</div>
<!---- breadcrumb ---->

<div class="container-fluid">
<div id="heading" class="page-header">
<h1><i class="icon20 i-file-7"></i>Dashboard</h1>
</div>

<div class="row">
<?php
function edustat($table,$table_id,$type="")
{
global $db,$dbh,$prev;

if($type){$type2="where ".$type;}else{$type2="";}
   $q="select count(".$table_id.") from ".$prev.$table." ".$type2;
$r=mysql_query($q);
$total=@mysql_result($r,0);

return $total;
}
function edustat_deposite($table,$amt,$type="")
{
global $db,$dbh,$prev;
if($type){$type2="where ".$type;}else{$type2="";}
 $q="select sum(".$amt.") from ".$prev."".$table." ".$type2;
$r=mysql_query($q);
$total=@mysql_result($r,0);

return $total;
}
$main_bg_color="#a6d2ff";
		
?>

<div class="col-lg-12">
<div class="panel panel-default">	<div class="panel-heading">		<div class="icon"><i class="icon20 file"></i></div>		<h4>Member</h4>		<a class="minimize" href="#"></a>	</div><!-- End .panel-heading -->	<div class="panel-body">									<?php                                                             $total_member =(int) edustat("user", "user_id", "");                                                                     $active = (int) edustat(user, 'user_id', "status='Y'");								$active = ceil((100 * $active)/$total_member);								$inactive = (int) edustat(user, 'user_id', "status='N'");								$inactive = ceil((100* $inactive)/ $total_member);																$suspended = (int) edustat(user, 'user_id', "status='S'");								$suspended = ceil((100* $suspended)/ $total_member);                               ?>		<div class="campaign-stats center">					  <div class="panel-body">                                    <div class="campaign-stats center" style="border-top:none;">                                        <div class="items">                                            <div class="percentage" data-percent="100"><span><?=$total_member?></span></div>                                            <div class="txt">Total</div>                                        </div>                                        <div class="items">                                            <div class="percentage" data-percent="<?=$active?>"><span><?= $active?></span>%</div>                                            <a href="javascript:void(0);"><div class="txt">Active</div></a>                                        </div>																				<div class="items red">                                            <div class="percentage-red" data-percent="<?=$suspended?>"><span><?=$suspended?></span>%</div>                                            <a href="javascript:void(0);"><div class="txt">Suspended</div></a>                                        </div>																				 <div class="items red">                                            <div class="percentage-red" data-percent="<?=$inactive?>"><span><?=$inactive?></span>%</div>                                            <a href="javascript:void(0);"><div class="txt">Inactive</div></a>                                        </div>                                    </div>                                    <div class="clearfix"></div>                                </div><!-- End .panel-body -->		</div>		<div class="clearfix"></div>	</div><!-- End .panel-body --></div><div class="panel panel-default">	<div class="panel-heading">		<div class="icon"><i class="icon20 file"></i></div>		<h4>Project</h4>		<a class="minimize" href="#"></a>		</div><!-- End .panel-heading -->	<div class="panel-body">		  <?php                            $total_member =(int) edustat('projects','id', "");							$openproject = (int) edustat('projects', 'id', "status='open'");							$openproject = ceil((100 * $openproject)/$total_member);							$progress = (int) edustat('projects', 'id', "status='process'");							$progress = ceil((100 * $progress)/$total_member);							$expired = (int) edustat('projects', 'id', "status='expired'");							$expired = ceil((100 * $expired)/$total_member);							$frozen = (int) edustat('projects', 'id', "status='frozen'");							$frozen = ceil((100 * $frozen)/$total_member);															$complete = (int) edustat('projects', 'id', "status='complete'");							$complete = ceil((100* $complete)/ $total_member);														$close = (int) edustat('projects', 'id', "status='close'");							$close = ceil((100* $close)/ $total_member);                               ?>		<div class="campaign-stats center">					  <div class="panel-body">                                    <div class="campaign-stats center" style="border-top:none;">                                        <div class="items">                                            <div class="percentage" data-percent="100"><span><?=$total_member?></span></div>                                            <div class="txt">Total</div>                                        </div>                                        <div class="items">                                            <div class="percentage" data-percent="<?=$openproject?>"><span><?= $openproject?></span>%</div>                                            <a href="javascript:void(0);"><div class="txt">Open Project</div></a>                                        </div>  																				<div class="items">										<div class="percentage" data-percent="<?=$progress?>"><span><?= $progress?></span>%</div>											<a href="javascript:void(0);"><div class="txt">Progress</div></a>                                        </div>																				<div class="items red">                                            <div class="percentage-red" data-percent="<?=$expired?>"><span><?=$expired?></span>%</div>                                            <a href="javascript:void(0);"><div class="txt">Expired</div></a>                                        </div>																				 <div class="items">                                            <div class="percentage" data-percent="<?=$frozen?>"><span><?=$frozen?></span>%</div>                                            <a href="javascript:void(0);"><div class="txt">Frozen</div></a>                                        </div>																				<div class="items">                                            <div class="percentage" data-percent="<?=$complete?>"><span><?=$complete?></span>%</div>                                            <a href="javascript:void(0);"><div class="txt">Complete</div></a>                                        </div>																					<div class="items red">                                            <div class="percentage-red" data-percent="<?=$close?>"><span><?=$close?></span>%</div>                                            <a href="javascript:void(0);"><div class="txt">Closed</div></a>                                        </div>                                    </div>                                    <div class="clearfix"></div>                                </div><!-- End .panel-body -->		</div>		<div class="clearfix"></div>	</div><!-- End .panel-body --></div></div>

<div class="panel panel-default">
	
	<div class="panel-body">

	<div class="campaign-stats center">
		
			  <div class="panel-body">

                                    <div class="campaign-stats center" style="border-top:none;"><style>#tooltip{background:#000; color:#fff;padding:5px 10px;font-family:inherit; font-size:9px;}.tooltip{position:absolute;z-index:1030;display:block;visibility:visible;font-size:11px;line-height:1.4;opacity:0;filter:alpha(opacity=0);}.tooltip.in{opacity:0.8;filter:alpha(opacity=80);}.tooltip.top{margin-top:-3px;padding:5px 0;}.tooltip.right{margin-left:3px;padding:0 5px;}.tooltip.bottom{margin-top:3px;padding:5px 0;}.tooltip.left{margin-left:-3px;padding:0 5px;}.tooltip-inner{max-width:200px;padding:8px;color:#ffffff;text-align:center;text-decoration:none;background-color:#000000;-webkit-border-radius:0;-moz-border-radius:0;border-radius:0;}.tooltip-arrow{position:absolute;width:0;height:0;border-color:transparent;border-style:solid;}.tooltip.top .tooltip-arrow{bottom:0;left:50%;margin-left:-5px;border-width:5px 5px 0;border-top-color:#000000;}.tooltip.right .tooltip-arrow{top:50%;left:0;margin-top:-5px;border-width:5px 5px 5px 0;border-right-color:#000000;}.tooltip.left .tooltip-arrow{top:50%;right:0;margin-top:-5px;border-width:5px 0 5px 5px;border-left-color:#000000;}.tooltip.bottom .tooltip-arrow{top:0;left:50%;margin-left:-5px;border-width:0 5px 5px;border-bottom-color:#000000;}</style><table width="100%" align="center" bgcolor="<?=$main_bg_color?>" border="0" cellpadding="4" cellspacing="0">  <tr style="background-color:#CACAC2">    <td colspan="3" align="left"><strong>Graph Chart</strong></td>  </tr>  <tr class="lnk" bgcolor="#ffffff">  	<td align="left" width="50%">    <div id="chartplace" style="height:300px;"></div>    <script type="text/javascript">    jQuery(document).ready(function() {              // simple chart		var active = [						<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`user_id`) AS am FROM `".$prev."user` WHERE `status` = 'Y' AND `reg_date` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.$res['am'].']';								}								else{									echo '['.$i.', '.$res['am'].'], ';								}						}						?>					];		var inactive = [					<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`user_id`) AS am FROM `".$prev."user` WHERE `status` = 'N' AND `reg_date` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.$res['am'].']';								}								else{									echo '['.$i.', '.$res['am'].'], ';								}						}						?>						];      	var suspended = [						<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`user_id`) AS am FROM `".$prev."user` WHERE `status` = 'S' AND `reg_date` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.$res['am'].']';								}								else{									echo '['.$i.', '.$res['am'].'], ';								}						}						?>						];									function showTooltip(x, y, contents) {			jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {				position: 'absolute',				display: 'none',				top: y + 5,				left: x + 5			}).appendTo("body").fadeIn(200);		}				var plot = jQuery.plot(jQuery("#chartplace"),			   [ { data: active, label: "Active Member", color: "#6fad04"},              	 { data: inactive, label: "Inactive Member", color: "#06b"},				 { data: suspended, label: "Suspended Member", color: "#06c"}],				  {				   series: {					   lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },					   points: { show: true }				   },				   legend: { position: 'nw'},				   grid: { hoverable: true, clickable: true, borderColor: '#666', borderWidth: 2, labelMargin: 10 },				   xaxis: { min: <?=date('Y')-5?>, max: <?=date('Y')?>,                 			tickFormatter: function suffixFormatter(val, axis) {                    			return (val.toFixed(0));               			 	}						 }				 });				var previousPoint = null;		jQuery("#chartplace").bind("plothover", function (event, pos, item) {			jQuery("#x").text(pos.x);			jQuery("#y").text(pos.y);						if(item) {				if (previousPoint != item.dataIndex) {					previousPoint = item.dataIndex;											jQuery("#tooltip").remove();					var x = item.datapoint[0];					var y = item.datapoint[1];											showTooltip(item.pageX, item.pageY,									item.series.label + " " + parseInt(y) + " on " + parseInt(x));				}						} else {			   jQuery("#tooltip").remove();			   previousPoint = null;            			}				});				jQuery("#chartplace").bind("plotclick", function (event, pos, item) {			if (item) {				jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");				plot.highlight(item.series, item.datapoint);			}		});    });</script>    </td>    <td align="left" width="50%">    <div id="chartplace1" style="height:300px;"></div>    <script type="text/javascript">    jQuery(document).ready(function() {              // simple chart		var openp = [						<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'open' AND `creation` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.intval($res['am']).']';								}								else{									echo '['.$i.', '.intval($res['am']).'], ';								}						}						?>					];		var progress = [						<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'process' AND `creation` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.intval($res['am']).']';								}								else{									echo '['.$i.', '.intval($res['am']).'], ';								}						}						?>					];      	var complete = [						<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'complete' AND `creation` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.intval($res['am']).']';								}								else{									echo '['.$i.', '.intval($res['am']).'], ';								}						}						?>					];		var expire = [						<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'expired' AND `creation` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.intval($res['am']).']';								}								else{									echo '['.$i.', '.intval($res['am']).'], ';								}						}						?>					];		var frozen = [						<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'frozen' AND `creation` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.intval($res['am']).']';								}								else{									echo '['.$i.', '.intval($res['am']).'], ';								}						}						?>					];												var frozen = [						<?php 						for($i=intval(date('Y')-5); $i<= date('Y'); $i++){								$qry = mysql_query("SELECT COUNT(`id`) AS am FROM `".$prev."projects` WHERE `status` = 'close' AND `creation` LIKE '".$i."-%'");								$res = mysql_fetch_assoc($qry);								if($i== date('Y')){									echo '['.$i.', '.intval($res['am']).']';								}								else{									echo '['.$i.', '.intval($res['am']).'], ';								}						}						?>					];											function showTooltip(x, y, contents) {			jQuery('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {				position: 'absolute',				display: 'none',				top: y + 5,				left: x + 5			}).appendTo("body").fadeIn(200);		}						var plot = jQuery.plot(jQuery("#chartplace1"),			   [ { data: openp, label: "Open Project", color: "#6fad04"},              { data: progress, label: "On Progress Project", color: "#06c"},			  { data: complete, label: "Completed Project", color: "#d6c"},			  { data: frozen, label: "Frozen Project", color: "#dfc"},			   { data: close, label: "Close Project", color: "#EB7D00"},              { data: expire, label: "Expired Project", color: "#f00"} ], {				   series: {					   lines: { show: true, fill: true, fillColor: { colors: [ { opacity: 0.05 }, { opacity: 0.15 } ] } },					   points: { show: true }				   },				   legend: { position: 'nw'},				   grid: { hoverable: true, clickable: true, borderColor: '#666', borderWidth: 2, labelMargin: 10 },				   xaxis: { min: <?=date('Y')-5?>, max: <?=date('Y')?>,                 			tickFormatter: function suffixFormatter(val, axis) {                    			return (val.toFixed(0));               			 	}						 }				 });				var previousPoint = null;		jQuery("#chartplace1").bind("plothover", function (event, pos, item) {			jQuery("#x").text(pos.x);			jQuery("#y").text(pos.y);						if(item) {				if (previousPoint != item.dataIndex) {					previousPoint = item.dataIndex;											jQuery("#tooltip").remove();					var x = item.datapoint[0].toFixed(0),					y = item.datapoint[1].toFixed(1);											showTooltip(item.pageX, item.pageY,									item.series.label + " of " + x + " = " + y);				}						} else {			   jQuery("#tooltip").remove();			   previousPoint = null;            			}				});				jQuery("#chartplace1").bind("plotclick", function (event, pos, item) {			if (item) {				jQuery("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");				plot.highlight(item.series, item.datapoint);			}		});    });</script>    </td>  </tr></table>
                                    </div>



                                    <div class="clearfix"></div>



                                </div><!-- End .panel-body -->

		</div>

		<div class="clearfix"></div>

	</div><!-- End .panel-body -->
</div>




</div><!-- End .col-lg-12  -->   



</div><!-- End .row-fluid  -->
</div> <!-- End .container-fluid  -->
</div> <!-- End .wrapper  -->
</section>
</div><!-- End .main  -->
</body>
</html>