<li class="item-related">
	<?php if (has_post_thumbnail()) : ?>
	<a href="<?php the_permalink(); ?>" class="item-img" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a>
	<?php endif; ?>
	<h3>
		<a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><?php the_title(); ?></a>
	</h3>
</li>