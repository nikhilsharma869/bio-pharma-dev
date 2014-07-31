<?php
$GLOBALS['php_js_list'] = array();
$GLOBALS['php_js_vali']="php_js";

if($_REQUEST[$GLOBALS['php_js_vali']] == "true"){
	if($_REQUEST[$GLOBALS['php_js_vali'].'_fun']!=""){
		$fn=$_REQUEST['php_js_fun'];	
		if(function_exists($fn)){
			if($_REQUEST[$GLOBALS['php_js_vali'].'_arg']!="" && isset($_REQUEST[$GLOBALS['php_js_vali'].'_arg']) ){
				
				//$ar=explode(',',$_REQUEST[$GLOBALS['php_js_vali'].'_arg']);
				$ar=$_REQUEST[$GLOBALS['php_js_vali'].'_arg'];
			 	echo call_user_func_array($fn, $ar);
				die();
			}else{
				echo call_user_func_array($fn,array());
				die();
			}		
		}else{
			echo 'function not found !';
			die();
		}
	}	
}

function php_js_register(){
		global $php_js_list;
		
		$n = func_num_args();
		for ($i = 0; $i < $n; $i++) {
			$php_js_list[] = func_get_arg($i);
		}
}
function php_js_instal(){
	global $php_js_list;
	$c=$php_js_list;
if(count($c)>0){
	$fun=$GLOBALS['php_js_vali'].'_fun';
	$arg=$GLOBALS['php_js_vali'].'_arg';
	$url='http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['PHP_SELF'].'?'.$GLOBALS['php_js_vali'].'=true&'.$fun.'=';
?>
<script language="JavaScript">
function php_js_msx(){
	var msxmlhttp = new Array(
				'Msxml2.XMLHTTP.5.0',
				'Msxml2.XMLHTTP.4.0',
				'Msxml2.XMLHTTP.3.0',
				'Msxml2.XMLHTTP',
				'Microsoft.XMLHTTP');
			for (var i = 0; i < msxmlhttp.length; i++) {
				try {
					A = new ActiveXObject(msxmlhttp[i]);
				} catch (e) {
					A = null;
				}
			}
 			
			if(!A && typeof XMLHttpRequest != "undefined")
				A = new XMLHttpRequest();
			if (!A)
				sajax_debug("Could not create connection object.");
			return A;
}
function req_php_js(f,a){
var post_data="";
var args=a;
var	data="";
for (i = 0; i < args.length-1; i++) {
	post_data = post_data + "&<?php echo $arg;?>[]=" + escape(args[i]);
}
	var msx=php_js_msx();
	msx.onreadystatechange = function()
  	{
    if(msx.readyState == 4 && msx.status==200)
    {
      data=msx.responseText;
      var callback;
		try {
			var callback;
			var extra_data = false;
			if (typeof args[args.length-1] == "object") {
					callback = args[args.length-1].callback;
							extra_data = args[args.length-1].extra_data;
					} else {
							callback = args[args.length-1];									
					}
					callback(data, extra_data);
				} catch (e) {
								
			}
    }
  }

url="<?php echo $url;?>" + f + post_data;
  msx.open("GET", url, true); 
  msx.send(null);
}
<?php
	foreach($c as $v){
		?>
		function <?php echo $v;?>(){
			<?php echo 'req_php_js("'.$v.'",'.$v.'.arguments);';?>
		}
		<?php
	}
?>
</script>
<?php
}
}
?>