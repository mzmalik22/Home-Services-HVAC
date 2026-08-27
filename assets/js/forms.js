/**
 * Progressive-enhancement AJAX submission for the theme's built-in forms
 * (booking widgets, Contact Us, footer newsletter signup). Forms already work
 * without this script via a normal POST to admin-post.php; this just avoids
 * the full page reload and shows the confirmation/error message in place.
 */
( function () {
	'use strict';

	if ( typeof hvacForms === 'undefined' ) {
		return;
	}

	function findMessageEl( form ) {
		var type = form.querySelector( '[name="form_type"]' );
		if ( ! type ) {
			return null;
		}
		return document.getElementById( type.value + '-form-message' );
	}

	function setMessage( el, text, state ) {
		if ( ! el ) {
			return;
		}
		el.textContent = text;
		el.hidden = false;
		el.classList.remove( 'is-success', 'is-error' );
		if ( state ) {
			el.classList.add( 'is-' + state );
		}
	}

	/**
	 * Format a US phone number as the visitor types: strips anything that
	 * isn't a digit, caps it at 10 digits, and lays it out as
	 * "(XXX) XXX-XXXX" so the value always matches the field's pattern.
	 */
	function formatUsPhone( value ) {
		var digits = value.replace( /\D/g, '' ).slice( 0, 10 );
		if ( digits.length > 6 ) {
			return '(' + digits.slice( 0, 3 ) + ') ' + digits.slice( 3, 6 ) + '-' + digits.slice( 6 );
		}
		if ( digits.length > 3 ) {
			return '(' + digits.slice( 0, 3 ) + ') ' + digits.slice( 3 );
		}
		if ( digits.length > 0 ) {
			return '(' + digits;
		}
		return '';
	}

	function handlePhoneInput( event ) {
		var field = event.target;
		if ( ! field.classList || ! field.classList.contains( 'hvac-phone-input' ) ) {
			return;
		}
		var caretWasAtEnd = field.selectionStart === field.value.length;
		field.value = formatUsPhone( field.value );
		if ( caretWasAtEnd ) {
			field.setSelectionRange( field.value.length, field.value.length );
		}
	}

	function handleSubmit( event ) {
		var form = event.target;
		if ( ! form.classList.contains( 'hvac-ajax-form' ) ) {
			return;
		}
		event.preventDefault();

		var messageEl = findMessageEl( form );
		var submitBtn = form.querySelector( '[type="submit"]' );
		var formData  = new FormData( form );

		formData.set( 'action', 'hvac_form_submit' );
		if ( ! formData.get( 'hvac_page_url' ) ) {
			formData.set( 'hvac_page_url', window.location.href );
		}

		if ( submitBtn ) {
			submitBtn.disabled = true;
		}

		fetch( hvacForms.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			body: formData,
		} )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( json ) {
				var data = json && json.data ? json.data : {};
				if ( json && json.success ) {
					setMessage( messageEl, data.message || hvacForms.genericError, 'success' );
					form.reset();
				} else {
					setMessage( messageEl, data.message || hvacForms.genericError, 'error' );
				}
			} )
			.catch( function () {
				setMessage( messageEl, hvacForms.genericError, 'error' );
			} )
			.finally( function () {
				if ( submitBtn ) {
					submitBtn.disabled = false;
				}
			} );
	}

	document.addEventListener( 'input', handlePhoneInput, true );
	document.addEventListener( 'submit', handleSubmit, true );
} )();
