<?php
if ( post_password_required() )
	return;
?>

<div id="post-comments">

	<?php if (have_comments()) : ?>
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

	<?php endif; ?>

	<?php
		$uid = get_current_user_id();
		$args = array(
			'title_reply' => '<span class="main-font">' . __('Leave a Comment', 'maziu') . '</span>',
			'title_reply_to' => '<span class="main-font">' . __('Leave a Comment to %s', 'maziu') . '</span>',
			'label_submit' => __('Submit Comment'),
			'fields' => apply_filters('comment_form_default_fields', array(
				'author' => (empty($uid) ? '<div class="comment-wrap clearfix"><div class="comment-left">' : '') . 
							'<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . 
							'" size="30"' . $aria_req . ' placeholder="' . __('Name', 'maziu') . ($req ? ' *' : '') . '" />',
				'email' => '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . 
							'" size="30"' . $aria_req . ' placeholder="' . __('Email', 'maziu') . ($req ? ' *' : '') . '" />',
				'url' => '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . 
							'" size="30"' . $aria_req . ' placeholder="' . __('Website', 'maziu') . '" />' .
							(empty($uid) ? '</div>' : ''),
			)),
			'comment_field' => (empty($uid) ? '<div class="comment-right">' : '') .
								'<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' .
								__('Your comment', 'maziu') . '"></textarea>' .
								(empty($uid) ? '</div></div>' : ''),
			'comment_notes_before' => '<p class="comment-notes">' .
			__('Your email address will not be published', 'maziu') .
			'</p>',
			'comment_notes_after' => '',
			'class_submit' => 'submit main-border main-color main-bg-hover ease-transition'
		);
		comment_form($args);
	?>

</div><!-- #comments -->