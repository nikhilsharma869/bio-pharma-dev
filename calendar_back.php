<?php 
	include "configs/path.php";
	session_start();
	CheckLogin();
	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
?>

<!--<script type="text/javascript" src="js/modaldbox.js"></script>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>-->
<script type="text/javascript" src="js/jquery.fancybox-1.3.4.pack.js"></script>

<link rel="stylesheet" type="text/css" href="css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="js/jquery.hoverIntent.js"></script>
<script src="js/jquery.cluetip.js"></script>
<script src="js/demo.js"></script>

<link rel="stylesheet" href="css/jquery.cluetip.css" type="text/css" />
<link rel="stylesheet" href="css/demo.css" type="text/css" />

<link rel="stylesheet" href="jquery/jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
   
<style>
.tbp{border-top:1px solid #FF3300;
border-left:1px solid #FF3300;
font-family:arial; font-size:12px; font-weight:bold; color:#CC0000;
}

.tbp2{border-top:1px solid #FF3300;
border-left:1px solid #FF3300;
font-family:arial; font-size:12px; color:#CC0000;
padding-left:10px;
}
</style>
<style type="text/css">
 .updatebutton
 {
     background-color:#FD80FD;
    border: 0 none;
    border-radius: 5px 5px 5px 5px;
    color: #FFFFFF;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    padding: 15px 2px 15px 2px;
 }
 .profile_border{
	
	border:solid 2px #bfdfff;
	
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding:2px;
}
.special_border{
	
	border:solid 2px #ff8040;
	
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding:2px;
}
 </style>
 
<!-----------Header End-----------------------------> 

<!-- content-->
<div class="freelancer">


<!--Profile-->
<?php include 'includes/leftpanel1.php';?> 
    <!-- left side-->
    <!--middle -->
    <div class="profile_right">
	<div class="edit_profile">
	<h2>Calendar</h2>
	</div>
	<div class="edit_form_box">
      <table width="670" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td>
 <!--<table width="660" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px 20px 0px;">
  
  <tr>
    <td style="border:3px solid #c3c3c3; margin:20px 0px 20px 0px; padding:15px 0px 15px 0px;">
    	<table width="455" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="6" align="center" style="font-size:14px; font-weight:bold; color:#a1282c; padding:5px;">Show On Calendar</td>
   
  </tr>
  <tr>
    <td><input style="border:2px solid #000000;" type="checkbox"/></td>
    <td class="chbtxt">Milestone Doc</td>
    <td><input type="checkbox"/></td>
    <td class="chbtxt">Job Doc</td>
    <td><input type="checkbox"/></td>
    <td class="chbtxt">Bids Closing</td>
  </tr>
</table>

    </td>
    
  </tr>
</table>-->
</td>
          
        </tr>
        
        <tr>
          <td><!--<img src="images/calender.gif" width="657" height="564" />-->
		  
		  
		  
						  <div class="">
				
				<!--<img src="images/cal.png" height="285" width="190" alt="" />-->
				
				
				
				<!-- //////////////////////////////////////////////////// start event calender /////////////////////////////////////////////////////////////-->
				<?php
				
				
				
					$m = (!$m) ? date("m",mktime()) : "$m";
					$y = (!$y) ? date("Y",mktime()) : "$y";
				
					/*if ($_SERVER['REQUEST_METHOD'] == "POST") 
					{
						$eventdate = $_POST['eventdate']; 
						$event = $_POST['event']; 
						echo "<br />";
				
						echo "<h2>PHP Event Calendar</h2>";
						echo "This is a demo. We are not saving the event to the calendar, but you could.<br /><br />";
						echo "We are demo-ing building the calendar, and interacting with it.<br /><br />";
						echo "<b>Event:</b> $event<br />";
						echo "<b>Date:</b> $eventdate<br />";
						exit();
					}*/
					
				?>
				
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
				<td valign="top" align="center"><?php mk_drawCalendar($_GET['m'],$_GET['y'],$prev); ?></td>
				
				</tr></table>
				
				
				<?php
				
				//*********************************************************
				// DRAW CALENDAR
				//*********************************************************
				/*
					Draws out a calendar (in html) of the month/year
					passed to it date passed in format mm-dd-yyyy 
				*/
				function mk_drawCalendar($m,$y,$prev)
				{
					if ((!$m) || (!$y))
					{ 
						$m = date("m",mktime());
						$y = date("Y",mktime());
					}
				
					/*== get what weekday the first is on ==*/
					$tmpd = getdate(mktime(0,0,0,$m,1,$y));
					$month = strtoupper($tmpd["month"]); 
					$firstwday= $tmpd["wday"];
				
					$lastday = mk_getLastDayofMonth($m,$y);
				
				?>
				<table cellpadding="2" cellspacing="0" border="0" width="100%" style="background-color:#F2F6FE;">
				<tr>
				<td colspan="7" bgcolor="">
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-bottom:1px solid #00A2E8; border-top:1px solid #00A2E8;">
					<tr><th width="20" style="">
					<div style="width:30px; height:30px;  line-height:24px; background-color:#3B5998;">
					<a style="color:#FFFFFF;; text-decoration:none; font-size:2.5em;" href="<?php echo $_SERVER['PHP_SELF']; ?>?m=<?=(($m-1)<1) ? 12 : $m-1 ?>&y=<?=(($m-1)<1) ? $y-1 : $y ?>"> &lsaquo;-</a>
					</div>
					
					</th>
					<th><span style="font-size:16pt; color:#3387B1; font-family:Arial, Helvetica, sans-serif; font-weight:bold;"><?="$month $y"?></span></th>
					<th width="20" style="">
					
					<div style="width:30px; height:30px;  line-height:24px; background-color:#3B5998;">
					<a style="color:#FFFFFF; text-decoration:none; font-size:2.5em;" href="<?php echo $_SERVER['PHP_SELF']; ?>?m=<?=(($m+1)>12) ? 1 : $m+1 ?>&y=<?=(($m+1)>12) ? $y+1 : $y ?>">-&rsaquo;</a>
					</div>
					
					</th>
					</tr></table>
				</td></tr>
				
				<tr style="color:#FFFFFF; background-color:#3B5998; font-family:Verdana, Arial, Helvetica, sans-serif; height:20px; line-height:20px; ">
				
				<th width=22 class="tcell"><span style="font-weight:normal; font-size:12px;">Sunday</span></th>
				<th width=22 class="tcell"><span style="font-weight:normal; font-size:12px;">Monday</span>
				</th>
					<th width=22 class="tcell"><span style="font-weight:normal; font-size:12px;">Tuesday</span> </th>
					<th width=22 class="tcell"><span style="font-weight:normal; font-size:12px;">Wednesday</span></th>
					<th width=22 class="tcell"><span style="font-weight:normal; font-size:12px;">Thursday</span></th>
					<th width=22 class="tcell"><span style="font-weight:normal; font-size:12px;">Friday</span></th>
					<th width=22 class="tcell"><span style="font-weight:normal; font-size:12px;">Saturday</span></th></tr>
				
				<?php $d = 1;
					$wday = $firstwday;
					$firstweek = true;
				
					/*== loop through all the days of the month ==*/
					while ( $d <= $lastday) 
					{
				
						/*== set up blank days for first week ==*/
						if ($firstweek) {
							echo "<tr>";
							for ($i=1; $i<=$firstwday; $i++) 
							{ echo "<td style=\"font-weight:bold; border-right:1px solid #29245A;  border-bottom:1px solid #29245A; height:90px; width:80px;\"><font size=2>&nbsp;</font></td>"; }
							$firstweek = false;
						}
				
					
						
				
				
						/*== Sunday start week with <tr> ==*/
						if ($wday==0) { echo "<tr>"; }
				//echo $d;
						$tdate=$y.'-'.$m.'-'.$d;
						
				///////////////////////////////////////////////////////////////////  highlighted date /////////////////////////////////////////////////////////		
						
						//echo "select * from " . $prev . "events where user_id=" . $_SESSION['user_id']." and reminder_on='" . $tdate . "'";
						
						$rr=mysql_query("select * from " . $prev . "events where user_id=" . $_SESSION['user_id']." and reminder_on='" . $tdate . "'");
						$numm=@mysql_num_rows($rr);
						//$row=mysql_fetch_array($rr);
						
						/*== check for event ==*/ 
						if($numm > 0)
						{
						?>
						<td class='tcell' align='left' valign="top" style="font-weight:bold;border-right: 1px solid #3387B1; border-bottom: 1px solid #3387B1;">
						
						<div style="background-color:#FFCF9F;">
						<?php
						echo "<a style='display:block;' href=\"event.php?m=$m&y=$y&cdate=$d\" title='Reminders' rel=\"event.php?m=$m&y=$y&cdate=$d\" id='clickme_$tdate'>$d</a>";						
						?>
						</div>
                       <?php echo '<span class="reminder">'.$numm; echo (($numm>1)?' Reminders</span>':' Reminder</span>');
					   echo '<br>&nbsp;<a href="'.$vpath.'cal_reminder.php" id="various_'.$tdate.'"><span class="reminder dialink" onclick="sm(\'box\',200,50)">Set Reminder</span></a>';
					   ?>
						
                        <script type ="text/javascript">
						$('#clickme_<?php echo $tdate; ?>').cluetip({activation: 'hover', width: 250, tracking: true});						
						</script>
                        
                        <script type="text/javascript">
							$(document).ready(function() {
								/*
								*   Examples - images
								*/
								$("#various_<?php echo $tdate; ?>").fancybox({
									'width'				: '40%',
									'height'			: '56%',
									'autoScale'			: false,
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'type'				: 'iframe'
								});
							});
						</script>
                       
                       <div style="background:#021D9B; display:none;">
                       <?php //Shows the events
						//echo $sql; exit;
						$result_ev=mysql_query("select * from ".$prev."events where reminder_on='$tdate'");
						$i=0;
						while($row_ev = mysql_fetch_array($result_ev))
						  {					   
                           echo $row_ev['reminder'];
						  } 
						  ?>
                       </div>
                       
                    <!-- shows project ending day-->                       
                       <?php $result_exp = mysql_query("SELECT * FROM  " . $prev . "projects WHERE user_id='" .$_SESSION[user_id]."'");
					while($row_exp = mysql_fetch_array($result_exp))
					{
						//echo $row_exp['date2'];
						//echo date('Y-m-d', $row_exp['date2']);
						$timeStamp = $row_exp['date2'];
						$secondsPerDay = ((24 * 60) * 60);
						$timeStamp2 = time();
						$daysUntilExpiry = $row_exp['expires'];
						$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);
						echo genDate($daysUntilExpiry);
						
						if ((($daysUntilExpiry - $timeStamp2)/$secondsPerDay)<1 && (( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)>=0):
						echo " (less than a day left)";
					elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1):
					   echo " (" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) . " day";
					   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1):
						  echo "s";
					   endif;
					   echo " left)";
					else:
					   echo "<font color=red>(expired)</font>";
					endif;
					
					}?>                       
                    <!--End shows project ending day-->
                    
						</td>
						<?php
					   
						}
						else
						{
				///////////////////////////////////////////////////////////////////  highlighted date /////////////////////////////////////////////////////////			
						?>
						<td class='tcell' align='left' valign="top"  style="font-weight:bold; border-right:1px solid #29245A;  border-bottom:1px solid #29245A; height:90px; width:80px;">
						
						<div >
							<?php
							//Define start and end timestamps for the requested day
							//$time_start = mktime(0,0,0,$date['mon'],$date['mday'],$date['year']);
							//$time_end = mktime(23,59,59,$date['mon'],$date['mday'],$date['year']);
							//echo "select * from " . $prev . "events where user_id=" . $_SESSION['user_id'] . " and reminder_on = $firstwday and reminder_on <= $lastday";
							//echo '<br>';
							echo "$d";
							//echo '<div id="locations-toggle"><a href="http://yahoo.co.in">click here</a></div>';
							echo '<br>&nbsp;<a href="'.$vpath.'cal_reminder.php" id="various_'.$tdate.'"><span class="reminder dialink" onclick="sm(\'box\',200,50)">Set Reminder</span></a>';
							//$resultt=mysql_query("select * from " . $prev . "events where user_id=" . $_SESSION['user_id'] . " and reminder_on = $d");
//							 while($rowtt=mysql_fetch_array($resultt))
//							 {
								 //print_r($rowtt);								 
								 //echo 'matched';
							 //}
							
                            
						//echo "<a href=\"cal_reminder.php\" title='Set Reminder' rel=\"cal_reminder.php\" id='clickme_$tdate'>$d</a>";
						//echo "<a href=\"cal_reminder.php\" id='various_$tdate'>$d</a>";
						?>
                        
                        
                        <script type="text/javascript">
							$(document).ready(function() {
								/*
								*   Examples - images
								*/
								$("#various_<?php echo $tdate; ?>").fancybox({
									'width'				: '40%',
									'height'			: '56%',
									'autoScale'			: false,
									'transitionIn'		: 'none',
									'transitionOut'		: 'none',
									'type'				: 'iframe'
								});
							});
						</script>
						</div> 
                    <!-- shows project ending day-->                       
                       <?php $result_exp = mysql_query("SELECT * FROM  " . $prev . "projects WHERE user_id='" .$_SESSION[user_id]."' and expires between ".mktime(0,0,0,$m,$d,$y)." and ".mktime(23,59,59,$m,$d,$y)."");
					   
					   if(mysql_num_rows($result_exp)>0)
					   {
						//echo '<a href="'.$vpath.'cal_reminder.php" id="various_'.$tdate.'"><img src="images/REMINDER-01.gif" alt="Reminder"></a>';
						echo "<a style='display:block;' href=\"javascript:void(0);\" title='Reminders' rel=\"event.php?m=$m&y=$y&cdate=$d\" id='clickme1_$tdate'><img src='images/REMINDER-01.gif' alt='Reminder'></a>";
						?>
                        <script type ="text/javascript">
						$('#clickme1_<?php echo $tdate; ?>').cluetip({activation: 'hover', width: 300, tracking: true});						
						</script>
                        <?php
					   }
						
					while($row_exp = mysql_fetch_array($result_exp))
					{
						//echo $row_exp['date2'];
						//echo date('Y-m-d', $row_exp['date2']);
						$timeStamp = $row_exp['date2'];
						//echo $m.$d.$y;
						//echo mktime(0,0,0,$m,$d,$y);
						$secondsPerDay = ((24 * 60) * 60);
						$timeStamp2 = mktime(0,0,0,$m,$d,$y);
						$daysUntilExpiry = $row_exp['expires'];
						$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);
						//echo genDate($daysUntilExpiry);
						if($daysUntilExpiry >= mktime(0,0,0,$m,$d,$y) || $daysUntilExpiry <= mktime(23,59,59,$m,$d,$y))
						{
						//if(mysql_num_rows($result_exp)>0)
						//echo "<img src='images/REMINDER-01.gif' alt='Reminder'>";
						}
						/*if ((($daysUntilExpiry - $timeStamp2)/$secondsPerDay)<1 && (( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)>=0):
						echo " (less than a day left)";
					elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1):
					   echo " (" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) . " day";
					   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1):
						  echo "s";
					   endif;
					   echo " left)";
					else:
					   echo "<font color=red>(expired)</font>";
					endif;*/
					
					}?>                       
                    <!--End shows project ending day-->
						</td>
						<?php
						
						}
				
						/*== Saturday end week with </tr> ==*/
						if ($wday==6) { echo "</tr>\n"; }
				
						$wday++;
						$wday = $wday % 7;
						$d++;
					}
				?>
				
				</tr>
				
				
				
				</table>
				
				
				<?php
				/*== end drawCalendar function ==*/
				} 
				
				
				
				
				/*== get the last day of the month ==*/
				function mk_getLastDayofMonth($mon,$year)
				{
					for ($tday=28; $tday <= 31; $tday++) 
					{
						$tdate = getdate(mktime(0,0,0,$mon,$tday,$year));
						if ($tdate["mon"] != $mon) 
						{ break; }
				
					}
					$tday--;
				
					return $tday;
				}
				
				?>
				
				
				<!-- //////////////////////////////////////////////////// end event calender /////////////////////////////////////////////////////////////-->
				
				
				
				
				
				</div>
		  
		  
		  
		  </td>
          
        </tr>
        <tr>
          <td>&nbsp;</td>
          
        </tr>
        <tr>
          <td>&nbsp;</td>
          
        </tr>
        
      </table>
    </div>
	</div>
<!--end content-->


</div>
</div>
</div>
</div>
<?php include 'includes/footer.php';?> 
</body>
</html>