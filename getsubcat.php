<? include("configs/path.php");
if($_POST[cat_id]!=''){
$rr=mysql_query("select * from " . $prev . "categories where parent_id=" . $_POST[cat_id] . " and status='Y' order by cat_name");
$i=1;
while($row=mysql_fetch_array($rr))
{
if($_SESSION[lang_id])
		{
			$row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id='".$row['cat_id']."' and table_name='categories' and field_name='cat_name' and lang_id='".$_SESSION[lang_id]."'"));					
			$row['cat_name']=$row_content_lang['content'];
		 }
		 	$cat[]=$row['cat_name'];
		 
}
}
$csty=@implode('","',$cat);	
if($csty!=""){
?>
	<script>	
		function getchild(val){
			$('#scat_ids').tagit('createTag', val);
			
			return false;
			}	
	var sampleTags = ["<?=$csty?>"];

$(document).ready(function(){	
	 $('#scat_ids').tagit({
	 onlyAvailableTags : true,
	 allowNewTags: false,
	  placeholderText: 'Add Skills ',
	 availableTags: sampleTags,
	 singleField: true,
     allowSpaces: true,
	beforeTagAdded: function(event, ui) {
    if ($.inArray(ui.tagLabel, sampleTags)==-1)
    return false;  
    }
	 });
	$(".skdiv").click(function(){
	$('.sk').show();
	});
	});
	function Callme(){/*
setTimeout(function() {
	$('.sk').fadeOut('fast');
	}, 1000);
*/	
}	
			
			</script>
			<div class="skdiv"  onblur="Callme();"><p>Chose Skills Or Type In Box:</p>
			<ul class="sk" style=" height: 100px; list-style-type: none; overflow-x: hidden; ">
			<?
			foreach($cat as $val){
			?>
			<li><a href="javascript:void(0)" onclick="getchild('<?=$val?>')"><?=$val?></a></li>
			<?
			}
			?>
			</ul>
			
			<input type=text name="scat_ids" id="scat_ids" class="changebox" value="<?=$in?>" onfocus="getsk()" onblur="getsk1()">
			
			<? }else{?>
			No Skills
			<? }?></div>