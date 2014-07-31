<?php 
$dot = "";
if( substr_count($_SERVER[PHP_SELF], "admin") ) 
{
    $dot = "../";
}

$currencytype = "US";
$currency = "" . "\$";
$spacer = "<table cellspacing=0 cellpadding=0 border=0 height=8><tr><td height=8><img width=1 height=1></td></tr></table>";
$month_ary["01"] = "Jan";
$month_ary["02"] = "Feb";
$month_ary["03"] = "Mar";
$month_ary["04"] = "Apr";
$month_ary["05"] = "May";
$month_ary["06"] = "Jun";
$month_ary["07"] = "Jul";
$month_ary["08"] = "Aug";
$month_ary["09"] = "Sep";
$month_ary["10"] = "Oct";
$month_ary["11"] = "Nov";
$month_ary["12"] = "Dec";
$month_ary2["January"] = "01";
$month_ary2["February"] = "02";
$month_ary2["March"] = "03";
$month_ary2["April"] = "04";
$month_ary2["May"] = "05";
$month_ary2["June"] = "06";
$month_ary2["July"] = "07";
$month_ary2["August"] = "08";
$month_ary2["September"] = "09";
$month_ary2["Octobar"] = "10";
$month_ary2["Noveber"] = "11";
$month_ary2["December"] = "12";
$r = mysql_query("select * from " . $prev . "stat");
$stat = @mysql_fetch_array($r);
$r = mysql_query("select * from " . $prev . "setup");
$setting = @mysql_fetch_array($r);
$r = mysql_query("select * from " . $prev . "contents");
while( $d = @mysql_fetch_array($r) ) 
{
    $contents_array[$d[cont_title]] = $d[contents];
}
$datetime = "[month]/[day]/[year] at [hours]:[minutes]:[seconds]";
mysql_query("update " . $prev . "projects set status='expired' where expires <=" . time() . " and status='open'");
$budget_array = array( "", "" . "Less than \$250", "" . "Between \$250 and \$500", "" . "Between \$500 and \$1,000", "" . "Between \$1,000 and \$2,500", "" . "Between \$2,500 and \$5,000", "" . "Between \$5,000 and \$10,000", "" . "Between \$10,000 and \$25,000", "" . "Over \$25,000", "Not Sure/Confidential" );
echo "\r\n";
function resize($img, $target, $type = "")
{
    $size = @GetImageSize($img);
    $width = $size[0];
    $height = $size[1];
    if( $target < $width && $target < $height || $target < $width ) 
    {
        $cent = 100 - round(($width - $target) / $width * 100);
        $width = round(($width * $cent) / 100);
        $height = round(($height * $cent) / 100);
    }
    else
    {
        if( $target < $height ) 
        {
            $cent = 100 - round(($height - $target) / $height * 100);
            $width = round(($width * $cent) / 100);
            $height = round(($height * $cent) / 100);
        }

    }

    if( $target < $width && $target < $height || $target < $width ) 
    {
        $cent = 100 - round(($width - $target) / $width * 100);
        $width = round(($width * $cent) / 100);
        $height = round(($height * $cent) / 100);
    }
    else
    {
        if( $target < $height ) 
        {
            $cent = 100 - round(($height - $target) / $height * 100);
            $width = round(($width * $cent) / 100);
            $height = round(($height * $cent) / 100);
        }

    }

    return "<img src='" . $img . "' width='" . $width . "' height='" . $height . "' border=0  " . $type . ">";
}

function redirect($link)
{
    echo "<script>window.location.href='" . $link . "';</script>";
}

function datedif($date2)
{
    $date1 = time();
    $e = explode("-", $date2);
    $date2 = mktime(0, 0, 0, $e[1], $e[2], $e[0]);
    $dateDiff = $date1 - $date2;
    $txt = "";
    $fullDays = floor($dateDiff / (60 * 60 * 24));
    if( $fullDays ) 
    {
        $txt .= $fullDays . " days ";
    }

    $fullHours = floor(($dateDiff - $fullDays * 60 * 60 * 24) / (60 * 60));
    if( $fullHours ) 
    {
        $txt .= $fullHours . " hours ";
    }

    $fullMinutes = floor(($dateDiff - $fullDays * 60 * 60 * 24 - $fullHours * 60 * 60) / 60);
    if( $fullMinutes ) 
    {
        $txt .= $fullMinutes . " minutes ";
    }

    $txt .= "ago from ";
    return $txt;
}

function chklogin($x = "", $referer = "")
{
    if( $_SESSION[user_id] < 1 ) 
    {
        echo "<script>window.location.href='" . $x . "sign.in.php" . $txt . "';</script>";
    }

}

function mysqldate($date)
{
    global $month_ary2;
    if( $date ) 
    {
        $e = explode(",", $date);
        $d = explode(" ", $e[0]);
        $month = $month_ary2[$d[0]];
        $day = $d[1];
        $f = explode(":", $date);
        $year = substr($e[1], 0, 4);
        $hour = substr($f[0], 0 - 2, 2);
        $minute = substr($f[1], 0, 2);
        $am = substr($f[1], 0 - 2, 2);
        if( $am == "PM" ) 
        {
            $hour = $hour + 12;
        }

        if( $year && $month && $day ) 
        {
            return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":00";
        }

    }

}

function mysqldate_show($date)
{
    if( $date ) 
    {
        $e = @explode("-", $date);
        $time = @explode(":", @substr($e[2], 2));
        $day = @substr($e[2], 0, 2);
        if( $e[1] && $day && $e[0] ) 
        {
            return date("F d,Y g:i A", mktime($time[0], $time[1], $time[2], $e[1], $day, $e[0]));
        }

    }

}

function showdate($date)
{
    global $month_ary;
    if( $date ) 
    {
        $e = explode("-", $date);
        return $month_ary[$e[1]] . " " . $e[2] . "," . $e[0];
    }

}

function sqldate($date)
{
    if( $date ) 
    {
        $e = explode("/", $date);
        return $e[2] . "-" . $e[1] . "-" . $e[0];
    }

}

function paging($total, $perpage = 10, $param = "", $class = "lnk")
{
    $limit = $_GET["limit"];
    $page = ceil($total / $perpage);
    $start = 1;
    $end = 10;
    $t = $limit % 10;
    if( $t ) 
    {
        $start = $limit - $t + 1;
    }
    else
    {
        if( 10 < $limit ) 
        {
            $start = $limit - 9;
        }

    }

    $end = $start + 9;
    if( $page < $end ) 
    {
        $end = $page;
    }

    $data = "";
    if( 1 < $limit && $start != 1 ) 
    {
        $data .= "<a href='" . $_SERVER["PHP_SELF"] . "?limit=" . ($start - 1) . $param . "' class=" . $class . "> &laquo;Prev.</a> ";
    }

    for( $i = $start; $i <= $end; $i++ ) 
    {
        if( $limit == $i ) 
        {
            $data .= "<a href='" . $_SERVER["PHP_SELF"] . "?limit=" . $i . $param . "' class=" . $class . "><b>[" . $i . "]</b></a> ";
        }
        else
        {
            $data .= "<a href='" . $_SERVER["PHP_SELF"] . "?limit=" . $i . $param . "' class=" . $class . ">" . $i . "</a> ";
        }

    }
    if( $i < $page ) 
    {
        $data .= "<a href='" . $_SERVER["PHP_SELF"] . "?limit=" . $i . $param . "' class=" . $class . "> &raquo; </a>";
    }

    return "Pages :&nbsp;" . $data;
}

function genDate($time)
{
    global $datetime;
    $datetime2 = $datetime;
    $datetime2 = str_replace("[year]", date("y", $time), $datetime2);
    $datetime2 = str_replace("[month]", date("m", $time), $datetime2);
    $datetime2 = str_replace("[day]", date("d", $time), $datetime2);
    $datetime2 = str_replace("[hours]", date("H", $time), $datetime2);
    $datetime2 = str_replace("[12hours]", date("h", $time), $datetime2);
    $datetime2 = str_replace("[minutes]", date("i", $time), $datetime2);
    $datetime2 = str_replace("[seconds]", date("s", $time), $datetime2);
    $datetime2 = str_replace("[ampm]", date("s", $time), $datetime2);
    $datetime2 = str_replace("[timezone]", date("T", $time), $datetime2);
    return $datetime2;
}

function getusername($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select * from " . $prev . "user where user_id=" . $id);
    $d = @mysql_fetch_array($r);
    return $d[username];
}

function getemail($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select * from " . $prev . "user where user_id=" . $id);
    $d = mysql_fetch_array($r);
    return $d[email];
}

function getusertype($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select * from " . $prev . "user where user_id=" . $id);
    $d = mysql_fetch_array($r);
    return $d[type];
}

function getuserid($viewprofile)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select * from " . $prev . "user where username='" . $viewprofile . "'");
    $d = mysql_fetch_array($r);
    return $d[user_id];
}

function getproject($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select * from " . $prev . "projects where id=" . $id);
    $d = @mysql_fetch_array($r);
    return $d[project];
}

function getbuyer($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select * from " . $prev . "projects where id=" . $id);
    $d = mysql_fetch_array($r);
    return $d[user_id];
}

function getcategory($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select * from " . $prev . "categories where cat_id=" . $id);
    $d = mysql_fetch_array($r);
    return $d[cat_name];
}

function totalbid($id)
{
    global $dbh;
    global $prev;
    $result2 = mysql_query("SELECT * FROM " . $prev . "bids WHERE id='" . $id . "' ");
    return mysql_num_rows($result2);
}

function avaragebid($id)
{
    global $dbh;
    global $prev;
    $result2 = mysql_query("SELECT AVG(amount) as avarage FROM " . $prev . "bids WHERE id='" . $id . "' AND status='open'");
    return mysql_result($result2, 0, "avarage");
}

function total_messages($id)
{
    global $dbh;
    global $prev;
    return @mysql_num_rows(@mysql_query("SELECT * FROM  " . $prev . "forum WHERE pid='" . $id . "'"));
}

function getspacial($id)
{
    global $dbh;
    global $prev;
    $d = @mysql_fetch_array(@mysql_query("SELECT * FROM  " . $prev . "user WHERE user_id='" . $id . "'"));
    return $d[special];
}

function getspacial_project($id)
{
    global $dbh;
    global $prev;
    $d = @mysql_fetch_array(@mysql_query("SELECT * FROM  " . $prev . "projects WHERE user_id='" . $id . "'"));
    return $d[special];
}

function roundit($number, $decimals)
{
    return sprintf("%01." . $decimals . "f", $number);
}


