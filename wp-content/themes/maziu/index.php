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
		
		<div id="main-content" class="container">
			<div id="main-content-inner" class="clearfix">
				<div id="primary" class="content-area">
					<div id="content" class="site-content">
                    <?php
                        $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
						$wp_query->set('posts_per_page', get_option('posts_per_page'));
						$wp_query->set('paged', $paged);
                    ?>
					<?php if (have_posts()) : ?>

						<?php while (have_posts()) : the_post(); ?>
							<?php get_template_part('content', get_post_format()); ?>
						<?php endwhile; ?>

					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>

					</div><!-- #content -->

                    <div id="content-pagination">
                        <div id="content-pagination-in" class="clearfix">
                        <?php
                            /*
                             * Pagination
                             */
                            $args = array(
                                'total' => $wp_query->max_num_pages,
                                'show_all' => true,
                                'prev_text' => '<i class="fa fa-angle-left"></i>',
                                'next_text' => '<i class="fa fa-angle-right"></i>'
                            );

                            echo paginate_links($args);
                        ?>
                        </div><!-- #content-pagination-in -->
                    </div><!-- #content-pagination -->

				</div><!-- #primary -->
				
				<?php get_sidebar(); ?>
				
			</div><!-- #main-content-inner -->
		</div><!-- #main-content -->
	</div><!-- #main-content-wrap -->
	
	<div id="main-socials-wrap">
		<div id="main-socials" class="container">
			<?php echo do_shortcode('[socials class="main-bg-hover main-color" position="center"]'); ?>
		</div><!-- #main-socials -->
	</div><!-- #main-socials-wrap -->

<?php get_footer(); ?>