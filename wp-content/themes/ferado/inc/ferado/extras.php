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
 * Count the number of bottom sidebars to enable dynamic classes for the bottom
 *
 * @package Ferado
 */
function wr_ferado_bottom_sidebar_class() {
	// Count sidebar is enabled
	$count = 0;

	if ( is_active_sidebar( 'bottom-1' ) )
		$count++;

	if ( is_active_sidebar( 'bottom-2' ) )
		$count++;

	if ( is_active_sidebar( 'bottom-3' ) )
		$count++;

	if ( is_active_sidebar( 'bottom-4' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'columns twelve';
			break;
		case '2':
			$class = 'columns six';
			break;
		case '3':
			$class = 'columns four';
			break;
		case '4':
			$class = 'columns three';
			break;
	}
	if ( $class )
		echo 'class="' . $class . '"';
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	function wr_ferado_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'ferado' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'wr_ferado_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function wr_ferado_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'wr_ferado_render_title' );
endif;

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function wr_ferado_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'wr_ferado_setup_author' );

/**
 * Output the new logo to header
 *
 * @package Ferado
 */
function wr_ferado_logo() {
	if ( 'logo_image' == wr_ferado_theme_option( 'wr_logo_type' ) ) : ?>

		<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( wr_ferado_theme_option( 'wr_logo_image' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>

	<?php else : ?>

		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

	<?php endif;
}

/**
 * Change favicon option
 *
 * @package Ferado
 */
function wr_ferado_favicon() {
	if ( wr_ferado_theme_option( 'wr_favicon' ) )
		echo '<link sizes="16x16" href="'. wr_ferado_theme_option( 'wr_favicon' ) .'" rel="icon" />';
}
add_action( 'wp_head', 'wr_ferado_favicon', 1 );

/**
 * Google analytics ID, GA code is automatically embedded.
 *
 * @package Ferado
 */
function wr_ferado_google_analytics_code() {
	if ( wr_ferado_theme_option( 'wr_google_analytics_code' ) ) :
		echo '<scr' . 'ipt>' . wr_ferado_theme_option( 'wr_google_analytics_code' ) . '</scr' . 'ipt>';
	endif;
}
add_action( 'wp_head', 'wr_ferado_google_analytics_code' );

/**
 * Custom background.
 *
 * @package Ferado
 */
function wr_ferado_custom_page_background() {
	if ( wr_ferado_theme_option( 'background_image' ) ) :
		echo '
		<style>
			html body.custom-background {
				background-repeat: ' . wr_ferado_theme_option( 'wr_page_bg_repeat' ) . ';
				background-position: ' . wr_ferado_theme_option( 'wr_page_bg_position' ) . ' top;
				background-attachment: ' . wr_ferado_theme_option( 'wr_page_bg_attachment' ) . ';
			}
		</style>';
	endif;
}
add_action( 'wp_head', 'wr_ferado_custom_page_background' );

/**
 * Social channels renderer.
 *
 * @package Ferado
 */
function wr_ferado_social_channel() {

	$channels = array( 'facebook', 'twitter', 'dribbble', 'googleplus', 'vimeo', 'wordpress', 'pinterest', 'linkedin', 'yahoo',  'skype', 'stumbleupon', 'youtube', 'flickr', 'rss', 'myspace', 'tumblr' );

	$list = array();
	foreach ( $channels as $value ) {
		$mod_val = wr_ferado_theme_option( 'wr_social_' . $value );

		if ( $mod_val ) {
			$list[] = sprintf( '<li><a href="%s" title="%s" target="_blank"><i class="wr-icon-%s"></i></a></li>', esc_url ( $mod_val ), ucfirst( $value ), $value );
		}
	}
	$html = '';
	if ( $list ) :
		$html .= '<ul class="social">';
		$html .= implode( '', $list );
		$html .= '</ul>';
	endif;
	
	return $html;

}
add_action( 'wp_head', 'wr_ferado_social_channel' );

/**
 * Print custom code at the end of head section.
 *
 * @package Ferado
 */
function wr_ferado_custom_head() {
	$head = wr_ferado_theme_option( 'wr_code_at_end_of_head' );
	if ( $head ) :
		echo '' . esc_html( $head ) . "\n";
	endif;
}
add_action( 'wp_head', 'wr_ferado_custom_head', 999 );

/**
 * Print custom code at the end of body section.
 *
 * @package Ferado
 */
function wr_ferado_custom_footer() {
	$footer = wr_ferado_theme_option( 'wr_code_at_end_of_body' );
	if ( $footer ) :
		echo '' . esc_html( $footer ) . "\n";
	endif;
}
add_action( 'wp_footer', 'wr_ferado_custom_footer' );

/**
 * Print custom style of header image.
 *
 * @package Ferado
 */
function wr_ferado_custom_header_image() {
	if ( get_header_image() ) : ?>
		
		<style>
			.header-bot {
				background: url('<?php  esc_url( header_image() ); ?>') no-repeat 0 0;
			}
		</style>

	<?php
	endif;
}
add_action( 'wp_head', 'wr_ferado_custom_header_image' );

/**
 * Redirect to offline page
 *
 * @package Ferado
 */
function wr_ferado_maintenance_mode() {
	// Check if maintenance mode is enabled
	if ( wr_ferado_theme_option( 'wr_maintenance_mode' ) ) {
		if ( ! is_feed() ) {
			// Check if user is not logged in
			if ( ! is_user_logged_in() ) {
				// Load message for maintenance
				include get_template_directory() . '/offline.php';
				exit;
			}
		}

		// Check if user is logged in
		if ( is_user_logged_in() ) {
			global $current_user;

			// Get user role
			get_currentuserinfo();

			$loggedInUserID = $current_user->ID;
			$userData = get_userdata( $loggedInUserID );

			// If user role is not 'administrator' then redirect to coming soon page
			if ( 'administrator' != $userData->roles[0] ) {
				if ( ! is_feed() ) {
					include get_template_directory() . '/offline.php';

					exit;
				}
			}
		}
	}
}
add_action( 'template_redirect', 'wr_ferado_maintenance_mode' );

/**
 * Function social share
 *
 * Adds a dynamic bar with sharing icons
 */
if ( ! function_exists( 'wr_ferado_social_share' ) ) {
	function wr_ferado_social_share() {
		global $post;

		// Get post thumbnail
		$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' );
	?>
		<div class="single-share">
			<ul class="social">
				<li>
					<a title="Facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="wr-icon-facebook"></i>
						<span><?php _e( 'Facebook', 'ferado' ); ?></span>
					</a>
				</li>
				<li>
					<a title="Twitter" href="https://twitter.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="wr-icon-twitter"></i>
						<span><?php _e( 'Twitter', 'ferado' ); ?></span>
					</a>
				</li>
				<li>
					<a title="Googleplus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="wr-icon-googleplus"></i>
						<span><?php _e( 'Google Plus', 'ferado' ); ?></span>
					</a>
				</li>
				<li>
					<a title="Pinterest" href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $src[0]; ?>&description=<?php the_title(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="wr-icon-pinterest"></i>
						<span><?php _e( 'Pinterest', 'ferado' ); ?></span>
					</a>
				</li>
			</ul>
		</div>
	<?php
	}
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wr_ferado_body_class( $classes ) {
	if ( wr_ferado_theme_option( 'wr_maintenance_mode' ) ) {
		if ( ! is_feed() ) {
			// Check if user is not logged in
			if ( ! is_user_logged_in() ) {
				$classes[] = 'offline';
			}
		}
	}
	if ( wr_ferado_theme_option( 'wr_layout_boxed' ) ) {
		$classes[] = 'boxed';
	}
	return $classes;
}
add_filter( 'body_class', 'wr_ferado_body_class' );

/**
 * Register required plugins.
 *
 * @return  void
 */
function wr_ferado_register_theme_dependency() {
	$plugins = array(
		array(
			'name'     => 'WR Page Builder',
			'slug'     => 'wr-pagebuilder',
			'required' => true,
		),
		array(
			'name'     => 'WR Contact Form',
			'slug'     => 'wr-contactform',
			'required' => false,
		),
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => 'Revolution Slider',
			'slug'     => 'revslider',
			'source'   => get_template_directory_uri() . '/inc/plugins/revslider.zip',
			'required' => false,
		),
		array(
			'name'     => 'Envato WordPress Toolkit',
			'slug'     => 'envato-wordpress-toolkit',
			'source'   => get_template_directory_uri() . '/inc/plugins/envato-wordpress-toolkit.zip',
			'required' => false,
		),
		array(
			'name'     => 'YITH WooCommerce Wishlist',
			'slug'     => 'yith-woocommerce-wishlist',
			'required' => false,
		),
		array(
			'name'     => 'YITH WooCommerce Ajax Navigation',
			'slug'     => 'yith-woocommerce-ajax-navigation',
			'required' => false,
		),
		array(
			'name'             => 'Ferado Shortcodes',
			'slug'             => 'ferado-shortcodes',
			'source'           => get_template_directory_uri() . '/inc/plugins/ferado-shortcodes.zip',
			'required'         => true,
		),
		array(
			'name'     => 'Advanced Custom Fields',
			'slug'     => 'advanced-custom-fields',
			'required' => true,
		),
		array(
			'name'     => 'zM Ajax Login & Register',
			'slug'     => 'zm-ajax-login-register',
			'required' => false,
		)
	);

	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'wr_ferado_register_theme_dependency' );