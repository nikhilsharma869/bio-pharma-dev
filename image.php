<?
function imageresize($max_width,$max_height,$image)
{
	$dimensions=getimagesize($image);
	$width_percentage=$max_width/$dimensions[0];
	$height_percentage=$max_height/$dimensions[1];
	if($width_percentage <= $height_percentage)
	{
		$new_width=$width_percentage*$dimensions[0];
		$new_height=$width_percentage*$dimensions[1];
	}
	else
	{
		$new_width=$height_percentage*$dimensions[0];
		$new_height=$height_percentage*$dimensions[1];
	}
	$new_image=array($new_width,$new_height);
	return $new_image;
}
//$dimensions=imageresize("100","250","images/blog.gif");
//$image="<img src='images/blog.gif' width='$dimensions[0]' height='$dimensions[1]'>";


function sizeImage($image, $x, $y, $proportional)
{
	if (!$attr = getimagesize($image))
	{
		trigger_error("GD: Image does not exist. Must be gif, jpeg, or png!",E_USER_ERROR);
	}
	switch ($attr[2])
	{
		case 1:
		$image = imagecreatefromgif($image);
		break;
		
		case 2:
		$image = imagecreatefromjpeg($image);
		break;
		
		case 3:
		$image = imagecreatefrompng($image);
		break;
		
		default:
		trigger_error("GD: Image type wrong. Must be gif, jpeg, or png!", E_USER_ERROR);
	}
	if($proportional)
	{
		if($attr[0]<$attr[1])
		{
			$x = $y * ($attr[0]/$attr[1]);
		}
		else
		{
			$y = $x / ($attr[0]/$attr[1]);
		} 
	}
   
	$newimage = imagecreatetruecolor($x,$y);
	imagecopyresampled($newimage, $image, 0, 0, 0, 0, $x, $y, $attr[0], $attr[1]);
	imagepng($newimage);
	imagedestroy($image);
	imagedestroy($newimage);
}
 $image = $_GET['img']; //image location
if(!file_exists($image)){$image="";}
if(!$_REQUEST[x] && !$_REQUEST[y]):
	$x = 135; //width
	$y = 192; //height
else:
    $x = $_REQUEST[x]; //width
	$y = $_REQUEST[y]; //height
endif;
$proportional = TRUE; //proportional or not
if(substr_count($_SERVER[PHP_SELF],"admin")){$dot="../";}

if(!$image){$image="images/blank_logo.gif";}
header("Content-type: image/png"); //so we can use the image right in a tag. <img src="image.php?image=me.gif">
sizeImage($image, $x, $y, $proportional);
?>


