<?php
$current_page = "Mailbox";
include "includes/header.php";


CheckLogin();



	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

	$res2=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

	$row2=mysql_fetch_array($res2);

	$res4=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");

	$row3=mysql_fetch_array($res4);

	

	$no_of_records=10;

	$select_project="";	

	

	$q = "SELECT * FROM (

				SELECT *

				FROM ".$prev."pmb

				WHERE private_id = '$_SESSION[user_id]'

				ORDER BY mid DESC

				) AS tmp_table

				GROUP BY id, user_id";

	$r=mysql_query($q);

	$j=0; 

	$parameter="";

	$page_num=@mysql_num_rows($r);

	$a=1;

	$num=mysql_num_rows($r);



	if($_POST['del']=="Delete")

	{

		$id=$_POST['chk'];

		if($id!=null)

		{

			foreach($id as $val)

			{

				$res3=mysql_query("delete from  ".$prev."messages  where id='".$val."'");

			}

			$page=$_REQUEST['page'];

			$msg=$lang['MSG_DELETED'];

			$msg1=base64_encode($msg);

			//header("location:message.php?page=$page&msg='".$msg1."'");

		}

		else

		{

			$page=$_REQUEST['page'];

			$msg=$lang['NO_CONVERSATION_SELECT'];

			$msg1=base64_encode($msg);

			//header("location:message.php?page=$page&msg='".$msg1."'");

		}

	}


	if($_POST['unread']=="Mark as Unread")

	{

		$id=$_POST['chk'];

		if($id!=null)

		{

			foreach($id as $val)

			{

				$res3=mysql_query("update ".$prev."messages set read_status='N' where id='".$val."'");

			}

			$page=$_REQUEST['page'];

			//header("location:message.php?page=$page");

		}

		else

		{

			$page=$_REQUEST['page'];

			$msg=$lang['NO_CONVERSATION_SELECT'];

			$msg1=base64_encode($msg);

			//header("location:message.php?page=$page&msg='".$msg1."'");

		}

	}



	if($_POST['read']=="Mark as Read")

	{

		$id=$_POST['chk'];

		if($id!=null)

		{

			foreach($id as $val)

			{

				$res3=mysql_query("update ".$prev."messages set read_status='Y' where id='".$val."'");

			}

			$page=$_REQUEST['page'];

			//header("location:message.php?page=$page");

		}

		else

		{

			$page=$_REQUEST['page'];

			$msg=$lang['NO_CONVERSATION_SELECT'];

			$msg1=base64_encode($msg);

			//header("location:message.php?page=$page&msg='".$msg1."'");

		}

	}

	if(isset($_REQUEST['bookers_inbox']) && $_POST['checkboxmsg']!="")

	{

		$checkbox = $_POST['checkboxmsg']; //from name="checkbox[]"

		 $countCheck = count($_POST['checkboxmsg']);

		$del_id='';

		for($i=0;$i<$countCheck;$i++)

		{

		$del_id= $checkbox[$i];

		$sql = "DELETE from ".$prev."messages where id='".$del_id."'";

		$result = mysql_query($sql) or die (mysql_error());

		}

		$msg=$lang['MSG_DELETED'];

		$msg1=base64_encode($msg);

		//header("location:messages.php?msg='".$msg1."'");

	}

	$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION['user_id']."'"));

	$inbox_data="select * from  ".$prev."messages where receiver='".$_SESSION['user_id']."' and sender_id!='".$_SESSION['user_id']."' and status='Y' and user_type='reciver' and read_status='N'";

	$rec_date=mysql_query($inbox_data);

	$num_date=mysql_num_rows($rec_date);

// New Query Messages	
$no_of_records = 5;
$sql = "SELECT * FROM " . $prev . "user AS u
        LEFT JOIN (SELECT * FROM ".$prev."pmb ORDER BY ".$prev."pmb.mid DESC) AS pmb ON pmb.user_id=u.user_id
            LEFT JOIN ".$prev."projects AS p ON p.id=pmb.id 
        WHERE pmb.private_id=" . $_SESSION['user_id'];



$condser = 0;
if($_REQUEST['keyword']!=''){

    $srt=@explode(" ",$_REQUEST['keyword']);
    if(count($srt)>0){
        foreach($srt as $val){
            $condser = " AND (u.username like '%".$val."%' OR u.fname like '%".$val."%'  OR u.lname like '%".$val."%')";

        }
        if($condser){
            $sql .= $condser;
        }
    }
}

$sql .= " GROUP BY pmb.user_id, pmb.id ORDER BY pmb.date DESC";

$num=mysql_num_rows(mysql_query($sql));    
//Paging
if($_REQUEST['page']){
    $page=$_REQUEST['page'];
}else{
    $page=0;
}

$parr=array();
$parr=paging_new($sql,$no_of_records,$page);

$limitvalue  = $parr[1];
$total_pages = $parr[2];
$total_item  = $parr[3];


$sql .= " LIMIT $limitvalue, $no_of_records";
$r = mysql_query($sql);
?>


<div class="spage-container managemyteam_message">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left" style="padding-top:30px;">
                <!-- tabs left -->
               <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                    <li><a href="<?= $vpath ?>message.html">Inbox</a></li>
                </ul>
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">
                	<?php
                        echo new_pagingnew(5,$vpath.'message/',$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
                    ?>                         
                    <div class="managemyteam-content">
                        <?php
                        while($d=@mysql_fetch_array($r))
                        {

                            $name = $d[fname]." ".$d[lname];
                            if(!empty($d[logo]))
                            {
                                $temp_logo=$d[logo];
                            }
                            else
                            {
                               $temp_logo="images/face_icon.gif";
                            }   
                            
                        ?>  
                        <div class="j-row" style="<?php if($d['readyet']=='0'){ print "background-color:#CCDDB9";}else{echo "background-color:#fff";}?>">
                            <p class="j-col1">
                            <img class="mt-img" src="<?=$vpath?>viewimage.php?img=<?php echo $temp_logo;?>&amp;width=100&amp;height=100" alt=""/>
                            <span class="mt-title"><strong class="c-blue"><?=$name?></strong></span>
                            <span class="mt-address">From Project: <a class="c-blue" href="<?=$vpath?>conversation/<?php echo $d['id'];?>/<?=$d['user_id']?>/" title="Click Here to view Message"><?=$d['project']?></a></span>
                            <span class="mt-ptime">Date: <?php echo date('M d, Y H:i:s ',strtotime($d['date']));?></span>
                            </p>
                            <div class="dropdown new-drd new-drd-pasthire">
                                  <a id="dLabel" class="mt-action" data-toggle="dropdown" data-target="#" href="/page.html">
                                    Action
                                  </a>
                                  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <li><a href="#" class="">Mark as Unread</a></li>
                                    <li><a href="#" class="">Mark as Read</a></li>
                                    <li><a href="#" class="">Delete</a></li>
                                  </ul>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <?php
                        echo new_pagingnew(5,$vpath.'message/',$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
                    ?> 
                </div>
            </div>

        </div>
    </div>  
</div>

</script>
<?php include 'includes/footer.php'; ?>