<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (is_home()) : ?>

        <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </div><!-- .post-thumbnail -->
        <?php endif; ?>

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
            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
            <div class="post-excerpt"><?php the_excerpt(); ?></div>
            <div class="post-read-more">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="main-bg-hover main-border main-color ease-transition"><?php echo __('Continue reading'); ?></a>
            </div>
            <div class="post-socials"><?php echo do_shortcode('[post_socials]'); ?></div>
        </div><!-- .post-content -->

	<?php elseif (is_single()) : ?>

        <div class="post-content">
            <div class="post-categories"><?php the_category(''); ?></div>
            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php the_post_thumbnail(); ?>
                    </a>
                </div><!-- .post-thumbnail -->
            <?php endif; ?>

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
            <div class="post-content-detail"><?php the_content(); ?></div>
			<div class="post-content-footer clearfix">
				<div class="post-tags">
					Tags: 
					<?php 
						$tags = get_the_tags();
						$tag_arr = array();
						foreach ($tags as $tag) {
							$tag_link = get_tag_link($tag->term_id);
							$tag_arr[] = "<a href='" . $tag_link . "' class='main-color'>" . $tag->name . "</a>";
						}
						
						echo implode("<span class='main-color'>, </span>", $tag_arr);
					?>
				</div>
				<div class="post-socials"><?php echo do_shortcode('[post_socials]'); ?></div>
			</div>
        </div><!-- .post-content -->

    <?php endif; ?>
</article><!-- #post -->