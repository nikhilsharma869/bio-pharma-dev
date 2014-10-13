<?php
include "includes/header.php";
CheckLogin();
$no_of_records = 5;
$sql = "SELECT *,p.status AS pstatus FROM ".$prev."projects AS p
        LEFT JOIN ".$prev."buyer_bids AS b ON p.id=b.project_id 
            LEFT JOIN ".$prev."user AS u ON p.user_id=u.user_id 
        WHERE p.chosen_id=".$_SESSION['user_id'];

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
            $condser = " AND (p.project like '%".$val."%')";

        }
        if($condser){
            $sql .= $condser;
        }
    }
}
// $sql .= " GROUP BY u.user_id";
        
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
                <h3 class="title-page">Contracts</h3>
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <?php
                        $parent = 'my_job';
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
                            <form name="search-frm" id="search-frm" action="" method="post">
                                <input type='text' name="keyword" placeholder="Enter Name, Title or Team" value="<?=$_REQUEST['keyword']?>">
                                <input id="check_ended" type="checkbox" class="css-input" name="end_pj" <?php if(isset($_REQUEST['end_pj']) && $_REQUEST['end_pj'] != 'all') {echo 'value="ended" checked="checked"';} else { echo "value='all'";}   ?> />    
                                <label for="check_ended" class="css-label"></label>
                                <label>Ended Contacts</label>
                            </form>
                        </div>
                        <?php
                            echo new_pagingnew(5,$vpath.'contracts/',$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
                        ?>
                        <div class="row-title">                            
                            <p class="j-col1 text-bold">Contracts</p>
                            <p class="j-col2 text-bold">Time Period</p>
                            <p class="j-col3 text-bold">Terms</p>
                        </div>
                        <div class="row-content">
                            <?php
                        
                            while($d=@mysql_fetch_array($r))
                            {      
                                                     
                            ?>  
                            <div class="j-row">
                                <a href='<?= $vpath ?>project/<?php echo $d['project_id'];?>'><p class="j-col1"><?php echo $d['project']?></p></a>
                                <p class="j-col2"><?php echo date('M d, Y', strtotime($d['ctime'])); ?> - <?php if($d['pstatus']=='process') {echo 'Present';} else { echo date('M d, Y', strtotime($d['edate']));} ?></p>
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
                            echo new_pagingnew(5,$vpath.'contracts/',$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
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