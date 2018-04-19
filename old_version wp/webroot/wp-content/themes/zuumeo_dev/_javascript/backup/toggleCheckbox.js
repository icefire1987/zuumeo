function toggleCheckbox(id) {
	var current_checkbox_value = jQuery("#checkbox_" + id).attr('checked');
	
	if(current_checkbox_value == "checked") {
		jQuery("#click_checkbox_" + id).removeClass("checkbox_checked");
		jQuery("#click_checkbox_" + id).addClass("checkbox_unchecked");
		jQuery("#checkbox_" + id).attr('checked', false);
		
		if(jQuery("#value_" + id)) {
			jQuery("#value_" + id).val(0);
		}
		
	} else {
		jQuery("#click_checkbox_" + id).removeClass("checkbox_unchecked");
		jQuery("#click_checkbox_" + id).addClass("checkbox_checked");
		jQuery("#checkbox_" + id).attr('checked', true);
		
		if(jQuery("#value_" + id)) {
			jQuery("#value_" + id).val(1);
		}
	}
	
	/* alert(current_checkbox_value); */
}