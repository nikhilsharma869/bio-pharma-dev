<?php
include "includes/header.php";



$every_10_minutes = hoursRange( 0, 86400, 60 * 10, 'h:i a' );

if(isset($_REQUEST['date2load']) && strtotime($_REQUEST['date2load'])) {
    $current_date = date('D, M d, Y', strtotime($_REQUEST['date2load']));
} else {
    $current_date = date('D, M d, Y');
}
?>
    <div class="spage-container job_work_diary">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <h3 class="title-page">Contracts</h3>
                   <?php
                        $parent = 'my_job';
                        $current = 'job_work_diary';
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
                                    <?php $my_job = list_jobs();
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
                            <a href="#" class="add-time" data-toggle="modal" data-target="#myModal">Add Manual Time</a>                        
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
                            <p class="total-time">Total Time Logged: <strong>03:30</strong></p>
                            <p class="auto-tracked">Auto-tracked: 03:30</p>
                            <p class="manual-time">Manual time: 00:00</p>
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
<!-- Modal -->
<div class="modal fade job-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Manual Time</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="add_manual_time_f" name="add_manual_time_f">
                    <div class="alert alert-success" role="alert">Success</div>
                    <div class="alert alert-warning" role="alert">Error</div>

                    <!-- <input type="hidden" id="project_id" value="<?=$_REQUEST['id']?>"> -->
                    <input type="hidden" id="user_id" value="<?=$_SESSION['user_id']?>">
                  <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Date</label>
                    <div class="col-sm-8">
                       <span class="date2add"></span> 
                       <input class="form-control" type="hidden" name="date2add" id="date2add">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Timezone</label>
                    <div class="col-sm-8">
                        <span class="timezone2add">UTC+00</span> 
                        <input class="form-control" type="hidden" name="timezone2add" id="timezone2add">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-sm-4 control-label">From</label>
                    <div class="col-sm-8">
                        <div class="row">
                          <div class="col-xs-5">                            
                            <select class="form-control time_select_box" name="stime2add" id="stime2add">
                                <option value="">Select</option>
                                <?php foreach ($every_10_minutes as $key_time => $value) : ?>
                                <option value="<?=$key_time?>"><?=$value?></option>
                                <?php endforeach; ?>
                            </select>                            
                          </div>
                          <div style="display: inline-block;float: left;padding: 3px 0; width: 15px;">To</div>
                          <div class="col-xs-5">                            
                            <select class="form-control time_select_box" name="etime2add" id="etime2add">
                                <option value="">Select</option>
                                <?php foreach ($every_10_minutes as $key_time => $value) : ?>
                                <option value="<?=$key_time?>"><?=$value?></option>
                                <?php endforeach; ?>
                            </select>                                
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-sm-4 control-label">Memo</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" rows="3" name="memo2add" id="memo2add"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                      <button type="submit" class="btn btn-default">Save</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </form>            
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
            $('#add_manual_time_f .alert').hide();

            $('#add_manual_time_f').submit(function(){
                var stime2add = $('#stime2add').val();
                var etime2add = $('#etime2add').val();
                var date2add = $('#date2add').val();
                var memo2add = $('#memo2add').val();
                var project_id = $('#select-pj').val();
                var user_id = $('#user_id').val();      
                if(stime2add == '' || etime2add == '') {
                    $('#add_manual_time_f .alert-warning').html("Please select start time and stop time");
                    $('#add_manual_time_f .alert-warning').show();
                    setTimeout(function(){
                        $('#add_manual_time_f .alert').fadeOut();
                    },3000);
                    return false;
                }
                if(memo2add == '') {
                    $('#add_manual_time_f .alert-warning').html("Please enter a Memo");
                    $('#add_manual_time_f .alert-warning').show();
                    setTimeout(function(){
                        $('#add_manual_time_f .alert').fadeOut();
                    },3000);
                    return false;
                }
                $.ajax({
                   url: '<?= $vpath; ?>ajax_action.php',
                   data: {action: 'add_manual_time', stime2add: stime2add, etime2add: etime2add, date2add: date2add, memo2add: memo2add, project_id: project_id, user_id: user_id},
                   success: function(data) {
                      var result = JSON.parse(data);
                      if(result.error) {
                        $('#add_manual_time_f .alert-warning').html(result.error);
                        $('#add_manual_time_f .alert-warning').show();
                      }
                      if(result.success) {
                        $('#add_manual_time_f .alert-success').html(result.success);
                        $('#add_manual_time_f .alert-success').show();

                        setTimeout(function(){
                            loadByDate($('#datepicker').val());
                            get_all_snap_dates();
                            $('#myModal').modal('hide');
                        }, 2000);
                      }
                        setTimeout(function(){
                            $('#add_manual_time_f .alert').fadeOut();
                        },3000);
                   }
                });
                return false;
            })
            
            function centerModal() {
                $(this).css('display', 'block');
                var $dialog = $(this).find(".modal-dialog");
                var offset = ($(window).height() - $dialog.height()) / 2;
                // Center modal vertically in window
                $dialog.css("margin-top", offset);
            }

            $('.modal').on('show.bs.modal', centerModal);
            $(window).on("resize", function () {
                $('.modal:visible').each(centerModal);
            });

            
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
        $('#date2add').val(val);
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
        $('#date2add').val($('#datepicker').val());
        $('.date2add').html($('#datepicker').val());
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