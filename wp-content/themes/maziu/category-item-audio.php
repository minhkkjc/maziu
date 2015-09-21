<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="clearfix">
		<div class="post-thumbnail">
			<div class="fluid-audio-wrapper">
				<?php echo get_soundcloud($post->ID); ?>
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