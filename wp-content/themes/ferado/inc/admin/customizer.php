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
 * Customizer Control Class
 *
 * @package Ferado
 * @since   1.0
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	class WR_Ferado_Textarea_Control extends WP_Customize_Control {
		/**
		 * @access public
		 * @var string
		 */
		public $type = 'textarea';

		/**
		 * Render the control's content.
		 */
		public function render_content() {
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" class="large-text" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
		<?php
		}
	}

	class WR_Ferado_Button_Control extends WP_Customize_Control {
		/**
		 * @access public
		 * @var string
		 */
		public $type = 'button';

		/**
		 * HTML tag to render button object.
		 *
		 * @var  string
		 */
		protected $tag = 'button';

		/**
		 * Link for <a> based button.
		 *
		 * @var  string
		 */
		protected $href = 'javascript:void(0)';

		/**
		 * Target for <a> based button.
		 *
		 * @var  string
		 */
		protected $target = '';

		/**
		 * Click event handler.
		 *
		 * @var  string
		 */
		protected $onclick = '';

		/**
		 * ID attribute for HTML tab.
		 *
		 * @var  string
		 */
		protected $tag_id = '';

		/**
		 * Render the control's content.
		 */
		public function render_content() {
		?>
			<span class="center">
				<?php
				// Print open tag
				echo '<' . esc_html( $this->tag ) . ' class="button-secondary"';

				if ( 'button' == $this->tag )
					echo ' type="button"';
				else
					echo ' href="' . esc_url( $this->href ) . '"' . ( empty( $this->tag ) ? '' : ' target="' . esc_attr( $this->target ) . '"' );

				if ( ! empty( $this->onclick ) )
					echo ' onclick="' . esc_js( $this->onclick ) . '"';

				if ( ! empty( $this->tag_id ) )
					echo ' id="' . esc_attr( $this->tag_id ) . '"';

				echo '>';

				// Print text inside tag
				echo esc_html( $this->label );

				// Print close tag
				echo '</' . esc_html( $this->tag ) . '>';
				?>
			</span>
		<?php
		}
	}

	class WR_Ferado_Checkbox_Image_Control extends WP_Customize_Control {
		/**
		 * Render the control's content.
		 */
		public function render_content() {

			if ( empty( $this->choices ) ) return;

			$name = $this->id;

			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul class="control-select-group">
				<?php
					foreach ( $this->choices as $value => $label ) :
						$checked = '';
						if ( $value == 0 ) $checked = 'checked';
				?>
				<li>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/<?php echo esc_attr( $value ); ?>.png" alt="<?php echo esc_attr( $value ); ?>" /><br />
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
				</li>
				<?php endforeach; ?>
			</ul>
		<?php
		}
	}

	class WR_Ferado_Subtitle_Control extends WP_Customize_Control {
		/**
		 * @access public
		 * @var string
		 */
		public $type = 'subtitle';

		/**
		 * Render the control's content.
		 */
		public function render_content() {
		?>
			<span class="customize-control-subtitle"><?php echo esc_html( $this->label ); ?></span>
		<?php
		}
	}
}

if ( ! function_exists( 'wr_ferado_theme_options' ) ) {
	function wr_ferado_theme_options( $wp_customize = null ) {
		/*--------------------------------------------------------------
			Getting Started
		--------------------------------------------------------------*/
		// Check if we have any backup file?
		$theme = wp_get_theme();
		$path  = wp_upload_dir();
		$path  = $path['basedir'] . '/' . strtolower( $theme['Name'] ) . '/backup';

		if ( count( $files = glob( "{$path}/*.sql" ) ) ) {
			// Sort by file name
			sort( $files );

			// Store latest backup file
			$backup = array_pop( $files );
		}

		// Define settings
		$theme_options['getting_started'] = array(
			'title'       => __( 'Getting Started', 'ferado' ),
			'description' => __( 'The best way to understand the template is to setup sample data on your website to make it look the same as template demo website. And when the sample data installed, it\'s about time to take a look at template documentation and start exploration.', 'ferado' ),
			'priority'    => 10,
			'settings'    => array(
				'wr_install_sample_data' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_read_documentation' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
			),
			'controls' => array(
				'wr_install_sample_data' => array(
					'type' => 'WR_Ferado_Button_Control',
					'args' => array(
						'label'   => ( isset( $backup ) && $backup ) ? __( 'Restore Original Data', 'ferado' ) : __( 'Install Sample Data', 'ferado' ),
						'section' => 'getting_started',
						'type'    => 'button',
						'tag_id'  => ( isset( $backup ) && $backup ) ? 'wr-restore-original-data' : 'wr-install-sample-data',
					)
				),
				'wr_read_documentation' => array(
					'type' => 'WR_Ferado_Button_Control',
					'args' => array(
						'label'   => __( 'Read Documentation', 'ferado' ),
						'section' => 'getting_started',
						'type'    => 'button',
						'tag'     => 'a',
						'href'    => 'http://www.woorockets.com/docs/ferado/',
						'target'  => '_blank',
					)
				),
			),
		);

		/*--------------------------------------------------------------
			Site Title & Logo & Tagline
		--------------------------------------------------------------*/
		// Get list fonts
		$google_fonts = wr_ferado_google_fonts();

		if ( $wp_customize ) {
			$wp_customize->remove_control( 'blogdescription' );
		}

		$theme_options['title_tagline'] = array(
			'title' => __( 'Site Title & Logo & Tagline', 'ferado' ),
			'description' => __( 'Enter your website title or insert logo image. And type a short description for your website', 'ferado' ),
			'settings' => array(
				'wr_logo_type' => array(
					'default' => 'logo_image',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_logo_image' => array(
					'default'           => get_template_directory_uri() . '/assets/img/main-logo.png',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'blogname_font_family' => array(
					'default'           => '',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'blogname_font_size' => array(
					'default'           => '35',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'blogname_font_weight' => array(
					'default'           => '700',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_logo_mgl' => array( 'sanitize_callback' => 'wr_ferado_sanitize_cb' ),
				'wr_logo_mgt' => array( 'sanitize_callback' => 'wr_ferado_sanitize_cb',  'default' => '26' )
			),
			'controls' => array(
				'wr_logo_type' => array(
					'label'    => __( 'Logo Type', 'ferado' ),
					'section'  => 'title_tagline',
					'type'     => 'select',
					'priority' => 1,
					'choices'  => array(
						'logo_text'  => __( 'Logo Text', 'ferado' ),
						'logo_image' => __( 'Logo Image', 'ferado' ),
					),
				),
				'wr_logo_image' => array(
					'type' => 'WP_Customize_Image_Control',
					'args' => array(
						'label'    => __( 'Upload Logo', 'ferado' ),
						'section'  => 'title_tagline',
						'priority' => 2,
					),
				),
				'blogname_font_family' => array(
					'label'    => __( 'Logo Font Family', 'ferado' ),
					'section'  => 'title_tagline',
					'type'     => 'select',
					'choices'  => $google_fonts,
					'priority' => 10,
				),
				'blogname_font_size' => array(
					'label'    => __( 'Logo Font Size (px)', 'ferado' ),
					'section'  => 'title_tagline',
					'type'     => 'text',
					'priority' => 11,
				),
				'blogname_font_weight' => array(
					'label'    => __( 'Logo Font Weight', 'ferado' ),
					'section'  => 'title_tagline',
					'type'     => 'select',
					'priority' => 12,
					'choices'  => array(
						'100'   => __( 'Thin 100', 'ferado' ),
						'100_i' => __( 'Thin 100 Italic', 'ferado' ),
						'300'   => __( 'Light 300', 'ferado' ),
						'300_i' => __( 'Light 300 Italic', 'ferado' ),
						'400'   => __( 'Normal 400', 'ferado' ),
						'400_i' => __( 'Normal 400 Italic', 'ferado' ),
						'600'   => __( 'Semi Bold 600', 'ferado' ),
						'600_i' => __( 'Semi Bold 600 Italic', 'ferado' ),
						'700'   => __( 'Bold 700', 'ferado' ),
						'700_i' => __( 'Bold 700 Italic', 'ferado' ),
						'800'   => __( 'Extra Bold 800', 'ferado' ),
						'800_i' => __( 'Extra Bold 800 Italic', 'ferado' ),
						'900'   => __( 'Ultra Bold 900', 'ferado' ),
						'900_i' => __( 'Ultra Bold 900 Italic', 'ferado' )
					)
				),
				'wr_logo_mgl' => array(
					'label'    => __( 'Logo Margin Left (px)', 'ferado' ),
					'section'  => 'title_tagline',
					'type'     => 'text',
					'priority' => 11,
				),
				'wr_logo_mgt' => array(
					'label'    => __( 'Logo Margin Top (px)', 'ferado' ),
					'section'  => 'title_tagline',
					'type'     => 'text',
					'priority' => 11,
				)
			)
		);

		/*--------------------------------------------------------------
			Colors Scheme
		--------------------------------------------------------------*/
		// Remove default Colors section
		if ( $wp_customize ) {
			$wp_customize->remove_section( 'colors' );
		}

		// Define settings
		$theme_options['color_schemes'] = array(
			'title'       => __( 'Color Schemes', 'ferado' ),
			'description' => __( 'Ferado provides 6 major color variations for your taste. Each color variation covers not only the main background, but also color of drop-down menu, links, table\'s header and others', 'ferado' ),
			'priority'    => 30,
			'settings'    => array(
				'wr_color_schemes' => array(
					'default'           => 'red',
					'sanitize_callback' => 'wr_ferado_sanitize_color_placement',
				),
				'wr_body_color_subtitle' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_c_body_color' => array(
					'default'           => '#353533',
					'sanitize_callback' => 'sanitize_hex_color',
				),
				'wr_c_body_bg_color' => array(
					'default'           => '#fff',
					'sanitize_callback' => 'sanitize_hex_color',
				),
				'wr_c_page_title_color_subtitle' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_c_page_title_color' => array(
					'default'           => '#f45245',
					'sanitize_callback' => 'sanitize_hex_color',
				),
				'wr_c_page_title_bg_color' => array(
					'default'           => '#e2e2e2',
					'sanitize_callback' => 'sanitize_hex_color',
				),
				'wr_c_header_color_subtitle' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_c_main_menu_color' => array(
					'default'           => '#fff',
					'sanitize_callback' => 'sanitize_hex_color',
				),
				'wr_c_other_color_subtitle' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_c_footer_bg_color' => array(
					'default'           => '#2e2e2e',
					'sanitize_callback' => 'sanitize_hex_color',
				),
				'wr_c_heading_color' => array(
					'default'           => '#353533',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			),
			'controls' => array(
				'wr_color_schemes' => array(
					'type' => 'WR_Ferado_Checkbox_Image_Control',
					'args' => array(
						'label'   => __( 'Main color schemes', 'ferado' ),
						'section' => 'color_schemes',
						'choices' => array(
							'red'    => __( 'Red', 'ferado' ),
							'brown'  => __( 'Brown', 'ferado' ),
							'yellow' => __( 'Yellow', 'ferado' ),
							'blue'   => __( 'Blue', 'ferado' ),
							'green'  => __( 'Green', 'ferado' ),
							'purple' => __( 'Purple', 'ferado' ),
						)
					)
				),
				'wr_body_color_subtitle' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'args' => array(
						'label'    => __( 'Body color schemes', 'ferado' ),
						'section'  => 'color_schemes'
					)
				),
				'wr_c_body_color' => array(
					'type' => 'WP_Customize_Color_Control',
					'args' => array(
						'label'   => __( 'Body font color', 'ferado' ),
						'section' => 'color_schemes'
					)
				),
				'wr_c_body_bg_color' => array(
					'type' => 'WP_Customize_Color_Control',
					'args' => array(
						'label'   => __( 'Body background color', 'ferado' ),
						'section' => 'color_schemes'
					)
				),
				'wr_c_page_title_color_subtitle' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'args' => array(
						'label'    => __( 'Page title color schemes', 'ferado' ),
						'section'  => 'color_schemes'
					)
				),
				'wr_c_page_title_color' => array(
					'type' => 'WP_Customize_Color_Control',
					'args' => array(
						'label'   => __( 'Page title color', 'ferado' ),
						'section' => 'color_schemes'
					)
				),
				'wr_c_page_title_bg_color' => array(
					'type' => 'WP_Customize_Color_Control',
					'args' => array(
						'label'   => __( 'Page title background color', 'ferado' ),
						'section' => 'color_schemes'
					)
				),
				'wr_c_header_color_subtitle' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'args' => array(
						'label'    => __( 'Header color schemes', 'ferado' ),
						'section'  => 'color_schemes'
					)
				),
				'wr_c_main_menu_color' => array(
					'type' => 'WP_Customize_Color_Control',
					'args' => array(
						'label'   => __( 'Main menu color', 'ferado' ),
						'section' => 'color_schemes'
					)
				),
				'wr_c_other_color_subtitle' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'args' => array(
						'label'    => __( 'Other color schemes', 'ferado' ),
						'section'  => 'color_schemes'
					)
				),
				'wr_c_heading_color' => array(
					'type' => 'WP_Customize_Color_Control',
					'args' => array(
						'label'   => __( 'Heading font color', 'ferado' ),
						'section' => 'color_schemes'
					)
				),
				'wr_c_footer_bg_color' => array(
					'type' => 'WP_Customize_Color_Control',
					'args' => array(
						'label'   => __( 'Footer background color', 'ferado' ),
						'section' => 'color_schemes'
					)
				)
			)
		);

		/*--------------------------------------------------------------
			Typography
		--------------------------------------------------------------*/
		// Get list fonts
		$google_fonts   = wr_ferado_google_fonts();
		$standard_fonts = wr_ferado_standard_fonts();

		// Define settings
		$theme_options['typography'] = array(
			'title'       => __( 'Typography', 'ferado' ),
			'description' => __( 'Setting typography for your website', 'ferado' ),
			'priority'    => 40,
			'settings'    => array(
				'wr_body_font_subtitle' => array(
					'default'           => '',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_body_font' => array(
					'default'           => 'google_font',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_body_font_google_family' => array(
					'default'           => 'Lato',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_body_font_standard_family' => array(
					'default'           => '',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_body_font_size' => array(
					'default'           => '13',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_body_font_google_weight' => array(
					'default'           => '400',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_body_font_standard_weight' => array(
					'default'           => 'normal',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_page_title_subtitle' => array(
					'default'           => '',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_page_title_font' => array(
					'default'           => 'google_font',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_page_title_font_google_family' => array(
					'default'           => 'Lato',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_page_title_font_standard_family' => array(
					'default'           => '',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_page_title_font_size' => array(
					'default'           => '60',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_page_title_font_google_weight' => array(
					'default'           => '400',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_page_title_font_standard_weight' => array(
					'default'           => 'normal',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_font_subtitle' => array(
					'default'           => '',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_font' => array(
					'default'           => 'google_font',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_font_google_family' => array(
					'default'           => 'Lato',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_font_standard_family' => array(
					'default'           => '',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_font_google_weight' => array(
					'default'           => 'normal',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_font_standard_weight' => array(
					'default'           => 'normal',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_h1_font_size' => array(
					'default'           => '36',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_h2_font_size' => array(
					'default'           => '30',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_h3_font_size' => array(
					'default'           => '24',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_h4_font_size' => array(
					'default'           => '18',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_h5_font_size' => array(
					'default'           => '14',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
				'wr_heading_h6_font_size' => array(
					'default'           => '12',
					'sanitize_callback' => 'wr_ferado_sanitize_cb'
				),
			),
			'controls' => array(
				'wr_body_font_subtitle' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'args' => array(
						'label'    => __( 'Body Font Settings', 'ferado' ),
						'section'  => 'typography',
						'priority' => 0
					)
				),
				'wr_body_font' => array(
					'label'    => __( 'Body Font Type', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 1,
					'choices'  => array(
						'standard_font' => __( 'Standard Font', 'ferado' ),
						'google_font'   => __( 'Google Font', 'ferado' ),
					),
				),
				'wr_body_font_google_family' => array(
					'label'    => __( 'Body Font Family', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 2,
					'choices'  => $google_fonts
				),
				'wr_body_font_standard_family' => array(
					'label'    => __( 'Body Font Family', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 2,
					'choices'  => $standard_fonts
				),
				'wr_body_font_size' => array(
					'label'    => __( 'Body Font Size (px)', 'ferado' ),
					'section'  => 'typography',
					'priority' => 3,
					'type'     => 'text',
				),
				'wr_body_font_google_weight' => array(
					'label'    => __( 'Body Font Weight', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 4,
					'choices'  => array(
						'100'   => __( 'Thin 100', 'ferado' ),
						'100_i' => __( 'Thin 100 Italic', 'ferado' ),
						'300'   => __( 'Light 300', 'ferado' ),
						'300_i' => __( 'Light 300 Italic', 'ferado' ),
						'400'   => __( 'Normal 400', 'ferado' ),
						'400_i' => __( 'Normal 400 Italic', 'ferado' ),
						'600'   => __( 'Semi Bold 600', 'ferado' ),
						'600_i' => __( 'Semi Bold 600 Italic', 'ferado' ),
						'700'   => __( 'Bold 700', 'ferado' ),
						'700_i' => __( 'Bold 700 Italic', 'ferado' ),
						'800'   => __( 'Extra Bold 800', 'ferado' ),
						'800_i' => __( 'Extra Bold 800 Italic', 'ferado' ),
						'900'   => __( 'Ultra Bold 900', 'ferado' ),
						'900_i' => __( 'Ultra Bold 900 Italic', 'ferado' )
					)
				),
				'wr_body_font_standard_weight' => array(
					'label'    => __( 'Heading Font Weight', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 4,
					'choices'  => array(
						'normal'       => __( 'Normal', 'ferado' ),
						'normal_i'     => __( 'Normal Italic', 'ferado' ),
						'bold'         => __( 'Bold', 'ferado' ),
						'bold_i'       => __( 'Bold Italic', 'ferado' )
					)
				),
				'wr_page_title_subtitle' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'args' => array(
						'label'    => __( 'Page Title Font Settings', 'ferado' ),
						'section'  => 'typography',
						'priority' => 5
					)
				),
				'wr_page_title_font' => array(
					'label'    => __( 'Page Title Font Type', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 6,
					'choices'  => array(
						'standard_font' => __( 'Standard Font', 'ferado' ),
						'google_font'   => __( 'Google Font', 'ferado' ),
					),
				),
				'wr_page_title_font_google_family' => array(
					'label'    => __( 'Page Title Font Family', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 7,
					'choices'  => $google_fonts
				),
				'wr_page_title_font_standard_family' => array(
					'label'    => __( 'Page Title Font Family', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 7,
					'choices'  => $standard_fonts
				),
				'wr_page_title_font_size' => array(
					'label'    => __( 'Page Title Font Size (px)', 'ferado' ),
					'section'  => 'typography',
					'priority' => 8,
					'type'     => 'text',
				),
				'wr_page_title_font_google_weight' => array(
					'label'    => __( 'Page Title Font Weight', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 9,
					'choices'  => array(
						'100'   => __( 'Thin 100', 'ferado' ),
						'100_i' => __( 'Thin 100 Italic', 'ferado' ),
						'300'   => __( 'Light 300', 'ferado' ),
						'300_i' => __( 'Light 300 Italic', 'ferado' ),
						'400'   => __( 'Normal 400', 'ferado' ),
						'400_i' => __( 'Normal 400 Italic', 'ferado' ),
						'600'   => __( 'Semi Bold 600', 'ferado' ),
						'600_i' => __( 'Semi Bold 600 Italic', 'ferado' ),
						'700'   => __( 'Bold 700', 'ferado' ),
						'700_i' => __( 'Bold 700 Italic', 'ferado' ),
						'800'   => __( 'Extra Bold 800', 'ferado' ),
						'800_i' => __( 'Extra Bold 800 Italic', 'ferado' ),
						'900'   => __( 'Ultra Bold 900', 'ferado' ),
						'900_i' => __( 'Ultra Bold 900 Italic', 'ferado' )
					)
				),
				'wr_page_title_font_standard_weight' => array(
					'label'    => __( 'Heading Font Weight', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 9,
					'choices'  => array(
						'normal'       => __( 'Normal', 'ferado' ),
						'normal_i'     => __( 'Normal Italic', 'ferado' ),
						'bold'         => __( 'Bold', 'ferado' ),
						'bold_i'       => __( 'Bold Italic', 'ferado' )
					)
				),
				'wr_heading_font_subtitle' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'args' => array(
						'label'    => __( 'Heading Font Settings', 'ferado' ),
						'section'  => 'typography',
						'priority' => 10
					)
				),
				'wr_heading_font' => array(
					'label'    => __( 'Heading Font Type', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 11,
					'choices'  => array(
						'standard_font' => __( 'Standard Font', 'ferado' ),
						'google_font'   => __( 'Google Font', 'ferado' ),
					),
				),
				'wr_heading_font_google_family' => array(
					'label'    => __( 'Heading Font Family', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 12,
					'choices'  => $google_fonts
				),
				'wr_heading_font_standard_family' => array(
					'label'    => __( 'Heading Font Family', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 13,
					'choices'  => $standard_fonts
				),
				'wr_heading_font_google_weight' => array(
					'label'    => __( 'Heading Font Weight', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 14,
					'choices'  => array(
						'100'   => __( 'Thin 100', 'ferado' ),
						'100_i' => __( 'Thin 100 Italic', 'ferado' ),
						'300'   => __( 'Light 300', 'ferado' ),
						'300_i' => __( 'Light 300 Italic', 'ferado' ),
						'400'   => __( 'Normal 400', 'ferado' ),
						'400_i' => __( 'Normal 400 Italic', 'ferado' ),
						'600'   => __( 'Semi Bold 600', 'ferado' ),
						'600_i' => __( 'Semi Bold 600 Italic', 'ferado' ),
						'700'   => __( 'Bold 700', 'ferado' ),
						'700_i' => __( 'Bold 700 Italic', 'ferado' ),
						'800'   => __( 'Extra Bold 800', 'ferado' ),
						'800_i' => __( 'Extra Bold 800 Italic', 'ferado' ),
						'900'   => __( 'Ultra Bold 900', 'ferado' ),
						'900_i' => __( 'Ultra Bold 900 Italic', 'ferado' )
					)
				),
				'wr_heading_font_standard_weight' => array(
					'label'    => __( 'Heading Font Weight', 'ferado' ),
					'section'  => 'typography',
					'type'     => 'select',
					'priority' => 15,
					'choices'  => array(
						'normal'       => __( 'Normal', 'ferado' ),
						'normal_i'     => __( 'Normal Italic', 'ferado' ),
						'bold'         => __( 'Bold', 'ferado' ),
						'bold_i'       => __( 'Bold Italic', 'ferado' )
					)
				),
				'wr_heading_h1_font_size' => array(
					'label'    => __( 'H1 Font Size (px)', 'ferado' ),
					'section'  => 'typography',
					'priority' => 16,
					'type'     => 'text',
				),
				'wr_heading_h2_font_size' => array(
					'label'    => __( 'H2 Font Size (px)', 'ferado' ),
					'section'  => 'typography',
					'priority' => 17,
					'type'     => 'text',
				),
				'wr_heading_h3_font_size' => array(
					'label'    => __( 'H3 Font Size (px)', 'ferado' ),
					'section'  => 'typography',
					'priority' => 18,
					'type'     => 'text',
				),
				'wr_heading_h4_font_size' => array(
					'label'    => __( 'H4 Font Size (px)', 'ferado' ),
					'section'  => 'typography',
					'priority' => 19,
					'type'     => 'text',
				),
				'wr_heading_h5_font_size' => array(
					'label'    => __( 'H5 Font Size (px)', 'ferado' ),
					'section'  => 'typography',
					'priority' => 20,
					'type'     => 'text',
				),
				'wr_heading_h6_font_size' => array(
					'label'    => __( 'H6 Font Size (px)', 'ferado' ),
					'section'  => 'typography',
					'priority' => 21,
					'type'     => 'text',
				),
			)
		);

		/*--------------------------------------------------------------
			Header
		--------------------------------------------------------------*/
		if ( $wp_customize ) {
			$wp_customize->get_section( 'header_image' )->priority = 50;
			$wp_customize->get_section( 'header_image' )->title = __( 'Header', 'ferado' );
		}
		$theme_options['header'] = array(
			'settings'    => array(
				'wr_header_layout' => array(
					'default'           => 'header-v1',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_sticky_menu' => array(
					'default'           => '1',
					'sanitize_callback' => 'wr_ferado_sanitize_checkbox',
				),
				'wr_search_box' => array(
					'default'           => '1',
					'sanitize_callback' => 'wr_ferado_sanitize_checkbox',
				),
				'wr_search_box_text' => array(
					'default'           => __( 'Enter your keywords', 'ferado' ),
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_header_info' => array(
					'default'           => '',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'header_image_sub_title' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				)
			),
			'controls' => array(
				'wr_header_layout' => array(
					'label'    => __( 'Blog List Layout', 'ferado' ),
					'section'  => 'header_image',
					'type'     => 'select',
					'priority' => 0,
					'choices'  => array(
						'header-v1' => __( 'Header version 1', 'ferado' ),
						'header-v2' => __( 'Header version 2', 'ferado' )
					),
				),
				'wr_sticky_menu' => array(
					'label'    => __( 'Enable sticky menu', 'ferado' ),
					'section'  => 'header_image',
					'type'     => 'checkbox',
					'priority' => 1,
				),
				'wr_search_box' => array(
					'label'    => __( 'Show search box', 'ferado' ),
					'section'  => 'header_image',
					'type'     => 'checkbox',
					'priority' => 2,
				),
				'wr_search_box_text' => array(
					'label'    => __( 'Search text', 'ferado' ),
					'section'  => 'header_image',
					'priority' => 3,
					'type'     => 'text',
				),
				'wr_header_info' => array(
					'label'    => __( 'Right header info (HTML allowed)', 'ferado' ),
					'section'  => 'header_image',
					'type'     => 'textarea',
					'priority' => 4,
				),
				'header_image_sub_title' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'args' => array(
						'label'    => __( 'Background image', 'ferado' ),
						'section'  => 'header_image',
						'priority' => 5
					)
				),
			)
		);

		/*--------------------------------------------------------------
			Page Layout
		--------------------------------------------------------------*/
		if ( $wp_customize ) {
			$wp_customize->remove_section( 'background_image' );
			$wp_customize->get_control( 'background_image' )->section = 'page_layout';
			$wp_customize->get_control( 'background_image' )->priority = 2;
		}
		$theme_options['page_layout'] = array(
			'title'       => __( 'Page Layout', 'ferado' ),
			'description' => __( 'Select page layout with sidebar display.', 'ferado' ),
			'priority'    => 60,
			'settings'    => array(
				'wr_page_layout' => array(
					'default'           => 'main-right',
					'sanitize_callback' => 'wr_ferado_sanitize_page_layout',
				),
				'wr_layout_boxed' => array(
					'default'           => 0,
					'sanitize_callback' => 'wr_ferado_sanitize_checkbox',
				),
				'wr_page_bg_repeat' => array(
					'default'           => 'no-repeat',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_bg_position' => array(
					'default'           => 'left',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_bg_position' => array(
					'default'           => 'left',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_bg_attachment' => array(
					'default'           => 'scroll',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_comments' => array(
					'default'           => '0',
					'sanitize_callback' => 'wr_ferado_sanitize_checkbox',
				),
				'wr_blog_layout' => array(
					'default'           => 'large_thumb',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_title_setting' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_title_image' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_title_bg_repeat' => array(
					'default'           => 'no-repeat',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_title_bg_position' => array(
					'default'           => 'left',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_title_bg_attachment' => array(
					'default'           => 'scroll',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_page_title_alignment' => array(
					'default'           => 'center',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				)
			),
			'controls' => array(
				'wr_page_layout' => array(
					'type' => 'WR_Ferado_Checkbox_Image_Control',
					'args' => array(
						'label'    => __( 'Select Page Layout', 'ferado' ),
						'section'  => 'page_layout',
						'priority' => 0,
						'choices'  => array(
							'main'            => __( 'Main', 'ferado' ),
							'left-main'       => __( 'Left - Main', 'ferado' ),
							'main-right'      => __( 'Main - Right', 'ferado' ),
							'left-main-right' => __( 'Left - Main - Right', 'ferado' ),
							'left-right-main' => __( 'Left - Right - Main', 'ferado' ),
							'main-left-right' => __( 'Main - Left - Right', 'ferado' )
						)
					)
				),
				'wr_layout_boxed' => array(
					'label'    => __( 'Enable Boxed Layout', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'checkbox',
					'priority' => 1,
				),
				'wr_page_bg_repeat' => array(
					'label'    => __( 'Background Repeat', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'radio',
					'priority' => 2,
					'choices'  => array(
						'no-repeat' => __( 'No Repeat', 'ferado' ),
						'repeat'    => __( 'Repeat', 'ferado' ),
						'repeat-x'  => __( 'Repeat X', 'ferado' ),
						'repeat-y'  => __( 'Repeat Y', 'ferado' ),
					),
				),
				'wr_page_bg_position' => array(
					'label'    => __( 'Background Position', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'radio',
					'priority' => 2,
					'choices'  => array(
						'left'   => __( 'Left', 'ferado' ),
						'center' => __( 'Center', 'ferado' ),
						'right'  => __( 'Right', 'ferado' ),
					),
				),
				'wr_page_bg_attachment' => array(
					'label'    => __( 'Background Attachment', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'radio',
					'priority' => 2,
					'choices'  => array(
						'scroll' => __( 'Scroll', 'ferado' ),
						'fixed'  => __( 'Fixed', 'ferado' ),
					),
				),
				'wr_page_comments' => array(
					'label'    => __( 'Show Comments', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'radio',
					'priority' => 2,
					'choices'  => array(
						'1' => __( 'Yes', 'ferado' ),
						'0' => __( 'No', 'ferado' ),
					),
				),
				'wr_blog_layout' => array(
					'label'    => __( 'Blog List Layout', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'select',
					'priority' => 3,
					'choices'  => array(
						'large_thumb' => __( 'Large featured image', 'ferado' ),
						'small_thumb' => __( 'Small featured image', 'ferado' ),
						'masonry'     => __( 'Masonry', 'ferado' ),
					),
				),
				'wr_page_title_setting' => array(
					'type' => 'WR_Ferado_Subtitle_Control',
					'priority' => 4,
					'args' => array(
						'label'    => __( 'Page title settings', 'ferado' ),
						'section'  => 'page_layout'
					)
				),
				'wr_page_title_image' => array(
					'type' => 'WP_Customize_Image_Control',
					'args' => array(
						'label'    => __( 'Page Title Background Image', 'ferado' ),
						'section'  => 'page_layout',
						'priority' => 10,
					),
				),
				'wr_page_title_bg_repeat' => array(
					'label'    => __( 'Background Repeat', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'radio',
					'priority' => 11,
					'choices'  => array(
						'no-repeat' => __( 'No Repeat', 'ferado' ),
						'repeat'    => __( 'Repeat', 'ferado' ),
						'repeat-x'  => __( 'Repeat X', 'ferado' ),
						'repeat-y'  => __( 'Repeat Y', 'ferado' ),
					),
				),
				'wr_page_title_bg_position' => array(
					'label'    => __( 'Background Position', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'radio',
					'priority' => 12,
					'choices'  => array(
						'left'   => __( 'Left', 'ferado' ),
						'center' => __( 'Center', 'ferado' ),
						'right'  => __( 'Right', 'ferado' ),
					),
				),
				'wr_page_title_bg_attachment' => array(
					'label'    => __( 'Background Attachment', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'radio',
					'priority' => 12,
					'choices'  => array(
						'scroll' => __( 'Scroll', 'ferado' ),
						'fixed'  => __( 'Fixed', 'ferado' ),
					),
				),
				'wr_page_title_alignment' => array(
					'label'    => __( 'Page Title Alignment', 'ferado' ),
					'section'  => 'page_layout',
					'type'     => 'select',
					'priority' => 13,
					'choices'  => array(
						'left'   => __( 'Left', 'ferado' ),
						'center' => __( 'Center', 'ferado' ),
						'right'  => __( 'Right', 'ferado' ),
					),
				)
			)
		);

		/*--------------------------------------------------------------
			WooCommerce Layout
		--------------------------------------------------------------*/
		if ( class_exists( 'Woocommerce' ) ) :
			$theme_options['wcm_layout'] = array(
				'title'    => __( 'WooCommerce Layout', 'ferado' ),
				'priority' => 70,
				'settings' => array(
					'wr_wcm_layout' => array(
						'default'           => 'left-main',
						'sanitize_callback' => 'wr_ferado_sanitize_cb',
					),
					'wr_wcm_list_product_layout' => array(
						'default'           => '1',
						'sanitize_callback' => 'wr_ferado_sanitize_cb',
					),
					'wr_wcm_shop_cart' => array(
						'default'           => '1',
						'sanitize_callback' => 'wr_ferado_sanitize_checkbox',
					)
				),
				'controls' => array(
					'wr_wcm_layout' => array(
						'type' => 'WR_Ferado_Checkbox_Image_Control',
						'args' => array(
							'label'    => __( 'Product list layout', 'ferado' ),
							'section'  => 'wcm_layout',
							'priority' => 1,
							'choices'  => array(
								'main'       => __( 'Main', 'ferado' ),
								'left-main'  => __( 'Left - Main', 'ferado' ),
								'main-right' => __( 'Main - Right', 'ferado' ),
							)
						)
					),
					'wr_wcm_list_product_layout' => array(
						'label'       => __( 'Product list style', 'ferado' ),
						'section'     => 'wcm_layout',
						'type'        => 'radio',
						'priority'    => 4,
						'choices'     => array(
							'1' => __( 'Grid', 'ferado' ),
							'0' => __( 'List', 'ferado' ),
						),
					),
					'wr_wcm_shop_cart' => array(
						'label'    => __( 'Show shop cart in header', 'ferado' ),
						'section'  => 'wcm_layout',
						'type'     => 'checkbox',
						'priority' => 5,
					)
				)
			);
		endif;

		/*--------------------------------------------------------------
			Social Network
		--------------------------------------------------------------*/
		$theme_options['footer'] = array(
			'title'       => __( 'Footer', 'ferado' ),
			'description' => __( 'Config for display text on footer and set the URLs for your social media profiles here to be used in the header. Adding in a link will make its respective icon show up without needing to do anything else.', 'ferado' ),
			'priority'    => 80,
			'settings'    => array(
				'wr_copyright_text' => array(
					'default'           => 'Proudly powered by WordPress | Designed By <a href="http://www.woorockets.com">WooRockets</a>.',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_footer_right_text' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_facebook' => array(
					'default'           => 'https://www.facebook.com/woorockets',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_twitter' => array(
					'default'           => 'https://twitter.com/woorockets',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_dribbble' => array(
					'default'           => 'https://dribbble.com/woorockets',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_googleplus' => array(
					'default'           => 'https://plus.google.com/u/0/111984051165567587486/about',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_vimeo' => array(
					'default'           => 'http://vimeo.com/woorockets',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_wordpress' => array(
					'default'           => 'http://profiles.wordpress.org/woorockets',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_pinterest' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_linkedin' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_yahoo' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_skype' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_stumbleupon' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_youtube' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_flickr' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_rss' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_myspace' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_social_tumblr' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				)
			),
			'controls' => array(
				'wr_copyright_text' => array(
					'label'    => __( 'Left Footer', 'ferado' ),
					'section'  => 'footer',
					'type'     => 'textarea',
					'priority' => 0,
				),
				'wr_footer_right_text' => array(
					'label'    => __( 'Right Footer', 'ferado' ),
					'section'  => 'footer',
					'type'     => 'textarea',
					'priority' => 1,
				),
				'wr_social_facebook' => array(
					'label'    => __( 'Facebook', 'ferado' ),
					'section'  => 'footer',
					'priority' => 2,
					'type'     => 'text',
				),
				'wr_social_twitter' => array(
					'label'    => __( 'Twitter', 'ferado' ),
					'section'  => 'footer',
					'priority' => 3,
					'type'     => 'text',
				),
				'wr_social_dribbble' => array(
					'label'    => __( 'Dribbble', 'ferado' ),
					'section'  => 'footer',
					'priority' => 4,
					'type'     => 'text',
				),
				'wr_social_googleplus' => array(
					'label'    => __( 'Google Plus', 'ferado' ),
					'section'  => 'footer',
					'priority' => 5,
					'type'     => 'text',
				),
				'wr_social_vimeo' => array(
					'label'    => __( 'Vimeo', 'ferado' ),
					'section'  => 'footer',
					'priority' => 6,
					'type'     => 'text',
				),
				'wr_social_wordpress' => array(
					'label'    => __( 'WordPress', 'ferado' ),
					'section'  => 'footer',
					'priority' => 7,
					'type'     => 'text',
				),
				'wr_social_pinterest' => array(
					'label'    => __( 'Pinterest', 'ferado' ),
					'section'  => 'footer',
					'priority' => 8,
					'type'     => 'text',
				),
				'wr_social_linkedin' => array(
					'label'    => __( 'LinkedIn', 'ferado' ),
					'section'  => 'footer',
					'priority' => 9,
					'type'     => 'text',
				),
				'wr_social_yahoo' => array(
					'label'    => __( 'Yahoo', 'ferado' ),
					'section'  => 'footer',
					'priority' => 10,
					'type'     => 'text',
				),
				'wr_social_skype' => array(
					'label'    => __( 'Skype', 'ferado' ),
					'section'  => 'footer',
					'priority' => 11,
					'type'     => 'text',
				),
				'wr_social_stumbleupon' => array(
					'label'    => __( 'Stumbleupon', 'ferado' ),
					'section'  => 'footer',
					'priority' => 12,
					'type'     => 'text',
				),
				'wr_social_youtube' => array(
					'label'    => __( 'Youtube', 'ferado' ),
					'section'  => 'footer',
					'priority' => 13,
					'type'     => 'text',
				),
				'wr_social_flickr' => array(
					'label'    => __( 'Flickr', 'ferado' ),
					'section'  => 'footer',
					'priority' => 14,
					'type'     => 'text',
				),
				'wr_social_rss' => array(
					'label'    => __( 'RSS', 'ferado' ),
					'section'  => 'footer',
					'priority' => 15,
					'type'     => 'text',
				),
				'wr_social_myspace' => array(
					'label'    => __( 'MySpace', 'ferado' ),
					'section'  => 'footer',
					'priority' => 16,
					'type'     => 'text',
				),
				'wr_social_tumblr' => array(
					'label'    => __( 'Tumblr', 'ferado' ),
					'section'  => 'footer',
					'priority' => 17,
					'type'     => 'text',
				)
			)
		);

		/*--------------------------------------------------------------
			Extras
		--------------------------------------------------------------*/
		$theme_options['extras'] = array(
			'title'    => __( 'Extras', 'ferado' ),
			'priority' => 90,
			'settings' => array(
				'wr_loading' => array(
					'default'           => '1',
					'sanitize_callback' => 'wr_ferado_sanitize_checkbox',
				),
				'wr_favicon' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_google_analytics_code' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_maintenance_mode' => array(
					'default'           => '0',
					'sanitize_callback' => 'wr_ferado_sanitize_checkbox',
				),
				'wr_maintenance_mode_message' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_maintenance_mode_timer' => array(
					'default'           => 'January 01, 2020',
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_code_at_end_of_head' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				),
				'wr_code_at_end_of_body' => array(
					'sanitize_callback' => 'wr_ferado_sanitize_cb',
				)
			),
			'controls' => array(
				'wr_loading' => array(
					'label'    => __( 'Enable page loading effect', 'ferado' ),
					'section'  => 'extras',
					'type'     => 'checkbox',
					'priority' => 0,
				),
				'favicon' => array(
					'type' => 'WP_Customize_Image_Control',
					'args' => array(
						'label'    => __( 'Upload Favicon', 'ferado' ),
						'section'  => 'extras',
						'settings' => 'wr_favicon',
						'priority' => 1
					)
				),
				'wr_google_analytics_code' => array(
					'label'    => __( 'Google Analytics Code', 'ferado' ),
					'section'  => 'extras',
					'type'     => 'textarea',
					'priority' => 2,
				),
				'wr_maintenance_mode' => array(
					'label'    => __( 'Enable Under construction mode', 'ferado' ),
					'section'  => 'extras',
					'type'     => 'radio',
					'priority' => 3,
					'choices'  => array(
						'1' => __( 'Yes', 'ferado' ),
						'0' => __( 'No', 'ferado' ),
					),
				),
				'wr_maintenance_mode_message' => array(
					'label'    => __( 'Your Away Message', 'ferado' ),
					'section'  => 'extras',
					'type'     => 'textarea',
					'priority' => 4,
				),
				'wr_maintenance_mode_timer' => array(
					'label'    => __( 'Countdown timer (Format: M D, Y)', 'ferado' ),
					'section'  => 'extras',
					'type'     => 'text',
					'priority' => 5,
				),
				'wr_code_at_end_of_head' => array(
					'label'    => __( 'Code Before &lt;/head&gt;', 'ferado' ),
					'section'  => 'extras',
					'type'     => 'textarea',
					'priority' => 6,
				),
				'wr_code_at_end_of_body' => array(
					'label'    => __( 'Code Before &lt;/body&gt;', 'ferado' ),
					'section'  => 'extras',
					'type'     => 'textarea',
					'priority' => 7,
				)
			)
		);

		/*--------------------------------------------------------------
			Register theme options with WordPress
		--------------------------------------------------------------*/
		if ( $wp_customize ) {
			foreach ( $theme_options as $section => $define ) {
				// Get settings
				$settings = isset( $define['settings'] ) ? $define['settings'] : array();

				// Get controls
				$controls = isset( $define['controls'] ) ? $define['controls'] : array();

				// Unset settings and controls data
				unset( $define['settings'] );
				unset( $define['controls'] );

				// Check if section already exists
				if ( $wp_customize->get_section( $section ) ) {
					foreach ( $define as $k => $v ) {
						$wp_customize->get_section( $section )->$k = $v;
					}
				} else {
					$wp_customize->add_section( $section, $define );
				}

				// Add settings
				foreach ( $settings as $setting => $define ) {
					$wp_customize->add_setting( $setting, array_merge( array( 'sanitize_callback' => null ), $define ) );
				}

				// Add controls
				foreach ( $controls as $control => $define ) {
					if ( isset( $define['type'] ) && class_exists( $define['type'] ) ) {
						$wp_customize->add_control( new $define['type']( $wp_customize, $control, isset( $define['args'] ) ? $define['args'] : array() ) );
					} else {
						$wp_customize->add_control( $control, $define );
					}
				}
			}
		}

		if ( ! $wp_customize ) {
			return $theme_options;
		}
	}

	add_action( 'customize_register', 'wr_ferado_theme_options' );
}

/**
 * Sanitizes the general.
 *
 * @since 1.0
 */
if ( ! function_exists( 'wr_ferado_sanitize_cb' ) ) {
	function wr_ferado_sanitize_cb( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
	}
}

/**
 * Sanitizes the checkbox.
 *
 * @since 1.0
 */
if ( ! function_exists( 'wr_ferado_sanitize_checkbox' ) ) {
	function wr_ferado_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return 0;
		}
	}
}

/**
 * Sanitizes the color schemes.
 *
 * @since 1.0
 */
if ( ! function_exists( 'wr_ferado_sanitize_color_placement' ) ) {
	function wr_ferado_sanitize_color_placement( $input ) {
		$valid = array(
			'red'    => __( 'Red', 'ferado' ),
			'brown'  => __( 'Brown', 'ferado' ),
			'yellow' => __( 'Yellow', 'ferado' ),
			'blue'   => __( 'Blue', 'ferado' ),
			'green'  => __( 'Green', 'ferado' ),
			'purple' => __( 'Purple', 'ferado' ),
		);
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
}

/**
 * Sanitizes the page layout.
 *
 * @since 1.0
 */
if ( ! function_exists( 'wr_ferado_sanitize_page_layout' ) ) {
	function wr_ferado_sanitize_page_layout( $input ) {
		$valid = array(
			'main'            => __( 'Main', 'ferado' ),
			'left-main'       => __( 'Left - Main', 'ferado' ),
			'main-right'      => __( 'Main - Right', 'ferado' ),
			'left-main-right' => __( 'Left - Main - Right', 'ferado' ),
			'left-right-main' => __( 'Left - Right - Main', 'ferado' ),
			'main-left-right' => __( 'Main - Left - Right', 'ferado' )
		);
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
}

/**
 * Sanitizes the color schemes data.
 *
 * @since 1.1
 */
function wr_ferado_get_color_schemes() {
	return apply_filters( 'ferado_color_schemes',
		array(
			'red' => array(
				'label'  => __( 'Red', 'ferado' ),
				'colors' => array(
					'wr_body_color'          => '#39342e',
					'wr_body_bg_color'       => '#ffffff',
					'wr_page_title_color'    => '#f45245',
					'wr_page_title_bg_color' => '#e2e2e2',
					'wr_main_menu_color'     => '#ffffff',
					'wr_heading_color'       => '#353533',
					'wr_footer_bg_color'     => '#2e2e2e',
				),
			),
			'brown'    => array(
				'label'  => __( 'Brown', 'ferado' ),
				'colors' => array(
					'wr_body_color'          => '#39342e',
					'wr_body_bg_color'       => '#ffffff',
					'wr_page_title_color'    => '#786d5b',
					'wr_page_title_bg_color' => '#e2e2e2',
					'wr_main_menu_color'     => '#ffffff',
					'wr_heading_color'       => '#353533',
					'wr_footer_bg_color'     => '#2e2e2e',
				),
			),
			'yellow'    => array(
				'label'  => __( 'Yellow', 'ferado' ),
				'colors' => array(
					'wr_body_color'          => '#39342e',
					'wr_body_bg_color'       => '#ffffff',
					'wr_page_title_color'    => '#c99542',
					'wr_page_title_bg_color' => '#e2e2e2',
					'wr_main_menu_color'     => '#ffffff',
					'wr_heading_color'       => '#353533',
					'wr_footer_bg_color'     => '#2e2e2e',
				),
			),
			'blue'    => array(
				'label'  => __( 'Blue', 'ferado' ),
				'colors' => array(
					'wr_body_color'          => '#39342e',
					'wr_body_bg_color'       => '#ffffff',
					'wr_page_title_color'    => '#68a8aa',
					'wr_page_title_bg_color' => '#e2e2e2',
					'wr_main_menu_color'     => '#ffffff',
					'wr_heading_color'       => '#353533',
					'wr_footer_bg_color'     => '#2e2e2e',
				),
			),
			'green'    => array(
				'label'  => __( 'Green', 'ferado' ),
				'colors' => array(
					'wr_body_color'          => '#39342e',
					'wr_body_bg_color'       => '#ffffff',
					'wr_page_title_color'    => '#68aa71',
					'wr_page_title_bg_color' => '#e2e2e2',
					'wr_main_menu_color'     => '#ffffff',
					'wr_heading_color'       => '#353533',
					'wr_footer_bg_color'     => '#2e2e2e',
				),
			),
			'purple'    => array(
				'label'  => __( 'Purple', 'ferado' ),
				'colors' => array(
					'wr_body_color'          => '#39342e',
					'wr_body_bg_color'       => '#ffffff',
					'wr_page_title_color'    => '#65759b',
					'wr_page_title_bg_color' => '#e2e2e2',
					'wr_main_menu_color'     => '#ffffff',
					'wr_heading_color'       => '#353533',
					'wr_footer_bg_color'     => '#2e2e2e',
				),
			),
		)
	);
}

/**
 * Enqueue script for custom customize control.
 */
function wr_ferado_customizer_control_js() {

	// Enqueue customizer script
	wp_enqueue_script( 'ferado-customizer-control', get_template_directory_uri() . '/assets/js/customizer-control.js', array( 'jquery', 'customize-controls' ), '', true );

	// Load customizer color scheme data
	wp_localize_script( 'ferado-customizer-color', 'wr_colorScheme', wr_ferado_get_color_schemes() );

	// Load customizer stylesheet.
	wp_enqueue_style( 'ferado-customizer', get_template_directory_uri() . '/assets/css/customizer.css' );

}
add_action( 'customize_controls_enqueue_scripts', 'wr_ferado_customizer_control_js' );

/**
 * Add google fonts.
 */
require get_template_directory() . '/inc/admin/fonts.php';