/**
 * Toggles the mobile primary navigation menu.
 */
( function () {
	'use strict';

	var siteNavigation = document.getElementById( 'site-navigation' );
	var button = document.querySelector( '.menu-toggle' );

	if ( ! siteNavigation || ! button ) {
		return;
	}

	button.addEventListener( 'click', function () {
		siteNavigation.classList.toggle( 'toggled' );

		var expanded = 'true' === button.getAttribute( 'aria-expanded' );
		button.setAttribute( 'aria-expanded', expanded ? 'false' : 'true' );
	} );

	// Close the open menu when a link is followed or focus leaves the header.
	siteNavigation.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( 'a' ) ) {
			siteNavigation.classList.remove( 'toggled' );
			button.setAttribute( 'aria-expanded', 'false' );
		}
	} );
} )();

/**
 * Blog slider: non-infinite horizontal scroller with prev/next controls.
 * Prev is disabled at the start, next at the end.
 */
( function () {
	'use strict';

	function initSlider( slider ) {
		var track = slider.querySelector( '[data-blog-track]' );
		var prev  = slider.querySelector( '[data-blog-prev]' );
		var next  = slider.querySelector( '[data-blog-next]' );

		if ( ! track || ! prev || ! next ) {
			return;
		}

		function step() {
			var card = track.querySelector( '.blog-card' );
			if ( ! card ) {
				return track.clientWidth;
			}
			var styles = window.getComputedStyle( track );
			var gap    = parseFloat( styles.columnGap || styles.gap ) || 0;
			return card.getBoundingClientRect().width + gap;
		}

		function update() {
			var maxScroll = track.scrollWidth - track.clientWidth - 1;
			prev.disabled = track.scrollLeft <= 0;
			next.disabled = track.scrollLeft >= maxScroll;
		}

		prev.addEventListener( 'click', function () {
			track.scrollBy( { left: -step(), behavior: 'smooth' } );
		} );

		next.addEventListener( 'click', function () {
			track.scrollBy( { left: step(), behavior: 'smooth' } );
		} );

		track.addEventListener( 'scroll', function () {
			window.requestAnimationFrame( update );
		} );
		window.addEventListener( 'resize', update );

		update();
	}

	var sliders = document.querySelectorAll( '[data-blog-slider].is-slider' );
	for ( var i = 0; i < sliders.length; i++ ) {
		initSlider( sliders[ i ] );
	}
} )();
