(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $( document ).ready( function() {

	 	$('#szamlahegy_wc_create').click(function(e) {
	  	e.preventDefault();

	    var nonce = $(this).data('nonce');
	    var order = $(this).data('order');
	    var button_container = $(this).parents('div.inside');
	   	var data = {
	       action: 'szamlahegy_wc_create_invoice',
	       nonce: nonce,
	       order: order
	     };

	 		button_container.block({message: null, overlayCSS: {background: '#fff', backgroundSize: '16px 16px', opacity: 0.6}});
			$('.szamlahegy-wc-message').remove();

			$.post( ajaxurl, data, function( response ) {
				console.log(response);
				if(response.success) {
					button_container.html('<div class="updated szamlahegy-wc-message">Sikeres számla készítés!</div>');
					button_container.append(response.data.meta_box);
				} else {
					button_container.before('<div class="error szamlahegy-wc-message"></div>');
					$('.szamlahegy-wc-message').append(response.data.error_text);
				}
				button_container.unblock();

			}).fail(function() {
    		button_container.before('<div class="error szamlahegy-wc-message">Sikertelen számla létrehozás! Kérlek, keress minket, és segítünk kijavítani a hibát!</div>');
				button_container.unblock();
  		});
		});
	});

})( jQuery );
