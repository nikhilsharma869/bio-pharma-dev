<?php get_header(); ?>
	<?php get_template_part('title'); ?>
	<div class="container">
		<div class="row">	
			<div id="content" class="span8 <?php echo of_get_option('blog_sidebar_pos') ?>">
			<?php if (have_posts()) : while (have_posts()) : the_post(); 
				// The following determines what the post format is and shows the correct file accordingly
				$format = get_post_format();
				get_template_part( 'includes/post-formats/'.$format );
					
				if($format == '')
				get_template_part( 'includes/post-formats/standard' );					
			 	endwhile; else:			 
			?>			 
			<div class="no-results">
				<?php echo '<p><strong>' . __('There has been an error.', 'cherry') . '</strong></p>'; ?>
				<p><?php _e('We apologize for any inconvenience, please', 'cherry'); ?> <a href="<?php echo home_url(); ?>/" title="<?php bloginfo('description'); ?>"><?php _e('return to the home page', 'cherry'); ?></a> <?php _e('or use the search form below.', 'cherry'); ?></p>
				<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
			</div><!--no-results-->			
			<?php endif; ?>	    
	  		<?php get_template_part('includes/post-formats/post-nav'); ?>	  
			</div><!--#content-->
    		<?php get_sidebar(); ?>
		</div><!--.row-->
	</div><!--.container-->   
<?php get_footer(); ?>