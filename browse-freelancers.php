<?php 
$current_page="View Freelancers / Contractors";
include "includes/header.php";
include("country.php");
if($_REQUEST['page']==""){	$pg = 1;}else{	$pg = $_REQUEST['page'];}
if(isset($_REQUEST['skillsinput']) && $_REQUEST['skillsinput']!="")
{
	if($_REQUEST['skills']!=0)
	{
	$limit=$_REQUEST['limit'];
	$skills=$_REQUEST['skills'];
	$cate_id=$_REQUEST['cate_id'];
		if(!$_REQUEST['cate_id']){
		$cate_id=0;
		}
		header("location:".$vpath."browse-freelancers/1/".$skills."/".$cate_id."/");

	}else{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$cate_id=$_REQUEST['cate_id'];

		if($cate_id==0){
		header("location:".$vpath."browse-freelancers/1/");
		}else{
		header("location:".$vpath."browse-freelancers/1/".$cate_id."/");
		}

	}	

}


if(isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput']!="")
{
	if($_REQUEST['categoryinput']!=0)
	{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$categoryinput=$_REQUEST['categoryinput'];
		header("location:".$vpath."browse-freelancers/1/".$categoryinput."/");
	}else{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$categoryinput=$_REQUEST['categoryinput'];
		header("location:".$vpath."browse-freelancers/1/");
	}	

}

if(isset($_REQUEST['profile_type_user1']))
{ 
	if($_REQUEST['profile_type_user']!='')
	{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
			if($skills==""){
			$skills=0;
			}
		$cate_id=$_REQUEST['cate_id'];
			if(!$_REQUEST['cate_id']){
			$cate_id=0;
			}
		$profilety=$_REQUEST['profile_type_user'];
		header("location:".$vpath."browse-freelancers/1/".$skills."/".$cate_id."/".$profilety."/");
	}else{
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		$categoryinput=$_REQUEST['categoryinput'];
		header("location:".$vpath."browse-freelancers/1/");
	}	

}

if(isset($_REQUEST['start1']) )
{
	if( $_REQUEST['srat']!=""){
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
			if($skills==""){
			$skills=0;
			}
		$cate_id=$_REQUEST['cate_id'];
			if(!$_REQUEST['cate_id']){
			$cate_id=0;
			}
			$profilety=$_REQUEST['profile_type_user'];
			if($profilety==''){
			$profilety="All";
			}
	$rt=$_REQUEST['srat'];
		if(count($rt)){
			foreach($rt as $val){
			$rty[]=$val;
			}
		$ratey=@implode("-",$rty);
		}
	if($ratey!=""){
	$rtv=$ratey."/";
	}
		header("location:".$vpath."browse-freelancers/1/".$skills."/".$cate_id."/".$profilety."/".$rtv."");

	}else{
		$skills=$_REQUEST['skills'];
		if($skills==""){
		$skills=0;
		}
		$cate_id=$_REQUEST['cate_id'];
		if(!$_REQUEST['cate_id']){
			$cate_id=0;
		}
	header("location:".$vpath."browse-freelancers/1/".$skills."/".$cate_id."/");
	}
			
}

if(isset($_REQUEST['ratee']) )
{
	if( $_REQUEST['rate']!=""){
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		if($skills==""){
			$skills=0;
		}
		$cate_id=$_REQUEST['cate_id'];
	if(!$_REQUEST['cate_id']){
	$cate_id=0;
	}
	$rt=$_REQUEST['srat1'];	
	if($rt!=""){
		$rtv=$rt."/";
	}else{
		$rtv="0/";
	}
	$profilety=$_REQUEST['profile_type_user'];
			if($profilety==''){
			$profilety="All";
			}
	$rat=$_REQUEST['rate']."/";
	header("location:".$vpath."browse-freelancers/1/".$skills."/".$cate_id."/".$profilety."/".$rtv.$rat."");
	}else{
		$skills=$_REQUEST['skills'];
		if($skills==""){
		$skills=0;
		}
		$cate_id=$_REQUEST['cate_id'];
		if(!$_REQUEST['cate_id']){
			$cate_id=0;
		}
		$profilety=$_REQUEST['profile_type_user'];
			if($profilety==''){
			$profilety="All";
			}
	if($ratey!=""){
		$rtv=$ratey."/";
	}else{
		$rtv="0/";
	}	
	header("location:".$vpath."browse-freelancers/1/".$skills."/".$cate_id."/".$profilety."/".$rtv."");
	}	
}
	

if(isset($_REQUEST['countryinput']) )
{
	if( $_REQUEST['country']!=""){
		$limit=$_REQUEST['limit'];
		$skills=$_REQUEST['skills'];
		if($skills==""){
			$skills=0;
		}
		$cate_id=$_REQUEST['cate_id'];
		if(!$_REQUEST['cate_id']){
			$cate_id=0;
		}

	$rt=$_REQUEST['srat1'];
	
		if($rt!=""){
			$rtv=$rt."/";
		}else{
			$rtv="0/";
		}
		$rat=$_REQUEST['rate']."/";
		if($rat!=""){
			$rat="0/";
		}
		$profilety=$_REQUEST['profile_type_user'];
			if($profilety==''){
			$profilety="All";
			}
		$country=$_REQUEST['country']."/";
	
		header("location:".$vpath."browse-freelancers/1/".$skills."/".$cate_id."/".$profilety."/".$rtv.$rat.$country."");



	}else{
		$skills=$_REQUEST['skills'];
		if($skills==""){
			$skills=0;
		}
		$cate_id=$_REQUEST['cate_id'];
		if(!$_REQUEST['cate_id']){
			$cate_id=0;
		}
		$profilety=$_REQUEST['profile_type_user'];
			if($profilety==''){
			$profilety="All";
			}
		if($ratey!=""){
			$rtv=$ratey."/";
		}else{
			$rtv="0/";
		}
		$rat=$_REQUEST['rate']."/";
		if($rat!=""){
			$rat=0;
		}	
		header("location:".$vpath."browse-freelancers/1/".$skills."/".$cate_id."/".$profilety."/".$rtv.$rat."");
	}
	
}

?>
<script type="text/javascript">



function funonchange(val){
	document.getElementById("skillsinput").value = val;

	$("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	if(document.getElementById("skillsinput").value != ""){
		document.skillform.submit();	
	}
}

function funonchangecategory(val){
	document.getElementById("categoryinput").value = val;
	$("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	if(document.getElementById("categoryinput").value != ""){
		document.categoryform.submit();	
	}

}
function getstart()
{
 $("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	document.startform.submit();	
}

function get_rate(val)
{
 $("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	document.rateform.submit();	
}
function get_country(val)
{
 $("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	document.countryform.submit();	
}

function get_profile_type(val){
 $("#member_right_box").empty().html('<div style="clear:both;padding-top:10px" align="center"><img src="<?=$vpath?>images/pic-loader.gif"/></div>');
	document.profiletypeform.submit();	
}
function showcat(id){
$(".showcss_"+id).css({"display": "inline-block"});
$("#more_"+id).slideUp('slow');
$("#less_"+id).slideDown('slow');

}
function hidecat(id){
$(".showcss_"+id).slideUp('slow');
$("#more_"+id).slideDown('slow');
$("#less_"+id).slideUp('slow');
}
</script>
<script type="text/javascript" src="<?=$vpath?>js/jquery_3.js"></script>

<script src="<?=$vpath?>js/jquery.collapse.js"></script>
<script src="<?=$vpath?>js/jquery.collapse_storage.js"></script>
<script>

jQuery.noConflict();
// Code that uses other library's $ can follow here.
</script>

<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle"> 


  <div class="page_headding"><div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0)" class="selected"><?=$lang['FIND_TALENT']?></a></p></div>
<form action="<?=$vpath?>find-talents/"  method="POST" name="myform" id="myform">
<div class="serach_pannel" style="float:none; margin:0px auto; width:430px; height:33px; border:1px solid #CCCCCC;">
<select name="select2" id="tech1" class="selectyze3" onChange="this.form.action=this.options[this.selectedIndex].value;">
  <option value="browse-freelancers.php" <?php if(isset($_POST['select2']) && $_POST['select2'] == 'browse-freelancers.php') echo 'selected="selected"';?>><?=$lang['FIND_TALENT']?></option>
   <option value="sear_all_jobs.php" <?php if(isset($_POST['select2']) && $_POST['select2'] == 'sear_all_jobs.php') echo 'selected="selected"';?>><?=$lang['PROJECT_NAME']?></option>
</select>
 <input name="keyword" id="keyword" type="text" size="20px" class="search_input" onblur="if(this.value=='')this.value='<? if($_REQUEST['keyword']!=""){ echo $_REQUEST['keyword'];}else{?><?=$lang['CONTRATER3']?><? }?>';" onfocus="if(this.value=='<? if($_REQUEST['keyword']!=""){ echo $_REQUEST['keyword'];}else{?><?=$lang['CONTRATER3']?><? }?>')this.value='';" style="width:250px;" value="<? if($_REQUEST['keyword']!=""){ echo $_REQUEST['keyword'];}else{?><?=$lang['CONTRATER3']?><? }?>">
           <input name="submit2" type="submit" value="" class="search_bnt1">
        </div>
		</form>
</div>
<div class="clear"></div>
          
   <!--Inbox Left Start-->
<div class="profile_left">
<div id="open-by-default-example" class="accordian" data-collapse>
 <?php
  $f=0;
   $rt=mysql_query("select cat_id,cat_name from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
   while($p_f=@mysql_fetch_array($rt)){
   echo ' <h3 class="open">'.languagechagevalue($p_f['cat_id'],'cat_name','categories',$p_f['cat_name']).'</h3>
   <ul class="live-pro-list clearfix" >';
   $r=mysql_query("select cat_id,cat_name from " . $prev . "categories  where parent_id='".$p_f['cat_id']."' and status='Y' order by cat_name");
	while($d=mysql_fetch_array($r))
	{
	$f++;
	
	$catnm=$d['cat_name'];
		if($_SESSION[lang_id])
		{
			$row_content_lang=mysql_fetch_array(mysql_query("select content from ".$prev."language_content where content_field_id='".$d['cat_id']."' and table_name='categories' and field_name='cat_name' and lang_id='".$_SESSION[lang_id]."'"));					
			$d['cat_name']=$row_content_lang['content'];
		 }

		?>
							
						<li ><a href='<?=$vpath?>browse-freelancers/1/<?=$d['cat_id']?>/<?=$p_f['cat_id']?>/' <? if($_GET['skills']==$d['cat_id']){?> class="active" <? }?> ><?php echo $d['cat_name'];?>&nbsp;</a></li>
					<?php
					
		
		}
		echo '</ul>';
	}
	?>   

<!--<h3 class='open'><?=$lang['WORK_REQUIRE']?></h3>
<ul class="live-pro-list clearfix" >
<?php
						if($_REQUEST['skills']!="")
						{

							$select_cate="select * from ".$prev."categories where cat_id='".$_REQUEST['skills']."'";

							$rec_cate=mysql_query($select_cate);

							$row_cate=mysql_fetch_array($rec_cate);

						}

						$r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");

							  while($d=mysql_fetch_array($r))
							  {
	 $catname=languagechagevalue($row_skills['cat_id'],'cat_name','categories',$d['cat_name']);
		
?>
<li><a href='<?=$vpath?>browse-freelancers/1/<?=$d['cat_id']?>/'<? if($row_cate['parent_id']==$d['cat_id']){?> class="selected is open" <? }?> ><?php echo $catname;?></a></li>
<? }?>
	</ul>-->
	<h3  class="open"><?=$lang['PROFILE_TYPE']?></h3>
	<ul class="live-pro-list clearfix" ><li>
	<form name="profiletypeform" id="profiletypeform" action="" method="post">
 <div class="select-box">
        <select name="profile_type_user" class="selectyze2" onchange="get_profile_type(this.value)">
          <option value="All"><?=$lang['EVERYONE']?></option>
          <option value="I" <? if($_REQUEST[profile_type_user]=='I'){?> selected=selected<? }?>><?=$lang['INDIVIDUAL']?></option> 
		  <option value="C" <? if($_REQUEST[profile_type_user]=='C'){?> selected=selected<? }?>><?=$lang['COMPANIES']?></option>
		  
        </select>
        </div>
		
	 
	    <input name="profile_type_user1" type="hidden" id="profile_type_user1" value="<?php echo $_REQUEST['profile_type_user1'];?>" />

        <input name="limit" type="hidden" id="limit" value="<?php echo $_REQUEST['limit'];?>" />

        <input name="cate_id" type="hidden" id="cate_id" value="<?php echo $_REQUEST['cate_id'];?>"/>
         
        <input name="skills" type="hidden" id="skills" value="<?php echo $_REQUEST['skills'];?>"/>
	</form>
	</li></ul>
	
	
<?
$su=@explode("-",$_REQUEST[start]);
?>
	<h3  class="open"><?=$lang['RATTING_H']?></h3>
		<form name="startform" id="startform" action="" method="post">
<ul class="live-pro-list clearfix" >
        <li><input name="srat[]" type="checkbox" value="5" onclick="getstart()" <? if(in_array("5",$su)){?> checked=checked<? }?>>&nbsp;&nbsp;<img src="images/5star.png" alt="" ></li>
        <li><input name="srat[]" type="checkbox" value="4" onclick="getstart()" <? if(in_array("4",$su)){?> checked=checked<? }?>>&nbsp;&nbsp;<img src="images/4star.png" alt=""></li>
        <li><input name="srat[]" type="checkbox" value="3" onclick="getstart()" <? if(in_array("3",$su)){?> checked=checked<? }?>>&nbsp;&nbsp;<img src="images/3star.png" alt="" ></li>
        <!--<li><input name="" type="checkbox" value="">&nbsp;&nbsp;<img src="images/2star.png" alt=""></li>
        <li><input name="" type="checkbox" value="">&nbsp;&nbsp;<img src="images/1star.png" alt=""></li>-->
        </ul>
	  <input name="start1" type="hidden" id="start1" value="<?php echo $_REQUEST['start1'];?>" />

        <input name="limit" type="hidden" id="limit" value="<?php echo $_REQUEST['limit'];?>" />

        <input name="cate_id" type="hidden" id="cate_id" value="<?php echo $_REQUEST['cate_id'];?>"/>
        
        <input name="skills" type="hidden" id="skills" value="<?php echo $_REQUEST['skills'];?>"/>      
	</form>
		
	<h3  class="open"><?=$lang['H_RATE']?></h3>
	<ul class="live-pro-list clearfix" ><li>
	<form name="rateform" id="rateform" action="" method="post">
 <div class="select-box">
        <select name="rate" class="selectyze2" onchange="get_rate(this.value)">
          <option value=""><?=$lang['ANY']?></option>
          <option value="1" <? if($_REQUEST[rate]==1){?> selected=selected<? }?>><?=$lang['LESSTHAN10']?></option> 
		  <option value="2" <? if($_REQUEST[rate]==2){?> selected=selected<? }?>><?=$lang['USD_10_20']?></option>
		  <option value="3" <? if($_REQUEST[rate]==3){?> selected=selected<? }?>><?=$lang['USD_20_30']?></option>
		 <option value="4" <? if($_REQUEST[rate]==4){?> selected=selected<? }?>><?=$lang['USD_30_40']?></option>
			 <option value="5" <? if($_REQUEST[rate]==5){?> selected=selected<? }?>><?=$lang['Over_USD_40']?></option>
        </select>
        </div>
		
	  <input name="ratee" type="hidden" id="ratee" value="<?php echo $_REQUEST['ratee'];?>" />
	    <input name="srat1" type="hidden" id="ratee" value="<?php echo $_REQUEST['start'];?>" />

        <input name="limit" type="hidden" id="limit" value="<?php echo $_REQUEST['limit'];?>" />

        <input name="cate_id" type="hidden" id="cate_id" value="<?php echo $_REQUEST['cate_id'];?>"/>
        <input name="start" type="hidden" id="start" value="<?php echo $_REQUEST['start'];?>"/>  
        <input name="skills" type="hidden" id="skills" value="<?php echo $_REQUEST['skills'];?>"/>
	</form>
	</li></ul>
		<h3  class="open"><?=$lang['COUNTRY']?></h3><ul class="live-pro-list clearfix" >
	<form name="countryform" id="countryform" action="" method="post">
 
 <div class="select-box"> 
        <select name="country" class="selectyze2" onchange="get_country(this.value)">
           <option value="0"><?=$lang['RIG1']?>&nbsp;</option>
                <?php

							$arr=array_keys($country_array);

							for($i=0;$i<count($arr);$i++):
?>
							  <option value="<?=$arr[$i]?>" <? if($_REQUEST[country]==$arr[$i]){?> selected=selected <? }?>><?=$country_array[$arr[$i]]?></option>
<?
							endfor; 

					?>
        </select>
        </div>
		<input name="countryinput" type="hidden" id="countryinput" />
	  <input name="rate" type="hidden" id="rate" value="<?php echo $_REQUEST['rate'];?>" />
 <input name="srat1" type="hidden" id="ratee" value="<?php echo $_REQUEST['start'];?>" />
        <input name="limit" type="hidden" id="limit" value="<?php echo $_REQUEST['limit'];?>" />

        <input name="cate_id" type="hidden" id="cate_id" value="<?php echo $_REQUEST['cate_id'];?>"/>
        <input name="start" type="hidden" id="start" value="<?php echo $_REQUEST['start'];?>"/>  
        <input name="skills" type="hidden" id="skills" value="<?php echo $_REQUEST['skills'];?>"/>
	</form>
 </div>


	
	
	</div>
  <!--Inbox Left End--> 
  
  <!--Inbox right Start-->
  
  <div class="profile_right">
  
    <div class="latest_worbox" id="member_right_box" >
      <?



$no_of_records=10;



if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}

$params='/';
if($_REQUEST['skills']){$params.=$_REQUEST['skills']."/";}else{$params.="0/";}
if($_REQUEST['cate_id']){$params.=$_REQUEST['cate_id']."/";}else{$params.="0/";}
if($_REQUEST['profile_type_user']){$params.=$_REQUEST['profile_type_user']."/";}else{$params.="All/";}
if($_REQUEST['start']){$params.=$_REQUEST['start']."/";}else{$params.="0/";}
if($_REQUEST['rate']){$params.=$_REQUEST['rate']."/";}else{$params.="0/";}
if($_REQUEST['country']){$params.=$_REQUEST['country']."/";}else{$params.="0/";}

if($_REQUEST['keyword']!="" && $_REQUEST['keyword']!=$lang['CONTRATER3']){$params.=$_REQUEST['keyword']."/";}


if(isset($_REQUEST['skills']) && $_REQUEST['skills']!="" && $_REQUEST['skills']!="0")
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



}elseif(isset($_REQUEST['cate_id']) && $_REQUEST['cate_id']!="" && $_REQUEST['cate_id']!="0" )

{



	$select_subcate="select * from ".$prev."categories where parent_id='".$_REQUEST['cate_id']."'";



	$rec_subcate=mysql_query($select_subcate);



	$cat_id='';



	while($row_subcate=mysql_fetch_array($rec_subcate))



	{



		$cat_id.= $row_subcate['cat_id'].',';



	}



	$cat_id=rtrim($cat_id, ",");

if($cat_id==""){
$cat_id="''";
}





	 $select_cate="select ".$prev."user.* from ".$prev."user_cats left join ".$prev."user on ".$prev."user_cats.user_id=".$prev."user.user_id where  ".$prev."user_cats.cat_id in (".$cat_id.") group by ".$prev."user_cats.user_id";	







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






///////////////////////////////////////////////////////////////////////// end search section //////////////////////////////////////////////////////


if(isset($_REQUEST['start']) && $_REQUEST['start']!="" && $_REQUEST['start']!="0")

{
$rec="";

if(isset($_REQUEST['start']) && $_REQUEST['start']!="" ){
$sd=@explode("-",$_REQUEST['start']);
foreach($sd as $val){
$recq[]="   icon >= $val";

}
$sdf=" group by ".$prev."feedback.feedback_to having (".implode(" or ",$recq).")";
}
if($user_id2 !="" && $user_id2!="0"){

$rec.=" and ".$prev."user.user_id in (".$user_id2.")";
}
	  $select_cate="select ".$prev."user.user_id,AVG(".$prev."feedback.avg_rate) as icon from ".$prev."user left join ".$prev."feedback on ".$prev."user.user_id=".$prev."feedback.feedback_to where  ".$prev."user.user_id!=''  $rec $sdf ";

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
if((isset($_REQUEST['rate']) && $_REQUEST['rate']!="" && $_REQUEST['rate']!="0") )

{
$rec="";
if(isset($_REQUEST['rate']) && $_REQUEST['rate']!=""){
if($_REQUEST['rate']==1){
$rec.=" and ".$prev."user.rate <'10'";
}elseif($_REQUEST['rate']==2){
$rec.=" and ".$prev."user.rate between '10' and '20'";
}
elseif($_REQUEST['rate']==3){
$rec.=" and ".$prev."user.rate between '20' and '30'";
}
elseif($_REQUEST['rate']==4){
$rec.=" and ".$prev."user.rate between '30' and '40'";
}
elseif($_REQUEST['rate']==5){
$rec.=" and ".$prev."user.rate >'40'";

}

}

if($user_id2!="" && $user_id2!="0"){

$rec.=" and ".$prev."user.user_id in (".$user_id2.")";
}
	   $select_cate="select ".$prev."user.* from ".$prev."user where  ".$prev."user.user_id!='' $rec ";

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

if((isset($_REQUEST['country']) && $_REQUEST['country']!="" && $_REQUEST['country']!="0") )

{
$rec="";
if(isset($_REQUEST['country']) && $_REQUEST['country']!=""){
$rec.=" and ".$prev."user.country ='".$_REQUEST['country']."'";
}

if($user_id2!="" && $user_id2!="0"){

$rec.=" and ".$prev."user.user_id in (".$user_id2.")";
}
	   $select_cate="select ".$prev."user.* from ".$prev."user where ".$prev."user.user_id!=''  $rec ";

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




if($user_id2!="")
{
$cond2="  and ".$prev."user.user_id in (".$user_id2.")";
}else
{
$cond2="";
}
if($_REQUEST['profile_type_user']!="All" && $_REQUEST['profile_type_user']!=''){
$userond=" and account_type='".$_REQUEST['profile_type_user']."'";

}else{
$userond='';
}
if($_REQUEST['keyword']!=''){
$srt=@explode(" ",$_REQUEST['keyword']);
if(count($srt)>0){
foreach($srt as $val){
// $condser.= " and (".$prev."user.username like '%".$val."%' or ".$prev."user.fname like '%".$val."%'  or ".$prev."user.lname like '%".$val."%')";
$condser.= " and (".$prev."user.username like '%".$val."%' or ".$prev."user.fname like '%".$val."%'  or ".$prev."user.lname like '%".$val."%' or ".$prev."user_profile.skills like '%".$val."%')";

}
if($condser){
$rec.=$condser;
}
}
}





// $sql1=mysql_query("select * from  ".$prev."user left join ".$prev."user_cats on ".$prev."user_cats.user_id=".$prev."user.user_id  where  ".$prev."user.status='Y'  and ".$prev."user_cats.user_id=".$prev."user.user_id  ".$cond2." $userond $rec group by ".$prev."user.user_id");
$sql1=mysql_query("select * from  ".$prev."user left join ".$prev."user_profile on ".$prev."user_profile.user_id=".$prev."user.user_id  where  ".$prev."user.status='Y'  and ".$prev."user_profile.user_id=".$prev."user.user_id  ".$cond2." $userond $rec group by ".$prev."user.user_id");



$total =@mysql_num_rows($sql1);
// var_dump($total); exit();
// var_dump("select * from  ".$prev."user left join ".$prev."user_profile on ".$prev."user_profile.user_id=".$prev."user.user_id  where  ".$prev."user.status='Y'  and ".$prev."user_profile.user_id=".$prev."user.user_id  ".$cond2." $userond $rec group by ".$prev."user.user_id"); exit();


	



if($_GET['page'])
{
 // $sql="select * from  ".$prev."user left join ".$prev."user_cats on ".$prev."user_cats.user_id=".$prev."user.user_id  where  status='Y' and ".$prev."user_cats.user_id=".$prev."user.user_id  ".$cond2." $userond $rec group by ".$prev."user.user_id limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
 $sql="select * from  ".$prev."user left join ".$prev."user_profile on ".$prev."user_profile.user_id=".$prev."user.user_id  where  status='Y' and ".$prev."user_profile.user_id=".$prev."user.user_id  ".$cond2." $userond $rec group by ".$prev."user.user_id limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";

}else{	
// $sql="select * from  ".$prev."user left join ".$prev."user_cats on ".$prev."user_cats.user_id=".$prev."user.user_id  where  status='Y' and ".$prev."user_cats.user_id=".$prev."user.user_id   ".$cond2." $userond $rec group by ".$prev."user.user_id limit 0,".$no_of_records."";
$sql="select * from  ".$prev."user left join ".$prev."user_profile on ".$prev."user_profile.user_id=".$prev."user.user_id  where  status='Y' and ".$prev."user_profile.user_id=".$prev."user.user_id   ".$cond2." $userond $rec group by ".$prev."user.user_id limit 0,".$no_of_records."";
}



	//echo $sql;



$r=mysql_query($sql) or die(mysql_error());


	echo'<div class="browse-members_right">



     <p style="border-bottom:1px dotted #CCCCCC;">'. $total ." ".$lang['FREELANCE_FOUNDS'].'</p>



   </div>';






if(!$total)



{



?>
      <div style="height:100px;"></div>
      <div align="center" style="color:#3B5998; font-weight:bold;">
        <?=$lang['NO_RES_FOUND']?>
      </div>
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
      <div class="resutblock">
        <div class="resultimgblock"><a href="<?=$vpath;?>publicprofile/<?=$d[username]?>/" > <img src="<?=$vpath?>viewimage.php?img=<?php echo $temp_logo;?>&amp;width=100&amp;height=100" /></a>
		<div><!--<img src="images/starone.png" alt=""> <img src="images/cup.png" alt="">--></div>
		</div>
        <div class="resulttxt">
         <a href="<?=$vpath;?>publicprofile/<?=$d[username]?>/" style="text-decoration: none;" > <h2> 
            <?=ucwords(txt_value_output($name));?><?=getrating($d[user_id])?>
            </h2></a>
			<h3><?=ucfirst($d['slogan'])?></h3>
			<h4><?=$lang['COMPLETE_PROJECTS']?> <b><?=getprojectcomplted($d[user_id])?></b> | <?=$lang['HOURLY_RATE']?> <b><?=$d['rate']?></b></h4>
        
          
			 <p>
            <? echo substr($d[profile],0,200);?>
          </p>
		<div  style="padding-bottom:5px;">
         
            <?=$lang['TOP_SKILLS']?>
            :	
       <?
       
$skill_q = "select skills from " . $prev . "user_profile where user_id=" . $d[user_id];

                        $res_skill = mysql_query($skill_q);
                        $data_skills = @mysql_result($res_skill,0,"skills");
                        $data_skills = explode(',', $data_skills);

                        foreach ($data_skills as $skill) {
                            $data_skill_name.= "<a href='browse-freelancers.php?keyword=".$skill."' class='skilslinks'>". $skill . '</a>  ';
                        }
                       
                        $skill_name = $data_skill_name;
                        echo $skill_name;
                        $data_skill_name = "";

// $skill_q="select c.cat_name,c.cat_id,c.parent_id from ".$prev."categories c inner join ".$prev."user_cats u on c.cat_id=u.cat_id where user_id=".$d[user_id];

// $res_skill=mysql_query($skill_q);
// $ca=0;
// while($data_skill=@mysql_fetch_array($res_skill))

// {
// $ca++;
// $cs="";
// $more="";
// if($ca>6){
// $cs="hidecss showcss_".$d[user_id]."";
// $more='<a href="javascript:void(0)" onclick="showcat('.$d[user_id].')" id="more_'.$d[user_id].'" class="moreless">'.$lang['MORE'].'</a><a href="javascript:void(0)" onclick="hidecat('.$d[user_id].')" id="less_'.$d[user_id].'" style="display:none;" class="moreless">'.$lang['LESS'].'</a>';
// }
//  $catnamesk=@languagechagevalue($data_skill['cat_id'],'cat_name','categories',$data_skill['cat_name']);
// 	$data_cat_name.=  " <a class='skilslinks $cs' href='".$vpath."browse-freelancers/1/".$data_skill[cat_id]."/".$data_skill[parent_id]."/'>".$catnamesk.'</a> ';

// }

// $cat_name=$data_cat_name;

// echo $cat_name."<div style='clear:both'></div>".$more;

// $data_cat_name="";

   ?>
	   
 </div>	   
	   
	   
	   
	   
	   
     
       <!-- <div  style="padding-bottom:5px;">
         
            <?=$lang['TOP_SKILLS']?>
            :
            <?php
			$skill_q="select s.name,us.rating,us.id from ".$prev."user_skills AS us left join ".$prev."skill_data as s on us.skills_id=s.id where s.status='Y' and us.user_id='".$d[user_id]."' order by us.id desc";

$res_skill=mysql_query($skill_q);
$u=0;
while($data_skill=@mysql_fetch_array($res_skill))
{
$u++;
if($u>4){$s="style='display:none'";
 }else{
 $s="";
 }
	$data_cat_name.=  "<a class='skilslinks' href='javascript:void(0);'>".$data_skill['name'].'</a>';
}


echo $data_cat_name;

$data_cat_name="";

?>
            </div> -->
			<div><p><img src="<?=$vpath?>cuntry_flag/<?=strtolower($d[country]);?>.png" title="<?=$country_array[$d[country]];?>" width="16" height="11" > &nbsp;&nbsp;<?=$country_array[$d[country]];?> | <?=$lang['LAST_LOGIN']?>:<b><?php print date('M d, Y', strtotime($d[ldate]));?></b> | <?=$lang['REGISTER_SINCE']?>:<b><?php print date('M, Y', strtotime($d[reg_date]));?></b></p></div>
			</div>
         
        </div>
    
      <?php

    $j++;


}


if($total>$no_of_records)


{


  echo"<div align=right>" .new_pagingnew(5,'browse-freelancers/',$params,$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";


}

?>
</div>      
</div>
</div></div></div>

<style>
 .live-pro-list li a.active{
 font-weight:bold;
 }
 </style>
<style>
.hidecss{
display:none;
}
/*.skilslinks {
font-size: 11px;
line-height: 9.5px;
}*/
.moreless{
 color: #205691;text-decoration: none; font-size:13px;

}
</style>
<?php include 'includes/footer.php';?>
