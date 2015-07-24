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
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 740;
}

if ( ! function_exists( 'wr_ferado_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Cosa 1.0
 */
function wr_ferado_setup() {

	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ferado, use a find and replace
	 * to change 'ferado' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'ferado', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Support woocommerce plugin for theme
	 */
	add_theme_support( 'woocommerce' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 *
	 * @link http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'gallery', 'video', 'quote', 'audio',
	) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'wr_ferado_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/**
	 * Setup the WordPress core custom header image.
	 */
	add_theme_support( 'custom-header', array(
		// Header text display default
		'header-text' => false,
		// Header image flex width
		'flex-width'  => true,
		// Header image width (in pixels)
		'width'       => 1170,
		// Header image flex height
		'flex-height' => true,
		// Header image height (in pixels)
		'height'      => 130,
	) );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus
	 */
	register_nav_menus( array(
		'main_menu'   => __( 'Main Menu', 'ferado' ),
		'top_menu'    => __( 'Top Menu', 'ferado' ),
	) );

	/**
	 * Tell the TinyMCE editor to use a custom stylesheet
	 */
	add_editor_style( 'assets/css/editor-style.css' );

}
endif; // wr_ferado_setup
add_action( 'after_setup_theme', 'wr_ferado_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @since Ferado 1.0
 */
function wr_ferado_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Right Sidebar', 'ferado' ),
		'id'            => 'primary-sidebar',
		'description'   => 'This is the right sidebar if you are using a two or three column site layout option.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'ferado' ),
		'id'            => 'secondary-sidebar',
		'description'   => 'This is the left sidebar if you are using a two or three column site layout option.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Bottom 1', 'ferado' ),
		'id'            => 'bottom-1',
		'description'   => 'The first column in bottom area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Bottom 2', 'ferado' ),
		'id'            => 'bottom-2',
		'description'   => 'The second column in bottom area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Bottom 3', 'ferado' ),
		'id'            => 'bottom-3',
		'description'   => 'The third column in bottom area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Bottom 4', 'ferado' ),
		'id'            => 'bottom-4',
		'description'   => 'The fourth column in bottom area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	if ( class_exists( 'BuddyPress' ) ) {
		register_sidebar( array(
			'name'          => __( 'BuddyPress Sidebar', 'ferado' ),
			'id'            => 'buddypress',
			'description'   => 'This is the buddypress sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'wr_ferado_widgets_init' );

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Ferado 1.0
 */
function wr_ferado_scripts() {
	// Load owl carousel stylesheet.
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/css/vendor/owl.carousel.css' );

	// Load font Awesome.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/vendor/font-awesome.min.css' );

	// Load our main stylesheet.
	wp_enqueue_style( 'ferado-main', get_template_directory_uri() . '/assets/css/main.css', array( 'dashicons' ) );

	// Load user custom stylesheet.
	wp_enqueue_style( 'ferado-custom', get_template_directory_uri() . '/assets/css/custom.css' );

	// Load jquery waypoints.
	wp_enqueue_script( 'waypoints-script', get_template_directory_uri() . '/assets/js/vendor/jquery.waypoints.min.js', array(), '', true );

	// Load scrollfix script.
	wp_enqueue_script( 'scrollfix-script', get_template_directory_uri() . '/assets/js/vendor/scrollfix.js', array(), '', true );

	// Load owl-carousel script.
	wp_enqueue_script( 'owl-carousel-script', get_template_directory_uri() . '/assets/js/vendor/owl.carousel.min.js', array(), '', true );

	// Load bx-slider script.
	wp_enqueue_script( 'bx-slider-script', get_template_directory_uri() . '/assets/js/vendor/jquery.bxslider.min.js', array(), '', true );

	// Load isotope script.
	wp_enqueue_script( 'owl-isotope-script', get_template_directory_uri() . '/assets/js/vendor/isotope.pkgd.min.js', array(), '', true );

	// Enqueue countdown timer script if maintenance mode is enable
	if ( wr_ferado_theme_option( 'wr_maintenance_mode' ) ) {
		wp_enqueue_script( 'jquery-countdown-script', get_template_directory_uri() . '/assets/js/vendor/jquery.countdown.js', array(), '', true );
	}

	// Load our custom javascript.
	$extraParams = array();
	wp_enqueue_script( 'ferado-main-script', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '', true );
	if ( 'masonry' == wr_ferado_theme_option( 'wr_blog_layout' ) ) {
		$extraParams['blog_masonry'] = wr_ferado_theme_option( 'wr_blog_layout' );
	}
	if ( wr_ferado_theme_option( 'wr_sticky_menu' ) ) {
		$extraParams['sticky_menu'] = wr_ferado_theme_option( 'wr_sticky_menu' );	
	}
	wp_localize_script( 'ferado-main-script', 'extraParams', $extraParams );

	// Adds the comment-reply JavaScript to the single post pages
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue style of WR Page Builder
	if ( class_exists( 'WR_Pb_Init' ) ) {
		wp_enqueue_style( 'ferado-pagebuilder', get_template_directory_uri() . '/assets/css/pagebuilder.css' );
	}

	// Enqueue custom style for woocommerce
	if ( class_exists( 'Woocommerce' ) ) {
		wp_enqueue_style( 'ferado-wcm', get_template_directory_uri() . '/assets/css/wcm.css' );
	}

	// Enqueue custom style for BuddyPress
	if ( class_exists( 'BuddyPress' ) ) {
		wp_enqueue_style( 'ferado-bdp', get_template_directory_uri() . '/assets/css/buddypress.css' );
	}

	// Load responsive stylesheet.
	wp_enqueue_style( 'ferado-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), '', 'screen' );
}
add_action( 'wp_enqueue_scripts', 'wr_ferado_scripts', 10000 );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/admin/customizer.php';

/**
 * Load sample data installer.
 */
require get_template_directory() . '/inc/admin/sample-data-installer.php';

/**
 * Additions field for advanced custom fields
 */
require get_template_directory() . '/inc/admin/acf.php';

/**
 * Filter the content width based on the user selected layout.
 */
require get_template_directory() . '/inc/ferado/layout.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/ferado/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/ferado/extras.php';

/**
 * HTML5 Schema Markup initialization.
 */
require get_template_directory() . '/inc/ferado/markup.php';

/**
 * Additions color schemes for theme.
 */
require get_template_directory() . '/inc/ferado/colors.php';

/**
 * Additions typography output.
 */
require get_template_directory() . '/inc/ferado/typography.php';

/**
 * Integrated AQ Resizer script.
 */
require get_template_directory() . '/inc/ferado/aq-resizer.php';

/**
 * Load TGM Plugin Activation library
 */
require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

/**
 * Additions function for woocommerce plugin.
 */
if ( class_exists( 'Woocommerce' ) ) {
	require get_template_directory() . '/inc/ferado/wcm.php';
}

/**
 * Define function to get theme option.
 *
 * @param   string  $option  Name of option to get value for.
 *
 * @return  mixed
 */
function wr_ferado_theme_option( $option ) {
	static $theme_options;

	// Get saved value for the specified option
	$value = get_theme_mod( $option, false );

	if ( false === $value ) {
		// Get all theme options
		if ( ! isset( $theme_options ) ) {
			$theme_options = wr_ferado_theme_options();
		}

		// Loop thru theme options to get default value for the specified option
		foreach ( $theme_options as $section => $define ) {
			if ( isset( $define['settings'][ $option ] ) && isset( $define['settings'][ $option ]['default'] ) ) {
				return $define['settings'][ $option ]['default'];
			}
		}
	}

	return $value;
}
