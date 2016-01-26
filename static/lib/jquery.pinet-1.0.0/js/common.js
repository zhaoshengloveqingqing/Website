;(function($){

	var measure_string = function(str, font){
		var canvas = document.createElement('canvas');
		var ctx = canvas.getContext("2d");
		ctx.font = font;        
		return ctx.measureText(str).width;
	}

	var calc_length = function(str, font, w, emitter) {
		if(measure_string(str, font) > w) {
			var ic = Math.floor(w / measure_string('i'));
			var mc = Math.floor(w / measure_string('m'));
			for(var i = ic; i > 0; i--) {
				var s = str.substring(0, i) + emitter;
				if(measure_string(s, font) < w) {
					return i;
				}
			}
		}
		else {
			return str.length;
		}
	}

    var get_font = function(e) {
        var fs = $(e).css('font-style');
        var fv = $(e).css('font-variant');
        var fz = $(e).css('font-size');
        var ff = $(e).css('font-family');
        return [fs, fv, fz, ff].join(' ');
    }

	$.fn.emit = function(){
		$(this).each(function(){
			var font = get_font(this);
			var pl = $(this).css('padding-left').replace('px', '');
			var pr = $(this).css('padding-right').replace('px', '');
			var w = $(this).width();
            if($(this).children("a").length) {
                $(this).children("a").emit();
            }
            else {
                if(measure_string($(this).text(), font) < w) {
                    return;
                }
                var emitter = ' ... ';
                var c = calc_length($(this).text(), font, w - pl - pr, emitter);
                var str = $(this).text();
                if(str.length > 0) {
                    $(this).attr('title', str);
                    $(this).text(str.substring(0, c) + emitter);
                }
            }
		});
	}

	function getFileName(){
		var url = this.location.href
		var pos = url.lastIndexOf("/");
		if(pos == -1){
		   pos = url.lastIndexOf("\\")
		}
		var filename = url.substr(pos +1)
		return filename;
	}

	$.fn.PictureButton = function(){

		return this.each(function(){
			var pic_btn = $(this);			
			var picture = pic_btn.find('picture');
			if(picture.length > 0) {
				var img = picture.find('img');
				var imageName = picture[0].attributes['src'].value.replace('.png','');
				if(pic_btn.hasClass('disabled')) {
					var src = img.attr('src');
					if(src.indexOf('-disabled') < 0) {
						var imagePath = img.attr('src').replace(imageName, imageName + '-disabled');
						img.attr('src', imagePath);
					}					
				}				
			}
			
		});

	}

    $.fn.alertMap = function(){
	    var option = {
		    indicator_template: '<ul class="nav indicator"></ul>',
		    indicator_item_template: '<li><a class="indicator-item"></a></li>',
		    indicator_container_height: 20,
			item_selector: '.alert-map-item'
	    }

		this.each(function(){
			var self = $(this);
			var self_width = self.width();
			var self_height = self.height();
			var self_items = self.find(option.item_selector);
			var last_index = 0;
			var jq_document = $(document);
			var jq_document_scrollTop = jq_document.scrollTop();
			var interval = null;

			if(self_items.length < 2) {
				self_items.eq(0).show();
				return this;
			}

			self_items.eq(0).show();
			self.height(self_height + option.indicator_container_height);

			self.off('mousewheel').on('mousewheel', function(e){
				var index = last_index;
				if(e.deltaY < 0) {
					index++;
					if(index > self_items.length - 1) {
						index = 0;
					}
				}else if(e.deltaY > 0) {
					index--;
					if(index < 0) {
						index = self_items.length - 1;
					}  
				}
				changeAlert(index);
				return false;
			});

			var indicator = $(option.indicator_template);
			var indicator_items = [];

			for (var i = 0; i < self_items.length; i++) {
				indicator_items[i] = $(option.indicator_item_template);
				if(i == 0){
					indicator_items[i].addClass('active');
				}

				indicator_items[i].find('a').attr('item-index', i);
				indicator.append(indicator_items[i]);
			}

			self.append(indicator);
			var indicator_width = indicator.width();
			indicator.css('left', (self_width - indicator_width) / 2);

			indicator.on('click', '.indicator-item', function(e){
				var item = $(e.target);
				var index = $(e.target).attr('item-index');
				changeAlert(index);
			});

			self.on('mouseenter', function(){
				clearInterval(interval);
			});

			self.on('mouseleave', function(){
				interval = setInterval(function(){
					var index = last_index;
					index++;
					if(index > self_items.length - 1) {
						index = 0;
					}
					changeAlert(index);
				}, 6000);				
			}).trigger('mouseleave');

			function changeAlert(index) {
				indicator_items[last_index].removeClass('active');
				self_items.eq(last_index).fadeOut();

				self_items.eq(index).fadeIn();

				last_index = index;
				indicator_items[index].addClass('active');
			}

		});

	}

	$.fn.display_box = function(options) {

		var defaults = {
			selector: ".check-in-poid-switch-dialog",
			state: "readOnly"
		};

		var op = $.extend(defaults, options);

	    $(op.selector).each(function(){
	        var self = $(this);
	        var container = self.parent();
	        var display_box = self.parentsUntil('.sns-display-box').parent();
	        var iframe = self.find('iframe');
	        var isIframeInit = false;

	        if(iframe.length < 1) {
	        	iframe = $('<iframe src="'+op.url+'" frameborder="0"></iframe>');
	        	iframe.css('width', '100%');
	        	iframe.height(240);
	        }

	     	self.data('show', false);

	        self.find('.switch-box').off('click.iframe.on').on('click.iframe.on', '.btn.on', function(e){
	        	var btn_group = $(e.delegateTarget);
	        	if(btn_group.find("input[type=radio]").length > 0 && btn_group.attr("data-toggle") == "buttons" ) {
		        	self.trigger('switch-box.on');
		        	if(!self.data('show')) {
		        		self.data('show', true);
			           	container.addClass('on');
			            if(!isIframeInit) {
			            	isIframeInit = true;
				            container.append(iframe);
				            iframe.load(function(){
				                display_box.stop().animate({'height': display_box.height() + 240}, 600);
				                iframe.show();
				            })
			            }else {
			            	iframe.show();
			            	display_box.stop().animate({'height': display_box.height() + 240}, 600);
			            }
		        	}
	        	}
	        });  

	        self.find('.switch-box').off('click.iframe.off').on('click.iframe.off', '.btn.off', function(e){
	        	var btn_group = $(e.delegateTarget);
	        	if(btn_group.find("input[type=radio]").length > 0 && btn_group.attr("data-toggle") == "buttons" ) {
		        	if(self.data('show')) {
		        		self.data('show', false);
			        	container.removeClass('on');
			        	display_box.stop().animate({'height': display_box.height() - 240}, 1000, function(){
			        		iframe.hide();
			        	});
		        	}
	        	}
	        });

	    })
	}

})(jQuery)