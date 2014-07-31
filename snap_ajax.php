<?php 
include "configs/config.php";
$dt = explode("_", $_POST['dt']);
$ndate = date("d M , Y", strtotime($dt[0] . "-" . $dt[1] . "-" . $dt[2]));

$rdt = date("Y-m-d", strtotime($dt[2] . "-" . $dt[1] . "-" . $dt[0]));

$prev = "serv_";

function getTotalHR($d) {
    //global $prev;

    $sl = "SELECT time_to_sec(TIMEDIFF(`stop_time`,`start_time`)) as wt FROM " . $prev . "project_tracker WHERE `note`='' and `stop_time`<>'0000-00-00 00:00:00' and start_time >= '" . ($d . " 00:00:00") . "' and `stop_time`<='" . ($d . " 23:59:59") . "'";
    //echo $sl;
    $r = mysql_query($sl);
    $time = 0;
    while ($t = @mysql_fetch_assoc($r)) {
        $time = $time + $t['wt'];
    }
    return $time;
}

function getTotalAMT($ts, $bid_amt) {
    return round((($bid_amt * $ts) / 3600), 2);
}
?>

<script>
    $(document).ready(function() {
        $(".fancyclass").fancybox();
    });

</script>
<?
$sl2 = "select * from " . $prev . "project_tracker_snap where project_tracker_id in (select id from " . $prev . "project_tracker where project_id='" . $_POST['pid'] . "' order by start_time) and project_work_snap_time>='" . $rdt . " 00:00:00' and project_work_snap_time<='" . $rdt . " 23:59:59'";
//echo $sl2;
$html.="<table width=100%><tr>";
$sql_query = mysql_query($sl2);
$i = 1;
while ($snap_view = mysql_fetch_object($sql_query)) {
    if ($i == 3) {
        $html.="									
			<td><div class='pro_imgShowArea'>
				<div class='proImgArea'> 
					<a  class='fancyclass' rel='gallery' href='" . $vpath . "viewimage.php?img=time_tracker/mediafile/" . $_POST['pid'] . "_" . $snap_view->id . ".jpg&width=1024&height=768' id='showimg" . $snap_view->id . "' >
					   <img src='" . $vpath . "viewimage.php?img=time_tracker/mediafile/" . $_POST['pid'] . "_" . $snap_view->id . ".jpg&width=165&height=135'/>
					</a>		
				</div>
				 <div class='proDateText'>" . $snap_view->project_work_snap_time . "</div>
			</div></td></tr><tr>
	";
        $i = 1;
    } else {
        $html.="									
			<td><div class='pro_imgShowArea'>
				<div class='proImgArea'> 
					<a  class='fancyclass' rel='gallery' href='" . $vpath . "viewimage.php?img=time_tracker/mediafile/" . $_POST['pid'] . "_" . $snap_view->id . ".jpg&width=1024&height=768' id='showimg" . $snap_view->id . "' >
					   <img src='" . $vpath . "viewimage.php?img=time_tracker/mediafile/" . $_POST['pid'] . "_" . $snap_view->id . ".jpg&width=165&height=135'/>
					</a>		
				</div>
				 <div class='proDateText'>" . $snap_view->project_work_snap_time . "</div>
			</div></td>
	";
        $i++;
    }
}
$html.="
	</div>
	
</div>
";

echo $html;
?>











