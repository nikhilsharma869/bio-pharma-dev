<?php
/**
 * Template Name: FAQs
 */

get_header(); ?>
	<?php get_template_part('title'); ?>
	<div class="container">
		<div class="row">			
			<div id="content" class="span12">
			<?php
				$temp = $wp_query;
				$wp_query= null;
				$wp_query = new WP_Query();
				$wp_query->query('post_type=faq&showposts=-1');
			?>
				<dl class="faq-list">
				<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
					<dt class="faq-list_h"><span class="marker"><?php _e('Q?', 'cherry'); ?></span><?php the_title(); ?></dt>
					<dd id="post-<?php the_ID(); ?>" class="faq-list_body">
						<span class="marker"><?php _e('A.', 'cherry'); ?></span><?php the_content(); ?>
					</dd>
				<?php endwhile; ?>
				</dl>  
			<?php $wp_query = null; $wp_query = $temp;?>
			</div><!--#content-->
		</div><!-- .row -->
	</div><!--.container-->
<?php get_footer(); ?>