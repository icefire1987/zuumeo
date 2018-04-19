var slideshow_current = 1;
var slideshow_next = 2;
var autoslideshow = 1; 

function autoSlideshow(slideshow_id, intervall) {
	moveSlideshow(slideshow_id, 'next');
	
	var slideshow_amount = jQuery("#gallery_amount_" + slideshow_id).val();
	
	if(slideshow_amount > 1 && autoslideshow == 1) {
		if(slideshow_current == slideshow_amount) {
			slideshow_current = 1;
			slideshow_next = 2;
		
		} else {
			slideshow_current++;
			
			if(slideshow_next == slideshow_amount) {
				slideshow_next = 1;
			} else {
				slideshow_next++;
			}
		}
		
		//jQuery("#slideshow_test").html('ID: ' + slideshow_id + '<br>AMOUNT: ' + slideshow_amount + '<br>CURRENT: ' + slideshow_current);
		
		window.setTimeout("autoSlideshow(" + slideshow_id + ", " + intervall + ")", intervall);
	}
}