<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
$upload_ext=array("jpg","jpeg","png","gif");
function getExtension($str) 
{
    $ext = pathinfo($str, PATHINFO_EXTENSION);

    return strtolower($ext);
}
function generateRandomString($length = 10, $letters = '1234567890qwertyuiopasdfghjklzxcvbnm')
  {
      $s = '';
      $lettersLength = strlen($letters)-1;
     
      for($i = 0 ; $i < $length ; $i++)
      {
      $s .= $letters[rand(0,$lettersLength)];
      }
     
      return $s;
  } 
?>
<?
if($_POST[SBMT_REG]):
	if(!$_POST[status]){$status="Y";}else{$status=$_POST[status];}
    $contents=htmlentities($_POST[contents]);
	$post_url = str_replace(' ', '_', $_POST[url]);
	
   	if($_POST[id]):
   		$r=mysql_query("update " . $prev . "halp set 

		question=\"" . $_POST[question] . "\",

		answers=\"". $_POST[answers] . "\",

		ord=\"" . $_POST[ord] . "\",

		status=\"" . $_POST[status] . "\"

		where id=" . $_POST[id]);

		$id=$_POST[id];
	else:
		$r=mysql_query("insert into " . $prev . "halp set 

		question=\"" . $_POST[question] . "\",

		answers=\"". $_POST[answers] . "\",

		ord=\"" . $_POST[ord] . "\",

		status=\"" . $_POST[status] . "\"");

		$id=mysql_insert_id();
	endif;
	if($r):		
		$msg="<font face=Arial size=2 color='#000000'><b>Update Successful.</b></font>";
	else:
		$msg="<font face=Arial size=2 color=red><b>Error! Please try again.</b></font>";
	endif;
endif;
if($_REQUEST[id]){$id=$_REQUEST[id];}
if($id):
	$r=mysql_query("select * from " . $prev . "halp where id=" . $id);
   	$d=@mysql_fetch_array($r);
endif;
if(!$d['status']){$d['status']="Y";}
?>
<script language="javascript" type="text/javascript">
<!--
function ValidEditor(register)
{
    var txt="";
	if(!register.cont_title.value)
	{
		txt+="     Title should not be empty.\n"
	}

   	if(txt)
	{
   		alert("Sorry!! Following errors has been occured :\n\n"+ txt +"\n     Please Check");
  	 	return false
	}
    return true
}
function txtduplicate(dest,src) 
{
	var src3=document.getElementById(src).value;
	if(src3!="" && document.getElementById('id').value != '1' )
	{
	var src2=src3.replace(/\s/g,"_");
	document.getElementById(dest).value="<?=$vpath?>cms/"+src2+".htm";
	}
	else
	{
		document.getElementById(dest).value="";
	}
}
function textCounter(field,cntfield,maxlimit) {
	   if (field.value.length > maxlimit) { 
	   field.value = field.value.substring(0, maxlimit);
	   alert('Max lenght is 300 characters. You have typed ' + field.value.length + ' charachters.');
	   }
	   // otherwise, update 'characters left' counter
	   else
	   cntfield.value = maxlimit - field.value.length;
	   }
	   
//-->
var browser=navigator.appName;
	if(browser=="Microsoft Internet Explorer")
	{
		var displaystyle="block";
	}
	else
	{
		var displaystyle="table-row";
	}
function appearmenu()
	{
		if(document.getElementById("menu").checked==true)
		{
			document.getElementById("aurl").style.display=displaystyle;
			document.getElementById("aord").style.display=displaystyle;
			document.getElementById("mimage").style.display=displaystyle;
			document.getElementById("mhimage").style.display=displaystyle;
			document.getElementById("imimage").style.display=displaystyle;
			document.getElementById("imhimage").style.display=displaystyle;
		}		
		else
		{
			document.getElementById("aurl").style.display="none";
			document.getElementById("aord").style.display="none";
			document.getElementById("mimage").style.display="none";
			document.getElementById("mhimage").style.display="none";
			document.getElementById("imimage").style.display="none";
			document.getElementById("imhimage").style.display="none";
		}
	}
function mylogo(str)
{
	if(str!='choose')
	{
		location.href='page.editor.php?id=8&lid='+str;
		return true;
	}
	else
	{ return false;}
}
</script>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script src="../ckeditor/_samples/sample.js" type="text/javascript"></script>


    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			

<script src="js/jquery.genyxAdmin.js"></script>
 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="help.list.php">Faq Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Faq Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='help.list.php' class="header">&nbsp;Help List:</a> <?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
<form method="post" name="faqreg" action="<?=$_SERVER['../PHP_SELF'];?>" onsubmit="javascript:return faq_validity(document.faqreg.status, document.faqreg.faq_type);">
<input type="hidden" name="id" value="<?=$_GET[id]?>">


<table width="100%" border="0" align="center" cellspacing="1" cellpadding="4" bgcolor="<?=$light?>" class="table">

<tr class=header_tr><td height=30 colspan=2><a href="javascript:window.parent.location.href='halp.list.php'" class="header"><b>Admin Halp Entryform:</b></a>  <?=$d[question]?> </td>

</tr>

<tr bgcolor="#ffffff" class="lnk"><td width="20%">Question</td>

<td width="80%"><input type="text" id="question_id" name='question'  size=63 value="<?=$d[question]?>" ></td></tr>

<tr bgcolor="#ffffff" class="lnk">

  <td>Display Order</td>

  <td><input type="text" id="ordr_id" name='ord'  value="<?=$d[ord]?>" size=4 maxlength="3"></td></tr>

<tr bgcolor="#ffffff" class="lnk"><td>Status </td><td><input type="radio" value='Y' name="status"  <? if($d[status]=="Y" or $d[status]==""){echo"checked";}?>>Active <input type=radio name=status value='N' <? if($d[status]=="N"){echo"checked";}?>>Hidden</td></tr>

<tr bgcolor="#ffffff" class="lnk"><td  valign="top">Answers</td>

<td>
                <?php				
				include_once '../ckeditor/ckeditor.php';
				include_once '../ckfinder/ckfinder.php';				 
				$ckeditor = new CKEditor();
				$ckeditor->basePath = '../ckeditor/';
				$ckfinder = new CKFinder();
				$ckfinder->BasePath = '../ckfinder/'; // Note: the BasePath property in the CKFinder class starts with a capital letter.
				$ckfinder->SetupCKEditorObject($ckeditor);
				$ckeditor->editor('answers',html_entity_decode($d["answers"]));
				?>
</td></tr>
<tr><td colspan="2" height="20" align="center" >
<?php 
if($_REQUEST['id'])
{ 
?>
	<input type="submit"  name='SBMT_REG' value='Update' class="lnk" >
<?php 
}
else 
{ 
?>
	<input type="submit"  name='SBMT_REG' value='Add' class="lnk" >
<?php 
}
?>&nbsp;&nbsp;<input type="Reset" class="lnk"></td></tr>
</table>
</form>



<!-----------------------------------------------for logo upload only---------------------------------------------------->
<?php

if($_POST['sub']=='Upload')
{
	if($_FILES['cont_logo']['name']!="")
	{
		$logo_path="../upload/".time()."_logo_".$_FILES['cont_logo']['name'];
		$r1=mysql_query("insert into ".$prev."partners set
		page_id='".$_POST['id']."',
		logo_name='".$_FILES['cont_logo']['name']."',
		logo='".$logo_path."',
		logo_description='".htmlentities($_POST['logo_desc'])."',
		status='Y'");
		if($r1)
		{ copy($_FILES['cont_logo']['tmp_name'], $logo_path); }
	}
	else
	{
		$msg='u have not selected any file to upload';
	}
}
if($_POST['up']=="Update")
{
	mysql_query("update ".$prev."partners set 
	logo_description='".htmlentities($_POST['logo_desc'])."' where id='".$_POST['hidd']."'");
}
if($_POST['del']=="Delete")
{
	mysql_query("delete from ".$prev."partners where id='".$_POST['hidd']."'");
}
if($_GET['id']=='8')
	{
		$res=mysql_query("select * from ".$prev."partners where page_id='8'");
		$res1=mysql_query("select * from ".$prev."partners where id='".$_GET['lid']."'");
		$row1=mysql_fetch_array($res1);
?>
<form method='post' name="logo_frm" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="hidden" name="id" value="<?=$d[id]?>">
<table width="100%" border="0" align="left" cellspacing="1" cellpadding="4" class="table table-striped table-bordered table-hover" id="dataTable">
<tr class="header">
	<td height=30 style="border-bottom:solid 2px <?=$dark?>" colspan=2>
		<a href="content.list.php" class="header" ><b><u>Partner-Logo Management</u></b></a>
		&nbsp;:&nbsp; Page Editor : <?=ucwords($d[cont_title])?> &nbsp;&nbsp;<? if($msg){?><BLINK><?=$msg?></BLINK><? }?>
	</td>
</tr>

<tr bgcolor="#ffffff" class="lnk">
	<td valign="top" width="25%">
		<b>Upload Logo</b><font color="#CC3300">*</font>
	</td>
	<td width="75%">
		<input type="file" name='cont_logo' id="cont_title"  size="30" value="<?=$row1[logo_name]?>" onkeyup="txtduplicate('url','cont_title');" style="width:50%;" />
	</td>
</tr>
<tr bgcolor="#ffffff" class="lnk">
	<td valign="top" width="25%">
		<b>Select Logo</b><font color="#CC3300">*</font>
	</td>
	<td width="75%">
		<select name="logo_select" onchange="return mylogo(this.options[this.selectedIndex].value);">
			<option value="choose">select</option>
<?php 
		while($row=mysql_fetch_array($res))
		{
?>
			<option <?php if($_GET['lid']==$row['id']) {?> selected="selected" <?php }?> value="<?php print $row['id']?>">
			<?php print ucwords($row['logo_name']);?></option>
<?php 	} ?>
		</select>
	</td>
</tr>
<tr bgcolor="#ffffff" class="lnk"><td  valign="top" colspan="2"><b>Partner Description</b></td></tr>

<tr  bgcolor="#ffffff" class="lnk"><td colspan="2">
<?php
			require_once($fckapath."fckeditor.php") ;
			/*echo $fckapath."fckeditor.php";*/
			// Automatically calculates the editor base path based on the _samples directory.
			// This is usefull only for these samples. A real application should use something like this:
			// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
			
			$sBasePath =$fckbasepath;
			//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "admin" ) )."fckeditor/" ;
			$oFCKeditor = new FCKeditor('logo_desc') ;
			$oFCKeditor->BasePath = $sBasePath ;
			$oFCKeditor->ToolbarSet = "Default";
			$oFCKeditor->Width = "100%";
			$oFCKeditor->Height = "300";
			$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/silver/' ;
			
			$oFCKeditor->Value =stripslashes(html_entity_decode($row1['logo_description']));
			$oFCKeditor->Create() ;
			?>
</td></tr>
<tr>
	<td colspan="2" height="20" align="center" >
	<?php
		if(isset($_GET['lid'])&&isset($_GET['id']))
		{
	?>
			<input type="hidden"  name='hidd' value=<?php print $_GET['lid'];?>  />
			<input type="submit"  name='up' value='Update' class="lnk" >
			<input type="submit"  name='del' value='Delete' class="lnk" >
	<?php
		}
		else
		{
	?>
			<input type="submit"  name='sub' value='Upload' class="lnk" >
	<?php 
		}
	?>
			
	</td>
</tr>
</table>
</form>

<?php } ?>
<!------------------------------------------------end logo upload---------------------------------------------------->
                                </div><!-- End .panel-body -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-12  --> 
                    </div><!-- End .row-fluid  -->

                </div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    </div><!-- End .main  -->
	 

  </body>
</html>