<?php
class thumbnail
{
	var $img;
	var $quality = 72;
  	var $pos_x = "RIGHT"; 
  	var $pos_y = "BOTTOM"; 
 	function thumbnail($imgfile)
  	{
		 if(!file_exists($imgfile)){
		   $this->CreateErrorImage('file not found!');
		 }
		 list($width, $height, $type) = getimagesize($imgfile);
		 $types = array(1=>'GIF',2=>'JPEG',3=>'PNG',4=>'SWF',5=>'PSD',6=>'BMP',7=>'TIFF(intel byte order)',8=>'TIFF(motorola byte order)',9 =>'JPC',10 =>'JP2',11 =>'JPX',12 =>'JB2',13 => 'SWC',14 => 'IFF',15 => 'WBMP',16 => 'XBM');
		 if($type>3){
		   $this->CreateErrorImage('Error format file!');
		 }
		 $this->width = $width;
		 $this->height = $height;
		 $this->type = $types[$type];
		 $this->image = $this->imageCreateFromX($imgfile);
  	}
	
  	function imageCreateFromX($file)
  	{
     	switch ($this->type)
		{
      		case "JPEG" :   return ImageCreateFromJPEG($file);	break;
      		case "PNG" :    return ImageCreateFromPNG($file);  	break;
      		case "GIF" :    return ImageCreateFromGIF($file); 	break;
      		default : $this->CreateErrorImage("Cannot find image!");
		}
  	}
	
  	function imageCreateX($file,$saveFile="")
	{
    	switch ($this->type)
	 	{
      		case "JPEG" :  ImageJPEG($file,NULL,$this->quality);	break;
      		case "PNG" :   ImagePNG($file);                   	break;
      		case "GIF" :	 ImageGIF($file);                   break;
	 	}
     	return true;
  	}
  	function imageSaveX($file,$saveFile="")
  	{
     	switch ($this->type)
		{
      		case "JPEG" : ImageJPEG($file,"$saveFile",$this->quality);	break;
      		case "PNG" :  ImagePNG($file,"$saveFile");         			break;
      		case "GIF" :  ImageGIF($file,"$saveFile");         			break;
		}
    	return true;
  	}	
	
	function size_height($size=100)
	{
		
		if($size > $this->height){$size = $this->height; }
    	$this->new_height=$size;
    	$this->new_width =  round(($this->new_height/$this->height)*$this->width);
		$this->x = 0;
		$this->y = 0;
  	}
	function size_width($size=100)
	{
		
		if($size > $this->width){$size = $this->width; }
		$this->new_width=$size;
    	$this->new_height = round(($this->new_width/$this->width)*$this->height);
		$this->x = 0;
		$this->y = 0;
	}
	function size_auto($size=100)
	{
		
		if ($this->width >= $this->height) 
		{
    		if($size > $this->width){$size = $this->width; }
		    $this->new_width=$size-10;
    	  	$this->new_height = $size/*round(($this->new_width/$this->width)*$this->height)*/;
		}
		else
		{
	    	if($size > $this->height){$size = $this->height; }
    	  	$this->new_height=$size;
    	  	$this->new_width = $size-10;/* round(($this->new_height/$this->height)*$this->width)*/;
 		}
		$this->x = 0;
		$this->y = 0;
	}
	
	function size_crop($size=100)
	{
		
		if ($this->width >= $this->height) { 		
		    $biggestSide = $this->height; 
		} else {	    	
		    $biggestSide = $this->width;
		}
		$cropPercent = 1; 
    	$this->new_width   = round($biggestSide*$cropPercent); 
    	$this->new_height  = round($biggestSide*$cropPercent);
		$this->x = round(($this->width-$this->new_width)/2);
    	$this->y = round(($this->height-$this->new_height)/2);
		
		if($size > $this->width OR $size > $this->height)
		{
		   if($this->width  > $this->height){ 	 
			   $size = $this->height;			
			 }else{  
			   $size = $this->width;			
			 } 
		}
		$this->width = $this->new_width ;
		$this->height = $this->new_height; 
		$this->new_width = round($size);
		$this->new_height = round($size); 
	}
	
	function size_width_height($size_w=100,$size_h=100)
	{
		
		if($size_w >= $this->width){$size_w = $this->width;}
		if($size_h >= $this->height){$size_h = $this->height;}
		
		$Correlation_main = $this->height/$this->width;
		$Correlation_new = $size_h/$size_w;
			
		if($Correlation_main < $Correlation_new)
		{
		   	$tmp = ($Correlation_main/$Correlation_new);
		   	$this->new_width   = round($this->width*$tmp); 
       		$this->new_height  = round($this->height);
		} else {	    	
 		   	$tmp = ($Correlation_new/$Correlation_main);
			$this->new_width   = round($this->width); 
       		$this->new_height  = round($this->height*$tmp);
		}
		
		$this->x = round(($this->width-$this->new_width)/2);
    	$this->y = round(($this->height-$this->new_height)/2);
	
		$this->width = $this->new_width ;
		$this->height = $this->new_height; 
		$this->new_width = round($size_w);
		$this->new_height = round($size_h); 
	}
	
	function show()
	{
		
	  	$this->newImage = ImageCreateTrueColor($this->new_width ,$this->new_height);
    	$bg = imagecolortransparent($this->newImage);   
	   //$bg=imagecolorallocate($newImage,255,255,255);
	  	imagefill($this->newImage, 0, 0, $bg ); 
		imagecopyresampled($this->newImage, $this->image, 0, 0, $this->x, $this->y, $this->new_width, $this->new_height, $this->width, $this->height);
		header("Content-type: image/".$this->type);
	  	$this->imageCreateX($this->newImage);
		imagedestroy($this->newImage);
	}
	function save_thumb($saveFile="")
	{
		
		if (empty($saveFile)) $saveFile=strtolower("./thumb.".$this->type);
		$newImage = ImageCreateTrueColor($this->new_width ,$this->new_height);
    	imagecopyresampled($newImage, $this->image, 0, 0, $this->x, $this->y, $this->new_width, $this->new_height, $this->width, $this->height);
    	header("Content-type: image/".$this->type);
		$this->imageSaveX($newImage,$saveFile);
	}
	
	function add_logo($logo = NULL)
	{
		
		if(!file_exists($logo)){
		   $this->CreateErrorImage('logo not found!');
		}
		$this->newImage = ImageCreateTrueColor($this->new_width ,$this->new_height);
		$bg = imagecolortransparent($this->newImage);
		imagefill($this->newImage, 0, 0, $bg );
		imagecopyresampled($this->newImage, $this->image, 0, 0, $this->x, $this->y, $this->new_width, $this->new_height, $this->width, $this->height);
		list($this->logo_width, $this->logo_height, $this->logo_type) = getimagesize($logo);
		
		switch ($this->logo_type)
		{
      		case "2" :    $this->logo = ImageCreateFromJPEG($logo);	 break;
      		case "3" :    $this->logo = ImageCreateFromPNG($logo);   break;
      		case "1" :    $this->logo = ImageCreateFromGIF($logo); 	 break;
      		default : 
		}
	  	$this->wt_x = $this->calc_pos_x($this->pos_x);
    	$this->wt_y = $this->calc_pos_y($this->pos_y); 
    	imagecopy($this->newImage, $this->logo, $this->wt_x, $this->wt_y, 0, 0, $this->logo_width, $this->logo_height);
		header("Content-type: image/".$this->type);
		$this->imageCreateX($this->newImage);
		imagedestroy($this->newImage);
	}
	
	function CreateErrorImage($text)
	{
		$im = imagecreate(110, 30);
		$bg = imagecolorallocate($im, 255, 255, 255);
		$textcolor = imagecolorallocate($im, 255, 0, 0);
		imagestring($im, 2, 0, 0, $text, $textcolor);
		header("Content-type: image/png");
		imagepng($im);
		die();
	}
	
	
	function calc_pos_x($position_x)
  	{
     
		$x = 0;
     	switch($position_x)
		{
      		case 'LEFT':    $x = 0;     break;
      		case 'CENTER':  $x = @$this->new_width/2 - @$this->logo_width/2;  break;
      		case 'RIGHT':   $x = @$this->new_width - @$this->logo_width;      break;
      		default:        $x = 0;
		}
    	return $x;
  }
  function calc_pos_y($position_y)
  {
     
		$y = 0;
     	switch($position_y)
		{
			case 'TOP':    $y = 0;      break;
			case 'MIDDLE': $y = @$this->new_height/2 - @$this->logo_height/2; break;
			case 'BOTTOM': $y = @$this->new_height - @$this->logo_height;     break;
			default:       $y = 0;
  		}
    	return $y;
  } 
	
		
}
?>