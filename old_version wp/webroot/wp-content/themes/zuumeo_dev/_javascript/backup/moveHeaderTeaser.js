function moveHeaderTeaser(){
	/* header_teaser_current = 0; */
	/* header_teaser_amount = 3; */
	
	jQuery(".header_teaser_block").fadeOut(header_teaser_fade_duration);
	jQuery(".header_teaser_nav_marker").removeClass("header_teaser_nav_marker_selected");
	
	if(header_teaser_current < header_teaser_amount) {
		var next = header_teaser_current + 1;
		
	} else {
		var next = 0;
	}
	
	header_teaser_current = next;
	
	jQuery("#header_teaser_" + next).fadeIn(header_teaser_fade_duration);
	jQuery("#header_teaser_marker_" + next).addClass("header_teaser_nav_marker_selected");
	
	window.setTimeout("moveHeaderTeaser()", header_teaser_interval);
}