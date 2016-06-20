/**
 * a11y.js
 *
 * Handles toggling a focus/blur state on dropdowns for keyboard nav
 */
( function( $ ) {
	// make dropdowns functional on focus
	var navigation;

	navigation = document.querySelectorAll( '.main-navigation a' );
	if ( navigation.length === 0 ) {
		return;
	}

	$( navigation ).on( 'focus blur', function() {
		$( this ).parents('li').toggleClass( 'focus' );
	});

} )( jQuery );

/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/



;(function( $, window, document, undefined ) {
	$.fn.doubleTapToGo = function( params ) {
		if ( !( 'ontouchstart' in window ) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

		this.each( function() {
			var curItem = false;

			$( this ).on( 'click', function( e ) {
				var item = $( this );
				if ( item[ 0 ] != curItem[ 0 ] ) {
					e.preventDefault();
					curItem = item;
				}
			});

			$( document ).on( 'click touchstart MSPointerDown', function( e ) {
				var resetItem = true,
					parents	  = $( e.target ).parents();

				for ( var i = 0; i < parents.length; i++ ) {
					if ( parents[ i ] == curItem[ 0 ] ) {
						resetItem = false;
					}
				}

				if ( resetItem ) {
					curItem = false;
				}
			});
		});
		return this;
	};

	$( '#site-navigation li:has(ul)' ).doubleTapToGo();
})( jQuery, window, document );
/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function() {
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

	if ( -1 === menu.className.indexOf( 'nav-menu' ) )
		menu.className += ' nav-menu';

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) )
			container.className = container.className.replace( ' toggled', '' );
		else
			container.className += ' toggled';
	};
} )();

( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && 'undefined' !== typeof( document.getElementById ) ) {
		var eventMethod = ( window.addEventListener ) ? 'addEventListener' : 'attachEvent';
		window[ eventMethod ]( 'hashchange', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
					element.tabIndex = -1;

				element.focus();
			}
		}, false );
	}
})();
