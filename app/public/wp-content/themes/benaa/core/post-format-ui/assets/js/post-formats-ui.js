(function ($) {
	"use strict";
	var G5Plus_PFUI = G5Plus_PFUI || {},
		post_format = ['audio','gallery','link','quote','video'];


	G5Plus_PFUI.onReady = {
		init : function() {
			G5Plus_PFUI.postFormats.init();
			G5Plus_PFUI.media.init();
		}
	};

	G5Plus_PFUI.postFormats = {
		init : function() {
			G5Plus_PFUI.postFormats.switchTab();
			G5Plus_PFUI.postFormats.renderUI();
		},
		switchTab : function() {
			$('body').on('click', '#g5plus-post-formats-ui-tabs a', function(event) {
				event.preventDefault();
				var $this = $(this),
					postFormat = $this.attr('href').replace('#',''),
					$fieldWrap = $('#g5plus-pfui-' + postFormat);
				if ($this.hasClass('current')) {
					return;
				}

				$('#g5plus-post-formats-ui-tabs a[class="current"]').removeClass('current');
				$this.addClass('current');

				$('[id^="g5plus-pfui-post-format-"]').hide();
				$fieldWrap.show();

				$('#'+ postFormat).trigger('click');
			});
		},
		renderUI : function(){
			$('#g5plus-post-formats-ui-tabs').insertBefore($('form#post')).show();
			$('#g5plus-pfui-post-format-link, #g5plus-pfui-post-format-video, #g5plus-pfui-post-format-audio').insertAfter($('#titlediv'));
			$('#g5plus-pfui-post-format-gallery').find('dt a').each(function() {
				$(this).replaceWith($(this.childNodes)); // remove links
			}).end().insertAfter($('#titlediv'));
			$('#g5plus-pfui-post-format-quote').insertAfter($('#titlediv'));
			$(document).trigger('g5plus-post-formats-ui-init');

			var postFormatCurrent = $('#g5plus-post-formats-ui-tabs a[class="current"]').attr('href').replace('#','');
			$('#g5plus-pfui-' + postFormatCurrent).show();
		}
	};

	G5Plus_PFUI.media = {
		_frame : null,
		init : function() {
			$('#wpbody').on('click', '.g5plus-pfui-gallery-button', function(e){
				e.preventDefault();
				G5Plus_PFUI.media.frame().open();
			});

			this.event();
		},
		event : function() {
			var $gallery = $('.g5plus-pfui-gallery-picker .gallery');

			$gallery.on('update', function(){
				var ids = [];
				$(this).find('> span').each(function(){
					ids.push($(this).data('id'));
				});
				$('[name="g5plus_format_gallery_images"]').val(ids.join(','));
			});

			$gallery.sortable({
				placeholder: "g5plus-pfui-ui-state-highlight",
				revert: 200,
				tolerance: 'pointer',
				stop: function () {
					$gallery.trigger('update');
				}
			});

			$gallery.on('click', 'span.close', function(e){
				$(this).parent().fadeOut(200, function(){
					$(this).remove();
					$gallery.trigger('update');
				});
			});
		},
		frame : function() {
			if (this._frame) {
				return this._frame;
			}

			this._frame = wp.media({
				title : g5plus_pfui_post_format.media_title,
				library : {
					type : 'image'
				},
				button : {
					text : g5plus_pfui_post_format.media_button
				},
				multiple : true
			});
			this._frame.on('open', this.updateFrame).state('library').on('select', this.select);
			return this._frame;
		},
		select : function() {
			var selection = this.get('selection'),
				$gallery = $('.g5plus-pfui-gallery-picker .gallery');

			selection.each(function(model) {
				var thumbnail = model.attributes.url;
				if( model.attributes.sizes !== undefined && model.attributes.sizes.thumbnail !== undefined )
					thumbnail = model.attributes.sizes.thumbnail.url;
				$gallery.append('<span data-id="' + model.id + '" title="' + model.attributes.title + '"><img src="' + thumbnail + '" alt="" /><span class="close">x</span></span>');
				$gallery.trigger('update');
			});
		},
		updateFrame: function() {

		}

	};


	$(document).ready(G5Plus_PFUI.onReady.init);
	//$(window).load(G5Plus.onLoad.init);

})(jQuery);
