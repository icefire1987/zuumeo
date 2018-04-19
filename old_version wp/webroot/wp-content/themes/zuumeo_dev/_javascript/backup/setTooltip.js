function setTooltip(text) {
	removeTooltip();
	
	jQuery("#tooltip_content").html(text);
	
	setTooltipPosition();
	
	jQuery("#tooltip").show();
}

function setTooltipPosition() {
	var w_tooltip 			= jQuery("#tooltip").outerWidth();
	var h_tooltip 			= jQuery("#tooltip").outerHeight();
	
	var w_browser			= jQuery(document).width();
	var h_browser			= jQuery(document).height();
	
	var w_offset			= jQuery("#content_noise").offset().left;
	var h_offset			= jQuery("#content_noise").offset().top;
	
	var w_wrapper 			= jQuery("#wrapper-inner").innerWidth();
	if(w_wrapper > w_browser) {
		w_wrapper = w_browser;
	}
	
	var w_wrapper_real	= Math.round(w_browser - ((w_browser-w_wrapper)/2));
	
	var w_overflow 		= w_wrapper_real - mouseX;
	var h_overflow 		= h_browser - mouseY;
	
	if(w_overflow >= (w_tooltip + 20)) {
		var left = Math.round(mouseX - w_offset + 20);
		var tooltip_class = "tooltip_left";
	
	} else {
		var left = Math.round(mouseX - w_tooltip - w_offset - 20);
		var tooltip_class = "tooltip_right";
	}
	
	
	if(h_overflow >= (h_tooltip)) {
		var top = Math.round(mouseY - 20 - h_offset);
	
	} else {
		var top = Math.round(mouseY - h_tooltip - h_offset);
	}
	
	
	var text = '2mouseX: ' + mouseX + '<br>mouseY: ' + mouseY + '<br>w_browser: ' + w_browser + '<br>h_browser: ' + h_browser + '<br>w_offset: ' + w_offset + '<br>h_offset: ' + h_offset + '<br>w_wrapper: ' + w_wrapper + '<br>w_wrapper_real: ' + w_wrapper_real + '<br>w_overflow: ' + w_overflow + '<br>w_tooltip: ' + w_tooltip + '<br>h_tooltip: ' + h_tooltip + '<br>left: ' + left + '<br>top: ' + top;
	
	//jQuery("#admin").html(text);
	
	
	jQuery("#tooltip").removeClass("tooltip_left");
	jQuery("#tooltip").removeClass("tooltip_right");
	jQuery("#tooltip").addClass(tooltip_class);
	
	jQuery("#tooltip").css("left", (left) + "px");
	jQuery("#tooltip").css("top", (top) + "px");
	
	
}

function removeTooltip() {
	jQuery("#tooltip").hide();
}