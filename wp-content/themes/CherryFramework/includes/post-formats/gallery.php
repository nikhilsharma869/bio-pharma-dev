<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class('post__holder'); ?>>

	<header class="post-header">
	
	<?php if(!is_singular()) : ?>
	
	<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to:', 'cherry');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
	<?php else :?>
	
	<h1 class="post-title"><?php the_title(); ?></h1>
	
	<?php endif; ?>
	
	</header>
	
	
	<?php $random = gener_random(10); ?>

	<script type="text/javascript">
		// Can also be used with $(document).ready()
		$(window).load(function() {
			$('#flexslider_<?php echo $random ?>').flexslider({
				animation: "slide",
				smoothHeight: true
			});
		});
	</script>

		
		<!-- Gallery Post -->
		<div class="gallery-post">
			
			<!-- Slider -->
			<div id="flexslider_<?php echo $random ?>" class="flexslider thumbnail">
				<ul class="slides">
					
					<?php 
					$args = array(
						'orderby'		 => 'menu_order',
						'order' => 'ASC',
						'post_type'      => 'attachment',
						'post_parent'    => get_the_ID(),
						'post_mime_type' => 'image',
						'post_status'    => null,
						'numberposts'    => -1,
					);
					$attachments = get_posts($args); ?>
					
					<?php if ($attachments) : ?>
					
					<?php foreach ($attachments as $attachment) : ?>
					
					<?php 
						$attachment_url = wp_get_attachment_image_src( $attachment->ID, 'full' );
						$url = $attachment_url['0'];
						$image = aq_resize($url, 800, 400, true);
					?>
					
					<li><img src="<?php echo $image; ?>" alt="<?php echo apply_filters('the_title', $attachment->post_title); ?>"/></li>
					
					<?php endforeach; ?>
					<?php endif; ?>
					
				</ul>
			</div>
			<!-- /Slider -->
		
		</div>
		<!-- /Gallery Post -->

		<!-- Post Content -->
		<div class="post_content">
			<?php the_content(''); ?>
		</div>
		<!-- //Post Content -->
		
		<?php get_template_part('includes/post-formats/post-meta'); ?>
  
</article><!--END .post-->