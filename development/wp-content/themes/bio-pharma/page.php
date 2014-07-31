<?php
get_header(); ?>

<div id="main-content" class="main-content">
	<div class="borderBg"></div>
	<div class="banner">
    <?php 
	if ( get_post_meta(get_the_ID(),'slider_shortcode',true) <> ''){
		    echo do_shortcode( get_post_meta(get_the_ID(),'slider_shortcode',true) ); 
	}
	?>
    </div>
	<div class="centerPanel">
        <div id="primary">
			<?php
			while ( have_posts() ) : the_post();
			?>
			<h1><?php the_title();?></h1>
			<?php the_content();?>
			<?php endwhile;?>
        </div>
    
    	<?php get_sidebar();;?>
	</div><!--CenterPanel-->

</div><!-- #main-content -->

<?php
//
get_footer();
