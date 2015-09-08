<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="clearfix">
		<?php if (has_post_thumbnail()) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>
		</div><!-- .post-thumbnail -->
		<?php endif; ?>

		<div class="post-content<?php if (!has_post_thumbnail()) echo ' full-width'; ?>">
			<div class="post-categories"><?php the_category(''); ?></div>
			<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
			<div class="post-entry">
				<ul class="clearfix">
					<li>
						<span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
					</li>
					<li>
						<span><i class="fa fa-heart-o"></i>5</span>
					</li>
					<li>
						<span><i class="fa fa-comments-o"></i><?php comments_number('0', '1', '%'); ?></span>
					</li>
				</ul>
			</div><!-- .post-entry -->
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