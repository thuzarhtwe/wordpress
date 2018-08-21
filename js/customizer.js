/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
	// Header background color.
	wp.customize( 'themename_theme_bgcolor1', function( value ) {
		value.bind( function( newval ) {
			$( '.site-header' ).css({'background-color': newval});
			$( '.main-navigation ul' ).css({'background-color': newval});
			$( '.main-navigation .current-menu-ancestor>a,.main-navigation .current-menu-item>a,.main-navigation .current_page_ancestor>a,.main-navigation .current_page_item>a' ).css({'background-color': newval});
			$( '.site .site-content .content-area .site-main .top-page .post .read-more a' ).css({'background-color': newval});

			$('<style>.site .site-content .content-area .site-main .top-page .post .read-more a:hover{background-color:' + newval + ' !important}</style>').appendTo('head');
			$('<style>.site-title a:hover{color:' + newval + ' !important}</style>').appendTo('head');
			$('<style>.header-menu ul li:hover{color:' + newval + ' !important}</style>').appendTo('head');
			$('<style>.header-menu ul li a:hover{background-color:' + newval + ' !important}</style>').appendTo('head');
		} );
	} );
	wp.customize( 'themename_theme_hovercolor', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation .current-menu-ancestor>a,.main-navigation .current-menu-item>a,.main-navigation .current_page_ancestor>a,.main-navigation .current_page_item>a' ).css({'color': newval});
			$('<style>.header-menu ul li a:hover{color:' + newval + ' !important}</style>').appendTo('head');
			$('<style>.site-branding .site-title a:hover{color:' + newval + ' !important}</style>').appendTo('head');
			$('<style>.pagination .page-numbers.current, .pagination a.page-numbers:hover{color:' + newval + ' !important}</style>').appendTo('head');
		} );
	} );
	wp.customize( 'themename_text_color', function( value ) {
		value.bind( function( newval ) {
			$( '.site .site-content .content-area .site-main .entry-summary' ).css({'color': newval});
			$( '.site-main-single .post .widget, .site-main-single .post .entry-header, .site-main-single .post .entry-content p' ).css({'color': newval});
			$( '.site .site-content .content-area .site-main-archive .top-page .post .entry-summary' ).css({'color': newval});
		} );
	} );

	wp.customize( 'themename_header_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation li' ).css({'background-color': newval});
		} );
	} );

	wp.customize( 'themename_a_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.main-navigation a' ).css({'color': newval});
			$( '.widget_posts ul li a' ).css({'color': newval});
			$( '.site .site-content .content-area .site-main .entry-header h2 a' ).css({'color': newval});
			$( '.site .site-content .content-area .site-main-archive .top-page .post .entry-header h2 a' ).css({'color': newval});
			$( '.site .site-content .content-area .site-main .entry-footer span a' ).css({'color': newval});
			$( '.site .site-content .content-area .site-main-archive .top-page .post .entry-footer span a' ).css({'color': newval});
			$( '.pagination .page-numbers' ).css({'color': newval});
			$( '.widget-area a' ).css({'color': newval});
			$( '.site-main-single a' ).css({'color': newval});
		} );
	} );
	// wp.customize( 'themename_a_bgcolor', function( value ) {
	// 	value.bind( function( to ) {
	// 		if ( '#9e0c78' === to ) {
	// 			$( 'a' ).css( {
	// 				'clip': 'rect(1px, 1px, 1px, 1px)',
	// 				'position': 'absolute'
	// 			} );
	// 		} else {
	// 			$( 'a' ).css( {
	// 				'clip': 'auto',
	// 				'color': to,
	// 				'position': 'relative'
	// 			} );
	// 		}
	// 	} );
	// } );

	wp.customize( 'themename_mainpost_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.site-main-single' ).css({'background-color': newval});
			$( '.site .site-content .content-area .site-main-archive .top-page .post' ).css({'background-color': newval});
			$( '.site .site-content .content-area .site-main-archive .no-results' ).css({'background-color': newval});
			$( '.site .site-content .content-area .site-main .top-page .post' ).css({'background-color': newval});
			$( '.site .site-content .content-area .site-main .error-404' ).css({'background-color': newval});
		} );
	} );
	wp.customize( 'themename_readmore_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.site .site-content .content-area .site-main .top-page .post .read-more a' ).css({'background-color': newval});
			$( '.site .site-content .content-area .site-main-archive .top-page .post .read-more a' ).css({'background-color': newval});
			$('<style>.pagination .page-numbers.current,.pagination a.page-numbers:hover{background-color:' + newval + ' !important}</style>').appendTo('head');
			$('<style>.site .site-content .content-area .site-main-archive .top-page .post .read-more a:hover{color:' + newval + ' !important}</style>').appendTo('head');
			$('<style>.site .site-content .content-area .site-main .top-page .post .read-more a:hover{color:' + newval + ' !important}</style>').appendTo('head');
			$('<style>.site .site-content .content-area .site-main-archive .top-page .post .read-more a:hover{color:' + newval + ' !important}</style>').appendTo('head');
		} );
	} );

	wp.customize( 'themename_popularpost_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.widget_posts h2' ).css({'background-color': newval});
			$( '.widget_posts ul li' ).css({'background-color': newval});
		} );
	} );

	wp.customize( 'themename_widget_bgcolor', function( value ) {
		value.bind( function( newval ) {
			$( '.widget' ).css({'background-color': newval});
		} );
	} );

	// Widget Title Font-awesome
	wp.customize( 'themename_widget_title_fontawesome', function( value ) {
		value.bind( function( newval ) {
			var val = "\\" + newval;
			$('<style>.widget .widget-title::before{content:"' + val + '" !important}</style>').appendTo('head');
		} );
	} );
	// Widget List Font-awesome
	wp.customize( 'themename_widget_list_fontawesome', function( value ) {
		value.bind( function( newval ) {
			var val = "\\" + newval;
			$('<style>.widget ul li::before{content:"' + val + '" !important}</style>').appendTo('head');
		} );
	} );
} )( jQuery );
