<!--BEGIN .hentry -->
<article id="post-<?php the_ID(); ?>" <?php post_class('post__holder'); ?>>				
	<header class="post-header">				
		<?php if(!is_singular()) : ?>
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to:', 'cherry');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<?php else :?>
			<h1 class="post-title"><?php the_title(); ?></h1>
		<?php endif; ?>
		
	</header>
	
	<?php 
		// get video attribute
		$video_title = get_post_meta(get_the_ID(), 'tz_video_title', true);
		$video_artist = get_post_meta(get_the_ID(), 'tz_video_artist', true);
		$embed = get_post_meta(get_the_ID(), 'tz_video_embed', true);
		$m4v_url = get_post_meta(get_the_ID(), 'tz_m4v_url', true);
		$ogv_url = get_post_meta(get_the_ID(), 'tz_ogv_url', true);
		
		// get thumb
		if(has_post_thumbnail()) {
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
			$image = aq_resize( $img_url, 770, 380, true ); //resize & crop img
		}
	?>
	
	<div class="video-wrap">
		<?php
			if ($embed != '') {
				echo stripslashes(htmlspecialchars_decode($embed));
			} else { ?>
				<script type="text/javascript">
					$(document).ready(function(){
						var myPlaylist_<?php the_ID(); ?> = new jPlayerPlaylist({
						  jPlayer: "#jquery_jplayer_<?php the_ID(); ?>",
						  cssSelectorAncestor: "#jp_container_<?php the_ID(); ?>"
						}, [
						  {
							title:"<?php echo $video_title; ?>",
							artist:"<?php echo $video_artist; ?>",
							m4v: "<?php echo stripslashes(htmlspecialchars_decode($m4v_url)); ?>",
							ogv: "<?php echo stripslashes(htmlspecialchars_decode($ogv_url)); ?>" <?php if(has_post_thumbnail()) {?>,
							poster: "<?php echo $image; ?>" <?php } ?>
						  }
						], {
						  playlistOptions: {
							enableRemoveControls: false
						  },
						  ready: function () {
							$(this).jPlayer("setMedia", {
								m4v: "<?php echo stripslashes(htmlspecialchars_decode($m4v_url)); ?>",
								ogv: "<?php echo stripslashes(htmlspecialchars_decode($ogv_url)); ?>"
								});
							},
						  swfPath: "<?php echo get_template_directory_uri(); ?>/flash",
						  supplied: "m4v, ogv, all",
						  wmode:"window",
						  size: {
							width: "100%",
							height: "100%"
							}
						});
					});
				</script>
				
				<!-- BEGIN video -->	
				<div id="jp_container_<?php the_ID(); ?>" class="jp-video fullwidth playlist">
					<div class="jp-type-list-parent">
						<div class="jp-type-single">
							<div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer"></div>
							<div class="jp-gui">
								<div class="jp-video-play">
									<a href="javascript:;" class="jp-video-play-icon" tabindex="1" title="Play">Play</a>
								</div>
								<div class="jp-interface">
									<div class="jp-progress">
										<div class="jp-seek-bar">
											<div class="jp-play-bar"></div>
										</div>
									</div>
									<div class="jp-duration"></div>
									<div class="jp-time-sep"></div>
									<div class="jp-current-time"></div>
									<div class="jp-controls-holder">
										<ul class="jp-controls">
											<li><a href="javascript:;" class="jp-previous" tabindex="1" title="Previous"><span>Previous</span></a></li>
											<li><a href="javascript:;" class="jp-play" tabindex="1" title="Play"><span>Play</span></a></li>
											<li><a href="javascript:;" class="jp-pause" tabindex="1" title="Pause"><span>Pause</span></a></li>
											<li><a href="javascript:;" class="jp-next" tabindex="1" title="Next"><span>Next</span></a></li>
											<li><a href="javascript:;" class="jp-stop" tabindex="1" title="Stop"><span>Stop</span></a></li>
										</ul>
										<div class="jp-volume-bar">
											<div class="jp-volume-bar-value"></div>
										</div>
										<ul class="jp-toggles">
											<li><a href="javascript:;" class="jp-mute" tabindex="1" title="Mute"><span>Mute</span></a></li>
											<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="Unmute"><span>Unmute</span></a></li>
										</ul>
									</div>
								</div>
								<div class="jp-no-solution">
									<span>Update Required. </span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
								</div>	
							</div>
						</div>			
					</div>
					<div class="jp-playlist">
						<ul>
							<li></li>
						</ul>
					</div>
				</div><!-- END video -->
			<?php }
		?>
		
	</div>
			
	<!-- Post Content -->
	<div class="post_content">
		<?php the_content(''); ?>
	</div>
	<!-- //Post Content -->
	
	<?php get_template_part('includes/post-formats/post-meta'); ?>        
 
</article><!--END .hentry-->