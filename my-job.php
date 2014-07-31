<?php 
	include "configs/path.php"; 
	include("country.php");
CheckLogin();

$openjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='open'"));
$closejobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='frozen'"));
$closedjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='closed'"));
//echo "SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='closed'";
$cancelledjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='cancelled'"));
	

?>



<style type="text/css">
		@import "ottools.css";
		/* domCollapse styles */
		@import "domcollapse.css";
</style>

<!-- content-->
<div id="content">
	<div id="about_cotent">
    <!--leftside-->
   
    <!-- left side-->
    <!-- rightside-->
	
	
	
	
	
	
    <div style="margin:20px 0 10px 0;" class="">
	
	
		<div style='padding-left:10px;padding-right:10px'>


			<table class="loginclass" cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
			<td width="300" valign="top">
				
					<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td><h2><?=$lang['MY_JOB_POSTED_H']?></h2></td>
<td align=right class=subtitle valign=middle style='padding-right:10px'> <?=$lang['OPEN_H']?> :(<?=$openjobs?>)<?=$lang['CLOSE_H']?> : (<?=$closedjobs?>) <?=$lang['JB_DEL_H']?> : (<?=$closedjobs?>) <?=$lang['STAT_CNCL']?> : (<?=$cancelledjobs?>)</td></tr></table>

<table width="651" border="0" cellspacing="0" cellpadding="0">
<tr>
     <td align="left" valign="top"><img src="images/inner_bx-top.jpg" alt="image" width="651" height="10" /></td>
</tr>
<tr>
    <td align="left" valign="top" class="bx-border">

<?
if($_REQUEST[close]):
    echo"<table cellpadding=4 cellspacing=1 align=center width=100% border=0><tr bgcolor=" . $light . " class=link><td ><a href='".$vpath."my-jobs/' class=link><u><b>".$lang['MY_JOBS']."</b></u></a><b>".$lang['CLS_JB_H']." " . getproject($_REQUEST[close])."</b></td></tr>";
	
	if (mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" . $_REQUEST[close] . "' AND user_id='" . $_SESSION[user_id] . "'"))==0): 
		echo '<tr><td class=red height=50 valign=middle align=center>'.$lang['NO_JB_H'].'<br>
		<a href="'.$vpath.'my-jobs/" class="link">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';
	else:
		if(!$_REQUEST[submit]):
			echo '<tr class=link><td height=100 valign=middle><center>
			<form method="POST" action="index.php?mode=my-jobs">
			<input type="hidden" name="close" value="' . $_REQUEST[close] . '">.<$lang['JB_MSG1_H'].<b>' . getproject($_REQUEST[close]) . '</b>?
			<br><br>
			<input type="submit" value=".$lang['JB_MSG3_H']." name="submit">
			<br><br>
			<font face=verdana size=1 color=red>.$lang['JB_MSG2_H'].<br><br>
			.<?=$lang['JB_MSG4_H'].</font face=verdana size=1 >
			</form></center></td></tr></table>';
		else:
			mysql_query("UPDATE " . $prev . "projects SET status='cancelled' WHERE id='" . $_REQUEST[close] . "'");
			mysql_query("UPDATE " . $prev . "bids SET status='cancelled' WHERE id='" . $_REQUEST[close] . "'");
			echo '<tr class=link><td><center>'.$lang['PROJ_NMD'].' <b>' . getproject($_REQUEST[close]) . '</b>'. $lang['PROJ_CLSD'].'<br>'
			<a href="'.$vpath.'my-jobs/" class="link">.$lang['RETURN_TO_PREVIOUS_PAGE'].</a></td></tr></table>';
		endif;
	endif;
elseif($_REQUEST[extend]):
	echo"<table cellpadding=4 cellspacing=1 align=center width=100% border=0><tr bgcolor=" . $light . " class=link><td ><a href='".$vpath."my-jobs/' class=link><u><b>.$lang['MY_JOBS'].</b></u></a><b>.$lang['EXTD_JB_H'].:" . getproject($_REQUEST[extend]) . " </b></td></tr>";
	if(mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" . $_REQUEST[extend] . "' AND user_id='" . $_SESSION[user_id] . "'"))==0):
		echo '<tr><td class=red height=50 valign=middle align=center>'.$lang['PROJ_NOT_FND'].'<br>
		<a href="'.$vpath.'my-jobs/" class="link">'.$lang['RETURN_TO_PREVIOUS_PAGE'].'</a></td></tr></table>';
	else:
		if(!$_REQUEST[submit]):
			echo '<tr class=link><td><form method="POST" action="'.$vpath.'my-jobs/">
			<input type="hidden" name="manage" value="$lang['N_2_H']">
			<input type="hidden" name="extend" value="' . $_REQUEST[extend] . '">'
			.$lang['PROJ_EXT'].'<input type="text" name="cdays" value="' . $setting[maxextend] . '" maxlength="3" size="3">
			days (max ' . $setting[maxextend] . ')...
			<input type="submit" value="$lang['EXTEND']" name="submit"></form></td></tr></table>';
		else:
			$ii = mysql_result(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" .$_REQUEST[extend] . "'"),0,"expires")+$_REQUEST[cdays];
			if($ii>$setting[mprojectdays]):
				echo '<tr class=link><td>'.$lang['PROJ_EXT_CANT']. ' .$setting[mprojectdays]' .$lang['DAYS_SORRY'].' </td></tr></table>';
			else:
				mysql_query("UPDATE " . $prev . "projects SET expires=expires+$cdays WHERE id='" . $_REQUEST[extend] . "'");
				echo '<tr class=link><td class=link>'.$lang['PROJ_NMD'].'<b>' . mysql_result(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='" . $_REQUEST[$extend] . "'"),0,"project") . '</b>'.$lang['LOGOUT_LANG'].?>has been extended by ' . $_REQUEST[cdays] . ' days.<br>
				<a href="'.$vpath.'my-jobs/" class="link"><?=$lang['LOGOUT_LANG']?>Return to Previous Page</a></td></tr></table>';
			endif;
		endif;
	endif;	
elseif($_REQUEST[pick]):
	echo"<table cellpadding=4 cellspacing=1 align=center width=100% >
	<tr bgcolor=" . $light . " class=link><td colspan=2><a href='".$vpath."my-jobs/' class=link><u><b><?=$lang['LOGOUT_LANG']?>My Jobs</b></u></a><b> > <?=$lang['LOGOUT_LANG']?>Select A Provider</b></td></tr>";
	if(@mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='$_REQUEST[pick]' AND user_id=" . $_SESSION[user_id]))==0):
	  	echo "<tr><td height=100 valign=middle colspan=2><span class=red><?=$lang['LOGOUT_LANG']?>No project of yours was found with the specified ID number.<br>
	  	<a href='".$vpath."my-jobs/' class=link><?=$lang['LOGOUT_LANG']?>Return to Previous Page</a></td></tr></table>";
	else:
		if(!$_REQUEST[submit]):
			echo'<tr ><td class=link colspan=2><strong>Project : ' . getproject($_REQUEST[pick]) . '</strong></td></tr>
			<tr ><td class=link colspan=2>
			<?=$lang['LOGOUT_LANG']?>If you are ready to select a Provider for your project, follow the instructions below.<br>
	 		<?=$lang['LOGOUT_LANG']?>Check the box next to the provider\'s username and click the select provider button to make your selection. The Provider will be notified of your choice and asked to confirm by accepting the project by e-mail,
	 		and this job will be "frozen" so no other bids can be placed on it.<br>
	 		<?=$lang['LOGOUT_LANG']?>They will FIRST have to accept the offer before your project is considered closed for bidding.<br>
	 		<?=$lang['LOGOUT_LANG']?>If the Provider does accept, you will both be put in contact to begin your project.<br>
	 		<?=$lang['LOGOUT_LANG']?>The project will then be closed and archived. If the Provider does not respond or does not accept your project, you will be allowed to select another Web Developer.</td></tr>
	 		<tr ><td class=link>
			<form method="POST" action="index.php?mode=my-jobs">
			<input type="hidden" name="pick" value="' . $_REQUEST[pick] . '">
			<input type="hidden" name="submit" value="select"></td></tr>
			<tr ><td class=link><?=$lang['LOGOUT_LANG']?>Select a Provider and press this button.........................................
			<td align=right><input type="submit" value="<?=$lang['LOGOUT_LANG']?>Select Provider"></td></tr></table><br>
			<table width="100%" border=0 cellspacing=1 cellpadding=4 bgcolor=whitesmoke>
			<tr bgcolor="' . $light . '"  class=link><td ><b><?=$lang['LOGOUT_LANG']?>Select</b></td><td><b><?=$lang['LOGOUT_LANG']?>Provider</b></td><td><b><?=$lang['LOGOUT_LANG']?>Bid</b></td><td><b><?=$lang['LOGOUT_LANG']?>Delivery Within</b></td><td><b><?=$lang['LOGOUT_LANG']?>Time of Bid</b></td><td><b><?=$lang['LOGOUT_LANG']?>Reviews</td></tr>';
			$rez = mysql_query("SELECT * FROM " . $prev . "bids WHERE id=" . $_REQUEST[pick]);
			//echo"SELECT * FROM " . $prev . "bids WHERE id=" . $_REQUEST[pick];
			if(@mysql_num_rows($rez)==0):
				echo'<tr><td  class="red" valign=middle align=center colspan=6>(No bids yet.)</td></tr>';
			else:
				$i=0;
				while($row=mysql_fetch_array($rez)):
					$i++;
					if(!($i%2)){$bg='whitesmoke';}else{$bg='#ffffff';}
					$result4 = mysql_query("SELECT AVG(rating) as average FROM " . $prev . "ratings WHERE user_id=" . $row[user_id] . " AND type='Provider' AND status='rated'");
					if($_REQUEST[select]==$row[user_id]):
					    $bg="yellow";
						echo"<tr class=link bgcolor=yellow><td><input checked  type=radio name=chosen value=" . $row[user_id] . "></td><td><a href='".$vpath."viewprofile.php?user_id=" . getusername($row[user_id]) . "' class=link><u>" . getusername($row[user_id]) . "</u></a></td><td>".$curn . $row[amount] ."</td><td>" . $row[delivery] . " days</td><td>" . $row[date] . "</td><td>";
					else:
					    echo"<tr class=link bgcolor=" .$bg ."><td><input type=radio name=chosen value=" . $row[user_id] . "></td><td><a href='".$vpath."viewprofile.php?user_id=" . getusername($row[user_id]) . "' class=link><u>" . getusername($row[user_id]) . "</u></a></td><td>".$curn . $row[amount] ."</td><td>" . $row[delivery] . " days</td><td>" . $row[date] . "</td><td>";
					endif;
					if (mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "ratings WHERE user_id=" . $row[user_id] . " AND type='Provider' AND status='rated'"))==0):
						echo "(No Feedback Yet)";
					else:
						echo '<a href="'.$vpath.'feedback/?user_id=' . $row[user_id] . '" class=link>';
						$avgratin = round(mysql_result($result4,0,"average"), 2);
						$avgrating = explode(".", $avgratin);
						for ($t2=0;$t2<$avgrating[0]-5;$t2++):
							echo '<img src="images/img_52.jpg" border=0 alt="' . $avgratin . '/5">';
						endfor;
						$numeric2 = 10-$avgrating[0];
						if($numeric2):
							for ($b2=0;$b2<$numeric2-5;$b2++): 
								echo '<img src="images/img_54.jpg" border=0 alt="' . $avgratin . '/5">';
							endfor;
						endif;
						if(mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "ratings WHERE user_id='" . $row[user_id] . "' AND status='rated'"))==1):
							echo ' (<b>1</b> review)';
						else:
							echo ' (<b>' . mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "ratings WHERE user_id='" . $row[user_id] . "'  AND status='rated'")) . '</b> reviews)';
						endif;
						echo '</a>';
				   endif;
				   echo '</td></tr>
				   <tr bgcolor=' .$bg .'><td  colspan="6" class="link" style="border-bottom:solid 1px">' . $row[details] .'</td></tr>';
		   	    endwhile;
       	   endif;
	       echo '<tr class=link bgcolor="' . $light . '"><td ><input type=button OnClick="javascript:history.back();" value=" Back "></td><td  colspan=5 align=right><input type="submit"  value="Select Provider"></td></tr></form></table>';
       else:
	    	/*$theabsoluteresss = mysql_query("SELECT * FROM " . $prev . "transactions WHERE user_id='" . $_SESSION[user_id] . "' AND type='buyer' ORDER BY date2 DESC LIMIT 0,1");
			$nbalance = mysql_result($theabsoluteresss,0,"balance");
			if(getspecial_project($_REQUEST[pick])):
				$bidd = mysql_query("SELECT * FROM " . $prev . "bids WHERE user_id='$_REQUEST[chosen]'");
				$amnt = mysql_result($bidd,0,"amount");
				$projectper2 = $projectper2/100;
				$perc2 = $projectper2 * $amnt;
				if (mysql_result($result10090,0,"special") == "user"):
					$perc2 = $perc2 / 2;
					$projectfee2 = $projectfee2 / 2;
				endif;
				$perc2 = roundit($perc2,2);
				if ($perc2>$projectfee2):
			 		if ($perc2>$nbalance): 
						echo '<tr><td  class="red" valign=middle align=center colspan=6>ERROR: You cannot choose a Provider this project!  You do not have enough money in your account balance to cover the ' . $setting[perc] . ' commission fee.  You will need to add funds to your account balance.</td></tr></table>';
						echo'</td><td width=10>&nbsp;</td><td valign=top>' . banner("160X600") .'</td></tr></table>';
						include ("footer.inc");
						exit();
					endif;
				else:
					if ($projectfee2>$nbalance): 
						echo '<tr><td  class="red" valign=middle align=center colspan=6>ERROR: You cannot choose a Provider this project!  You do not have enough money in your account balance to cover the ' . $setting[projectfee] . ' commission fee.  You will need to add funds to your account balance.</td></tr></table>';
						echo'</td><td width=10>&nbsp;</td><td valign=top>' . banner("160X600") .'</td></tr></table>';
						include ("footer.inc");
						exit();
					endif;
				endif;
			endif;
			*/	
			mysql_query("UPDATE " . $prev . "projects SET chosen_id='$_REQUEST[chosen]', status='frozen' WHERE id='$_REQUEST[pick]'");
			mysql_query("UPDATE " . $prev . "bids SET chosen_id='$_REQUEST[chosen]', status='frozen' WHERE id='$_REQUEST[pick]'");
			$msg = $setting[emailheader] . '
			--------------------
			You were chosen for the job named "' . getproject($_REQUEST[pick]) . '".
			Important: You must first accept (or decline) this offer by going to the following URL, logging in, and confirming this project: ' . $setting[site_url] . '/index.php?mode=accept&id=' . $_REQUEST[pick] . '&confirm=' . $_REQUEST[pick] . '  
			If you wait too long another provider could be chosen! So please act now!
			If you have any problems with this step you can contact ' . $setting[emailaddress] . '
			--------------------
			' . $setting[emailfooter];
			
			mail(getemail($_REQUEST[chosen]),$setting[companyname] . " Job Bid Won",$msg,"From: $setting[retemailaddress]");
			echo '<tr><td colspan=6 class=link>The provider <b>' . getusername($_REQUEST[chosen]) . '</b> has been notified of your selection, 
			and the project named <b>' . getproject($_REQUEST[pick]) . '</b> has been "frozen" temporarily.
			You will be e-mailed when they accept (or decline) the offer.<br><br>
			You can choose a new provider anytime if <b>' . getusername($_REQUEST[chosen]) . '</b> does not respond.<br><br>
			If you do choose an alternate Web Developer, only the new provider will be able to accept your project offer.<br><br>
			<div align=right>
			<a href="' . $setting[site_url] . '/my-jobs/" class=link>Go back...</a></div></td></tr></table>';
		endif;
	endif;

else:
	echo"<table cellpadding=4 cellspacing=1 align=center width=100% bgcolor=whitesmoke>
	<tr class=link bgcolor=" . $light . "><td ><b>Job Name</b></td>
    <td><b>Bids</b></td><td><b>Status</b></td><td><b>Action<b></td></tr>";
	$tinyres = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id,date2 DESC");
	//echo"SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id DESC";
	$tinyrows = @mysql_num_rows($tinyres);
	if($tinyrows==0):
		echo '<tr><td  colspan=4 height=50 valign=middle class=red><center>(no jobs to display)</td></tr>';
	else:
		$i=0;
		while($kikrow=mysql_fetch_array($tinyres)):
			if(!($i%2)){$bg="#ffffff";}else{$bg="whitesmoke";}
			echo '<tr class=link bgcolor=' . $bg . '> <td ><a class=link href="'.$vpath.'viewprojects/' . $kikrow[id] . '/"><b><u>' . $kikrow[project] . '</u></b></a>';
			if($kikrow[special] == "featured"):
				echo' <img src="images/featured.gif" alt="Featured Project!" border=0>';
			endif;
			echo '</td> <td >' . totalbid($kikrow[id]) . '</td> <td >';
			if($kikrow[status] == "open"):
				echo '<font face=verdana size=1 color=green><b>' .  Ucwords($kikrow[status]) . '</td> <td >';
				if(totalbid($kikrow[id])):
				   echo'<a href="'.$vpath.'my-jobs/?pick=' . $kikrow[id] . '" class=link><u>Select a Provider</u></a>';
				//else:
				    
					//echo'<a href="#" class=link onclick="javascript:alert(\'No Bid yet\');"><u>Select a Provider</u></a>|';
				endif;
				echo'  <a href="'.$vpath.'my-jobs/?extend=' . $kikrow[id] . '" class=link><u>Extend</u></a> | <a href="'.$vpath.'post-job/?edit=' . $kikrow[id] . '" class=link><u>Edit</u></a> | <a href="index.php?mode=my-jobs&close=' . $kikrow[id] . '" class=link><u>Close</u></a></td></tr>';
			elseif ($kikrow[status] == "frozen"):
				echo '<span class=link>' .  Ucwords($kikrow[status]) . '</span></td> <td >
				<a href="'.$vpath.'my-jobs/?pick=' . $kikrow[id] . '" class=link><u>Pick a Provider</u></a> | <a href="'.$vpath.'my-jobs/?extend=' . $kikrow[id] . '" class=link><u>Extend</u></a> |  <a href="'.$vpath.'my-jobs/?close=' . $kikrow[id] . '" class=link><u>Close</u></a><br>
				(awaiting response from <i><a href="'.$vpath.'viewprofile.php?user_id=' . getusername($kikrow[chosen_id]) . '" class=link><u>' . getusername($kikrow[chosen_id]) . '</u></a></i>)</td></tr>';
			elseif($kikrow[status] == "cancelled"):
				echo '<font face=verdana size=1 color=red><strong>Cancelled</strong></td><td >(Project was cancelled)</td></tr>';
			elseif($kikrow[status] == "expired"):
			    echo '<font face=verdana size=1 color=red><strong>Expired</strong></td><td >(Project expired)</td></tr>';
			else:
				echo '<font face=verdana size=1 color=orange><b>' . Ucwords($kikrow[status]) . '</td> <td >You picked <a href="'.$vpath.'viewprofile.php?user_id=' .getusername( $kikrow[chosen_id] ). '/">' . getusername($kikrow[chosen_id]) . '</a> (click here to pay <a href="'.$vpath.'payment/?transfer=money&transfer2=' . $kikrow[chosen_id] . '&tamount=' . @mysql_result(mysql_query("SELECT * FROM " . $prev . "bids WHERE id='" . $kikrow[id] . "' AND user_id='" . $kikrow[chosen_id] . "'"),0,"amount") . '">' . getusername($kikrow[chosen_id]) . '</a>...)</td></tr>';
			endif;
	    	$i++;	
		 endwhile;
	 endif;
	echo"</table>";
endif;


?>

</td></tr>
<tr><td align="left" valign="top" class="inner_bx-bottom" ><br>
</td></tr></table>

			</td>
			<td valign="top" align="left" style="padding:0 0 0 0; "><?php include("includes/right.php");?>
			</td>
			</tr>
			</table>

		
	
	
	
	
	</div>
    
    </div>
    <!-- end rightside-->
    <div class="clear"></div>
    </div>
  
    <div class="clear"></div>
    
 <!-----------Footer----------------------------->
<?php include 'includes/footer.php';?> 
<!-----------Footer End----------------------------->
     <div class="clear"></div>
      <!-- end job listing chart-->
</div>
<!--end content-->
<div class="clear"></div>
</div>
 </body>
</html>
