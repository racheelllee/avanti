jQuery(document).ready(function($){
	// Date picker
	$(document).on("focus", ".datepicker", function() {
		$(this).datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true
		});
	});
	$(document).on("focus", ".datetimepicker", function() {
		$(this).datetimepicker({
			format: 'yyyy-mm-dd hh:ii:ss',
			autoclose: true,
			showMeridian: true
		});
	});
	// adding title to links in table header
	$(document).on("mouseenter", "table tr th a", function() {
		$(this).attr('title', 'Click to sort records');
	});  
	var per_float_div = $('#per_float_header');
	$('#per_loading_text').html('');
	$('#per_loading_text').css('display','none');
	if(per_float_div.length) {
		var start = $(per_float_div).offset().top;
		$.event.add(window, "scroll", function() {
			var p = $(window).scrollTop();
			$(per_float_div).css('position',((p)>start) ? 'fixed' : 'static');
			$(per_float_div).css('top',((p)>start) ? '0px' : '');
		});
	}
	$(document).on('click', '.closeMsg', function(){
		$(this).closest('.messageHolder').remove();
	});
	$(document).on('click', '.groupMatrix .changePermission', function(e){
		e.preventDefault();
		var pelem = $(this).closest('.permission');
		var url = $(this).attr('href');
		var self = this;
		$(this).html('<img alt="" src="'+urlForJs+'usermgmt/img/loading-circle.gif">');
		$.ajax({
			async : true,
			data : '',
			dataType : 'html',
			success : function (data, textStatus) {
				$(self).html(data);
				$(pelem).find('.permissionType').html('');
			},
			type : 'POST',
			url : url
		});
		return false;
	});
});