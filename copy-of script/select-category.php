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


<div style='padding-left:10px;padding-right:10px'>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr><td valign=top class="bid_heading_txt">Jobs by Category </td></tr>
<tr><td  style="border-top:1px solid #87b0b1;" height=3>&nbsp;</td></tr></table>	

<?
    $r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
	$j=0;$n=0;
	while($d=mysql_fetch_array($r)):
	     if(!$j){$cls="expanded";}else{$cls="expanded";}
	     echo"<h3 class=" . $cls . ">" . $d[cat_name] . "</h3>\n
		 <div id=content><table cellpadding=2 cellspacing=0 align=center width=99%><tr class=link>\n";
    	 $rr=mysql_query("select * from " . $prev . "categories where parent_id=" . $d[cat_id] . " and status='Y' order by cat_name");
		 $i=0;
		 while($row=mysql_fetch_array($rr)):
		   	 ?>
			 <td width=25% class=link>
			 <?php 
			 $q=mysql_query("SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and " . $prev . "projects.status='open' and " . $prev . "projects_cats.cat_id='".$row['cat_id']."'");
			  
			 $count_proj=@mysql_num_rows($q);
			 $fetch_row=mysql_fetch_array($q);
			 ?>
				 <img src='images/dots.png' align=absmiddle><a class="link" href="<?=$vpath?>projects/?param=search&id=<?=$fetch_row[id];?>&cat_id=<?=$row[cat_id];?>"><?if($count_proj){echo"<strong>" . $row[cat_name] . "</strong>";}else{echo $row[cat_name];}?> (<?=$count_proj;?>)</a></td>
		    	 <?
			 $i++;
			
			 $n++;
			 if(!($i%4)){echo"</tr><tr class=link>";}
		 endwhile;
		 echo"</table></div>\n";
		 $j++;
	endwhile;
?>

