<div class="linkedin"><div class="profile">
<div id ="cartouche" class="section">
	<a href="<?php echo esc_url($profile->publicProfileUrl); ?>"><img class="picture" src="<?php echo $profile->pictureUrl; ?>" width="80px" /></a>
	<div class="name"><a href="<?php echo esc_url($profile->publicProfileUrl); ?>"><?php echo $profile->firstName; ?> <?php echo $profile->lastName; ?></a></div>
	<div class="headline"><?php echo $profile->headline; ?></div>
	<div class="location"><?php echo $profile->location->name; ?> | <?php echo $profile->industry; ?></div>
</div>

<?php if (isset($profile->summary)): ?>
<div id="summary" class="section">
<div class="heading"><?php _e('Summary', 'wp-linkedin'); ?></div>
<div class="summary"><?php echo wpautop($profile->summary); ?></div>
</div>
<?php endif; ?>

<?php if (isset($profile->specialties)): ?>
<div id="specialties" class="section">
<div class="heading"><?php _e('Specialties', 'wp-linkedin'); ?></div>
<div class="specialties"><?php echo wpautop($profile->specialties); ?></div>
</div>
<?php endif; ?>

<?php if (isset($profile->positions->values) && is_array($profile->positions->values)): ?>
<div id="positions" class="section">
<div class="heading"><?php _e('Experience', 'wp-linkedin'); ?></div>
<?php foreach ($profile->positions->values as $v): ?>
<div class="position">
	<div class="title"><strong><?php echo $v->title; ?></strong> (<?php echo $v->startDate->year; ?> - <?php echo isset($v->endDate) ? $v->endDate->year : __('Present', 'wp-linkedin'); ?>)</div>
	<div class="company"><?php echo $v->company->name; ?></div>
	<div class="industry"><?php if (isset($v->company->type)) { echo $v->company->type.', '; } if (isset($v->company->size)) { echo $v->company->size.', '; } echo $v->company->industry; ?></div>
	<?php if (isset($v->summary)): ?>
		<div class="summary"><?php echo wpautop($v->summary); ?></div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (isset($profile->projects->values) && is_array($profile->projects->values)): ?>
<div id="projects" class="section">
<div class="heading"><?php _e('Projects', 'wp-linkedin'); ?></div>
<?php foreach ($profile->projects->values as $v): ?>
<div class="project"><?php
	$name = $v->name;
	if (!empty($v->url)) $name = "<a href=\"{$v->url}\" target=\"_blank\">{$v->name}</a>";
	?>
	<div class="title"><strong><?php echo $name; ?></strong> (<?php echo $v->startDate->year; ?> - <?php echo isset($v->endDate) ? $v->endDate->year : __('Present', 'wp-linkedin'); ?>)</div>
	<?php if (isset($v->members->values) && is_array($v->members->values) && count($v->members->values) > 1): ?>
	<div class="project-members">
		<div class="members-count"><?php printf(__('%d team members', 'wp-linkedin'), count($v->members->values)); ?></div><?php
		foreach ($v->members->values as $m):
			$p = isset($m->person) ? $m->person : null;
			$pictureUrl = (isset($p->pictureUrl)) ? $p->pictureUrl : 'http://www.gravatar.com/avatar/?s=80&f=y&d=mm';

			if (isset($m->name)) {
				$name = $m->name;
			} elseif ($p->publicProfileUrl) {
				$name = $p->firstName . ' ' . $p->lastName;
			} else {
				$name = __('Anonymous', 'wp-linkedin');
			}

			if (isset($p->headline)) $name .= ' - ' . $p->headline;

			if (isset($p->publicProfileUrl)): ?>
				<a href="<?php echo esc_url($p->publicProfileUrl); ?>"
					target="_blank"><img src="<?php echo esc_url($pictureUrl); ?>"
					alt="<?php echo $name; ?>" title="<?php echo $name; ?>"></a><?php
			else: ?>
				<img src="<?php echo esc_url($pictureUrl); ?>"
					alt="<?php echo $name; ?>" title="<?php echo $name; ?>"><?php
			endif;
		endforeach; ?>
	</div>
	<?php endif; ?>
	<?php if (isset($v->description)): ?>
	<div class="summary"><?php echo wpautop($v->description); ?></div>
	<?php endif; ?>
	</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (isset($profile->volunteer->volunteerExperiences->values) && is_array($profile->volunteer->volunteerExperiences->values)): ?>
<div id="volunteer-experiences" class="section">
<div class="heading"><?php _e('Volunteer Experiences', 'wp-linkedin'); ?></div>
<?php foreach ($profile->volunteer->volunteerExperiences->values as $v): ?>
<div class="volunteer">
	<div class="role"><strong><?php echo $v->role; ?></strong><?php if (isset($v->startDate)): ?>
		(<?php echo $v->startDate->year; ?> - <?php echo isset($v->endDate) ? $v->endDate->year : __('Present', 'wp-linkedin'); ?>)
	<?php endif; ?></div>
	<div class="organization"><?php echo $v->organization->name; ?></div>
	<?php if (isset($v->cause)): ?>
		<div class="cause"><?php echo wp_linkedin_cause($v->cause->name); ?></div>
	<?php endif; ?>
	<?php if (isset($v->description)): ?>
		<div class="summary"><?php echo wpautop($v->description); ?></div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (isset($profile->skills->values) && is_array($profile->skills->values)): ?>
<div id="skills" class="section">
<div class="heading"><?php _e('Skills &amp; Expertise', 'wp-linkedin'); ?></div>
<?php
$skills = array();
foreach ($profile->skills->values as $v) {
	$skills[] = '<span class="skill">'.$v->skill->name.'</span>';
} ?>
<p><?php echo implode(', ', $skills); ?></p>
</div>
<?php endif;?>

<?php if (isset($profile->languages->values) && is_array($profile->languages->values)): ?>
<div id="languages" class="section">
<div class="heading"><?php _e('Languages', 'wp-linkedin'); ?></div>
<ul>
<?php foreach ($profile->languages->values as $v): ?>
<li class="language"><?php echo $v->language->name; ?><?php
	if (isset($v->proficiency)):
		echo "<span class=\"proficiency\">{$v->proficiency->name}</span>";
	endif; ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif;?>

<?php if (isset($profile->educations->values) && is_array($profile->educations->values)): ?>
<div id="educations" class="section">
<div class="heading"><?php _e('Education', 'wp-linkedin'); ?></div>
<?php foreach ($profile->educations->values as $v): ?>
<div class="education">
	<div class="school"><strong><?php echo $v->schoolName; ?></strong> (<?php echo $v->startDate->year; ?> - <?php echo isset($v->endDate) ? $v->endDate->year : __('Present', 'wp-linkedin'); ?>)</div>
	<div class="degree"><?php echo $v->degree; ?>, <?php echo $v->fieldOfStudy; ?></div>
	<?php if (isset($v->activities) && !empty($v->activities)): ?>
		<div class="activities"><em><?php _e('Activities and societies', 'wp-linkedin'); ?>:</em> <?php echo $v->activities; ?></div>
	<?php endif; ?>
	<?php if (isset($v->notes) && !empty($v->notes)): ?>
		<div class="notes"><?php echo wpautop($v->notes); ?></div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (isset($profile->recommendationsReceived->values) && is_array($profile->recommendationsReceived->values)): ?>
<div id="recommendations" class="section">
<div class="heading"><?php _e('Recommendations', 'wp-linkedin'); ?></div>
<?php foreach ($profile->recommendationsReceived->values as $v): ?>
<blockquote>
	<div class="recommendation"><?php  echo nl2br($v->recommendationText); ?></div>
	<div class="recommender"><?php if (isset($v->recommender->publicProfileUrl)): ?>
		<a href="<?php echo esc_url($v->recommender->publicProfileUrl); ?>"
		target="_blank"><?php echo $v->recommender->firstName; ?>
		<?php echo $v->recommender->lastName; ?></a>
		<?php else: ?>
		<?php  _e('Anonymous', 'wp-linkedin'); ?>
	<?php endif; ?></div>
</blockquote>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div></div>
