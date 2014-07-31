    <div class="latest_worbox">
<div class="latest_text">
          <h1><?=$lang['SKILLS']?></h1>
            
       </div>
<div class="latest_work">
<div class="notifications"><h3>
			<?php
				$skill_q="select c.parent_id,c.cat_id,c.cat_name from ".$prev."categories c inner 
				join ".$prev."user_cats u on c.cat_id=u.cat_id where user_id=".$_SESSION['user_id'];
				$res_skill=mysql_query($skill_q);
				while($data_skill=@mysql_fetch_array($res_skill))
				{
				    $catnm = $data_skill['cat_name'];
		            if($_SESSION[lang_id])
		             {
			          $row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id='".$data_skill['cat_id']."' and table_name='categories' and field_name='cat_name' and lang_id='".$_SESSION[lang_id]."'"));					
			          $data_skill['cat_name']=$row_content_lang['content'];
		             }
					$data_cat_name.= "<a href='".$vpath."browse-freelancers/1/".$data_skill[cat_id]."/".$data_skill[parent_id]."/'>"
					.$data_skill['cat_name'].'</a> , ';
				}
				$cat_name=substr($data_cat_name,0,-1);
				echo $cat_name;
				if($cat_name=="")
				{
					echo $lang['SKILL_NOT_SET'];
				}
				
			?></h3><div class="edit_bott"><a href="<?=$vpath?>select-expertise.html"><?=$lang['EDIT']?></a></div>
			  </div>
      </div>  </div>
  