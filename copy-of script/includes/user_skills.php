	  <div class="myproheading"><h3><?=$lang['SKILLS']?></h3></div>
	 <div class="myproblock"><p>
	<table width="100%" border="0" cellspacing="0" cellpadding="5">

                    <tr style=" background-color:#f7f7f7;">

                      <td align="center" >




                      </td>

                      <td align="left"><strong><?=$lang['NM1_H']?></strong></td>

                      <td align="left"><strong><?=$lang['SELF_RATING']?></strong></td>

                      <td  align="center"></td>
 <td  align="center"></td>
                    </tr>
	<?php
	
	$skl=mysql_query("select s.name,us.rating,us.id from ".$prev."user_skills AS us left join ".$prev."skill_data as s on us.skills_id=s.id where s.status='Y' and us.user_id='".$row_user['user_id']."' order by us.id desc");

					$i=1;
					if(@mysql_num_rows($skl)>0)
					{
						$i=1;

						while($fetchskill=@mysql_fetch_assoc($skl)){


							if($i%2==0)

							{

							$c1='#f7f7f7';

							}

							else

							{

							$c1='white';

							}	

							?>

				<tr style="height: 40px; <?php if($row['readyet']=='0'){ print "background-color:#CCDDB9";}else{echo "background-color:#fff";}?>">


				 <td align="center" >




                      </td>

				<td align="left" valign="center" style="font-size:12px; color:#6d6d6d; padding-left:5px;"><?php print $fetchskill[name];?> </td>

				<td align="left" style="padding-left:5px;">

				<?php
				for($wk=1;$wk<=$fetchskill[rating];$wk++){
				?>			  
<img src="<?=$vpath?>images/skill_on.png">
				<? }

				for($wk=1;$wk<=10-$fetchskill[rating];$wk++){

				?>			  
<img src="<?=$vpath?>images/skill_off.png">
				
				<? }?>



				</td>

				<td width="3%" align="left" valign="top"></td>
				</tr>

										<?php

					

							$i++;

					

						}

				

					}

					else

					{

						?>

						<tr>

						<td colspan="4" style="color:#999999;padding-left: 250px;padding-top: 20px; font-size:12px; font-weight:bold;"><?=$lang['NO_RECORD_FOUND']?></td>

						</tr>

						<?php

					}



				  ?>

                  </table>
</div>
