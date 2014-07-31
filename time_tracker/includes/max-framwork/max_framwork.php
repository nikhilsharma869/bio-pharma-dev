<?php
require_once(dirname(__FILE__).'/function.php');
if(!_d('FMKPATH')){
_d('FMKPATH',dirname(__FILE__).'/');
}

_req1(FMKPATH.'upload.php');
//For call and create object MYSQL Class
	function new_mysql($host,$user,$pass,$db){
		_req1(FMKPATH.'mysql.php');
		return new mysql($host,$user,$pass,$db);
	}

//For call and create object IMAGE Class
	function new_image($f,$v=''){
		_req1(FMKPATH.'images.php');
		if(isset($v)){
		return new resize($f,$v);
		}else{
			return new resize($f);
			}
	}
	
	function new_php_js(){
		_req1(FMKPATH.'php.js.php');
	}
?>