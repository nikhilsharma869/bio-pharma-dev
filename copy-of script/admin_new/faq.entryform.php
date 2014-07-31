<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
if($_POST[SBMT_REG]):
     $answers=htmlentities($_POST[answers]);
	
   	 if($_POST[id]):
	    $r=mysql_query("update " . $prev . "faq set 
		question=\"" . $_POST[question] . "\",
		answers=\"". $answers . "\",
		faq_cat=\"" . $_POST[faq_type] . "\",
		ord=\"" . $_POST[ord] . "\",
		status=\"" . $_POST[status] . "\" where id=" . $_POST[id]);
		//echo "update " . $prev . "faq set question=\"" . $_POST[question] . "\",answers=\"". $answers . "\",faq_type=\"" . $_POST[faq_type] . "\",ord=\"" . $_POST[ord] . "\",status=\"" . $_POST[status] . "\" where id=" . $_POST[id];
		$id=$_POST[id];
	 else:
	// echo "insert into " . $prev . "faq set question=\"" . $_POST[question] . "\",answers=\"". $_POST[answers] . "\",faq_type=\"" . $_POST[faq_type] . "\",ord=\"" . $_POST[ord] . "\",status=\"" . $_POST[status] . "\"";
		  //echo"insert into " . $prev . "faq set title=\"" . $_POST[title] . "\",contents=\"". $contents . "\",ord=\"" . $_POST[ord] . "\",status=\"" . $_POST[status] . "\"";
	    $r=mysql_query("insert into " . $prev . "faq set 
		question=\"" . $_POST[question] . "\",
		answers=\"". $answers . "\",
		faq_cat=\"" . $_POST[faq_type] . "\",
		ord=\"" . $_POST[ord] . "\",
		status=\"" . $_POST[status] . "\"");
	//	echo "insert into " . $prev . "faq set question=\"" . $_POST[question] . "\",answers=\"". $answers . "\",faq_type=\"" . $_POST[faq_type] . "\",ord=\"" . $_POST[ord] . "\",status=\"" . $_POST[status] . "\"";
		  //echo"insert into " . $prev . "faq set title=\"" . $_POST[title] . "\",contents=\"". $contents . "\",ord=\"" . $_POST[ord] . "\",status=\"" . $_POST[status] . "\"";
		$id=mysql_insert_id();
	 endif;
	 if($r):
	 $msg="<font face=verdana size=2 color=$dark><b>Update successful.</b></font><br /><br /><br /><a href=\"faq.list.php\" class=lnk target='_parent'><u>Back to FAQ Management</u></a> | <a href=\"faq.entryform.php?id=" . $id . "\" class=lnk target='_parent'><u>Back to FAQ Profile</u></a>";
    	//echo"<p align=center><br><br><font face=verdana size=2 color=$dark><b>Update successful.</b></font><br><br><br><br><a href=\"faq.list.php?id=" . $_REQUEST[id] . "\" class=lnk><u>Back to Faq List</u></a> | <a href=\"faq.editor.php?id=" . $_REQUEST[id] . "&image_id=" . $_REQUEST[image_id]. "\" class=lnk><u>Back to Faq Entry Form</u></a></p>";
	 endif;
endif;
if($_GET[id]){$id=$_GET[id];}
if($_POST[id]){$id=$_POST[id];}
if($id):
$r=mysql_query("select * from " . $prev . "faq where id=" . $id);
$d=@mysql_fetch_array($r);
endif;

?>

<script type="text/javascript">
function faq_validity(stat, faq_typ)
{
	var question=document.faqreg.question.value;
	var ord=document.faqreg.ord.value;
	var answers=document.getElementById('answers').value;
	
 
 var err="";
 
 
   if(question=="")
   {
    err+="*Enter Question.\n";
   }
  
  if(ord=="")
   {
    err+="*Enter the order of question.\n";
   }
    
/*	 if(status=="")
     {
     err+="*Select a status.\n";
     } 
	 if(stat[0].checked==false&&stat[1].checked==false)
	 {
	 	err+="*Select a status.\n";
	 }
	 if(faq_typ[0].checked==false&&faq_typ[1].checked==false&&faq_typ[2].checked==false&&faq_typ[3].checked==false&&faq_typ[4].checked==false)
	 {
	 	err+="*Select a Faq Type.\n";
	 }*/
	if(answers=="")
   	{
    	err+="*Enter Answer of the Question.\n";
   	}
	 if(err!="")
     {
     alert(err);
     return false;
     } 
	 
}
</script>



    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="faq.list.php">Faq Management</a></li>
                    
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
									<a href='faq.list.php' class="header">&nbsp;Faq Management:</a> <?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">


<br />

<? if(!$_POST[SBMT_REG])
{?>

<form method="post" name="faqreg" action="<?=$_SERVER['../PHP_SELF'];?>" onsubmit="javascript:return faq_validity(document.faqreg.status, document.faqreg.faq_type);">
<input type="hidden" name="id" value="<?=$_GET[id]?>">
<table width="100%" border="0" align="center" cellspacing="1" cellpadding="4" bgcolor="<?=$light?>" class="table">
<tr class=header_tr><td height=30 colspan=2><a href="javascript:window.parent.location.href='faq.list.php'" class="header"><b> Faq Entryform:</b></a>  <?=$d[question]?> </td>
</tr>
<tr bgcolor="#ffffff" class="lnk"><td width="20%">Question <span class="span">*</span></td>
<td width="80%"><input type="text" name='question'  size=63 value="<?=$d[question]?>" ></td></tr>
<tr bgcolor="#ffffff" class="lnk">
  <td>Display Order <span class="span">*</span></td>
  <td><input type="text" name='ord'  value="<?=$d[ord]?>" size=4 maxlength="3"> [Example 4]</td></tr>
<tr bgcolor="#ffffff" class="lnk"><td>Status </td><td><input type="radio" value='Y' name="status"  <? if($d[status]=="Y" or $d[status]==""){echo"checked";}?>>Active <input type=radio name=status value='N' <? if($d[status]=="N"){echo"checked";}?>>Hidden</td></tr>
<tr bgcolor="#ffffff" class="lnk"><td>Faq Type</td><td>
<?php
	//$res1=mysql_query("select * from ".$prev."faq_category where id='".$d['faq_cat']."'");
	//$row12=mysql_fetch_array($res1);
	
?>
<select name="faq_type" id="faq_type">
<option value="select">FAQ Type</option>
<?php
    $res_fcat=mysql_query("select * from ".$prev."faq_category where  parent_id=0 and status='Y'");
	while($row_fcat=mysql_fetch_array($res_fcat))
	{
?> 
		
    <optgroup label="<?=ucwords($row_fcat['name']);?>">
	  <?
	  $res_fcat2=mysql_query("select * from ".$prev."faq_category where  parent_id=" . $row_fcat[id]  . " and status='Y'");
	  while($row_fcat2=mysql_fetch_array($res_fcat2)):
	     if($row_fcat2[id]==$d['faq_cat']):
		    echo"<option value='" . $row_fcat2[id] . "' selected>|_" . ucwords($row_fcat2['name']) . "</option>";
		 else:
		      echo"<option value='" . $row_fcat2[id] . "'>|_" . ucwords($row_fcat2['name']) . "</option>";
		 endif;
	  endwhile;
	  ?>  
	</optgroup>
<?php
	}
?>
</select>
</td></tr>
<tr bgcolor="#ffffff" class="lnk"><td  valign="top">Answers <span class="span">*</span></td>

<td>
<?php
			require_once($fckapath."fckeditor.php") ;
			/*echo $fckapath."fckeditor.php";*/
			// Automatically calculates the editor base path based on the _samples directory.
			// This is usefull only for these samples. A real application should use something like this:
			// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
			
			$sBasePath =$fckbasepath;
			//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "admin" ) )."fckeditor/" ;
			$oFCKeditor = new FCKeditor('answers') ;
			$oFCKeditor->BasePath = $sBasePath ;
			$oFCKeditor->ToolbarSet = "Default";
			$oFCKeditor->Width = "100%";
			$oFCKeditor->Height = "400";
			$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/silver/' ;
			
			$oFCKeditor->Value =stripslashes(html_entity_decode($d["answers"]));
			$oFCKeditor->Create() ;
			?>


<!--<textarea cols="60" name="answers" rows="10"><?=$d[answers]?></textarea>--></td></tr>
<tr><td></td>
  <td  height=20>
    <input type=submit  name='SBMT_REG' value='Update' class="button" />
    &nbsp;
    <input type="button" class="button" value="Back" onClick="javascript:window.location.href='faq.list.php'">
  </td></tr>
</table>
</form>
<? }?>
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