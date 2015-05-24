(function($){

	$('.yp-advanced-options input[type=radio]').live('change', function(){
		var self = $(this);
		var table = self.closest('.acf_field_form_table');
		if(!table.length) {
			table = self.closest('.acf-table');
		}
		if(table.length){
			var fields = table.find('.field_advanced');
			if(fields.length) {
				fields.each(function(){
					if(parseInt(self.val()) === 1){
						$(this).show();
					}else{
						$(this).hide();
					}
				});
			}			
		}
	});

})(jQuery);