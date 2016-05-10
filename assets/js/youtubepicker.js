/*!
 * youtubepicker.js - v2.0.0 - 2016
 * http://github.com/airesvsg/youtubepicker
 * Copyright (c) 2016 Aires Goncalves;
 * Licensed MIT
 */

(function($){

	var endpoint = 'https://www.googleapis.com/youtube/v3/';

	var YouTubePicker = {
		init: function(elm, options){
			var self = this;

			self.$field  = $(elm);
			self.id      = 'youtubepicker-' + (new Date().getTime());
			self.options = $.extend({}, $.fn.youtubepicker.options, self.$field.data(), options);
			
			self.field_init();
		},
		field_init: function(){
			var self   = this;
			var offset = {};

			if(self.options.cloneField){
				self.$clone = self.$field.clone(true);
				self.$field.removeAttr('name');
				self.$clone.insertAfter(self.$field);
				self.$clone.hide()
					.removeAttr('class id')
					.addClass('youtubepicker-cloned-field');
			}

			$(self.template('panel')).insertAfter(self.$field);

			self.$panel = $('#' + self.id);
			self.$content = self.$panel.find('.youtubepicker-content');

			offset.x = (self.$field.offset().left - self.$panel.parent().offset().left);
			offset.x += parseInt(self.options.offset.x, 10)||0;	
			offset.y = parseInt(self.options.offset.y, 10)||0;
			
			self.$panel.css({'margin-left':offset.x, 'margin-top':offset.y});

			self.field_events();
			self.buttons_events();
			self.scroller();
		},
		field_events: function(){
			var self = this;
			var lastTerm;
			var timer;

			self.$field.on('keyup', function(){
				self.term = $(this).val();
				clearTimeout(timer);
				if(!self.term.length){
					self.$content.empty();
					self.$panel.removeClass('youtubepicker-loading');					
					self.scroller('update');
				}else if(self.term.length >= self.options.minChar && lastTerm !== self.term ){
					timer = setTimeout(function(){
						lastTerm = self.term;
						self.$content.empty();
						self.search();
					}, (parseInt(self.options.searchDelay, 10) * 1000));
				}
			})
			.on('focus', function(){
				$('.youtubepicker.panel').hide();
				if(!self.$panel.is(':visible')){
					self.$panel.show();
				}
			})
			.on('blur', function(){
				if(!self.$panel.is(':hover')){
					self.$panel.hide();
				}
			});
		},
		buttons_events: function(type){
			var self = this;

			if(type === 'items'){
				self.$panel.find('.youtubepicker-select-btn').off().on('click', function(e){
					e.preventDefault();

					var data = $(this).closest('.youtubepicker-item').data('youtubepicker-item-data');
					if(self.options.cloneField){
						self.$clone.val(data.vid);
						data = $.extend({}, data, {clone: self.$clone, term: self.term});
					}
					self.$field.trigger('itemSelected', data);
					self.$panel.hide();
				});

				self.$panel.find('.youtubepicker-preview-btn').off().on('click', function(e){
					e.preventDefault();

					var item    = $(this).closest('.youtubepicker-item');
					var data    = item.data('youtubepicker-item-data');
					var preview = self.$panel.find('.youtubepicker-preview');
					
					preview.addClass('show');
					preview.find('.youtubepicker-player').html(self.template('player', data));
					self.$panel.find('.youtubepicker-preview-btn').removeClass('current');
					item.addClass('current');
				});				
			} else {
				self.$panel.find('.youtubepicker-preview-close-btn').off().click(function(e){
					e.preventDefault();

					var preview = self.$panel.find('.youtubepicker-preview');

					if(preview.hasClass('show')){
						preview.removeClass('show');
					}

					preview.find('.youtubepicker-player').empty();
					self.$panel.find('.youtubepicker-preview-btn.current').removeClass('current');
				});

				self.$panel.find('.youtubepicker-preview-select-btn').off().click(function(e){
					e.preventDefault();

					self.$panel.find('.youtubepicker-preview-close-btn').click();
					self.$panel.find('.youtubepicker-item.current').find('.youtubepicker-select-btn').click();
				});
			}
		},
		scroller: function(act){
			var self = this;
			var nano = self.$panel.find('.nano');

			if($.isFunction(nano.nanoScroller)){
				if(act === 'update'){
					self.$panel.find('.nano').nanoScroller();						
				} else {
					nano.nanoScroller(setTimeout.nanoScroller)
						.on('scrollend', function(){
							self.search();
						});
				}
			}
		},
		template: function(type, data){
			var self    = this;
			var html    = '';
			var preview = '';

			if(type === 'panel'){
				if(self.options.preview){
					preview = '<div class="youtubepicker-preview">' +
											'<div class="youtubepicker-actions">' +
												'<a href="#" class="youtubepicker-preview-select-btn">' + self.options.language.buttons.select + '</a>' +
												'<a href="#" class="youtubepicker-preview-close-btn">' + self.options.language.buttons.close + '</a>' +
											'</div>' +
											'<div class="youtubepicker-player"></div>' +
										'</div>';
				}

				html = '<div id="' + self.id + '" class="youtubepicker youtubepicker-panel">' +
									'<div class="youtubepicker-wrap">' +
										'<div class="youtubepicker-results nano">' +
											'<div class="youtubepicker-content nano-content"></div>' +
											'<div class="youtubepicker-loader">' + self.options.language.labels.loading + '</div>' +
											'<div class="youtubepicker-no-records">' + self.options.language.labels.noRecords + '</div>' +
										'</div>' +
										preview +
									'</div>' +
								'</div>';
			} else if(type === 'item'){
				if(self.options.preview){
					preview = '<a href="#" class="youtubepicker-preview-btn">' + self.options.language.buttons.preview + '</a>';
				}

				html = '<div class="youtubepicker-item youtubepicker-item-' + data.vid + '">' +
									'<div class="youtubepicker-thumbnail">' +
										'<img src="' + data.thumb + '">' +
									'</div>' +
									'<div class="youtubepicker-info">' +
										'<p class="youtubepicker-title">' + data.title + '</p>' +
										'<p class="youtubepicker-description">' + data.description + '</p>' +
									'</div>' +
									'<div class="youtubepicker-actions" data-vid="' + data.vid + '">' +
										preview +
										'<a href="#" class="youtubepicker-select-btn">' + self.options.language.buttons.select + '</a>' +
									'</div>' +
								'</div>';
			} else if(type === 'player'){
				html = '<iframe type="text/html" width="100%" height="100%" src="http://www.youtube.com/embed/' + data.vid + '?autoplay=1&showsearch=0&iv_load_policy=3&fs=0&rel=0&loop=0" frameborder="0"/>';
			}

			return html;
		},
		populate: function(data){
			var self      = this;
			var items     = data.items||[];
			var noRecords = self.$panel.find('.youtubepicker-no-records');
			
			if(!items.length){
				noRecords.show();
			} else {
				noRecords.hide();
				for(var i in items){
					if(!$('.youtubepicker-item-'+items[i].id.videoId).length){
						data = {
							vid: items[i].id.videoId,
							title: items[i].snippet.title,
							description: items[i].snippet.description,
							thumb: items[i].snippet.thumbnails.default.url
						};

						self.$content.append(self.template('item', data));
						$.data(self.$panel.find('.youtubepicker-item:last')[0], 'youtubepicker-item-data', data);
					}
				}
			}
			
			self.$panel.removeClass('youtubepicker-loading');
			self.scroller('update');
			self.buttons_events('items');
		},
		search: function(){
			var self = this;
			var params = {
						key: self.options.key,
						part: "snippet",
						type: "video",
						pageToken: self.pageToken, 
						q: self.term
					};

			params = $.extend({}, self.options.searchParams, params);
			
			self.$panel.addClass('youtubepicker-loading');
			self.$field.trigger('loadInit', params);

			$.getJSON(endpoint+'search', params)
				.done(function(data){
					self.pageToken = data.nextPageToken;
					self.populate(data);
					self.$field.trigger('loadComplete', data);
				})
				.fail(function(data){
					self.$field.trigger('loadError', data);
				});
		}
	};

	$.fn.youtubepicker = function(options){
		return this.each(function(){
			var youtubepicker = Object.create(YouTubePicker);
			youtubepicker.init(this, options);
			$.data(this, 'youtubepicker', youtubepicker);
		});
	};

	$.fn.youtubepicker.options = {
		key: "AIzaSyAuHQVhEmD4m2AXL6TvADwZIxZjNogVRF0",
		prefix: "youtubepicker",
		minChar: 3,
		searchDelay: 2,
		preview: true,
		cloneField: true,
		offset: {
			x: 0, 
			y: 0
		},
		language: {
			buttons: {
				preview: "Preview",
				select: "Select",
				close: "&times;" 
			},
			labels: {
				views: "Views",
				noRecords: "No records",
				loading: "Loading..."
			}
		},
		searchParams: {			
			maxResults: 50,
			order: "relevance"
		}
	};

})(jQuery, window, document);
