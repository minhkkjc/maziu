<?php
/*
 * Display search page
 */

get_header(); ?>

    <div id="no-content-wrap" class="search-title-wrap">
        <h3><?php _e('Search results for', 'maziu'); ?> <span class="main-color"><?php echo get_search_query(); ?></span></h3>
    </div><!-- #no-content-wrap -->

    <div id="main-content-wrap">

        <div id="main-content" class="content">
            <div id="main-content-inner" class="clearfix">
                <div id="primary" class="content-area">
                    <div id="content" class="site-content">
                        <?php
                        $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
                        $wp_query->set('posts_per_page', get_option('posts_per_page'));
                        $wp_query->set('paged', $paged);
                        ?>
                        <?php
                        if (have_posts()) :
                            // Get category layout
                            $categoriesLayout = get_option('maziu_option')['categories_layout'];
                            $layout = $categoriesLayout[$cat];

                            if (empty($layout))
                                $layout = 'list';

                            get_template_part('category', $layout);
                        else :
                            get_template_part('content', 'none');
                        endif;
                        ?>

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
        <div id="main-socials" class="content">
            <?php echo do_shortcode('[socials class="main-bg-hover main-color" position="center"]'); ?>
        </div><!-- #main-socials -->
    </div><!-- #main-socials-wrap -->

<?php get_footer(); ?>