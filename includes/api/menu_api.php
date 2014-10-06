<?php
function get_child_menu($parent, $current, $current_sub) {
	// Config child menu

	$menuArr = array(
		'find_work' => array(
			'find_job' => array(
				'title'=> 'Find Job',
				'a_href' => 'Jobs',
				'sub' => array(
					'find_job' => array(
						'title'=> 'Find Job',
						'a_href' => 'Jobs'
						),
					'save_job' => array(
						'title'=> 'Save Job',
						'a_href' => 'Jobs'
						),
					'job_application' => array(
						'title'=> 'Job Application',
						'a_href' => 'job_application.html'
						)
					)
				),
			'save_job' => array(
				'title'=> 'Save Job',
				'a_href' => 'saved_job.html'
				),
			'job_application' => array(
				'title'=> 'Job Application',
				'a_href' => 'job_application.html'
				)
		),
		'my_job' => array(

		),
	);

	$menus = $menuArr[$parent];
	?>
	<ul id="up-tabs" class="nav nav-tabs" role="tablist">
		<?php foreach($menus as $key => $menu) : ?>
			<li <?php if($current == $key ) echo "class='active'"?>><a href="<?= $vpath.$menu['a_href'] ?>"><?php echo $menu['title'] ?></a></li>
				<?php if(isset($menu['sub']) && $current_sub !='') : ?>
					<ul class="child_menu">
					<?php foreach($menu['sub'] as $key_sub => $menu_sub) : ?>
						<li <?php if($current_sub == $key_sub ) echo "class='active'"?>>
							<a href="<?= $vpath.$menu_sub['a_href'] ?>"><?php echo $menu_sub['title'] ?></a>
						</li>
					<?php endforeach; ?>
					</ul>		
				<?php endif;?>
		<?php endforeach; ?>
	</ul>
	<?php
}