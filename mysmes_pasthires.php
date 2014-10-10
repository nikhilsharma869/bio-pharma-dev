<?php
include "includes/header.php";
CheckLogin();
$no_of_records = 5;
$sql = "SELECT * FROM " . $prev . "user AS u
        LEFT JOIN ".$prev."projects AS p ON p.chosen_id=u.user_id
            LEFT JOIN ".$prev."buyer_bids AS b ON b.project_id=p.id 
        WHERE p.status='complete' AND p.user_id=" . $_SESSION['user_id'];

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
$sql .= " GROUP BY u.user_id";
        
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
    <div class="spage-container managemyteam">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                   <!-- tabs left -->
                    <?php
                        $parent = 'manage_my_team';
                        $current = 'my_team';
                        $current_sub = 'pasthired';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
                    <!-- tabs left -->
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right">
                        <div class="search-team">
                            <form name="search-frm" action="" method="post">
                                <input type='text' name="keyword" placeholder="Search for SMEs">                                
                                <input type="submit" value="" name="submit">
                            </form>
                        </div>
                        <?php
                            echo new_pagingnew(5,$vpath.'mysmes_pasthires/',$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
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
                            <div class="j-row">
                                <p class="j-col1">
                                <img class="mt-img" src="<?=$vpath?>viewimage.php?img=<?php echo $temp_logo;?>&amp;width=100&amp;height=100" alt=""/>
                                <span class="mt-title"><strong class="c-blue"><?=$name?></strong></span>
                                <span class="mt-address"><?=ucfirst($d['slogan'])?></span>
                                </p>
                                <p class="j-col2">
                                    <span>Ended Jun 13, 2014 </span>
                                </p>
                                <p class="j-col3"><a href="#" class="mt-rehire">Rehire..</a></p>
                                <div class="dropdown new-drd new-drd-pasthire">
                                      <a id="dLabel" class="mt-action" data-toggle="dropdown" data-target="#" href="/page.html">
                                        Action
                                      </a>
                                      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                        <li><a href="#" class="">Invite</a></li>
                                        <li><a href="#" class="">Rehire</a></li>
                                      </ul>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <?php
                            echo new_pagingnew(5,$vpath.'mysmes_pasthires/',$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>