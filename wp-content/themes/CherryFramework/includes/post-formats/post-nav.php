<?php if(function_exists('pagination')) : ?>
	<?php pagination($wp_query->max_num_pages); ?>
<?php else : ?>
  <?php if ( $wp_query->max_num_pages > 1 ) : ?>
    <ul class="pager">
      <li class="previous">
        <?php next_posts_link( __('&laquo; Older Entries', 'cherry')) ?>
      </li><!--.older-->
      <li class="next">
        <?php previous_posts_link(__('Newer Entries &raquo;', 'cherry')) ?>
      </li><!--.newer-->
    </ul><!--.oldernewer-->
  <?php endif; ?>
<?php endif; ?>
<!-- Posts navigation -->