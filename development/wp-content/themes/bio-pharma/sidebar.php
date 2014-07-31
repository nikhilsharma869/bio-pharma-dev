<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<div id="secondary">

	<?php if ( has_nav_menu( 'secondary' ) ) : ?>
	<nav role="navigation" class="navigation site-navigation secondary-navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
	</nav>
	<?php endif; ?>

	<?php //if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
    
    <?php 
	$xml = simplexml_load_file('http://www.fiercecro.com/feed');
	$news = $xml->channel->item;
	
	for($i=0;$i<5;$i++){
		$data[$i]['title'] = (string)$news[$i]->title;
		$data[$i]['link'] = (string)$news[$i]->link;
		$data[$i]['description'] = (string)$news[$i]->description;
	}
	?>
    	<aside class="widget widget_news_entries" id="recent-posts-3">
        <fieldset>
            <legend>News</legend>
            <!--<h1 class="widget-title" style="margin-top:0px;">News</h1>-->
            <ul>
                <?php
                for($i=0;$i<count($data);$i++){
                ?>
                <li>
                    <a href="<?php echo $data[$i]['link'];?>"><?php echo $data[$i]['title'];?></a>
                    <span class="post-excerpt"><?php echo $data[$i]['description'];?></span>
                </li>
                <?php }?>
            </ul>
         </fieldset>
		</aside>
        
    	<aside class="widget widget_recent_entries" id="recent-posts-3">
        <fieldset>
            <legend>Case Studies</legend>
            <ul>
                <?php
				query_posts("post_type=post&showposts=4");
				while ( have_posts() ) : the_post();
				?>
                <li>
                    <a href="<?php the_permalink();?>"><?php the_title();?></a>
                    <a href="<?php the_permalink();?>"><?php the_post_thumbnail( array(268,186) ); ?></a>
                    <span class="post-date"><?php the_date('M d');?></span>
                    <span class="post-excerpt"><?php the_excerpt();?></span>
                </li>
                <?php endwhile;?>
            </ul>
        </fieldset>
		</aside>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #primary-sidebar -->
	<?php //endif; ?>
</div><!-- #secondary -->
