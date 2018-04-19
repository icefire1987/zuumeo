var mouseX = 0;
var mouseY = 0;

jQuery(document).mousemove( function(e) {
	mouseX = e.pageX; 
	mouseY = e.pageY;
	
	//debug2(mouseY);
});