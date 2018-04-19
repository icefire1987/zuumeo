var tooltip_position = 'right';

function tooltip(args) {
	div = jQuery("<div id='tooltip'>");
	jQuery("#tooltip").remove();
	
	//alert(args);
	
	if(args['image']) {
		var tooltip_content = '<img src="' + args['content'] + '" style="max-width:300px; max-height:300px;" />';
	
	} else {
		var tooltip_content = '<div class="tooltip_text">' + args['content'] + '</div>';
	}
	
	if(args['w']) {
		div.css('width', args['w'] + 'px');
	}
	
	if(args['h']) {
		div.css('height', args['h'] + 'px');
	}
	
	if(args['position']) {
		tooltip_position = args['position'];
	}
	
	div.html(tooltip_content);
	jQuery("body").prepend(div);
}

function tooltip_move() {
	div = jQuery("<div id='tooltip'>");
	
	if(tooltip_position == 'right') {
		var new_left = Math.round(mouseX + 20);
		var new_top = Math.round(mouseY - (jQuery("#tooltip").outerHeight()/2));
	
	} if(tooltip_position == 'top') {
		var new_left = Math.round(mouseX - (jQuery("#tooltip").outerWidth()/2));
		var new_top = Math.round(mouseY - (jQuery("#tooltip").outerHeight()) - 25);
	
	}
	
	
	jQuery("#tooltip").css("left", new_left + "px");
	jQuery("#tooltip").css("top", new_top + "px");
}



function tooltip_off() {
	jQuery("#tooltip").remove();
}


var mouseX = 0;
var mouseY = 0;

jQuery(document).mousemove( function(e) {
	mouseX = e.pageX; 
	mouseY = e.pageY;
	
	//debug2(mouseY);
});