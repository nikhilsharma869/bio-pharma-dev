<?php
	function get_file_type($v){
			$file_type=array(
		'image/jpeg'=>'IMAGE',
		'image/png'=>'IMAGE',
		'image/gif'=>'DOCUMENT',
		'application/msword'=>'DOCUMENT',
		'application/docx'=>'DOCUMENT',
		'application/txt'=>'TEXT',
		'video/avi'=>'VEDIO',
		'video/mp4'=>'VEDIO',
		'video/3gp'=>'VIDEO',	
		'application/pdf'=>'PDF'
	);
	
		$d=$file_type[$v];
		if(isset($d)){
		}else{
			$d="UNKNOWN";
		}
		return $d;
	}
	
	function media_icon($v){
		$ic=WEB_MED.'/images/crystal/';
		$file_type=array(
			'DOCUMENT'=>'document.png',
			'VEDIO'=>'video.png',
			'PDF'=>'default.png',
			'TEXT'=>'text.png',
			'UNKNOWN'=>'default.png');
		$tc=isset($file_type[$v])?$file_type[$v]:'default.png';
		return $ic.$tc;
	}
	
	function media_add($v){
		$p_type='attachment';
		$p_mtype= $v['type'];
		$dir=MEDPATH;
		$icon=media_icon($p_mtype);
		$folder='';
		$txt='';
		$title=isset($v['media_title'])?$v['media_title']:'';
		$desc=isset($v['media_description'])?$v['media_description']:'';
		$fht='';
		if($p_mtype=='IMAGE'){
			$folder='/images/';
			$ft='big/';
			$ftf=file_name(array('file'=>$v['name'],'dir'=>$dir.$folder.$ft,'overwrite'=>'false'));
			$RI=new_image($v['name'],$v['tmp_name']);
			$RI->resizeImage(800, 800);
			$RI-> saveImage($dir.$folder.$ft.$ftf, 100);
			
			$ft='midiam/';
			$ftf=file_name(array('file'=>$v['name'],'dir'=>$dir.$folder.$ft,'overwrite'=>'false'));
			$RI=new_image($v['name'],$v['tmp_name']);
			$RI->resizeImage(200, 200);
			$RI-> saveImage($dir.$folder.$ft.$ftf, 100);			
			$ft='smale/';
			$ftf=file_name(array('file'=>$v['name'],'dir'=>$dir.$folder.$ft,'overwrite'=>'false'));
			$RI=new_image($v['name'],$v['tmp_name']);
			$RI->resizeImage(100, 100);
			$RI-> saveImage($dir.$folder.$ft.$ftf, 100);			
			$fht=WEB_MED.$folder.'big/'.$ftf;
		}
		else{
			 if($p_mtype=='VEDIO'){
			$folder='/video/';
			}
			else{
				$folder='/document/';
			}
			
			$f_n=_upload(array('file'=>$v,'dir'=>$dir.$folder,'overwrite'=>'false'));			
		$fht=WEB_MED.$folder.$f_n;
			$txt=$f_n;
			
		}
	
		$sql="INSERT INTO `media` (`media_titel`, `media_type`, `media_description`, `media_link`, `media_date`, `media_icon`) VALUES ('".$title."', '".$p_mtype."', '".$desc."', '".$fht."', '".date("Y")."-".date("n")."-".date("d")."-".date("h").":".date("s").":00', '".$icon."')";
		
		run_quary($sql);
		$rs=array('mid'=>mysql_insert_id(),'link'=>$fht,'type'=>$p_mtype);		
		return $rs;
		
	}

	
?>