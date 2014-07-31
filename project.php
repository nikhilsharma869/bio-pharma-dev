

<script>



function validBid()



{



   //alert("test");



   if(!document.getElementById("bidamount1").value)



   {



      alert("<?=$lang['ENT_VLD_AMT_BD_H']?>");



	  return false;



   }



    if(document.getElementById("bidamount1").value)



   {



      if(isNaN(document.getElementById("bidamount1").value))



	  {



	      alert("<?=$lang['ENT_VLD_AMT_BD_H']?>");



	      return false;



	  }



   }



   



   if(!document.getElementById("delivery").value) 



   {



      alert("<?=$lang['ENT_DEL_DAY_H']?>");



	  return false;



   }



    if(document.getElementById("delivery").value)



   {



       if(isNaN(document.getElementById("delivery").value))



	  {



       alert("<?=$lang['ENT_DEL_DAY_H']?>");



	   return false;



	  }



   }



    if(!document.getElementById("details").value)



   {



      alert("<?=$lang['DESC_ABT_BD_H']?>");



	  return false;



   }



}



</script>



<?



if($_REQUEST[id]):



	$result = mysql_query("SELECT * FROM  " . $prev . "projects WHERE id='" .$_REQUEST[id]."'");



	//echo"SELECT * FROM  " . $prev . "projects WHERE id='" .$_REQUEST[id]."'";



	if(@mysql_num_rows($result)==0):



	   $err="<div align=center calss=red><strong>".$lang['JOB_NO_FD_ID_H']."</strong></div>";



   else:



       $d=mysql_fetch_array($result);



       



   endif;



endif;	



?>



<table width="90%" border="0" align="center" cellspacing="0" cellpadding="0" style="color:#4E4D4D; font-size:14px; font-family:Tahoma,Arial,Verdana,Sans-serif;">



<tr><td align="left" valign="middle" style="color:#666666;" ><div class="singuptest" style="margin-bottom:0px; font-size:18px;color:#a1282c; "><?=$d['project']?>&nbsp;&nbsp;&nbsp;







<?



/*if($d[special]== "featured"):







	echo "<img src='images/featured.png'  style=' position:absolute; padding-left:2px;' />";



endif;*/



?>







</div>







<div style="height:5px;"></div>



</td></tr>



<?



if($err):



  echo"<tr><td height=100>" . $err . "</td></tr>";



endif;



?>



</table>	



<?



if($_REQUEST[id] && !$err):



     ?>



	    <table border=0 cellspacing=0 cellpadding=0 width=90%  align=center bgcolor=#ffffff>



		<tr>



		<td>



					<table border=0 cellspacing=0 cellpadding=4 width=100%  align=center bgcolor=#ffffff>



					



					<tr bgcolor=whitesmoke>



					  <td   colspan=2 class=header_text1 style='padding-left:10px; color:#666666;'><strong><?=$lang['JOB_SUMM_H']?></strong></td><tr>



					<tr  class=link ><td style='padding-left:30px; height:10px;' width="25%" ></td><td ></td></tr>



					<tr  class=link ><td style='padding-left:30px' width="25%" ><b><b><?=$lang['ID_H']?> :</b></td><td ><?=$d[id];?></td></tr>



					<TR class=link ><TD valign=top style='padding-left:30px'><b><?=$lang['JOB_TYPE']?> :</b></TD>



					<TD  valign=top >



					<?php



					$rr=mysql_query("select * from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $d[id]);



					//echo"select * from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $d[id];



					$txt="";



					while($dd=@mysql_fetch_array($rr)):



					  $txt.=$dd[cat_name] . " , ";



					endwhile;



					if($txt!=""){



					echo substr($txt,0,-2);



					}



					else



					{



					  echo $lang['NOT_DFND'];



					}



					?>



					</TD></TR>



					<TR class=link ><TD width=25% valign=top style='padding-left:30px'><b><?=$lang['STATUS']?> :</b></TD><TD width=85%  valign=top >



					<?



					$secondsPerDay9 = ((24 * 60) * 60);



					$timeStamp9 = time();



					$daysUntilExpiry9 = mysql_result($result,0,"expires");



					$getdat9  = $timeStamp9 + ($daysUntilExpiry9 * $secondsPerDay9);



					$thedat9  = $getdat9-$timeStamp9;



					$realdat9 = round($thedat9/((24 * 60) * 60));



					$explod9  = explode('-', $projectudays);



					for($i9=0;$i9<count($explod9);$i9++):



						if($realdat9==$explod9[$i9]):



							echo "<img src='images/urgent.gif' alt='Urgent!' border=0>";



						endif;



					endfor;



					if($d[status] == "cancelled"):



						echo "<font color=red>".$lang['CANC_PROJ']."</font>";



					elseif($d[status] == "closed"):



						$chosen_id=$d[chosen_id];



						//echo " Chosen Provider : <a href='index.php?mode=viewprofile&user_id=" . $d[chosen_id] .  "'>" . getusername($d[chosen_id]) . "</a> ";



						$result2 = mysql_query("SELECT * FROM  " . $prev . "user WHERE user_id='" . $d[chosen_id] . "'");



						if(@mysql_result($result2,0,"special")):



							echo " <a href='".$vpath."special/' target=_new><br><img src='images/certificate.gif' alt='" . $setting[specialalt] . "' border=0></a>";



						endif;



					endif;



					echo Ucwords($d[status]) . " ";



					if($d[status] == "cancelled" || $d[status] == $d[closed] || $d[status] == "expired"):



					   echo $d[status] . "|";



					   echo"<font color=red>".$lang['NO_BDDNG']."</font>";



					elseif($d[status] == "frozen"):



					  echo $lang['NO_BDDNG_2'];



					endif;



					$secondsPerDay29 = ((24 * 60) * 60);



					$timeStamp29 = time();



					$daysUntilExpiry29 = mysql_result($result,0,"expires");



				  



					$getdat29 = $timeStamp29 + ($daysUntilExpiry29 * $secondsPerDay29);



					$thedat29 = $getdat29-$timeStamp29;



					$realdat29 = round($thedat29/((24 * 60) * 60));



					$explod29 = explode('-', $projectudays);



					for($i29=0;$i29<count($explod29);$i29++):



					   if($realdat29==$explod29[$i29]):



							echo "<span class='splashorange'><br> ".$lang['URGENT']."!";



					   endif;



					endfor;



					?></TD></TR>



					<TR class=link ><TD  valign=top style='padding-left:30px'><b><?=$lang['POSTJOB_DIV_14']?> </b></TD>



					<TD  valign=top ><?=$budget_array[$d[budget_id]]?></TD></TR>



					<tr  class=link ><td style='padding-left:30px; height:10px;' width="25%" ></td><td ></td></tr>



					 <TR bgcolor=whitesmoke ><TD  valign=top class=header_text1 style='padding-left:10px; color:#666666;' colspan=2><b><?=$lang['JOB_CREATOR_H']?> </b></TD></tr>



					 <tr  class=link ><td style='padding-left:30px; height:10px;' width="25%" ></td><td ></td></tr>



					  <TR class=link ><TD  valign=top style='padding-left:30px'><b><?=$lang['NM1_H']?> :</b></TD>



					 <td>



                     <?php $result222 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$d["user_id"]."'"));?>



                     <a href='<?=$vpath?>publicprofile.php?id=<?=base64_encode($d["user_id"]);?>' class=link><u><?=$result222[fname].' '.$result222[lname];?></u></a></td></tr>



					 <TR class=link ><TD  valign=top style='padding-left:30px'><b><?=$lang['FDB_SCOR_BD_H']?> :</b></TD><td>



					<? if(getspacial($d[user_id])){echo"<a href='<?=$vpath?>special/' class=link><img src='images/certificate.gif' border=0 hspace=4></a><br>";}



					$result8 = mysql_query("SELECT AVG(rating) as average2 FROM  " . $prev . "ratings WHERE user_id='" . $d[user_id] . "' AND status='rated'");



					if(@mysql_num_rows(mysql_query("SELECT * FROM  " . $prev . "ratings WHERE user_id='" . $d[user_id] . "' AND type='buyer' AND status='rated'"))==0):



						echo '<img src="images/none.gif">';



					else:



						echo"<a href='index.php?mode=feedback&user_id=" . $d[user_id] . "' class=link>";



						$avgratin8 = round(mysql_result($result8,0,"average2"), 2);



						$avgrating8 = explode(".", $avgratin8);



						for($t28=0;$t28<$avgrating8[0]-5;$t28++):



							echo "<img src='images/star.gif' border=0>";



						endfor;



						$numeric28 = 5-$avgrating8[0];



						if($numeric28):



							for($b28=0;$b28<$numeric28-5;$b28++):



								 echo "<img src='images/star_gray.gif' border=0>";



							endfor;



						endif;



						if(@mysql_num_rows(mysql_query("SELECT * FROM  " . $prev . "ratings WHERE user_id=" . $d[user_id] . " AND status='rated'"))==1):



							echo "(1 review)";



						else:



						   $n=@mysql_num_rows(mysql_query("SELECT * FROM  " . $prev . "ratings WHERE user_id=" . $d[user_id] . " AND status='rated'"));



						   echo "(" . $n . ' reviews)';



						endif;



						echo "</a>";



					endif;



					?>



					</td></tr>



					<tr  class=link ><td style='padding-left:30px; height:10px;' width="25%" ></td><td ></td></tr>



					<tr bgcolor=whitesmoke><td   colspan=2 class=header_text1 style='padding-left:10px; color:#666666;'><strong><?=$lang['SUMMERY_BD_H']?></strong></td><tr>



					<tr  class=link ><td style='padding-left:30px; height:10px;' width="25%" ></td><td ></td></tr>



					<TR class=link ><TD  valign=top style='padding-left:30px' ><b><?=$lang['BEGAN_BD_H']?> :</b></TD>



					<TD  valign=top ><? echo genDate($d[date2]); ?></TD></TR>



					<TR class=link ><TD valign=top style='padding-left:30px'><b><?=$lang['EXPRESS_BD_H']?> :</b></TD>



					<TD  valign=top>



					<?php



					



					$secondsPerDay = ((24 * 60) * 60);



			



					$timeStamp = mysql_result($result,0,"date2");



					$timeStamp2 = time();



			



					$daysUntilExpiry = mysql_result($result,0,"expires");



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



					   echo "<font color=red>(".$lang['EXPIRED'].")</font>";



					endif;



					?>



					</TD></TR>



					<?



					//echo $_REQUEST[id];



					 $totalbid=totalbid($_REQUEST[id]);



					 $avaragebid=avaragebid($_REQUEST[id]);



					 /*$a=explode(".", $avaragebid);



					 $a1=$a[0];*/



					 $avaragebid=ceil($avaragebid);



					 $total_messages=total_messages($_REQUEST[id]);



				  if($totalbid):?>



					 <TR class=link ><TD  valign=top style='padding-left:30px'><b><?=$lang['COUNT_BD_H']?> :</b></TD>



					 <TD  valign=top><?=$totalbid;?></TD></TR>



				  <?



				  endif;



				  if($avaragebid):?>



					 <TR class=link><TD  valign=top style='padding-left:30px'><b><?=$lang['AVG_BD_H']?> :</b></TD>



					 <TD  valign=top colspan=2><? echo $setting[currency]?><?=$avaragebid?></TD></TR>



				  <?



				  endif;



				  if($total_messages):?>



					 <TR class=link><TD  valign=top bgcolor=whitesmoke align=right><b><?=$lang['MSG_POSTED_H']?> :</b></TD>



					 <TD  valign=top><?=$total_messages?></TD></TR>



				  <?



				  endif;



				  ?>



					</table>



		</td>



		</tr>



		



		</table> 



		<table border=0 cellspacing=0 cellpadding=4 width=90%  align=center bgcolor=#ffffff >



		<tr><td   colspan=2 class=header_text1 style='padding-left:10px; color:#666666; height:10px;'></td><tr>



		



		<tr bgcolor=whitesmoke><td   colspan=2 class=header_text1 style='padding-left:10px; color:#666666;'><strong><?=$lang['DESCRIPTION']?></strong></td><tr>



		<tr><td   colspan=2 class=header_text1 style='padding-left:10px; color:#666666; height:10px;'></td><tr>



        <tr ><td style='padding-left:30px' colspan=2 class=link>



		<?=nl2br($d[description])?>



		</td></tr>



		



  		   <TR class=link ><TD width="16%" valign=top align=right ><b><?=$lang['ATTACH_IF_H']?>:</b></TD>



    	   <TD  valign=top >



           <?







		   if($d[attachment]!= ""):



		   



			    $e=explode(",",$d['attachment']);



				



				for($i=0;$i<count($e);$i++):



					 $t=explode("@",$e[$i]); 



					 echo"<a href='" . $vpath .  $e[$i] . "' class=link>" . $t[1] . "</a><br>\n";



				endfor;



			



		    else:



			  echo $lang['NO_ATTACH'];



		   endif;



           ?>



           </TD></TR>



           <?php



     



        



	    $r3=mysql_query("select * from " . $prev . "projects_additional where  project_id=" . $_REQUEST[id]);



	   



		if(@mysql_num_rows($r3)):



		?>



		<TR class=link bgcolor=whitesmoke><TD  colspan=2 class=header_text1 style='border-bottom:1px solid #eaeaea;border-top:1px solid #eaeaea;padding-left:10px'><b><?=$lang['ADD_INFO_H']?></b></TD></tr>



		<TR class=link ><TD width="15%" valign=top style='padding-left:30px' colspan=2>



		<?



		while($dd=@mysql_fetch_array($r3)):



			



			echo"(" . date('F d,Y g:i a',$dd['date']) . " EST)....<br><br>\n";



			if($dd[info]):



				echo nl2br($dd[info]) . "<br><br>\n";



			endif;



			if($dd['attached_file']):



			    $e=explode(",",$dd['attached_file']);



				echo"<b><u>".$lang['ATTACH_H']."</u> : </b>";



				$txt="";



				for($i=0;$i<count($e);$i++):



					 $t=explode("@",$e[$i]); 



					$txt.="<a href='" . $vpath .  $e[$i] . "' class=link>" . $t[1] . "</a>, \n";



				endfor;



				echo substr($txt,0,-1);



			endif;



		endwhile;



		?>



	   </TD></TR>



        <?php



	   endif;



	   $rr=mysql_query("select * from " . $prev . "invite where id=" . $_REQUEST['id']);



	   if(@mysql_num_rows($rr)):



	       ?>



		   <tr bgcolor=whitesmoke><td   colspan=2 class=header_text1 style='border-bottom:1px solid #eaeaea;border-top:1px solid #eaeaea;padding-left:10px'><strong><?=$lang['DESCRIPTION']?></strong></td><tr>



           <tr ><td style='padding-left:30px' colspan=2 class=link>



		   <?



		   while($dd=mysql_fetch_array($rr)):



		      echo "<a href='".$vpath."viewprofile.php?user_id=" .getusername($dd[user_id]) . "' class=link>" . getusername($dd[user_id]) ."</a>&nbsp;&nbsp;";



		   endwhile;  



		   ?>



		   </td></tr>



		   <?



	   endif;



	  ?>



	  </TABLE>



	  <br> 



	 <?php



	 if(($d[status] == "open" || $d[status] == "closed") && $_SESSION[user_id]!=$d[user_id]):







	     $q="select * from ".$prev."messages where readyet=1 and private_id=".$_SESSION['user_id']." and id=".$_REQUEST['id'];



	     $q=mysql_query($q);



		 $msg_count=@mysql_num_rows($q);



	     ?>



	     <table border=0 cellspacing=0 cellpadding=4 width=90% align=center bgcolor=#ffffff >



	     <TR class=link><TD width="50%" style='background-color:#f5f5f5;border-bottom:solid 1px #eaeaea;border-top:solid 1px #eaeaea'>



		 <? if($d[status] == "open"){?>



		 <A href="<?=$vpath?>bid.php?id=<?=base64_encode($_REQUEST[id]);?>"><button class="submit_bott"><?=$lang['SUBMISSION7']?></button></A>



		 <?



		 }



		 ?>



		 </TD>



	     <td style='background-color:#f5f5f5;border-bottom:solid 1px #eaeaea;border-top:solid 1px #eaeaea'>



		 <A href="<?=$vpath?>message.board.php?id=<?=$d["user_id"];?>" ><button class="submit_bott"><?=$lang['SEND_MSG_H']?></button></A>



		 </td>



		 <td style='background-color:#f5f5f5;border-bottom:solid 1px #eaeaea;border-top:solid 1px #eaeaea'><font color="#FF0000"><!--<?=$msg_count?>&nbsp;unread messages--></font></td>



		 <td align=right style='background-color:#f5f5f5;border-bottom:solid 1px #eaeaea;border-top:solid 1px #eaeaea'>



<a href="<?php echo $vpath;?>pop-violation.php?bidder_id=<?=$d[user_id]?>&project_id=<?=$_REQUEST[id]?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="button-small">

		<!-- <a href="javascript://" onclick="javascript:window.open('<?php echo $vpath;?>pop-violation.php?bidder_id=<?=$d[user_id]?>&project_id=<?=$_REQUEST[id]?>','_new','width=500,height=400,left=100,top=80,addressbar=no');">-->



		 <button class="submit_bott"><?=$lang['REPORT_VIOLATION']?></button></a>



		 </TD></TR>



	     </TABLE>



	     <P>



	     <?php



 	  endif;



	  ?>

		<A href="<?=$vpath?>message.board.php?id=<?=$_REQUEST[id];?>" ><button class="submit_bott" style="margin-left:43px;"><?=$lang['SEND_MSG_H']?></button></A>

	  <table border=0 cellspacing=0 cellpadding=4 width=90% align=center bgcolor=#ffffff >



	  



	  	  <TR  ><TD colspan="5" style=' height:10px;'></TD>



     </TR>



	  



	  



	  



	  



	  <TR class="bid_number_heading_txt" ><TD style='background-color:#f5f5f5; color:#a1282c;'><b><?=$lang['PROV_H']?></b></TD>



      <TD align="right" class="bid_number_heading_txt" style='background-color:#f5f5f5; color:#a1282c;'><b><?=$lang['BID']?></b></TD>



	  <TD class="bid_number_heading_txt" style='background-color:#f5f5f5; color:#a1282c;'><b><?=$lang['DELIVRY_DAYS']?></b></TD>



	  <TD align="center" class="bid_number_heading_txt" style='background-color:#f5f5f5; color:#a1282c;'><b><?=$lang['TIME_BID_H']?></b></TD>



      <TD align=CENTER class="bid_number_heading_txt" style='background-color:#f5f5f5; color:#a1282c;'><b><?=$lang['RATTING_H']?></b></TD></TR>



	   <TR  ><TD colspan="5" style=' height:10px;'></TD>



     </TR>



      <?php



	  $j=0;



      $bees = mysql_query("SELECT * FROM  " . $prev . "buyer_bids WHERE project_id='" . $_REQUEST[id] . "' ORDER BY bid_amount ASC, add_date ASC");



	  //echo "SELECT * FROM  " . $prev . "buyer_bids WHERE project_id='" . $_REQUEST[id] . "' ORDER BY amount ASC, date2 ASC";



 	  if(@mysql_num_rows($bees)==0):



          echo "<TR class=link><td align='center' colspan=6>".$lang['NO_BD_PLCD']."</td></tr>";



      else:



	  	  while($row=mysql_fetch_array($bees)):



	   	      $j++;$cup="";



			  if(!($j%2)){$bg="whitesmoke";}else{$bg="#ffffff";}



			  if($chosen_id==$row[user_id]){$bg="#ffcece";$cup="<img src='images/cup.png' border=0 width=20 ALIGN=absmiddle>";}



		      ?>



  		      <TR class=link bgcolor=<?=$bg?>><TD valign=top><A href="<?=$vpath?>publicprofile.php?id=<?=base64_encode($row[bidder_id]);?>" style="text-decoration:none;"><b><?=getfullname($row[bidder_id]);?></b></A>&nbsp;&nbsp; <?=$cup?>



              <?php



		      $check4 = mysql_query("SELECT * FROM  " . $prev . "user WHERE user_id='" . $row[user_id] . "' AND special='user'");



              if(@mysql_num_rows($check4)){echo "<a href='".$vpath."special/' target_new class=link><br><img src='images/certificate.gif' alt='" . $setting[specialalt] . "' border=0></a>";}



              ?>



              </TD><TD align=right><? echo $setting[currencytype] . ' ' . $setting[currency]; ?> <? echo $row[bid_amount];?></TD>



              <TD ><? echo $row[duration]; ?><?=$lang['DAYS_H']?> </TD><TD align=center><?=date('d-m-Y', strtotime($row[add_date]));?></TD><TD class="lnk" align=center>



              <?



		      $chick = mysql_query("SELECT AVG(rating) as average FROM  " . $prev . "ratings WHERE user_id='" . $row[user_id] . "' AND type='freelancer' AND status='rated'");



              if(@mysql_num_rows(mysql_query("SELECT * FROM  " . $prev . "ratings WHERE user_id='" . $row[user_id] . "' AND type='freelancer' AND status='rated'"))==0):



                 echo "<img src='images/none.gif'>";



              else:



			  	 echo "<br><a href='".$vpath."feedback.php?user_id=" . $row[user_id] . "'>";



				 $avgratin = round(mysql_result($chick,0,"average")-5, 2);



			     $avgrating = explode(".", $avgratin);



				 for($t2=0;$t2<$avgrating[0];$t2++):



					 echo"<img src='images/star.gif' border=0 alt='" . $avgratin . "/5'>";



				 endfor;



			 	 $numeric2 = 5-$avgrating[0];



				 if($numeric2):



					for($b2=0;$b2<$numeric2;$b2++):



						echo "<img src='images/star_gray.gif' width=7 border=0 alt='" . $avgratin . "/5'>";



					endfor;



				 endif;



				 if (@mysql_num_rows(mysql_query("SELECT * FROM  " . $prev . "ratings WHERE user_id='" . $row[user_id] . "'  AND status='rated'"))==1):



					echo "<div align=center>(1 review)</div>";



				 else:



					 echo "<div align='center'>(" . @mysql_num_rows(mysql_query("SELECT * FROM  " . $prev . "ratings WHERE user_id='" . $row[user_id] . "'  AND status='rated'")) . ' reviews)</div>';



                 endif;



                 echo"</a>";



             endif;



             ?>



             </TD></TR>



             <TR class=link bgcolor=<?=$bg?>><TD  colspan=4><?=$row[details];?></TD><td align=right><a href="pop-violation.php?bidder_id=<?=$row[bidder_id]?>" onclick="return hs.htmlExpand(this, {objectType: 'iframe', width: 555, height: 470, allowSizeReduction: false, wrapperClassName: 'draggable-header no-footer', preserveContent: false,headingText: 'Terms &amp; Conditions', objectLoadTime: 'after'})"><img src='images/bu-violation.gif' border='0' alt='Violation'></a></td></TR>



			 



             <?php



         endwhile;



      endif;



      ?>



      </TABLE>



      <P>



<?







elseif($_REQUEST[delbid]):



	$result = mysql_query("SELECT * FROM  " . $prev . "buyer_bids WHERE project_id='" . $_REQUEST[delbid] ."' AND user_id='" . $_SESSION[user_id] . "'");



	if(@mysql_num_rows($result)==0):



		echo '<div class=red align=center>'.$lang['ERROR_BID_ID'].'<br>



		<a href="javascript:history.go(-1);">'.$lang['GO_BK'].'</a></div>';



	else:



		mysql_query("DELETE FROM  " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[delbid] . " AND user_id='" . $_SESSION[user_id] . "'");



		echo '<div class=link align=center>'.$lang['BID_DLT'].'</div>';



	endif;



elseif($_REQUEST[invite]):



     echo"<table border=0 cellspacing=0 cellpadding=0 width=98%  align=center bgcolor=#ffffff ><tr><td>";



	 echo '<table border=0 cellspacing=0 cellpadding=4 width=98% align=center style="border:solid 2px ' . $light .'">



	 <TR class=link ><td class=title colspan=3>'.$lang['INVT_TO'].' : ' . getusername($_REQUEST[invite]) . '</td></tr>';







	$realun = mysql_query("SELECT * FROM  " . $prev . "user WHERE user_id='" . $_REQUEST[invite]);



	if(@mysql_num_rows($realun)==0):



		echo "<tr><td align=center height=200 valign=middle>".$lang['NO_PRVDR_ACC']." " . getusername($_REQUEST[invite]) . "<br>



		<a href='javascript:history.go(-1);' class=link><u>".$lang['GO_BK']."</u></a></td></tr></table>";



	else:



	    $dd=mysql_fetch_array($realun);



		$result = mysql_query("SELECT * FROM  " . $prev . "projects WHERE user_id=" . $_SESSION[user_id] . " AND status='open'");



		if(@mysql_num_rows($result)==0):



		    echo "<tr><td align=center height=200 valign=middle><div align=center class=red>".$lang['NO_OPN_JBS']."<br>



            <a href='my-jobs.php' class=link><u>".$lang['MNG_ACC']."</u>...</a></div></td></tr></table>";



        else:



           if(!$_REQUST[confirm]):



               echo '<tr><td align=center height=200 valign=middle><form method="POST" action="index.php?mode="' . $_REQUEST[mode] .'">



			   <input type="hidden" name="invite" value="' . $_REQUEST[invite] . '">'



			   .$lang['PROJ_INVT'].' <a href="' . $setting[site_url] . '/index.php?mode=viewprofile&user_id=' . $_REQUEST[invite] . '">' . getusername($_REQUEST[invite]) . '</a> '.$lang['BID_ON'].'



			   <select name="project" size="1">';



			   while ($row=mysql_fetch_array($result)):



				   echo'<option value="' . $row[id] . '">' . $row[project] . '</option>';



			   endwhile;



			   echo '</select><input type=hidden name=confirm value=1> <input type=image src="images/invite_white.jpg"></form></td></tr></table>';



           else:



		       mysql_query("insert into " . $prev . "invite set id=" . $d[project] . ",user_id=" . $_REQUEST[invite]);



			   $emaddr = $dd[email];



			   $mymess = $setting[emailheader] . "\n";



			   $mymess .= "\n";



			   $mymess .= $_SESSION[username] . $lang['INVT_BID_JOB'] . getproject($d[project]) . $lang['VIEW_URL'] . $setting[site_url] . "/index..php?mode=project.dtl&id=" . $d[project] . "\n";



			   $mymess .=-"\n";



			   $mymess .= $setting[emailfooter] . "\n";



			   mail($emaddr,$setting[companyname] . $lang['PRJ_INVT'],$mymess,$lang['FROM_H'] . $setting[retemailaddress]);



			   echo '<tr><td align=center height=200 valign=middle class=link>'.$lang['INVT_SUCC'] . getusername($_REQUEST[invite]) . '.</td></tr></table>';



		   endif;



       	endif;



    endif;



elseif($_REQUEST[bid]):



    if($_SESSION[user_type]=="W" || $_SESSION[user_type]=="B"):



	    $d=mysql_fetch_array(mysql_query("select profile from ".$prev."user where user_id=".$_SESSION['user_id']));



		$n=@mysql_num_rows(mysql_query("select user_id from ".$prev."user_cats  where user_id=".$_SESSION['user_id']." limit 1"));



		if(!$n || !$d['profile']){ redirect($vpath."profile.php");}



    endif;



	



    $result = mysql_query("SELECT * FROM  " . $prev . "projects WHERE id='" . $_REQUEST[bid] . "' AND status='open'");



   	$d=mysql_fetch_array($result);



	echo"<table border=1 cellspacing=0 cellpadding=0 width=98%  align=center bgcolor=#ffffff >



	<tr><td>";



    echo "<table border=1 cellspacing=0 cellpadding=4 width=100% align=center bgcolor=#ffffff >



	<TR class=link  ><td    class='bid_heading_txt' >".$lang['B_MSG1']." : <a href='".$vpath."project-dtl.php?id=" . $_REQUEST[bid]."' class='bid_heading_txt' > ". $d[project] . "</td></tr>";







	if(!$_SESSION[user_id]):



   		redirect($vpath."login.php?msg=''");



	endif;



	$result = mysql_query("SELECT * FROM  " . $prev . "projects WHERE id='" . $_REQUEST[bid] . "' AND status='open'");



	if(@mysql_num_rows($result)==0):



		echo '<tr><td  height=200 valign=middle><div align=center class=red>'.$lang['ERR_NO_JOB'].'<br>



		<a href="javascript:history.go(-1);">'.$lang['GO_BK'].'</a></div>';



		echo"</td></tr></table>";



		



	endif;



	$d=mysql_fetch_array($result);



	if(!$_REQUEST[submit]):



		$da=mysql_query("SELECT * FROM  " . $prev . "buyer_bids WHERE project_id='" . $_REQUEST[bid] ."' AND user_id=" . $_SESSION[user_id]);



		$data=mysql_fetch_array($da);



		echo '<form method="POST" name="bidform" action="project-dtl.php?bid=' . $_REQUEST[bid] . '" onSubmit="javascript:return validBid();">



		<input type="hidden" name="bid" value="' . $_REQUEST[bid] . '">



		<tr class=link bgcolor=whitesmoke><td  style="border-bottom:1px solid #eaeaea;border-top:1px solid #eaeaea;padding-left:10px"><b>'.$lang['TOT_BID_JB'].' (' . $setting[currencytype] . $setting[currency]. ') :</b></td></tr>';



		if($d["budgetmin"] == "" && $d["budgetmax"] !== ""):



			echo '<tr class=link ><td style="padding-left:30px"><span class="lnk">'.$lang['JOB_BUDG_MAX'] . $setting[currencytype] . '' . $setting[currency] . '' .$d[budgetmax] . '</td></tr>';



		elseif($d[budgetmin] !== "" && $d[budgetmax] == ""):



			echo '<tr class=link ><td style="padding-left:30px"><span class="lnk">'.$lang['JOB_BUDG_MIN'] . $setting[currencytype] . '' . $setting[currency] . '' . $d[budgetmin] . '</td></tr>';



		elseif ($d[budgetmin] !== "" && $d[budgetmax] !== ""):



			echo '<tr class=link ><td style="padding-left:30px"><span class="lnk">'.$lang['JOB_BUDG'] . $setting[currencytype] . '' . $setting[currency] . '' . $d[budgetmin] . ' - ' . $setting[currencytype] . '' . $setting[currency] . '' . $d[budgetmax] . '</td></tr>';



		endif;



	    echo'<tr class=link ><td style="padding-left:8px">'.$setting[currencytype] . $setting[currency] .'<input type="text" name="bidamount1" id="bidamount1" maxlength="6" size="6" value="'. $data[bidamount] . '" onKeyUp="javascript:getbid(' . $setting[projectper] . ');"> + ' . $setting[commision] . $lang['ONEOUT_CHRG'].$setting[currencytype] . $setting[currency].' <input type="text" name="bidamount" id="bidamount" maxlength="6" size="6" value="'. $data[bidamount] . '" > &laquo; '.$lang['B_MSG5'].'</td></tr>



		<tr class=link bgcolor=whitesmoke><td style="border-bottom:1px solid #eaeaea;border-top:1px solid #eaeaea;padding-left:10px"><b>'.$lang['B_MSG6'].'?</b> </td></tr>



		<tr class=link><td style="padding-left:30px"><input type="text" id="delivery" name="delivery" maxlength="3"  size="6" value="'. $data[delivery] . '"> '.$lang['B_MSG7'].'';



		$secondsPerDay = ((24 * 60) * 60);



		$timeStamp = time();



		$daysUntilExpiry = mysql_result($result,0,"expires");



		$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);



		$date  = getdate($expiry);



		$month = $date["mon"];



		$day   = $date["mday"];



		$year  = $date["year"];



		$expiryDate = $month . '/' . $day . '/' . $year;



		//echo '<font size=1 face=verdana color=gray>(The user wants the project completed by ' . $expiryDate. ', which is ';



		if ($expiry==0):



			//echo 'in less than one day.)';



		elseif($expiry>=1):



			//echo 'in ' . ( $expiry - $timeStamp ) / $secondsPerDay . ' day';



			if($expiry>=1):



				//echo "s.)";



			else:



				//echo "expired.)";



			endif;



			//echo'</font>';



		endif;



		if($data[outbid]){$checked=" Checked";}



		echo'</td></tr>



		<tr class=link bgcolor=whitesmoke><td  style="border-bottom:1px solid #eaeaea;border-top:1px solid #eaeaea;padding-left:10px"><b>'.$lang['B_MSG8'].'</b></td></tr>



		<tr class=link ><td style="padding-left:30px"><textarea rows="10" id="details" name="details" cols="50" style="width:100%" value="' . $data[details] . '"></textarea></td></tr>



		<tr class=link><td style="padding-left:30px"><input type="checkbox" name="outbid" value="y" ' .$checked . '> '.$lang['NOT_EML_BID'].'</td></tr>



		<tr class=link ><td  style="padding-left:30px"><input type="submit" value="'.$lang['B_MSG9'].'" name="submit" class=link></td></tr></form>';



	    echo"</table>"; 



	else:



	    echo"<table border=0 cellspacing=0 cellpadding=0 width=98%  align=center bgcolor=#ffffff >



	    <tr><td>";



	    if(preg_match("/^\\d+$/", $_REQUEST[bidamount])) {}



	



		else



		{



			echo '<div class=red>'.$lang['ERR_BD_POS'].'<br>



			<a href="javascript:history.go(-1);">'.$lang['GO_BK'].'</a></div>';



			echo"";



		}



		if($_SESSION[type]=="W" || $_SESSION[type]=="B")







		{



			echo '<div class=red>'.$lang['ERR_PRVR_BD'].'<br>



			<a href="javascript:history.go(-1);">Go Back...</a></div>';



			echo"";



			



		}



		//setcookie ("fusername", $username,time()+999999);



		//setcookie ("fpassword", $password,time()+999999);



		$today = getdate();



		$month = $today['mon'];



		$day = $today['mday'];



		$year = $today['year'];



		$hours = $today['hours'];



		$minutes = $today['minutes'];



		$_REQUEST[bidremind] = mysql_query("SELECT * FROM  " . $prev . "bids WHERE id='$_REQUEST[bid]' AND amount>$_REQUEST[bidamount] AND outbid='y' AND user_id!=" . $_SESSION[user_id]);



		while ($row=mysql_fetch_array($_REQUEST[bidremind])):



			$emails = mysql_query("SELECT * FROM  " . $prev . "programmers WHERE user_id=" . $row[user_id]);



			$mymess = $setting[emailheader] . "\n" . 



			



			$_SESSION[username] . $lang['OUTBID_MSG'] . $vpath . 'project-dtl?bid=' . $_REQUEST[bid] ."\n" . 



			



			$setting[emailfooter];



			@mail(mysql_result($emails,0,"email"),$companyname . $lang['JOB_OUTBID'],$mymess,$lang['FROM_H'].":".$retemailaddress);



		endwhile;



		$result = mysql_query("SELECT * FROM  " . $prev . "projects WHERE id='" . $_REQUEST[bid] . "' AND status='open'");



		$bidnotify = mysql_query("SELECT * FROM  " . $prev . "user WHERE user_id='" . mysql_result($result,0,"user_id") . "'");



		if (@mysql_result($bidnotify,0,"bidnotify") !== ""):



		    $mymess2 = $setting[emailheader] .  $_SESSION[username] . $lang['HAS_BID'] . $setting[currencytype] . '' . $setting[currency] . ' ' . $_REQUEST[bidamount] . $lang['VIEW_DET'] . $setting[site_url] . '/project-dtl.php?id=' . $_REQUEST[bid] . 



			$setting[emailfooter];



			@mail(@mysql_result($bidnotify,0,"email"),$setting[companyname] . $lang['JOB_BID_NOTC'],$mymess2,$lang['FROM_H'].":". $setting[retemailaddress]);



		endif;



		$prevbid = mysql_query("SELECT * FROM  " . $prev . "bids WHERE id='" . $_REQUEST[bid] . "' AND user_id=" . $_SESSION[user_id]);



		if (@mysql_num_rows($prevbid)==0):



			mysql_query("INSERT INTO  " . $prev . "bids (user_id, status, id, project, special, amount, delivery, date, details, date2, chosen_id, outbid) VALUES (\"" . $_SESSION[user_id] . "\", 'open', \"" . $_REQUEST[bid] . "\", \"" . $d[project] . "\", \"" . $d[special] . "\", \"" . $_REQUEST[bidamount] . "\", \"". $_REQUEST[delivery] . "\", \"" . genDate(time()) . "\", \"" . $details . "\", \"" . time() . "\", '', \"" . $_REQUEST[outbid] . "\")");



			echo"INSERT INTO  " . $prev . "bids (user_id, status, id, project, special, amount, delivery, date, details, date2, chosen_id, outbid) VALUES (\"" . $_SESSION[user_id] . "\", 'open', \"" . $_REQUEST[bid] . "\", \"" . $d[project] . "\", \"" . $d[special] . "\", \"" . $_REQUEST[bidamount] . "\", \"". $_REQUEST[days] . "\", \"" . genDate(time()) . "\", \"" . $details . "\", \"" . time() . "\", '', \"" . $_REQUEST[outbid] . "\")";die();



			echo '<tr><td><br><p align=center class=link>'.$lang['MSG_BID_SUCC'].'<br>



			'.$lang['NOTF_EML'].'<br>



			<a href="'.$vpath.'project-dtl.php?id=' . $_REQUEST[bid] . '" class=link><b>'.$lang['GO_BK'].'</b></a>



			<!--<META HTTP-EQUIV=REFRESH CONTENT="30; URL="'.$vpath.'project-dtl.php?id=' . $_REQUEST[bid] . '">--></td></tr></table>';



		else:



			mysql_query("UPDATE  " . $prev . "bids SET amount='$_REQUEST[bidamount]', delivery='$days', date='" . genDate(time()) . "', details='$details', date2='" . time() . "', outbid='" . $_REQUEST[outbid] . "' WHERE id='" . $_REQUEST[bid] . "' AND user_id=" . $_SESSION[user_id]);



			echo '<tr><td><br><span class=link><br><center>'.$lang['MSG_BID_SUCC'].'<br>



			'.$lang['NOTE_OLD_BID'].'<br>



			'.$lang['NOTF_EML'].'<br>



			<a href="'.$vpath.'project-dtl.php?id=' . $_REQUEST[bid] . '" class=link><b>.'$lang['GO_BK']'.</b></a>



			<!--<META HTTP-EQUIV=REFRESH CONTENT="30; URL="'.$vpath.'project-dtl.php?id=' . $_REQUEST[bid] . '">--></span></td></tr></table>';



		endif;



	endif;



	echo"</td><td width=320 align=right valign=top>" . banner("300X250")."</td></tr></table>";



endif;



?>



<script>



function getbid(n)



{



  if(!isNaN(document.getElementById("bidamount1").value))



  {



  	document.getElementById("bidamount").value=(parseFloat(document.getElementById("bidamount1").value)*.10) + parseFloat(document.getElementById("bidamount1").value);



  }



}







</script>