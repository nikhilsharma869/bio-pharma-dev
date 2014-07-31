<?php
/**
 * Template Name: Fullwidth Page
 */

get_header(); ?>
	<div class="container">
		<div id="content">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('page fullwidth-page'); ?>>
				<?php if(has_post_thumbnail()) {
					echo '<a href="'; the_permalink(); echo '">';
				  	echo '<figure class="featured-thumbnail thumbnail">'; the_post_thumbnail(); echo '</figure>';
				  	echo '</a>';
				}
				the_content(); ?>
			</div><!--#post-->
	  	<?php endwhile; ?>
		</div><!--#content-->
	</div><!--.container-->  
<?php get_footer(); ?>