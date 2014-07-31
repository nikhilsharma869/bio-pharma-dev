<script type="text/javascript" src="domcollapse.js"></script>
<style type="text/css">
		@import "ottools.css";
		/* domCollapse styles */
		@import "domcollapse.css";
</style>
<style type="text/css">
.link_txt
{
color:#000000;
text-decoration:none;
}

</style>

<?
$total=0;

$txt="<table cellpadding=2 cellspacing=0 align=center width=99%><tr class=link>\n";
$rr=mysql_query("select * from " . $prev . "categories where parent_id!=0 and status='Y' order by cat_name");
$i=0;
while($row=mysql_fetch_array($rr)):
	$q=mysql_query("SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and " . $prev . "projects.status='open' and " . $prev . "projects_cats.cat_id='".$row['cat_id']."'");
	$count_proj=@mysql_num_rows($q);
	$fetch_row=mysql_fetch_array($q);
	if($count_proj):
	     $txt.="<td width=25% class=link>";
		 $txt.="<img src='images/dots.png' align=absmiddle><a class='link' href='" . $vpath ."projects/?param=search&id=".$fetch_row[id] ."&cat_id=" .$row[cat_id] ."'><strong>" . $row[cat_name] . "</strong>(" . $count_proj .")</a></td>";
	     $i++;
		 $total+=$count_proj;
	endif;
	if(!($i%4)){$txt.="</tr><tr class=link>";}
endwhile;
$txt.="</table>\n";
?>		 

<div style='padding-left:10px;padding-right:10px'>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr><td valign=top class="bid_heading_txt">Jobs by Category </td><td align=right class="bid_heading_txt"><?=$total?> Projects</td></tr>
<tr><td  style="border-top:1px solid #87b0b1;" height=3 colspan=2>&nbsp;</td></tr></table>	
<?
		
	echo $txt;
?>
</div>
