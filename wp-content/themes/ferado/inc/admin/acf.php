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

if ( function_exists( 'register_field_group' ) ) {
	register_field_group(
		array(
			'id'     => 'layout-options',
			'title'  => __( 'Layout Options', 'ferado' ),
			'fields' => array(
				array(
					'key'          => 'field_549b74c3ad94f',
					'label'        =>  __( 'Select a specific layout for this page', 'ferado' ),
					'name'         => 'acf_page_layout',
					'type'         => 'select',
					'instructions' => __( 'Default layout: <strong>Global Layout On Customizer</strong>', 'ferado' ),
					'choices' => array(
						'default'         => __( 'Default', 'ferado' ),
						'main'            => __( 'Full Width', 'ferado' ),
						'left-main'       => __( 'Left Sidebar', 'ferado' ),
						'main-right'      => __( 'Right Sidebar', 'ferado' ),
						'left-main-right' => __( 'Left - Main Content - Right', 'ferado' ),
						'left-right-main' => __( 'Left - Right - Main Content', 'ferado' ),
						'main-left-right' => __( 'Main Content - Left - Right', 'ferado' )
					),
					'default_value' => 'default',
					'allow_null'    => 0,
					'multiple'      => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page'
					),
				),
			),
			'options' => array(
				'position'       => 'side',
				'layout'         => 'default',
				'hide_on_screen' => array(
				),
			),
			'menu_order' => 0,
		)
	);

	register_field_group(
		array(
			'id'     => 'post-options',
			'title'  => __( 'Post Options', 'ferado' ),
			'fields' => array(
				array(
					'key'               => 'field_53df40c5588c3',
					'label'             => __( 'Post Layout', 'ferado' ),
					'name'              => '',
					'prefix'            => '',
					'type'              => 'tab',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
				),
				array(
					'key'           => 'field_549b74c3ad95f',
					'label'         => __( 'Post layout', 'ferado' ),
					'name'          => 'acf_post_layout',
					'type'          => 'true_false',
					'instructions'  => __( 'Enable large post type for <b>masonry layout only</b>', 'ferado' ),
					'default_value' => '0',
					'allow_null'    => 0,
					'multiple'      => 0,
				),
				array(
					'key'               => 'field_53df3ff5e761f',
					'label'             => 'Post format',
					'name'              => '',
					'prefix'            => '',
					'type'              => 'tab',
					'instructions'      => '',
				),
				array(
					'key'     => 'field_54b4d34c04152',
					'label'   => __( 'Choose video source', 'ferado' ),
					'name'    => 'video',
					'type'    => 'select',
					'choices' => array(
						'link'  => __( 'Video Link', 'ferado' ),
						'embed' => __( 'Video Embed code', 'ferado' ),
						'local' => __( 'Upload local file', 'ferado' ),
					),
					'default_value' => 1,
					'allow_null'    => 0,
					'multiple'      => 0,
				),
				array(
					'key'          => 'field_54b4d36704153',
					'label'        => __( 'Video URL', 'ferado' ),
					'name'         => 'video_url',
					'instructions' => __( 'You can choose Youtube or Vimeo link (eg: https://www.youtube.com/watch?v=uxHXATYpt2w)', 'ferado' ),
					'type'         => 'text',
					'conditional_logic' => array(
						'status' => 1,
						'rules'  => array(
							array(
								'field'    => 'field_54b4d34c04152',
								'operator' => '==',
								'value'    => 'link',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'html',
					'maxlength'     => '',
				),
				array(
					'key'          => 'field_54b4d7287f15f',
					'label'        => __( 'Video embed code', 'ferado' ),
					'name'         => 'video_code',
					'instructions' => __( 'Paste video embed code', 'ferado' ),
					'type'         => 'textarea',
					'conditional_logic' => array(
						'status' => 1,
						'rules'  => array(
							array(
								'field'    => 'field_54b4d34c04152',
								'operator' => '==',
								'value'    => 'embed',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'html',
					'maxlength'     => '',
				),
				array(
					'key'          => 'field_54b4d7387f160',
					'label'        => __( 'Upload video', 'ferado' ),
					'name'         => 'video_local',
					'instructions' => __( 'Support .mp4 file format only', 'ferado' ),
					'type'         => 'file',
					'conditional_logic' => array(
						'status' => 1,
						'rules'  => array(
							array(
								'field'    => 'field_54b4d34c04152',
								'operator' => '==',
								'value'    => 'local',
							),
						),
						'allorany' => 'all',
					),
					'return_format' => 'array',
					'library'       => 'all',
				),
				array(
					'key'     => 'field_53e2etiff58b8',
					'label'   => __( 'Choose audio source', 'ferado' ),
					'name'    => 'audio',
					'type'    => 'select',
					'choices' => array(
						'link'  => __( 'Soundcloud link', 'ferado' ),
						'local' => __( 'Upload local file', 'ferado' ),
					),
					'default_value' => 1,
					'allow_null'    => 0,
					'multiple'      => 0,
				),
				array(
					'key'          => 'field_53de3fbbcb5e4',
					'label'        => __( 'Soundcloud URL', 'ferado' ),
					'name'         => 'audio_url',
					'type'         => 'text',
					'conditional_logic' => array(
						'status' => 1,
						'rules'  => array(
							array(
								'field'    => 'field_53e2etiff58b8',
								'operator' => '==',
								'value'    => 'link',
							),
						),
						'allorany' => 'all',
					),
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'html',
					'maxlength'     => '',
				),
				array(
					'key'          => 'field_53df78207e597',
					'label'        => __( 'Upload audio', 'ferado' ),
					'name'         => 'audio_local',
					'instructions' => __( 'Support .mp3 file format only', 'ferado' ),
					'type'         => 'file',
					'conditional_logic' => array(
						'status' => 1,
						'rules'  => array(
							array(
								'field'    => 'field_53e2etiff58b8',
								'operator' => '==',
								'value'    => 'local',
							),
						),
						'allorany' => 'all',
					),
					'return_format' => 'array',
					'library'       => 'all',
				),
				array(
					'key'           => 'field_54b4da10e832c',
					'label'         => __( 'Gallery', 'ferado' ),
					'name'          => 'gallery',
					'instructions'  => __( 'Insert gallery shortcode', 'ferado' ),
					'type'          => 'text',
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'html',
					'maxlength'     => '',
				),
				array(
					'key'           => 'field_53d9aedbf3c36',
					'label'         => __( 'Quote author', 'ferado' ),
					'name'          => 'quote_author',
					'instructions'  => __( 'Option for format "quote" only', 'ferado' ),
					'type'          => 'text',
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'maxlength'     => '',
				),
				array(
					'key'          => 'field_543390cd5aafb',
					'label'        => __( 'Author quote url', 'ferado' ),
					'name'         => 'quote_url',
					'instructions' => __( 'Option for format "quote" only', 'ferado' ),
					'type'         => 'text',
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'formatting'    => 'html',
					'maxlength'     => '',
				),
				array(
					'key'           => 'field_543830cd5aafb',
					'label'         => __( 'Quote Content', 'ferado' ),
					'name'          => 'quote_content',
					'instructions'  => __( 'Option for format "quote" only', 'ferado' ),
					'type'          => 'wysiwyg',
					'default_value' => '',
					'toolbar'       => 'basic',
					'media_upload'  => 'no',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'options' => array(
				'position'       => 'normal',
				'layout'         => 'default',
				'hide_on_screen' => array(
				),
			),
		)
	);
}
