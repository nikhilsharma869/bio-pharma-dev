<?php
	//My SQL class 
	class mysql{
		var $h="";
		var $u="";
		var $p="";
		var $d="";
		var $Er="";
		
		function mysql($host,$user,$pass,$db=""){
			$h=$host;
			$u=$user;
			$p=$pass;
			
			if(! mysql_connect($h, $u, $p)){
				$Er=mysql_error();
				die("Sorry ! Can't connect to MySQL server. ") ;
			}	
			if($db != ""){
				$this -> selDB($db);
			}		
		}
		function selDB($db){
			mysql_select_db($db);
		}
		function convart_array($v){
			$r[]= array();
			$i=0;
			while($rt=mysql_fetch_array($v)){
				$r[$i]=$rt;
				$i++;
			}
			return $r;
		}
		function select($q){
			$r=mysql_query($q);
			return $this->convart_array($r);
		}
		function select_array($q){
			$r=mysql_query($q);
			return mysql_fetch_array($r);
		}
			
		function run($q){
			if(mysql_query($q)){
				return true;
			}else{
				return false;
			}
		}
		function test($v){
			$r=mysql_query($v);
			return $r;
		}
		
	}
?>