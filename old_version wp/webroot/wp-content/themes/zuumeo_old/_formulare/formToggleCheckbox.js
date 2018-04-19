function formToggleCheckbox(id) {
	var current_value = jQuery("#value_" + id).val();
	
	if(current_value == 0) {
		jQuery("#value_" + id).val(1);
		jQuery("#checkbox_" + id).attr("src", jQuery("#form_gfx_checkbox_1").val());
		
	} else {
		jQuery("#value_" + id).val(0);
		jQuery("#checkbox_" + id).attr("src", jQuery("#form_gfx_checkbox_0").val());
	}
	
	/* alert(id + '_' + current_value); */
}