var current_thumb_nr = 1;
var next_thumb_nr = 0;
var last_thumb_nr = 0;
var slideshow_status = 1;

function moveSlideshow(slideshow_id,direction) {
	if(slideshow_status == 1) {
		var speed = 600;
		
		
		slideshow_status = 0;
		jQuery(".slideshow-control").fadeTo(speed/2, 0.1);
		
		var amount = jQuery("#gallery_amount_" + slideshow_id).val();
		
		if(direction == 'next') {
			if(current_thumb_nr == amount) {
				next_thumb_nr = 1;
			
			} else {
				next_thumb_nr = current_thumb_nr + 1;
			}
		
		} else {
			if(current_thumb_nr == 1) {
				next_thumb_nr = amount;
			
			} else {
				next_thumb_nr = current_thumb_nr - 1;
			}
			
		}
		
		//!move current to the left
		var w = jQuery("#gallery_" + slideshow_id).outerWidth();
		var final_left_current = w;
		var final_left_next = '-' + w;
			
		if(direction == 'next') {
			final_left_current = '-' + w;
			final_left_next = w;
		}
		
		jQuery("#gallery_" + slideshow_id + '_' + current_thumb_nr).animate({'left': + final_left_current + 'px'}, speed, function(){
			slideshow_status = 1;
			jQuery(".slideshow-control").fadeTo(speed/2, 1.0);
		});
		jQuery("#gallery_" + slideshow_id + '_' + next_thumb_nr).css({'left': final_left_next +'px'});
		
		jQuery("#gallery_" + slideshow_id + '_' + next_thumb_nr).animate({'left':'0px'}, speed);
		
		jQuery(".slideshow-bar-button").removeClass("slideshow-bar-button-on");
		jQuery(".slideshow-bar-button").addClass("slideshow-bar-button-off");
		jQuery("#button_" + slideshow_id + "_" + next_thumb_nr).removeClass("slideshow-bar-button-off");
		jQuery("#button_" + slideshow_id + "_" + next_thumb_nr).addClass("slideshow-bar-button-on");
		
		//jQuery("#admin").html('width:' + w + '<br>current_thumb_nr:' + current_thumb_nr + '<br>next_thumb_nr:' + next_thumb_nr + '<br>amount:' + amount + '<br>width:' + w + '<br>')
		
		current_thumb_nr = next_thumb_nr;	
	}
}