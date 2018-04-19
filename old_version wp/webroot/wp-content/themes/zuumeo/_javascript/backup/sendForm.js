var sendstatus = 0;

function sendForm(id) {
	var error = 0;
	
	var form_id = jQuery.trim(jQuery("#contactform_" + id + "_id").val());
	
	var mandatory_fields = jQuery.trim(jQuery("#contactform_" + id + "_mandatory_fields").val()).split(",");
	
	for(var i=0; i<mandatory_fields.length; i++) {
		var mandatory_field_value = jQuery.trim(jQuery("#value_" + id + "_" + mandatory_fields[i]).val());
		
		if(mandatory_field_value == "") {
			error = 1;
			blink("#td_" + id + "_" + mandatory_fields[i]);
		}
	}
	
	
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	var email_fields = jQuery.trim(jQuery("#contactform_" + id + "_email_fields").val()).split(",");
	
	for(var i=0; i<email_fields.length; i++) {
		var email_field_value = jQuery.trim(jQuery("#value_" + id + "_" + email_fields[i]).val());
		
		/* alert(email_field_value); */
		
		if(reg.test(email_field_value) == false) {
			error = 1;
			blink("#td_" + id + "_" + email_fields[i]);
		}
	}
	
	
	var elem_datenschutz = jQuery("#checkbox_" + id + "_datenschutz");
	
	if(elem_datenschutz) {
		var datenschutz = elem_datenschutz.attr('checked');
	
		if(datenschutz != "checked") {
			error = 1;
			blink("#td_" + id + "_datenschutz");
		}
	}
	
	if(sendstatus == 1) {
		error = 1;
		alert("Ihre Anfrage wird gerade gesendet");
	}
	
	
	if(error != 1) {
		sendstatus = 1;
		
		var submit_text = jQuery("#submit_" + id + " a").text();
		
		jQuery("#submit_" + id + " a").text("wird gesendet ...");
		
		var all_fields = jQuery.trim(jQuery("#contactform_" + id + "_all_fields").val()).split(",");
	
		var ajax_values = '';
		for(var i=0; i<all_fields.length; i++) {
			var all_field_value = jQuery.trim(jQuery("#value_" + id + "_" + all_fields[i]).val());
			//var all_field_value = all_field_value.split("@").join("[at]");
			
			ajax_values += "&" + all_fields[i] + "=" + escape(all_field_value);
		}
		
		var data = "ajax=1&id=" + id + "&form_id=" + form_id + ajax_values;
		/* alert(data); */
		
		jQuery.ajax({
			url: "/wp-content/themes/weinbewusstsein/send-contactform.php",
			type: "POST",
			data: data,
			evalScripts: true,
			
			success: function(responses) {
				/* alert(1); */
				
			},
			
			complete: function(){
				/* alert(2); */
				
				sendstatus = 0;
				
				jQuery("#submit_" + id + " a").text("Ihre Anfrage wurde verschickt");
				
				for(var i=0; i<all_fields.length; i++) {
					jQuery("#value_" + id + "_" + all_fields[i]).val("");
				}
			}
		});
		
		
		//jQuery("#" + id).submit();
	}
}