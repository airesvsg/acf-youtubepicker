( function( $ ) {

	$( document ).on( 'change', '.yp-advanced-options input[type=radio]', function() {
		var self  = $(this);
		var table = self.closest( '.acf_field_form_table' );

		if ( ! table.length ) {
			table = self.closest( '.acf-table' );
		}

		if ( table.length ) {
			var fields = table.find( '.field_advanced' );
			
			if( fields.length ) {
				fields.each( function() {
					if ( 1 === parseInt( self.val(), 10 ) ) {
						$( this ).show();
					} else {
						$( this ).hide();
					}
				} );
			}			
		}
	} );

} )( jQuery );