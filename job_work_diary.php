<?php
include "includes/header.php";

$current_date = date('D, M d, Y');

$every_10_minutes = hoursRange( 0, 86400, 60 * 10, 'h:i a' );

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
                            <div class="sv-dropdown dd-name">
                            <?php $my_job = list_jobs();
                                $count = 1;                                
                                foreach ($my_job as $job):
                                    if($count==1):?>
                                        <div class="sv-dropSelect" for="<?php echo $job['id']?>"><?php echo $job['project']?></div> 
                                    <ul> 
                                    <?php endif;?>                                   
                                    <li id="<?php echo $job['id']?>"><?php echo $job['project']?></li>
                                <?php $count++; endforeach;?>
                                    </ul>
                            </div>
                            <a href="#" class="add-time" data-toggle="modal" data-target="#myModal">Add Manual Time</a>                        
                        </div>
                        <div class="container">
                        <div class="time-zone">
                            <p>Time Zone</p>
                            <div class="sv-dropdown dd-timezone">
                                <div class="sv-dropSelect">Mine (UTC +8:00)</div>
                                <ul>
                                    <li>1</li>
                                    <li>2</li>
                                    <li>3</li>
                                    <li>4</li>
                                </ul>
                            </div>
                            <div class="datetime">
                                <input type="text" id="datepicker" value='' class="date2add">
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
                            <ul class="workdiary-tracker-list-snap">
                                <li class="snap-list-label">
                                    <h3>12</h3>
                                    <p>pm</p>
                                    <input id='snap_126ddYi3hbaLexIGn5' type='checkbox' data-check='12' class='css-input snap-list-check' />
                                    <label for='snap_126ddYi3hbaLexIGn5' class='css-label'></label>
                                </li>
                                <li data-workdiary-time='12' data-workdiary-memo='2' class='first-workdiary-snap first-li-workdiary-snap'>
                                    <span class='cwork-diary-label-memo'>Working with Raj</span>
                                    <img src='images/job_work_diary/edit_bott.jpg'>
                                    <input id='workdiary_snap6ddYi3hbaLexIGn5' type='checkbox' class='css-input workdiary_snap_check_box' />
                                    <label for='workdiary_snap6ddYi3hbaLexIGn5' class='css-label'>12:20 pm</label>
                                </li>
                                <li data-workdiary-time='12' data-workdiary-memo='2' class=''>
                                    <span class='cwork-diary-label-memo'>Working with Raj</span>
                                    <img src='images/job_work_diary/edit_bott.jpg'>
                                    <input id='workdiary_snapyz0yAHb50JRN3qrJ' type='checkbox' class='css-input workdiary_snap_check_box' />
                                    <label for='workdiary_snapyz0yAHb50JRN3qrJ' class='css-label'>12:30 pm</label>
                                </li>
                                <li data-workdiary-time='12' data-workdiary-memo='2' class=''>
                                    <span class='cwork-diary-label-memo'>Working with Raj</span>
                                    <img src='images/job_work_diary/edit_bott.jpg'>
                                    <input id='workdiary_snapR4isiiKX10ZGuelV' type='checkbox' class='css-input workdiary_snap_check_box' />
                                    <label for='workdiary_snapR4isiiKX10ZGuelV' class='css-label'>12:40 pm</label>
                                </li>
                                <li data-workdiary-time='12' data-workdiary-memo='2' class=''>
                                    <span class='cwork-diary-label-memo'>Working with Raj</span>
                                    <img src='images/job_work_diary/edit_bott.jpg'>
                                    <input id='workdiary_snapUslFMNuycP3cqfWf' type='checkbox' class='css-input workdiary_snap_check_box' />
                                    <label for='workdiary_snapUslFMNuycP3cqfWf' class='css-label'>12:50 pm</label>
                                </li>
                                <li data-workdiary-time='12' data-workdiary-memo='2' class=''>
                                    <span class='cwork-diary-label-memo'>Working with Raj</span>
                                    <img src='images/job_work_diary/edit_bott.jpg'>
                                    <input id='workdiary_snapU2slFMNuycP3cqfWf' type='checkbox' class='css-input workdiary_snap_check_box' />
                                    <label for='workdiary_snapU2slFMNuycP3cqfWf' class='css-label'>12:50 pm</label>
                                </li>
                            </ul>
                            <ul class="workdiary-tracker-list-snap" id="snap_test">
                                <li class="snap-list-label">
                                    <h3>08</h3><p>am</p>
                                    <input id="snap_08VxIxS8pPtRTPRcZQ" type="checkbox" data-check="08" class="css-input snap-list-check">
                                    <label for="snap_08VxIxS8pPtRTPRcZQ" class="css-label"></label>
                                </li>
                                <li date-workdiary-postion="0" data-workdiary-time="08" data-workdiary-memo="Working 1" class="first-li-workdiary-snap workdiary-snap-item">
                                    <span class="cwork-diary-label-memo">Working 1</span>
                                    <img src="images/job_work_diary/edit_bott.jpg">
                                    <input id="workdiary_snapVxIxS8pPtRTPRcZQ" type="checkbox" class="css-input workdiary_snap_check_box">
                                    <label for="workdiary_snapVxIxS8pPtRTPRcZQ" class="css-label">08:00 am</label>
                                </li>
                                <li date-workdiary-postion="1" data-workdiary-time="08" data-workdiary-memo="Working 1" class=" workdiary-snap-item">
                                    <span class="cwork-diary-label-memo">Working 1</span>
                                    <img src="images/job_work_diary/edit_bott.jpg">
                                    <input id="workdiary_snapBsySiv2x8yZs1lxi" type="checkbox" class="css-input workdiary_snap_check_box">
                                    <label for="workdiary_snapBsySiv2x8yZs1lxi" class="css-label">08:10 am</label>
                                </li>
                                <li date-workdiary-postion="2" data-workdiary-time="08" data-workdiary-memo="Working 1" class=" workdiary-snap-item">
                                    <span class="cwork-diary-label-memo">Working 1</span>
                                    <img src="images/job_work_diary/edit_bott.jpg">
                                    <input id="workdiary_snapTV0Q5v5TxE1pg8Ay" type="checkbox" class="css-input workdiary_snap_check_box">
                                    <label for="workdiary_snapTV0Q5v5TxE1pg8Ay" class="css-label">08:20 am</label>
                                </li>
                                <li date-workdiary-postion="3" data-workdiary-time="08" data-workdiary-memo="Working 1" class="last-workdiary-snap  workdiary-snap-item">
                                    <span class="cwork-diary-label-memo">Working 1</span><img src="images/job_work_diary/edit_bott.jpg">
                                    <input id="workdiary_snapLsNrX9yxNCoFRiEB" type="checkbox" class="css-input workdiary_snap_check_box">
                                    <label for="workdiary_snapLsNrX9yxNCoFRiEB" class="css-label">08:30 am</label>
                                </li>
                                <li date-workdiary-postion="4" data-workdiary-time="08" data-workdiary-memo="Working 2" class="first-workdiary-snap  workdiary-snap-item">
                                    <span class="cwork-diary-label-memo">Working 2</span><img src="images/job_work_diary/edit_bott.jpg">
                                    <input id="workdiary_snapow5l6biPOsw8HW9N" type="checkbox" class="css-input workdiary_snap_check_box">
                                    <label for="workdiary_snapow5l6biPOsw8HW9N" class="css-label">08:40 am</label>
                                </li>
                                <li date-workdiary-postion="5" data-workdiary-time="08" data-workdiary-memo="Working 2" class=" workdiary-snap-item">
                                    <span class="cwork-diary-label-memo">Working 2</span><img src="images/job_work_diary/edit_bott.jpg">
                                    <input id="workdiary_snapsk88kGIqzHQUEYtX" type="checkbox" class="css-input workdiary_snap_check_box">
                                    <label for="workdiary_snapsk88kGIqzHQUEYtX" class="css-label">08:50 am</label>
                                </li>
                            </ul>
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

                    <input type="hidden" id="project_id" value="<?=$_REQUEST['id']?>">
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
            $(".time_select_box").chosen();
            $('.alert').hide();

            $('#add_manual_time_f').submit(function(){
                var stime2add = $('#stime2add').val();
                var etime2add = $('#etime2add').val();
                var date2add = $('#date2add').val();
                var memo2add = $('#memo2add').val();
                var project_id = $('#project_id').val();
                var user_id = $('#user_id').val();      
                if(stime2add == '' || etime2add == '') {
                    $('.alert-warning').html("Please select start time and stop time");
                    $('.alert-warning').show();
                    setTimeout(function(){
                        $('.alert').fadeOut();
                    },3000);
                    return false;
                }
                if(memo2add == '') {
                    $('.alert-warning').html("Please enter a Memo");
                    $('.alert-warning').show();
                    setTimeout(function(){
                        $('.alert').fadeOut();
                    },3000);
                    return false;
                }
                $.ajax({
                   url: '<?= $vpath; ?>ajax_action.php',
                   data: {action: 'add_manual_time', stime2add: stime2add, etime2add: etime2add, date2add: date2add, memo2add: memo2add, project_id: project_id, user_id: user_id},
                   success: function(data) {
                      var result = JSON.parse(data);
                      if(result.error) {
                        $('.alert-warning').html(result.error);
                        $('.alert-warning').show();
                      }
                      if(result.success) {
                        $('.alert-success').html(result.success);
                        $('.alert-success').show();
                        setTimeout(function(){
                            $('#myModal').modal('hide');
                        }, 4000);
                      }
                        setTimeout(function(){
                            $('.alert').fadeOut();
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
      $(function() {
        $( "#datepicker" ).datepicker( "option", "dateFormat", "D, M dd, yy" ); 
        $( "#datepicker" ).datepicker( "setDate", "<?=$current_date?>" );
        $('#date2add').val($('#datepicker').val());
        $('.date2add').html($('#datepicker').val());
        $( "#datepicker" ).on('change', function(){
            $('#date2add').val($(this).val());
            $('.date2add').html($(this).val());
            $.ajax({
                   url: '<?= $vpath; ?>ajax_action.php',
                   data: {action: 'load_work_diary', project_id: '<?=$_REQUEST['id']?>', user_id: '<?=$_SESSION['user_id']?>', load_date: $(this).val()},
                   success: function(data) {
                      $('#workdiary-tracker-containter').html(data);
                   }
                });
        })
      });
    </script>
<?php include 'includes/footer.php'; ?>