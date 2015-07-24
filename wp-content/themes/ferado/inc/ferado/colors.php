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
function wr_ferado_color_schemes_output() {
	// Get color schemes option
	$color               = wr_ferado_theme_option( 'wr_color_schemes' );
	$body_color          = wr_ferado_theme_option( 'wr_c_body_color' );
	$body_bg_color       = wr_ferado_theme_option( 'wr_c_body_bg_color' );
	$page_title_color    = wr_ferado_theme_option( 'wr_c_page_title_color' );
	$page_title_bg_color = wr_ferado_theme_option( 'wr_c_page_title_bg_color' );
	$page_title_bg_image = wr_ferado_theme_option( 'wr_page_title_image' );
	$page_title_repeat   = wr_ferado_theme_option( 'wr_page_title_bg_repeat' );
	$page_title_position = wr_ferado_theme_option( 'wr_page_title_bg_position' );
	$page_title_attach   = wr_ferado_theme_option( 'wr_page_title_bg_attachment' );
	$page_title_align    = wr_ferado_theme_option( 'wr_page_title_alignment' );
	$main_menu_color     = wr_ferado_theme_option( 'wr_c_main_menu_color' );
	$heading_color       = wr_ferado_theme_option( 'wr_c_heading_color' );
	$footer_bg_color     = wr_ferado_theme_option( 'wr_c_footer_bg_color' );

	if ( 'brown' == $color ) : ?>

		<style>
			a,
			#menu-main li .sub-menu li a:hover,
			.entry-title a:hover,
			.entry-meta a:hover,
			.more-link,
			.counter-wrap:hover,
			.widget a,
			.widget ul li a:hover,
			.site-footer .widget a:hover,
			.post-list .entry-title a:hover,
			.post-list .entry-meta a:hover,
			.post-list.style-2 .entry-title a:hover,
			.post-list.style-2 .entry-meta a,
			.post-list.style-3 .right .post:hover .entry-title a,
			.post-list.style-3 .right .post:hover .entry-meta,
			.bx-controls-direction a i,
			.jsn-bootstrap3 a,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a i,
			.jsn-bootstrap3 .wr-element-accordion.no-bg .panel-title a:hover,
			.shop-cart .shop-item ul.product_list_widget li span,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce #content div.product p.price,
			.woocommerce #content div.product span.price,
			.woocommerce div.product p.price,
			.woocommerce div.product span.price,
			.woocommerce-page #content div.product p.price,
			.woocommerce-page #content div.product span.price,
			.woocommerce-page div.product p.price,
			.woocommerce-page div.product span.price,
			.widget.woocommerce ul li:hover:before,
			.widget.woocommerce ul li li:hover:before,
			.widget.woocommerce ins .amount,
			.woocommerce #content table.cart .product-name a:hover,
			.woocommerce table.cart .product-name a:hover,
			.woocommerce-page #content table.cart .product-name a:hover,
			.woocommerce-page table.cart .product-name a:hover,
			.woocommerce .cart-collaterals .cart_totals table td .amount,
			.woocommerce-page .cart-collaterals .cart_totals table td .amount,
			.error-404 h1,
			.site-header.version-2 .header-top .top-info,
			.site-header.version-2 #menu-main li .sub-menu li a:hover,
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a,
			.site-header.version-2 .search-form button,
			.site-header.version-2 .shop-cart .cart-control,
			.post-list.style-3 .right .entry-title a.active,
			.page-title h1 {
				color: #786d5b;
			}
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-header .wr-prtbl-title,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-footer .btn {
				background-color: #786d5b !important;
			}
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			#menu-top > li > a:hover,
			.entry-thumb .posted-on,
			.widget .tagcloud a,
			.site-footer .top,
			.site-footer .widget ul li:hover:before,
			.back-to-top i:hover,
			.bx-controls-direction a i:hover,
			.page-numbers li span.current,
			.page-numbers li a:hover,
			.page-numbers li a.prev,
			.page-numbers li a.next,
			.comments-area .action-link a:hover,
			.comment-respond .comment-form .form-submit input[type="submit"],
			.post-list.style-3 .more-link,
			.blog-masonry .hentry .more-link:hover,
			.widget #wp-calendar caption,
			.counter-wrap:hover .icon,
			.counter-wrap.circle:hover .icon,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:before,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:after,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.left,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.right,
			.jsn-bootstrap3 .wr-element-testimonial .carousel.wr-testimonial ol.carousel-indicators li.active,
			.jsn-bootstrap3 .wr-element-heading.h-center,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-progressbar.mini.left-info .progress-bar-danger .sr-only,
			.jsn-bootstrap3 .wr-element-accordion.no-bg.has-icon .wr-icon-accordion:before,
			.shop-cart .shop-item .buttons .button,
			.style-switch a.active,
			.woocommerce ul.products li.product .p-info:before,
			.woocommerce-page ul.products li.product .p-info:before,
			.woocommerce ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce ul.products li.product .onsale,
			.woocommerce-page ul.products li.product .onsale,
			.woocommerce span.onsale,
			.woocommerce-page span.onsale,
			.woocommerce span.free-badge,
			.woocommerce-page span.free-badge,
			.woocommerce #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce #content nav.woocommerce-pagination ul li span.current,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
			.woocommerce-page nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page nav.woocommerce-pagination ul li span.current,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div,
			.summary .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
			.single-share .social li a:hover,
			.woocommerce #content .quantity .minus:hover,
			.woocommerce #content .quantity .plus:hover,
			.woocommerce .quantity .minus:hover,
			.woocommerce .quantity .plus:hover,
			.woocommerce-page #content .quantity .minus:hover,
			.woocommerce-page #content .quantity .plus:hover,
			.woocommerce-page .quantity .minus:hover,
			.woocommerce-page .quantity .plus:hover,
			.woocommerce #content input.button.alt,
			.woocommerce #respond input#submit.alt,
			.woocommerce a.button.alt,
			.woocommerce button.button.alt,
			.woocommerce input.button.alt,
			.woocommerce-page #content input.button.alt,
			.woocommerce-page #respond input#submit.alt,
			.woocommerce-page a.button.alt,
			.woocommerce-page button.button.alt,
			.woocommerce-page input.button.alt,
			.woocommerce #content input.button,
			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button,
			.woocommerce-page #content input.button,
			.woocommerce-page #respond input#submit,
			.woocommerce-page a.button,
			.woocommerce-page button.button,
			.woocommerce-page input.button,
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-slider-range,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button,
			.woocommerce #content table.cart a.remove:hover,
			.woocommerce table.cart a.remove:hover,
			.woocommerce-page #content table.cart a.remove:hover,
			.woocommerce-page table.cart a.remove:hover,
			.woocommerce.product-slider .owl-theme .owl-controls .owl-buttons > div:hover,
			.error-404 h1 span,
			.error-404 input.search-submit,
			.page-offline footer .social li a,
			.site-header.version-2 #menu-top > li > a:hover {
				background: #786d5b;
			}
			.header-bot {
				background-color: #786d5b;	
			}
			#menu-main > li.current-menu-item > a {
				background-image: -moz-linear-gradient(bottom, #786d5b 0%, #6c6251 100%); /* gradient overlay */
				background-image: -o-linear-gradient(bottom, #786d5b 0%, #6c6251 100%); /* gradient overlay */
				background-image: -webkit-linear-gradient(bottom, #786d5b 0%, #6c6251 100%); /* gradient overlay */
				background-image: linear-gradient(bottom, #786d5b 0%, #6c6251 100%); /* gradient overlay */
			}
			blockquote,
			address,
			q,
			.comment-respond .comment-form [class*="comment-form"] input:focus,
			.comment-respond .comment-form .comment-form-comment textarea:focus,
			.widget input:focus,
			.error-404 input.search-field:focus,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:focus,
			.jsn-bootstrap3 .wr-element-tab .tabs-below .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-left .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-right .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab.color .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li.active > a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li a:hover,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li.chosen a,
			.site-header.version-2 .header-top {
				border-color: #786d5b;
			}
			.site .jsn-master .jsn-bootstrap .jsn-form-content input:focus,
			.site .jsn-master .jsn-bootstrap .jsn-form-content textarea:focus {
				border-color: #786d5b !important;
			}
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a {
				border-top-color: #786d5b;
			}
			.counter-wrap .icon:before,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:before {
				border-bottom: 4px solid #786d5b;
				border-top: 4px solid #786d5b;
			}
			.counter-wrap .icon:after,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:after {
				border-left: 4px solid #786d5b;
				border-right: 4px solid #786d5b;
			}
			.counter-wrap.circle:hover .icon {
				-webkit-box-shadow: 0 0 0 4px #fff inset, 0 0 0 2px #786d5b;
				-moz-box-shadow:    0 0 0 4px #fff inset, 0 0 0 2px #786d5b;
				-ms-box-shadow:     0 0 0 4px #fff inset, 0 0 0 2px #786d5b;
				box-shadow:         0 0 0 4px #fff inset, 0 0 0 2px #786d5b;
			}
			.jsn-bootstrap3 .wr-element-testimonial.quotes-top .wr-testimonial-box,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a {
				border-left: 2px solid #786d5b;
			}
			.jsn-bootstrap3 .wr-element-list.iconbg .wr-list-icons.wr-shape-circle li:hover .wr-icon-base {
				-webkit-box-shadow: 0 0 0 3px #fff inset, 0 0 0 3px #786d5b;
				-moz-box-shadow:    0 0 0 3px #fff inset, 0 0 0 3px #786d5b;
				-ms-box-shadow:     0 0 0 3px #fff inset, 0 0 0 3px #786d5b;
				box-shadow:         0 0 0 3px #fff inset, 0 0 0 3px #786d5b;
			}
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-state-default {
				border: 1px solid #786d5b;
			}
			.site-branding .site-description,
			#menu-main li a,
			.site-footer .top .social li a:hover,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i {
				color: #5c513f;
			}
			.search-box > .wr-icon-search:hover,
			.search-box .search-form button:hover,
			.page-numbers li a.prev:hover,
			.page-numbers li a.next:hover,
			.widget .tagcloud a:hover,
			.site-footer .top .social li a,
			.breadcrumbs li.current,
			.breadcrumbs li a,
			.post-list.style-3 .more-link:hover,
			.shop-cart .cart-control span,
			.shop-cart .shop-item .buttons .button:hover,
			.style-switch a:hover,
			.woocommerce ul.products li.product .p-info .p-cart a.button:hover,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:hover,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div:hover,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.jsn-bootstrap3 .wr-element-heading.h-center:before,
			.jsn-bootstrap3 .wr-element-heading.h-center:after,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:before,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:after,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.page-offline footer .social li a,
			.error-404 input.search-submit {
				background: #5c513f;
			}
		</style>

	<?php elseif ( 'yellow' == $color ) : ?>

		<style>
			a,
			#menu-main li .sub-menu li a:hover,
			.entry-title a:hover,
			.entry-meta a:hover,
			.more-link,
			.counter-wrap:hover,
			.widget a,
			.widget ul li a:hover,
			.site-footer .widget a:hover,
			.post-list .entry-title a:hover,
			.post-list .entry-meta a:hover,
			.post-list.style-2 .entry-title a:hover,
			.post-list.style-2 .entry-meta a,
			.post-list.style-3 .right .post:hover .entry-title a,
			.post-list.style-3 .right .post:hover .entry-meta,
			.bx-controls-direction a i,
			.jsn-bootstrap3 a,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a i,
			.jsn-bootstrap3 .wr-element-accordion.no-bg .panel-title a:hover,
			.shop-cart .shop-item ul.product_list_widget li span,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce #content div.product p.price,
			.woocommerce #content div.product span.price,
			.woocommerce div.product p.price,
			.woocommerce div.product span.price,
			.woocommerce-page #content div.product p.price,
			.woocommerce-page #content div.product span.price,
			.woocommerce-page div.product p.price,
			.woocommerce-page div.product span.price,
			.widget.woocommerce ul li:hover:before,
			.widget.woocommerce ul li li:hover:before,
			.widget.woocommerce ins .amount,
			.woocommerce #content table.cart .product-name a:hover,
			.woocommerce table.cart .product-name a:hover,
			.woocommerce-page #content table.cart .product-name a:hover,
			.woocommerce-page table.cart .product-name a:hover,
			.woocommerce .cart-collaterals .cart_totals table td .amount,
			.woocommerce-page .cart-collaterals .cart_totals table td .amount,
			.error-404 h1,
			.site-header.version-2 .header-top .top-info,
			.site-header.version-2 #menu-main li .sub-menu li a:hover,
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a,
			.site-header.version-2 .search-form button,
			.site-header.version-2 .shop-cart .cart-control,
			.post-list.style-3 .right .entry-title a.active,
			.page-title h1 {
				color: #c99542;
			}
			.bg-red,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-header .wr-prtbl-title,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-footer .btn {
				background-color: #c99542 !important;
			}
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			#menu-top > li > a:hover,
			.entry-thumb .posted-on,
			.widget .tagcloud a,
			.site-footer .top,
			.site-footer .widget ul li:hover:before,
			.back-to-top i:hover,
			.bx-controls-direction a i:hover,
			.page-numbers li span.current,
			.page-numbers li a:hover,
			.page-numbers li a.prev,
			.page-numbers li a.next,
			.comments-area .action-link a:hover,
			.comment-respond .comment-form .form-submit input[type="submit"],
			.post-list.style-3 .more-link,
			.blog-masonry .hentry .more-link:hover,
			.widget #wp-calendar caption,
			.counter-wrap:hover .icon,
			.counter-wrap.circle:hover .icon,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:before,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:after,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.left,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.right,
			.jsn-bootstrap3 .wr-element-testimonial .carousel.wr-testimonial ol.carousel-indicators li.active,
			.jsn-bootstrap3 .wr-element-heading.h-center,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-progressbar.mini.left-info .progress-bar-danger .sr-only,
			.jsn-bootstrap3 .wr-element-accordion.no-bg.has-icon .wr-icon-accordion:before,
			.shop-cart .shop-item .buttons .button,
			.style-switch a.active,
			.woocommerce ul.products li.product .p-info:before,
			.woocommerce-page ul.products li.product .p-info:before,
			.woocommerce ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce ul.products li.product .onsale,
			.woocommerce-page ul.products li.product .onsale,
			.woocommerce span.onsale,
			.woocommerce-page span.onsale,
			.woocommerce span.free-badge,
			.woocommerce-page span.free-badge,
			.woocommerce #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce #content nav.woocommerce-pagination ul li span.current,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
			.woocommerce-page nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page nav.woocommerce-pagination ul li span.current,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div,
			.summary .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
			.single-share .social li a:hover,
			.woocommerce #content .quantity .minus:hover,
			.woocommerce #content .quantity .plus:hover,
			.woocommerce .quantity .minus:hover,
			.woocommerce .quantity .plus:hover,
			.woocommerce-page #content .quantity .minus:hover,
			.woocommerce-page #content .quantity .plus:hover,
			.woocommerce-page .quantity .minus:hover,
			.woocommerce-page .quantity .plus:hover,
			.woocommerce #content input.button.alt,
			.woocommerce #respond input#submit.alt,
			.woocommerce a.button.alt,
			.woocommerce button.button.alt,
			.woocommerce input.button.alt,
			.woocommerce-page #content input.button.alt,
			.woocommerce-page #respond input#submit.alt,
			.woocommerce-page a.button.alt,
			.woocommerce-page button.button.alt,
			.woocommerce-page input.button.alt,
			.woocommerce #content input.button,
			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button,
			.woocommerce-page #content input.button,
			.woocommerce-page #respond input#submit,
			.woocommerce-page a.button,
			.woocommerce-page button.button,
			.woocommerce-page input.button,
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-slider-range,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button,
			.woocommerce #content table.cart a.remove:hover,
			.woocommerce table.cart a.remove:hover,
			.woocommerce-page #content table.cart a.remove:hover,
			.woocommerce-page table.cart a.remove:hover,
			.woocommerce.product-slider .owl-theme .owl-controls .owl-buttons > div:hover,
			.error-404 h1 span,
			.error-404 input.search-submit,
			.page-offline footer .social li a,
			.site-header.version-2 #menu-top > li > a:hover {
				background: #c99542;
			}
			.header-bot {
				background-color: #c99542;	
			}
			#menu-main > li.current-menu-item > a {
				background-image: -moz-linear-gradient(bottom, #c99542 0%, #ba8635 100%); /* gradient overlay */
				background-image: -o-linear-gradient(bottom, #c99542 0%, #ba8635 100%); /* gradient overlay */
				background-image: -webkit-linear-gradient(bottom, #c99542 0%, #ba8635 100%); /* gradient overlay */
				background-image: linear-gradient(bottom, #c99542 0%, #ba8635 100%); /* gradient overlay */
			}
			blockquote,
			address,
			q,
			.comment-respond .comment-form [class*="comment-form"] input:focus,
			.comment-respond .comment-form .comment-form-comment textarea:focus,
			.widget input:focus,
			.error-404 input.search-field:focus,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:focus,
			.jsn-bootstrap3 .wr-element-tab .tabs-below .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-left .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-right .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab.color .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li.active > a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li a:hover,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li.chosen a,
			.site-header.version-2 .header-top {
				border-color: #c99542;
			}
			.site .jsn-master .jsn-bootstrap .jsn-form-content input:focus,
			.site .jsn-master .jsn-bootstrap .jsn-form-content textarea:focus {
				border-color: #c99542 !important;
			}
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a {
				border-top-color: #c99542;
			}
			.counter-wrap .icon:before,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:before {
				border-bottom: 4px solid #c99542;
				border-top: 4px solid #c99542;
			}
			.counter-wrap .icon:after,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:after {
				border-left: 4px solid #c99542;
				border-right: 4px solid #c99542;
			}
			.counter-wrap.circle:hover .icon {
				-webkit-box-shadow: 0 0 0 4px #fff inset, 0 0 0 2px #c99542;
				-moz-box-shadow:    0 0 0 4px #fff inset, 0 0 0 2px #c99542;
				-ms-box-shadow:     0 0 0 4px #fff inset, 0 0 0 2px #c99542;
				box-shadow:         0 0 0 4px #fff inset, 0 0 0 2px #c99542;
			}
			.jsn-bootstrap3 .wr-element-testimonial.quotes-top .wr-testimonial-box,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a {
				border-left: 2px solid #c99542;
			}
			.jsn-bootstrap3 .wr-element-list.iconbg .wr-list-icons.wr-shape-circle li:hover .wr-icon-base {
				-webkit-box-shadow: 0 0 0 3px #fff inset, 0 0 0 3px #c99542;
				-moz-box-shadow:    0 0 0 3px #fff inset, 0 0 0 3px #c99542;
				-ms-box-shadow:     0 0 0 3px #fff inset, 0 0 0 3px #c99542;
				box-shadow:         0 0 0 3px #fff inset, 0 0 0 3px #c99542;
			}
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-state-default {
				border: 1px solid #c99542;
			}
			.site-branding .site-description,
			#menu-main li a,
			.site-footer .top .social li a:hover,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i {
				color: #ab7724;
			}
			.search-box > .wr-icon-search:hover,
			.search-box .search-form button:hover,
			.page-numbers li a.prev:hover,
			.page-numbers li a.next:hover,
			.widget .tagcloud a:hover,
			.site-footer .top .social li a,
			.breadcrumbs li.current,
			.breadcrumbs li a,
			.post-list.style-3 .more-link:hover,
			.shop-cart .cart-control span,
			.shop-cart .shop-item .buttons .button:hover,
			.style-switch a:hover,
			.woocommerce ul.products li.product .p-info .p-cart a.button:hover,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:hover,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div:hover,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.jsn-bootstrap3 .wr-element-heading.h-center:before,
			.jsn-bootstrap3 .wr-element-heading.h-center:after,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:before,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:after,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.page-offline footer .social li a,
			.error-404 input.search-submit {
				background: #ab7724;
			}
		</style>

	<?php elseif ( 'blue' == $color ) : ?>

		<style>
			a,
			#menu-main li .sub-menu li a:hover,
			.entry-title a:hover,
			.entry-meta a:hover,
			.more-link,
			.counter-wrap:hover,
			.widget a,
			.widget ul li a:hover,
			.site-footer .widget a:hover,
			.post-list .entry-title a:hover,
			.post-list .entry-meta a:hover,
			.post-list.style-2 .entry-title a:hover,
			.post-list.style-2 .entry-meta a,
			.post-list.style-3 .right .post:hover .entry-title a,
			.post-list.style-3 .right .post:hover .entry-meta,
			.bx-controls-direction a i,
			.jsn-bootstrap3 a,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a i,
			.jsn-bootstrap3 .wr-element-accordion.no-bg .panel-title a:hover,
			.shop-cart .shop-item ul.product_list_widget li span,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce #content div.product p.price,
			.woocommerce #content div.product span.price,
			.woocommerce div.product p.price,
			.woocommerce div.product span.price,
			.woocommerce-page #content div.product p.price,
			.woocommerce-page #content div.product span.price,
			.woocommerce-page div.product p.price,
			.woocommerce-page div.product span.price,
			.widget.woocommerce ul li:hover:before,
			.widget.woocommerce ul li li:hover:before,
			.widget.woocommerce ins .amount,
			.woocommerce #content table.cart .product-name a:hover,
			.woocommerce table.cart .product-name a:hover,
			.woocommerce-page #content table.cart .product-name a:hover,
			.woocommerce-page table.cart .product-name a:hover,
			.woocommerce .cart-collaterals .cart_totals table td .amount,
			.woocommerce-page .cart-collaterals .cart_totals table td .amount,
			.error-404 h1,
			.site-header.version-2 .header-top .top-info,
			.site-header.version-2 #menu-main li .sub-menu li a:hover,
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a,
			.site-header.version-2 .search-form button,
			.site-header.version-2 .shop-cart .cart-control,
			.post-list.style-3 .right .entry-title a.active,
			.page-title h1 {
				color: #68a8aa;
			}
			.bg-red,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-header .wr-prtbl-title,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-footer .btn {
				background-color: #68a8aa !important;
			}
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			#menu-top > li > a:hover,
			.entry-thumb .posted-on,
			.widget .tagcloud a,
			.site-footer .top,
			.site-footer .widget ul li:hover:before,
			.back-to-top i:hover,
			.bx-controls-direction a i:hover,
			.page-numbers li span.current,
			.page-numbers li a:hover,
			.page-numbers li a.prev,
			.page-numbers li a.next,
			.comments-area .action-link a:hover,
			.comment-respond .comment-form .form-submit input[type="submit"],
			.post-list.style-3 .more-link,
			.blog-masonry .hentry .more-link:hover,
			.widget #wp-calendar caption,
			.counter-wrap:hover .icon,
			.counter-wrap.circle:hover .icon,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:before,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:after,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.left,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.right,
			.jsn-bootstrap3 .wr-element-testimonial .carousel.wr-testimonial ol.carousel-indicators li.active,
			.jsn-bootstrap3 .wr-element-heading.h-center,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-progressbar.mini.left-info .progress-bar-danger .sr-only,
			.jsn-bootstrap3 .wr-element-accordion.no-bg.has-icon .wr-icon-accordion:before,
			.shop-cart .shop-item .buttons .button,
			.style-switch a.active,
			.woocommerce ul.products li.product .p-info:before,
			.woocommerce-page ul.products li.product .p-info:before,
			.woocommerce ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce ul.products li.product .onsale,
			.woocommerce-page ul.products li.product .onsale,
			.woocommerce span.onsale,
			.woocommerce-page span.onsale,
			.woocommerce span.free-badge,
			.woocommerce-page span.free-badge,
			.woocommerce #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce #content nav.woocommerce-pagination ul li span.current,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
			.woocommerce-page nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page nav.woocommerce-pagination ul li span.current,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div,
			.summary .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
			.single-share .social li a:hover,
			.woocommerce #content .quantity .minus:hover,
			.woocommerce #content .quantity .plus:hover,
			.woocommerce .quantity .minus:hover,
			.woocommerce .quantity .plus:hover,
			.woocommerce-page #content .quantity .minus:hover,
			.woocommerce-page #content .quantity .plus:hover,
			.woocommerce-page .quantity .minus:hover,
			.woocommerce-page .quantity .plus:hover,
			.woocommerce #content input.button.alt,
			.woocommerce #respond input#submit.alt,
			.woocommerce a.button.alt,
			.woocommerce button.button.alt,
			.woocommerce input.button.alt,
			.woocommerce-page #content input.button.alt,
			.woocommerce-page #respond input#submit.alt,
			.woocommerce-page a.button.alt,
			.woocommerce-page button.button.alt,
			.woocommerce-page input.button.alt,
			.woocommerce #content input.button,
			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button,
			.woocommerce-page #content input.button,
			.woocommerce-page #respond input#submit,
			.woocommerce-page a.button,
			.woocommerce-page button.button,
			.woocommerce-page input.button,
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-slider-range,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button,
			.woocommerce #content table.cart a.remove:hover,
			.woocommerce table.cart a.remove:hover,
			.woocommerce-page #content table.cart a.remove:hover,
			.woocommerce-page table.cart a.remove:hover,
			.woocommerce.product-slider .owl-theme .owl-controls .owl-buttons > div:hover,
			.error-404 h1 span,
			.error-404 input.search-submit,
			.page-offline footer .social li a,
			.site-header.version-2 #menu-top > li > a:hover {
				background: #68a8aa;
			}
			.header-bot {
				background-color: #68a8aa;	
			}
			#menu-main > li.current-menu-item > a {
				background-image: -moz-linear-gradient(bottom, #68a8aa 0%, #347c7e 100%); /* gradient overlay */
				background-image: -o-linear-gradient(bottom, #68a8aa 0%, #347c7e 100%); /* gradient overlay */
				background-image: -webkit-linear-gradient(bottom, #68a8aa 0%, #347c7e 100%); /* gradient overlay */
				background-image: linear-gradient(bottom, #68a8aa 0%, #347c7e 100%); /* gradient overlay */
			}
			blockquote,
			address,
			q,
			.comment-respond .comment-form [class*="comment-form"] input:focus,
			.comment-respond .comment-form .comment-form-comment textarea:focus,
			.widget input:focus,
			.error-404 input.search-field:focus,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:focus,
			.jsn-bootstrap3 .wr-element-tab .tabs-below .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-left .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-right .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab.color .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li.active > a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li a:hover,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li.chosen a,
			.site-header.version-2 .header-top {
				border-color: #68a8aa;
			}
			.site .jsn-master .jsn-bootstrap .jsn-form-content input:focus,
			.site .jsn-master .jsn-bootstrap .jsn-form-content textarea:focus {
				border-color: #68a8aa !important;
			}
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a {
				border-top-color: #68a8aa;
			}
			.counter-wrap .icon:before,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:before {
				border-bottom: 4px solid #68a8aa;
				border-top: 4px solid #68a8aa;
			}
			.counter-wrap .icon:after,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:after {
				border-left: 4px solid #68a8aa;
				border-right: 4px solid #68a8aa;
			}
			.counter-wrap.circle:hover .icon {
				-webkit-box-shadow: 0 0 0 4px #fff inset, 0 0 0 2px #68a8aa;
				-moz-box-shadow:    0 0 0 4px #fff inset, 0 0 0 2px #68a8aa;
				-ms-box-shadow:     0 0 0 4px #fff inset, 0 0 0 2px #68a8aa;
				box-shadow:         0 0 0 4px #fff inset, 0 0 0 2px #68a8aa;
			}
			.jsn-bootstrap3 .wr-element-testimonial.quotes-top .wr-testimonial-box,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a {
				border-left: 2px solid #68a8aa;
			}
			.jsn-bootstrap3 .wr-element-list.iconbg .wr-list-icons.wr-shape-circle li:hover .wr-icon-base {
				-webkit-box-shadow: 0 0 0 3px #fff inset, 0 0 0 3px #68a8aa;
				-moz-box-shadow:    0 0 0 3px #fff inset, 0 0 0 3px #68a8aa;
				-ms-box-shadow:     0 0 0 3px #fff inset, 0 0 0 3px #68a8aa;
				box-shadow:         0 0 0 3px #fff inset, 0 0 0 3px #68a8aa;
			}
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-state-default {
				border: 1px solid #68a8aa;
			}
			.site-branding .site-description,
			#menu-main li a,
			.site-footer .top .social li a:hover,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i {
				color: #4d8d8f;
			}
			.search-box > .wr-icon-search:hover,
			.search-box .search-form button:hover,
			.page-numbers li a.prev:hover,
			.page-numbers li a.next:hover,
			.widget .tagcloud a:hover,
			.site-footer .top .social li a,
			.breadcrumbs li.current,
			.breadcrumbs li a,
			.post-list.style-3 .more-link:hover,
			.shop-cart .cart-control span,
			.shop-cart .shop-item .buttons .button:hover,
			.style-switch a:hover,
			.woocommerce ul.products li.product .p-info .p-cart a.button:hover,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:hover,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div:hover,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.jsn-bootstrap3 .wr-element-heading.h-center:before,
			.jsn-bootstrap3 .wr-element-heading.h-center:after,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:before,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:after,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.page-offline footer .social li a,
			.error-404 input.search-submit {
				background: #4d8d8f;
			}
		</style>

	<?php elseif ( 'green' == $color ) : ?>

		<style>
			a,
			#menu-main li .sub-menu li a:hover,
			.entry-title a:hover,
			.entry-meta a:hover,
			.more-link,
			.counter-wrap:hover,
			.widget a,
			.widget ul li a:hover,
			.site-footer .widget a:hover,
			.post-list .entry-title a:hover,
			.post-list .entry-meta a:hover,
			.post-list.style-2 .entry-title a:hover,
			.post-list.style-2 .entry-meta a,
			.post-list.style-3 .right .post:hover .entry-title a,
			.post-list.style-3 .right .post:hover .entry-meta,
			.bx-controls-direction a i,
			.jsn-bootstrap3 a,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a i,
			.jsn-bootstrap3 .wr-element-accordion.no-bg .panel-title a:hover,
			.shop-cart .shop-item ul.product_list_widget li span,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce #content div.product p.price,
			.woocommerce #content div.product span.price,
			.woocommerce div.product p.price,
			.woocommerce div.product span.price,
			.woocommerce-page #content div.product p.price,
			.woocommerce-page #content div.product span.price,
			.woocommerce-page div.product p.price,
			.woocommerce-page div.product span.price,
			.widget.woocommerce ul li:hover:before,
			.widget.woocommerce ul li li:hover:before,
			.widget.woocommerce ins .amount,
			.woocommerce #content table.cart .product-name a:hover,
			.woocommerce table.cart .product-name a:hover,
			.woocommerce-page #content table.cart .product-name a:hover,
			.woocommerce-page table.cart .product-name a:hover,
			.woocommerce .cart-collaterals .cart_totals table td .amount,
			.woocommerce-page .cart-collaterals .cart_totals table td .amount,
			.error-404 h1,
			.site-header.version-2 .header-top .top-info,
			.site-header.version-2 #menu-main li .sub-menu li a:hover,
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a,
			.site-header.version-2 .search-form button,
			.site-header.version-2 .shop-cart .cart-control,
			.post-list.style-3 .right .entry-title a.active,
			.page-title h1 {
				color: #68aa71;
			}
			.bg-red,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-header .wr-prtbl-title,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-footer .btn {
				background-color: #68aa71 !important;
			}
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			#menu-top > li > a:hover,
			.entry-thumb .posted-on,
			.widget .tagcloud a,
			.site-footer .top,
			.site-footer .widget ul li:hover:before,
			.back-to-top i:hover,
			.bx-controls-direction a i:hover,
			.page-numbers li span.current,
			.page-numbers li a:hover,
			.page-numbers li a.prev,
			.page-numbers li a.next,
			.comments-area .action-link a:hover,
			.comment-respond .comment-form .form-submit input[type="submit"],
			.post-list.style-3 .more-link,
			.blog-masonry .hentry .more-link:hover,
			.widget #wp-calendar caption,
			.counter-wrap:hover .icon,
			.counter-wrap.circle:hover .icon,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:before,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:after,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.left,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.right,
			.jsn-bootstrap3 .wr-element-testimonial .carousel.wr-testimonial ol.carousel-indicators li.active,
			.jsn-bootstrap3 .wr-element-heading.h-center,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-progressbar.mini.left-info .progress-bar-danger .sr-only,
			.jsn-bootstrap3 .wr-element-accordion.no-bg.has-icon .wr-icon-accordion:before,
			.shop-cart .shop-item .buttons .button,
			.style-switch a.active,
			.woocommerce ul.products li.product .p-info:before,
			.woocommerce-page ul.products li.product .p-info:before,
			.woocommerce ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce ul.products li.product .onsale,
			.woocommerce-page ul.products li.product .onsale,
			.woocommerce span.onsale,
			.woocommerce-page span.onsale,
			.woocommerce span.free-badge,
			.woocommerce-page span.free-badge,
			.woocommerce #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce #content nav.woocommerce-pagination ul li span.current,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
			.woocommerce-page nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page nav.woocommerce-pagination ul li span.current,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div,
			.summary .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
			.single-share .social li a:hover,
			.woocommerce #content .quantity .minus:hover,
			.woocommerce #content .quantity .plus:hover,
			.woocommerce .quantity .minus:hover,
			.woocommerce .quantity .plus:hover,
			.woocommerce-page #content .quantity .minus:hover,
			.woocommerce-page #content .quantity .plus:hover,
			.woocommerce-page .quantity .minus:hover,
			.woocommerce-page .quantity .plus:hover,
			.woocommerce #content input.button.alt,
			.woocommerce #respond input#submit.alt,
			.woocommerce a.button.alt,
			.woocommerce button.button.alt,
			.woocommerce input.button.alt,
			.woocommerce-page #content input.button.alt,
			.woocommerce-page #respond input#submit.alt,
			.woocommerce-page a.button.alt,
			.woocommerce-page button.button.alt,
			.woocommerce-page input.button.alt,
			.woocommerce #content input.button,
			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button,
			.woocommerce-page #content input.button,
			.woocommerce-page #respond input#submit,
			.woocommerce-page a.button,
			.woocommerce-page button.button,
			.woocommerce-page input.button,
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-slider-range,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button,
			.woocommerce #content table.cart a.remove:hover,
			.woocommerce table.cart a.remove:hover,
			.woocommerce-page #content table.cart a.remove:hover,
			.woocommerce-page table.cart a.remove:hover,
			.woocommerce.product-slider .owl-theme .owl-controls .owl-buttons > div:hover,
			.error-404 h1 span,
			.error-404 input.search-submit,
			.page-offline footer .social li a,
			.site-header.version-2 #menu-top > li > a:hover {
				background: #68aa71;
			}
			.header-bot {
				background-color: #68aa71;	
			}
			#menu-main > li.current-menu-item > a {
				background-image: -moz-linear-gradient(bottom, #68aa71 0%, #3b9146 100%); /* gradient overlay */
				background-image: -o-linear-gradient(bottom, #68aa71 0%, #3b9146 100%); /* gradient overlay */
				background-image: -webkit-linear-gradient(bottom, #68aa71 0%, #3b9146 100%); /* gradient overlay */
				background-image: linear-gradient(bottom, #68aa71 0%, #3b9146 100%); /* gradient overlay */
			}
			blockquote,
			address,
			q,
			.comment-respond .comment-form [class*="comment-form"] input:focus,
			.comment-respond .comment-form .comment-form-comment textarea:focus,
			.widget input:focus,
			.error-404 input.search-field:focus,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:focus,
			.jsn-bootstrap3 .wr-element-tab .tabs-below .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-left .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-right .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab.color .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li.active > a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li a:hover,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li.chosen a,
			.site-header.version-2 .header-top {
				border-color: #68aa71;
			}
			.site .jsn-master .jsn-bootstrap .jsn-form-content input:focus,
			.site .jsn-master .jsn-bootstrap .jsn-form-content textarea:focus {
				border-color: #68aa71 !important;
			}
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a {
				border-top-color: #68aa71;
			}
			.counter-wrap .icon:before,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:before {
				border-bottom: 4px solid #68aa71;
				border-top: 4px solid #68aa71;
			}
			.counter-wrap .icon:after,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:after {
				border-left: 4px solid #68aa71;
				border-right: 4px solid #68aa71;
			}
			.counter-wrap.circle:hover .icon {
				-webkit-box-shadow: 0 0 0 4px #fff inset, 0 0 0 2px #68aa71;
				-moz-box-shadow:    0 0 0 4px #fff inset, 0 0 0 2px #68aa71;
				-ms-box-shadow:     0 0 0 4px #fff inset, 0 0 0 2px #68aa71;
				box-shadow:         0 0 0 4px #fff inset, 0 0 0 2px #68aa71;
			}
			.jsn-bootstrap3 .wr-element-testimonial.quotes-top .wr-testimonial-box,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a {
				border-left: 2px solid #68aa71;
			}
			.jsn-bootstrap3 .wr-element-list.iconbg .wr-list-icons.wr-shape-circle li:hover .wr-icon-base {
				-webkit-box-shadow: 0 0 0 3px #fff inset, 0 0 0 3px #68aa71;
				-moz-box-shadow:    0 0 0 3px #fff inset, 0 0 0 3px #68aa71;
				-ms-box-shadow:     0 0 0 3px #fff inset, 0 0 0 3px #68aa71;
				box-shadow:         0 0 0 3px #fff inset, 0 0 0 3px #68aa71;
			}
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-state-default {
				border: 1px solid #68aa71;
			}
			.site-branding .site-description,
			#menu-main li a,
			.site-footer .top .social li a:hover,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i {
				color: #4a8c53;
			}
			.search-box > .wr-icon-search:hover,
			.search-box .search-form button:hover,
			.page-numbers li a.prev:hover,
			.page-numbers li a.next:hover,
			.widget .tagcloud a:hover,
			.site-footer .top .social li a,
			.breadcrumbs li.current,
			.breadcrumbs li a,
			.post-list.style-3 .more-link:hover,
			.shop-cart .cart-control span,
			.shop-cart .shop-item .buttons .button:hover,
			.style-switch a:hover,
			.woocommerce ul.products li.product .p-info .p-cart a.button:hover,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:hover,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div:hover,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.jsn-bootstrap3 .wr-element-heading.h-center:before,
			.jsn-bootstrap3 .wr-element-heading.h-center:after,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:before,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:after,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.page-offline footer .social li a,
			.error-404 input.search-submit {
				background: #4a8c53;
			}
		</style>

	<?php elseif ( 'purple' == $color ) : ?>

		<style>
			a,
			#menu-main li .sub-menu li a:hover,
			.entry-title a:hover,
			.entry-meta a:hover,
			.more-link,
			.counter-wrap:hover,
			.widget a,
			.widget ul li a:hover,
			.site-footer .widget a:hover,
			.post-list .entry-title a:hover,
			.post-list .entry-meta a:hover,
			.post-list.style-2 .entry-title a:hover,
			.post-list.style-2 .entry-meta a,
			.post-list.style-3 .right .post:hover .entry-title a,
			.post-list.style-3 .right .post:hover .entry-meta,
			.bx-controls-direction a i,
			.jsn-bootstrap3 a,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a i,
			.jsn-bootstrap3 .wr-element-accordion.no-bg .panel-title a:hover,
			.shop-cart .shop-item ul.product_list_widget li span,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist i,
			.woocommerce #content div.product p.price,
			.woocommerce #content div.product span.price,
			.woocommerce div.product p.price,
			.woocommerce div.product span.price,
			.woocommerce-page #content div.product p.price,
			.woocommerce-page #content div.product span.price,
			.woocommerce-page div.product p.price,
			.woocommerce-page div.product span.price,
			.widget.woocommerce ul li:hover:before,
			.widget.woocommerce ul li li:hover:before,
			.widget.woocommerce ins .amount,
			.woocommerce #content table.cart .product-name a:hover,
			.woocommerce table.cart .product-name a:hover,
			.woocommerce-page #content table.cart .product-name a:hover,
			.woocommerce-page table.cart .product-name a:hover,
			.woocommerce .cart-collaterals .cart_totals table td .amount,
			.woocommerce-page .cart-collaterals .cart_totals table td .amount,
			.error-404 h1,
			.site-header.version-2 .header-top .top-info,
			.site-header.version-2 #menu-main li .sub-menu li a:hover,
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a,
			.site-header.version-2 .search-form button,
			.site-header.version-2 .shop-cart .cart-control,
			.post-list.style-3 .right .entry-title a.active,
			.page-title h1 {
				color: #65759b;
			}
			.bg-red,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-header .wr-prtbl-title,
			.jsn-bootstrap3 .wr-element-pricing_table .wr-prtbl-cols.wr-prtbl-cols-featured .wr-prtbl-footer .btn {
				background-color: #65759b !important;
			}
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			#menu-top > li > a:hover,
			.entry-thumb .posted-on,
			.widget .tagcloud a,
			.site-footer .top,
			.site-footer .widget ul li:hover:before,
			.back-to-top i:hover,
			.bx-controls-direction a i:hover,
			.page-numbers li span.current,
			.page-numbers li a:hover,
			.page-numbers li a.prev,
			.page-numbers li a.next,
			.comments-area .action-link a:hover,
			.comment-respond .comment-form .form-submit input[type="submit"],
			.post-list.style-3 .more-link,
			.blog-masonry .hentry .more-link:hover,
			.widget #wp-calendar caption,
			.counter-wrap:hover .icon,
			.counter-wrap.circle:hover .icon,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:before,
			.jsn-bootstrap3 .wr-element-testimonial .wr-testimonial-meta .wr-testimonial-name:after,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.left,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control.right,
			.jsn-bootstrap3 .wr-element-testimonial .carousel.wr-testimonial ol.carousel-indicators li.active,
			.jsn-bootstrap3 .wr-element-heading.h-center,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-progressbar.mini.left-info .progress-bar-danger .sr-only,
			.jsn-bootstrap3 .wr-element-accordion.no-bg.has-icon .wr-icon-accordion:before,
			.shop-cart .shop-item .buttons .button,
			.style-switch a.active,
			.woocommerce ul.products li.product .p-info:before,
			.woocommerce-page ul.products li.product .p-info:before,
			.woocommerce ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:before,
			.woocommerce ul.products li.product .onsale,
			.woocommerce-page ul.products li.product .onsale,
			.woocommerce span.onsale,
			.woocommerce-page span.onsale,
			.woocommerce span.free-badge,
			.woocommerce-page span.free-badge,
			.woocommerce #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce #content nav.woocommerce-pagination ul li span.current,
			.woocommerce nav.woocommerce-pagination ul li a:focus,
			.woocommerce nav.woocommerce-pagination ul li a:hover,
			.woocommerce nav.woocommerce-pagination ul li span.current,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page #content nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page #content nav.woocommerce-pagination ul li span.current,
			.woocommerce-page nav.woocommerce-pagination ul li a:focus,
			.woocommerce-page nav.woocommerce-pagination ul li a:hover,
			.woocommerce-page nav.woocommerce-pagination ul li span.current,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div,
			.summary .yith-wcwl-add-to-wishlist .add_to_wishlist:hover,
			.single-share .social li a:hover,
			.woocommerce #content .quantity .minus:hover,
			.woocommerce #content .quantity .plus:hover,
			.woocommerce .quantity .minus:hover,
			.woocommerce .quantity .plus:hover,
			.woocommerce-page #content .quantity .minus:hover,
			.woocommerce-page #content .quantity .plus:hover,
			.woocommerce-page .quantity .minus:hover,
			.woocommerce-page .quantity .plus:hover,
			.woocommerce #content input.button.alt,
			.woocommerce #respond input#submit.alt,
			.woocommerce a.button.alt,
			.woocommerce button.button.alt,
			.woocommerce input.button.alt,
			.woocommerce-page #content input.button.alt,
			.woocommerce-page #respond input#submit.alt,
			.woocommerce-page a.button.alt,
			.woocommerce-page button.button.alt,
			.woocommerce-page input.button.alt,
			.woocommerce #content input.button,
			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button,
			.woocommerce-page #content input.button,
			.woocommerce-page #respond input#submit,
			.woocommerce-page a.button,
			.woocommerce-page button.button,
			.woocommerce-page input.button,
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-slider-range,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button,
			.woocommerce #content table.cart a.remove:hover,
			.woocommerce table.cart a.remove:hover,
			.woocommerce-page #content table.cart a.remove:hover,
			.woocommerce-page table.cart a.remove:hover,
			.woocommerce.product-slider .owl-theme .owl-controls .owl-buttons > div:hover,
			.error-404 h1 span,
			.error-404 input.search-submit,
			.page-offline footer .social li a,
			.site-header.version-2 #menu-top > li > a:hover {
				background: #65759b;
			}
			.header-bot {
				background-color: #65759b;	
			}
			#menu-main > li.current-menu-item > a {
				background-image: -moz-linear-gradient(bottom, #65759b 0%, #485d8f 100%); /* gradient overlay */
				background-image: -o-linear-gradient(bottom, #65759b 0%, #485d8f 100%); /* gradient overlay */
				background-image: -webkit-linear-gradient(bottom, #65759b 0%, #485d8f 100%); /* gradient overlay */
				background-image: linear-gradient(bottom, #65759b 0%, #485d8f 100%); /* gradient overlay */
			}
			blockquote,
			address,
			q,
			.comment-respond .comment-form [class*="comment-form"] input:focus,
			.comment-respond .comment-form .comment-form-comment textarea:focus,
			.widget input:focus,
			.error-404 input.search-field:focus,
			.jsn-bootstrap3 .wr-element-list.border li:hover .wr-icon-base,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:hover,
			.jsn-bootstrap3 .wr-element-tab .nav-tabs > li.active > a:focus,
			.jsn-bootstrap3 .wr-element-tab .tabs-below .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-left .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab .tabs-right .nav-tabs li.active a,
			.jsn-bootstrap3 .wr-element-tab.color .nav-tabs > li.active > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li.active > a,
			.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li a:hover,
			.woocommerce .widget.yith-woo-ajax-navigation .yith-wcan-group li.chosen a,
			.site-header.version-2 .header-top {
				border-color: #65759b;
			}
			.site .jsn-master .jsn-bootstrap .jsn-form-content input:focus,
			.site .jsn-master .jsn-bootstrap .jsn-form-content textarea:focus {
				border-color: #65759b !important;
			}
			.site-header.version-2 #menu-main > li > a:hover,
			.site-header.version-2 #menu-main > li.current-menu-item > a {
				border-top-color: #65759b;
			}
			.counter-wrap .icon:before,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:before {
				border-bottom: 4px solid #65759b;
				border-top: 4px solid #65759b;
			}
			.counter-wrap .icon:after,
			.jsn-bootstrap3 .wr-element-list.border .wr-icon-base:after {
				border-left: 4px solid #65759b;
				border-right: 4px solid #65759b;
			}
			.counter-wrap.circle:hover .icon {
				-webkit-box-shadow: 0 0 0 4px #fff inset, 0 0 0 2px #65759b;
				-moz-box-shadow:    0 0 0 4px #fff inset, 0 0 0 2px #65759b;
				-ms-box-shadow:     0 0 0 4px #fff inset, 0 0 0 2px #65759b;
				box-shadow:         0 0 0 4px #fff inset, 0 0 0 2px #65759b;
			}
			.jsn-bootstrap3 .wr-element-testimonial.quotes-top .wr-testimonial-box,
			.jsn-bootstrap3 .wr-element-accordion .panel-title a {
				border-left: 2px solid #65759b;
			}
			.jsn-bootstrap3 .wr-element-list.iconbg .wr-list-icons.wr-shape-circle li:hover .wr-icon-base {
				-webkit-box-shadow: 0 0 0 3px #fff inset, 0 0 0 3px #65759b;
				-moz-box-shadow:    0 0 0 3px #fff inset, 0 0 0 3px #65759b;
				-ms-box-shadow:     0 0 0 3px #fff inset, 0 0 0 3px #65759b;
				box-shadow:         0 0 0 3px #fff inset, 0 0 0 3px #65759b;
			}
			.woocommerce .widget_price_filter .price_slider_wrapper .ui-state-default {
				border: 1px solid #65759b;
			}
			.site-branding .site-description,
			#menu-main li a,
			.site-footer .top .social li a:hover,
			.woocommerce ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i,
			.woocommerce-page ul.products li.product .p-inner .p-image .yith-wcwl-add-to-wishlist:hover i {
				color: #49597f;
			}
			.search-box > .wr-icon-search:hover,
			.search-box .search-form button:hover,
			.page-numbers li a.prev:hover,
			.page-numbers li a.next:hover,
			.widget .tagcloud a:hover,
			.site-footer .top .social li a,
			.breadcrumbs li.current,
			.breadcrumbs li a,
			.post-list.style-3 .more-link:hover,
			.shop-cart .cart-control span,
			.shop-cart .shop-item .buttons .button:hover,
			.style-switch a:hover,
			.woocommerce ul.products li.product .p-info .p-cart a.button:hover,
			.woocommerce-page ul.products li.product .p-info .p-cart a.button:hover,
			#p-thumb.owl-theme .owl-controls .owl-buttons > div:hover,
			.woocommerce .widget_price_filter .price_slider_wrapper .price_slider_amount .button:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.jsn-bootstrap3 .wr-element-heading.h-center:before,
			.jsn-bootstrap3 .wr-element-heading.h-center:after,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:before,
			.jsn-bootstrap3 .wr-element-heading.h-center > *:after,
			.jsn-bootstrap3 .wr-element-tab.multi-color .nav-tabs > li > a:hover,
			.jsn-bootstrap3 .wr-element-testimonial .carousel-control:hover,
			.page-offline footer .social li a,
			.error-404 input.search-submit {
				background: #49597f;
			}
		</style>

	<?php endif; ?>

	<style>
		<?php if ( $body_color || $body_bg_color ) { ?>
		body {
			color: <?php echo $body_color ?>;
			background: <?php echo $body_bg_color ?>;
		}
		<?php } if ( $main_menu_color ) { ?>

			#menu-main > li > a { color: <?php echo $main_menu_color ?>; }

		<?php } if ( $heading_color ) { ?>

			h1, h2, h3, h4, h5, h6 { color: <?php echo $heading_color ?>; }

		<?php } if ( $footer_bg_color ) { ?>

			.site-footer .bot { background: <?php echo $footer_bg_color ?>; }

		<?php } if ( $page_title_color || $page_title_bg_color || $page_title_bg_image || $page_title_align ) { ?>
			.page-title {
				background-color: <?php echo $page_title_bg_color ?>;
				background-image: url(<?php echo esc_url( $page_title_bg_image ); ?>);
				background-repeat: <?php echo $page_title_repeat ?>;
				background-position: <?php echo $page_title_position ?> top;
				background-attachment: <?php echo $page_title_attach ?>;
			}
			.page-title h1 {
				color: <?php echo $page_title_color ?>;
				text-align: <?php echo $page_title_align ?>;
			}
			
		<?php } ?>
	</style>
	<?php
}
add_action( 'wp_head', 'wr_ferado_color_schemes_output', 100001 );