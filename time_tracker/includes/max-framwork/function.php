<?php
//Its requerd for short from of some php inbild function

// for show/print function
function _e($v){
	echo($v);
}
function _p($v){	
	print($v);
}
function _pr($v,$r=false){
	print_r($v,$r);
}

//geting varaible type
function _gtype($v){
	return gettype($v);
}
function _d($n,$v=null){	
	if( $v != null){
		return define($n,$v); 
	}else{
		return defined($n);
	}
}


//validating function / calss
function _isfun($v){
 return function_exists($v);
}
function _isclass($v){
	class_exists($v);
}

// for includin php file
function _inc($f){
	include($f);
}
function _req($f){
	require($f);
}
function _req1($f){
	require_once($f);
}


//for io / file system
function _dir($p){
	return dirname($p);
}
function _isFile($p){
   return file_exists($p);
}


//for array function
function find_arrays($a,$f){
	
}
function find_array($v,$f){
	$r=array();
	$i=0;
	if(is_array($f)){
		$k=array_keys($f);
	}else{
		foreach($v as $c){
			$x=split('=>',$f);
			if(count($x)>0){
				if($c[$x[0]]==$x[1].''){
					$r[$i]=$c;
					$i++;
				}
			}
		}
	}
	
	if($i>0){
		return $r;
	}else{
		return false;
	}
}




//for nevigation
function _protocal(){
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	return $uri;
}	

//for current url;
function _url()
{
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}


function _gourl($url){
?>
<script language="JavaScript">
 window.location="<?php _e($url); ?>";
</script>	
<?php
	exit;
}



//for string opration
function _isthere($v,$f){
	$c=strstr($v,$f);
	if($c!=''){
		return true;
	}else{
		return false;
	}
}
function _add_one($a,$v){
	$c=strtolower($v);
	if(_isthere($c,strtolower($a))){
		return $v;
	}else{
		return $v." ".$a;
	}		
}

//month list function
function month_list($v=''){
	$s=1;
	$n='month';
	$id='month';
	$f='M';
	if(is_array($v)){
			if(isset($v['id'])){
				$id=$v['id'];
			}
			if(isset($v['name'])){
				$n=$v['name'];
			}
			if(isset($v['format'])){
				$tf=$v['format'];
			}
			if(isset($v['select'])){
				$s=$v['select'];
			}	
	}
	?>
	<select id="<?php _e($id);?>" name="<?php _e($n);?>" >
		<?php
			for($i=1;$i<=12;$i++){
				$CS='';
				if($i==$s){
					$CS= 'selected="selected"';
				}
			_e('<option value="'.$i.'" '.$CS.' >'.date($f,mktime(0, 0, 0, $i, 2, 98)).'</option>');	
			}		
		?>
	</select>
	<?php
}


function sql_insert_text($v){
	$v=htmlentities($v);
  	$v= str_replace("'","''",$v);
  	$v=str_replace("\\","\\\\",$v);
   	$v=str_replace("/\/","\\",$v);
   //$v=mysql_real_escape_string($v);
 return $v;
}


function encode($v){
 return	base64_encode(base64_encode($v));
}
function decode($v){
 return	base64_decode(base64_decode($v));
}

function array_encode($v){
	return encode(json_encode($v));
}

function array_decode($v){
	return json_decode(decode($v));
}


function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
//$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
//$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
//$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
//$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
 $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
 //$pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
} 


function base64_to_jpeg($base64_string, $output_file) {
    $ifp = fopen($output_file, "wb"); 

    $data = explode(',', $base64_string);

    fwrite($ifp, base64_decode($data[1])); 
    fclose($ifp); 

    return $output_file; 
}
?>