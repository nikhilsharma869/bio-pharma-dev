<?php
include("configs/config.php");
function PullValues($result) 
    {     
        if($result == 0) 
        { 
            echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>"; 
        } 
        elseif (@mysql_num_rows($result) == 0) 
        { 
            echo("<b>Query completed. No results returned.</b><br>"); 
        } 
        else 
        { 
            echo "<table border='1'> 
                <thead> 
                <tr><th>[Num]</th>"; 
            for($i = 0;$i < mysql_num_fields($result);$i++) 
            { 
                echo "<th>" . $i . "&nbsp;-&nbsp;" . mysql_field_name($result, $i) . "</th>"; 
            } 
            echo "  </tr> 
                </thead> 
                <tbody>"; 
            for ($i = 0; $i < mysql_num_rows($result); $i++) 
            { 
                echo "<tr><td>[$i]</td>"; 
                $row = mysql_fetch_row($result); 
                for($j = 0;$j < mysql_num_fields($result);$j++)  
                { 
                    echo("<td>" . $row[$j] . "</td>"); 
                } 
                echo "</tr>"; 
            } 
            echo "</tbody> 
            </table>"; 
        }  //end else 
    }  
if(isset($_POST['submit'])){
   $con=mysql_connect ($dbhost, $dbuser, $dbpass); //your mysql connection  
    mysql_select_db($dbname) or die( "Unable to select database"); //your db name 
//$string_old="Lorem Ipsum";
//$string_new="scriptLgiant";
$string_new=$_POST['newvalue'];
$string_old=$_POST['oldvalue'];
echo "Old value:--".$string_old."<br>";
echo "New value:--".$string_new."<br>";
$t=0;
$y=0;
    $tables = mysql_query("SELECT table_name FROM information_schema.tables WHERE table_schema='".$dbname."'"); //pull tables from theh databsase
    while ($table= mysql_fetch_row($tables)) { 
        $rsFields = mysql_query("SHOW COLUMNS FROM ".$table[0]); 
		$y=0;
        while ($field = mysql_fetch_assoc($rsFields)) { 
            //echo $table[0].".".$field["Field"].", "; //prints out all columns 
			
			 $a="UPDATE ".$table[0]."
SET `".$field["Field"]."` = REPLACE(`".$field["Field"]."`, '".$string_old."', '".$string_new."')
WHERE `".$field["Field"]."` LIKE ('%".$string_old."%')";
$effecr=mysql_query($a);
if(mysql_affected_rows()>0){
$t=$t+mysql_affected_rows();
$y=$y+mysql_affected_rows();
}

        } 
		if($y>0){
		 echo "<p style='color:red' class='blink' >Table Name:".$table[0]."------------";
		echo "No of effect:---".$y."</p>";
		}else{
		 echo "<p style='margin:0px'>Table Name:---".$table[0]."------------";
		echo "No of effect:---".$y."</p>";
		}
       
        //$query = "SELECT * FROM ".$table[0]; //prints out tables name
        //$result = mysql_query($query); 
        //PullValues($result); //call function to get all values
    }
mysql_close($con);	
echo "<br> <p style='color:green'class='blink' >Total No of effect:------".$t."</p>";

    //function to pull all values from tables
    
?>

<? unset($_POST);
}
if(isset($_POST['search'])){
    $con=mysql_connect ($dbhost, $dbuser, $dbpass); //your mysql connection  
    mysql_select_db($dbname) or die( "Unable to select database"); //your db name  
	$string_old=$_POST['oldvalue'];
echo "value:--".$string_old."<br>";

$t=0;
$y=0;
    $tables = mysql_query("SELECT table_name FROM information_schema.tables WHERE table_schema='".$dbname."'"); //pull tables from theh databsase
    while ($table= mysql_fetch_row($tables)) { 
        $rsFields = mysql_query("SHOW COLUMNS FROM ".$table[0]); 
		$y=0;
        while ($field = mysql_fetch_assoc($rsFields)) {
			 $a="select count('".$field["Field"]."') as cnt from ".$table[0]." WHERE `".$field["Field"]."` LIKE ('%".$string_old."%')";
$effecr=@mysql_fetch_array(mysql_query($a));
if($effecr['cnt']>0){
$t=$t+$effecr['cnt'];
$y=$y+$effecr['cnt'];
$as="select * from ".$table[0]." WHERE `".$field["Field"]."` LIKE ('%".$string_old."%')";
$result=mysql_query($as);
PullValues($result);
}

        } 
		if($y>0){
		 echo "<p style='color:red' class='blink' >Table Name:".$table[0]."------------";
		echo "Rows:---".$y."</p>";
		}
       
        //$query = "SELECT * FROM ".$table[0]; //prints out tables name
        //$result = mysql_query($query); 
        //PullValues($result); //call function to get all values
    }
mysql_close($con);	
echo "<br> <p style='color:green'class='blink' >Total rows will be  effect:------".$t."</p>";
}

if(isset($_POST['searchtable'])){
   $con=mysql_connect ($dbhost, $dbuser, $dbpass); //your mysql connection  
    mysql_select_db($dbname) or die( "Unable to select database"); //your db name 
//$string_old="Lorem Ipsum";
//$string_new="scriptLgiant";
$string_new=$_POST['newvalue'];
$string_old=$_POST['oldvalue'];
echo "Old value:--".$string_old."<br>";
echo "New value:--".$string_new."<br>";
$t=0;
$y=0;
   if($_POST['table']!=""){
        $rsFields = mysql_query("SHOW COLUMNS FROM ".$_POST['table']); 
		$y=0;
        while ($field = mysql_fetch_assoc($rsFields)) { 
            //echo $table[0].".".$field["Field"].", "; //prints out all columns 
			
			 $a="UPDATE ".$_POST['table']."
SET `".$field["Field"]."` = REPLACE(`".$field["Field"]."`, '".$string_old."', '".$string_new."')
WHERE `".$field["Field"]."` LIKE ('%".$string_old."%')";
$effecr=mysql_query($a);
if(mysql_affected_rows()>0){
$t=$t+mysql_affected_rows();
$y=$y+mysql_affected_rows();
}

        } 
		if($y>0){
		 echo "<p style='color:red' class='blink' >Table Name:".$_POST['table']."------------";
		echo "No of effect:---".$y."</p>";
		}else{
		 echo "<p style='margin:0px'>Table Name:---".$_POST['table']."------------";
		echo "No of effect:---".$y."</p>";
		}
       
        //$query = "SELECT * FROM ".$table[0]; //prints out tables name
        //$result = mysql_query($query); 
        //PullValues($result); //call function to get all values
    }
mysql_close($con);	
echo "<br> <p style='color:green'class='blink' >Total No of effect:------".$t."</p>";

 unset($_POST);
}?>
<form name="update" id="update" action="" method="post">
<p>Old value: <input type="text" name="oldvalue" value="<?=$_POST['oldvalue']?>"/></p>
<p>New value: <input type="text" name="newvalue" value="<?=$_POST['newvalue']?>"/></p>
<input type="submit" name="submit" id="submit" value="Replace"/>
</form>

<form name="update" id="update" action="" method="post">
<p>value: <input type="text" name="oldvalue" value="<?=$_POST['oldvalue']?>"/></p>

<input type="submit" name="search" id="search" value="Search"/>
</form>
<form name="update" id="update" action="" method="post">
<p>Old value: <input type="text" name="oldvalue" value="<?=$_POST['oldvalue']?>"/></p>
<p>New value: <input type="text" name="newvalue" value="<?=$_POST['newvalue']?>"/></p>
<p>Table: <input type="text" name="table" value="<?=$_POST['table']?>"/></p>
<input type="submit" name="searchtable" id="search" value="replace"/>
</form>
<style>
/**
 *    Real-World CSS
 *    by @visualidiot. Licensed under WTPFL.
 */
 
/* @group Blink */

.blink {
    -webkit-animation: blink .75s linear infinite;
    -moz-animation: blink .75s linear infinite;
    -ms-animation: blink .75s linear infinite;
    -o-animation: blink .75s linear infinite;
    animation: blink .75s linear infinite;
	padding: 0px;
margin: 0px;
}

@-webkit-keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 1; }
    50.01% { opacity: 0; }
    100% { opacity: 0; }
}

@-moz-keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 1; }
    50.01% { opacity: 0; }
    100% { opacity: 0; }
}

@-ms-keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 1; }
    50.01% { opacity: 0; }
    100% { opacity: 0; }
}

@-o-keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 1; }
    50.01% { opacity: 0; }
    100% { opacity: 0; }
}

@keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 1; }
    50.01% { opacity: 0; }
    100% { opacity: 0; }
}

/* @end */



/* @group Marquee */

.marquee {
    height: 30px;
    
    overflow: hidden;
    position: relative;
}
    .marquee div {
        display: block;
        width: 200%;
        height: 30px;
        
        position: absolute;
        overflow: hidden;
        
        -webkit-animation: marquee 4s linear infinite;
        -moz-animation: marquee 4s linear infinite;
        -ms-animation: marquee 4s linear infinite;
        -o-animation: marquee 4s linear infinite;
        animation: marquee 4s linear infinite;
    }
    .marquee span {
        float: left;
        width: 50%;
    }
    
@-webkit-keyframes marquee {
    0% { left: 0; }
    100% { left: -100%; }
}
@-moz-keyframes marquee {
    0% { left: 0; }
    100% { left: -100%; }
}
@-ms-keyframes marquee {
    0% { left: 0; }
    100% { left: -100%; }
}
@-o-keyframes marquee {
    0% { left: 0; }
    100% { left: -100%; }
}
@keyframes marquee {
    0% { left: 0; }
    100% { left: -100%; }
}

/* @end */


/* @group Peekaboo! */

.peekaboo:hover {
    opacity: 0;
}

/* @end */



/* @group Wibble-Wobble */

.wobble {
    position: relative;
    display: inline-block;
}
    .wobble:hover {
        -webkit-animation: wobble .75s linear infinite;
        -moz-animation: wobble .75s linear infinite;
        -ms-animation: wobble .75s linear infinite;
        -o-animation: wobble .75s linear infinite;
        animation: wobble .75s linear infinite;
    }
    
@-webkit-keyframes wobble {
    0% { -webkit-transform: rotate(-2deg); }
    20% { -webkit-transform: rotate(4deg); }
    30% { -webkit-transform: rotate(1deg); }
    40% { -webkit-transform: rotate(3deg); }
    55% { -webkit-transform: rotate(0deg); }
    70% { -webkit-transform: rotate(-4deg); }
    80% { -webkit-transform: rotate(2deg); }
    90% { -webkit-transform: rotate(-2deg); }
    90% { -webkit-transform: rotate(3deg); }
}
@-moz-keyframes wobble {
    0% { -moz-transform: rotate(-2deg); }
    20% { -moz-transform: rotate(4deg); }
    30% { -moz-transform: rotate(1deg); }
    40% { -moz-transform: rotate(3deg); }
    55% { -moz-transform: rotate(0deg); }
    70% { -moz-transform: rotate(-4deg); }
    80% { -moz-transform: rotate(2deg); }
    90% { -moz-transform: rotate(-2deg); }
    90% { -moz-transform: rotate(3deg); }
}
@-ms-keyframes wobble {
    0% { -ms-transform: rotate(-2deg); }
    20% { -ms-transform: rotate(4deg); }
    30% { -ms-transform: rotate(1deg); }
    40% { -ms-transform: rotate(3deg); }
    55% { -ms-transform: rotate(0deg); }
    70% { -ms-transform: rotate(-4deg); }
    80% { -ms-transform: rotate(2deg); }
    90% { -ms-transform: rotate(-2deg); }
    90% { -ms-transform: rotate(3deg); }
}
@-o-keyframes wobble {
    0% { -o-transform: rotate(-2deg); }
    20% { -o-transform: rotate(4deg); }
    30% { -o-transform: rotate(1deg); }
    40% { -o-transform: rotate(3deg); }
    55% { -o-transform: rotate(0deg); }
    70% { -o-transform: rotate(-4deg); }
    80% { -o-transform: rotate(2deg); }
    90% { -o-transform: rotate(-2deg); }
    90% { -o-transform: rotate(3deg); }
}
@keyframes wobble {
    0% { transform: rotate(-2deg); }
    20% { transform: rotate(4deg); }
    30% { transform: rotate(1deg); }
    40% { transform: rotate(3deg); }
    55% { transform: rotate(0deg); }
    70% { transform: rotate(-4deg); }
    80% { transform: rotate(2deg); }
    90% { transform: rotate(-2deg); }
    90% { transform: rotate(3deg); }
}


/* @end */



/* @group Third Degree */

.third-degree {
    -webkit-transform: rotate(3deg);
    -moz-transform: rotate(3deg);
    -ms-transform: rotate(3deg);
    -o-transform: rotate(3deg);
    transform: rotate(3deg);
    
    display: inline-block;
    position: relative;
    
    filter: progid:DXImageTransform.Microsoft.Matrix(M11=0.9986295347545738, M12=-0.05233595624294383, M21=0.05233595624294383, M22=0.9986295347545738, sizingMethod='auto expand');
    zoom: 1;
}

/* @end */



/* @group WordArt */

.wordart {
    color: #333; /* This is for non-webkit browsers */
    -webkit-text-fill-color: transparent;

    position: relative;
    display: inline-block;
    
    font: bold 48px "Arial Narrow", sans-serif;
}
    .wordart:before {
        content: attr(title);
        
        position: absolute;
        left: 0;
        top: 0;
        z-index: 2;
        
        background: -webkit-linear-gradient(left, rgb(176,9,151) 0%, rgb(227,33,107) 10%, rgb(249,96,30) 25%, rgb(255,180,18) 40%, rgb(255,216,45) 50%, rgb(185,221,23) 61%, rgb(65,160,60) 75%, rgb(19,54,180) 90%, rgb(116,27,157) 100%);
        
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .wordart:after {
        content: attr(title);

        position: absolute;
        z-index: 199;
        left: -6px;
        bottom: -10px;
        
        z-index: 1;
        
        
        -webkit-text-fill-color: #000;
        -webkit-transform: skew(40deg, 0deg) scaleY(.5);
        
        opacity: .3;
    }
    
/* @end */



/* @group Nausea */

.nausea {
    display: inline-block;
    position: relative;

    -webkit-animation: nausea .25s linear infinite;
    -moz-animation: nausea .25s linear infinite;
    -ms-animation: nausea .25s linear infinite;
    -o-animation: nausea .25s linear infinite;
    animation: nausea .25s linear infinite;
}

@-webkit-keyframes nausea {
    0% { -webkit-transform: rotate(0deg); }
    50% { -webkit-transform: scale(1.5) rotate(180deg); }
    100% { -webkit-transform: scale(.8) rotate(360deg); }
}
@-moz-keyframes nausea {
    0% { -moz-transform: rotate(0deg); }
    50% { -moz-transform: scale(1.5) rotate(180deg); }
    100% { -moz-transform: scale(.8) rotate(360deg); }
}
@-ms-keyframes nausea {
    0% { -ms-transform: rotate(0deg); }
    50% { -ms-transform: scale(1.5) rotate(180deg); }
    100% { -ms-transform: scale(.8) rotate(360deg); }
}
@-o-keyframes nausea {
    0% { -o-transform: rotate(0deg); }
    50% { -o-transform: scale(1.5) rotate(180deg); }
    100% { -o-transform: scale(.8) rotate(360deg); }
}
@keyframes nausea {
    0% { transform: rotate(0deg); }
    50% { transform: scale(1.5) rotate(180deg); }
    100% { transform: scale(.8) rotate(360deg); }
}
    
/* @end */



/* @group Perfect Typography */

.perfect {
    color: #f00;
    font: 72px/20px "Comic Sans MS", "Comic Sans", "Chalkboard", cursive;
    
    letter-spacing: -2px;    
}
 
/* @end */
</style>