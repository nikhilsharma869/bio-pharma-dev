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
		// get audio attribute
		$audio_title = get_post_meta(get_the_ID(), 'tz_audio_title', true);
		$audio_artist = get_post_meta(get_the_ID(), 'tz_audio_artist', true);		
		$audio_format = get_post_meta(get_the_ID(), 'tz_audio_format', true);
		$audio_url = get_post_meta(get_the_ID(), 'tz_audio_url', true);
	?>
	
	<div class="audio-wrap">
		<script type="text/javascript">
			$(document).ready(function(){
				var myPlaylist_<?php the_ID(); ?> = new jPlayerPlaylist({
				  jPlayer: "#jquery_jplayer_<?php the_ID(); ?>",
				  cssSelectorAncestor: "#jp_container_<?php the_ID(); ?>"
				}, [
				  {
					title:"<?php echo $audio_title; ?>",
					artist:"<?php echo $audio_artist; ?>",
					<?php echo $audio_format; ?>: "<?php echo stripslashes(htmlspecialchars_decode($audio_url)); ?>" <?php if(has_post_thumbnail()) {?>,
					poster: "<?php echo $image; ?>" <?php } ?>
				  }
				], {
				  playlistOptions: {
					enableRemoveControls: false
				  },
				  ready: function () {
					$(this).jPlayer("setMedia", {
						<?php echo $audio_format; ?>: "<?php echo stripslashes(htmlspecialchars_decode($audio_url)); ?>"
						});
					},
				  swfPath: "<?php echo get_template_directory_uri(); ?>/flash",
				  wmode: "window",
				  supplied: "mp3, all"
				});
			});
		</script>
		
		<!-- BEGIN audio -->
		<div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer"></div>
		<div id="jp_container_<?php the_ID(); ?>" class="jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui">
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
			<div class="jp-playlist">
				<ul>
					<li></li>
				</ul>
			</div>
		</div>
		<!-- END audio -->
	</div>
			
	<!-- Post Content -->
	<div class="post_content">
		<?php the_content(''); ?>
	</div>
	<!--// Post Content -->
	
	<?php get_template_part('includes/post-formats/post-meta'); ?>
		
</article><!--END .hentry-->