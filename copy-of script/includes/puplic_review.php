  <table cellpadding="5" cellspacing="0" border="0" width="100%" style="Arial, Helvetica, sans-serif;" >
<tr style=" background-color:#f7f7f7;">

                      <td align="center" width=30 >




                      </td>

                      <!--<td align="left"><strong><?=$lang['CLIENT_NAME'] ?></strong></td>-->
						 <td align="left"><strong><?=$lang['PROJECT_NAME'] ?></strong></td>
                      <td align="left"><strong><?=$lang['FEEDBACK_PN'] ?></strong></td>

                      <td  align="left"><strong><?=$lang['RATTING_H'] ?></strong></td>
 <td  align="center"></td>
                    </tr>
 <?php
 $_GET[id]=$row_user[user_id];
 $all = mysql_query("select * from ".$prev."feedback where feedback_to = '".$_GET[id]."'");
			$total = mysql_num_rows($all);
			
$sql="select * from ".$prev."feedback where feedback_to = '".$_GET[id]."' ";
			
				

			 $rw4 = mysql_query($sql);
			 $rw5 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_GET[id]."'"));

		
if($total>0)

{
$clientname="0";
	$cnt = 1;
	while($rw6 = mysql_fetch_array($rw4))

	{

		$rs1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw6['feedback_from']."'"));

		

		$rs3 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".$rw6['project_id']."'"));

		$rs4 = mysql_fetch_array(mysql_query("select * from ".$prev."buyer_bids where id = '".$rw6['bidid']."'"));

		$rs5 = mysql_fetch_array(mysql_query("select * from ".$prev."feedback where project_id = '".$rw6['project_id']."' and bidid = '".$rw6['bidid']."' and feedback_from = '".$rw6['feedback_to']."'"));
$rw = mysql_fetch_array(mysql_query("select * from ".$prev."feedback where id = '".$rw6['id']."'"));
$clientname++;
	?>
     
             
                <tr>
				<td></td>
				
					<!--<td align="left" valign="center" style="font-size:12px; color:#6d6d6d; padding-left:5px;">  <a href="<?=$vpath?>publicprofile/<?=$rs1["username"]?>"><?php print ucwords($rs1['fname']).' '.ucwords($rs1['lname']);?></a> </td>-->
					 <td align="left" style="padding-left:5px;"><p><?php print ucwords($rs3['project']);?></p></td>
                <td align="left" style="padding-left:5px;"><p><?php print $rw['comments'];?></p></td>
                 
                  <td width="100"><div class="rating">
                    <?php
		
		$avg_rate=$rw['avg_rate'];
		
			for($i=0;$i<$avg_rate;$i++)
			{
			?>
                    <img src="<?=$vpath?>images/star_1.png"/>
                    <?php
			}
			for($j=5;$j>$avg_rate;$j--)
			{
			?>
                    <img src="<?=$vpath?>images/star_3.png"/>
                    <?php
			}
			?>
                  </div></td>
                  
                </tr>
               
            
             
          <?php
$cnt++;
}

}
else
{
	echo "<tr><td colspan=5><div height='100px' align='middle'>".$lang['NO_RECORD_EXISTS']."</div></td></tr>";
}


?>
   </table>        