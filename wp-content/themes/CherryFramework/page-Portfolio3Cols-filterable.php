<?php
/**
 * Template Name: Filter Folio 3 cols
 */

get_header(); ?>
<?php get_template_part('title'); ?>
<div class="container">
	<div id="content">
	
		<?php // Theme Options vars
		$folio_filter = of_get_option('folio_filter');
		$items_count3 = of_get_option('items_count3');
		?>
		
		<?php if($folio_filter == "yes") { ?>
		<div class="filter-wrapper clearfix">
			<ul id="filters" class="nav nav-pills pull-right">
			<li class="active"><a href="#" data-filter="*">Show all</a></li>
			<?php 
			$portfolio_categories = get_categories(array('taxonomy'=>'portfolio_category'));
			foreach($portfolio_categories as $portfolio_category)
				echo '<li><a href="#" data-filter=".'.$portfolio_category->slug.'">' . $portfolio_category->name . '</a></li>';
			?>
			</ul>
		</div>
		<?php } ?>
		
		<?php $temp = $wp_query;
		$wp_query= null;
		$wp_query = new WP_Query(); ?>
		<?php $wp_query->query("post_type=portfolio&paged=".$paged.'&showposts='.$items_count3); ?>
		<?php if ( ! have_posts() ) : ?>
		<div id="post-0" class="post error404 not-found">
			<h1 class="entry-title"><?php _e( 'Not Found', 'cherry' ); ?></h1>
			<div class="entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'cherry' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</div><!-- #post-0 -->
		<?php endif; ?>

		<ul id="portfolio-grid" class="filterable-portfolio thumbnails portfolio-3cols" data-cols="3cols">
			
			<?php get_template_part('filterable-portfolio-loop'); ?>
			
		</ul>
	
	<?php get_template_part('includes/post-formats/post-nav'); ?>
	
	<?php $wp_query = null; $wp_query = $temp;?>
	
	</div><!-- #content -->
</div><!--.container-->
<?php get_footer(); ?>