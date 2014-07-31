<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */


?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php if ( get_header_image() ) : ?>
	<div id="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
		</a>
	</div>
	<?php endif; ?>

	<header id="masthead" class="site-header" role="banner">
			<div class="topBlock">
            	<div class="topMobileMenu">
                	<button><?php _e( 'Primary Menu', 'bio-pharma' ); ?></button>
                      
                </div>
            	<div class="topBlockLeft">
                	<ul>
                    	<li><a href="<?php echo site_url();?>/news/">News</a></li>
                    	<li><a href="<?php echo site_url();?>/blog/">Blog</a></li>    
                    	<li><a href="javascript:alert('Coming Soon!');">People</a></li>    
                    	<li><a href="javascript:alert('Coming Soon!');">White Papers</a></li>    
                    	<li><a href="javascript:alert('Coming Soon!');">Strategic Partners</a></li>    
					</ul>                	
                </div>

            	<div class="topBlockRight">
                	<a href="<?php echo site_url();?>/login/" class="login">Login</a>
                    <a href="javascript:alert('Coming Soon!');" class="icons"><img src="<?php echo get_template_directory_uri();?>/images/question-mark.png"></a>
                    <a href="javascript:alert('Coming Soon!');" class="icons"><img src="<?php echo get_template_directory_uri();?>/images/settings.png"></a>
                </div>
            </div>
            <div id="mobileMenu">
                <ul>
                    <li><a href="<?php echo site_url();?>/news/">News</a></li>
                    <li><a href="<?php echo site_url();?>/blog/">Blog</a></li>    
                    <li><a href="javascript:alert('Coming Soon!');">People</a></li>    
                    <li><a href="javascript:alert('Coming Soon!');">White Papers</a></li>    
                    <li><a href="javascript:alert('Coming Soon!');">Strategic Partners</a></li>    
                </ul>
            </div>
            <div class="header-main">
            	<div class="logo">
                	<a href="<?php echo site_url();?>"><img src="<?php echo get_template_directory_uri();?>/images/logo.png"></a>
                </div>
				<?php //wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
				<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<button class="menu-toggle"> <?php _e( 'Primary Menu', 'bio-pharma' ); ?></button>
				<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'twentyfourteen' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</nav>
            </div>

	</header><!-- #masthead -->

	<div id="main" class="site-main">
