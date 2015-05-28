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
    wp_enqueue_script('jssor', get_template_directory_uri() . '/js/jssor/jssor.js', array('jquery'), null);
    wp_enqueue_script('jssor-slider', get_template_directory_uri() . '/js/jssor/jssor.slider.js', array('jquery'), null);
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
    register_sidebar( array(
        'name'          => __( 'Main Widget Area', 'maziu' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Main Widget Area', 'maziu' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
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
	if (!empty($options['category_name'])) :
		if (!isset($options['slide_count']))
			$options['slide_count'] = 4;

		if (!empty($options['slide_count'])) :
			$args = array(
				'posts_per_page' => $options['slide_count'],
				'category_name' => $options['category_name'],
				'offset' => 0,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'post',
				'post_status' => 'publish'
			);

			$posts = get_posts($args);
	?>
    <div id="slideshow" style="position: relative; top: 0px; left: 0px; width: 900px; height: 435px; overflow: hidden;">
        <div u="slides" style="position: absolute; left: 0px; top: 0px; width: 900px; height: 435px; overflow: hidden;">
            <?php
            foreach ($posts as $post) :
                setup_postdata($post);
                ?>
                <div class="slider-box">
                    <div class="sb-inner">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="slider-image">
                            <?php if (has_post_thumbnail()) the_post_thumbnail('module-size'); ?>
                        </a>
                        <p class="sb-categories"><?php the_category(' - '); ?></p>
                        <h3>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </h3>
                    </div>
                </div>
            <?php
            endforeach;
            wp_reset_postdata();
            ?>
        </div>

        <span u="arrowleft" class="slide-button prev-button">
            <i class="fa fa-arrow-circle-o-left"></i>
        </span>
        <span u="arrowright" class="slide-button next-button">
            <i class="fa fa-arrow-circle-o-right"></i>
        </span>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 160,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                $SlideWidth: 300,                                   //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 150,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 3,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                              //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)



                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var slideshow = new $JssorSlider$("slideshow", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    slideshow.$ScaleWidth(Math.min(bodyWidth, 809));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
    <style>
        .slide-button {
            display: block;
            position: absolute;
            /* size of arrow element */
            width: 55px;
            height: 55px;
            cursor: pointer;
            overflow: hidden;
        }
        .jssora03l { background-position: -3px -33px; }
        .jssora03r { background-position: -63px -33px; }
        .jssora03l:hover { background-position: -123px -33px; }
        .jssora03r:hover { background-position: -183px -33px; }
        .jssora03l.jssora03ldn { background-position: -243px -33px; }
        .jssora03r.jssora03rdn { background-position: -303px -33px; }
    </style>
	<?php
		endif;
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
        <ul class="instagram-pictures-list clearfix">
        <?php foreach ($medias->data as $k => $media) : ?>
			<li class="instagram-picture" 
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

function maziu_register_widgets() {
	register_widget('About_Me_Widget');
    register_widget('Follow_Widget');
    register_widget('Categories_Widget');
    register_widget('Popular_Posts_Widget');
    register_widget('News_Letter_Widget');
    register_widget('Popular_Tags_Widget');
	register_widget('Instagram_Widget');
}
add_action('widgets_init', 'maziu_register_widgets');

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