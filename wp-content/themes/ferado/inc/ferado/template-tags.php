<?php
/**
 * @version    1.5
 * @package    Ferado
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

/**
 * Display navigation to next/previous set of posts when applicable.
 */
if ( ! function_exists( 'wr_ferado_pagination' ) ) :
	function wr_ferado_pagination( $nav_query = false ) {

		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		// Prepare variables
		$query        = $nav_query ? $nav_query : $wp_query;
		$max          = $query->max_num_pages;
		$current_page = max( 1, get_query_var( 'paged' ) );
		$big          = 999999;
		?>
		<nav class="page-nav cl" role="navigation">
			<?php
			echo '' . paginate_links(
				array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => $current_page,
					'total'     => $max,
					'type'      => 'list',
					'prev_text' => __( '&laquo;', 'ferado' ),
					'next_text' => __( '&raquo;', 'ferado' )
				)
			) . ' ';
			?>
		</nav><!-- .page-nav -->
		<?php
	}
endif;

/**
 * Prints HTML with meta information for the current post-date/time, author, categories and comments.
 */
if ( ! function_exists( 'wr_ferado_post_meta' ) ) :
	function wr_ferado_post_meta() {

		$byline = sprintf(
			_x( '<i class="wr-icon-user"></i>%s', 'post author', 'ferado' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>';

		// Used between list items, there is a space after the comma
		$categories_list = get_the_category_list( __( ', ', 'ferado' ) );
		if ( $categories_list ) :
			echo '<span class="cat-links">';
				printf( __( '<i class="wr-icon-category"></i>%1$s', 'ferado' ), $categories_list );
			echo '</span>';
		endif;

		// Get comments
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) :
			echo '<span class="comments-link"><i class="wr-icon-comments"></i>';
				comments_popup_link( __( '0 Comment', 'ferado' ), __( '1 Comment', 'ferado' ), __( '% Comments', 'ferado' ) );
			echo '</span>';
		endif;
	}
endif;

/**
 * custom function to use to open and display each comment
 */
if ( ! function_exists( 'wr_ferado_comments' ) ) :
	function wr_ferado_comments( $comment, $args, $depth ) {
	// Globalize comment object
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :

			case 'pingback'  :
			case 'trackback' :
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p>
						<?php
						_e( 'Pingback:', 'ferado' );
						comment_author_link();
						edit_comment_link( __( 'Edit', 'ferado' ), '<span class="edit-link">', '</span>' );
						?>
					</p>
				<?php
			break;

			default :
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment-body" <?php wr_ferado_schema_metadata( array( 'context' => 'comment' ) ); ?>>
						<div class="comment-avatar">
							<?php echo get_avatar( $comment, 72 ); ?>
							<div class="action-link">
								<?php
								edit_comment_link( __( '<span>Edit</span>', 'ferado' ) );
								comment_reply_link(
									array_merge(
										$args,
										array(
											'reply_text' => __( '<span>Reply</span>', 'ferado' ),
											'depth'      => $depth,
											'max_depth'  => $args['max_depth'],
										)
									)
								);
								?>
							</div><!-- .action-link -->
						</div>
						<?php
						
						if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'ferado' ); ?></p>
						<?php endif; ?>

						<header class="comment-meta">
							<?php
							printf(
								'<cite class="comment-author" ' . wr_ferado_schema_metadata( array( 'context' => 'comment_author', 'echo' => false ) ) . '>%1$s</cite>',
								'<span ' . wr_ferado_schema_metadata( array( 'context' => 'author_name', 'echo' => false ) ) . '>' . get_comment_author_link() . '</span>',
								( $comment->user_id == $post->post_author ) ? '<span class="author-post">' . __( 'Post author', 'ferado' ) . '</span>' : ''
							);

							printf(
								'<a href="%1$s"><time ' . wr_ferado_schema_metadata( array( 'context' => 'comment_time', 'echo' => false ) ) . '><span> - </span> %3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								sprintf( __( '%1$s at %2$s', 'ferado' ), get_comment_date(), get_comment_time() )
							);

							?>
						</header>

						<section class="comment-content comment" <?php wr_ferado_schema_metadata( array( 'context' => 'comment_text' ) ); ?>>
							<?php
							comment_text();
							?>
						</section><!-- .comment-content -->
							
					</article><!-- #comment- -->
				<?php
			break;

		endswitch;
	}
endif;
