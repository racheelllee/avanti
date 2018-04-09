var ajaxValidation = (function(){
	return {
		doPost: function(settings){
			this.settings = settings;
			var formData = this.settings.element.serializeAll();
			var _this = this;
			var buttonRef = this.settings.buttonRef;
			$(buttonRef).attr("disabled", "disabled");
			$.ajax({
				type: "POST",
				url: this.settings.url,
				datatype: 'json',
				data: formData,
				success: function(data, textStatus, jqXHR) {
					_this.readResponse(data);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$(buttonRef).removeAttr("disabled");
					$('.submit-indicator').remove();
					$(buttonRef).unbind();
				}
			});
		},
		readResponse: function(data) {
			var buttonRef = this.settings.buttonRef;
			$(buttonRef).removeAttr("disabled");
			try {
				var data = JSON.parse(data);
				$('body').find('.error-message').remove();
				if(data.error != 1) {
					this.settings.callback(data.message);
				} else {
					$('.submit-indicator').remove();
					this.addValidation(data);
					var selec = this.settings.element.selector;
					var scrollpage = $(selec).attr('scrollpage');
					var showerrorflash = $(selec).attr('showerrorflash');
					var displayErrorFlash = scrollPageTop = true;
					if(showerrorflash !=undefined && showerrorflash=='0') {
						displayErrorFlash = false;
					}
					if(scrollpage !=undefined && scrollpage=='0') {
						scrollPageTop = false;
					}
					var buttonRefId = $(buttonRef).attr('id');
					if(scrollPageTop) {
						var toppos = $($(selec).find('.error-message')).offset().top - 50;
						if(toppos < 0) {
							toppos = 0;
						}
						if(self==top) {
							if($('.modal #'+buttonRefId).length) {
								$("html, body .modal").animate({ scrollTop: toppos }, "slow");
							} else {
								$("html, body").animate({ scrollTop: toppos }, "slow");
							}
						} else {
							$(parent.window).scrollTop(toppos);
						}
					}
				}
			} catch(e) {
				this.settings.callback('error');
			}
		},
		addValidation: function(data) {
			var _this   = this;
			var selec = this.settings.element.selector;
			if(data.data) {
				$.each(data.data, function(model, fields) {
					if(fields) {
						$.each(fields, function(field, message) {
							var inputField = field;
							var inputMessage = message;
							if(jQuery.type(message) == 'object') {
								$.each(message, function(f1, m1) {
									inputField = field;
									inputMessage = m1;
									if(jQuery.type(m1) == 'object') {
										$.each(m1, function(f2, m2) {
											inputField = field+'-'+f1;
											inputMessage = m2;
											if(jQuery.type(m2) == 'object') {
												$.each(m2, function(f3, m3) {
													inputField = field+'-'+f1+'-'+f2;
													inputMessage = m3;
													_this.addErrorMessage(_this, model, inputField, inputMessage);
												});
											} else {
												_this.addErrorMessage(_this, model, inputField, inputMessage);
											}
										});
									} else {
										_this.addErrorMessage(_this, model, inputField, inputMessage);
									}
								});
							} else {
								_this.addErrorMessage(_this, model, inputField, inputMessage);
							}
						});
					}
				});
			}
		},
		addErrorMessage: function(_this, model, field, message) {
			var selec = _this.settings.element.selector;
			var inputId = selec+' #' + _this.createCakeId(model+'-'+field);
			if(!$(inputId).length) {
				if($(inputId+'-').length) {
					inputId = inputId+'-';
				}
			}
			var element = $('<div>' + message + '</div>')
							.attr({
								'class' : 'error-message'
							})
							.css ({
								display: 'none'
							});
			var errorId = $(inputId).attr('errorId');
			if(errorId == undefined) {
				if($(inputId).css('display') == 'none') {
					// check for chosen, ckeditor element
					var chosedId = selec+' #' + _this.createChosenId(model+'_'+field);
					var ckeditorId = selec+' #' + _this.createCkeditorId(model+'-'+field);
					if($(chosedId).length) {
						$(chosedId).after(element);
					} else if($(ckeditorId).length) {
						$(ckeditorId).after(element);
					} else {
						$(inputId).after(element);
					}
				} else {
					$(inputId).after(element);
				}
			} else {
				$('#'+errorId).html('<span class="error-message">'+message+'</span>');
			}
			$(element).fadeIn();
		},
		createCakeId: function(string) {
			string = string.toLowerCase();
			string = string.replace(/_/g, '-');
			string = string.replace(/ /g, '-');
			return string;
		},
		createChosenId: function(string) {
			string = string.toLowerCase();
			string = string.replace(/-/g, '_');
			string = string.replace(/ /g, '_');
			return string+'_chosen';
		},
		createCkeditorId: function(string) {
			string = string.toLowerCase();
			string = string.replace(/_/g, '-');
			string = string.replace(/ /g, '-');
			return 'cke_'+string;
		}
	};
});
(function($) {
	$.fn.serializeAll = function() {
		var rselectTextarea = /^(?:select|textarea)/i;
		var rinput = /^(?:color|date|datetime|datetime-local|email|file|hidden|month|number|password|range|search|tel|text|time|url|week)$/i;
		var rCRLF = /\r?\n/g;

		var arr = this.map(function(){
			var elmt = this.elements ? jQuery.makeArray( this.elements ) : this;
			return elmt;
		})
		.filter(function(){
			return this.name && !this.disabled && (this.checked || rselectTextarea.test(this.nodeName) || rinput.test(this.type ));
		})
		.map(function( i, elem ){
			var val = jQuery( this ).val();
			var defaultValue = jQuery( this ).attr('default');
			if(defaultValue !=undefined && defaultValue==val) {
				val ='';
			}
			var defaultValue = jQuery( this ).attr('placeholder');
			if(defaultValue !=undefined && defaultValue==val) {
				val ='';
			}
			if(typeof tinyMCE != 'undefined') {
				var inputId = jQuery( this ).attr('id');
				if(inputId !=undefined && tinyMCE.get(inputId)) {
					val =tinyMCE.get(inputId).getContent();
				}
			}
			if(typeof CKEDITOR != 'undefined') {
				var inputId = jQuery( this ).attr('id');
				if(inputId !=undefined && CKEDITOR.instances[inputId]) {
					val =CKEDITOR.instances[inputId].getData();
				}
			}
			if(this.type=='file') {
				elemName = elem.name+'[name]';
				val = (val==null) ? null : jQuery.isArray( val ) ?
												jQuery.map( val, function( val, i ){
													return { name: elemName, value: val.replace( rCRLF, "\r\n" ) };
												}) :
												{ name: elemName, value: val.replace( rCRLF, "\r\n" ) };
			} else {
				val = (val==null) ? null : jQuery.isArray( val ) ?
												jQuery.map( val, function( val, i ){
													return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
												}) :
												{ name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
			}
			return val;
		}).get();
		return $.param(arr);
	}
})(jQuery);