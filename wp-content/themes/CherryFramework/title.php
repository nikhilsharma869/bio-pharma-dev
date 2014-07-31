<section class="title-section">
	<div class="container">
		<h1 class="title-header">
			<?php if(is_home()){ ?>
				<?php $blog_text = of_get_option('blog_text'); ?>
					<?php if($blog_text){?>
						<?php echo of_get_option('blog_text'); ?>
					<?php } else { ?>
						<?php _e('Blog','cherry');?>
				<?php } ?>
				
			<?php } elseif ( is_category() ) { ?>
				<?php printf( __( 'Category Archives: %s', 'cherry' ), '<small>' . single_cat_title( '', false ) . '</small>' ); ?>
				<?php echo category_description(); /* displays the category's description from the Wordpress admin */ ?>
			
			<?php } elseif ( is_search() ) { ?>
				<?php _e('Search for: ','cherry');?>"<?php the_search_query(); ?>"
			
			<?php } elseif ( is_day() ) { ?>
				<?php printf( __( 'Daily Archives: <small>%s</small>', 'cherry' ), get_the_date() ); ?>
				
			<?php } elseif ( is_month() ) { ?>	
				<?php printf( __( 'Monthly Archives: <small>%s</small>', 'cherry' ), get_the_date('F Y') ); ?>
				
			<?php } elseif ( is_year() ) { ?>	
				<?php printf( __( 'Yearly Archives: <small>%s</small>', 'cherry' ), get_the_date('Y') ); ?>
			
			<?php } elseif ( is_author() ) { ?>
				<?php 
					global $author;
					$userdata = get_userdata($author);
				?>
					<?php _e('by ','cherry');?><?php echo $userdata->display_name; ?>
					
			<?php } elseif ( is_tag() ) { ?>
				<?php printf( __( 'Tag Archives: %s', 'cherry' ), '<small>' . single_tag_title( '', false ) . '</small>' ); ?>
				
			<?php } else { ?>
			
				<?php if (have_posts()) : while (have_posts()) : the_post();
					$pagetitle = get_post_custom_values("page-title");
					$pagedesc = get_post_custom_values("title-desc");
						if($pagetitle == ""){
							the_title();
						} else {
							echo $pagetitle[0];
						}
						if($pagedesc != ""){ ?>
							<span class="title-desc"><?php echo $pagedesc[0];?></span>
						<?php }
					endwhile; endif;
				wp_reset_query();			
			} ?>
		</h1>
		<?php
			if (of_get_option('g_breadcrumbs_id') == 'yes') { ?>
				<!-- BEGIN BREADCRUMBS-->
				<?php if (function_exists('breadcrumbs')) breadcrumbs(); ?>
				<!-- END BREADCRUMBS -->
		<?php }
		?>
	</div>
</section><!-- .title-section -->