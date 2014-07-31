<?php session_start();
include("configs/path.php");
if(!$_SESSION[user_id]){
	/*echo"<script>alert('You are not Login!');javascript:window.opener.location='login.php?referer=postjob.php?id=" . $_REQUEST[project_id] . "';window.close();</script>"; */   
   //redirect("sign.in.php?referer=" .$_SERVER[PHP_SELF] . "?" . $QUERY_STRING);
}
?>
<!DOCTYPE html>

<script type="text/javascript">
function fun()
{
<? if($row1[user_type]=='emp'){
?>
parent.location.href='empProfile.php?tp=emp';
<? }else{  ?>
parent.location.href='empProfile.php?tp=emp';
<? }?>

}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<script type="text/javascript">
window.focus();
//window.resizeTo(400,330);
function chking()
{
	var fi = document.getElementById('attachment');
	//alert (fi.value);
	if(fi.value=="")
	{
		alert('<?=$lang['ALRT_32_H']?>
');
		return false;
	}
	else if(fi.files[0].size>1024*1024)
	{
	alert (fi.files[0].size);
		alert('<?=$lang['ALRT_33_H']?>
');
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<form action="" method="post" enctype='multipart/form-data'>
<table width="100%" cellspacing="0" cellpadding="4" class=lnk align=center style='border:solid 1px #3387b1'>
<tr bgcolor=#eaeaea><td ><h2><?=$lang['UPLOAD_FILE']?>
</h2></td></tr>
<?
//print_r($_POST);
if($_POST['submit']==$lang['SUBMIT'] && $_FILES['attachment']!=""):
$xt=end(explode(".",$_FILES['attachment']['name']));
if($xt=="jpg" || $xt=="jpeg" || $xt=="gif" || $xt=="png" || $xt=="xls" || $xt=="xlsx" || $xt=="doc" || $xt=="docx" || $xt=="zip" || $xt=="rar" || $xt=="pdf"){
$ty=1;
}else{
$ty=0;
}
    if($_FILES['attachment']['size']>1024*1024 && $ty==1):
	    echo"<span class=red><strong>".$lang['ALRT_34_H']."</strong></span>";
	else:	
		if(@copy($_FILES['attachment']['tmp_name'],"attachment/" . time() ."-". str_replace("@","",str_replace(" ","_",basename($_FILES['attachment']['name']))))):
			?>
			<script>
			  var opt = window.opener.document.createElement("option");
			   window.opener.document.getElementById("attachfile").options.add(opt);
			opt.text = "<?=str_replace(" ","_",basename($_FILES['attachment']['name']));?>";
			opt.value = "attachment/<?=time() ."-". str_replace("@","",str_replace(" ","_",basename($_FILES['attachment']['name'])));?>";
		/*
			var sel = window.opener.document.forms['postjob'].attachfile;
			sel.options[sel.options.length] = new Option("<?=str_replace(" ","_",basename($_FILES['attachment']['name']));?>","attachment/<?=time() ."-". str_replace("@","",str_replace(" ","_",basename($_FILES['attachment']['name'])));?>");
			*/
			selectBox = window.opener.document.getElementById('attachfile');

			for (var i = 0; i < selectBox.options.length; i++) {
            selectBox.options[i].selected = true;
        }

		   
			</script>
			
			<?
			
		    echo"<tr style='background:#77a92c; border:1px solid #45670b;'><td align=center><br><br>".$lang['FILE_SUB_SUCC_H']."</td></tr>";
	    else:
		   echo"<tr style='background:#d02f2f; border:1px solid #aa0707;'><td><p align=center><br><br>".$lang['ERR_TRY_H']."<br><br></p></td></tr>";
	    endif;
	endif;	
endif;	
?>				

<tr class=link><td height=150 style='padding-left:50px'><b><?=$lang['FILE_H']?>
</b><br><br><input type="file" size="40" name="attachment" id="attachment" class="link"><br><br><?=$lang['ALRT_33_H']?>
 <br><br>
<input type="submit" id="submit" class="submit_bott" name="submit" onClick="chking();" value="<?=$lang['SUBMIT']?>" />
<!--<input type=hidden name=submit value=1>-->
&nbsp;
<a onClick="window.close(this)" ><button class="submit_bott"><?=$lang['CANCEL']?>
</button></a>

</td></tr>


<tr bgcolor=#eaeaea><td align="center"  height=20></td></tr>
</table>
</form>

</body>
</html>