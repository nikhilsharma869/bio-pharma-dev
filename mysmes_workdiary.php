<?php
include "includes/header.php";
?>

    <div class="spage-container job_work_diary" id="manageMyTeam_workDiary">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                     <?php
                        $parent = 'manage_my_team';
                        $current = 'my_team';
                        $current_sub = 'work_diary';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
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

  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/jquery-ui.js"></script>  
<?php include 'includes/footer.php'; ?>