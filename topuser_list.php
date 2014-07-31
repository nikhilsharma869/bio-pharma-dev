<?php 

	include "includes/header.php";

////////////////////////////////////////////////////////////// submit search skills /////////////////////////////////////////////////////

if(isset($_REQUEST['skillsinput']) && $_REQUEST['skillsinput']!="")
{
	if($_REQUEST['skills']!=0)
	{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$cate_id=$_REQUEST['cate_id'];
		header("location:browse-freelancers.php?user=W&skills=$skills&cate_id=$cate_id");
	}
	else
	{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$cate_id=$_REQUEST['cate_id'];
		header("location:browse-freelancers.php?user=W&cate_id=$cate_id");
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



		header("location:browse-freelancers.php?user=W&cate_id=$categoryinput");



	}



	else



	{



		$limit=$_REQUEST['limit'];



		$skills=$_REQUEST['skills'];



		$categoryinput=$_REQUEST['categoryinput'];



		header("location:browse-freelancers.php?user=W");



	}	



}

////////////////////////////////////////////////////////////// submit search category /////////////////////////////////////////////////////


?>
<script type="text/javascript">



function funonchange(val)



{



	document.getElementById("skillsinput").value = val;



	document.getElementById("contentiddiv").style.display = 'none';



	document.getElementById("falseiddiv").style.display = '';



	if(document.getElementById("skillsinput").value != "")



	{



		document.skillform.submit();	



	}



}







function funonchangecategory(val)



{



	//alert(val);



	document.getElementById("categoryinput").value = val;



	document.getElementById("contentiddiv").style.display = 'none';



	document.getElementById("falseiddiv").style.display = '';



	if(document.getElementById("categoryinput").value != "")



	{



		document.categoryform.submit();	



	}



}











</script>

<div class="freelancer">
  <h1><span>Find a Freelancer</span></h1>
  
  <!--/////////////////////////////////////////////////////////////// start Browse Freelancers  section  ///////////////////////////////////////////////////-->
  <div class="freelancer_left1">
    <div id="contentiddiv">
      <?



include("country.php");


$no_of_records=10;
if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}



$limit=" limit " . ($_REQUEST['limit']-1)*20 . ",20";







$str= $_SERVER['REQUEST_URI'];



$arr=array();



$arr=explode("/",$str);



$page=$arr[3];







$params="&user=" . $_REQUEST[user] . "&cate_id=" . $_REQUEST['cate_id'] . "&skills=" . $_REQUEST['skills'];











///////////////////////////////////////////////////////////////////////// start search section //////////////////////////////////////////////////////



if(isset($_REQUEST['skills']) && $_REQUEST['skills']!="")



{



	$select_cate="select freelan_user_cats.*,freelan_user.* from freelan_user_cats,freelan_user where freelan_user_cats.user_id=freelan_user.user_id and freelan_user_cats.cat_id ='".$_REQUEST['skills']."'";



	// $select_cate="select freelan_projects_cats.*,freelan_projects.* from freelan_projects_cats,freelan_projects where freelan_projects_cats.id=freelan_projects.id and freelan_projects_cats.cat_id='".$_REQUEST['skills']."'";



	$rec_cate=mysql_query($select_cate);



	$user_id='';



	while($row_cate=mysql_fetch_array($rec_cate))



	{	



		$user_id.=$row_cate['user_id'].',';



	}



	$user_id=rtrim($user_id, ",");



	if($user_id!="")



	{



		$user_id=$user_id;



	}



	else



	{



		$user_id='0';



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



//die();



	$select_cate="select freelan_user_cats.*,freelan_user.* from freelan_user_cats,freelan_user where freelan_user_cats.user_id=freelan_user.user_id and freelan_user_cats.cat_id in (".$cat_id.")";	



	//$select_cate="select freelan_projects_cats.*,freelan_projects.* from freelan_projects_cats,freelan_projects where freelan_projects_cats.id=freelan_projects.id and freelan_projects_cats.cat_id in (".$cat_id.")";



	$rec_cate=mysql_query($select_cate);



	$user_id='';



	while($row_cate=mysql_fetch_array($rec_cate))



	{	



		$user_id.=$row_cate['user_id'].',';



	}



	$user_id=rtrim($user_id, ",");



	if($user_id!="")



	{



		$user_id=$user_id;



	}



	else



	{



		$user_id='0';



	}











}











///////////////////////////////////////////////////////////////////////// end search section //////////////////////////////////////////////////////










if($user_id!="")



{



	$cond2=" and (u.user_type='" .$_REQUEST[user] ."' or u.user_type='B') and u.user_id in (".$user_id.")";



}



else



{



	$cond2=" and (u.user_type='" .$_REQUEST[user] ."' or u.user_type='B')";



}


$rate_fb="select AVG(avg_rate) as icon from ".$prev."feedback  where feedback_to='".$d['user_id']."' ";

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



	



if($_REQUEST[user]=="W")



{  



	echo"<tr><td colspan=3 style='border-bottom:1px solid #b1ced9;padding-top:10px'>



	<table width=100% cellpadding=0 cellspaciong=0 border=0><tr><td style='width:50%;' class='singuptest'>



	Browse  " . $total . " Freelancers </td>";


	echo"</tr></table></td></tr>";



}











if(!$total):



?>
      <div style="height:100px;"></div>
      <div align="center" style="color:#3B5998; font-weight:bold;">No Result found.</div>
      <div style="height:100px;"></div>
      <?php



endif;



//$r=mysql_query("select * from  ".$prev."user where status='Y' ".$cond2." order by user_id desc ".$limit);



//echo"select * from  ".$prev."user where status='Y' ".$cond2." order by user_id desc ".$limit;



$j=0;



while($d=@mysql_fetch_array($r)):



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
      <div class="freel_text">
        <div class="freel_img"><a href="publicprofile/<?php print base64_encode($d[user_id]);?>" > <img src="viewimage.php?img=<?php echo $temp_logo;?>&amp;width=60&amp;height=60" /></a></div>
        <div class="freel_text_right">
          <div class="freel_text_right_img"><img src="images/dotted_icon.png" /></div>
          <a href="publicprofile/<?php print base64_encode($d[user_id]);?>" >
            <h1>
              <?=txt_value_output($name);?>
            </h1>
          </a>
          <div class="freel_text_right_img"><img src="cuntry_flag/<?=$d['country'];?>.png" title="France" width="16" height="11" ></div>
          <br />
          <br />
          <?php

$rate_fb="select AVG(avg_rate) as icon from ".$prev."feedback  where feedback_to='".$d['user_id']."' ";

$rate_fb1="select * from ".$prev."feedback  where feedback_to='".$d['user_id']."' ";

//echo $rate_fb;

$rate_fbicon=mysql_fetch_array(mysql_query($rate_fb));

$rate_fbicon1=mysql_num_rows(mysql_query($rate_fb1));



$ic=number_format($rate_fbicon['icon'],1,'.',',');

?>
          <div class="freel_text_right_img">
            <?php 

for($i=0;$i<$ic;$i++)

{

	echo '<img src="images/rating_icon.png" />';

}

echo $ic;

echo '<a href="'.$vpath.'reviews.php?id=' . base64_encode($d['user_id']) . '" class=linka><font color="red"> ('.$rate_fbicon1.' Reviews)</font></a>';

?>
          </div>
        </div>
        <h2>Since : &nbsp; <span>
          <?=mysqldate_show($d[reg_date])?>
        </span></h2>
        <?php



$skill_q="select cat_name from freelan_categories c inner join freelan_user_cats u on c.cat_id=u.cat_id where user_id=".$d[user_id];



$res_skill=mysql_query($skill_q);



?>
        <h2>Top Skills : &nbsp;<span>
          <?php



while($data_skill=mysql_fetch_array($res_skill))



{



	$data_cat_name.= $data_skill['cat_name'].',';



}



$cat_name=substr($data_cat_name,0,-1);



echo $cat_name;



$data_cat_name="";



?>
        </span></h2>
        <h3>
          <?=$d[profile];?>
        </h3>
      </div>
      <?php







    $j++;



endwhile;



if($total>$no_of_records)
{
   echo"<div align=right>" .new_paging(0,'browse-freelancers.php','&user=W',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";

}








?>
    </div>
    <div id="falseiddiv" style="display:none;">
      <div style="height:150px;"></div>
      <div align="center" style="color:#CCCCCC; font-weight:bold;">Loading..<img src="images/pic-loader.gif" height="12" /></div>
      <div style="height:250px;"></div>
    </div>
  </div>
  </div>
</div>
</div>
</div>
</div>
</div>
<?php include 'includes/footer.php';?>
</body></html>