<?php
if ( post_password_required() )
	return;
?>

<div id="post-comments">

	<?php //if (have_comments()) : ?>
		<h3 class="comments-title">
			<?php
				printf(_nx('%1s comment', '%1$s comments', get_comments_number(), 'comments title', 'maziu'),
					number_format_i18n(get_comments_number()));
			?>
		</h3>

		<ul class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
				) );
			?>
		</ul><!-- .comment-list -->

		<?php if (!comments_open() && get_comments_number()) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'twentythirteen' ); ?></p>
		<?php endif; ?>

	<?php //endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->