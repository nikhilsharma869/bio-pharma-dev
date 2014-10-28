<?php
include "includes/header.php";
CheckLogin();
$no_of_records = 5;
$sql = "SELECT *,p.id AS p_id FROM " . $prev . "user AS u
        LEFT JOIN ".$prev."projects AS p ON p.chosen_id=u.user_id
            LEFT JOIN ".$prev."buyer_bids AS b ON b.project_id=p.id 
        WHERE p.user_id=" . $_SESSION['user_id'];

if(isset($_REQUEST['end_pj']) && $_REQUEST['end_pj'] != 'all') {
    $sql .= " AND p.status='complete'";
} else {
    $sql .= " AND (p.status='complete' OR p.status='process')";
}

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
    <div class="spage-container manageMyTeam_contracts">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <?php
                        $parent = 'manage_my_team';
                        $current = 'contracts';
                        $current_sub = '';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right sv-plus">
                        <div class="search" id="ds-team">       
                            <!-- <label class="lb-team">Team</label>         
                            <div class="sv-dropdown">                                
                                <div class="sv-dropSelect">MyCS</div>
                                <ul>
                                    <li>1</li>
                                    <li>2</li>
                                    <li>3</li>
                                    <li>4</li>
                                </ul>
                            </div> -->
                            <form name="search-frm" id="search-frm" action="" method="post">
                                <input type='text' name="keyword" placeholder="Enter Name, Title or Team" value="<?=$_REQUEST['keyword']?>">
                                <input id="check_ended" type="checkbox" class="css-input" name="end_pj" <?php if(isset($_REQUEST['end_pj']) && $_REQUEST['end_pj'] != 'all') {echo 'value="ended" checked="checked"';} else { echo "value='all'";}   ?> />    
                                <label for="check_ended" class="css-label"></label>
                                <label>Ended Contacts</label>
                            </form>
                        </div>
                        <?php
                            echo new_pagingnew(5,$vpath.'mysmes_contracts/',$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
                        ?>
                        <div class="row-title">                            
                            <p class="j-col1 text-bold">SMEs</p>
                            <p class="j-col2 text-bold">Time Period</p>
                            <p class="j-col3 text-bold">Terms</p>
                        </div>
                        <div class="row-content">
                            <?php
                            if(mysql_num_rows($r) == 0) { ?>
                            <div class="j-row">
                                <div class="alert alert-warning" role="alert"><?=$lang['NO_DATA']?></div>
                            </div>
                            <?php }
                            while($d=@mysql_fetch_array($r))
                            {

                                $name = $d[fname]." ".$d[lname];
                                
                            ?>  
                            <div class="j-row">
                                <p class="j-col1"><?=$name?><br/><span class="small-text"><?=ucfirst($d['slogan'])?></span></p>
                                <p class="j-col2"><?php echo date('M d, Y', strtotime($d['ctime'])); ?> - <?php if($d['status']=='process') {echo 'Present';} else { echo date('M d, Y', strtotime($d['edate']));} ?></p>
                                <?php if($d['project_type_bid'] == 'H') : ?>
                                <p class="j-col3"><span>$<?=$d['bid_amount']?>/hour<br/><?=$d['hour_limit']?> maximum hours/week</span>
                                <a href="<?= $vpath ?>work_diary/<?= $d['p_id'] ?>" class="work-diary">Work Diary</a></p>
                                <?php else: ?>
                                <p class="j-col3"><span>$<?=$d['paid_amount']?> paid of $<?=$d['bid_amount']?></span>
                                <?php endif; ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php
                            echo new_pagingnew(5,$vpath.'mysmes_contracts/',$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<script type="text/javascript">
    $('#check_ended').on('change', function(){
        if($(this).is(':checked')) {
            $(this).val('ended');
            $('#search-frm').submit();
        } else {
            $(this).val('all');
            $('#search-frm').submit();
        }
    })
</script>
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/jquery-ui.js"></script>  
<?php include 'includes/footer.php'; ?>