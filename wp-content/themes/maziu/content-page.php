<?php
/**
 * Display for page
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="post-content">
        <?php the_content(); ?>
    </div><!-- .post-content -->

</article><!-- #post -->