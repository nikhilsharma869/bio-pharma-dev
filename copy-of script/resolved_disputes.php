<?php 
$current_page="Resolved Disputes"; 
include "includes/header.php"; 
CheckLogin();

$no_of_records=10;
$sql1=mysql_query("select d.*,p.project from " . $prev . "disputes d inner join  " . $prev . "projects p on d.claim_proj_id=p.id where (d.disput_by='".$_SESSION['user_id']."' or d.disput_for='".$_SESSION['user_id']."') and  d.resolve='Y'");
$total =@mysql_num_rows($sql1);

if($_GET['page'])
	{
		$sql="select d.*,p.project,u.username from " . $prev . "user u," . $prev . "disputes d inner join  " . $prev . "projects p on d.claim_proj_id=p.id where (d.disput_by='".$_SESSION['user_id']."' or d.disput_for='".$_SESSION['user_id']."') and  d.resolve='Y' and u.user_id=d.disput_by  limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
	}
else
	{	
		$sql="select d.*,p.project,u.username from " . $prev . "user u," . $prev . "disputes d inner join  " . $prev . "projects p on d.claim_proj_id=p.id where (d.disput_by='".$_SESSION['user_id']."' or d.disput_for='".$_SESSION['user_id']."') and  d.resolve='Y' and u.user_id=d.disput_by limit 0,".$no_of_records."";
	}
$r=mysql_query($sql);

?>
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="<?=$vpath?>active_dispute.html"><?=$lang['ACTIVE_DISPUTE']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['CLOSE_DISPUTE']?></a></p></div>
<div class="clear"></div>
  <?php include 'includes/leftpanel1.php';?>
  
  
 <div class="profile_right">

   <div id="wrapper_3">
              <ul class="tabs">      
                <li><a href="<?=$vpath?>active_dispute.html" class="" ><?=$lang['ACTIVE_DISPUTE']?></a></li>
                <li><a class="defaulttab selected" href="javascript:void(0);" ><?=$lang['CLOSE_DISPUTE']?> </a></li>
              </ul>
              
			 
			<div class="browse_tab-content"> 
			<div class="browse_job_middle">
              
              <table border="0" width="750" align="center" cellpadding="0" cellspacing="0" >
                  <tr>
                    <td ><table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr class="tbl_bg_1">
                        <td width="100" align="left" class="space"><?=$lang['DUPLICATE_ID']?></td>
                        <td width="180" align="center"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="10" align="left">&nbsp;</td>
                        <td width="150" align="center"><?=$lang['OTHER_PARTY']?></td>
                        <td width="120" align="center"><?=$lang['DUPLICATE_AMOUNT']?></td>
                        <td width="100" align="center"><?=$lang['RELEASE_AMT']?></td>
                        <td width="100" align="center"><?=$lang['DATE']?></td>
                      </tr>
					  <?php
					  if($total>0)
					  {
					  	$i=1;
						while($disputes=@mysql_fetch_array($r))
						{
							$k=$i%2;
							if($k==0)
							{
								$class='class="tbl_bg3"';
							}
							else
							{
								$class='class="tbl_bg2"';
							}
					  ?>
                      <tr <?=$class?> >
                        <td align="left"  class="space"><!--<a href="<?=$vpath?>disputes_details.php?disput_id=<?=$disputes[disput_id]?>">--><h1>#<? printf('%05d',$disputes[disput_id]);?></h1></td>
                        <td align="center"  style="border-right:#e9e9e9 1px dotted; "><?=$disputes['project']?></td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle" style="border-right:#e9e9e9 1px dotted; "><?=$disputes['username']?></td>
                        <td align="center" valign="middle" style="border-right:#e9e9e9 1px dotted; "><?=$disputes['claim_amount']?></td>
                        <td align="center" valign="middle" style="border-right:#e9e9e9 1px dotted; ">$<?=$disputes['received_amt']?></td>
                        <td align="center" valign="middle"><?=date('M d, Y',strtotime($disputes['date']))?></td>
                      </tr>
                      
					<?php
						$i++;
						}
					}
					?>
                     <tr><td colspan="2">
					<a class="submit_bott" style="text-decoration:none; margin:5px;" href="<?=$vpath?>create_dispute.html"><?=$lang['CREATE_NEW_DISPUTE']?></a>
					</td>
					<td colspan="5">
			 <?php
				  if($total>$no_of_records)
					{
					echo"<div align=right>". new_pagingnew(0,$vpath.'resolved_disputes/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
					}
				?>
				</td></tr>
				
                    </table></td>
                  </tr>
				  <tr><td>
				  
				</td>
				</tr>
                </table>
              
              </div>
              </div>
              
              
              
              
</div>

</div>
</div>
  
  
<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>