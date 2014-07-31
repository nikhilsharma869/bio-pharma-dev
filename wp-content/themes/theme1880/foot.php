	</div>
	<footer id="footer" class="footer">
  	<div id="back-top-wrapper">
    	<p id="back-top">
        <a href="#top"><span></span></a>
      </p>
    </div>
		<div class="container">
	    	<div class="row">
				<div id="widget-footer" class="footer-widgets clearfix">
				
					<div class="span4 footer_left_img">
<!--						<div class="widget-inner">
							
						</div>-->
						
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer-bldg-image.png" alt="image" />
					</div>
				
					<?php if ( ! dynamic_sidebar( 'Footer' ) ) : ?>
						<!--Widgetized Footer-->
					<?php endif ?>
				</div>
				
				<div id="copyright" class="copyright clearfix">
					<?php if ( of_get_option('footer_menu') == 'true') { ?>  
						<nav class="nav footer-nav">
							<?php wp_nav_menu( array(
								'container'       => 'ul', 
								'menu_class'      => 'footer-nav',
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
							<?php bloginfo('name'); ?> &copy; <?php echo date("Y"); ?> &nbsp; | &nbsp; <a href="<?php echo home_url(); ?>/privacy-policy/" title="Privacy Policy"><?php _e('Privacy Policy', 'theme1880'); ?></a>
						<?php } ?>
						<?php if( is_front_page() ) { ?>
						<!-- {%FOOTER_LINK} -->
						<?php } ?>
					</div>
				</div>

				
			</div>

		</div><!--.container-->
	</footer>
</div><!--#main-->