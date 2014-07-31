<?php 

	include "includes/header.php";
CheckLogin();
?>
<?php

$rand = rand(1111111, 9999999);
if($_SESSION['user_id']){$user_id=$_SESSION['user_id'];}else{$user_id=$_SESSION['usre_id'];}
if(empty($user_id)){header("Location: ".$vpath."login.php"); exit();}

$count=mysql_num_rows(mysql_query("select * from " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " order by add_date desc")); 
				
if($_REQUEST['SBMT']):
    if($_REQUEST['ed'])
	{
	    $q="update " . $prev . "portfolio set project_title='".$_REQUEST['project_title'] ."', description='".$_REQUEST['description'] ."' where  id=" . $_REQUEST['EDIT'];
		mysql_query($q);
	    if($q)
		{
		   //print_r($_FILES);
		   //exit();
		   if($_FILES['thumb']['name']):
		   list($image_ex,$ext)=explode('.',$_FILES['thumb']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
				$rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
			
			
			
			 if($_FILES['thumb1']['name']):
			 list($image_ex,$ext)=explode('.',$_FILES['thumb1']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb1']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
				$rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb1']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image1=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
			
			
			 if($_FILES['thumb2']['name']):
			 list($image_ex,$ext)=explode('.',$_FILES['thumb2']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb2']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
		    	$rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb2']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image2=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
			
			 if($_FILES['thumb3']['name']):
			 list($image_ex,$ext)=explode('.',$_FILES['thumb3']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb3']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
		    	$rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb3']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image3=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
			
			 if($_FILES['thumb4']['name']):
			 list($image_ex,$ext)=explode('.',$_FILES['thumb4']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb4']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
		    	$rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb4']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image4=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
			
		$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";
		}
	}
	else{
	if(($count+1)>10):
	   $msg="<h3 ><font color=red><img src='images/error.png' align=absmiddle hspace=5>".$lang['YOU_CANNOT_UPLOAD']."</font></h3>";	
    else:
		$r=mysql_query("insert into " . $prev . "portfolio set user_id=" . $_SESSION[user_id] . ",project_title=\"" . $_REQUEST['project_title'] . "\",description=\"" .$_REQUEST['description'] . "\",add_date=\"" . date("Y-m-d H:i:s") . "\",url='".rand()."'");  
    //	echo "insert into " . $prev . "portfolio set user_id=" . $_SESSION[user_id] . ",project_title=\"" . $_REQUEST['project_title'] . "\",description=\"" .$_REQUEST['description'] . "\",add_date=\"" . date("Y-m-d H:i:s") . "\"";die();
		if($r):
	    	$id=mysql_insert_id(); 
	    	if($_FILES['thumb']['name']):
			list($image_ex,$ext)=explode('.',$_FILES['thumb']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
		    	$rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image=\"" . $file . "\" where id=\"" . $id . "\"");   
				//echo "update " . $prev . "portfolio set image=\"" . $file . "\" where id=\"" . $id . "\"";  
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			if($_FILES['thumb1']['name']):
			list($image_ex,$ext)=explode('.',$_FILES['thumb1']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb1']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
		    $rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb1']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image1=\"" . $file . "\" where id=\"" . $id . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
			
			
			if($_FILES['thumb2']['name']):
			list($image_ex,$ext)=explode('.',$_FILES['thumb2']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb2']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
		    	$rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb2']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image2=\"" . $file . "\" where id=\"" . $id . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
			
			
			if($_FILES['thumb3']['name']):
			list($image_ex,$ext)=explode('.',$_FILES['thumb3']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb3']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
		    	$rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb3']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image3=\"" . $file . "\" where id=\"" . $id . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
			if($_FILES['thumb4']['name']):
			list($image_ex,$ext)=explode('.',$_FILES['thumb4']['name']);
	        	//$ext=strtolower(substr($_FILES['thumb4']['name'],-3,3));
		    	//if($ext=="peg"){$ext=="jpg";}
		    $rand = rand(1111111, 9999999);
		    	$file="portfolio/" .$rand. time() . "." .$ext;
	        	copy($_FILES['thumb4']['tmp_name'],$file);
		    	$r=mysql_query("update " . $prev . "portfolio set image4=\"" . $file . "\" where id=\"" . $id . "\"");     
	        	$msg="<h3 >".$lang['PORTFOLIO_UPDATED']."</h3>";	
			endif;	
			
			
			
			
	   else:
	      $msg="<h3 ><font color=red><img src='images/error.png' align=absmiddle hspace=5>Duplicate title not allowed.</font></h3>";	
	   endif;
	endif;
   }
endif;
if($_REQUEST['EDIT'])
{
$e1=mysql_query("select * from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id]." and id=".$_REQUEST['EDIT']); 
$data1=@mysql_fetch_array($e1);
$project_title=$data1['project_title'];
$description=$data1['description'];
//echo $_REQUEST['ed'];

echo  '<script language="javascript" type="text/javascript">';
echo "document.exp_form.ed.value='1'";
echo "</script>";
 }
elseif($_REQUEST['DELT']){
	$e=mysql_query("delete from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " and id=" . $_REQUEST['DELT']); 
}	

$e=mysql_query("select * from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id]); 
$data=@mysql_fetch_array($e);

?>

<script type="text/javascript" src="js/gen_validatorv4.js"></script>

<script>

function valueEdit()
{

document.exp_form.ed.value=1;
//alert(document.exp_form.ed.value);
}
</script>

<style type="text/css">
.profilebutton {
    background-color: #58AFDE;
    border: 1px solid #388bb5;
    color: #FFFFFF;
    cursor: pointer;
   
    padding: 2px 4px;
    text-shadow: 1px 1px 1px #CCCCCC;
	-webkit-border-radius:4px;-moz-border-radius:4px;
}

</style>

<!-----------Header End-----------------------------> 

<!-- content-->
<div class="freelancer">


<!--Profile-->
<?php include 'includes/leftpanel1.php';?> 
    <!-- left side-->
    <!--middle -->
    <?php
					$r = mysql_query("SELECT * FROM " . $prev . "user where status='Y' and (user_id='".$user_id."')");
					$d=@mysql_fetch_array($r);
					if(empty($d['user_id'])){header("Location: ".$vpath); exit();}
					$user_id=$d['user_id'];
					
					if($d['gold_member']=='Y')
							{
							$mem=mysql_query("select * from ".$prev."membership where id=2");
							$rowmem=mysql_fetch_array($mem);
							}
							else
							{
							$mem=mysql_query("select * from ".$prev."membership where id=1");
							$rowmem=mysql_fetch_array($mem);				
					}
					
					$pcount=$rowmem['portfolio']-$count;
					
					?>
   <div class="profile_right">
   <div class="edit_profile">
     <h2><?=$lang['WELCOME']?> <?php print $_SESSION['fullname'];?><br />
	 <span><?=$lang['World_p1']?><?=mysqldate_show($_SESSION[ldate],1)?></span></h2>

<!--<div align="right">
Balance  :  $ <strong><?php print $balsum;?></strong><br />
Pending Transactions  :  $ <strong><?php print $sum1;?></strong>
</div>-->
<ul>
<li ><a href="profile.php"><?=$lang['UPD_PRF']?></a></li>
<li ><a href="select-expertise.php"><?=$lang['UPDATE_EXPERTISE']?></a></li>
<li class="selected" ><a href="upload-portfolio.php"><?=$lang['UPDATE_PORTFOOLIO']?></a></li>
  

</ul>
   </div>

<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->
<div class="edit_form_box">


            <table cellpadding="0" cellspacing="0" border="0" width="90%" align="center" style="font-size:12px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >
            <tr><td height="10px;"></td></tr>
<!------------------------------------------------Middle Body-------------------------------------------------------------->
            <tr>
            	<td>
<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->	

        <table align="center" width="100%" style="font-size:12px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >
        <tr>
        <td align="left" width="50%"></td><td align="right" width="20%">
		<button class="submit_bott" ><?=$lang['SKIP']?> </button><!--<img src="skip.jpg" onclick="javascript: window.location='profile.php'" style="padding-right:10px; cursor:pointer;" />--></td>
        </tr>
        </table>
        <?php
        //if($msg)
        //{
        //echo"<table align=center width=100%><tr><td class=\"title\" align=center>" . $msg . "</td></tr></table>";
        //}
        ?>
        <form action="<?=$vpath?>upload-portfolio.php" method="POST" name="exp_form" enctype="multipart/form-data">
        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >
        <?php
        if($msg)
        {
        ?>
        <tr><td colspan="2" align="center" style="color:#C60000; font-size:11px; font-weight:normal;"><?=$msg?></td></tr>
        <?php
        }
		if($d['gold_member']!='Y')
		{
		?>
			<tr><td colspan="3"><table bgcolor="#F5F5F5" width="100%">
			<tr><td >
			<?=$lang['UPDATE_MEMBERSHIP']?></td>
			<td><a href="membership_plan.php" ><img src="images/gold-member.png"  /></a>
			</td></tr>
			</table></td></tr>
		<?php
		}
        ?>
        <tr>
        <td align="left" valign="top" class="bx-border"><input type="hidden" value="<?=$_REQUEST['ed']?>" name="ed"/><input type="hidden" value="<?=$_REQUEST['EDIT']?>" name="EDIT"/><table width="100%" border="0" cellpadding="4" cellspacing="0" align="center" style="color:#4E4D4D; font-size:12px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >
        
        <tr style="background-color:#a1282c;">
        <td valign='top' class='link' colspan=2><font color="#FFFFFF"><strong><?=$lang['YOU_CAN_UPLOAD_MAXIMUM']?>
        <?=$pcount;?>
        <?=$lang['YOUR_BEST_WORK']?></strong></font></td>
        </tr>
        <tr class='link'>
        <td ><?=$lang['PROJECT_TITLE']?> : *</td>
        <td><input type=text name="project_title" style='width:300px' value="<?=$data1['project_title']?>" size="100" /></td>
        </tr>
        <tr class='link'>
        <td ><?=$lang['DESCRIBING_SHORT']?> : *</td>
        <td><textarea name="description"  style="width:300px;height:50px"><?=$data1['description']?></textarea>
        <br />
        <small><?=$lang['NOT_MORE_THAN']?></small></td>
        </tr>
        <tr class='link'>
        <td ><?=$lang['PICTURES_EXAMPLES']?> : </td>
        <td><input type="file" name="thumb"  size=30 />
        <br />
        <?=$lang['PICTURES_EXAMPLES']?></td>
        </tr>
		<tr class='link'>
        <td ><?=$lang['PICTURES_EXAMPLES']?> : </td>
        <td><input type="file" name="thumb1"  size=30 />
        <br />
        <?=$lang['PICTURES_EXAMPLES']?></td>
        </tr>
		<tr class='link'>
        <td ><?=$lang['PICTURES_EXAMPLES']?> : </td>
        <td><input type="file" name="thumb2"  size=30 />
        <br />
       <?=$lang['PICTURES_EXAMPLES']?></td>
        </tr>
		<tr class='link'>
        <td ><?=$lang['PICTURES_EXAMPLES']?> : </td>
        <td><input type="file" name="thumb3"  size=30 />
        <br />
        <?=$lang['PICTURES_EXAMPLES']?></td>
        </tr>
		<tr class='link'>
        <td ><?=$lang['PICTURES_EXAMPLES']?> : </td>
        <td><input type="file" name="thumb4"  size=30 />
        <br />
        <?=$lang['PICTURES_EXAMPLES']?></td>
        </tr>
        <tr class='link'>
        <td ></td>
        <td>
		 <input type="submit"  class="submit_bott" value="Update"  />
		<!--<input name="image" type="image" src="images/update.jpg"   />-->
        <input type=hidden name='SBMT'  value='Submit' /></td>
        </tr>
        </table></td>
        </tr>


        </table>
        </form>
        <script language="JavaScript" type="text/javascript">
		
		  var frmvalidator  = new Validator("exp_form");
		  frmvalidator.addValidation("project_title","req","Please enter title.   ");     
		  frmvalidator.addValidation("description","req","Please enter job details.   ");
		  
		</script>
        
        
        <div style='padding-left:10px;padding-right:10px'>
        
        <?php
        $r1=mysql_query("select * from " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " order by add_date desc"); 
        $num=mysql_num_rows($r1);
        if($num > 0)
        {
        ?>
        
        <div style=" color:#3387B1; font-size:15px; font-weight:bold; border-bottom:1px solid #CCCCCC;"><?=$lang['UPLOAD_PORTFOLIO']?></div>
        <?php
        }
        ?>
		
		
     <?
	
	 while($d1=mysql_fetch_array($r1)):
	  $date_up=explode('-',$d1[add_date]);
        $date=$date_up[2].'-'.$date_up[1].'-'.$date_up[0];
	 ?>  
	   
	   
	   <table width="100%" border="0" cellspacing="2" cellpadding="6" style=" font-size:12px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >
  <tr>
    <td width="27%" align="left" valign="top">
	<?php
	//print_r($d1[image]);
	list($image_ex,$ext)=explode('.',$d1[image]);
	//echo $ext;
	if($ext!='jpg' && $ext!='png' && $ext!='gif' && $ext!='jpeg')
	{
	//echo "aA";
	?>
		<a href="<?=$d1[image]?>"><img src='image.php?img=images/word_doc.jpg&x=100&y=100' border=0></a>
		
	<?php	
	}
	else
	{
	//echo "dasdasdas";
	?>
		<img src='image.php?img=<?=$d1[image]?>&x=100&y=100' border=0>
		
	<?php
	}
	?>
	</td>
    <td width="73%" align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="color:#4E4D4D; font-size:12px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >
  <tr>
    <td colspan="2"><strong><?=$d1[project_title]?></strong></td>
    </tr>
  <tr>
    <td colspan="2"><?=$d1[description]?></td>
  </tr>
  <tr>
    <td width="31%"><?=$lang['UPDATED_ON']?> <?=$date?></td>
    <td width="69%"><a href="upload-portfolio.php?ed=1&EDIT=<?php echo $d1[id]; ?>" class=boldfont_name onclick='javascript:valueEdit()'><?=$lang['EDIT']?></a> | <a href='upload-portfolio.php?DELT=<?php echo $d1[id]; ?>' class=boldfont_name onclick='javascript:confirm(Do you really want to delete it ?)'><?=$lang['DELETE']?></a></td>
  </tr>
</table>

	</td>
  </tr>
  
  
  
  <?
   if($d1[image1]!="")
   {
  ?>
  
  
  <tr>
    <td><img src='image.php?img=<?=$d1[image1]?>&x=100&y=100' border=0></td>
    <td>&nbsp;</td>
  </tr>
  <?
   }
  
  ?>
  
  <?
   if($d1[image2]!="")
   {
  ?>
  
  
  <tr>
    <td><img src='image.php?img=<?=$d1[image2]?>&x=100&y=100' border=0></td>
    <td>&nbsp;</td>
  </tr>
 <?
 }
 ?> 
  
  
  
  
  <?
   if($d1[image3]!="")
   {
  ?>
  <tr>
    <td><img src='image.php?img=<?=$d1[image3]?>&x=100&y=100' border=0></td>
    <td>&nbsp;</td>
  </tr>
  <?
  }
  ?>
  
  
  <?
   if($d1[image4]!="")
   {
  ?>
  <tr>
    <td><img src='image.php?img=<?=$d1[image4]?>&x=100&y=100' border=0></td>
    <td>&nbsp;</td>
  </tr>
  <?
  }
  ?>
  
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<?

endwhile; 
?>







	   
	    
        </div>	
											
										
										
										
<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->			
                </td>
            </tr>
<!------------------------------------------------Middle Body End---------------------------------------------------------->
            </table>

    
</div>
<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->
   </div>

   
   </div>
<!--end content-->


</div>
</div>
</div>
</div>
<?php include 'includes/footer.php';?> 
</body>
</html>