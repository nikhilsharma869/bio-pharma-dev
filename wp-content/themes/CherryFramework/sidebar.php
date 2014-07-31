<aside id="sidebar" class="sidebar span4">
	<?php if ( ! dynamic_sidebar( 'Sidebar' )) : ?>
		<div id="sidebar-search" class="widget">
			<?php echo '<h3>' . __('Search', 'cherry') . '</h3>'; ?>
			<?php get_search_form(); ?> <!-- outputs the default Wordpress search form-->
		</div>
  
		<div id="sidebar-nav" class="widget menu">
			<?php echo '<h3>' . __('Navigation', 'cherry') . '</h3>'; ?>
			<?php wp_nav_menu( array('menu' => 'Sidebar Menu' )); ?> <!-- editable within the Wordpress backend -->
		</div>
  
		<div id="sidebar-archives" class="widget">
			<?php echo '<h3>' . __('Archives', 'cherry') . '</h3>'; ?>
			<ul>
				<?php wp_get_archives( 'type=monthly' ); ?>
			</ul>
		</div>

		<div id="sidebar-meta" class="widget">
			<?php echo '<h3>' . __('Meta', 'cherry') . '</h3>'; ?>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</div>
	<?php endif; ?>
</aside><!--sidebar-->