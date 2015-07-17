<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="post-thumbnail">
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
            endif;
        }
    ?>
    </div>

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
                <span><i class="fa fa-clock-o"></i><?php the_date(); ?></span>
            </li>
        </ul>
    </div><!-- .post-entry -->

    <div class="post-content">
        <div class="post-categories"><?php the_category(''); ?></div>
        <h3><?php the_title(); ?></h3>
        <div class="post-excerpt"><?php the_excerpt(); ?></div>
        <div class="post-read-more">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="main-bg-hover main-border main-color ease-transition"><?php echo __('Continue reading'); ?></a>
        </div>
        <div class="post-socials"><?php echo do_shortcode('[post_socials]'); ?></div>
    </div><!-- .post-content -->

</article><!-- #post -->