var current_showreel = 0;

function moveShowreel(args) {
	$("#showreel").css("height", $("#showreel").height() + "px");
	
	var direction = args['direction'];
	
	var showreel_w 			= $(".showreel_content").outerWidth() + parseInt($(".showreel_content").css("margin-right"));
	var showreel_count 		= $("#showreel_count").val();
	var showreel_columns 	= $("#showreel_columns").val();
	var showreel_first_left = parseInt($("#showreel_first_left").val());
	
	
	
	if(direction == 'right') {
		if(current_showreel < showreel_count-showreel_columns) {
			++current_showreel;
		}
	
	} else {
		if(current_showreel > 0) {
			--current_showreel;
		}
	}
	
	var test = 'current_showreel:' + current_showreel + '<br>showreel_w:' + showreel_w + '<br>showreel_count:' + showreel_count + '<br>showreel_columns:' + showreel_columns + '<br>showreel_first_left:' + showreel_first_left;
	
	if(current_showreel >= 0 && current_showreel <= showreel_count-showreel_columns) {
		if(showreel_count > showreel_columns) {
			if(current_showreel == 0) {
				$("#showreel_left").addClass("showreel_arrow_inactive");
			} else {
				$("#showreel_left").removeClass("showreel_arrow_inactive");
			}
			
			if(current_showreel == showreel_count-showreel_columns) {
				$("#showreel_right").addClass("showreel_arrow_inactive");
			} else {
				$("#showreel_right").removeClass("showreel_arrow_inactive");
			}
		}
		
		for(var i=0; i<showreel_count; i++) {
		  	var new_pos = 0 - (current_showreel * showreel_w) + showreel_first_left;
		  	
		  	test += '<br>' + i + ':' + new_pos;
		  	
		  	jQuery("#showreel_" + i).animate({
		  		left: new_pos + "px",
		  	}, {
		  		duration: 700,
		  		easing: 'easeOutQuart',
		  	});
		  	
		  	if(i < current_showreel) {
		  		$("#showreel_" + i).fadeTo(500, 0.00001);
		  	
		  	} else if(i < current_showreel+showreel_columns) {
		  		$("#showreel_" + i).fadeTo(500, 1);
		  		
		  	} else {
		  		$("#showreel_" + i).fadeTo(500, 0.00001);
		  	}
		}
	}
	
	
	//$("#test").html(test);
}