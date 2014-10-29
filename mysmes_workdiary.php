<?php
include "includes/header.php";
CheckLogin();

$every_10_minutes = hoursRange( 0, 86400, 60 * 10, 'h:i a' );

if(isset($_REQUEST['date2load']) && strtotime($_REQUEST['date2load'])) {
    $current_date = date('D, M d, Y', strtotime($_REQUEST['date2load']));
} else {
    $current_date = date('D, M d, Y');
}

$q = "SELECT * FROM ".$prev."projects p
        WHERE p.user_id='".$_SESSION['user_id']."' AND p.status= 'process' AND p.project_type='H' ORDER BY p.id DESC";   
        
$r = mysql_query($q);   
$list = array();
while ($val = mysql_fetch_array($r)) {
    array_push($list, $val);
}
?>

    <div class="spage-container job_work_diary" id="manageMyTeam_workDiary">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                     <?php
                        $parent = 'manage_my_team';
                        $current = 'work_diary';
                        $current_sub = '';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right">
                        <div class="container">
                            <div class="select-box select-box-pj">
                                <select name="select_pj" id="select-pj" class="selectyze2">
                                    <?php $my_job = $list;
                                    foreach ($my_job as $job) { 
                                        $selected = '';
                                        if(isset($_REQUEST['id']) && $_REQUEST['id'] == $job['id']) {
                                            $selected = 'selected';
                                        }
                                        ?>
                                        <option value="<?php echo $job['id']?>" <?php echo $selected ?>><?php echo $job['project']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="container">
                        <div class="time-zone">
                            <p>Time Zone</p>
                            <div class="sv-dropdown dd-timezone">
                                <div class="sv-dropSelect">Mine (UTC +0:00)</div>
                                <ul>
                                    <li>UTC+00</li>
                                </ul>
                            </div>
                            <div class="datetime">
                                <span class="prev-day" style="margin-right: 15px;"><i class="fa fa-chevron-left"></i></span>
                                <input type="text" id="datepicker" value='' class="date2add">
                                <span class="next-day"><i class="fa fa-chevron-right"></i></span>
                                <img class="clander-img" src="css/img/calender_icon.png" alt="">
                            </div>
                            <a href="#" class="pref">Pref</a>
                        </div>
                        </div>
                        <div class="container">
                            <div class="total-time-logged">
                            <p class="total-time">Total Time Logged: <strong>00:00</strong></p>
                            <p class="auto-tracked">Auto-tracked: <span>00:00</span></p>
                            <p class="manual-time">Manual time: <span>00:00</span></p>
                            <p>Selected: <strong>00:00 min</strong></p>
                            </div>
                        </div>
                        <div id="workdiary-tracker-containter">
                            
                        </div>
                </div>
            </div>
            </div>
        </div>
    </div>  
</div>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            loadByDate('<?=$current_date?>');
            $('#select-pj').on('change', function(){
                loadByDate($('#datepicker').val());
            })
            $(".time_select_box").chosen();
            
        })        

    </script>
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script>
    function sortLiSnap(ulContainer) {
        var items = ulContainer.find('li').get();
        items.sort(function(a,b){
          var keyA = $(a).data('workdiary-postion');
          var keyB = $(b).data('workdiary-postion');

          if (keyA < keyB) return -1;
          if (keyA > keyB) return 1;
          return 0;
        });
        
        $.each(items, function(i, li){
          ulContainer.append(li);
        });
    }

    function checkMissingPos(ulContainer) {
        for (var i = 0; i <= 5; i++) {
            if(ulContainer.find('li[data-workdiary-postion='+i+']').length == 0) {
                ulContainer.append('<li data-workdiary-postion="'+i+'" class="workdiary-snap-item"></li>');
            }
        }

        sortLiSnap(ulContainer);
    }

    function loadByDate(val) {
        $('.date2add').html(val);
        var project_id = $('#select-pj').val();
        
        $.ajax({
           url: '<?= $vpath; ?>ajax_action.php',
           data: {action: 'load_work_diary', project_id: project_id, user_id: '<?=$_SESSION['user_id']?>', load_date: val},
           success: function(data) {
                if(data) {
                    $('#workdiary-tracker-containter').html(data);
                    $('.workdiary-tracker-list-snap').each(function() {
                    var ulContainer = $(this);
                    checkMissingPos(ulContainer);
                    });
                } else {
                    $('#workdiary-tracker-containter').html('<div class="alert alert-warning" role="alert">No Snap Time</div>');
                }
                get_all_snap_dates();
                getTotalTime(val);
                $(".fancyclass").fancybox();
           }
        });
    }
    function get_all_snap_dates() {
        var project_id = $('#select-pj').val();
        $.ajax({
           url: '<?= $vpath; ?>ajax_action.php',
           data: {action: 'get_all_dates_snap', user_id: '<?=$_SESSION['user_id']?>', project_id: project_id},
           success: function(data) {
                var arr = JSON.parse(data);
                var SelectedDates = {};

                for (var i = 0; i < arr.length; i++) {
                    SelectedDates[new Date(arr[i])] = new Date(arr[i]);
                };
                // console.log(SelectedDates);
                $( "#datepicker" ).datepicker( "option", {
                    dateFormat: "D, M dd, yy",
                    beforeShowDay: function(date) {
                        var Highlight = SelectedDates[date];                
                        if(Highlight) {
                            return [true, 'has-snap-shot', '']
                        } else {
                            return [true, '', ''];
                        }
                    } 
                });
                // if($( "#datepicker" ).val() == '') {
                //     $( "#datepicker" ).datepicker( "setDate", "<?=$current_date?>" );
                // }
           }
        });
    }

    function getTotalTime(val) {
        var project_id = $('#select-pj').val();
        $.ajax({
           url: '<?= $vpath; ?>ajax_action.php',
           data: {action: 'calculate_log_time', user_id: '<?=$_SESSION['user_id']?>', project_id: project_id, load_date: val},
           success: function(data) {
                var arr = JSON.parse(data);
                $('.total-time strong').html(arr.total);
                $('.auto-tracked span').html(arr.auto);
                $('.manual-time span').html(arr.manual);
           }
        });
    }
      $(function() {
        get_all_snap_dates();
        
        // var SelectedDates = {};
        // <?php for ($i=0; $i < count($all_dates_snap); $i++) { ?>
        // SelectedDates[new Date("<?php echo $all_dates_snap[$i]?>")] = new Date("<?php echo $all_dates_snap[$i]?>");
        // <?php } ?>

        // $( "#datepicker" ).datepicker( "option", {
        //     dateFormat: "D, M dd, yy",
        //     beforeShowDay: function(date) {
        //         var Highlight = SelectedDates[date];                
        //         if(Highlight) {
        //             return [true, 'has-snap-shot', '']
        //         } else {
        //             return [true, '', ''];
        //         }
        //     } 
        // }); 
        $( "#datepicker" ).datepicker( "option", "dateFormat", "D, M dd, yy");
        $( "#datepicker" ).datepicker( "setDate", "<?=$current_date?>" );
        $( "#datepicker" ).on('change', function(){
            loadByDate($(this).val());
        })
        $('.next-day').on("click", function () {
            var date = $('#datepicker').datepicker('getDate');
            date.setTime(date.getTime() + (1000*60*60*24))
            $('#datepicker').datepicker("setDate", date);
            loadByDate($('#datepicker').val());
        });

        $('.prev-day').on("click", function () {
            var date = $('#datepicker').datepicker('getDate');
            date.setTime(date.getTime() - (1000*60*60*24))
            $('#datepicker').datepicker("setDate", date);
            loadByDate($('#datepicker').val());
        });
      });
    </script>
<?php include 'includes/footer.php'; ?>