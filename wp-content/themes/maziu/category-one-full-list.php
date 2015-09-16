<?php
/*
 * Category 1st full post and list layout
 */

$i = 0;
while (have_posts()) : the_post();
    $i++;
    if ($i == 1) {
        get_template_part('content', get_post_format());
    } else {
        if ($i == 2)
            echo '<div class="category-list-wrap">';

        get_template_part('category-item', get_post_format());
    }
endwhile;
if ($i > 1)
    echo '</div>';