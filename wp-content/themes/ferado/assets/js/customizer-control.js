/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	"use strict";

	$(document).ready(function() {

		// Logo switch
		var LogoType  = $( 'select[data-customize-setting-link="wr_logo_type"]' );
		var LogoImage = $( '#customize-control-wr_logo_image' );
		var LogoText  = $( 'li[id*="customize-control-blogname"]' );

		LogoType.on( 'update', function() {
			if ( $( this ).val() == 'logo_text') {
				LogoImage.css( 'display', 'none' );
				LogoText.css( 'display', 'block' );
			} else if ( $( this ).val() == 'logo_image') {
				LogoImage.css( 'display', 'block' );
				LogoText.css( 'display', 'none' );
			}
		});
		LogoType.trigger( 'update' );
		LogoType.change(function() {
			LogoType.trigger( 'update' );
		});

		// Header switch
		var HeaderType = $( 'select[data-customize-setting-link="wr_header_layout"]' );
		var HeaderInfo = $( 'li[id*="customize-control-wr_header_info"]' );
		var HeaderBG   = $( 'li[id*="customize-control-header_image"]' );

		HeaderType.on( 'update', function() {
			if ( $( this ).val() == 'header-v2') {
				HeaderInfo.css( 'display', 'block' );
				HeaderBG.css( 'display', 'none' );
			} else {
				HeaderInfo.css( 'display', 'none' );
				HeaderBG.css( 'display', 'block' );
			}
		});
		HeaderType.trigger( 'update' );
		HeaderType.change(function() {
			HeaderType.trigger( 'update' );
		});

		// Search box
		var SearchBox     = $( 'input[data-customize-setting-link="wr_search_box"]' );
		var SearchBoxText = $( 'li#customize-control-wr_search_box_text' );

		SearchBox.on( 'update', function() {
			if( $( this ).is( ':checked' ) && $( this ).val() == '1' ) {
				SearchBoxText.css( 'display', 'block' );
			} else {
				SearchBoxText.css( 'display', 'none' );
			}
		});
		SearchBox.trigger( 'update' );
		SearchBox.change(function() {
			SearchBox.trigger( 'update' );
		});

		// Enable offline
		var Offline        = $( 'input[data-customize-setting-link="wr_maintenance_mode"]' );
		var OfflineMessage = $( 'li[id*="customize-control-wr_maintenance_mode_"]' );

		Offline.on( 'update', function() {
			if( $( this ).is( ':checked' ) && $( this ).val() == '0' ) {
				OfflineMessage.css( 'display', 'none' );
			} else {
				OfflineMessage.css( 'display', 'block' );
			}
		});
		Offline.trigger( 'update' );
		Offline.change(function() {
			Offline.trigger( 'update' );
		});

		// Typography
		var BodyFontType     = $( 'select[data-customize-setting-link="wr_body_font"]' );
		var BodyFontGoogle   = $( 'li[id*="customize-control-wr_body_font_google_"]' );
		var BodyFontStandard = $( 'li[id*="customize-control-wr_body_font_standard_"]' );

		BodyFontType.on( 'update', function() {
			if ( $( this ).val() == 'standard_font') {
				BodyFontGoogle.css( 'display', 'none' );
				BodyFontStandard.css( 'display', 'block' );
			} else if ( $( this ).val() == 'google_font') {
				BodyFontGoogle.css( 'display', 'block' );
				BodyFontStandard.css( 'display', 'none' );
			}
		});
		BodyFontType.trigger( 'update' );
		BodyFontType.change(function() {
			BodyFontType.trigger( 'update' );
		});

		var PageTitleFontType     = $( 'select[data-customize-setting-link="wr_page_title_font"]' );
		var PageTitleFontGoogle   = $( 'li[id*="customize-control-wr_page_title_font_google_"]' );
		var PageTitleFontStandard = $( 'li[id*="customize-control-wr_page_title_font_standard_"]' );

		PageTitleFontType.on( 'update', function() {
			if ( $( this ).val() == 'standard_font') {
				PageTitleFontGoogle.css( 'display', 'none' );
				PageTitleFontStandard.css( 'display', 'block' );
			} else if ( $( this ).val() == 'google_font') {
				PageTitleFontGoogle.css( 'display', 'block' );
				PageTitleFontStandard.css( 'display', 'none' );
			}
		});
		PageTitleFontType.trigger( 'update' );
		PageTitleFontType.change(function() {
			PageTitleFontType.trigger( 'update' );
		});

		var HeadingFontType     = $( 'select[data-customize-setting-link="wr_heading_font"]' );
		var HeadingFontGoogle   = $( 'li[id*="customize-control-wr_heading_font_google_"]' );
		var HeadingFontStandard = $( 'li[id*="customize-control-wr_heading_font_standard_"]' );

		HeadingFontType.on( 'update', function() {
			if ( $( this ).val() == 'standard_font') {
				HeadingFontGoogle.css( 'display', 'none' );
				HeadingFontStandard.css( 'display', 'block' );
			} else if ( $( this ).val() == 'google_font') {
				HeadingFontGoogle.css( 'display', 'block' );
				HeadingFontStandard.css( 'display', 'none' );
			}
		});
		HeadingFontType.trigger( 'update' );
		HeadingFontType.change(function() {
			HeadingFontType.trigger( 'update' );
		});

		// Check background has image
		if ( ! $('#customize-control-wr_page_title_bg_image').find('img.attachment-thumb').length ) {
			$( 'li[id*="wr_page_title_bg_"]' ).hide();
		}
		if ( ! $('#customize-control-background_image').find('img.attachment-thumb').length ) {
			$( 'li[id*="wr_page_bg_"]' ).hide();
		}

	});
	
	// Image upload control
	wp.customize( 'wr_page_title_image', function( value ) {
		value.bind( function( to ) {
			console.log(value)
			var bg_control = $( 'li[id*="wr_page_title_bg_"]' );
			0 === $.trim( to ).length ? bg_control.hide() : bg_control.show();
		});
	});

	wp.customize( 'background_image', function( value ) {
		value.bind( function( to ) {
			var bg_control = $( 'li[id*="wr_page_bg_"]' );
			0 === $.trim( to ).length ? bg_control.hide() : bg_control.show();
		});
	});

} )( jQuery );

( function( api ) {
	api.Control = api.Control.extend( {
		ready: function() {

			if ( 'wr_color_schemes' === this.id ) {

				this.setting.bind( 'change', function( value ) {

					api( 'wr_c_body_color' ).set( wr_colorScheme[value].colors['wr_body_color'] );
					api.control( 'wr_c_body_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', wr_colorScheme[value].colors['wr_body_color'] )
						.wpColorPicker( 'defaultColor', wr_colorScheme[value].colors['wr_body_color'] );

					api( 'wr_c_body_bg_color' ).set( wr_colorScheme[value].colors['wr_body_bg_color'] );
					api.control( 'wr_c_body_bg_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', wr_colorScheme[value].colors['wr_body_bg_color'] )
						.wpColorPicker( 'defaultColor', wr_colorScheme[value].colors['wr_body_bg_color'] );

					api( 'wr_c_page_title_color' ).set( wr_colorScheme[value].colors['wr_page_title_color'] );
					api.control( 'wr_c_page_title_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', wr_colorScheme[value].colors['wr_page_title_color'] )
						.wpColorPicker( 'defaultColor', wr_colorScheme[value].colors['wr_page_title_color'] );

					api( 'wr_c_page_title_bg_color' ).set( wr_colorScheme[value].colors['wr_page_title_bg_color'] );
					api.control( 'wr_c_page_title_bg_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', wr_colorScheme[value].colors['wr_page_title_bg_color'] )
						.wpColorPicker( 'defaultColor', wr_colorScheme[value].colors['wr_page_title_bg_color'] );

					api( 'wr_c_main_menu_color' ).set( wr_colorScheme[value].colors['wr_main_menu_color'] );
					api.control( 'wr_c_main_menu_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', wr_colorScheme[value].colors['wr_main_menu_color'] )
						.wpColorPicker( 'defaultColor', wr_colorScheme[value].colors['wr_main_menu_color'] );

					api( 'wr_c_heading_color' ).set( wr_colorScheme[value].colors['wr_heading_color'] );
					api.control( 'wr_c_heading_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', wr_colorScheme[value].colors['wr_heading_color'] )
						.wpColorPicker( 'defaultColor', wr_colorScheme[value].colors['wr_heading_color'] );

					api( 'wr_c_footer_bg_color' ).set( wr_colorScheme[value].colors['wr_footer_bg_color'] );
					api.control( 'wr_c_footer_bg_color' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', wr_colorScheme[value].colors['wr_footer_bg_color'] )
						.wpColorPicker( 'defaultColor', wr_colorScheme[value].colors['wr_footer_bg_color'] );

				} );

			}

		}
	} );


} )( wp.customize );
