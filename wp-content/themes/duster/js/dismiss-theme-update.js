( function( $ ) {
	$( document ).on( 'ready', function() {
		$( '#dismiss-theme-update' ).on( 'click', function( event ) {
			event.preventDefault();
			$.ajax( {
				url: ajaxurl,
				data: {
					action: 'dismiss_theme_update',
					theme: dismissThemeUpdate.theme,
					nonce: dismissThemeUpdate.nonce
				},
				success: function() {
					$( '#setting-error-theme-update' ).hide();
				}
			} );
		} );
	} );
} )( jQuery );