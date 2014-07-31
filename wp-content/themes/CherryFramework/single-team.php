<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div id="content" class="span8 <?php echo of_get_option('blog_sidebar_pos') ?>">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post();
				$custom = get_post_custom($post->ID);
				$teampos = $custom["my_team_pos"][0];
				$teaminfo = $custom["my_team_info"][0];
			?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
				<article class="team-holder single-post">
					<div class="page-header">
						<h1><?php the_title(); ?></h1>
						<?php if($teampos) { ?>
							<span class="page-desc"><?php echo $teampos; ?></span>
						<?php } ?>
					</div>
				<?php if(has_post_thumbnail()) {
					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'thumbnail'); //get img URL
					$image = aq_resize( $img_url, 120, 120, true ); //resize & crop img
				?>
					<figure class="featured-thumbnail">
						<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" />
					</figure>
				<?php } ?>
						
				<div class="team-content post-content">
					<?php the_content(); ?>
					<span class="page-desc"><?php echo $teaminfo; ?></span>
				</div><!--.post-content-->
			  </article>		
			</div><!-- #post-## -->		
		  <?php endwhile; /* end loop */ ?>
		</div><!--#content-->		
		<?php get_sidebar(); ?>		
	</div><!--.row-->
</div><!--.container-->  
<?php get_footer(); ?>