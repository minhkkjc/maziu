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

global $post;

// Get post format
$post_format = get_post_format();

// Post format video
$video       = ( function_exists( 'get_field' ) ) ? get_field( 'video', get_the_ID() ) : '';
$video_url   = ( function_exists( 'get_field' ) ) ? get_field( 'video_url', get_the_ID() ) : '';
$video_code  = ( function_exists( 'get_field' ) ) ? get_field( 'video_code', get_the_ID() ) : '';
$video_local = ( function_exists( 'get_field' ) ) ? get_field( 'video_local', get_the_ID() ) : '';

// Post format audio
$audio       = ( function_exists( 'get_field' ) ) ? get_field( 'audio', get_the_ID() ) : '';
$audio_url   = ( function_exists( 'get_field' ) ) ? get_field( 'audio_url', get_the_ID() ) : '';
$audio_local = ( function_exists( 'get_field' ) ) ? get_field( 'audio_local', get_the_ID() ) : '';

// Post format gallery
$gallery = ( function_exists( 'get_field' ) ) ? get_field( 'gallery', get_the_ID() ) : array();

if ( post_password_required() ) { ?>

	<div class="entry-thumb">
		<form action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
			<input name="post_password" type="password" size="20" maxlength="20" />
		</form>
	</div><!-- .entry-thumb -->

<?php } else { ?>

	<div class="entry-thumb">
		<?php if ( 'masonry' != wr_ferado_theme_option( 'wr_blog_layout' ) ) : ?>
			<span class="posted-on">
				<span class="date"><?php echo the_time( 'j' ); ?></span>
				<span class="month"><?php echo the_time( 'M' ); ?></span>
				<span class="year"><?php echo the_time( 'Y' ); ?></span>
			</span><!-- .posted-on -->
		<?php
			endif;
		switch ( $post_format ):
			case 'gallery' :
				echo do_shortcode( $gallery );
			break;

			case 'video' :
				if ( 'link' == $video ) :
					echo do_shortcode( '[wr_video video_source_link_youtube="' . esc_url( $video_url ) . '" video_sources="youtube"][/wr_video]' );
					echo do_shortcode( '[wr_video video_source_link_vimeo="' . esc_url( $video_url ) . '" video_sources="vimeo"][/wr_video]' );
				elseif ( 'embed' == $video ) :
					echo $video_code;
				elseif ( 'local' == $video ) :
					echo do_shortcode('[video src="' . esc_url( $video_local['url'] ) . '"/]');
				endif;
			break;

			case 'audio':
				if ( 'link' == $audio ) :
					global $wp_embed;
					$media_result = $wp_embed->run_shortcode( '[embed]' . esc_url( $audio_url ) . '[/embed]' );
					echo $media_result;
				elseif ( 'local' == $audio ) :
					echo do_shortcode('[audio src="' . esc_url( $audio_local['url'] ) . '"/]');
				endif;
			break;
			
			default:

			if ( 'small_thumb' == wr_ferado_theme_option( 'wr_blog_layout' ) ) {
				$link  = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
				$image = aq_resize( $link, 400, 400, true );

				echo '<a href="' . esc_url( get_permalink() ) . '"><img src="' . esc_url( $image ) . '" alt="' . get_the_title() . '" width="" height="" /></a>';

			} else {

				if ( has_post_thumbnail() ) { ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
		<?php } else { ?>
					<a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri() . '/assets/img/placeholder.png' ?>" width="850" height="340" alt="Ferado" /></a>
			<?php }
			}
			break;
		endswitch;
		?>
	</div><!-- .entry-thumb -->

<?php }