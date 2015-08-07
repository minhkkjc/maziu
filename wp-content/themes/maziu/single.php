<?php

get_header();
?>

    <div id="no-content-wrap">

    </div><!-- #no-content-wrap -->

    <div id="main-content-wrap">
        <div id="main-content" class="content">
            <div id="main-content-inner" class="clearfix">
                <div id="primary" class="content-area">
                    <div id="content" class="site-content">

                        <?php while (have_posts()) : the_post(); ?>
                            <?php
                                update_hits(get_hits());
                                get_template_part('content', get_post_format());
                            ?>
                        <?php endwhile; ?>

                    </div><!-- #content -->
                </div><!-- #primary -->

                <?php get_sidebar(); ?>

            </div><!-- #main-content-inner -->
        </div><!-- #main-content -->
    </div><!-- #main-content-wrap -->
	
	<div id="main-socials-wrap">
		<div id="main-socials" class="content">
			<?php echo do_shortcode('[socials class="main-bg-hover main-color" position="center"]'); ?>
		</div><!-- #main-socials -->
	</div><!-- #main-socials-wrap -->

<?php get_footer(); ?>