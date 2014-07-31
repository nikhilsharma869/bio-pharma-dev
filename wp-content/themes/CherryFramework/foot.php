	</div>
	<footer id="footer" class="footer">
	  	<div id="back-top-wrapper" class="visible-desktop">
	    	<p id="back-top">
		    	<a href="#top"><span></span></a>
		    </p>
	    </div>
		<div class="container">
    		<div class="row">
				<div id="widget-footer" class="footer-widgets clearfix">
					<?php if ( ! dynamic_sidebar( 'Footer' ) ) : ?>
						<!--Widgetized Footer-->
					<?php endif ?>
				</div>
			</div>
			<div id="copyright" class="copyright clearfix">
				<?php if ( of_get_option('footer_menu') == 'true') { ?>  
					<nav class="nav footer-nav">
						<?php wp_nav_menu( array(
							'container'       => 'ul',
							'depth'           => 0,
							'theme_location' => 'footer_menu' 
							)); 
						?>
					</nav>
				<?php } ?>
				<div id="footer-text" class="footer-text">
					<?php $myfooter_text = of_get_option('footer_text'); ?>
					
					<?php if($myfooter_text){?>
						<?php echo of_get_option('footer_text'); ?>
					<?php } else { ?>
						<a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>" class="site-name"><?php bloginfo('name'); ?></a> <?php _e('is proudly powered by', 'cherry'); ?> <a href="http://wordpress.org">WordPress</a> <a href="<?php if ( of_get_option('feed_url') != '' ) { echo of_get_option('feed_url'); } else bloginfo('rss2_url'); ?>" rel="nofollow" title="<?php _e('Entries (RSS)', 'cherry'); ?>"><?php _e('Entries (RSS)', 'cherry'); ?></a> and <a href="<?php bloginfo('comments_rss2_url'); ?>" rel="nofollow"><?php _e('Comments (RSS)', 'cherry'); ?></a>
						<a href="<?php echo home_url(); ?>/privacy-policy/" title="Privacy Policy"><?php _e('Privacy Policy', 'cherry'); ?></a>
					<?php } ?>
					<?php if( is_front_page() ) { ?>
						<!-- {%FOOTER_LINK} -->
					<?php } ?>
				</div>
			</div><!--/Copyright-->
		</div><!--/Container-->
	</footer>
</div><!--#main-->