<?php
include "includes/header.php";
?>

    <div class="spage-container job_work_diary">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <h3 class="title-page">Contracts</h3>
                    <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                        <li><img class="job_icon" src="css/img/job_icon.png" alt=""/><a href="<?= $vpath ?>postjob.html">My Jobs</a></li>
                        <li class="active"><img class="active contract_icon" src="css/img/contract_icon.png" alt=""/><a href="<?= $vpath ?>postjob.html">Contracts</a></li>
                        <li><img class="work_icon"src="css/img/work_icon.png" alt=""/><a href="<?= $vpath ?>postjob.html">Work Diary</a></li>
                    </ul>
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right">
                        <div class="container">
                            <div class="sv-dropdown dd-name">
                                <div class="sv-dropSelect">Sr. Designer - myCS</div>
                                <ul>                                    
                                    <li>1</li>
                                    <li>2</li>
                                    <li>3</li>
                                    <li>4</li>
                                </ul>
                            </div>
                            <a href="#" class="add-time">Add Manual Time</a>                        
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
                                <input type="text" id="datepicker">
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
                        <div class="container">
                            <div class="working-raj">
                            <div class="left-content">
                                <div class="time first-time">
                                    <span class="time-title">7<br/>am</span>
                                    <span class="checkbox_icon"><input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                    <i class="fa"></i></span>
                                </div>
                                <div class="time">
                                    <span class="time-title">8<br/>am</span>
                                    <span class="checkbox_icon"><input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                    <i class="fa"></i></span>
                                </div>
                                <div class="time">
                                    <span class="time-title">9<br/>am</span>
                                    <span class="checkbox_icon"><input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                    <i class="fa"></i></span>
                                </div>
                                <div class="time">
                                    <span class="time-title">10<br/>am</span>
                                    <span class="checkbox_icon"><input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                    <i class="fa"></i></span>
                                </div>
                            </div>
                            <div class="right-content">
                                <div class="r-time">
                                    <h3>working with Raj</h3>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:10 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:20 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:30 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:40 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item last">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:50 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="r-time">
                                    <h3>working with Raj</h3>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:10 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:20 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:30 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:40 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item last">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:50 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="r-time">
                                    <h3>working with Raj</h3>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:10 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:20 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:30 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:40 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item last">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:50 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="r-time">
                                    <h3>working with Raj</h3>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:10 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:20 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:30 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="r-item">
                                        <img src="images/job_work_diary/edit_bott.jpg" alt=""/>
                                        <div class="r-item-bottom">                                             
                                            <span class="checkbox_icon">
                                            <input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                            <i class="fa"></i></span>
                                            <span class="time-title">7:40 am</span>
                                            <ul class="r-code">
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li></li>                                                
                                                <li></li>
                                                <li></li>
                                                <li></li>
                                                <li class="last-code"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>  
</div>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/jquery-ui.js"></script>  
<script>
    $(function() {
        //check box
        $(".checkbox_icon input[type='checkbox']").click(function(){ //alert('true');
            $(this).parents(".checkbox_icon").find(".fa").addClass("fa-chevron-down");
        });
        $(".checkbox_icon .fa").click(function(){
            $(this).removeClass("fa-chevron-down");
             $(".checkbox_icon input[type='checkbox']").attr('checked', false); 
        });
        //dropdown

        $(".sv-dropSelect").click(function(){
            $(this).parents(".sv-dropdown").find("ul").toggleClass("ul-active");
        });
         $(".sv-dropdown ul li").click(function(){
            var vItem = $(this).text();
            $(this).parents(".sv-dropdown").find(".sv-dropSelect").text(vItem);
            $(this).parents("ul").toggleClass("ul-active");
        });
         //datepicker
         $( "#datepicker" ).datepicker();
    });
</script>
<?php include 'includes/footer.php'; ?>