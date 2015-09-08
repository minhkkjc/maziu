<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (is_home() || is_category()) : ?>

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

		<div class="post-entry">
			<ul class="clearfix">
				<li>
					<span><i class="fa fa-pencil-square-o"></i><?php the_author(); ?></span>
				</li>
				<li>
					<span><i class="fa fa-heart-o"></i>5</span>
				</li>
				<li>
					<span><i class="fa fa-comments-o"></i><?php comments_number('0', '1', '%'); ?></span>
				</li>
				<li>
					<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
				</li>
			</ul>
		</div><!-- .post-entry -->

		<div class="post-content">
			<div class="post-categories"><?php the_category(''); ?></div>
			<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
			<div class="post-excerpt"><?php the_excerpt(); ?></div>
			<div class="post-read-more">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="main-bg-hover main-border main-color ease-transition"><?php echo __('Continue reading'); ?></a>
			</div>
			<div class="post-socials"><?php echo do_shortcode('[post_socials]'); ?></div>
		</div><!-- .post-content -->
		
	<?php elseif (is_single()) : ?>
		
		<div class="post-content">
            <div class="post-categories"><?php the_category(''); ?></div>
            <h3><?php the_title(); ?></h3>
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

            <div class="post-entry">
                <ul class="clearfix">
                    <li>
                        <span><i class="fa fa-pencil-square-o"></i><?php the_author(); ?></span>
                    </li>
                    <li>
                        <span><i class="fa fa-heart-o"></i>5</span>
                    </li>
                    <li>
                        <span><i class="fa fa-comments-o"></i><?php comments_number('0', '1', '%'); ?></span>
                    </li>
                    <li>
                        <span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
                    </li>
                </ul>
            </div><!-- .post-entry -->
            <div class="post-content-detail"><?php the_content(); ?></div>
			<div class="post-content-footer clearfix">
				<div class="post-tags">
					<?php 
						$tags = get_the_tags();
						$tag_arr = array();
						
						if (!empty($tags)) :
							echo 'Tags: ';
							foreach ($tags as $tag) {
								$tag_link = get_tag_link($tag->term_id);
								$tag_arr[] = "<a href='" . $tag_link . "' class='main-color'>" . $tag->name . "</a>";
							}
							
							echo implode("<span class='main-color'>, </span>", $tag_arr);
						endif;
					?>
				</div>
				<div class="post-socials"><?php echo do_shortcode('[post_socials]'); ?></div>
			</div>
        </div><!-- .post-content -->
		
	<?php endif; ?>

</article><!-- #post -->