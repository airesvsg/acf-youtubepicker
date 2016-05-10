( function( $ ) {
	
	function initialize_field( $el ) {		
		$el.find( '.acf-youtubepicker-field' ).each( function() {
			var self     = $( this );
			var multiple = 1 === parseInt( self.data( 'multiple' ), 10 );
			var id       = self.attr( 'id' );
			var holder   = $( '#' + id + '-holder > .inner' );
			var input    = self.youtubepicker();
			
			input.on( 'itemSelected', function( e, data ) {
				var selector = pro ? 'acf' : 'field';
				var field    = self.parent().find( 'input[name^=' + selector + ']' );
				var current  = JSON.stringify( { title : data.title, vid : data.vid } );
				var name     = field.attr( 'name' ) + '[]';
				var item     = '<div class="thumbnail">' +
								'<input type="hidden" name="' + name + '">' + 
								'<div class="inner clearfix">' + 
									'<img src="http://i.ytimg.com/vi/' + data.vid + '/default.jpg" alt="' + data.title + '">' + 
								'</div>' +
								'<div class="acf-soh">'+
									'<div class="actions acf-soh-target">' +
										'<a href="#" class="acf-button-delete acf-icon -cancel dark"></a>' +			
									'</div>' +
								'</div>' +
							'</div>';
				
				if( ! multiple ) {
					holder.empty();
				}

				holder.append( item );
				holder.find( 'input[name="' + name + '"]:last' ).val( current );
			} );
			
			if( multiple ) {
				holder.sortable( {
					items: '> .thumbnail',
					forceHelperSize: true,
					forcePlaceholderSize: true,
					scroll: true,
					start: function( event, ui ) {
						ui.placeholder.width( ui.placeholder.width() );
						ui.placeholder.height( ui.placeholder.height() );
		   			}
				} );
			}

			$( document ).on( 'click', '.acf-youtubepicker .acf-button-delete', function( e ) {
				e.preventDefault();

				$( this ).closest( '.thumbnail' ).fadeOut( 'fast', function() {
					$( this ).remove();
				} );
			} );
		} );
	}
	
	var pro = typeof acf.add_action !== 'undefined';

	$( document ).on( 'click', '#publish', function() {
		var field  = $( '.field_type-youtubepicker.required' );
		var thumbs = field.find( '.thumbnail' );
		
		if ( thumbs.length > 0 ) {
			field.find( 'input[type=text]:first' ).val( ' ' );
		}
	} );
	
	if( pro ) {
		acf.add_action( 'ready append', function( $el ) {
			acf.get_fields( { type : 'youtubepicker' }, $el ).each( function() {
				initialize_field( $( this ) );				
			} );			
		} );	
	} else {
		$( document ).on( 'acf/setup_fields', function( e, postbox ) {
			$( postbox ).find( '[data-field_type="youtubepicker"]' ).each( function() {
				initialize_field( $( this ) );
			} );
		} );
	}

} )( jQuery );
