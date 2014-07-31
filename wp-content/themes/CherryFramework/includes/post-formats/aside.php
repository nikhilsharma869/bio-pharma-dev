<!--BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php post_class('post__holder'); ?>>
		
    <!-- Post Content -->
    <div class="post_content">
        <?php the_content('<span>Continue Reading</span>'); ?>
    <!--// Post Content -->
    </div>
    
    <?php get_template_part('includes/post-formats/post-meta'); ?>

<!--END .hentry-->  
</article>