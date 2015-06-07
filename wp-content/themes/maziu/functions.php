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
        $font = 350; // Lato font
    } else {
        $font = $options['font_text_family'];
    }

    $fonts_arr = json_decode(file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBgzCr9pt5xS09me72S91tTaCmLtAzWkOE'));
	
    $query_args = array(
        'family' => urlencode($fonts_arr->items[$font]->family),
        'subset' => urlencode(implode(',', $fonts_arr->items[$font]->subsets))
    );
	
    $font_style = "
        body {
            font-family: '" . $fonts_arr->items[$font]->family . "', Arial, sans-serif;
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
        'family' => urlencode('Droid Serif:regular,italic'),
        'subset' => urlencode('latin'),
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
    wp_enqueue_script('maziu_admin_script', get_template_directory_uri() . '/js/admin.js');
}
add_action('admin_enqueue_scripts', 'maziu_admin_scripts');

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
                            <?php if (has_post_thumbnail()) the_post_thumbnail('module-size'); ?>
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
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="main-color-hover"><?php echo wp_trim_words(get_the_title(), 7, '...'); ?></a>
                            </h3>
                        </div>
                    </div>
                    <div class="sb-meta">
                        <ul class="clearfix">
                            <li><i class="fa fa-heart-o main-color"></i>4</li>
                            <li><a href="<?php the_permalink(); ?>" title="<?php the_title() ?>" class="read-more main-color"><?php echo __('Continue reading'); ?></a></li>
                            <li><i class="fa fa-comments-o main-color"></i><?php comments_number('0', '1', '%') ?></li>
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
                nextText: '<i class="fa fa-angle-right main-color-hover main-border-hover ease-transition"></i>',
                prevText: '<i class="fa fa-angle-left main-color-hover main-border-hover ease-transition"></i>'
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
        <ul class="socials clearfix">
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
		'class' => 'main-color'
	), $atts);
	
	ob_start();
	?>
	<ul class="post_socials clearfix">
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
        echo 1;
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
            $this->options['font_text_family'] = 352; // Font Lato
        }

        if (!empty($fonts_arr->items))
        {
            foreach ($fonts_arr->items as $k => $font)
            {
                $selected_text = (isset($this->options['font_text_family']) && $this->options['font_text_family'] == $k) ? ' selected' : '';
                $this->fonts['font_text']['family'] .= '<option value="' . $k . '"' . $selected_text . '>' . $font->family . '</option>';
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
         * Fonts page
         */
        if (isset($input['font_text_family']))
            $new_input['font_text_family'] = absint($input['font_text_family']);

        /*
         * Slideshow page
         */
        if (isset($input['category_name']))
            $new_input['category_name'] = sanitize_text_field($input['category_name']);
		
		if (isset($input['slide_count']))
			$new_input['slide_count'] = absint($input['slide_count']);

        return $new_input;
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
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
			       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('post_slug'); ?>"><?php echo _e('Post slug:', 'maziu'); ?></label>
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
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
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('thumbnail'); ?>
					</a>
                </div>
                <div class="popular-post-info">
                    <h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h3>
                    <div class="popular-post-meta clearfix">
                        <div class="post-likes">
                            <i class="fa fa-heart-o main-color"></i>
                            4
                        </div>
                        <div class="post-hits">
                            <i class="fa fa-comments-o main-color"></i>
                            <?php echo get_hits(); ?>
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php echo _e('Count:', 'maziu'); ?></label>
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php echo _e('Description:', 'maziu'); ?></label>
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php echo _e('Count:', 'maziu'); ?></label>
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
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                    <div class="popular-post-info">
                        <h3><?php the_title(); ?></h3>
                        <div class="popular-post-meta clearfix">
                            <div class="post-likes">
                                <i class="fa fa-heart-o main-color"></i>
                                4
                            </div>
                            <div class="post-hits">
                                <i class="fa fa-comments-o main-color"></i>
                                <?php echo get_hits(); ?>
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php echo _e('Count:', 'maziu'); ?></label>
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
				<a href="<?php echo $media->link; ?>">
					<img src="<?php echo $media->images->low_resolution->url ?>" />
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('instagram_username'); ?>"><?php echo _e('Instagram username:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('instagram_username'); ?>"
                   name="<?php echo $this->get_field_name('instagram_username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php echo _e('Count:', 'maziu'); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('column'); ?>"><?php echo _e('Column:', 'maziu'); ?></label>
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
		
		require_once('inc/twitter_api/TwitterAPIExchange.php');
		
		$settings = array(
			'oauth_access_token' => "3140033382-c6FjBsmgLmKfL59Khv2TKY2Q5kmrZMRWOQCw1b4",
			'oauth_access_token_secret' => "kKVM3qUI1fGAikORmXB3RJQJcKnjOqs3LOF3nD7uhZoNI",
			'consumer_key' => "bpwii15Ik843H97DAmAueTp1q",
			'consumer_secret' => "af5BmvqxriRzYQJEUBh20QCkseYAAKugHqcCyJgBOh9a91LLXX"
		);
		
		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$requestMethod = 'POST';
		
		$postfields = array(
			'user_id' => '3140033382'
		);
		
		$twitter = new TwitterAPIExchange($settings);
		echo $twitter->buildOauth($url, $requestMethod)
					 ->setPostfields($postfields)
					 ->performRequest();
		
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Enter title', 'maziu');
		$username = !empty($instance['twitter_username']) ? $instance['twitter_username'] : '';
        $count = !empty($instance['count']) ? $instance['count'] : 3;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('twitter_username'); ?>"><?php echo _e('Twitter username:', 'maziu'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('twitter_username'); ?>"
                   name="<?php echo $this->get_field_name('twitter_username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php echo _e('Count:', 'maziu'); ?></label>
            <input id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
		$instance['twitter_username'] = !empty($new_instance['twitter_username']) ? strip_tags($new_instance['twitter_username']) : '';
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

/* Functions */

/*
 * get post hits
 */
function get_hits() {
    global $post;
    $hits = get_post_meta($post->ID, '_hit-counter', true);
    return $hits;
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
    return $likes;
}