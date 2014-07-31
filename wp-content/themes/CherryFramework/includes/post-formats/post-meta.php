<?php $post_meta = of_get_option('post_meta'); ?>
<?php if ($post_meta=='true' || $post_meta=='') { ?>
	<!-- Post Meta -->
	<div class="post_meta">
		<span class="post_category"><i class="icon-bookmark"></i><?php the_category(', ') ?></span><span class="post_date"><i class="icon-calendar"></i><time datetime="<?php the_time('Y-m-d\TH:i:s'); ?>"><?php the_time('F j, Y'); ?></time></span><span class="post_author"><i class="icon-user"></i><?php the_author_posts_link() ?></span><span class="post_comment"><i class="icon-comments"></i><?php comments_popup_link('No comments', '1 comment', '% comments', 'comments-link', 'Comments are closed'); ?></span>
		
		<span class="post_permalink"><i class="icon-link"></i><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to:', 'cherry');?> <?php the_title(); ?>"><?php _e('Permalink', 'cherry') ?></a></span>
	</div>
	<!--// Post Meta -->
<?php } ?>