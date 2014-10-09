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
			'my_job' => array(
				'title'=> 'My Job',
				'a_href' => 'my_jobs_sme.html'
				),
			'contracts' => array(
				'title'=> 'Contracts',
				'a_href' => 'contracts.html'
				),
			'job_work_diary' => array(
				'title'=> 'Work Diary',
				'a_href' => 'job_work_diary.html'
				)
		),
		
		'manage_my_team' => array(
			'my_team' => array(
				'title'=> 'My team',
				'a_href' => 'manage_my_team/',
				'sub' => array(
					'hired' => array(
						'title'=> 'Hired',
						'a_href' => 'manage_my_team/'
						),
					'pasthired' => array(
						'title'=> 'Past Hires',
						'a_href' => 'mysmes_pasthires/'
						),
					'messages' => array(
						'title'=> 'Messages',
						'a_href' => 'mysmes_message.html'
						),
					'saved' => array(
						'title'=> 'Saved',
						'a_href' => 'mysmes_saved.html'
						)
					)
				),
			'work_diary' => array(
				'title'=> 'Work Diary',
				'a_href' => 'mysmes_workdiary.html'
				),
			'contracts' => array(
				'title'=> 'Contracts',
				'a_href' => 'mysmes_contracts.html'
				),
			'activities' => array(
				'title'=> 'Activities',
				'a_href' => 'mysmes_activities.html'
				)
		),
		
		'client_report' => array(
			'report_weekly_summary' => array(
				'title'=> 'Weekly Summary',
				'a_href' => 'reports_weekly_summary.html'
				),
			'report_transaction_history' => array(
				'title'=> 'Transaction History',
				'a_href' => 'reports_transaction_history.html'
				),
			'reports_work_summary' => array(
				'title'=> 'Work Summary',
				'a_href' => 'reports_work_summary.html'
				),
			'reports_activity_summary' => array(
				'title'=> 'Activity Summary',
				'a_href' => 'reports_activity_summary.html'
				)
		),
		
	);

	$menus = $menuArr[$parent];
	?>
	<ul id="up-tabs" class="nav nav-tabs" role="tablist">
		<?php foreach($menus as $key => $menu) : ?>
			<li <?php if($current == $key ) echo "class='active'"?>><a href="<?= $vpath.$menu['a_href'] ?>"><?php echo $menu['title'] ?></a></li>
				<?php if(isset($menu['sub']) && $current_sub !='') : ?>
					<ul class="child_menu" >
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