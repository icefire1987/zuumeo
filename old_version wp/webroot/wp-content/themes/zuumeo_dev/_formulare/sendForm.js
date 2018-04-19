var sendstatus = 0;

function sendForm(args) {
	var id 			= args['id'];
	var error 		= 0;	
	
	
	//GET different fields
	var mandatory_fields = jQuery.trim(jQuery("#form_" + id + " #mandatory_fields").val()).split(",");
	var email_fields = jQuery.trim(jQuery("#form_" + id + " #email_fields").val()).split(",");
	var all_fields = jQuery.trim(jQuery("#form_" + id + " #all_fields").val()).split(",");
	var submit_pending = jQuery.trim(jQuery("#form_" + id + " #submit_pending").val());
	var submit_done = jQuery.trim(jQuery("#form_" + id + " #submit_done").val());
	var form_path = jQuery.trim(jQuery("#form_path").val());
	
	
	//CHECK pflichtfelder
	if(mandatory_fields != "") {
		for(var i=0; i<mandatory_fields.length; i++) {
			var mandatory_field_value = jQuery.trim(jQuery('#value_' + id + '_' + mandatory_fields[i]).val());
			
			if(mandatory_field_value == "" && sendstatus != 2) {
				error = 2;
				
				var th = "#th_" + id + "_" + mandatory_fields[i];
				var td = "#td_" + id + "_" + mandatory_fields[i];
				
				blink(th);
				blink(td);
			}
		}
	}
	
	
	//CHECK mail-sytax(es)
	if(email_fields != "") {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		
		for(var i=0; i<email_fields.length; i++) {
			var email_field_value = jQuery.trim(jQuery('#value_' + id + '_' + email_fields[i]).val());
			
			/* alert(email_field_value); */
			
			if(reg.test(email_field_value) == false && sendstatus != 2) {
				error = 3;
				blink("#th_" + id + "_" + email_fields[i]);
				blink("#td_" + id + "_" + email_fields[i]);
			}
		}
	}
	
	
	
	
	if(sendstatus == 1) {
	  error = 1;
	  blink("#submit_" + id);
	  /* alert("Ihre Anfrage wird gerade gesendet"); */
	  
	} else if(sendstatus == 2) {
	  error = 1;
	  blink("#submit_" + id);
	  /* alert("Ihre Anfrage wird wurde bereits gesendet"); */
	}
	
	//alert('id:' + id + '\nmandatory_fields:' + mandatory_fields + '\nemail_fields:' + email_fields + '\nall_fields:' + all_fields + '\nerror:' + error);
	
	
	if(error == 0) {
		sendstatus = 1;
		
		var submit_text = jQuery("#submit_" + id).text();
		
		jQuery("#submit_" + id).text(submit_pending);
		
		var all_fields = jQuery.trim(jQuery("#form_" + id + " #all_fields").val()).split(",");
		
		var ajax_values = '';
		for(var i=0; i<all_fields.length; i++) {
			var all_field_type = jQuery.trim(jQuery("#fieldtype_" + id + "_" + all_fields[i]).val());
			
			var all_field_value = jQuery.trim(jQuery("#value_" + id + "_" + all_fields[i]).val());
			//var all_field_value = all_field_value.split("@").join("[at]");
			
			ajax_values += "&value_" + all_fields[i] + "=" + escape(all_field_value);
		}
		
		var data = "ajax=1&send_form=1&all_fields=" + all_fields + "&id=" + id + ajax_values;
		var url = form_path + "/sendForm.php";
		
		//alert(url + '_' + data);
		
		var output = '';
		jQuery.ajax({
		    url: url,
		    type: "POST",
		    data: data,
		    evalScripts: true,
		    
		    success: function(responses, status, xhr) {
			    //alert(responses);
			    //$("#form_test").html(responses);
			    
			    if(status == "success") {
					var response 	= responses.split("|||");
					
					//alert(responses);
					
					if(response[1] == 1) {
			    		sendstatus = 2;
			    		jQuery("#submit_" + id).text(submit_done);
			    	
			    		blink("#submit_" + id);
			    	
			    		for(var i=0; i<all_fields.length; i++) {
				    		//jQuery("#value_" + id + "_" + all_fields[i]).val("");
				    	}
				    
				    }
				}
			}
		});
	}
	
	return false;
}