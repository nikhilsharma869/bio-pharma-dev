<aside id="sidebar">

            <div class="side-options">

                <ul class="list-unstyled">

                    <li>

                        <a href="#" id="collapse-nav" class="act act-primary tip" title="Collapse navigation">

                            <i class="icon16 i-arrow-left-7"></i>

                        </a>

                    </li>

                </ul>

            </div>



            <div class="sidebar-wrapper">

                <nav id="mainnav">

                    

                    

                    

               <ul class="nav nav-list">

                        <li>

                            <a href="dashboard.php">

                                <span class="icon"><i class="icon20 i-screen"></i></span>

                                <span class="txt">Dashboard</span>

                            </a>

                        </li>

	<?php

	

	$rws=mysql_query("select * from " . $prev . "adminmenu where status='Y' and parent_id=0  order by ord");

	while($rw=mysql_fetch_row($rws))

	{

		

		?>

          <li>

                            <a href="#">

                                <span class='icon'><i class='icon20 i-menu-6'></i></span>

                                <span class="txt"><?=$rw[1]?></span>

                            </a>

                         <?

                         $rs=mysql_query("select * from " . $prev . "adminmenu where status='Y' and parent_id=".$rw[0]." order by ord");

		if(@mysql_num_rows($rs))

		{

						 

						 

						 ?>   

                          <ul class="sub">

                          <?

                          	while($r=mysql_fetch_row($rs))

			{

						  

						  ?>

                                <li>

                                    <a href="<?=$r[2]?>">

                                        <span class="icon"><i class="icon20 i-stack-list"></i></span>

                                        <span class="txt"><?=$r[1]?></span>

                                    </a>

                                </li>

                               

                               <? }?>

                            </ul>

                            <? }?>

                        </li>

        <?

        

        

	}

	

	?>
							    <li>
                                    <a href="<?php echo $vpath;?>admin_new/fbo-import.php">
                                        <span class="icon"><i class="icon20 i-stack-list"></i></span>
                                        <span class="txt">FBO Projects Import</span>
                                    </a>
                                </li>


</ul>

                </nav> 

                </div> <!-- end.sidebar-widget--> 



         </div>  <!--# End .spark-stats-->

        </aside>