<?php
/*
	Template Name: Talent Sourcing
*/
?>
<?php get_header(); ?>
	<?php //get_template_part('title'); ?>
	
	<div class="job_search_cont">
		<?php echo do_shortcode('[wpjb_search]'); ?>
	</div><!--//job_search_cont-->	
	
	<div class="job_search_bottom_cont">
		Hundreds of Medical Jobs to choose in different categories and states
	</div><!--//job_search_bottom_cont-->
	
	<div class="container talent_sourcing_container">

	
		<div class="row">		
			<div id="content" class="span9 <?php echo of_get_option('blog_sidebar_pos') ?>">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
				  	<article class="post-holder">
					<?php if(has_post_thumbnail()) {
						echo '<a href="'; the_permalink(); echo '">';
						echo '<figure class="featured-thumbnail thumbnail">'; the_post_thumbnail(); echo '</figure>';
						echo '</a>';
					} ?>
						<div id="page-content">
						  	<?php the_content(); ?>							
						</div><!--#pageContent -->
				  	</article>
				</div><!--#post-# .post-->
			  	<?php endwhile; ?>
			</div><!--#content-->
			<?php get_sidebar('talent'); ?>
	    </div><!--.row-->
	</div><!--.container-->  
<?php get_footer(); ?>