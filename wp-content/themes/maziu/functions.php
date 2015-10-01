<?php

/*
 * Include vimeo shortcode
 */
require_once(get_template_directory() . '/inc/vimeo_shortcode.php');

function maziu_setup() {
    load_theme_textdomain('maziu', get_template_directory() . '/languages');

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');

    /*
     * Switches default core markup for search form, comment form,
     * and comments to output valid HTML5.
     */
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ));

    /*
     * This theme supports post formats.
     */
    add_theme_support('post-formats', array(
        'audio', 'gallery', 'image', 'quote', 'video'
    ));

    // This theme uses wp_nav_menu() in one location.
    register_nav_menu('mainmenu', __( 'Main Menu', 'maziu' ));

    /*
     * This theme uses a custom image size for featured images, displayed on
     * "standard" posts and pages.
     */
    add_theme_support('post-thumbnails');
    add_image_size('module-size', 450, 306, true);
    set_post_thumbnail_size(1110, 756, true);
}
add_action('after_setup_theme', 'maziu_setup');

/*
 * Get the Google font stylesheet URL
 */
function maziu_font_url() {
    $options = get_option('maziu_option');

    if (empty($options['font_text_family']))
    {
        $font = 'Lato'; // Lato font
    } else {
        $font = $options['font_text_family'];
    }

    $fonts_arr = json_decode(file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBgzCr9pt5xS09me72S91tTaCmLtAzWkOE'));
	
    $query_args = array(
        'family' => $font
    );
	
    $font_style = "
        body, .main-font {
            font-family: '" . $font . "', Arial, sans-serif;
        }
    ";
    wp_add_inline_style('maziu-style', $font_style);

    $font_url = add_query_arg($query_args, '//fonts.googleapis.com/css');
    return $font_url;
}

/*
 * Get the Google font stylesheet URL for titles
 */
function maziu_font_title_url()
{
    $query_args = array(
        'family' => urlencode('Playfair Display:regular,italic'),
    );

    $font_url = add_query_arg($query_args, '//fonts.googleapis.com/css');
    return $font_url;
}

/*
 * Enqueue scripts and styles for the front end.
 */
function maziu_scripts_styles() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    wp_enqueue_script('maziu-script', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);
    wp_enqueue_script('bx-slider-script', get_template_directory_uri() . '/js/bxslider/jquery.bxslider.min.js', array('jquery'), null);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.js', array('jquery'));

	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/fonts/fontawesome/css/font-awesome.min.css', array(), null);
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style('maziu-style', get_stylesheet_uri(), array(), '2015-03-05');
    wp_enqueue_style('maziu-font', maziu_font_url(), array(), null);
    wp_enqueue_style('maziu-font-title', maziu_font_title_url(), array(), null);

    wp_enqueue_style('maziu-ie', get_template_directory_uri() . '/css/ie.css', array('maziu-style'));
    wp_style_add_data( 'maziu-ie', 'conditional', 'lt IE 9' );
}
add_action('wp_enqueue_scripts', 'maziu_scripts_styles');

/*
 * Filter the page title.
 */
function maziu_wp_title( $title, $sep ) {

    $title .= get_bloginfo( 'name', 'display' );

    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    return $title;
}
add_filter( 'wp_title', 'maziu_wp_title', 10, 2 );

/*
 * Register widget areas
 */
function maziu_widgets_init() {
    register_sidebar(array(
        'name'          => __( 'Main Widget Area', 'maziu' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Main Widget Area', 'maziu' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
	
	register_sidebar(array(
		'name'          => __( 'Footer Widget Area', 'maziu' ),
        'id'            => 'sidebar-2',
        'description'   => __( 'Footer Widget Area', 'maziu' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
	));
}
add_action('widgets_init', 'maziu_widgets_init');

/*
 * Add script file for admin
 */
function maziu_admin_scripts($hook) {
    wp_enqueue_style('maziu_admin_style', get_template_directory_uri() . '/css/admin.css', false, '1.0.0');
    wp_enqueue_script('maziu_admin_script', get_template_directory_uri() . '/js/admin.js', false, '1.0.0');
}
add_action('admin_enqueue_scripts', 'maziu_admin_scripts');

/*
 * Custom excerpt
 */
function maziu_excerpt_length($length) {
	return 25;
}
add_filter('excerpt_length', 'maziu_excerpt_length', 999);

function maziu_excerpt_more($more) {
	return ' ...';
}
add_filter('excerpt_more', 'maziu_excerpt_more');

/*
 * Slideshow
 */
function maziu_slideshow()
{
	global $post;

	$options = get_option('maziu_option');
	if (!isset($options['slide_count']))
		$options['slide_count'] = 4;

	if (!empty($options['slide_count'])) :
		$args = array(
			'meta_key' => '_slideshow',
			'meta_value' => 1,
			'posts_per_page' => $options['slide_count'],
			'offset' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_status' => 'publish'
		);

		$posts = get_posts($args);
	?>
    <div id="main-slideshow">
        <div class="slideshow">
            <?php
            foreach ($posts as $post) :
                setup_postdata($post);
                ?>
                <div class="slider-box">
                    <div class="sb-main">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="slider-image">
                            <?php if (has_post_thumbnail()) the_post_thumbnail(); ?>
                        </a>
                        <div class="sb-main-info">
                            <?php
                                $categories = get_the_category($post->ID);
                                if (!empty($categories)) :
                            ?>
                            <ul class="categories-list main-bg clearfix">
                            <?php foreach ($categories as $category) : ?>
                                <li>
                                    <a href="<?php echo get_category_link($category->term_id); ?>" title="<?php echo esc_attr($category->name) ?>"><?php echo $category->name; ?></a>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                            <h3 class="ease-transition">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words(get_the_title(), 7, '...'); ?></a>
                            </h3>
                        </div>
                    </div>
                    <div class="sb-meta">
                        <ul class="clearfix">
                            <li>
                                <?php
                                // Check current user liked this post
                                $pid = get_the_ID();
                                $baseurl = get_site_url();
                                $cookie_name = $baseurl . '-like-' . $pid;
                                $cookie = get_cookie($cookie_name);

                                if (!empty($cookie)) {
                                    $liked = 1;
                                } else {
                                    $liked = 0;
                                }
                                ?>
                                <span>
                                    <i class="fa <?php echo ($liked) ? 'fa-heart' : 'fa-heart-o'; ?> post-like post-like-<?php echo $pid; ?> main-color"
                                       data-pid="<?php echo $pid; ?>"></i>
                                    <span class="like-count"><?php echo get_likes(); ?></span>
                                </span>
                            </li>
                            <li>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title() ?>" class="read-more main-color"><?php echo __('Continue reading'); ?></a>
                            </li>
                            <li>
                                <i class="fa fa-comments-o main-color"></i><?php comments_number('0', '1', '%') ?>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(function($) {
            $('.slideshow').bxSlider({
                slideWidth: $('body').width() / 3,
                minSlides: 2,
                maxSlides: 3,
                slideMargin: 0,
                moveSlides: 1,
                pager: false,
                nextText: '<span class="main-border-hover main-color-hover ease-transition"><i class="fa fa-angle-right"></i></span>',
                prevText: '<span class="main-border-hover main-color-hover ease-transition"><i class="fa fa-angle-left"></i></span>'
            });
        });
    </script>
	<?php
	endif;
}

/*
 * Shortcodes
 */

// Socials
function socials_shortcode($atts)
{
	$a = shortcode_atts(array(
		'class' => 'main-color',
        'position' => 'center'
	), $atts);
	
	ob_start();
	?>
    <div class="socials-wrap" style="text-align: <?php echo $a['position']; ?>">
        <ul class="socials clearfix social-list">
            <li>
                <a href="#" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-facebook"></i></a>
            </li>
            <li>
                <a href="#" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
                <a href="#" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-google-plus"></i></a>
            </li>
            <li>
                <a href="#" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-dribbble"></i></a>
            </li>
            <li>
                <a href="#" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-linkedin"></i></a>
            </li>
            <li>
                <a href="#" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-rss"></i></a>
            </li>
        </ul>
    </div>
	<?php
	return ob_get_clean();
}
add_shortcode('socials', 'socials_shortcode');

function post_socials_shortcode($atts)
{
	$a = shortcode_atts(array(
		'class' => 'main-color',
		'class_ul' => '',
	), $atts);

    $url = urlencode(get_the_permalink());
    $facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $url;
    $google = 'https://plus.google.com/share?url=' . $url;
    $twitter = 'https://twitter.com/home?status=' . $url;

    if (has_post_thumbnail()) {
        $pinterest = 'https://pinterest.com/pin/create/button/?url=' . get_the_permalink() . '&media=' . urlencode(wp_get_attachment_url(get_post_thumbnail_id())) . '&description=' . get_the_title();
    } else {
        $pinterest = '#';
    }

    $linkedin = 'https://www.linkedin.com/shareArticle?url=' . $url . '&title=' . get_the_title();

	ob_start();
	?>
	<ul class="post-socials-list social-list clearfix <?php echo $a['class_ul']; ?>">
		<li>
			<a href="<?php echo $facebook; ?>" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-facebook"></i></a>
		</li>
		<li>
			<a href="<?php echo $twitter; ?>" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-twitter"></i></a>
		</li>
		<li>
			<a href="<?php echo $google; ?>" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-google-plus"></i></a>
		</li>
		<li>
			<a href="<?php echo $pinterest; ?>" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-pinterest"></i></a>
		</li>
		<li>
			<a href="<?php echo $linkedin; ?>" class="<?php echo $a['class']; ?> ease-transition"><i class="fa fa-linkedin"></i></a>
		</li>
	</ul>
	<?php
	return ob_get_clean();
}
add_shortcode('post_socials', 'post_socials_shortcode');

/*
 * Add admin menus
 */
class maziuSettings
{
    private $options;
    private $fonts;

    const CATEGORY_LAYOUT_LIST = 1;
    const CATEGORY_LAYOUT_GRID = 2;
    const CATEGORY_LAYOUT_LIST_SPECIAL = 3;
    const CATEGORY_LAYOUT_GRID_SPECIAL = 4;

    private function _getCategoriesLayout() {
        if (empty($this->_categoriesLayout)) {
            return array(
                'list' => __('List', 'maziu'),
                'one-full-list' => __('1st Full Post and List', 'maziu'),
                'grid' => __('Grid', 'maziu'),
                'one-full-grid' => __('1st Full Post and Grid', 'maziu'),
            );
        } else {
            return $this->_categoriesLayout;
        }
    }

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    public function add_page()
    {

        /*
         * Add maziu settings menu
         */
        add_menu_page(
            'maziu',
            'maziu',
            'administrator',
            'maziu-settings-page',
            array($this, 'maziu_settings_page')
        );

        /*
         * Add font settings menu
         */
        add_submenu_page(
            'maziu-settings-page',
            'Google fonts',
            'Google fonts',
            'administrator',
            'maziu-fonts-page',
            array($this, 'maziu_fonts_page')
        );

        /*
         * Add slideshow settings menu
         */
        add_submenu_page(
            'maziu-settings-page',
            'Slideshow settings',
            'Slideshow',
            'administrator',
            'maziu-slideshow-page',
            array($this, 'maziu_slideshow_page')
        );
    }

    public function maziu_settings_page()
    {
        $this->options = get_option('maziu_option');
        ?>
        <div class="wrap">
            <h2><?php _e('General', 'maziu') ?></h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('maziu_group');
                do_settings_sections('maziu-settings-page');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /*
     * Call back for font settings page
     */
    public function maziu_fonts_page()
    {
        $this->options = get_option('maziu_option');

        $fonts_arr = json_decode(file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBgzCr9pt5xS09me72S91tTaCmLtAzWkOE'));

        if (!isset($this->options['font_text_family']))
        {
            $this->options['font_text_family'] = 'Lato'; // Font Lato
        }

        if (!empty($fonts_arr->items))
        {
            foreach ($fonts_arr->items as $k => $font)
            {
                $selected_text = (isset($this->options['font_text_family']) && $this->options['font_text_family'] == $font->family) ? ' selected' : '';
                $this->fonts['font_text']['family'] .= '<option value="' . $font->family . '"' . $selected_text . '>' . $font->family . '</option>';
            }
        }

        ?>
        <div class="wrap">
            <h2>Google Fonts</h2>
            <form method="post" action="options.php">
            <?php
                settings_fields('maziu_group');
                do_settings_sections('maziu-fonts-page');
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /*
     * Call back for feature post settings page
     */
    public function maziu_slideshow_page()
    {
        $this->options = get_option('maziu_option');
        ?>
        <div class="wrap">
            <h2>Slideshow settings</h2>
            <form method="post" action="options.php">
            <?php
                settings_fields('maziu_group');
                do_settings_sections('maziu-slideshow-page');
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    public function page_init()
    {
        register_setting(
            'maziu_group',
            'maziu_option',
            array($this, 'sanitize')
        );

        /*
         * General page
         */
        add_settings_section(
            'general_categories_section',
            __('Categories settings', 'maziu'),
            '',
            'maziu-settings-page'
        );

        add_settings_field(
            'categories_layout',
            __('Categories layout', 'maziu'),
            array($this, 'categories_layout_callback'),
            'maziu-settings-page',
            'general_categories_section'
        );

        /*
         * Fonts page
         */
        add_settings_section(
            'font_text_section',
            '',
            '',
            'maziu-fonts-page'
        );

        add_settings_field(
            'font_text_family',
            'Font family',
            array($this, 'font_text_family_callback'),
            'maziu-fonts-page',
            'font_text_section'
        );

        /*
         * Slideshow page
         */
        add_settings_section(
            'slideshow_section',
            '',
            '',
            'maziu-slideshow-page'
        );

        add_settings_field(
            'category_name',
            'Category name',
            array($this, 'category_name_callback'),
            'maziu-slideshow-page',
            'slideshow_section'
        );
		
		add_settings_field(
            'slide_count',
            'Count',
            array($this, 'slide_count_callback'),
            'maziu-slideshow-page',
            'slideshow_section'
        );
    }

    public function sanitize($input)
    {
        $new_input = get_option('maziu_option');

        /*
         * General page
         */
        if (isset($input['categories_layout']))
            $new_input['categories_layout'] = $input['categories_layout'];

        /*
         * Fonts page
         */
        if (isset($input['font_text_family']))
            $new_input['font_text_family'] = sanitize_text_field($input['font_text_family']);

        /*
         * Slideshow page
         */
        if (isset($input['category_name']))
            $new_input['category_name'] = sanitize_text_field($input['category_name']);
		
		if (isset($input['slide_count']))
			$new_input['slide_count'] = absint($input['slide_count']);

        return $new_input;
    }

    public function categories_layout_callback() {
        $categories = get_categories(array(
            'hide_empty' => 0
        ));

        $html = '<table class="wp-list-table widefat striped categories-layout-table">';
        $html .= '<thead><tr>';
        $html .= '<th>' . __('Category', 'maziu') . '</th>';
        $html .= '<th>' . __('Layout', 'maziu') . '</th>';
        $html .= '</tr></thead>';
        $html .= '<tbody id="the-list">';

        if (!empty($categories)) :
            foreach ($categories as $category) {
                $html .= '<tr>';
                $html .= '<td>' . $category->name . '</td>';
                $html .= '<td>';
                $html .= '<select name="maziu_option[categories_layout][' . $category->term_id . ']">';

                $categoriesLayout = self::_getCategoriesLayout();
                if (!empty($categoriesLayout)) :
                    foreach ($categoriesLayout as $key => $layout) {
                        $html .= '<option value="' . $key . '"' .
                                (($this->options['categories_layout'][$category->term_id] == $key) ? ' selected' : '') . '>' .
                                $layout . '</option>';
                    }
                endif;

                $html .= '</select>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        endif;

        $html .= '</tbody>';
        $html .= '</table>';
        printf($html);
    }

    public function font_text_family_callback()
    {
        printf(
            '<select id="font-text-family" name="maziu_option[font_text_family]" class="google-font-family">' . $this->fonts['font_text']['family'] . '</select>'
        );
    }

    public function category_name_callback()
    {
        printf(
            '<input type="text" id="category-name" name="maziu_option[category_name]" value="%s" />',
            isset($this->options['category_name']) ? esc_attr($this->options['category_name']) : ''
        );
    }
	
	public function slide_count_callback()
	{
		printf(
			'<input type="text" id="slide-count" name="maziu_option[slide_count]" value="%s" />',
			isset($this->options['slide_count']) ? esc_attr($this->options['slide_count']) : ''
		);
	}
}

if (is_admin())
    $my_settings_page = new maziuSettings();


/* Widgets */

/*
 * Adds About me widget
 */

class About_Me_Widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'about_me_widget',
			__('Maziu About Me Widget', 'maziu'),
			array('description' => __('A About Me Widget', 'maziu'))
		);
	}
	
	public function widget($args, $instance) {
		global $post;
		
		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}

		if (!empty($instance['post_slug'])) {
			$post_slug = trim($instance['post_slug']);

			$array = array(
				'name' => $post_slug,
				'post_status' => 'publish',
				'numberposts' => 1
			);

			$posts = get_posts($array);
			if (!empty($posts)) {
				$post = $posts[0];
				setup_postdata($post);
			?>
			<div class="about-me-thumbnail">
			<?php
				if (has_post_thumbnail()) {
					the_post_thumbnail('medium');
				}
			?>
			</div>

			<div class="about-me-excerpt"><?php echo wp_trim_words(get_the_content(), 25, '...'); ?></div>

			<div class="about-me-read-more">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo __('Continue reading', 'maziu'); ?></a>
			</div>
			<?php
				wp_reset_postdata();
			}
		}
		
		echo $args['after_widget'];
	}
	
	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
		$post_slug = !empty($instance['post_slug']) ? $instance['post_slug'] : __('Enter post slug', 'maziu');
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('post_slug'); ?>"><?php _e('Post slug:', 'maziu'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('post_slug'); ?>" 
			       name="<?php echo $this->get_field_name('post_slug'); ?>" type="text" value="<?php echo esc_attr($post_slug); ?>" />
		</p>
		<?php
	}
	
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
		$instance['post_slug'] = !empty($new_instance['post_slug']) ? strip_tags($new_instance['post_slug']) : '';
		
		return $instance;
	}
	
}

/*
 * Add follow widget
 */

class Follow_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'follow_widget',
            __('Maziu Follow Widget', 'maziu'),
            array('description' => __('A Follow Widget', 'maziu'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo do_shortcode('[socials]');

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }

}

/*
 * Add categories widget
 */

class Categories_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'categories_widget',
            __('Maziu Categories Widget', 'maziu'),
            array('description' => __('A Categories Widget', 'maziu'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $array = array(
            'type' => 'post',
            'parent' => 0,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 0,
            'pad_counts' => 1
        );

        $categories = get_categories($array);
        ?>
        <ul class="categories-list">
        <?php foreach ($categories as $k => $cat) : ?>
            <li class="clearfix">
                <a href="<?php echo get_category_link($cat->term_id); ?>" title="<?php echo esc_attr($cat->name); ?>" class="main-color-hover"><?php echo $cat->name; ?></a>
                <span class="post-count main-color">(<?php echo $cat->count; ?>)</span>
            </li>
        <?php endforeach; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }

}

/*
 * Add popular posts widget
 */

class Popular_Posts_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'popular_posts_widget',
            __('Maziu Popular Posts Widget', 'maziu'),
            array('description' => __('A Popular Posts Widget', 'maziu'))
        );
    }

    public function widget($args, $instance) {
        global $post;

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        if (!empty($instance['count'])) {
            $count = (int)$instance['count'];
        }

        if (empty($count)) $count = 5;

        $array = array(
            'numberposts' => $count,
            'post_type' => 'post',
            'post_status' => 'publish',
            'meta_key' => '_hit-counter',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );

        $posts = get_posts($array);
        ?>
        <ul class="popular-post-list">
        <?php
        foreach ($posts as $post) :
            setup_postdata($post);
        ?>
            <li class="popular-post clearfix">
                <div class="popular-post-thumbnail">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="thumbnail-hover">
						<?php the_post_thumbnail('thumbnail'); ?>
                        <div class="thumbnail-cover ease-transition"></div>
					</a>
                </div>
                <div class="popular-post-info">
                    <h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
                    <div class="popular-post-meta clearfix">
                        <div class="post-likes">
                            <?php
                            // Check current user liked this post
                            $pid = get_the_ID();
                            $baseurl = get_site_url();
                            $cookie_name = $baseurl . '-like-' . $pid;
                            $cookie = get_cookie($cookie_name);

                            if (!empty($cookie)) {
                                $liked = 1;
                            } else {
                                $liked = 0;
                            }
                            ?>
                            <span>
                                    <i class="fa <?php echo ($liked) ? 'fa-heart' : 'fa-heart-o'; ?> post-like post-like-<?php echo $pid; ?> main-color"
                                       data-pid="<?php echo $pid; ?>"></i>
                                    <span class="like-count"><?php echo get_likes(); ?></span>
                                </span>
                        </div>
                        <div class="post-hits">
                            <i class="fa fa-comments-o main-color"></i>
                            <?php comments_number('0', '1', '%'); ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php
        endforeach;
        wp_reset_postdata();
        ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
        $count = !empty($instance['count']) ? $instance['count'] : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:', 'maziu'); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = !empty($new_instance['count']) ? (int)strip_tags($new_instance['count']) : 5;

        return $instance;
    }

}

/*
 * Add news letter widget
 */

class News_Letter_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'news_letter_widget',
            __('Maziu News Letter Widget', 'maziu'),
            array('description' => __('A News Letter Widget', 'maziu'))
        );
    }

    public function widget($args, $instance) {
        global $post;

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        if (!empty($instance['description'])) {
            echo '<p class="news-letter-desc">' . strip_tags($instance['description']) . '</p>';
        }
        ?>
        <div class="news-letter-input">
            <input type="text" name="email" placeholder="<?php echo __('Your email address..'); ?>" class="main-border-focus" />
            <i class="fa fa-envelope-o main-color"></i>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
        $description = !empty($instance['description']) ? $instance['description'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'maziu'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('description'); ?>"
                   name="<?php echo $this->get_field_name('description'); ?>"><?php echo $description; ?></textarea>
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['description'] = !empty($new_instance['description']) ? strip_tags($new_instance['description']) : '';

        return $instance;
    }

}

/*
 * Add Popular Tags widget
 */

class Popular_Tags_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'popular_tags_widget',
            __('Maziu Popular Tags Widget', 'maziu'),
            array('description' => __('A Popular Tags Widget', 'maziu'))
        );
    }

    public function widget($args, $instance) {
        global $post;

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        if (!empty($instance['count'])) {
            $count = (int)$instance['count'];
        }

        if (empty($count)) $count = 10;

        $array = array(
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => $count
        );

        $tags = get_tags($array);
        ?>
        <ul class="popular-tags-list clearfix">
        <?php
        foreach ($tags as $tag) :
        ?>
            <li class="popular-tag <?php echo $tag->slug; ?>">
                <a href="<?php echo get_tag_link($tag->term_id); ?>" title="<?php echo $tag->name; ?>" class="main-color-hover main-border-hover"><?php echo $tag->name; ?></a>
            </li>
        <?php
        endforeach;
        ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
        $count = !empty($instance['count']) ? $instance['count'] : 10;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:', 'maziu'); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = !empty($new_instance['count']) ? (int)strip_tags($new_instance['count']) : 10;

        return $instance;
    }

}

/*
 * Add liked posts widget
 */

class Liked_Posts_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'liked_posts_widget',
            __('Maziu Liked Posts Widget', 'maziu'),
            array('description' => __('A Liked Posts Widget', 'maziu'))
        );
    }

    public function widget($args, $instance) {
        global $post;

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        if (!empty($instance['count'])) {
            $count = (int)$instance['count'];
        }

        if (empty($count)) $count = 5;

        $array = array(
            'numberposts' => $count,
            'post_type' => 'post',
            'post_status' => 'publish',
            'meta_key' => '_like-counter',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );

        $posts = get_posts($array);
        ?>
        <ul class="liked-post-list">
            <?php
            $rank = 0;
            foreach ($posts as $post) :
                $rank++;
                setup_postdata($post);
                ?>
                <li class="liked-post clearfix">
                    <div class="liked-post-thumbnail">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                            <?php the_post_thumbnail('module-size'); ?>
                        </a>
                    </div>
                    <div class="liked-rank-num main-bg ease-transition"><?php echo $rank; ?></div>
                    <div class="liked-post-info post-content ease-transition">
                        <div class="post-categories"><?php the_category(''); ?></div>
                        <p class="post-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </p>
                        <div class="liked-post-meta clearfix">
                            <div class="post-likes">
                                <?php
                                // Check current user liked this post
                                $pid = get_the_ID();
                                $baseurl = get_site_url();
                                $cookie_name = $baseurl . '-like-' . $pid;
                                $cookie = get_cookie($cookie_name);

                                if (!empty($cookie)) {
                                    $liked = 1;
                                } else {
                                    $liked = 0;
                                }
                                ?>
                                <span>
                                    <i class="fa <?php echo ($liked) ? 'fa-heart' : 'fa-heart-o'; ?> post-like post-like-<?php echo $pid; ?> main-color"
                                       data-pid="<?php echo $pid; ?>"></i>
                                    <span class="like-count"><?php echo get_likes(); ?></span>
                                </span>
                            </div>
                            <div class="post-comment-count">
                                <i class="fa fa-comments-o main-color"></i>
                                <?php comments_number('0', '1', '%'); ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
        $count = !empty($instance['count']) ? $instance['count'] : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:', 'maziu'); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = !empty($new_instance['count']) ? (int)strip_tags($new_instance['count']) : 5;

        return $instance;
    }

}

/*
 * Add instagram widget
 */

class Instagram_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'instagram_widget',
            __('Maziu Instagram Widget', 'maziu'),
            array('description' => __('A Instagram Widget', 'maziu'))
        );
    }

    public function widget($args, $instance) {
        global $post;

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

		if (!empty($instance['instagram_username'])) {
			$username = $instance['instagram_username'];
		}

        if (!empty($instance['count'])) {
            $count = (int)$instance['count'];
        }

        if (empty($count)) $count = 4;

		if (!empty($instance['column'])) {
			$column = (int)$instance['column'];
		}

		if (empty($column)) $column = 2;

		if (!empty($username)) :
			$user = json_decode(file_get_contents('https://api.instagram.com/v1/users/search?q=' . $username . '&access_token=2137252455.d7646b8.a916a8a8e024489ba99ae5c9eaee50ae'));
			$id = $user->data[0]->id;
			if (!empty($id)) :
				$medias = json_decode(file_get_contents('https://api.instagram.com/v1/users/' . $id . '/media/recent/?count=' . $count . '&access_token=2137252455.d7646b8.a916a8a8e024489ba99ae5c9eaee50ae'));
				if (count($medias->data) > 0) :
					$width = 94 / $column;
					$margin_right = 6 / ($column - 1);
					$total = count($medias->data);
		?>
        <ul class="instagram-pictures-list clearfix instagram-columns-<?php echo $column; ?>">
        <?php foreach ($medias->data as $k => $media) : ?>
			<li class="instagram-picture<?php if ($k >= ($total - $column)) echo ' no-margin-bottom'; ?>"
			style="float: left; width: <?php echo $width; ?>%;<?php if (($k % $column) != ($column - 1)) echo ' margin-right:' . $margin_right . '%;'; ?><?php if ($k < ($total - $column)) echo ' margin-bottom: 10px;'; ?>">
				<a href="<?php echo $media->link; ?>" class="thumbnail-hover">
					<img src="<?php echo $media->images->low_resolution->url ?>" />
                    <div class="thumbnail-cover ease-transition"></div>
				</a>
			</li>
		<?php endforeach; ?>
        </ul>
        <?php
				endif;
			endif;
		endif;
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
		$username = !empty($instance['instagram_username']) ? $instance['instagram_username'] : '';
        $count = !empty($instance['count']) ? $instance['count'] : 4;
		$column = !empty($instance['column']) ? $instance['column'] : 2;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('instagram_username'); ?>"><?php _e('Instagram username:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('instagram_username'); ?>"
                   name="<?php echo $this->get_field_name('instagram_username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:', 'maziu'); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('column'); ?>"><?php _e('Column:', 'maziu'); ?></label>
            <input id="<?php echo $this->get_field_id('column'); ?>"
                   name="<?php echo $this->get_field_name('column'); ?>" type="text" value="<?php echo esc_attr($column); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
		$instance['instagram_username'] = !empty($new_instance['instagram_username']) ? strip_tags($new_instance['instagram_username']) : '';
        $instance['count'] = !empty($new_instance['count']) ? (int)strip_tags($new_instance['count']) : 4;
		$instance['column'] = !empty($new_instance['column']) ? (int)strip_tags($new_instance['column']) : 2;

        return $instance;
    }

}

class Twitter_Timeline_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'twitter_timeline_widget',
            __('Maziu Twitter Timeline Widget', 'maziu'),
            array('description' => __('A Twitter Timeline Widget', 'maziu'))
        );
    }

    public function widget($args, $instance) {
        global $post;

        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
		?>
		
		<ul class="twitter-widget-list" id="content_<?php echo $args['widget_id']; ?>"></ul>
		<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/twitterFetcher_min.js' ?>"></script>
		<script type="text/javascript">
			var config1 = {
			  "id": '<?php echo $instance['wid']; ?>',
			  "domId": '',
			  "maxTweets": <?php echo $instance['count']; ?>,
			  "enableLinks": true,
			  "showUser": false,
			  "showRetweet": false,
			  "showInteraction": false,
			  "customCallback": handleTweets,
			};
			
			function handleTweets(tweets){
				var x = tweets.length;
				var n = 0;
				var element = document.getElementById('content_<?php echo $args['widget_id']; ?>');
				var html = '';
				while(n < x) {
				  html += '<li><span class="tweet-icon"><i class="fa fa-twitter main-color"></i></span>' + tweets[n] + '</li>';
				  n++;
				}
				element.innerHTML = html;
			}
			
			twitterFetcher.fetch(config1);
		</script>
		
		<?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
		$wid = !empty($instance['wid']) ? $instance['wid'] : '';
        $count = !empty($instance['count']) ? $instance['count'] : 3;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('wid'); ?>"><?php _e('Widget ID:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('wid'); ?>"
                   name="<?php echo $this->get_field_name('wid'); ?>" type="text" value="<?php echo esc_attr($wid); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:', 'maziu'); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
		$instance['wid'] = !empty($new_instance['wid']) ? strip_tags($new_instance['wid']) : '';
        $instance['count'] = !empty($new_instance['count']) ? (int)strip_tags($new_instance['count']) : 3;

        return $instance;
    }

}

function maziu_register_widgets() {
	register_widget('About_Me_Widget');
    register_widget('Follow_Widget');
    register_widget('Categories_Widget');
    register_widget('Popular_Posts_Widget');
    register_widget('News_Letter_Widget');
    register_widget('Popular_Tags_Widget');
	register_widget('Instagram_Widget');
	register_widget('Twitter_Timeline_Widget');
    register_widget('Liked_Posts_Widget');
}
add_action('widgets_init', 'maziu_register_widgets');

/* Add meta box */
function maziu_add_meta_box() {
	$screens = array('post', 'page');
	
	foreach ($screens as $screen) {
		add_meta_box(
			'maziu_meta_box_section',
			__('Maziu Options'),
			'maziu_meta_box_callback',
			$screen
		);
	}
}
add_action('add_meta_boxes', 'maziu_add_meta_box');

function maziu_meta_box_callback($post) {
	wp_nonce_field('maziu_meta_box', 'maziu_meta_box_nonce');
	
	$slideshow = get_post_meta($post->ID, '_slideshow', true);
	if (!empty($slideshow))
		$checked = ' checked';
	else
		$checked = '';
	
	echo '<label>';
	echo '<input type="checkbox" id="maziu_post_slideshow" name="maziu_post_slideshow" value="1"' . $checked . ' />';
	_e('Slideshow');
	echo '</label>';
}

function maziu_save_meta_box_data($post_id) {
	if (!isset($_POST['maziu_meta_box_nonce'])) {
		return;
	}
	
	if (!wp_verify_nonce($_POST['maziu_meta_box_nonce'], 'maziu_meta_box')) {
		return;
	}
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	
	if (isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
		if (!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}
	}
	
	if (!isset($_POST['maziu_post_slideshow'])) {
		$slideshow_data = 0;
	} else {
		$slideshow_data = absint($_POST['maziu_post_slideshow']);
	}
	
	update_post_meta($post_id, '_slideshow', $slideshow_data);
}
add_action('save_post', 'maziu_save_meta_box_data');

/* --------------------- */
$metaboxes = array(
    'link_video' => array(
        'title' => __('Video', 'maziu'),
        'applicableto' => array('post', 'page'),
        'location' => 'normal',
        'display_condition' => 'post-format-video',
        'priority' => 'low',
        'fields' => array(
            'v_url' => array(
                'title' => __('URL', 'maziu'),
                'type' => 'text',
                'description' => ''
            ),
        ),
    ),
    'link_audio' => array(
        'title' => __('Audio', 'maziu'),
        'applicableto' => array('post', 'page'),
        'location' => 'normal',
        'display_condition' => 'post-format-audio',
        'priority' => 'low',
        'fields' => array(
            'a_url' => array(
                'title' => __('URL', 'maziu'),
                'type' => 'text',
                'description' => ''
            )
        )
    ),
);

add_action('admin_init', 'add_post_format_metabox');
function add_post_format_metabox() {
    global $metaboxes;

    if (!empty($metaboxes)) {
        foreach ($metaboxes as $id => $metabox) {
            foreach ($metabox['applicableto'] as $applicableto) {
                add_meta_box($id, $metabox['title'], 'show_metaboxes', $applicableto, $metabox['location'], $metabox['priority'], $id);
            }
        }
    }
}

function show_metaboxes($post, $args) {
    global $metaboxes;

    $custom = get_post_custom($post->ID);
    $fields = $metaboxes[$args['id']]['fields'];

    $output = '<input type="hidden" name="post_format_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';

    if (sizeof($fields)) {
        foreach ($fields as $id => $field) {
            switch ($field['type']) {
                default:
                case "text":
                    $output .= '<label for="' . $id . '">' . $field['title'] . '</label><input type="text" id="' . $id . '" name="' . $id . '" value="' . $custom[$id][0] . '" />';
                    break;
            }
        }
    }

    echo $output;
}

add_action('save_post', 'save_metaboxes');
function save_metaboxes($post_id) {
    global $metaboxes;

    // verify nonce
    if ( ! wp_verify_nonce( $_POST['post_format_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    // check permissions
    if ( 'page' == $_POST['post_type'] ) {
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

    $post_type = get_post_type();

    foreach ($metaboxes as $id => $metabox) {
        if (in_array($post_type, $metabox['applicableto'])) {
            $fields = $metabox['fields'];

            foreach ($fields as $id => $field) {
                $old = get_post_meta($post_id, $id, true);
                if (isset($_POST[$id])) {
                    $new = $_POST[$id];
                } else {
                    $new = '';
                }

                if ($new && $new != $old) {
                    update_post_meta($post_id, $id, $new);
                } elseif ($new == '' && $old) {
                    delete_post_meta($post_id, $id, $old);
                }
            }
        }
    }
}

add_action('admin_print_scripts', 'display_metaboxes', 1000);
function display_metaboxes() {
    global $metaboxes;
    ?>

    <script type="text/javascript">
        $ = jQuery;

        <?php
            $formats = $ids = array();
            foreach ($metaboxes as $id => $metabox) {
                array_push($formats, "'" . $metabox['display_condition'] . "': '" . $id . "'");
                array_push($ids, "#" . $id);
            }
        ?>

        var formats = {<?php echo implode(',', $formats); ?>};
        var ids = "<?php echo implode(',', $ids); ?>";

        function displayMetaboxes() {
            $(ids).hide();

            var selectedElt = $("input[name='post_format']:checked").attr('id');

            if (formats[selectedElt]) {
                $("#" + formats[selectedElt]).fadeIn();
            }
        }

        $(function() {
            displayMetaboxes();

            $("input[name='post_format']").change(function() {
                displayMetaboxes();
            });
        })
    </script>

    <?php
}

/* Add social fields to user form */
add_action('show_user_profile', 'add_social_fields');
add_action('edit_user_profile', 'add_social_fields');
function add_social_fields($user) {
?>
	<h3><?php _e('Extra profile information', 'maziu'); ?></h3>
	<table class="form-table">
		<tr>
			<th>
				<label for="avatar"><?php _e('Avatar', 'maziu'); ?></label>
			</th>
			<td>
				<?php if (!empty(get_the_author_meta('avatar', $user->ID))) : ?>
				<div class="user-avatar-img">
					<img src="<?php echo get_site_url(); ?>/wp-content/uploads/avatars/<?php echo get_the_author_meta('avatar', $user->ID); ?>" />
				</div>
				<?php endif; ?>
				<input type="file" name="avatar" id="avatar" /><br />
			</td>
		</tr>
		<tr>
			<th>
				<label for="facebook"><?php _e('Facebook', 'maziu'); ?></label>
			</th>
			<td>
				<input type="text" name="facebook" id="facebook" class="regular-text" 
					value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>" /><br />
			</td>
		</tr>
		<tr>
			<th>
				<label for="google"><?php _e('Google+', 'maziu'); ?></label>
			</th>
			<td>
				<input type="text" name="google" id="google" class="regular-text" 
					value="<?php echo esc_attr(get_the_author_meta('google', $user->ID)); ?>" /><br />
			</td>
		</tr>
		<tr>
			<th>
				<label for="twitter"><?php _e('Twitter', 'maziu'); ?></label>
			</th>
			<td>
				<input type="text" name="twitter" id="twitter" class="regular-text" 
					value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" /><br />
			</td>
		</tr>
	</table>
<?php
}

add_action('personal_options_update', 'save_social_fields');
add_action('edit_user_profile_update', 'save_social_fields');
function save_social_fields($uid) {
	$saved = false;
	if (current_user_can('edit_user', $uid)) {
		update_user_meta($uid, 'facebook', $_POST['facebook']);
		update_user_meta($uid, 'google', $_POST['google']);
		update_user_meta($uid, 'twitter', $_POST['twitter']);
	
		$saved = true;
	}
	
	return $saved;
}

/* Functions */

/*
 * get post hits
 */
function get_hits() {
    global $post;
    $hits = get_post_meta($post->ID, '_hit-counter', true);
    if (!empty($hits)) {
        return $hits;
    } else {
        return 0;
    }
}

/*
 * update post hits
 */
function update_hits($hits) {
    global $post;
    $hits = !empty($hits) ? (int)$hits : 0;
    update_post_meta($post->ID, '_hit-counter', $hits + 1);
}

/*
 * get post likes
 */
function get_likes() {
    global $post;
    $likes = get_post_meta($post->ID, '_like-counter', true);
    if (!empty($likes)) {
        return $likes;
    } else {
        return 0;
    }
}

function returnJSON(array $data) {
    echo json_encode($data);
    die;
}

function get_soundcloud($postid) {
    $url = get_post_meta($postid, 'a_url', true);
    $sco = json_decode(file_get_contents('https://api.soundcloud.com/resolve.json?url=' . urlencode($url) . '&client_id=cf7b086fe7172e25225bcb5ba431eb71'));

    $sc = '<iframe scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=' . urlencode($sco->uri) . '&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';
    return $sc;
}

/*
 * Update post like ajax
 */
add_action('wp_ajax_like_ajax', 'like_ajax');
add_action("wp_ajax_nopriv_like_ajax", "like_ajax");
function like_ajax() {
    if (isset($_POST['pid']) && $_POST['pid']) {
        $pid = $_POST['pid'];
        $likes = get_post_meta($pid, '_like-counter', true);

        // Check cookie
        $cookie_name = get_site_url() . '-like-' . $pid;
        $cookie = get_cookie($cookie_name);

        if (!empty($cookie)) {
            $liked = 1;
        } else {
            $liked = 0;
        }

        // Update likes for post
        if ($liked == 1) {
            $likes--;
            unset($_COOKIE[$name]);
            setcookie($cookie_name, '', time() - 1, '/');
        } else {
            $likes++;
            setcookie($cookie_name, 1, time() + (30 * 24 * 60 * 60 * 1000), '/');
        }

        update_post_meta($pid, '_like-counter', $likes);

        returnJSON(array('likes' => $likes, 'liked' => $liked));
    } else {
        returnJSON(array('error' => 1));
    }
}

/*
 * Get cookie
 */
function get_cookie($name) {
    return $_COOKIE[$name];
}

/*
 * Custom comment list
 */
function custom_comment_list($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	switch($comment->comment_type) :
        case 'pingback':
        case 'trackback': ?>
            <li <?php comment_class(); ?> id="comment<?php comment_ID(); ?>">
                <div class="back-link"><?php comment_author_link(); ?></div>
            </li>
    <?php break;
        default: ?>
            <li <?php comment_class(); ?> id="comment-<?php echo comment_ID(); ?>">
				<div class="clearfix">
					<div class="comment-avatar">
						<?php echo get_avatar($comment, 100); ?>
					</div>
					<div class="comment-info">
						<p class="comment-author"><?php comment_author(); ?></p>
						<p class="comment-date">
							<i class="fa fa-clock-o"></i>
							<?php comment_date(); ?>
						</p>
						<?php
							$status = wp_get_comment_status(get_comment_ID());
							if ($status == 'unapproved') :
						?>
						<p class="comment-status"><?php _e('Comment awaiting approval', 'maziu'); ?></p>
						<?php endif; ?>
						<div class="comment-content"><?php comment_text(); ?></div>
						<div class="comment-reply main-color-child">
						<?php 
							comment_reply_link(array_merge($args, array( 
								'reply_text' => __('Reply', 'maziu'),
								'before' => '<i class="fa fa-reply"></i>', 
								'depth' => $depth,
								'max_depth' => $args['max_depth'] 
								)));
						?>
						</div>
					</div>
				</div>
            </li>
        <?php
    endswitch;
}