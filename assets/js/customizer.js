/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	var api = wp.customize;
	// Site title and description.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	api( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	// add class to widget on footer.
	api( 'suffice_footer_columns_count', function( value ) {
		value.bind( function( to ) {
			$( '.footer-top' ).find( '.footer-widgets' ).find( '.footer-widget-area' ).
			removeClass('col-md-3 col-md-4 col-md-6 col-md-12').
			addClass( to );
		} );
	} );

	// add class to widget .
	api( 'sufficet_show_widget_title_ribbon', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( '.widget-area' ).find( '.widget' ).addClass( 'widget--ribbon' );
			} else {
				$( '.widget-area' ).find( '.widget' ).removeClass('widget--ribbon');
			}
		} );
	} );

} )( jQuery );
