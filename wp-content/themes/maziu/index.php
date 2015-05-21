<?php

get_header(); ?>
	
	<div id="main-content-wrap">
		<div id="slideshow-wrap">
			<div class="content">
				<div class="content-inner">
					<?php //maziu_slideshow(); ?>
				</div>
			</div>
		</div><!-- #slideshow -->
		
		<div id="main-content" class="content">
			<div id="main-content-inner" class="clearfix">
				<div id="primary" class="content-area">
					<div id="content" class="site-content">
					<?php if (have_posts()) : ?>

						<?php while (have_posts()) : the_post(); ?>
							<?php get_template_part('content', get_post_format()); ?>
						<?php endwhile; ?>

					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>

					</div><!-- #content -->
				</div><!-- #primary -->
				
				<?php get_sidebar(); ?>
				
			</div><!-- #main-content-inner -->
		</div><!-- #main-content -->
	</div><!-- #main-content-wrap -->

<?php get_footer(); ?>