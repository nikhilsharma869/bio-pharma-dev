<?php 
$current_page="Browse Jobs by Categories";
include "includes/header.php"; 

if($_REQUEST['categoryinput']!="")
	{
		$r=mysql_query("select * from " . $prev . "categories  where cat_id=".$_REQUEST['categoryinput']." and status='Y' order by cat_name");
	}
	else
	{
		$r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
	}
	$catcount = @mysql_num_rows($r);
?>

<script language="javascript" src="<?=$vpath?>js/xpander.js"></script>
<script type="text/javascript" src="<?=$vpath?>js/jquery.min.js"></script>
<script type="text/javascript">

var limit = 3

var more = 0

$("#tricky_list li").each(function(index) {

    if(index >= limit){

        $(this).hide();

        more++;

    }

});

if(more){

    $("#tricky_list").append('<li class="more">' + more + ' more</li>');

}

$("#tricky_list li.more").live("mouseover", function(){

    $("#tricky_list li").each(function(index) {

            $(this).show();

    });

    $("#tricky_list li.more").hide()

});



</script>



<script type="text/javascript">

		$(document).ready(function() {

			setTimeout(function() {

				// Slide

				$('#menu1 > li > a.expanded + ul').slideToggle('medium');

				$('#menu1 > li > a').click(function() {

					$(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('medium');

				});

				$('#example1 .expand_all').click(function() {

					$('#menu1 > li > a.collapsed').addClass('expanded').removeClass('collapsed').parent().find('> ul').slideDown('medium');

				});

				$('#example1 .collapse_all').click(function() {

					$('#menu1 > li > a.expanded').addClass('collapsed').removeClass('expanded').parent().find('> ul').slideUp('medium');

				});

				// Fade

				$('#menu2 > li > a.expanded + ul').fadeIn();

				$('#menu2 > li > a').click(function() {

					var el = $(this).parent().find('> ul');

					if($(this).hasClass('collapsed'))

						$(el).fadeIn();

					else

						$(el).fadeOut();

					$(this).toggleClass('expanded').toggleClass('collapsed');

				});

				$('#example2 .expand_all').click(function() {

					$('#menu2 > li > a.collapsed').addClass('expanded').removeClass('collapsed').parent().find('> ul').fadeIn();

				});

				$('#example2 .collapse_all').click(function() {

					$('#menu2 > li > a.expanded').addClass('collapsed').removeClass('expanded').parent().find('> ul').fadeOut();

				});

				// Grow/Shrink

				$('#menu3 > li > a.expanded + ul').show('normal');

				$('#menu3 > li > a').click(function() {

					$(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').toggle('normal');

				});

				$('#example3 .expand_all').click(function() {

					$('#menu3 > li > a.collapsed').addClass('expanded').removeClass('collapsed').parent().find('> ul').show('normal');

				});

				$('#example3 .collapse_all').click(function() {

					$('#menu3 > li > a.expanded').addClass('collapsed').removeClass('expanded').parent().find('> ul').hide('normal');

				});

				// Appear/Disappear

				$('#menu4 > li > a.expanded + ul').show();

				$('#menu4 > li > a').click(function() {

					$(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').toggle();

				});

				$('#example4 .expand_all').click(function() {

					$('#menu4 > li > a.collapsed').addClass('expanded').removeClass('collapsed').parent().find('> ul').show();

				});

				$('#example4 .collapse_all').click(function() {

					$('#menu4 > li > a.expanded').addClass('collapsed').removeClass('expanded').parent().find('> ul').hide();

				});

				// Accordion

				$('#menu5 > li > a.expanded + ul').slideToggle('medium');

				$('#menu5 > li > a').click(function() {

					$('#menu5 > li > a.expanded').not(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('medium');

					

					$(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('medium');

					

				});

				$('#menu52 > li > a.expanded + ul').slideToggle('medium');

				$('#menu52 > li > a').click(function() {

					$('#menu52 > li > a.expanded').not(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('medium');

					

					$(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('medium');

					

				});

				$('#menu6 > li > a.collapsed + ul').slideToggle('medium');

				$('#menu6 > li > a').click(function() {

					$('#menu6 > li > a.expanded').not(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('medium');

					

					$(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('medium');

					

				});

				

				

				

			}, 250);

		});

	</script>

<div class="browse_contract">
<div class="howitworks_box">
     <div class="howitworks_text">

      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
        <tr>
          <td align="left" valign="top">
		  <?php
				$dir_cols = 4;
				$percol_short = floor($catcount / $dir_cols);
				$percol_long = $percol_short + 1;
				$longcols = $catcount % $dir_cols;
				
				$i = 0;
				$j = 0;
				$col = 0;
				$thiscolcats = 0;
				while($d=mysql_fetch_array($r))
				{
					if ($j >= $thiscolcats)
					{
						$col++;
						$thiscolcats = ($col > $longcols) ? $percol_short : $percol_long;
						$j = 0;
						echo "<td  align=\"left\" valign=\"top\" width=25%>";
					}
					$i++;
					$j++;
		?>
					<table width="100%" class="box">
					<tr>
					<td class="boxtitle"><?php echo $d['cat_name'];?></td>
					</tr>
       <?php
					$select_skills="select * from " . $prev . "categories where parent_id='".$d['cat_id']."' and status='Y' order by cat_name limit 0,15";
					$rec_skills=mysql_query($select_skills);
					$num_skills=mysql_num_rows($rec_skills);
					if($num_skills > 0)
					{
						$k=0;$flag=0;
						echo"<tr><td align='left' valign='top'><ul id='tricky_list' style='top-margin:0px;bottom-margin:0px'>";
					
					while($row_skills=mysql_fetch_array($rec_skills))
					{
						$select_count_project="select ".$prev."projects_cats.*,".$prev."projects.* from ".$prev."projects_cats,".$prev."projects where 
						".$prev."projects_cats.cat_id='".$row_skills['cat_id']."' and ".$prev."projects_cats.id=".$prev."projects.id and ".$prev."projects.status='open'";
						
						$rec_count_project=mysql_query($select_count_project);
						$num_count_project=@mysql_num_rows($rec_count_project);
		$ppm="cat_id=".$row_skills['cat_id']."&projectStatus=&budget_min=&budget_max=";
				?>
					<li ><a href="<?=$vpath?>jobs/1/<?=$row_skills['cat_id']?>/<?=$row_skills['cat_name']?>/open/0/0/"><?php echo $row_skills['cat_name'];?>.&nbsp;(<?php echo $num_count_project;?>)</a></li>
			   <?php
	
						$k++;
	
						if($k==10)
						{
						echo"</ul><span style='display:none;top-margin:0px' id=hiddenText" .$row_skills[cat_id] . "><ul style='top-margin:0px;bottom-margin:0px;width:90%;'>";	
						$flag=$row_skills[cat_id];
						}
	
					}
					echo"</ul>";
						if($k>10)
						{
							echo"</span>";	
							echo"<ul style='top-margin:0px;bottom-margin:0px'><li class='show_class' onClick=\"javascript:toggleBlockText('hiddenText" .$flag . "', this, 'Show More...', 'Show Less...', '98%');\">Show More...</li></ul>";
						}
	
					echo"</td></tr>"; 
					}
	
					else
					{
					?>
						<tr>
						<td  valign='middle' class="err" align="center" height="40"> <?=$lang['CATEGORY_COMING_SOON']?>. </td>
						</tr>
					<?php
					}
				?>
					<tr>
					<td>&nbsp;</td>
					</tr>
				</table>
            	<br />
              <?php
				
				if($j == $thiscolcats || $i == $catcount)
				echo "</td>";
				}
?>
          </td>
        </tr>
      </table>
	  
	  
</div>
</div>
</div>
 <div style="clear:both; height:10px;"></div>
<!--FOOTER BOX-->
<?php include 'includes/footer.php';?> 
<!--FOOTER BOX END-->