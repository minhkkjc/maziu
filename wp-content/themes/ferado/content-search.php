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
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); wr_ferado_schema_metadata( array( 'context' => 'entry' ) ); ?>>

	<?php
	if ( has_post_format('quote') ) :
		echo '<div class="quote-content"><i class="wr-icon-quote"></i>';
			the_excerpt( '' );
		echo '</div>';
	else :
	?>

		<header class="entry-header">

			<?php get_template_part( 'post', 'format' ); ?>

			<h2 class="entry-title" <?php wr_ferado_schema_metadata( array( 'context' => 'entry_title' ) ); ?>>
				<?php
					$post_format = get_post_format();
					switch ( $post_format ) :
						case 'gallery' :
							echo '<i class="wr-icon-gallery"></i>';
							break;

						case 'video' :
							echo '<i class="wr-icon-video"></i>';
							break;

						case 'audio' :
							echo '<i class="wr-icon-music"></i>';
							break;

						default:
							echo '<i class="wr-icon-edit"></i>';
							break;

					endswitch;

					the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' );
				?>
			</h2>

			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php wr_ferado_post_meta(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-summary" <?php wr_ferado_schema_metadata( array( 'context' => 'entry_content' ) ); ?>>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		
	<?php endif; ?>

</article><!-- #post-## -->