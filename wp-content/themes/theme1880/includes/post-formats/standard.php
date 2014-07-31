			<article id="post-<?php the_ID(); ?>" <?php post_class('post__holder'); ?>>
					
				<header class="post-header">
				
				<?php if(!is_singular()) : ?>
				
				<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to:', 'my_framework');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
				<?php else :?>
				
				<h1 class="post-title"><?php the_title(); ?></h1>
				
				<?php endif; ?>
				
				</header>
				
				
				<?php get_template_part('includes/post-formats/post-thumb'); ?>
				
				
				<?php if(!is_singular()) : ?>
				
				<!-- Post Content -->
				<div class="post_content">
					<?php $post_excerpt = of_get_option('post_excerpt'); ?>
					<?php if ($post_excerpt=='true' || $post_excerpt=='') { ?>
					
						<div class="excerpt">
						
						
						<?php 
						
						$content = get_the_content();
						$excerpt = get_the_excerpt();

						if (has_excerpt()) {

								the_excerpt();

						} else {
						
								if(!is_search()) {

								echo my_string_limit_words($content,55);
								
								} else {
								
								echo my_string_limit_words($excerpt,55);
								
								}

						}
						
						
						?>
						
						</div>
						
						
					<?php } ?>
					<a href="<?php the_permalink() ?>" class="btn btn-primary"><?php _e('Read more', 'my_framework'); ?></a>
				</div>
				
				<?php else :?>
				
				<!-- Post Content -->
				<div class="post_content">
				
					<?php the_content(''); ?>
					
				</div>
				<!-- //Post Content -->
				
				<?php endif; ?>
				
				<?php get_template_part('includes/post-formats/post-meta'); ?>
			 
			</article>