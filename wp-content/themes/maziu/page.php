<?php

get_header();
?>
    <?php
        while (have_posts()) :
            the_post();
            $full_width = get_post_meta(get_the_ID(), '_maziu_page_full_template', true);
            if ($full_width) :
    ?>
        <div id="full-width-thumbnail-wrap">
            <?php the_post_thumbnail('full'); ?>
        </div><!-- #no-content-wrap -->
    <?php else : ?>
        <div id="no-content-wrap"></div>
    <?php endif; ?>
        <div id="main-content-wrap">
            <div id="main-content" class="container">
                <div id="main-content-inner" class="clearfix">
                    <?php
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
                </div><!-- #main-content-inner -->
            </div><!-- #main-content -->
        </div><!-- #main-content-wrap -->
    <?php endwhile; ?>

    <div id="main-socials-wrap">
        <div id="main-socials" class="container">
            <?php echo do_shortcode('[socials class="main-bg-hover main-color" position="center"]'); ?>
        </div><!-- #main-socials -->
    </div><!-- #main-socials-wrap -->

<?php get_footer(); ?>