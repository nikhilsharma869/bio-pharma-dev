<?php get_header(); ?>

<div class="container">
	<div id="content">
		<div class="row error404-holder">
			<div class="span7 error404-holder_num">404</div>
			<div class="span5">
				<hgroup>
				<?php echo '<h1>' . __('Sorry!', 'my_framework') . '</h1>'; ?>
				<?php echo '<h2>' . __('Page Not Found', 'my_framework') . '</h2>'; ?>
			  </hgroup>
			  <?php echo '<h4>' . __('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'my_framework') . '</h4>'; ?>
			  <?php echo '<p>' . __('Please try using our search box below to look for information on the internet.', 'my_framework') . '</p>'; ?>
			  <?php get_search_form(); /* outputs the default Wordpress search form */ ?>
			</div>
		</div><!--#error404 .post-->
	</div><!--#content-->
</div>
<?php get_footer(); ?>