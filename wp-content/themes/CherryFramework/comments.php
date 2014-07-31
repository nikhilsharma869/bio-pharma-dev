<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
  	<?php echo '<p class="nocomments">' . __('This post is password protected. Enter the password to view comments.', 'cherry') . '</p>'; ?>
	<?php
		return;
	}
?>
<!-- BEGIN Comments -->	
	<?php if ( have_comments() ) : ?>
	<div class="comment-holder">
		<h3 class="comments-h"><?php printf( _n( '1 Response', '%1$s Responses', get_comments_number(), 'cherry' ),
				number_format_i18n( get_comments_number() ), '' );?></h3>
		<ol class="comment-list">
			<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
		</ol>
	</div>
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
			<!-- If comments are open, but there are no comments. -->
	   <?php echo '<p class="nocomments">' . __('No Comments Yet.', 'cherry') . '</p>'; ?>
		<?php else : // comments are closed ?>
			<!-- If comments are closed. -->
	   <?php echo '<p class="nocomments">' . __('Comments are closed.', 'cherry') . '</p>'; ?>

		<?php endif; ?>
	
	<?php endif; ?>
	

	<?php if ( comments_open() ) : ?>

	<div id="respond">

	<h3><?php comment_form_title( _e('Leave a reply','cherry')); ?></h3>

	<div class="cancel-comment-reply">
		<small><?php cancel_comment_reply_link(); ?></small>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p><?php _e('You must be', 'cherry'); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e('logged in', 'cherry'); ?></a> <?php _e('to post a comment.', 'cherry'); ?></p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

	<p><?php _e('Logged in as', 'cherry'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'cherry'); ?>"><?php _e('Log out &raquo;', 'cherry'); ?></a></p>

	<?php else : ?>

	<p class="field"><input type="text" name="author" id="author" value="<?php _e('Name', 'cherry'); ?><?php if ($req) _e('*', 'cherry'); ?>" onfocus="if(this.value=='<?php _e('Name', 'cherry'); ?><?php if ($req) _e('*', 'cherry'); ?>'){this.value=''}" onblur="if(this.value==''){this.value='<?php _e('Name', 'cherry'); ?><?php if ($req) _e('*', 'cherry'); ?>'}" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /></p>

	<p class="field"><input type="text" name="email" id="email" value="<?php _e('Email (will not be published)', 'cherry'); ?><?php if ($req) _e('*', 'cherry'); ?>" onfocus="if(this.value=='<?php _e('Email (will not be published)', 'cherry'); ?><?php if ($req) _e('*', 'cherry'); ?>'){this.value=''}" onblur="if(this.value==''){this.value='<?php _e('Email (will not be published)', 'cherry'); ?><?php if ($req) _e('*', 'cherry'); ?>'}" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /></p>

	<p class="field"><input type="text" name="url" id="url" value="<?php _e('Website', 'cherry'); ?>" onfocus="if(this.value=='<?php _e('Website', 'cherry'); ?>'){this.value=''}" onblur="if(this.value==''){this.value='<?php _e('Website', 'cherry'); ?>'}" size="22" tabindex="3" /></p>

	<?php endif; ?>

	<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

	<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4" onfocus="if(this.value=='<?php _e('Your comment*', 'cherry'); ?>'){this.value=''}" onblur="if(this.value==''){this.value='<?php _e('Your comment*', 'cherry'); ?>'}"><?php _e('Your comment*', 'cherry'); ?></textarea></p>

	<p><input name="submit" type="submit" class="btn btn-primary" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'cherry'); ?>" />
	<?php comment_id_fields(); ?>
	</p>
	<?php do_action('comment_form', $post->ID); ?>

	</form>

	<?php endif; // If registration required and not logged in ?>
	</div>
	

<!-- END Comments -->

<?php endif; ?>