jQuery(document).ready(function() {
	jQuery('.email').each(function(index) {
		var s = jQuery(this).text().replace(" [at] ", "&#64;");
		jQuery(this).html("<a href=\"mailto:" + s + "\">" + s + "</a>");
	});
	
	resize_full_div();
});

jQuery(window).bind("resize", function() {
	resize_full_div();
});


function resize_full_div() {
	jQuery('.full_div_center').each(function() {
		var div = jQuery("#" + this.id);
		
		var current_position 	= div.offset();
		var current_left 		= current_position.left;
		var div_w				= 1280;
		var window_w			= jQuery(window).outerWidth();
		
		if(window_w < div_w) {
			var final_left = "-" + Math.round((div_w - window_w) / 2) + "px";
		} else {
			var final_left = "auto";
		}
		
		//jQuery("#test").html(current_left + '_' + window_w + '_' + div_w + '=' + final_left);
		
		div.css("margin-left", final_left);
	});
}