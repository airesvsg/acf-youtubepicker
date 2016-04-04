(function($){
	
	
	function initialize_field( $el ) {
		
		$el.find('.acf-youtubepicker-field').each(function() {
					
			var self     = $(this);
			var multiple = 1 === parseInt(self.data('multiple')||0, 10);
			var holder   = self.closest('.acf-field-youtubepicker').find('.inner');
			var input    = self.youtubepicker(
								{'API_KEY' : self.data('api-key')}, 
								self.data('options')||{}
							);
			
			var deleteBtn = '<a href="#" class="acf-button-delete ir">remove</a></li>';
			if( self.data('pro') ) {
				deleteBtn = '<a href="#" class="acf-button-delete acf-icon"><i class="acf-sprite-delete"></i></a>';
			}
			
			input.on('itemSelected', function(e, data){
				var field   = data.clone;
				var current = JSON.stringify({ title : data.title, vid : data.vid });
				var name    = field.attr('name') + '[]';
				var item    = '<div class="thumbnail">' +
								'<input type="hidden" name="'+name+'">' + 
								'<div class="inner clearfix">' + 
									'<img src="http://i.ytimg.com/vi/'+data.vid+'/default.jpg" alt="'+data.title+'">' + 
								'</div>' +
								'<div class="hover">' +
									'<ul class="bl">' +
										'<li>' + deleteBtn + '</li>' +
									'</ul>' +
								'</div>' +
							'</div>';
				
				if( ! multiple ) {
					holder.empty();
				}
				
				holder.append(item);
				holder.find('input[name="'+name+'"]:last').val(current);

			});
			
			if( multiple ) {
				holder.sortable({
					items					:	'> .thumbnail',
					forceHelperSize			:	true,
					forcePlaceholderSize	:	true,
					scroll					:	true,
					start					:	function (event, ui) {
						ui.placeholder.width( ui.placeholder.width() - 4 );
						ui.placeholder.height( ui.placeholder.height() - 4 );
		   			}
				});				
			}

			$(document).on('click', '.acf-youtubepicker .acf-button-delete', function(){
				$(this).closest('.thumbnail').fadeOut('fast', function(){
					$(this).remove();
				});
				return false;
			});

		});
	}
	
	
	if( typeof acf.add_action !== 'undefined' ) {
	
		/*
		*  ready append (ACF5)
		*
		*  These are 2 events which are fired during the page load
		*  ready = on page load similar to $(document).ready()
		*  append = on new DOM elements appended via repeater field
		*
		*  @type	event
		*  @date	20/07/13
		*
		*  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
		*  @return	n/a
		*/
		
		acf.add_action('ready append', function( $el ){
			
			// search $el for fields of type 'youtubepicker'
			acf.get_fields({ type : 'youtubepicker'}, $el).each(function(){
				
				initialize_field( $(this) );
				
			});
			
		});
		
		
	} else {
		
		
		/*
		*  acf/setup_fields (ACF4)
		*
		*  This event is triggered when ACF adds any new elements to the DOM. 
		*
		*  @type	function
		*  @since	1.0.0
		*  @date	01/01/12
		*
		*  @param	event		e: an event object. This can be ignored
		*  @param	Element		postbox: An element which contains the new HTML
		*
		*  @return	n/a
		*/
		
		$(document).on('acf/setup_fields', function(e, postbox){
			
			$(postbox).find('.field[data-field_type="youtubepicker"]').each(function(){
				
				initialize_field( $(this) );
				
			});
		
			if(typeof postbox.selector == 'undefined') {

				$(postbox).find('.acf-youtubepicker .inner').empty();

			}
		
		});
	
	
	}


})(jQuery);
