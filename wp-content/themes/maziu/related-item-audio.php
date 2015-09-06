<li class="item-related">
	<div class="post-thumbnail">
        <div class="fluid-audio-wrapper">
            <?php echo get_soundcloud($post->ID); ?>
        </div><!-- .fluid-video-wrapper -->
    </div><!-- .post-thumbnail -->
	<h3>
		<a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><?php the_title(); ?></a>
	</h3>
</li>