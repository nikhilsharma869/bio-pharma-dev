<?php 
include "configs/path.php";
session_start();
//CheckLogin();
include("country.php");


	  
$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>My RSS feed</title>';
$rssfeed .= '<link>http://www.mywebsite.com</link>';
$rssfeed .= '<description>This is an example RSS feed</description>';
$rssfeed .= '<language>en-us</language>';
$rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';

$sql="select * from ".$prev."projects where date2 <= ".mktime(0,0,0,date('m'),date('d'),date('Y'))." order by date2 desc LIMIT 0 , 20";


$result=mysql_query($sql);
while($row = mysql_fetch_array($result))
{
$rr=mysql_query("select * from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id]);

$txt="";
while($dd=@mysql_fetch_array($rr)):
  $txt.=$dd[cat_name] . " , ";
endwhile;
if($txt!=""){
$cats=substr($txt,0,-2);
}
else
{
  $cats="not defined";
}

$rssfeed .= '<item>';
$rssfeed .= '<title>' . $row['project'] . '</title>';
$rssfeed .= '<description>' . $row['description'] . '</description>';
$rssfeed .= '<link>'. $vpath. 'project-dtl.php?id='. $row['id'] . '</link>';
$rssfeed .= '<pubDate>' . date('l jS \of F Y h:i:s A',$row['date2']) . '</pubDate>';
$rssfeed .= '<category>' . $cats . '</category>';
$rssfeed .= '</item>';

}
$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;

$myFile = "rss.xml";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $rssfeed."\n";
fwrite($fh, $stringData);
fclose($fh);

redirect($vpath."rss.xml");
?>
