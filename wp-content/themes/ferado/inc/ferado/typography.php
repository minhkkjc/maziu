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
 * Customizer Color Schemes CSS Output
 *
 * @package Ferado
 */
function wr_ferado_fonts_output() {
	// Get parameter of body font
	$body_font                 = wr_ferado_theme_option( 'wr_body_font' );
	$body_font_family_google   = wr_ferado_theme_option( 'wr_body_font_google_family' );
	$body_font_weight_google   = wr_ferado_theme_option( 'wr_body_font_google_weight' );
	$body_font_family_standard = wr_ferado_theme_option( 'wr_body_font_standard_family' );
	$body_font_weight_standard = wr_ferado_theme_option( 'wr_body_font_standard_weight' );
	$body_font_size            = wr_ferado_theme_option( 'wr_body_font_size' );

	// Get parameter of page title font
	$page_title_font                 = wr_ferado_theme_option( 'wr_page_title_font' );
	$page_title_font_family_google   = wr_ferado_theme_option( 'wr_page_title_font_google_family' );
	$page_title_font_weight_google   = wr_ferado_theme_option( 'wr_page_title_font_google_weight' );
	$page_title_font_family_standard = wr_ferado_theme_option( 'wr_page_title_font_standard_family' );
	$page_title_font_weight_standard = wr_ferado_theme_option( 'wr_page_title_font_standard_weight' );
	$page_title_font_size            = wr_ferado_theme_option( 'wr_page_title_font_size' );

	// Get parameter of heading font
	$heading_font                 = wr_ferado_theme_option( 'wr_heading_font' );
	$heading_font_family_google   = wr_ferado_theme_option( 'wr_heading_font_google_family' );
	$heading_font_weight_google   = wr_ferado_theme_option( 'wr_heading_font_google_weight' );
	$heading_font_family_standard = wr_ferado_theme_option( 'wr_heading_font_standard_family' );
	$heading_font_weight_standard = wr_ferado_theme_option( 'wr_heading_font_standard_weight' );
	$heading_h1_font_size         = wr_ferado_theme_option( 'wr_heading_h1_font_size' );
	$heading_h2_font_size         = wr_ferado_theme_option( 'wr_heading_h2_font_size' );
	$heading_h3_font_size         = wr_ferado_theme_option( 'wr_heading_h3_font_size' );
	$heading_h4_font_size         = wr_ferado_theme_option( 'wr_heading_h4_font_size' );
	$heading_h5_font_size         = wr_ferado_theme_option( 'wr_heading_h5_font_size' );
	$heading_h6_font_size         = wr_ferado_theme_option( 'wr_heading_h6_font_size' );

	// Get parameter of logo font
	$logo_font          = wr_ferado_theme_option( 'wr_logo_type' );
	$logo_font_family   = wr_ferado_theme_option( 'blogname_font_family' );
	$logo_font_weight   = wr_ferado_theme_option( 'blogname_font_weight' );
	$logo_font_size     = wr_ferado_theme_option( 'blogname_font_size' );

	$body_font_style = $page_title_font_style = $heading_font_style = $logo_font_style = '';

	if ( 'google_font' == $body_font ) {
		$body_font_family = "$body_font_family_google";
		if ( '100_i' == $body_font_weight_google || '300_i' == $body_font_weight_google || '400_i' == $body_font_weight_google || '600_i' == $body_font_weight_google || '700_i' == $body_font_weight_google || '800_i' == $body_font_weight_google || '900_i' == $body_font_weight_google )  {
			$body_font_weight = substr( $body_font_weight_google, 0, -2 );
			$body_font_style  = "font-style: italic;";
		} else {
			$body_font_weight = $body_font_weight_google;
		}
	} elseif ( 'standard_font' == $body_font ) {
		$body_font_family = $body_font_family_standard;
		if ( 'normal_i' == $body_font_weight_standard || 'bold_i' == $body_font_weight_standard ) {
			$body_font_weight = substr( $body_font_weight_standard, 0, -2 );
			$body_font_style  = "font-style: italic;";
		} else {
			$body_font_weight = $body_font_weight_standard;
		}
	}

	if ( 'google_font' == $page_title_font ) {
		$page_title_font_family = "$page_title_font_family_google";
		if ( '100_i' == $page_title_font_weight_google || '300_i' == $page_title_font_weight_google || '400_i' == $page_title_font_weight_google || '600_i' == $page_title_font_weight_google || '700_i' == $page_title_font_weight_google || '800_i' == $page_title_font_weight_google || '900_i' == $page_title_font_weight_google )  {
			$page_title_font_weight = substr( $page_title_font_weight_google, 0, -2 );
			$page_title_font_style  = "font-style: italic;";
		} else {
			$page_title_font_weight = $page_title_font_weight_google;
		}
	} elseif ( 'standard_font' == $page_title_font ) {
		$page_title_font_family = $page_title_font_family_standard;
		if ( 'normal_i' == $page_title_font_weight_standard || 'bold_i' == $page_title_font_weight_standard ) {
			$page_title_font_weight = substr( $page_title_font_weight_standard, 0, -2 );
			$page_title_font_style  = "font-style: italic;";
		} else {
			$page_title_font_weight = $page_title_font_weight_standard;
		}
	}

	if ( 'google_font' == $heading_font ) {
		$heading_font_family = "$heading_font_family_google";
		if ( '100_i' == $heading_font_weight_google || '300_i' == $heading_font_weight_google || '400_i' == $heading_font_weight_google || '600_i' == $heading_font_weight_google || '700_i' == $heading_font_weight_google || '800_i' == $heading_font_weight_google || '900_i' == $heading_font_weight_google )  {
			$heading_font_weight = substr( $heading_font_weight_google, 0, -2 );
			$heading_font_style  = "font-style: italic;";
		} else {
			$heading_font_weight = $heading_font_weight_google;
		}
	} elseif ( 'standard_font' == $heading_font ) {
		$heading_font_family = $heading_font_family_standard;
		if ( 'normal_i' == $heading_font_weight_standard || 'bold_i' == $heading_font_weight_standard ) {
			$heading_font_weight = substr( $heading_font_weight_standard, 0, -2 );
			$heading_font_style  = "font-style: italic;";
		} else {
			$heading_font_weight = $heading_font_weight_standard;
		}
	}

	if ( 'logo_text' == $logo_font ) {
		if ( '100_i' == $logo_font_weight || '300_i' == $logo_font_weight || '400_i' == $logo_font_weight || '600_i' == $logo_font_weight || '700_i' == $logo_font_weight || '800_i' == $logo_font_weight || '900_i' == $logo_font_weight )  {
			$logo_font_weight = substr( $logo_font_weight, 0, -2 );
			$logo_font_style  = "font-style: italic;";
		} else {
			$logo_font_weight = $logo_font_weight;
		}
	}

	if ( ! empty( $body_font ) || ! empty( $page_title_font ) || ! empty( $heading_font ) ) { ?>
		
		<style id="ferado-custom-fonts">
			body {
				font-family: <?php echo trim( $body_font_family ); ?>;
				font-size: <?php echo trim( $body_font_size ); ?>px;
				font-weight: <?php echo trim( $body_font_weight ); ?>;
				<?php echo trim( $body_font_style ); ?>
			}
			.site .jsn-master {
				font-family: <?php echo trim( $body_font_family ); ?>;
				font-size: <?php echo trim( $body_font_size ); ?>px;
			}
			h1, h2, h3, h4, h5, h6 {
				font-family: <?php echo trim( $heading_font_family ); ?>;
				font-weight: <?php echo trim( $heading_font_weight ); ?>;
				<?php echo trim( $heading_font_style ); ?>
			}
			h1 { font-size: <?php echo trim( $heading_h1_font_size ); ?>px; }
			h2 { font-size: <?php echo trim( $heading_h2_font_size ); ?>px; }
			h3 { font-size: <?php echo trim( $heading_h3_font_size ); ?>px; }
			h4 { font-size: <?php echo trim( $heading_h4_font_size ); ?>px; }
			h5 { font-size: <?php echo trim( $heading_h5_font_size ); ?>px; }
			h6 { font-size: <?php echo trim( $heading_h6_font_size ); ?>px; }
			.site-branding .site-title {
				font-family: "<?php echo trim( $logo_font_family ); ?>";
				font-size: <?php echo trim( $logo_font_size ); ?>px;
				font-weight: <?php echo trim( $logo_font_weight ); ?>;
				<?php echo trim( $logo_font_style ); ?>
			}
			<?php if ( 'google_font' == $page_title_font ) { ?>
				.page-title h1 {
					font-family: "<?php echo trim( $page_title_font_family_google ); ?>";
				}
			<?php } else { ?>
				.page-title h1 {
					font-family: <?php echo trim( $page_title_font_family_standard ); ?>;
				}
			<?php } ?>
			.page-title h1 {
				font-size: <?php echo trim( $page_title_font_size ); ?>px;
				font-weight: <?php echo trim( $page_title_font_weight ); ?>;
				<?php echo trim( $page_title_font_style ); ?>
			}
		</style>

	<?php }
}
add_action( 'wp_head', 'wr_ferado_fonts_output' );