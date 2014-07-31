<?php get_header(); ?>
<div class="container container_single_post">
	<div class="row">		
		<div id="content" class="span8 <?php echo of_get_option('blog_sidebar_pos') ?> clearfix">			
			<div class="wrapper">
				<?php if (have_posts()) : while (have_posts()) : the_post(); 				
					// The following determines what the post format is and shows the correct file accordingly
					$format = get_post_format();
					get_template_part( 'includes/post-formats/'.$format );					
					if($format == '')
						get_template_part( 'includes/post-formats/standard' );
						get_template_part( 'includes/post-formats/share-buttons' );
						wp_link_pages('before=<div class="pagination">&after=</div>');
				?>
			</div>
			<?php /* If a user fills out their bio info, it's included here */ ?>
	      	<div class="post-author clearfix">
	        	<h3 class="post-author_h"><?php _e('Written by', 'cherry'); ?> <?php the_author_posts_link() ?></h3>
	        	<p class="post-author_gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); /* This avatar is the user's gravatar (http://gravatar.com) based on their administrative email address */  } ?></p>
	        	<div class="post-author_desc">
	          	<?php the_author_meta('description') ?> 
	          		<div class="post-author_link">
	            		<p>View all posts by: <?php the_author_posts_link() ?></p>
	          		</div>
	        	</div>
	      	</div><!--.post-author-->
	      	
	      	<?php get_template_part( 'includes/post-formats/related-posts' ); ?>			
			<?php comments_template('', true); ?> 		      		
			<?php endwhile; endif; ?>
		</div><!--#content-->		
	<?php get_sidebar(); ?>	
	</div><!--.row-->
</div><!--.container-->  
<?php get_footer(); ?>