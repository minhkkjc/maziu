<?php

get_header();
?>

    <div id="no-content-wrap">

    </div><!-- #no-content-wrap -->

    <div id="main-content-wrap">
        <div id="main-content" class="content">
            <div id="main-content-inner" class="clearfix">
                <div id="primary" class="content-area">
                    <div id="content" class="site-content">

                        <?php while (have_posts()) : the_post(); ?>
                            <?php
                                update_hits(get_hits());
                                get_template_part('content', get_post_format());
                            ?>
						
						<div class="post-author clearfix">
							<div class="pa-left">
								<div class="pa-avatar">
									<?php echo get_avatar(get_the_author_meta('ID'), 95); ?>
								</div>
								<div class="pa-social">
									<ul class="clearfix">
										<li>
											<a href="<?php echo get_the_author_meta('facebook') ? get_the_author_meta('facebook') : '#'; ?>" class="main-color ease-transition">
												<i class="fa fa-facebook"></i>
											</a>
										</li>
										<li>
											<a href="<?php echo get_the_author_meta('twitter') ? get_the_author_meta('twitter') : '#'; ?>" class="main-color ease-transition">
												<i class="fa fa-twitter"></i>
											</a>
										</li>
										<li>
											<a href="<?php echo get_the_author_meta('google') ? get_the_author_meta('google') : '#'; ?>" class="main-color ease-transition">
												<i class="fa fa-google-plus"></i>
											</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="pa-right">
								<p class="pa-name">
									<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php the_author(); ?>">
										<?php
											if (!empty(get_the_author_meta('first_name')) && !empty(get_the_author_meta('last_name'))) {
												$fullname = get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name');
												echo $fullname;
											} else {
												echo get_the_author_meta('nickname');
											}
										?>
									</a>
								</p>
								<div class="pa-bio"><?php echo get_the_author_meta('description'); ?></div>
							</div>
						</div><!-- .post-author -->
						
						<div class="post-related">
							<p class="pr-title"><?php _e('You might also like', 'maziu'); ?></p>
							<?php 
								$categories = get_the_category($post->ID);
								$category_ids = array();
								foreach ($categories as $category) {
									$category_ids[] = $category->term_id;
								}
								
								$args = array(
									'category__in' => $category_ids,
									'post__not_in' => array($post->ID),
									'posts_per_page' => 3,
									'orderby' => 'rand',
									'ignore_sticky_posts' => 1
								);
								
								$query = new wp_query($args);
								
								if ($query->have_posts()) :
							?>
							<ul class="post-related-list clearfix">
								<?php 
									while ($query->have_posts()) :
										$query->the_post();
								?>
								<li class="item-related">
									<?php if (has_post_thumbnail()) : ?>
									<a href="<?php the_permalink(); ?>" class="item-img" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a>
									<?php endif; ?>
									<h3>
										<a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><?php the_title(); ?></a>
									</h3>
								</li>
								<?php 
									endwhile;
									wp_reset_postdata();
								?>
							</ul>
							<?php 
								endif;
							?>
						</div><!-- .post-related -->
						
						<?php comments_template(); ?>
						
						<?php endwhile; ?>
						
                    </div><!-- #content -->
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