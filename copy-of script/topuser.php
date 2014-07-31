<?php 
	$current_page="Top Freelancers / Contractors"; 
	include "includes/header.php";
	include("country.php");
////////////////////////////////////////////////////////////// submit search skills /////////////////////////////////////////////////////
if($_REQUEST['page']==""){	$pg = 1;}else{	$pg = $_REQUEST['page'];}
if(isset($_REQUEST['skillsinput']) && $_REQUEST['skillsinput']!="")
{
	if($_REQUEST['skills']!=0)
	{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$cate_id=$_REQUEST['cate_id'];	if(!$_REQUEST['cate_id']){	$cate_id=0;	}
		//header("location:topuser.php?user=W&skills=$skills&cate_id=$cate_id");
		header("location:".$vpath."topuser/1/".$skills."/".$cate_id."/");
	}
	else
	{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$cate_id=$_REQUEST['cate_id'];
		//header("location:topuser.php?user=W&cate_id=$cate_id");
		if($cate_id==0){header("location:".$vpath."topuser/1/");}
		else{	
		header("location:".$vpath."topuser/1/".$cate_id."/");}
	}	
}

////////////////////////////////////////////////////////////// submit search skills /////////////////////////////////////////////////////



////////////////////////////////////////////////////////////// submit search category /////////////////////////////////////////////////////

if(isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput']!="")
{//echo $_REQUEST['categoryinput'];
	if($_REQUEST['categoryinput']!=0)
	{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$categoryinput=$_REQUEST['categoryinput'];
		//header("location:topuser.php?user=W&cate_id=$categoryinput");
		
		header("location:".$vpath."topuser/1/".$categoryinput."/");
	}
	else
	{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$categoryinput=$_REQUEST['categoryinput'];
		//header("location:topuser.php?user=W");
		header("location:".$vpath."topuser/1/");
	}	
}

////////////////////////////////////////////////////////////// submit search category /////////////////////////////////////////////////////


?>

<script type="text/javascript">
function funonchange(val)
{
	document.getElementById("skillsinput").value = val;
	//document.getElementById("member_right_box").style.display = 'none';
	//document.getElementById("falseiddiv").style.display = '';
	$("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	if(document.getElementById("skillsinput").value != "")
	{
		document.skillform.submit();	
	}
}

function funonchangecategory(val)
{
	document.getElementById("categoryinput").value = val;
	//document.getElementById("member_right_box").style.display = 'none';
	//document.getElementById("falseiddiv").style.display = '';
	$("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	if(document.getElementById("categoryinput").value != "")
	{
		document.categoryform.submit();	
	}
}
</script>

<div class="browse_contract">
          
   <!--Inbox Left Start-->
   <div class="inbox_left">
   <div class="inbox_left_box">
   <div class="inbox_left_text">
     <h1><?=$lang['FILTERED_BY']?></h1>
   </div>
   
   
   
   <div class="filter_box">
   <div class="filter_form">
     <h1><strong><?=$lang['CATEGORIES']?></strong></h1>
     <form name="categoryform" id="categoryform" method="post" action="">
        <?php
						if($_REQUEST['skills']!="")
						{
							$select_cate="select * from ".$prev."categories where cat_id='".$_REQUEST['skills']."'";
							$rec_cate=mysql_query($select_cate);
							$row_cate=mysql_fetch_array($rec_cate);
						}
						$r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
						?>
        <select name="category" style="padding:4px; -moz-border-radius: 2px; border-radius: 2px; border:1px solid #CCCCCC; "  onchange='funonchangecategory(this.value);'>
          <option value="0"><?=$lang['ALL']?>&nbsp;</option>
          <?php
							  while($d=mysql_fetch_array($r))
							  {
							  ?>
          <option value="<?php echo $d['cat_id'];?>" <?php if($row_cate['parent_id']==$d['cat_id']){echo "selected";}?> <?php if($_REQUEST['cate_id']==$d['cat_id']){echo "selected";}?>><?php echo $d['cat_name'];?></option>
          <?php
							  }

							  ?>
        </select>
        <input name="categoryinput" type="hidden" id="categoryinput" />
        <input name="limit" type="hidden" id="limit" value="<?php echo $_REQUEST['limit'];?>" />
      </form>
   </div>
   <div class="filter_form">
     <h1><strong><?=$lang['SKILLS']?></strong></h1>
     <form name="skillform" id="skillform" method="post" action="">
        <?php
							if($_REQUEST['cate_id']!="" && $_REQUEST['cate_id']!=0)
							{
					 			$rr=mysql_query("select * from " . $prev . "categories where parent_id='".$_REQUEST['cate_id']."' and status='Y' order by cat_name");
							}
							else
							{
								$rr=mysql_query("select * from " . $prev . "categories where parent_id!='0' and status='Y' order by cat_name");
							}
					 	?>
        <select name="skills" style="padding:4px; -moz-border-radius: 2px; border-radius: 2px; border:1px solid #CCCCCC;" onchange='funonchange(this.value);'>
          <option value="0"><?=$lang['ALL']?>&nbsp;</option>
          <?php
							  while($row=mysql_fetch_array($rr))
							  {
							  ?>
          <option value="<?php echo $row['cat_id'];?>" <?php if($_REQUEST['skills']==$row['cat_id']){echo "selected";}?>><?php echo $row['cat_name'];?></option>
          <?php
							  }
							  ?>
        </select>
        <input name="skillsinput" type="hidden" id="skillsinput" />
        <input name="limit" type="hidden" id="limit" value="<?php echo $_REQUEST['limit'];?>" />
        <input name="cate_id" type="hidden" id="cate_id" value="<?php echo $_REQUEST['cate_id'];?>"/>
      </form>
   </div>
   </div>
   
   
   
   </div>
   
   </div>    
    <!--Inbox Left End-->



	<!--Inbox right Start-->
	<div class="inbox_right">
 	 <div class="member_right_box" id="member_right_box">

  
   

<?
$no_of_records=10;
if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
//$params="&user=" . $_REQUEST[user] . "&cate_id=" . $_REQUEST['cate_id'] . "&skills=" . $_REQUEST['skills'];
$params='/';if($_REQUEST['skills']!=0){$params.=$_REQUEST['skills']."/";}if($_REQUEST['cate_id']!=0){$params.=$_REQUEST['cate_id']."/";}
///////////////////////////////////////////////////////////////////////// start search section //////////////////////////////////////////////////////

if(isset($_REQUEST['skills']) && $_REQUEST['skills']!="")
{
	$select_cate="select ".$prev."user_cats.*,".$prev."user.* from ".$prev."user_cats,".$prev."user where ".$prev."user_cats.user_id=".$prev."user.user_id and ".$prev."user_cats.cat_id ='".$_REQUEST['skills']."'";
	$rec_cate=mysql_query($select_cate);
	$user_id2='';
	while($row_cate=mysql_fetch_array($rec_cate))
	{	
		$user_id2.=$row_cate['user_id'].',';
	}
	$user_id2=rtrim($user_id2, ",");
	if($user_id2!="")
	{
		$user_id2=$user_id2;
	}
	else
	{
		$user_id2='0';
	}
}

if(isset($_REQUEST['cate_id']) && $_REQUEST['cate_id']!="" && $_REQUEST['skills']=='')
{
	$select_subcate="select * from ".$prev."categories where parent_id='".$_REQUEST['cate_id']."'";
	$rec_subcate=mysql_query($select_subcate);
	$cat_id='';
	while($row_subcate=mysql_fetch_array($rec_subcate))
	{
		$cat_id.= $row_subcate['cat_id'].',';
	}
	$cat_id=rtrim($cat_id, ",");

	$select_cate="select ".$prev."user_cats.*,".$prev."user.* from ".$prev."user_cats,".$prev."user where ".$prev."user_cats.user_id=".$prev."user.user_id and ".$prev."user_cats.cat_id in (".$cat_id.")";	

	$rec_cate=mysql_query($select_cate);
	$user_id2='';
	while($row_cate=mysql_fetch_array($rec_cate))
	{	
		$user_id2.=$row_cate['user_id'].',';
	}
	$user_id2=rtrim($user_id2, ",");
	if($user_id!="")
	{
		$user_id2=$user_id2;
	}
	else
	{
		$user_id2='0';
	}
}

///////////////////////////////////////////////////////////////////////// end search section //////////////////////////////////////////////////////

if($user_id2!="")
{
	$cond2=" and (u.user_type='W' or u.user_type='B') and u.user_id in (".$user_id2.")";
}
else
{
	$cond2=" and (u.user_type='W' or u.user_type='B')";
}

$sql1=mysql_query("select u.*,AVG(f.avg_rate) as icon from  ".$prev."user u left join ".$prev."feedback f on u.user_id=f.feedback_to where u.status='Y' ".$cond2." group by u.user_id order by icon desc") ;
$total =@mysql_num_rows($sql1);
	
if($_GET['page'])
	{
		$sql="select u.*,AVG(f.avg_rate) as icon from  ".$prev."user u left join ".$prev."feedback f on u.user_id=f.feedback_to where u.status='Y' ".$cond2." group by u.user_id  order by icon desc limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
	}
	else
	{	
	$sql="select u.*,AVG(f.avg_rate) as icon from  ".$prev."user u left join ".$prev."feedback f on u.user_id=f.feedback_to where u.status='Y' ".$cond2." group by u.user_id  order by icon desc limit 0,".$no_of_records."";
	}
	//echo $sql;
$r=mysql_query($sql);

 
	echo'<div class="browse-members_right">
     <h5>'. $total .' Freelancers Found</h5>
   </div>';

if(!$total)
{
?>
      <div style="height:100px;"></div>
      <div align="center" style="color:#3B5998; font-weight:bold;"><?=$lang['NO_RES_FOUND']?></div>
      <div style="height:100px;"></div>
      <?php
}
$j=0;
while($d=@mysql_fetch_array($r))
{

	$name = $d[fname]." ".$d[lname];
    if(!empty($d[logo]))
	{
	   $temp_logo=$d[logo];
	}
    else
	{
	   $temp_logo="images/face_icon.gif";
	}



?>
   <div class="members_right_box2">
   <div class="members_right_box2_img"><a href="<?=$vpath?>publicprofile/<?php print $d[username];?>" > <img src="<?=$vpath?>viewimage.php?img=<?php echo $temp_logo;?>&amp;width=60&amp;height=60" /></a></div>
   <div class="members_name">
     <h1> <a href="<?=$vpath?>publicprofile/<?php print $d[username];?>" ><?=txt_value_output($name);?> </a></h1>
	 <h3>  <? print_r ($country_array[$d[country]]);?> <span><img src="<?=$vpath?>cuntry_flag/<?=strtolower($d['country']);?>.png" title="France" width="16" height="11" ></span></h3>
	 <h4><?=$lang['SINCE']?><span> <?=mysqldate_show($d[reg_date])?></span></h4>
   </div>
   
   <div class="members_quality">
    <div class="right_containt1">
	 <span class="tittle"><?=$lang['RATE']?></span>
		<?php 
		$rate_fb="select AVG(avg_rate) as icon from ".$prev."feedback  where feedback_to='".$d['user_id']."' ";
		$rate_fb1="select * from ".$prev."feedback  where feedback_to='".$d['user_id']."' ";
		//echo $rate_fb;
		$rate_fbicon=mysql_fetch_array(mysql_query($rate_fb));
		$rate_fbicon1=mysql_num_rows(mysql_query($rate_fb1));
		$ic=number_format($rate_fbicon['icon'],1,'.',',');
		$icon=floor($rate_fbicon['icon']);
		for($i=0;$i<$icon;$i++)
		{
			echo '<div class="members_name_img">';
			echo "<img src='".$vpath."images/star_1.png' />";
			echo '</div>';
		}
		?>
		<h2><span><?php echo $ic; ?></span> 
			<?php
			//echo '<a class="text_hover" href="'.$vpath.'reviews.php?id=' . base64_encode($d['user_id']) . '" > ('.$rate_fbicon1.' Reviews)</a>';						
			
			echo '<a class="text_hover" href="'.$vpath.'review/' . base64_encode($d['user_id']) . '/" > ('.$rate_fbicon1.' Reviews)</a>';
			?>
			</h2>
   </div>
     <div class="right_containt1">
			<span class="tittle"><?=$lang['EARN']?></span>
			<?php
				
				$tran="select sum(balance) as earn from ".$prev."transactions where user_id=".$d[user_id]." and amttype='CR' and details not like '%Deposit%'";
				$res_tran=@mysql_fetch_array(mysql_query($tran));
				$earn=$res_tran['earn'];
				if($res_tran['earn']=="")
				{
					$earn=0.00;
				}
			?>
			<h2>$ <?php echo $earn; ?></h2>
	</div>
	<div class="clear"></div>
   <!-- <div class="invite_bnt"><a href="#">Invite</a></div>-->    
   <div class="invite_bnt"><a href="<?=$vpath?>invite-provider/<?php print $d[username];?>/"><?=$lang['INVITE']?></a></div>
  </div>
	
   <div class="members_text">
    
     <h2><?=$lang['TOP_SKILLS']?> :<span>
<?php
$skill_q="select c.parent_id,c.cat_name,c.cat_id from ".$prev."categories c inner join ".$prev."user_cats u on c.cat_id=u.cat_id where user_id=".$d[user_id];
$res_skill=mysql_query($skill_q);
while($data_skill=@mysql_fetch_array($res_skill))
{
	//$data_cat_name.=  "<a class='text_hover' href='topuser.php?user=W&skills=".$data_skill[cat_id]."'>".$data_skill['cat_name'].'</a>,';	
	
	$data_cat_name.=  "<a class='text_hover' href='".$vpath."topuser/1/".$data_skill[cat_id]."/".$data_skill[parent_id]."/'>".$data_skill['cat_name'].'</a>,';
}
$cat_name=substr($data_cat_name,0,-1);
echo $cat_name;
$data_cat_name="";
?>
</span></h2>
     
    <p><?=$d[profile];?></p>
	
   </div>
   </div>   
   
      
      <?php



    $j++;

}

if($total>$no_of_records)
{
   //echo"<div align=right>" .new_paging(0,'topuser.php','&user=W',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";  

   echo"<div align=right>" .new_pagingnew(5,'topuser/',$params,$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";

}



?>
<!--Pagination Start-->
<!--<div class="pagination_box">
<div class="pagination">
            <ul>
            <li><a href="#">&#171 Previous</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li><a href="#">Next &#187 </a></li>
          </ul>
          </div>

</div>-->
<!--Pagination End-->

 
   <div id="falseiddiv" style="display:none;">

	<div style="height:150px;"></div>

	<div align="center" style="color:#CCCCCC; font-weight:bold;"><?=$lang['LOADING']?>..<img src="images/pic-loader.gif" height="12" /></div>

	<div style="height:250px;"></div>

</div>



   </div>
   </div>
   <!--Inbox  right End-->
   </div>
 <div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?> 