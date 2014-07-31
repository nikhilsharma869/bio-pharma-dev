<?php 
include "configs/path.php";
session_start();
CheckLogin();
include("country.php");



$user_lat = 33.603543;
$user_lon = -86.466833;
$distance= 10;
/*$sql = "SELECT *,
 
3956 * ASIN(SQRT( POWER(SIN(($user_lat -
abs( 
PostalCodes.Latitude)) * pi()/180 / 2),2) + COS($user_lat * pi()/180 ) * COS( 
abs
(PostalCodes.Latitude) *  pi()/180) * POWER(SIN(($user_lon - PostalCodes.Longitude) *  pi()/180 / 2), 2) ))
 
as distance FROM PostalCodes
HAVING distance < 10 
ORDER BY distance
";*/

$sql = "SELECT *,(((acos(sin((".$user_lat."*pi()/180)) *
sin((`Latitude`*pi()/180))+cos((".$user_lat."*pi()/180)) *
cos((`Latitude`*pi()/180)) * cos(((".$user_lon."- `Longitude`)
*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM
postalcodes HAVING distance <= 10 
ORDER BY distance";

echo $sql;
$result=mysql_query($sql);
while($row = mysql_fetch_array($result))
{
echo $row['City'].'<br>'.$row['County'].'<br>'.$row['distance']. ' Kms.';
echo '<pre>';
print_r($row);
echo '</pre>';

}

?>
