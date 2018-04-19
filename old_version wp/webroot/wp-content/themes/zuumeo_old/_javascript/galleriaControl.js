var current_galleria = 0;

function galleriaControl(id, nr, type) {
	var g = $('#galleria_' + id).data('galleria');
	
	if(type == "prev") {
		g.prev();
	
	} else if(type == "next") {
		g.next();
	
	} else {
		if(current_galleria != nr) {
			g.show(nr);	
		}
	}
	
	current_galleria = g.getIndex();
}