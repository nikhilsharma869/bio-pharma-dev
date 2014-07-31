<? include("configs/path.php")?>
<script>
function validatesk(){
if(document.getElementById('skill').value==''){
alert('Chose one skill');
document.getElementById('skill').focus();
return false;
}
if(document.getElementById('rate').value==''){
alert('Chose one rate');
document.getElementById('rate').focus();
return false;
}
document.forms['skform'].submit();


}

</script>
<?
$skif=@mysql_fetch_assoc(mysql_query("select * from ".$prev."user_skills where id='".$_GET[skid]."'"));
?>
<div class="editport_text"><h1><?=$lang['ADD_SKILLS'] ?></h1></div>
<form name="skform" name="skform" action="myprofile.php" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_class">
<tbody><tr>

    <td align="left" valign="top" class="bx-border">

    <table border="0" cellpadding="4" cellspacing="0" align="center" width="97%">



        <tbody><tr><td colspan="2" align="center">

		
		</td></tr>


   
<tr>
	<td valign="top" class="tdclass"><strong><?=$lang['SKILLS']?>: *</strong></td>
	<td>
	<select name="skill" id="skill" size="1" class="from_input_box" style="width:395px;">

    <option value=""><?=$lang['SELECT_SKILL']?></option>
<? $df=mysql_query("select * from ".$prev."skill_data where status='Y'");
while($fetchsk=@mysql_fetch_assoc($df)){
?>
    <option value="<?=$fetchsk[id]?>" <? if($skif[skills_id]==$fetchsk[id]){?> selected=selected<? }?>><?=$fetchsk[name]?></option>
<? }?>

    </select>

    </td></tr>



    <tr>

      <td valign="top" class="tdclass"><strong><?=$lang['RATTING_H'] ?>: </strong></td><td>
	  <select name="rate" id="rate" size="1" class="from_input_box" style="width:395px;">
 <option value=""><?=$lang['SELECT_RATE'] ?></option>
	<? for($rt=1;$rt<=10;$rt++){?>
<option value="<?=$rt?>" <? if($skif[rating]==$rt){?> selected=selected<? }?>><?=$rt?></option>
	<? }?>
      

	 
	

	 
   </td></tr>


    </tbody></table>

    </td></tr>

    <tr><td>&nbsp;</td></tr>

    <tr>

    <td align="left" valign="top" class="inner_bx-bottom">

    <table align="center" width="100%" cellpadding="0" cellspacing="0">

    <tbody><tr class="lnk"><td width="42%"></td>

    <td>

    <input type="button" class="submit_bott" value="Update" name="sksbmt" onclick="return validatesk();">

  

   <!-- <input type="image" src="images/update.jpg"  onClick="return ValidateForm();" />-->

    <input type="hidden" name="hiddskillSubmit" value="1"> 
 <input type="hidden" name="skilid" value="<?=$_GET[skid]?>"> 
    <br>

    </td>

    </tr>

    </tbody></table>

    </td>

    </tr>

    </tbody></table>
	</form>