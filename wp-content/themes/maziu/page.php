<?php

get_header();
?>

    <div id="no-content-wrap">

    </div><!-- #no-content-wrap -->

    <div id="main-content-wrap">
        <div id="main-content" class="content">
            <div id="main-content-inner" class="clearfix">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                        $full_width = get_post_meta(get_the_ID(), '_maziu_page_full_template', true);
                        if ($full_width) :
                    ?>
                        <div id="primary" class="content-area full-width">
                            <div id="content" class="site-content">

                                <?php get_template_part('content', 'page'); ?>

                            </div><!-- #content -->
                        </div><!-- #primary -->
                    <?php else : ?>
                        <div id="primary" class="content-area">
                            <div id="content" class="site-content">

                                <?php get_template_part('content', 'page') ?>

                            </div><!-- #content -->
                        </div><!-- #primary -->

                        <?php get_sidebar(); ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div><!-- #main-content-inner -->
        </div><!-- #main-content -->
    </div><!-- #main-content-wrap -->

    <div id="main-socials-wrap">
        <div id="main-socials" class="content">
            <?php echo do_shortcode('[socials class="main-bg-hover main-color" position="center"]'); ?>
        </div><!-- #main-socials -->
    </div><!-- #main-socials-wrap -->

<?php get_footer(); ?>