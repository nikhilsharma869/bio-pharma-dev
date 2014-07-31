			<article id="post-<?php the_ID(); ?>" <?php post_class('post__holder'); ?>>
			
				<header class="post-header">
				
				<?php if(!is_singular()) : ?>
				
				<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to:', 'cherry');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
				<?php else :?>
				
				<h1 class="post-title"><?php the_title(); ?></h1>
				
				<?php endif; ?>
				
				</header>
			
				<?php 
			
				if (has_post_thumbnail() ):
				
				$lightbox = get_post_meta(get_the_ID(), 'tz_image_lightbox', TRUE); 
				
				if($lightbox == 'yes') {
					$lightbox = TRUE;
				} else {
					$lightbox = FALSE;
				}
				
				$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), array( '9999','9999' ), false, '' ); 
				
			 ?>
			
			<div class="post-thumb clearfix">
				
				<?php
				$thumb = get_post_thumbnail_id();
				$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
				$image = aq_resize( $img_url, 770, 380, true ); //resize & crop img
				?>
			
				<?php if($lightbox) : ?>
					
					<figure class="featured-thumbnail thumbnail large">
						<a class="image-wrap" rel="prettyPhoto" title="<?php the_title(); ?>" href="<?php echo $src[0]; ?>"><img src="<?php echo $image ?>" alt="<?php the_title(); ?>" /><span class="zoom-icon"></span></a>
					</figure>
					<div class="clear"></div>
                    
						<span class="overlay">
							<span class="arrow"></span>
						</span>
					
				<?php else: ?>
				
					<figure class="featured-thumbnail thumbnail large">
						<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" />
					</figure>
					<div class="clear"></div>
					
				<?php endif; ?>
				
			</div>
            
				<?php endif; ?>
				
				<!-- Post Content -->
				<div class="post_content">
					<?php the_content(''); ?>
				</div>
				<!-- //Post Content -->
				
				<?php get_template_part('includes/post-formats/post-meta'); ?>
			
			</article><!--//.post__holder--> 
			