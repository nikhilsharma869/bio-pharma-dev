<?php 
$admin_folder = "admin_new";
if( substr_count($_SERVER["PHP_SELF"], $admin_folder) || substr_count($_SERVER["PHP_SELF"], "admincp") ) 
{
    include_once("../configs/config.php");
}
else
{
    if( substr_count($_SERVER["PHP_SELF"], $admin_folder) ) 
    {
        include_once("../configs/config.php");
    }
    else
    {
        include_once("configs/config.php");
        if( $_REQUEST["SBMT_LANG"] == 1 ) 
        {
            $_SESSION[lang_id] = $_POST[lang_id];
        }

        if( 0 < (int) $_SESSION[lang_id] ) 
        {
            $lang_file = mysql_fetch_array(mysql_query("select * from  " . $prev . "language where lang_id='" . $_SESSION[lang_id] . "'"));
            $_SESSION["lang_code"] = $lang_file["short_code"];
            $ln = $lang_file["short_code"];
            include("lang/" . $lang_file["short_code"] . ".inc.php");
        }
        else
        {
            $ln = "en";
            $_SESSION[lang_id] = 0;
            $_SESSION["lang_code"] = $ln;
            include("lang/en.inc.php");
        }

        if( 0 < (int) $_SESSION["user_id"] ) 
        {
            setUserLastLang($_SESSION["user_id"], $_SESSION["lang_code"]);
        }

        $rsu = mysql_query("SELECT maintenance_status FROM " . $prev . "setting LIMIT 1");
        $undermain = @mysql_fetch_array($rsu);
        if( $undermain[maintenance_status] == 1 ) 
        {
            header("location:" . $vpath . "maintain.html");
            exit();
        }

    }

}

$paypal_settings = @mysql_fetch_array(@mysql_query("select * from " . $prev . "paypal_settings"));
$curn = $paypal_settings[silver_member_currency];
$curncode = array( "EUR", "USD" );
mysql_query("update " . $prev . "projects set status='expired' where expires <=" . time() . " and status='open'");
$budget_array = array( "", "Less than " . $curn . "250", "Between " . $curn . "250 and " . $curn . "500", "Between " . $curn . "500 and " . $curn . "1,000", "Between " . $curn . "1,000 and " . $curn . "2,500", "Between " . $curn . "2,500 and " . $curn . "5,000", "Between " . $curn . "5,000 and " . $curn . "10,000", "Between " . $curn . "10,000 and " . $curn . "25,000", "Over " . $curn . "25,000", "Not Sure/Confidential" );
$budget_array1 = array( "", "BUDGET_SL2", "BUDGET_SL3", "BUDGET_SL4", "BUDGET_SL5", "BUDGET_SL6", "BUDGET_SL7", "BUDGET_SL8", "BUDGET_SL9", "BUDGET_SL10" , "BUDGET_SL11" );
$budget_array2 = array( "", "Less than " . $curn . "250", "" . $curn . "250 - " . $curn . "500", "" . $curn . "500 - " . $curn . "1,000", "" . $curn . "1,000 - " . $curn . "2,500", "" . $curn . "2,500 - " . $curn . "5,000", "" . $curn . "5,000 - " . $curn . "10,000", "" . $curn . "10,000 - " . $curn . "25,000", "Over " . $curn . "25,000", "Not Sure/Confidential" );
$rs = mysql_query("SELECT * FROM " . $prev . "setup LIMIT 1");
$setting = @mysql_fetch_array($rs);
$spacer = "<table cellspacing='0' cellpadding='0' border='0' align='center'><tr><td height='6'><img width='1' height='1' src='images/spacer.gif' alt='Spacer'></td></tr></table>";
$month_ary = array(  );
$month_ary["1"] = "January";
$month_ary["2"] = "February";
$month_ary["3"] = "March";
$month_ary["4"] = "April";
$month_ary["5"] = "May";
$month_ary["6"] = "June";
$month_ary["7"] = "July";
$month_ary["8"] = "August";
$month_ary["9"] = "September";
$month_ary["10"] = "October";
$month_ary["11"] = "November";
$month_ary["12"] = "December";
$month_ary2["01"] = "January";
$month_ary2["02"] = "February";
$month_ary2["03"] = "March";
$month_ary2["04"] = "April";
$month_ary2["05"] = "May";
$month_ary2["06"] = "June";
$month_ary2["07"] = "July";
$month_ary2["08"] = "August";
$month_ary2["09"] = "September";
$month_ary2["10"] = "October";
$month_ary2["11"] = "November";
$month_ary2["12"] = "December";
$month_ary3["January"] = "01";
$month_ary3["February"] = "02";
$month_ary3["March"] = "03";
$month_ary3["April"] = "04";
$month_ary3["May"] = "05";
$month_ary3["June"] = "06";
$month_ary3["July"] = "07";
$month_ary3["August"] = "08";
$month_ary3["September"] = "09";
$month_ary3["October"] = "10";
$month_ary3["November"] = "11";
$month_ary3["December"] = "12";
if( substr_count(basename($_SERVER["REQUEST_URI"], ".php"), "jobs") || substr_count(basename($_SERVER["REQUEST_URI"], ".php"), "Jobs") ) 
{
    $pageurl = $vpath . "projects/" . basename($_SERVER["REQUEST_URI"], ".php");
}
else
{
    $pageurl = $vpath . basename($_SERVER["REQUEST_URI"], ".php");
}

if( !basename($_SERVER["REQUEST_URI"], ".php") ) 
{
    $pageurl = $vpath;
}

if( $_REQUEST[id] && $ln != "" && $pg != "faq" ) 
{
    $result = mysql_query("SELECT * FROM  " . $prev . "projects WHERE id='" . $_REQUEST[id] . "'");
    $d = mysql_fetch_array($result);
    $site_title = $d["project"];
    $rr = mysql_query("select * from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $d[id]);
    $txt = "";
    while( $dd = @mysql_fetch_array($rr) ) 
    {
        $txt .= $dd[cat_name] . " , ";
    }
    if( $txt != "" ) 
    {
        $site_keys = substr($txt, 0, 0 - 2);
    }
    else
    {
        $site_keys = $ds["meta_keys"];
    }

    $site_desc = $d[description];
}
else
{
    if( $_REQUEST["username"] ) 
    {
        $query = "select * from " . $prev . "user where username = '" . $_REQUEST["username"] . "'";
        $d = @mysql_fetch_array(@mysql_query($query));
        $site_title = "User Profile " . $d["fname"] . " " . $d["lname"];
    }
    else
    {
        if( $pagetype == "cms" ) 
        {
            $sql = "select * from " . $prev . "contents where id = '" . $_REQUEST["cms_id"] . "'";
            $cms = @mysql_fetch_array(@mysql_query($sql));
            $site_title = $cms["site_title"];
            $site_keys = $cms["meta_keys"];
            $site_desc = $cms["meta_desc"];
        }
        else
        {
            $site_title = $setting["site_title"];
            $site_keys = $setting["meta_keys"];
            $site_desc = $setting["meta_desc"];
        }

    }

}

function Getunique_userID()
{
    $sid = session_id();
    $user_id = md5($sid);
    if( empty($_COOKIE["temp_user_id"]) ) 
    {
        setcookie("temp_user_id", $user_id, time() + 172800);
    }

    return $_COOKIE["temp_user_id"];
}

function txt_value($x)
{
    $x2 = mysql_real_escape_string(addslashes(strip_tags($x)));
    return $x2;
}

function txt_value_output($x)
{
    $x2 = stripslashes(stripslashes(strip_tags($x)));
    return $x2;
}

function html_value($x)
{
    $x2 = mysql_real_escape_string(htmlentities(addslashes($x)));
    return $x2;
}

function html_value_output($x)
{
    $x2 = stripslashes(stripslashes(html_entity_decode($x, ENT_QUOTES, "UTF-8")));
    return $x2;
}

function copyright($x)
{
    global $vpath;
    global $dotcom;
    if( $x == "admin_header" ) 
    {
        echo "<a href=\"" . $vpath . "\" target=\"_blank\" title=\"" . $dotcom . "\"><img src=\"../images/logo.png\" alt=\"" . $dotcom . "\" border=\"0\" width=200></a>";
    }
    else
    {
        if( $x == "admin_footer" ) 
        {
            echo "Powered By <a href='http://www.scriptgiant.com/' target='_blank' class='lnk' title='Scriptgiant.com'>Scriptgiant.com</a>";
        }

    }

}

function time_to_sec($time)
{
    $hours = substr($time, 0, 0 - 6);
    $minutes = substr($time, 0 - 5, 2);
    $seconds = substr($time, 0 - 2);
    return $hours * 3600 + $minutes * 60 + $seconds;
}

function genDate($time, $datetime2 = "[month]/[day]/[year] at [hours]:[minutes]:[seconds]")
{
    $datetime2 = str_replace("[year]", date("Y", $time), $datetime2);
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

function CheckLogin($return_url = "")
{
    global $vpath;
    if( empty($_SESSION["user_id"]) || !isset($_SESSION["user_id"]) ) 
    {
        if( $return_url ) 
        {
            redirect($vpath . "login.php?referer=" . $return_url);
            return NULL;
        }

        redirect($vpath . "login.php");
    }

}

function CheckLogindecode($return_url = "")
{
    global $vpath;
    if( empty($_SESSION["user_id"]) || !isset($_SESSION["user_id"]) ) 
    {
        if( $return_url ) 
        {
            redirect($vpath . "login/" . $return_url);
            return NULL;
        }

        redirect($vpath . "login.html");
    }

}

function redirect($x)
{
    header("Location: " . $x);
    exit();
}

function redir($tourl)
{
    echo "\r\n    <script>\r\n        window.location = '";
    echo $tourl;
    echo "';\r\n    </script>\r\n    ";
}

function banner($size, $location = "")
{
    global $db;
    global $prev;
    global $vpath;
    if( $location == "header" ) 
    {
        $location = "header='Y'";
    }
    else
    {
        if( $location == "footer" ) 
        {
            $location = "footer='Y'";
        }
        else
        {
            if( $location == "body_header" ) 
            {
                $location = "body_header='Y'";
            }
            else
            {
                if( $location == "body_footer" ) 
                {
                    $location = "body_footer='Y'";
                }

            }

        }

    }

    if( $location ) 
    {
        $location2 = " and " . $location;
        $banner_query = @mysql_query("select * from " . $prev . "adsense where size='" . $size . "' and status='Y' " . $location2 . " order by rand() limit 2");
    }
    else
    {
        $banner_query = @mysql_query("select * from " . $prev . "adsense where status='Y'  order by rand() limit 1");
    }

    $d = @mysql_fetch_array($banner_query);
    $e = explode("x", $d[size]);
    $width = $e[0];
    $height = $e[1];
    if( $d[type] == 1 ) 
    {
        $dx = str_replace("&", "&amp;", str_replace("IMG", "img", html_entity_decode($d[adsense])));
        $dx = str_replace("000000", "E7DEBD", $dx);
        if( $height != 240 ) 
        {
            $dx = str_replace("text_image", "image", $dx);
        }

        $dx = str_replace("F0F0F0", "E7DEBD", $dx);
        echo $dx;
    }
    else
    {
        if( $d[type] == 2 ) 
        {
            if( $d[image_type] == "N" ) 
            {
                echo "\t\t\r\n\r\n            <a href=\"";
                echo $d[link];
                echo "\" target='_blank' title=\"";
                echo $d[link];
                echo "\"><img src=\"";
                echo $vpath;
                echo $d[banner];
                echo "\" width=\"";
                echo $width;
                echo "\" height=\"";
                echo $height;
                echo "\" border='0' alt=\"";
                echo $d[link];
                echo "\" /></a>\r\n\r\n            ";
                return NULL;
            }

            if( $d[image_type] == "F" ) 
            {
                echo "\r\n            <!-- \r\n\r\n            <object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\" width=\"";
                echo $width;
                echo "\" height=\"";
                echo $height;
                echo "\" name=\"";
                echo $d[banner];
                echo "\">\r\n\r\n            <param name=\"movie\" value=\"";
                echo $vpath;
                echo $d[banner];
                echo "\">\r\n\r\n            <param name=\"Play\" value=\"-1\">\r\n\r\n            <param name=\"Loop\" value=\"-1\">\r\n\r\n            <param name=\"quality\" value=\"high\">\r\n\r\n            <param name=\"SCALE\" value=\"noborder\">\r\n\r\n            <EMBED src=\"";
                echo $vpath;
                echo $d[banner];
                echo "\" quality=\"high\" width=\"";
                echo $width;
                echo "\" height=\"";
                echo $height;
                echo "\" name=\"";
                echo $d[banner];
                echo "\" ALIGN=\"\" TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/go/getflashplayer\"></EMBED>\r\n\r\n            </object>-->\r\n\r\n\r\n\r\n            <noscript>\r\n\r\n            <object data=\"flash/20060223-FlashAd\" type=\"application/x-shockwave-flash\"\theight=\"";
                echo $height;
                echo "\" width=\"";
                echo $width;
                echo "\"> \r\n\r\n                <param name=\"Movie\" value=\"";
                echo $vpath;
                echo $d[banner];
                echo "\" /> \r\n\r\n                <param name=\"Base\" value=\"\" /> \r\n\r\n                <param name=\"quality\" value=\"best\" /> \r\n\r\n                <param name=\"play\" value=\"true\" /> \r\n\r\n                <param name=\"loop\" value=\"true\" /> \r\n\r\n                <param name=\"SAlign\" value=\"\" /> \r\n\r\n                <param name=\"AllowScriptAccess\" value=\"always\" /> \r\n\r\n                <param name=\"Scale\" value=\"ShowAll\" /> \r\n\r\n                <param name=\"SeamlessTabbing\" value=\"1\" /> \r\n\r\n            </object> \r\n\r\n            </noscript> \r\n\r\n            <script language=\"JavaScript\" type=\"text/javascript\">\r\n\r\n                AC_RunFlContentX(\"width\", \"";
                echo $width;
                echo "\", \"height\", \"";
                echo $height;
                echo "\", \"movie\", \"";
                echo $vpath;
                echo $d[banner];
                echo "\", \"quality\", \"autolow\", \"play\", \"true\", \"loop\", \"false\");\r\n\r\n            </script>\r\n\r\n            ";
            }

        }

    }

}

function resize($img, $target, $type = "")
{
    $size = GetImageSize($img);
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

    echo "<img src='" . $img . "' width='" . $width . "' height='" . $height . "' border=0  " . $type . ">";
}

function getcontent_title($x)
{
    global $db;
    global $dbh;
    global $prev;
    global $language_pack;
    $r2 = mysql_query("select contents from " . $prev . "contents where status='Y' and  cont_title='" . txt_value($x) . "'");
    $d = @mysql_fetch_array($r2);
    if( 1 < strlen($d[contents]) ) 
    {
        echo html_value_output($d["contents"]);
    }
    else
    {
        echo "<h1 align='center'><br /><br />Coming soon</h1>";
    }

}

function mysqldate($date)
{
    global $month_ary3;
    if( $date ) 
    {
        $e = explode(",", $date);
        $d = explode(" ", $e[0]);
        $month = $month_ary3[$d[0]];
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
            return date("M d,Y", mktime($time[0], $time[1], $time[2], $e[1], $day, $e[0]));
        }

    }

}

function showdate($date)
{
    global $month_ary2;
    if( $date ) 
    {
        $e = explode("-", $date);
        return $month_ary2[$e[1]] . " " . $e[2] . "," . $e[0];
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

function paging2($rowsPerPage, $numrows, $pageNum = 1, $param = "")
{
    global $db;
    $maxPage = ceil($numrows / $rowsPerPage);
    $self = str_replace(".php", ".html", $_SERVER["PHP_SELF"]);
    if( $param ) 
    {
        $slef = $self . $param;
    }

    if( 1 < $pageNum ) 
    {
        $page = $pageNum - 1;
        $prev = " <a href=\"" . $self . "?page=" . $page . str_replace("page", "x", $param) . "\" class=lnk><font color=#111111>[Prev]</font></a> ";
        $first = " <a href=\"" . $self . "?page=1" . str_replace("page", "x", $param) . "\" class=lnk><font color=#111111>[First Page]</font></a> ";
    }
    else
    {
        $prev = "";
        $first = "";
    }

    if( $pageNum < $maxPage ) 
    {
        $page = $pageNum + 1;
        $next = " <a href=\"" . $self . "?page=" . $page . str_replace("page", "x", $param) . "\" class=lnk><font color=#111111>[Next]</font></a> ";
        $last = " <a href=\"" . $self . "?page=" . $maxPage . str_replace("page", "x", $param) . "\" class=lnk><font color=#111111>[Last Page]</a> ";
    }
    else
    {
        $next = "  ";
        $last = "  ";
    }

    return $first . " " . $prev . " Showing page <b>" . $pageNum . "</b> of <b>" . $maxPage . "</b> pages   " . $next . " " . $last;
}

function paging($total, $perpage = 20, $param = "", $class = "lnk", $limitp = "limit")
{
    global $vpath;
    $limit = $_REQUEST["limit"];
    if( !$limit ) 
    {
        $limit = 1;
    }

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
    if( substr_count($_SERVER[REQUEST_URI], "admin_new") ) 
    {
        if( 1 < $limit && $start != 1 ) 
        {
            $data .= "<a href='" . $_SERVER["PHP_SELF"] . "&limit=" . ($start - 1) . $param . "' class=" . $class . "> &laquo;~Prev.</a>";
        }

        for( $i = $start; $i <= $end; $i++ ) 
        {
            if( $limit == $i ) 
            {
                $data .= "<a href='" . $_SERVER["PHP_SELF"] . "?limit=" . $i . $param . "' class=" . $class . "><b>[" . $i . "]</b></a> | ";
            }
            else
            {
                $data .= "<a href='" . $_SERVER["PHP_SELF"] . "?limit=" . $i . $param . "' class=" . $class . ">" . $i . "</a> | ";
            }

        }
        if( $i < $page ) 
        {
            $data .= "<a href='" . $_SERVER["PHP_SELF"] . "?limit=" . $i . $param . "' class=" . $class . "> Next~&raquo; </a>";
        }

    }
    else
    {
        if( 1 < $limit && $start != 1 ) 
        {
            $data .= "<a href='" . $vpath . $_REQUEST["mode"] . "/?" . $limitp . "=" . ($start - 1) . "" . $param . "' class='" . $class . "'> &laquo;~Prev.</a>";
        }

        for( $i = $start; $i <= $end; $i++ ) 
        {
            if( $limit == $i ) 
            {
                $data .= "<a href='" . $vpath . $_REQUEST["mode"] . "/?" . $limitp . "=" . $i . "" . $param . "' class='current-page'><b>" . $i . "</b></a>  ";
            }
            else
            {
                $data .= "<a href='" . $vpath . $_REQUEST["mode"] . "/?" . $limitp . "=" . $i . "" . $param . "' class='" . $class . "'>" . $i . "</a>  ";
            }

        }
        if( $i < $page ) 
        {
            $data .= "<a href='" . $vpath . $_REQUEST["mode"] . "/?" . $limitp . "=" . $i . "" . $param . "' class='" . $class . "'> Next~&raquo; </a>";
        }

    }

    if( $perpage < $total ) 
    {
        return "<b>Pages :</b> " . $data;
    }

}

function encrypter($string, $key)
{
    $result = "";
    for( $i = 0; $i < strlen($string); $i++ ) 
    {
        $char = substr($string, $i, 1);
        $keychar = substr($key, $i % strlen($key) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result .= $char;
    }
    return base64_encode($result);
}

function decrypter($string, $key)
{
    $result = "";
    $string = base64_decode($string);
    for( $i = 0; $i < strlen($string); $i++ ) 
    {
        $char = substr($string, $i, 1);
        $keychar = substr($key, $i % strlen($key) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result .= $char;
    }
    return $result;
}

function pageRedirect($target, $type = "location", $time = "")
{
    if( $type == "location" ) 
    {
        header("Location: " . $target);
        exit();
    }

    if( $type == "refresh" ) 
    {
        header("Refresh: " . $time . "; url=" . $target);
        exit();
    }

}

function genMailing($to, $subj, $body, $from = "", $reply = true, $mail_type)
{
    global $setting;
    global $dotcom;
    global $prev;
    if( isset($mail_type) ) 
    {
        $row_mail_type = mysql_fetch_array(mysql_query("select * from " . $prev . "mailsetup where mail_type = '" . $mail_type . "'"));
        $body = html_entity_decode($row_mail_type[header]) . $body . html_entity_decode($row_mail_type[footer]);
    }

    if( $from == "" ) 
    {
        $from = stripslashes($setting["admin_mail"]);
    }

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "" . "From: " . $dotcom . " <" . $from . ">\r\n";
    if( $reply ) 
    {
        if( $reply == "" ) 
        {
            $headers .= "" . "Reply-to: " . $dotcom . " <" . stripslashes($setting["admin_mail"]) . ">\r\n";
        }
        else
        {
            $headers .= "" . "Reply-to: " . $dotcom . " <" . stripslashes($reply) . ">\r\n";
        }

    }

    $body1 = str_replace("{first_name}", $_REQUEST["firstname"], $body);
    $body1 = str_replace("{last_name}", $_REQUEST["lastname"], $body1);
    $return_str = mail($to, $subj, $body1, $headers);
    return $return_str;
}

function dateModifier($db_date, $format = "d/m/Y [H:i:s]")
{
    $datetime = new DateTime($db_date);
    if( !$datetime ) 
    {
        return "unknown_date_value";
    }

    $explode_db_date = explode(" ", $db_date);
    if( count($explode_db_date) == 1 ) 
    {
        $explode_format = explode(" [", $format);
        $format = $explode_format[0];
    }

    return $datetime->format($format);
}

function new_pagingnew($adjacents, $targetpage, $param, $limit = 2, $page = 0, $total_pages, $table_id = "", $tbl_name = "")
{
    $tbl_name = $tbl_name;
    $adjacents = $adjacents;
    $total_pages = $total_pages;
    $targetpage = $targetpage;
    $limit = $limit;
    $page = $_REQUEST["page"];
    if( $page ) 
    {
        $start = ($page - 1) * $limit;
    }
    else
    {
        $start = 0;
    }

    if( $page == 0 ) 
    {
        $page = 1;
    }

    $prev = $page - 1;
    $next = $page + 1;
    $lastpage = ceil($total_pages / $limit);
    $lpm1 = $lastpage - 1;
    $pagination = "";
    if( 1 < $lastpage ) 
    {
        $pagination .= "<div class=\"pagination\"><ul>";
        if( 1 < $page ) 
        {
            $pagination .= "<li><a href=\"" . $targetpage . "" . $prev . $param . "\">&#171; Previous</a></li>";
        }
        else
        {
            $pagination .= "<li class=\"disabled\">&#171; Previous</li>";
        }

        if( $lastpage < 7 + $adjacents * 2 ) 
        {
            for( $counter = 1; $counter <= $lastpage; $counter++ ) 
            {
                if( $counter == $page ) 
                {
                    $pagination .= "" . "<li ><a class=\"active\">" . $counter . "</a></li>";
                }
                else
                {
                    $pagination .= "<li><a href=\"" . $targetpage . "" . $counter . $param . "\">" . $counter . "</a></li>";
                }

            }
        }
        else
        {
            if( 5 + $adjacents * 2 < $lastpage ) 
            {
                if( $page < 1 + $adjacents * 2 ) 
                {
                    for( $counter = 1; $counter < 4 + $adjacents * 2; $counter++ ) 
                    {
                        if( $counter == $page ) 
                        {
                            $pagination .= "" . "<li ><a class=\"active\">" . $counter . "</a></li>";
                        }
                        else
                        {
                            $pagination .= "<li><a href=\"" . $targetpage . "" . $counter . $param . "\">" . $counter . "</a></li>";
                        }

                    }
                    $pagination .= "<li>...</li>";
                    $pagination .= "<li><a href=\"" . $targetpage . "" . $lpm1 . $param . "\">" . $lpm1 . "</a></li>";
                    $pagination .= "<li><a href=\"" . $targetpage . "" . $lastpage . $param . "\">" . $lastpage . "</a></li>";
                }
                else
                {
                    if( $page < $lastpage - $adjacents * 2 && $adjacents * 2 < $page ) 
                    {
                        $pagination .= "<li><a href=\"" . $targetpage . "" . "1" . $param . "\">1</a></li>";
                        $pagination .= "<li><a href=\"" . $targetpage . "" . "2" . $param . "\">2</a></li>";
                        $pagination .= "<li>...</li>";
                        for( $counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++ ) 
                        {
                            if( $counter == $page ) 
                            {
                                $pagination .= "" . "<li><a class=\"active\">" . $counter . "</a></li>";
                            }
                            else
                            {
                                $pagination .= "<li><a href=\"" . $targetpage . "" . $counter . $param . "\">" . $counter . "</a></li>";
                            }

                        }
                        $pagination .= "<li>...</li>";
                        $pagination .= "<li><a href=\"" . $targetpage . "" . $lpm1 . "\">" . $lpm1 . "</a></li>";
                        $pagination .= "<li><a href=\"" . $targetpage . "" . $lastpage . "\">" . $lastpage . "</a></li>";
                    }
                    else
                    {
                        $pagination .= "<li><a href=\"" . $targetpage . "" . "1" . $param . "\">1</a></li>";
                        $pagination .= "<li><a href=\"" . $targetpage . "" . "2" . $param . "\">2</a></li>";
                        $pagination .= "<li>...</li>";
                        for( $counter = $lastpage - (2 + $adjacents * 2); $counter <= $lastpage; $counter++ ) 
                        {
                            if( $counter == $page ) 
                            {
                                $pagination .= "" . "<li ><a class=\"active\">" . $counter . "</a></li>";
                            }
                            else
                            {
                                $pagination .= "<li><a href=\"" . $targetpage . "" . $counter . $param . "\">" . $counter . "</a></li>";
                            }

                        }
                    }

                }

            }

        }

        if( $page < $counter - 1 ) 
        {
            $pagination .= "<li><a href=\"" . $targetpage . "" . $next . $param . "\">Next &#187;</a></li>";
        }
        else
        {
            $pagination .= "<li class=\"disabled\">Next &#187;</li>";
        }

        $pagination .= "</div></ul>\n";
    }

    return $pagination;
}

function MoneyFormat($number, $type = "USD")
{
    return "" . "\$ " . number_format($number, 2, ".", ",");
}

function get_domain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces["host"]) ? $pieces["host"] : "";
    if( preg_match("/(?P<domain>[a-z0-9][a-z0-9\\-]{1,63}\\.[a-z\\.]{2,6})\$/i", $domain, $regs) ) 
    {
        return $regs["domain"];
    }

    return false;
}

function getusername($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select username from " . $prev . "user where user_id=" . txt_value($id));
    $d = @mysql_fetch_array($r);
    return txt_value_output($d["username"]);
}

function getfullname($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select * from " . $prev . "user where user_id=" . txt_value($id));
    $d = @mysql_fetch_array($r);
    if( $d["fname"] != "" ) 
    {
        return txt_value_output($d["fname"] . " " . $d["lname"]);
    }

    return txt_value_output($d["username"]);
}

function getemail($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select email from " . $prev . "user where user_id=" . txt_value($id));
    $d = mysql_fetch_array($r);
    return txt_value_output($d["email"]);
}

function getusertype($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select type from " . $prev . "user where user_id=" . txt_value($id));
    $d = mysql_fetch_array($r);
    return txt_value_output($d["type"]);
}

function getuserid($viewprofile)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select user_id from " . $prev . "user where username='" . txt_value($viewprofile) . "'");
    $d = mysql_fetch_array($r);
    return txt_value_output($d["user_id"]);
}

function getproject($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select project from " . $prev . "projects where id=" . txt_value($id));
    $d = @mysql_fetch_array($r);
    return txt_value_output($d["project"]);
}

function getbuyer($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select user_id from " . $prev . "projects where id=" . txt_value($id));
    $d = mysql_fetch_array($r);
    return txt_value_output($d["user_id"]);
}

function getcategory($id)
{
    global $dbh;
    global $prev;
    $r = mysql_query("select cat_name from " . $prev . "categories where cat_id=" . txt_value($id));
    $d = mysql_fetch_array($r);
    return txt_value_output($d["cat_name"]);
}

function totalbid($id)
{
    global $dbh;
    global $prev;
    $result2 = mysql_query("SELECT id FROM " . $prev . "buyer_bids WHERE project_id='" . txt_value($id) . "' ");
    return mysql_num_rows($result2);
}

function avaragebid($id)
{
    global $dbh;
    global $prev;
    $result2 = mysql_fetch_assoc(mysql_query("SELECT AVG(emp_charge) as avarage FROM " . $prev . "buyer_bids WHERE project_id='" . txt_value($id) . "' AND chose!='C'"));
    return number_format($result2["avarage"]);
}

function total_messages($id)
{
    global $dbh;
    global $prev;
    return @mysql_num_rows(@mysql_query("SELECT pid FROM  " . $prev . "forum WHERE pid='" . @txt_value($id) . "'"));
}

function getspacial($id)
{
    global $dbh;
    global $prev;
    $d = @mysql_fetch_array(@mysql_query("SELECT special FROM  " . $prev . "user WHERE user_id='" . @txt_value($id) . "'"));
    return txt_value_output($d["special"]);
}

function getspacial_project($id)
{
    global $dbh;
    global $prev;
    $d = @mysql_fetch_array(@mysql_query("SELECT special FROM  " . $prev . "projects WHERE user_id='" . @txt_value($id) . "'"));
    return txt_value_output($d["special"]);
}

function roundit($number, $decimals)
{
    return sprintf("%01." . $decimals . "f", $number);
}

function DateTimeDiff($date2)
{
    $date1 = time();
    $txt = "";
    $e2 = explode(" ", $date2);
    $e = explode("-", $e2[0]);
    $date2 = mktime(0, 0, 0, $e[1], $e[2], $e[0]);
    $dateDiff = $date2 - $date1;
    $fullDays = floor($dateDiff / (60 * 60 * 24));
    if( $fullDays ) 
    {
        $txt .= $fullDays . " days ";
    }

    return $txt;
}

function adminRowColor($rowNum)
{
    if( $rowNum % 2 ) 
    {
        return "#FFFFFF";
    }

    return "";
}

function replacename($name)
{
    return str_replace(" ", "-", str_replace("&", "-", str_replace("/", "-", $name)));
}

function updateautomenbership()
{
    global $prev;
    $menbershipcheck = mysql_query("select user_id from " . $prev . "user where auto_update_member='Y' and date(gold_member_expire) <date(now())");
    while( $ashch = @mysql_fetch_assoc($menbershipcheck) ) 
    {
        $rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $ashch[user_id] . "' and status = 'Y' and amttype='CR'"));
        $rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $ashch[user_id] . "' and status = 'Y' and amttype='DR'"));
        $balsum = number_format($rwbal["balsum1"] - $rwbal2["baldeb"], 2);
        $r1 = mysql_query("select price from " . $prev . "membership where id=2 ");
        $data1 = @mysql_fetch_array($r1);
        $new_balance = $balsum - $data1["price"];
        $cur_time = time();
        if( 0 <= $new_balance ) 
        {
            $query = "insert into " . $prev . "transactions set amount=" . $data1["price"] . ",details='Gold Member',user_id='" . $ashch[user_id] . "', balance=" . $data1["price"] . ", add_date=now(), date2=" . $cur_time . ", paypaltran_id='0', status='Y', amttype='DR'";
            $update_query = mysql_query("update " . $prev . "user set gold_member='Y',member_date=now(),gold_member_expire=(DATE_ADD(now(), INTERVAL 1 MONTH)), auto_update_member='Y' where user_id='" . $ashch[user_id] . "'");
        }
        else
        {
            $update_query = mysql_query("update " . $prev . "user set gold_member='N',member_date=now(),gold_member_expire=(DATE_ADD(now(), INTERVAL 1 MONTH)), auto_update_member='N' where user_id='" . $ashch[user_id] . "'");
        }

    }
}

function getrating($user_id)
{
    global $dbh;
    global $prev;
    global $conn;
    $rate_fb = "select AVG(avg_rate) as icon from " . $prev . "feedback  where feedback_to='" . $user_id . "' ";
    $rate_fb1 = "select * from " . $prev . "feedback  where feedback_to='" . $user_id . "' ";
    $rate_fbicon = mysql_fetch_array(mysql_query($rate_fb));
    $rate_fbicon1 = mysql_num_rows(mysql_query($rate_fb1));
    $ic = number_format($rate_fbicon["icon"], 1, ".", ",");
    $icon = floor($rate_fbicon["icon"]);
    $a .= " ";
    for( $i = 0; $i < $icon; $i++ ) 
    {
        $a .= "<img src='" . $vpath . "images/1star.png' />";
    }
    for( $j = 5; $icon < $j; $j-- ) 
    {
        $a .= "<img src='" . $vpath . "images/star_3.png' />";
    }
    return $a;
}

function getprojectcomplted($userid)
{
    global $dbh;
    global $prev;
    global $conn;
    $rs3 = mysql_num_rows(mysql_query("select id from " . $prev . "projects where chosen_id = '" . $userid . "' and status='complete'"));
    return $rs3;
}

function getprojectcompltedbyclient($userid)
{
    global $dbh;
    global $prev;
    global $conn;
    $rs3 = mysql_num_rows(mysql_query("select id from " . $prev . "projects where user_id = '" . $userid . "' and status='complete'"));
    return $rs3;
}

function getprojectworking($userid)
{
    global $dbh;
    global $prev;
    global $conn;
    $rs3 = mysql_num_rows(mysql_query("select project_id from " . $prev . "buyer_bids where bidder_id = '" . $userid . "' and chose='Y'"));
    return $rs3;
}

function getprojectcountforuser($userid)
{
    global $dbh;
    global $prev;
    global $conn;
    $rs3 = mysql_num_rows(mysql_query("select id from " . $prev . "projects where user_id = '" . $userid . "' "));
    return $rs3;
}

function getworkedprojectcountforuser($userid)
{
    global $dbh;
    global $prev;
    global $conn;
    $rs3 = mysql_num_rows(mysql_query("select id from " . $prev . "projects where chosen_id = '" . $userid . "' "));
    return $rs3;
}

function getrelaseamountfordispute($escrow_id)
{
    global $dbh;
    global $prev;
    global $conn;
    $my = mysql_fetch_assoc(mysql_query("select received_amt from " . $prev . "disputes where escrow_id='" . $escrow_id . "'"));
    return $my["received_amt"];
}

function getprojecttab($selectid, $p = 2)
{
    global $lang;
    include("includes/my_project_tab.php");
}

function fetbidcount($bidder_id)
{
    global $dbh;
    global $prev;
    global $conn;
    $rt = mysql_num_rows(mysql_query("select id from " . $prev . "buyer_bids where bidder_id='" . $bidder_id . "'"));
    return $rt;
}

function getfeatureiconmain($project_id)
{
    global $dbh;
    global $prev;
    global $conn;
    global $vpath;
    global $ln;
    $rt = mysql_fetch_assoc(mysql_query("select special from " . $prev . "projects where id='" . $project_id . "' and special like '%featured%'"));
    if( trim($rt["special"]) != "" ) 
    {
        $a = "&nbsp;<img src=\"" . $vpath . "/images/" . $ln . "/featured_vr.png\" alt=\"featured\" >";
        return $a;
    }

}

function getfeatureicon($project_id, $ty)
{
    global $dbh;
    global $prev;
    global $conn;
    global $vpath;
    global $ln;
    $rt = mysql_fetch_assoc(mysql_query("select special from " . $prev . "projects where id='" . $project_id . "'"));
    if( trim($rt["special"]) != "" ) 
    {
        $fea = @explode(",", $rt["special"]);
        foreach( $fea as $val ) 
        {
            if( $ty == 1 ) 
            {
                if( $val != "featured" ) 
                {
                    $a .= "&nbsp;<img src=\"" . $vpath . "/images/" . $ln . "/" . $val . ".jpg\" alt=\"" . $val . "\" >";
                }

            }
            else
            {
                $rtstyl1 = "margin-left: -110px";
                $a .= "&nbsp;<img src=\"" . $vpath . "/images/" . $ln . "/" . $val . "_ic.png\" alt=\"" . $val . "\" style=\"margin-left: -110px\">";
            }

        }
        return $a;
    }

}

function getusercountry($userd)
{
    global $dbh;
    global $prev;
    global $conn;
    global $vpath;
    global $ln;
    $row_user = mysql_fetch_array(mysql_query("select country from " . $prev . "user where user_id = '" . $userd . "'"));
    print $country_array[$row_user[country]];
    echo " </b>&nbsp;<img src=\"";
    echo $vpath;
    echo "cuntry_flag/";
    echo strtolower($row_user[country]);
    echo ".png\" title=\"";
    echo $country_array[$row_user[country]];
    echo "\" width=\"16\" height=\"11\" >\r\n    ";
}

function getuserskills($uid, $sepate = ",", $class = "", $type = "a", $limit = 5)
{
    global $dbh;
    global $prev;
    global $conn;
    global $vpath;
    global $ln;
    $skill_q = "select c.cat_name,c.cat_id from " . $prev . "categories c inner join " . $prev . "user_cats u on c.cat_id=u.cat_id where user_id=" . $uid . "" . " limit " . $limit;
    $res_skill = mysql_query($skill_q);
    while( $data_skill = @mysql_fetch_array($res_skill) ) 
    {
        if( $type == "a" ) 
        {
            $data_cat_name[] = " <a class='" . $class . "' href='" . $vpath . "browse-freelancers.php?user=W&skills=" . $data_skill[cat_id] . "'>" . $data_skill["cat_name"] . "</a> ";
        }
        else
        {
            $data_cat_name[] = " <" . $type . " class='" . $class . "' >" . $data_skill["cat_name"] . "</" . $type . "> ";
        }

    }
    $cat_name = @implode($sepate, $data_cat_name);
    return $cat_name;
}

function getreviewcount($uid)
{
    global $dbh;
    global $prev;
    global $conn;
    global $vpath;
    global $ln;
    return $sql = mysql_num_rows(mysql_query("select id from " . $prev . "feedback where feedback_to = '" . $uid . "' "));
}

function getuserdetl($uid, $filed = "*")
{
    global $dbh;
    global $prev;
    global $conn;
    global $vpath;
    global $ln;
    $rs_user = mysql_fetch_array(mysql_query("select " . $filed . " from " . $prev . "user where user_id = '" . $uid . "'"));
    return $rs_user;
}

function languagechagevalue($filed_id, $filed_name, $table_name, $origianl_name)
{
    global $dbh;
    global $prev;
    global $conn;
    global $vpath;
    global $ln;
    global $lang;
    if( $_SESSION[lang_id] ) 
    {
        $row_content_lang = mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where content_field_id='" . $filed_id . "' and table_name='" . $table_name . "' and field_name='" . $filed_name . "' and lang_id='" . $_SESSION[lang_id] . "'"));
        if( $row_content_lang["content"] != "" ) 
        {
            return $row_content_lang["content"];
        }

        return $origianl_name;
    }

    return $origianl_name;
}

function getprojectcountbydate($fromdate, $days)
{
    global $prev;
    $today = $fromdate;
    $day = (0 - $days) . "day";
    $prevdate = date("Y-m-d", strtotime("'" . $day . "'", strtotime($today)));
    $p = @mysql_fetch_array(@mysql_query("select count(id) as ct from " . $prev . "" . "projects where creation between '" . $prevdate . "' and '" . $today . "' "));
    return $p[ct];
}

function gettotalfreelancer()
{
    global $prev;
    $q = @mysql_num_rows(@mysql_query("select " . $prev . "user.user_id from  " . $prev . "user left join " . $prev . "user_cats on " . $prev . "user_cats.user_id=" . $prev . "user.user_id  where  " . $prev . "user.status='Y'  and " . $prev . "user_cats.user_id=" . $prev . "user.user_id   group by " . $prev . "user.user_id"));
    return $q;
}

function gettotaluserbyskills($skilid)
{
    global $prev;
    $q = @mysql_fetch_array(@mysql_query("select count(" . $prev . "user.user_id) as c from  " . $prev . "user left join " . $prev . "user_cats on " . $prev . "user_cats.user_id=" . $prev . "user.user_id left join " . $prev . "categories on " . $prev . "user_cats.cat_id=" . $prev . "categories.cat_id where  " . $prev . "user.status='Y'  and " . $prev . "user_cats.user_id=" . $prev . "user.user_id and  " . $prev . "user_cats.cat_id='" . $skilid . "' and  " . $prev . "categories.status='Y'"));
    return $q["c"];
}

function getprojecttype($project_id)
{
    global $prev;
    $type_pr = mysql_fetch_array(mysql_query("select project_type from " . $prev . "projects where id='" . $project_id . "'"));
    return $type_pr["project_type"];
}

function canHeDo($userid, $action, $skillcount = "")
{
    global $prev;
    $flag = FALSE;
    $planqrry = mysql_query("SELECT * FROM `" . $prev . "usermembership` WHERE `user_id`='" . $userid . "'");
    $planrow = mysql_fetch_assoc($planqrry);
    switch( $action ) 
    {
        case "bid":
            $bidqrry = mysql_query("SELECT COUNT(id) AS tbid FROM `" . $prev . "buyer_bids` WHERE `bidder_id`='" . $userid . "' AND DATE(`add_date`) BETWEEN DATE('" . $planrow["sub_date"] . "') AND DATE('" . $planrow["exp_date"] . "')");
            $bidrow = mysql_fetch_assoc($bidqrry);
            if( (int) $bidrow["tbid"] < (int) $planrow["bids"] ) 
            {
                $flag = TRUE;
            }

            break;
        case "skill":
            if( 0 < $skillcount ) 
            {
                $skillqrry = mysql_query("SELECT COUNT(user_id) AS tskill FROM `" . $prev . "user_cats` WHERE `user_id`='" . $userid . "'");
                $skillrow = mysql_fetch_assoc($skillqrry);
                if( (int) $skillcount <= (int) $planrow["skill"] ) 
                {
                    $flag = TRUE;
                }

            }
            else
            {
                $flag = TRUE;
            }

            break;
        case "portfolio":
            $portqrry = mysql_query("SELECT COUNT(id) AS tpl FROM `" . $prev . "portfolio` WHERE `user_id`='" . $userid . "' AND `status`='Y'");
            $portrow = mysql_fetch_assoc($portqrry);
            if( (int) $portrow["tpl"] < (int) $planrow["portfolio"] ) 
            {
                $flag = TRUE;
            }

    }
    return $flag;
}

function getUserLastLang($userid)
{
    global $prev;
    $qrry = "SELECT `langcode` FROM `" . $prev . "userlastlang` WHERE `user_id`='" . $userid . "'";
    $res = mysql_query($qrry);
    $row = mysql_fetch_assoc($res);
    return $row["langcode"];
}

function setUserLastLang($userid, $langcode)
{
    global $prev;
    $qrry = "SELECT `langcode` FROM `" . $prev . "userlastlang` WHERE `user_id`='" . $userid . "'";
    $res = mysql_query($qrry);
    if( 0 < mysql_num_rows($res) ) 
    {
        $qrry = "UPDATE `" . $prev . "userlastlang` SET `langcode`='" . $langcode . "' WHERE `user_id`='" . $userid . "'";
    }
    else
    {
        $qrry = "INSERT INTO `" . $prev . "userlastlang` SET `langcode`='" . $langcode . "', `user_id`='" . $userid . "'";
    }

    mysql_query($qrry);
}

function getSubCategory($catid)
{
    global $prev;
    $qrry = "SELECT `cat_name` FROM `" . $prev . "categories` WHERE `cat_id`='" . $catid . "'";
    $res = mysql_query($qrry);
    $row = mysql_fetch_assoc($res);
    return $row["cat_name"];
}

function getUserDetailsById($uid, $field)
{
    global $prev;
    $uqry = mysql_query("SELECT `" . $field . "` FROM `" . $prev . "user` WHERE `user_id`=" . $uid);
    $urow = mysql_fetch_assoc($uqry);
    return $urow[$field];
}


