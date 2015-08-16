<?php
if ( post_password_required() )
	return;
?>

<div id="post-comments">

	<?php //if (have_comments()) : ?>
		<p class="comments-title">
			<i class="fa fa-comments-o"></i>
			<?php
				printf(_nx('%1s comment', '%1$s comments', get_comments_number(), 'comments title', 'maziu'),
					number_format_i18n(get_comments_number()));
			?>
		</p>

		<ul class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
                    'callback'    => 'custom_comment_list'
				) );
			?>
		</ul><!-- .comment-list -->

		<?php if (!comments_open() && get_comments_number()) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'twentythirteen' ); ?></p>
		<?php endif; ?>

	<?php //endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->