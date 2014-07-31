<?php 
	include "configs/path.php";
	session_start();
	CheckLogin();
	include("country.php");
	//echo getdate();
	$arr = getdate();
	//echo $arr[0];
	if($_POST['submit']){		
	$sql_ev_add=("insert into " . $prev . "events (reminder,user_id,reminder_on) VALUES('" . $_POST['reminder'] . "'," . $_SESSION['user_id'] . ",'" . $_POST['reminder_on']."')");
	mysql_query($sql_ev_add);
	//echo $sql;
	header('Location: '.$vpath.'calendar.php');	
	}
?>
<html>
<head>
<link rel="stylesheet" href="jquery/jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">
<!--	<script type="text/javascript">
    function ajax(){
	var XMLHTTP = XMLHttpRequest || ActiveXObject("Microsoft.XMLHTTP");
	if(typeof(XMLHttp!="undefined"){
		var xmlhttp=new XMLHTTP;
		xmlhttp.onreadystatechange= function(){
			if(xmlhttp.readyState==4){
				var resp=xmlhttp.responseText;
				document.getElementById("response").innerHTML=resp;
			}
		}
		xmlhttp.open("GET", "http://yahoo.co.in", true);
		xmlhttp.send(null);
	  }
	}
    </script>-->
	<script src="jquery/jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>
	<script src="jquery/jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jquery/jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jquery/jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker_from" ).datepicker({
			showOn: "button",
			buttonImage: "images/caln.png",
			buttonImageOnly: true
		});
	});
	$(function() {
		$( "#datepicker_to" ).datepicker({
			showOn: "button",
			buttonImage: "images/caln.png",
			buttonImageOnly: true
		});
	});
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
    </head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="set_reminder" method="post" target="_parent">
<div class="reminder" style="width:100%; font-family:Arial, Helvetica, sans-serif; color:#2F5b67"><h2><?=$lang['ST_RMNDR']?></h2></div>
<table class="reminder" style="color:#2F5B67;">

<tr>
<td valign="top"><b><?=$lang['RMND_FR']?>:</b> </td>
<td><textarea name="reminder" cols="20" rows="5"></textarea></td>
</tr>

<tr><td></td><td><input type="text" name="reminder_on" id="datepicker_from" readonly="" size="10" style="margin-right: 6px;" <?php if(isset($_POST['sub_go'])){?> value="<?php print $_POST['reminder_on'];?>"<?php }?>/></td></tr>

<tr><td>&nbsp;</td><td><input type="submit" value="Set" name="submit" class="profilebutton" style="color:#333333;"></td></tr>

</table>
</form>
</body>
</html>