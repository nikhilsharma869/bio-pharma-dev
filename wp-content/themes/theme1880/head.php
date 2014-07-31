<link rel="icon" type="image/png" href="http://bio-pharma.com/wp-content/uploads/2013/04/favicon.png">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.watermark.js"></script>

<script>
jQuery(document).ready(function() {
	jQuery('body.ask-question #question-title-td input[type="text"]').watermark('Title');
	jQuery('#question-tags').watermark('Tags:');
	jQuery('.head_bottom_nav ul').mobileMenu({
		className: 'sub_nav_dropdown'
	});
});
</script>

<div id="main" class="main-holder"><!-- this encompasses the entire Web site -->
	<header id="header" class="header">
		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/header-contact.png" alt="image" class="header_contact_img" />
	
		<!--<div class="container">-->
		
			<div class="head_top">
			
				<!-- BEGIN LOGO -->			
				<div class="logo pull-left">
					<?php if(of_get_option('logo_type') == 'text_logo'){?>
						<?php if( is_front_page() || is_home() || is_404() ) { ?>
							<h1 class="logo_h logo_h__txt"><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>" class="logo_link"><?php bloginfo('name'); ?></a></h1>
						<?php } else { ?>
							<h2 class="logo_h logo_h__txt"><a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>" class="logo_link"><?php bloginfo('name'); ?></a></h2>
						<?php } ?>
						<!-- Site Tagline -->
						<p class="logo_tagline"><?php bloginfo('description'); ?></p>
						
					<?php } else { ?>
						<?php if(of_get_option('logo_url') != ''){ ?>
							<a href="<?php echo home_url(); ?>/" class="logo_h logo_h__img"><img src="<?php echo of_get_option('logo_url', "" ); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('description'); ?>"></a>
						<?php } else { ?>
							<a href="<?php echo home_url(); ?>/" class="logo_h logo_h__img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('description'); ?>"></a>
						<?php } ?>
					<?php }?>
					
				</div>
				<!-- END LOGO -->
					
				
				<?php if ( of_get_option('g_search_box_id') == 'yes') { ?>
				<!-- BEGIN SEARCH FORM -->  
				<div class="search-form search-form__h hidden-phone clearfix">
					<form id="search-header" class="navbar-form pull-right" method="get" action="<?php echo home_url(); ?>/" accept-charset="utf-8">
						<input type="text" name="s" placeholder="<?php _e('Search', 'theme1880'); ?>" class="search-form_it"> <input type="submit" value="<?php _e('Go', 'theme1880'); ?>" id="submit" class="search-form_is btn btn-primary">
					</form>
				</div>  
				<!-- END SEARCH FORM -->
				<?php } ?>
				
				<?php 
				//echo "<pre>";
				//print_r(of_get_option);
				?>
				
				<div class="right">
				
					<div class="pull-right">
						<!--<div class="static-mail"><a href="mailto:contact@bio-pharma.com">contact@bio-pharma.com</a></div>
						<div class="static-phone">410 980 2823</div>-->
						<!--<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/header-contact-image.png" alt="image" />-->
					</div><!--//pull-right-->					
					
					<div class="clear"></div>
				
					<div class="new_head_nav_cont" style="DISPLAY: NONE;">
						<!-- BEGIN MAIN NAVIGATION -->
						<nav class="nav nav__primary clearfix">
							<?php wp_nav_menu( array(
								'container'       => 'ul', 
								'menu_class'      => 'sf-menu static-menu', 
								'menu_id'         => 'topnav',
								'depth'           => 0,
								'theme_location'  => 'header_menu'
								)); 
							?>
						</nav>
						<!-- END MAIN NAVIGATION -->
					</div><!--//new_head_nav_cont-->
					
				</div><!--//right-->
				
				<div class="clear"></div>
				
			</div><!--//head_top-->
			
<!--			
<ul class="static-menu">
<li><a href="">Project Management</a></li>
<li><a href="">Management Consulting</a></li>
<li><a href="">Commissioning</a></li>
<li><a href="">Validation</a></li>
<li><a href="">Compliance</a></li>
<li class="last"><a href="">Regulatory Submissions</a></li>
</ul>-->

				<?php /*wp_nav_menu( array(
					'container'       => 'ul', 
					'menu_class'      => 'static-menu', 
					//'menu_id'         => 'topnav',
					'depth'           => 0,
					'theme_location'  => 'header_menu'
					)); */
				?>
<!--
<select class="static-menu-dropdown">
<option>Project Management</option>
<option>Management Consulting</option>
<option>Commissioning</option>
<option>Validation</option>
<option>Compliance</option>
<option>Regulatory Submissions</option>
</select>
-->

			<div class="clear"></div>

		<!--</div>--><!--.container-->
		
		<div class="head_bottom_nav">
			<div class="container">
				<ul>
					<li><a href="<?php bloginfo('url'); ?>">About Us</a></li>
					<li><a href="http://bio-pharma.com/management-consulting/">Management Consulting</a></li>
					<li><a href="http://bio-pharma.com/wiki">My Wiki</a></li>
					<li><a href="http://bio-pharma.com/talent-sourcing">Talent Sourcing</a></li>
					<li><a href="#">Industrial Training</a></li>
					<li><a href="http://bio-pharma.com/questions/ask-an-expert/">Ask An Expert</a></li>
				</ul>
				<div class="clear"></div>
			</div><!--//container-->
		</div><!--//head_bottom_nav-->		
		
	</header>
	
		 <?php // echo do_shortcode( '[royal_slider]' ) ?>
		 
	<?php if(is_front_page() || is_page(1955)) { ?>
		 
	 <?php echo do_shortcode( '[wp_responsive_slider]' ); ?>
	 
	 <?php } ?>
	 
	 <?php if( is_page_template('tpl-management-consulting.php') ) { ?>
	 
		 <div class="mc_featured_full">
			<div class="container">
				<div class="row">
					<div class="text_center">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mc-featured-image.png" alt="image" />
					</div>
				</div>
			</div><!--//container-->
		 </div><!--//mc_featured_full-->
		 
	<?php } ?>
	 
	 <?php if( is_page_template('tpl-homepage-new.php') || is_page_template('tpl-management-consulting.php') ) { ?>
	 
		 <div class="bottom_slider">
			<div class="container">
				
				<div class="bottom_slider_left">
					<div class="bs_left_text">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/loved-by-text.png" alt="image" />
					</div>
					<div style="float: left;">
						<ul>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/saic-logo.png" alt="image" /></li>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/nat-inst-health-logo.png" alt="image" /></li>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/medimmune-logo.png" alt="image" /></li>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/bd-logo.png" alt="image" /></li>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pda-logo.png" alt="image" /></li>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ispe-logo.png" alt="image" /></li>
						</ul>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div><!--//bottom_slider_left-->
				
				<div class="bottom_slider_right">
					<div class="bs_right_text">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/be-our-buddy-text.png" alt="image" />
					</div>
					<div style="float: left;">
						<ul>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rss-icon.png" alt="rss" /></li>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/twitter-icon.png" alt="twitter" /></li>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/facebook-icon.png" alt="facebook" /></li>
							<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gplus-icon.png" alt="google plus" /></li>
						</ul>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div><!--//bottom_slider_right-->
				
			</div><!--//container-->
		 </div><!--//bottom_slider-->
		
	<?php } ?>
	 
	 <?php  //echo do_shortcode( '[responsiveslider]' ) ?> 
	 <?php //echo ctslider_slider_template( $id ); ?>
	
	<div class="content-holder clearfix">