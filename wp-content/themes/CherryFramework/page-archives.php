<?php
/**
 * Template Name: Archives
 */
?>

<?php get_header(); ?>
    <?php get_template_part('title'); ?>
    <div class="container">
    	<div class="row">		
    		<div id="content" class="span8 <?php echo of_get_option('blog_sidebar_pos') ?>">
    			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>                
                    <div id="post-<?php the_ID(); ?>" <?php post_class('post-holder'); ?>>                    
                        <div class="post-content">
                            <?php the_content('<span>Continue Reading</span>'); ?>
                            <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'cherry').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>                            
                            <div class="archive_lists">
                                <div class="row-fluid">
                                    <div class="span4">
                                        <h3 class="archive_h"><?php _e('Last 30 Posts', 'cherry') ?></h3>
                                        <div class="list styled check-list">
                                            <ul>
                                            <?php $archive_30 = get_posts('numberposts=30');
                                            foreach($archive_30 as $post) : ?>
                                                <li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <h3 class="archive_h"><?php _e('Archives by Month:', 'cherry') ?></h3>
                                        <div class="list styled check-list">
                                            <ul>
                                                <?php wp_get_archives('type=monthly'); ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="span4">
                                        <h3 class="archive_h"><?php _e('Archives by Subject:', 'cherry') ?></h3>
                                        <div class="list styled check-list">
                                            <ul>
                                                <?php wp_list_categories( 'title_li=' ); ?>
                                            </ul>
                                        </div><!-- .archive_lists -->
                                    </div>
                                </div>
                            </div><!-- .post-content -->
                        </div>
                    </div>
				<?php endwhile; endif; ?>			
    			</div><!--#content-->			
    		<?php get_sidebar(); ?>
    	</div><!--.row-->
    </div><!--.container-->   
<?php get_footer(); ?>