<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="clearfix">
		<div class="post-thumbnail">
			<div class="fluid-video-wrapper">
			<?php
				$url = get_post_meta($post->ID, 'v_url', true);
				if (!empty($url)) {
					if (mb_strpos($url, 'vimeo.com')):
						preg_match('/\/(\d)+/', $url, $matches);
						$v_id = str_replace('/', '', $matches[0]);
						if (!empty($v_id)):
			?>

			<iframe src="https://player.vimeo.com/video/<?php echo $v_id; ?>" frameborder="0" title="<?php the_title(); ?>" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

			<?php
						endif;
					elseif (mb_strpos($url, 'youtube.com')):
						preg_match('/v=[a-zA-Z0-9]+/', $url, $matches);
						$v_id = str_replace('v=', '', $matches[0]);
						if (!empty($v_id)):
			?>

			<iframe src="https://www.youtube.com/embed/<?php echo $v_id; ?>" frameborder="0" title="<?php the_title(); ?>" allowfullscreen></iframe>

			<?php
						endif;
					endif;
				}
			?>
			</div><!-- .fluid-video-wrapper -->
		</div><!-- .post-thumbnail -->

		<div class="post-content">
			<div class="post-categories"><?php the_category(''); ?></div>
			<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

            <?php
                // Get post entry
                get_template_part('post-entry');
            ?>

			<div class="post-excerpt"><?php the_excerpt(); ?></div>
			<div class="post-socials clearfix">
				<div class="socials-btn ease-transition" data-toggle='0'>
					<i class="fa fa-share-alt"></i>
				</div>
				<?php echo do_shortcode('[post_socials class_ul="ease-transition" class="main-color transparent"]'); ?>
			</div>
		</div><!-- .post-content -->
		
	</div>
	
</article><!-- #post -->