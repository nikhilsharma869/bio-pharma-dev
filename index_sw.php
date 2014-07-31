<?php $current_page="home"; ?>
<?php include ('includes/header.php');?> 
<!--BANNER BOX-->

<?php include 'includes/banner.php';?> 
<!--BANNER BOX END-->
<!--HOW WORKS BOX-->

<div class="middle">
        	<div class="add_back">
            	<span><?=$lang['INDEX_SPAN_H1']?><h2> <?=$lang['INDEX_SPAN_H2']?></h2></span>
                <div class="add_list">
                	<ul>
                    	<li><?=$lang['INDEX_DIV_1']?> &nbsp;
                    	  <div style="float:right;"><img src="<?=$vpath?>images/number_1.png" /></div></li>
                        <li><?=$lang['INDEX_DIV_2']?> &nbsp;<div style="float:right;"><img src="<?=$vpath?>images/number_2.png" /></div></li>
                        <li><?=$lang['INDEX_DIV_3']?> &nbsp;<div style="float:right;"><img src="<?=$vpath?>images/number_3.png" /></div></li>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
            <div class="middle_containt">
            <!---star_middle_left--->
            	<div class="left_containt">
				<form action="sear_all_jobs.php" method="POST" name="myform" id="myform">
				<div class="search_box">
				 <input type="text" name="keyword" id="keyword" value=<?=$lang['SEARCH_JOB']?> onblur="if(this.value=='')this.value='Search Job';" onfocus="if(this.value=='Search Job')this.value='';"/>
				<span> <a href="javascript:document.getElementById('myform').submit();"><img src="<?=$vpath?>images/search_icon.png" /></a></span></div>
			  	</form>
                <div style="clear:both; height:30px;"></div>
                <div class="sckil_back"><?=$lang['INDEX_DIV_4']?></div>
                <div class="skill_option_back">
				<div class="skil_option">
                        <ul>
<?php
$j=0;
$select_count_project="SELECT `".$prev."categories`.`cat_id`,`".$prev."categories`.`cat_name`,count(`".$prev."projects`.`id`) as 'pnum' FROM `".$prev."projects`,`".$prev."projects_cats`,`".$prev."categories` WHERE `".$prev."projects`.`status`='open' and   `".$prev."projects_cats`.`id`=`".$prev."projects`.`id` and `".$prev."categories`.`cat_id`=`".$prev."projects_cats`.`cat_id` group by `".$prev."categories`.`cat_id` order by `".$prev."categories`.cat_name limit 12";
//echo $select_count_project;

	$rec_skills=mysql_query($select_count_project);
	
	while($row_skills=@mysql_fetch_array($rec_skills))
	{
	if($_SESSION[lang_id])
		{
			$row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id='".$row_skills['cat_id']."' and table_name='categories' and field_name='cat_name' and lang_id='".$_SESSION[lang_id]."'"));					
			$row_skills['cat_name']=$row_content_lang['content'];
		 }
		{
?>							<li><a href="<?=$vpath?>Jobs/1/<?=$row_skills['cat_id']?>/<?=$row_skills['cat_name']?>/"><?php echo $row_skills['cat_name'];?>.&nbsp;(<?php echo $row_skills['pnum'];?>)</a></li>							
<?php
		$j++;
		}
			if(!($j%4)){
							echo'</ul>
							</div>
							<div class="skil_option">
							 <ul>';
			}
	}
?>
                	
                         </ul>
                    </div>
                </div>
                </div>
                <div style="float:left; margin-top:5px;"><img src="images/border.png" /></div>
            <!---end_middle_left--->
            <!----start_middle_right----->
            
            <div class="right_containt">
            	<h2><div style="float:left; padding-right:8px;"><img src="images/icon_1.png" /></div><?=$lang['INDEX_DIV_5']?></h2>
                <div>
                	<h3><?=$lang['INDEX_DIV_6']?><br />
	<?=$lang['INDEX_DIV_7']?> </h3>
                </div>
                
                <div style="clear:both;"></div>
                
                <h2><div style="float:left; padding-right:8px;"><img src="images/icon_2.png" /></div><?=$lang['INDEX_DIV_8']?> </h2>
                <div>
                	<h3><?=$lang['INDEX_DIV_6']?><br />
	<?=$lang['INDEX_DIV_7']?> </h3>
                </div>
                
                <div style="clear:both; height:20px;"></div>
                <div class="contrauctor_bnt"><a href="<?=$vpath?>browse-freelancers/"><?=$lang['INDEX_DIV_9']?> &#187 </a></div>
            </div>
            
            <!----start_middle_right----->
            </div>
            <div style="clear:both; height:20px;"></div>
            <div class="catagories_back">
            	<div class="catagories">
				<?php
	if($_SESSION[lang_id]){
    $row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id=35 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));
			
	$row_content['contents']=$row_content_lang[content]; 
}else{
				$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where id=35"));
				}
				?>
                	<a style="text-decoration:none;" href="<?=$vpath?>flexibility/"><h2><?=$lang['INDEX_DIV_10']?></h2></a>
                    <h3>
                    <?php echo substr(html_entity_decode($row_content['contents']),0,90);?> ...                       
                    </h3>
                    <h4><a href="<?=$vpath?>flexibility/">Read more &#187 </a></h4>
                </div>
                
                <div class="catagories">
				<?php
	if($_SESSION[lang_id]){
    $row_content_lang1=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id=36 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));
			
	$row_content1['contents']=$row_content_lang1[content]; 
}else{
				$row_content1=mysql_fetch_array(mysql_query("select * from ".$prev."contents where id=36"));
				}
				?>
                	<a  style="text-decoration:none;" href="<?=$vpath?>cost-saving/"><h2><?=$lang['INDEX_DIV_11']?></h2></a>
                    <h3>
                    <?php echo substr(html_entity_decode($row_content1['contents']),0,90);?> ...                                             
                    </h3>
                    <h4><a href="<?=$vpath?>cost-saving/">Read more &#187 </a></h4>

                                   </div>
                
                <div class="catagories">
				<?php
	if($_SESSION[lang_id]){
    $row_content_lang2=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id=37 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));
			
	$row_content2['contents']=$row_content_lang2[content]; 
}else{
				$row_content2=mysql_fetch_array(mysql_query("select * from ".$prev."contents where id=37"));
				}
				?>
                	<a style="text-decoration:none;" href="<?=$vpath?>access-to-talent/"><h2><?=$lang['INDEX_DIV_12']?></h2></a>
                    <h3>
                    <?php echo substr(html_entity_decode($row_content2['contents']),0,90);?> ...
                    </h3>
                    <h4><a href="<?=$vpath?>access-to-talent/">Read more &#187 </a></h4>
                    </div>
                
                <div class="catagories last ">
				<?php
	if($_SESSION[lang_id]){
    $row_content_lang3=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id=38 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));
			
	$row_content3['contents']=$row_content_lang3[content]; 
} else {
				$row_content3=mysql_fetch_array(mysql_query("select * from ".$prev."contents where id=38"));
				}
				?>
                	<a style="text-decoration:none;" href="<?=$vpath?>testimonials/"><h2><?=$lang['INDEX_DIV_13']?></h2></a>
                    <h3>
                    	<?php echo substr(html_entity_decode($row_content3['contents']),0,90);?> ...
	               </h3>
                   <h4><a href="<?=$vpath?>testimonials/">Read more &#187 </a></h4>
                </div>
            </div>
            <div style="clear:both; height:10px;"></div>
        </div>
		
		
		
<?php include 'includes/footer.php';?> 
