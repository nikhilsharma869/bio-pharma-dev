<?php

function _upload($v){
	$f;$o='true';$d='';
	if(is_array($v)){
		if(isset($v['file'])){
			$f=$v['file'];
			if(isset($v['dir'])){
				$d=$v['dir'];
				if (!file_exists($d))
				@mkdir($d);
			}	
			if(isset($v['overwrite'])){
				$o=$v['overwrite'];
				
			}	
		
		$trF=$d.basename($f['name']);
			if($o!='true'){
				$fileName=$f['name'];
				
				$ext = strrpos($fileName, '.');
				$fileName_a = substr($fileName, 0, $ext);
				$fileName_b = substr($fileName, $ext);
				$count = 1;				
				while (file_exists($d. $fileName_a . '_' . $count . $fileName_b)){
					$count++;
				}	
				$fileName = $fileName_a . '_' . $count . $fileName_b;
				$trF=$d.$fileName;
			}

		if (move_uploaded_file($f['tmp_name'], $trF)) {
			return $fileName;	
		}else{
			return 'false';
		}							
		}else{
			return 'false';	
		}
	}else{
		return 'false';	
	}
}

function file_name($v){
	$f;$o='true';$d='';
	if(is_array($v)){
		if(isset($v['file'])){
			$f=$v['file'];
			if(isset($v['dir'])){
				$d=$v['dir'];
				if (!file_exists($d))
				@mkdir($d);
			}	
			if(isset($v['overwrite'])){
				$o=$v['overwrite'];
				
			}	
		
		$trF=$d.basename($f);
			if($o!='true'){
				$fileName=$f;
				
				$ext = strrpos($fileName, '.');
				$fileName_a = substr($fileName, 0, $ext);
				$fileName_b = substr($fileName, $ext);
				$count = 1;				
				while (file_exists($d. $fileName_a . '_' . $count . $fileName_b)){
					$count++;
				}	
				$fileName = $fileName_a . '_' . $count . $fileName_b;
				$trF=$d.$fileName;
			}

			if ($trF!="") {
				return $fileName;	
			}else{
				return 'false';
			}								
		}else{
			return 'false';	
		}
	}else{
		return 'false';	
	}
	
}
?>