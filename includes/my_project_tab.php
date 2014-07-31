<ul class="tabs">      
                
				
				<!--<li><a href="<?=$vpath?>my-jobs.html"  rel="tabs1">
          <?=$lang['MY_PROJECTS']?>
          </a></li>-->
		  <? if($p==1){?>
		  
		   <? //if(fetbidcount($_SESSION['user_id'])>0){?>
        <li><a href="<?=$vpath?>mybids.html" rel="tabs2" <? if($selectid==6){?>class="selected" <? }?>>
          <?=$lang['MY_BIDS']?>
          </a></li>
		   <li><a href="<?=$vpath?>working_jobs.html" rel="tabs2" <? if($selectid==7){?>class="selected" <? }?>>
          <?=$lang['WORKING_PROJECTS']?>
          </a></li>
		  <li><a href="<?=$vpath?>completed_jobs.html" rel="tabs2" <? if($selectid==8){?>class="selected" <? }?>>
          <?=$lang['COMPLETE_PROJECTS']?>
          </a></li>
        <!--<li><a href="<?=$vpath?>lostbids.html" rel="tabs2" <? if($selectid==7){?>class="selected" <? }?>>
          <?=$lang['LOST_BIDS']?>
          </a></li>--><? //}?>
		  <? }else{?>
        <li><a href="<?=$vpath?>active_jobs.html" rel="tabs2" <? if($selectid==1){?>class="selected" <? }?>>
          <?=$lang['OPEN_PROJECTS']?>
          </a></li>
		   <li><a href="<?=$vpath?>frozen_project.html" rel="tabs2" <? if($selectid==2){?>class="selected" <? }?>>
          <?=$lang['FROZEN_PROJECTS']?>
          </a></li>
        <li><a href="<?=$vpath?>running_jobs.html" rel="tabs2" <? if($selectid==3){?>class="selected" <? }?>>
          <?=$lang['WORKING_PROJECTS']?>
          </a></li>
       <!-- <li><a href="<?=$vpath?>closed_jobs.html" rel="tabs2" <? if($selectid==3){?>class="selected" <? }?>>
          <?=$lang['CANCELED_PROJECTS']?>
          </a></li>-->
		  <li><a href="<?=$vpath?>expire_project.html" rel="tabs2" <? if($selectid==4){?>class="selected" <? }?>>
          Expire Projects
          </a></li>
           <li><a href="<?=$vpath?>closed_jobs.html" rel="tabs2" <? if($selectid==5){?>class="selected" <? }?>>
          <?=$lang['COMPLETE_PROJECTS']?>
          </a></li>
		 
		  <? }?>
		
              </ul>