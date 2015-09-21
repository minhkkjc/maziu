<?php
/*
 * Post entry
 */
?>
<div class="post-entry">
    <ul class="clearfix">
        <li>
            <span><i class="fa fa-pencil-square-o"></i><?php the_author(); ?></span>
        </li>
        <li>
            <?php
                // Check current user liked this post
                $pid = get_the_ID();
                $baseurl = get_site_url();
                $cookie_name = $baseurl . '-like-' . $pid;
                $cookie = get_cookie($cookie_name);

                if (!empty($cookie)) {
                    $liked = 1;
                } else {
                    $liked = 0;
                }
            ?>
            <span>
                <i class="fa <?php echo ($liked) ? 'fa-heart' : 'fa-heart-o'; ?> post-like post-like-<?php echo $pid; ?> main-color"
                    data-pid="<?php echo $pid; ?>"></i>
                <span class="like-count"><?php echo get_likes(); ?></span>
            </span>
        </li>
        <li>
            <span><i class="fa fa-comments-o"></i><?php comments_number('0', '1', '%'); ?></span>
        </li>
        <li>
            <span><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></span>
        </li>
    </ul>
</div><!-- .post-entry -->
<?php
    // Load ajax process
    wp_register_script('like_ajax', get_template_directory_uri() . '/js/update_like.js', array('jquery'));
    wp_localize_script('like_ajax', 'likeAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));

    wp_enqueue_script('jquery');
    wp_enqueue_script('like_ajax');
?>