/**
 * @version    1.5
 * @package    Ferado
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

(function($) {
	"use strict";
	$(document).ready(function() {

		/*  [ Detecting Mobile Devices ]
		- - - - - - - - - - - - - - - - - - - - */
		var isMobile = {
			Android: function() {
				return navigator.userAgent.match(/Android/i);
			},
			BlackBerry: function() {
				return navigator.userAgent.match(/BlackBerry/i);
			},
			iOS: function() {
				return navigator.userAgent.match(/iPhone|iPad|iPod/i);
			},
			Opera: function() {
				return navigator.userAgent.match(/Opera Mini/i);
			},
			Windows: function() {
				return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
			},
			Desktop: function() {
				return window.innerWidth <= 960;
			},
			any: function() {
				return ( isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows() || isMobile.Desktop() );
			}
		};

		/*  [ Search box  ]
		- - - - - - - - - - - - - - - - - - - - */
		$( '.wr-icon-search' ).on( 'click', function() {
			$(this).parent().toggleClass('active');
		});

		/*  [ Custom RTL Menu ]
		- - - - - - - - - - - - - - - - - - - - */
		if ( ! isMobile.any() ) {
			$( '.sub-menu li' ).on( 'hover', function () {
			var sub_menu = $( this ).find( ' > .sub-menu' );
				if ( sub_menu.length ) {
					if ( sub_menu.outerWidth() > ( $( window ).outerWidth() - sub_menu.offset().left ) ) {
						$( this ).addClass( 'menu-rtl' );
					}
				}
			});
		}

		/*  [ Back To Top ]
		- - - - - - - - - - - - - - - - - - - - */
		$(window).scroll(function () {
			if ( $( this ).scrollTop() > 50 ) {
				$( '.back-to-top' ).fadeIn( 'slow' );
			} else {
				$( '.back-to-top' ).fadeOut( 'slow' );
			}
		});
		$('.back-to-top').click(function () {
			$( "html, body" ).animate({
				scrollTop: 0
			}, 500);
			return false;
		});

		/*  [ Menu Responsive ]
		- - - - - - - - - - - - - - - - - - - - */
		
			var container, button, menu;
			container = document.getElementById( 'site-navigation' );
			if ( ! container )
				return;

			button = container.getElementsByTagName( 'button' )[0];
			if ( 'undefined' === typeof button )
				return;

			menu = container.getElementsByTagName( 'ul' )[0];

			// Hide menu toggle button if menu is empty and return early.
			if ( 'undefined' === typeof menu ) {
				button.style.display = 'none';
				return;
			}

			button.onclick = function() {
				if ( -1 !== container.className.indexOf( 'active' ) )
					container.className = container.className.replace( ' active', '' );
				else
					container.className += ' active';
			};

			var MenuChildren = $('#menu-main .menu-item-has-children');

			MenuChildren.children('a').after('<div class="touch"><i class="dashicons dashicons-arrow-down-alt2"></i></div>');
			MenuChildren.on('click', '.touch', function(e){
				e.stopPropagation();
				$(this).parent('.menu-item').toggleClass('active');
			});
		

		/*  [ Remove p empty tag of page builder ]
		- - - - - - - - - - - - - - - - - - - - */
		$( 'p' ).each(function() {
			var $this = $( this );
				if( $this.html().replace(/\s|&nbsp;/g, '').length == 0) {
				$this.remove();
			}
		});

		/*  [ Modify default gallery of wordpress to carousel ]
		- - - - - - - - - - - - - - - - - - - - - - - - - - - - */
		$( ".gallery" ) .owlCarousel({
			items: 1,
			pagination: true,
		});

		/*  [ Switch style for shop page  ]
		- - - - - - - - - - - - - - - - - - - - */
		$( '.style-switch a' ).on('click', function () {
			$(this).parent().children().removeClass(' active' );
			$(this).toggleClass('active');

			if ( $(this).hasClass( 'list' ) ) {
				$( '.products' ).addClass( 'list-style' );
			} else {
				$( '.products' ).removeClass( 'list-style' );
			}
		});

		/*  [ Custom accordion element ]
		- - - - - - - - - - - - - - - - - - - - */
		function toggleChevron(e) {
			$(e.target).prev('.panel-heading').find('a').toggleClass('collapsed');
		}
		$('.wr-element-accordion').on('hidden.bs.collapse', toggleChevron);
		$('.wr-element-accordion').on('shown.bs.collapse', toggleChevron);

		/*  [ Custom heading element ]
		- - - - - - - - - - - - - - - - - - - - */
		$('.h-center').wrap('<div style="text-align: center;"></div>');
		$('.h-center').append('<div class="dot"></div>');

		/*  [ Custom add to cart button ]
		- - - - - - - - - - - - - - - - - - - - */
		$( '.add_to_cart_button' ).click(function( e ) {
			setTimeout(function() {
				$(this).siblings('.added_to_cart').remove();
				$(this).removeClass('.added');
			}.bind(this), 350);
		});

		/*  [ Custom row fullwidth ]
		- - - - - - - - - - - - - - - - - - - - */
		$('.wr_fullwidth').each(function() {
			var $self_html = $(this).html();
			$(this).empty();$(this).append('<div class="container">' + $self_html + '</div>');
		});
		$( 'body' ).removeClass( 'wr-full-width' );

		/*  [ Custom promo box ]
		- - - - - - - - - - - - - - - - - - - - */
		$( '.wr-element-promobox' ).find( '.btn' ).each(function() {
			$(this).parent().addClass( 'has-btn' );
		});

	});

	$(window).load(function() {

		/*  [ Sticky header trigger ]
		- - - - - - - - - - - - - - - - - - - - */
		if ( extraParams.sticky_menu == '1' ) {
			$( '.header-bot' ).scrollFix({
				fixClass: 'sticky',
			});
		}

		/*  [ Blog masonry trigger ]
		- - - - - - - - - - - - - - - - - - - - */
		if ( extraParams.blog_masonry == 'masonry' ) {
			var container = document.querySelector( '.blog-masonry' );
			var msnry = new Masonry( container, {
				itemSelector: '.hentry',
				columnWidth: container.querySelector( '.grid-sizer' )
			});
		}

		/*  [ Page loader]
		- - - - - - - - - - - - - - - - - - - - */
		setTimeout(function() {
			$( 'body' ).addClass( 'loaded' );
			setTimeout(function () {
				$('#pageloader').remove();
			}, 1500);
		}, 1500);
	});
})(jQuery);