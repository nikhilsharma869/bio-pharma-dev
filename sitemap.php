<? 
$current_page="sitemap"; 
include "includes/header.php";
?>

<style type="text/css">
.cont{
	font-size:20px;
	font-family:Arial;
	color:#143256;
	background-color:#ffffff;
	font-weight:normal;
	font-style:normal;
	font-variant:normal;
	text-decoration:none;
	vertical-align:baseline;
	background: none repeat scroll 0 0 #FFFFFF;
	border-bottom:#0073A3 1px solid;
	float:left;
	width:100%;
}


</style>
<table width="980" bgcolor="#FFFFFF" align="center" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<table width="100%" border="0" cellspacing="0" align="center" cellpadding="0">
		<tr>
			<td width="1%">&nbsp;</td>
			<td width="16%" valign="top"></td>
			<td width="1%">&nbsp;</td>
			<td width="81%" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top"  colspan="3">
								 <table width="100%" border="0" cellspacing="0" cellpadding="0">
										
										<span class="cont">Site Map</span>
									
										<tr>
										  <td align="center" valign="middle">&nbsp;</td>
										</tr>
										<tr>
										  <td class="arr">
												<table cellpadding=2 cellspacing=0 border="0"  width="100%" align="center">
												<?
												$r=mysql_query("select * from " . $prev . "sitemap where parent_id=0 and status='Y' order by ord");
												//echo "select * from " . $prev . "sitemap where parent_id=0 order by ord";
												$j=0;
												while($d=@mysql_fetch_array($r)):
													if($d[url]):
														echo"<tr><td width=10 valign='middle' ><img src='images/icon1.png' alt'' align='middle'></td><td  align=left class='textfield' colspan=2 height='20' valign='top'><a href='".$d[url]."' title='".ucwords($d[name])."' class='textfield'><b>".ucwords($d[name])."</b></a></td></tr>\n";
														if($d[sitemap_desc]):
															echo"<tr><td width=10></td><td colspan=2>";
															$str=$d[sitemap_desc];
															eval($str);
															echo"</td><tr>\n";
														endif;
														echo"";
													else:
														echo"<tr><td width=10 valign='middle'><img src='images/icon1.png' alt='' align='middle'></td><td  align=left class='textfield' colspan=2 valign='top'>&nbsp;&nbsp;&nbsp;&nbsp;<b>".ucwords($d[name])."</b></td></tr>\n";
													endif;
													$q=mysql_query("select * from " . $prev . "sitemap where  parent_id=" . $d[id]." and status='Y' order by ord");
													//echo "select * from " . $prev . "sitemap where  parent_id=" . $d[id]." order by ord";
													while($dd=@mysql_fetch_array($q)):
														if($dd[url]):
															echo"<tr><td>&nbsp;</td><td width='10%' align='center'> <img src='images/icon1.png' alt='' align='top'></td><td colspan=2  valign='top' width='90%'><a href='".$dd[url]."' title='".ucwords($dd[name])."' class='bodytext8pt'>".ucwords($dd[name])."</a></td></tr>\n";
														else:
															echo"<tr><td>&nbsp;</td><td colspan=2 class=bodytext width='90%' valign='top'>&raquo;&raquo;".ucwords($dd[name])."</td></tr>\n";
														endif;
														$q2=mysql_query("select * from " . $prev . "sitemap where  parent_id=" . $dd[id]." and status='Y' order by ord");
														while($d2=@mysql_fetch_array($q2)):
															if($d2[url]):
																echo"<tr><td width=50></td><td></td><td valign='top'>&nbsp;&nbsp;&nbsp;<img src='images/icon1.png' alt='' align='middle'>&nbsp;<a href='".$d2[url]."' title='".ucwords($d2[name])."' class='textfield'>".ucwords($d2[name])."</a></td></tr>\n";
															else:
																echo"<tr><td width=50></td><td></td><td valign='top'>&nbsp;&nbsp;<img src='images/icon1.png' alt='' align='middle'>&nbsp;".ucwords($d2[name])."</a></td></tr>\n\n\n";
															endif;
														endwhile;
												   endwhile;
											endwhile;
											?>
											<tr><td>&nbsp;</td></tr>	
											</table></td>
										</tr>
									 </table>
						 </td>
					 </tr>
				</table>
			</td>
			<td width="1%">&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<? 
include("includes/footer.php");
?>
