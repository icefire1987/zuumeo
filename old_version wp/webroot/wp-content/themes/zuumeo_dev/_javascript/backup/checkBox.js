function checkbox(id) {
	var status = jQuery("#checkbox_" + id).attr('checked');
	
	if(status == undefined) {
		jQuery("#checkbox_" + id).prop('checked', true);
		jQuery("#checkbox_vis_" + id).addClass("checkbox_checked");
		
	} else {
		jQuery("#checkbox_" + id).prop('checked', false);
		jQuery("#checkbox_vis_" + id).removeClass("checkbox_checked");
	}
}