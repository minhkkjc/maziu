<?php
/*
 * Category grid layout
 */
?>

<div class="category-grid-wrap">
    <?php
    while (have_posts()) : the_post();

        get_template_part('category-item', get_post_format());

    endwhile;
    ?>
</div>