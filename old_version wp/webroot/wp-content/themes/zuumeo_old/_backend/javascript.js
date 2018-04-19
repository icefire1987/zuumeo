var w_editor = 550;

function admin_toggle_post_status(post_id) {
	var script = get_theme() + "/_backend/ajaxTogglePostStatus.php";
	var data = "ajax=1&data_edit_post_status=1&post_id=" + post_id;
	/* alert(script + '____' + data); */
	
	var btn = jQuery("#admin_frontpage_option_post_status");
	
	btn.fadeTo(500, 0.3);
	
	jQuery.ajax({
		url: script,
	    type: "POST",
	    data: data,
	    evalScripts: true,
	    success: function(responses, status, xhr) {
	    	if(status == "success") {
	    		//alert(responses);
	    		
	    		var response 		= responses.split("|||");
	    		
	    		var new_post_status 	= response[0];
	    		
	    		btn.removeClass("admin_frontpage_option_post_status_publish");
	    		btn.removeClass("admin_frontpage_option_post_status_draft");
	    		btn.addClass("admin_frontpage_option_post_status_" + new_post_status);
	    		btn.fadeTo(500, 1.0);
	    	}	
	    }
	});
}


function admin_update_post_modified(args) {
	var post_id 	= args['post_id'];
	var cache 		= args['cache'];
	
	var script = "ajaxUpdatePostModified.php";
	var data = "ajax=1&data_edit_post_modified=1&post_id=" + post_id + "&cache=" + encodeURIComponent(cache);
	/* alert(script + '____' + data); */
	
	jQuery.ajax({
		url: script,
	    type: "POST",
	    data: data,
	    evalScripts: true,
	    success: function(responses, status, xhr) {
	    	if(status == "success") {
	    		//alert(responses);
	    		//var response 		= responses.split("|||");
	    		
	    		if(jQuery("#admin_dashboard_cache_" + post_id)) {
		    	   jQuery("#admin_dashboard_cache_" + post_id).hide();
	    		}
	    		
	    		hide_reset_cache(post_id);
	    	}	
	    }
	});
}

var cancel_cache = 0;

function admin_cancel_cache(post_type) {
	cancel_cache = 1;
	
	jQuery(".button_cancel_cache").hide();
	jQuery(".cache_info").hide().html("");
	jQuery("#cache_" + post_type + "_progress").css("width", "0%");
	jQuery("#cache_" + post_type + "_count").html("0");
}

var cache_ids = "";
var current_cache_id = 0;

function admin_create_cache(args) {
	jQuery(".button_cancel_cache").hide();
	jQuery(".cache_info").hide().html("");
	
	cancel_cache 		= 0;
	var post_type 		= args['post_type'];
	var posts_per_page 	= args['posts_per_page'];
	var ids 			= args['ids'];
	
	if(jQuery("#button_cancel_cache_" + post_type)) {
	    jQuery("#button_cancel_cache_" + post_type).show();
	}
		
	if(ids != "") {
		cache_ids = ids;
		admin_create_cache_progress({ post_type: post_type });
	
	} else {
		var url 	= get_theme() + "/_backend/ajaxGetPosts.php";
		var data 	= "ajax=1&get_posts=1&post_type=" + post_type + "&cache_only=1&posts_per_page=" + posts_per_page;
		//alert(url + '?' + data);
	
		jQuery.ajax({
			url: url,
		    type: "POST",
		    data: data,
		    dataType: "html", 
		    evalScripts: true,
		    success: function(responses, status, xhr) {
		    	if(status == "success") {
		    		//alert(responses);
		    		var response = responses.split("|||");
		    		
					cache_ids = response[1];
					
		    		admin_create_cache_progress({ post_type: post_type });
		    	}	
		    }
		});
	}
}


function admin_delete_cache(args) {
	var id 			= args['id'];
	
	var url 	= get_theme() + "/_backend/ajaxDeleteCache.php";
	var data 	= "ajax=1&delete_cache=1&id=" + id;
	//alert(url + '?' + data);
	
	jQuery.ajax({
	    url: url,
	    type: "POST",
	    data: data,
	    dataType: "html", 
	    evalScripts: true,
	    success: function(responses, status, xhr) {
	    	if(status == "success") {
	    		var response = responses.split("|||");
	    		
	    		alert("Cache dieser Seite entfernt");
	    		
	    	} else {
		    	alert("Cache Löschen fehlgeschlagen");
	    	}
	    }
	});
}


function admin_create_cache_progress(args) {
	var ids		 	= cache_ids.split(",");
	var post_type 	= args['post_type'];
	
	var url 	= get_theme() + "/_backend/ajaxCreateCache.php";
	var data 	= "ajax=1&create_cache=1&ids=" + ids[current_cache_id];
	//alert(url + '?' + data);
	
	jQuery.ajax({
	    url: url,
	    type: "POST",
	    data: data,
	    dataType: "html", 
	    evalScripts: true,
	    success: function(responses, status, xhr) {
	    	if(status == "success") {
	    		//alert(responses);
	    		var response 		= responses.split("|||");
	    		
	    		var cache_amount	= response[0];
	    		var cache_urls		= response[1].replace(/###/g, "\n");;
	    		
	    		if(args['alert']) {
	        		alert("cached Files: " + cache_amount + "\n\n" + cache_urls);
	        	}
	    		
	    		++current_cache_id;
	    		
	    		if(cancel_cache == 0) {
	    		    if(jQuery("#cache_" + post_type + "_progress")) {
	    		        var percent = Math.round((100/ids.length) * current_cache_id);
	    		        
	    		        jQuery("#cache_" + post_type + "_progress").css("width", percent + "%");
	    		        jQuery("#cache_" + post_type + "_count").html(current_cache_id + "/" + ids.length);
	    		    }
	    		
	    		    jQuery("#cache_" + post_type + "_info").prepend(current_cache_id + ') ID ' + ids[current_cache_id-1] + ' &nbsp;/&nbsp; ' + cache_urls + '<br>').show();
	    		
				    if(ids.length == current_cache_id) {
	    		    	current_cache_id = 0;
						cancel_cache = 1;
					
					} else {
						admin_create_cache_progress({ post_type: post_type });
					}
	    		}
	    	}	
	    }
	});
}

function data_edit_loading() {
	//var editor = jQuery("#admin_frontpage_edit");
	//
	//editor.html('<div class="right"><img src="' + jQuery("#theme_path").val() + '/_backend/_images/loading.png" /></div>');
}

function ind_fp_editor_resize(obj) {
	var editor 			= jQuery("#admin_frontpage_edit");
	var editor_footer 	= jQuery("#ind_fp_editor_footer");
	var editor_resizer 	= jQuery("#ind_fp_editor_resizer");
	var editor_options 	= jQuery("#admin_frontpage_options");
	
	var new_x = parseInt(obj.css("left"));
	
	if(new_x < 300) { 
		new_x = 300; 
	}
	
	w_editor = new_x;
	
	editor
	.width(new_x)
	.css("marginRight", "-" + new_x + "px");
	
	editor_footer
	.width(new_x);
	
	editor_resizer
	.css("left", new_x + "px");
	
	editor_options
	.css("left", (new_x + 10) + "px");
	
	jQuery("#admin_frontpage_edit table.mceLayout").width("100%");
}

function data_edit_show() {
	var editor 			= jQuery("#admin_frontpage_edit");
	var editor_footer 	= jQuery("#ind_fp_editor_footer");
	var editor_resizer 	= jQuery("#ind_fp_editor_resizer");
	var editor_options 	= jQuery("#admin_frontpage_options");
	
	editor
	.width(w_editor)
	.show()
	.animate({
	    marginRight: "-" + w_editor + "px"
	}, 400);
	
	jQuery("#admin_frontpage_edit table.mceLayout").width("100%");
	
	editor_resizer
	.show()
	.animate({
	    left: w_editor + "px"
	}, 400);
	
	editor_footer
	.css("left", "-" + (w_editor+20) + "px")
	.width(w_editor)
	.show()
	/* .scrollTop() */
	.animate({
	    left: "0px"
	}, 400);
	
	editor_options
	.animate({
	    left: (w_editor + 10) + "px"
	}, 400);
}

function data_edit_close() {
	var editor 			= jQuery("#admin_frontpage_edit");
	var editor_footer 	= jQuery("#ind_fp_editor_footer");
	var editor_options 	= jQuery("#admin_frontpage_options");
	
	//jQuery(".data_edit_default").html("Bearbeiten");
	//jQuery(".data_edit_columns").html("Spalten");
	//jQuery(".data_edit_column").html("Modul");
	
	editor
	.animate({
		marginRight: "20px"
	}, 400);
	
	editor_footer
	.show()
	/* .scrollTop() */
	.animate({
		left: "-" + (w_editor+20) + "px"
	}, 400);
	
	editor_options
	.animate({
		left: "10px"
	}, 400);
}

function get_theme() {
	//alert(theme);
	
	return "/wp-content/themes/" + theme;
}

function data_edit(i_data_edit) {
	data_edit_close();
	
	var editor 			= jQuery("#admin_frontpage_edit");
	var editor_footer 	= jQuery("#ind_fp_editor_footer");
	var options 		= jQuery("#admin_frontpage_options");
	
	var edit_button 	= jQuery("#data_edit_" + i_data_edit);
	var edit_content 	= jQuery("#data_" + i_data_edit);
	
	var post_id 		= edit_button.data("post_id");
	var field 			= edit_button.data("field");
	var module_type 	= edit_button.data("module-type");
	var type 			= edit_button.data("type");
	var number 			= edit_button.data("number");
	
	var script = get_theme() + "/_backend/ajaxCreateDataEdit.php";
	var data = "ajax=1&data_edit=1&i_data_edit=" + i_data_edit + "&post_id=" + post_id + "&field=" + field + "&number=" + number + "&module_type=" + module_type + "&type=" + type;
	//alert(script + '____' + data);
	
	jQuery.ajax({
	    url: script,
	    type: "POST",
	    data: data,
	    evalScripts: true,
	    success: function(responses, status, xhr) {
	    	if(status == "success") {
	    		//alert(responses);
	    		
	    		//edit_button.text("edit");
	    		//editor.width(600);
	    		
	    		var response 		= responses.split("|||");
	    		
	    		var editor_content 	= response[0];
	    		
	    		editor.html(editor_content);
	    		
	    		var data_fields 		= jQuery("#data_fields").val();
	    		var data_fields_arr 	= data_fields.split(",");
	    		var data_types 			= jQuery("#data_types").val();
	    		var data_types_arr 		= data_types.split(",");
	    		
	    		
	    		for(var i=0, len = data_fields_arr.length; i<len; i++) {
	    		    var data_field 		= data_fields_arr[i];
	    		    var data_type 		= data_types_arr[i];
	    		    
	    		    var data_field_id 	= 'data_edit_input_' + data_field;
	    		    
	    		    //alert(data_field_id + '___' + data_type);
	    		    
	    		    if(data_type == "wysiwyg") {
	    		    	//editor.width(680);
	    		    	tinyMCE.execCommand("mceAddControl", true, data_field_id);	    
	    		    }
	    		    
	    		    //alert(data_field + ' --> ' + data_type + ' --> ' + data_value);
	    		}
	    		
	    		data_edit_show();
	    	}	
	    }
	});
}


function data_edit_image_remove(args) {
	var field_id 			= args['field_id'];
	
	jQuery("#" + field_id).val("");
	jQuery("#file_" + field_id).hide();
	jQuery("#btn_reupload_" + field_id).hide();
    jQuery("#btn_delete_" + field_id).hide();
    
    jQuery("#img_hint_" + field_id).show();
}

function data_edit_images_remove(args) {
	var field_id = args['field_id'];
	var image_id = args['image_id'];
	
	//jQuery("#" + field_id).val("");
	jQuery("#images_" + field_id + " #image_" + image_id).remove();
	
	data_edit_images_set(field_id);
}

function data_edit_images_set(field_id) {
	var input = jQuery("#" + field_id).val();
	
	var ids = [];
	jQuery("#images_" + field_id).find("div.image_container").each(function(){ 
		var id = this.id.replace("image_", "");
		
		ids.push(id); 
	});
	
	jQuery("#" + field_id).val(ids);
}
	
function data_edit_image(args) {
	var field_id 		= args['field_id'];
	var type 			= args['type'];
	
	original_send = wp.media.editor.send.attachment;
	//alert(field_id);
	
	wp.media.editor.send.attachment = function( a, b) {
       //alert(b);
       //console.log(b); // b has all informations about the attachment
       
       	var new_image_id = b.id;
       	var new_image_url = b.url;
       	
       	//alert(new_image_url);
       	
       	if(type == 'image') {
	   			jQuery("#file_" + field_id).attr("src", new_image_url).show();
	   			jQuery("#" + field_id).val(new_image_id);
	   			jQuery("#btn_reupload_" + field_id).hide();
	   			jQuery("#btn_delete_" + field_id).show();
	   			jQuery("#img_hint_" + field_id).hide();   
       	
       	} else if(type == 'file') {
	   			jQuery("#file_" + field_id).text(new_image_url).show();
       	}
       
       	jQuery("#" + field_id).val(new_image_id);
   		jQuery("#btn_delete_" + field_id).show();
   		jQuery("#img_hint_" + field_id).hide();
    };
    
    //wp.media.send.to.editor will automatically trigger window.send_to_editor for backwards compatibility
    wp.media.editor.open("btn_upload_" + field_id);
}


function data_edit_images(args) {
	var field_id 			= args['field_id'];
	
	//original_send = wp.media.editor.send.attachment;
	//alert(field_id);
	
	
	wp.media.editor.send.attachment = function( a, b) {
       //alert(b);
       //console.log(b); // b has all informations about the attachment
       
       var new_image_id = b.id;
       var new_image_url = b.url;
       
       var img_preview = '<div class="image_container left relative null" id="image_' + new_image_id + '"><img src="' + new_image_url + '" class="shadow data_edit_image data_edit_images" /><div onclick="data_edit_images_remove({ field_id:\'' + field_id + '\', image_id:\'' + new_image_id + '\' });" class="absolute data_edit_image_delete hand shadow"></div></div>';
       
       jQuery("#images_" + field_id).append(img_preview);
       
       data_edit_images_set(field_id);
    };
    
    // wp.media.send.to.editor will automatically trigger window.send_to_editor for backwards compatibility

// 
	
	wp.media.editor.open("test");
}


function data_edit_save(i_data_edit) {
	var editor 					= jQuery("#admin_frontpage_edit");
								
	var edit_button 			= jQuery("#data_edit_" + i_data_edit);
	var edit_content 			= jQuery("#data_" + i_data_edit);
								
	var post_id 				= edit_button.data("post_id");
	var field 					= edit_button.data("field");
	var type 					= edit_button.data("type");
	var module_type 			= edit_button.data("module-type");
								
	var data_fields 			= jQuery("#data_fields").val();
	var data_fields_arr 		= data_fields.split(",");
	var data_field_keys 		= jQuery("#data_field_keys").val();
	var data_field_keys_arr 	= data_field_keys.split(",");
	var data_types 				= jQuery("#data_types").val();
	var data_types_arr 			= data_types.split(",");
	var data_repeaters 			= jQuery("#data_repeaters").val();
	var data_repeaters_arr 		= data_repeaters.split(",");
	var data_cpt_keys 			= jQuery("#data_cpt_keys").val();
	var data_cpt_keys_arr 		= data_cpt_keys.split(",");
								
	var data_values 			= new Array();
	
	for(var i=0, len = data_fields_arr.length; i<len; i++) {
		var data_field 		= data_fields_arr[i];
		var data_type 		= data_types_arr[i];
		var data_repeater 	= data_repeaters_arr[i];
		var data_cpt_key 	= data_cpt_keys_arr[i];
		
		var data_field_id 	= 'data_edit_input_' + data_field;
		
		if(data_type == "wysiwyg") {
			var data_value 	= tinyMCE.get(data_field_id).getContent();
		
		} else if(data_type == "true_false") {
			if(jQuery("#" + data_field_id).is(':checked')) {
				var data_value = 1;
			} else {
				var data_value = 0;
			}
		
		} else if(data_type == "radio") {
			var data_value = jQuery('input[name=radio_' + data_field_id + ']:checked', '#' + data_field_id).val();
			
		} else if(data_type == "checkbox") {
			//var data_value = jQuery('input[name=radio_' + data_field_id + ']:checked', '#' + data_field_id).val();
			var data_value = new Array();
			jQuery("#" + data_field_id + ' input[type=checkbox]').each(function () {
				if(this.checked == 1) {
					var push = data_value.push(jQuery(this).val());
				}
			});
						
		} else {
			var data_value = jQuery("#" + data_field_id).val();
		}
		
		var push = data_values.push(encodeURIComponent(data_value));
		
		//alert(data_field + ' --> ' + data_field_id + ' --> ' + data_type + ' --> ' + data_value);
	}
	
	
	var prev_value	= edit_content.html();
	
	
	var columns_cols = '';
	if(jQuery("#data_columns_cols_" + i_data_edit)) {
		columns_cols = "&columns_cols=" + jQuery("#data_columns_cols_" + i_data_edit).val();
	}
	
	
	var url = get_theme() + "/_backend/ajaxSaveDataEdit.php";
	var data = "ajax=1&data_edit_save=1&i_data_edit=" + i_data_edit + "&post_id=" + post_id + "&module_type=" + module_type + "&data_field_keys=" + data_field_keys + "&data_fields=" + data_fields + "&data_types=" + data_types + "&data_cpt_keys=" + data_cpt_keys + "&data_repeaters=" + data_repeaters + "&data_values=" + data_values.join("######") + columns_cols;
	//alert(url + '____' + data);
	
	
	jQuery.ajax({
	  url: url,
	    type: "POST",
	    data: data,
	    evalScripts: true,
	    success: function(responses, status, xhr) {
	    	if(status == "success") {
	    		var response 				= responses.split("|||");
	    		var success 				= response[1];
	    		var new_values				= response[2].split("######");
	    		var new_types				= response[3].split("######");
	    		var new_gap_top				= response[4];
	    		var new_gap_bottom			= response[5];
	    		var new_gap_innertop		= response[6];
	    		var new_gap_innerbottom		= response[7];
	    		var test	 				= response[8];
	    		
	    		//alert(responses);
	    		
	    		if(success > 0) {
	    		    //jQuery("#admin_frontpage_edit_debug").html(responses);
	    		    data_edit_close();
	    		    
	    		    if(jQuery("#data_gap_top_" + i_data_edit)) {
		    		    jQuery("#data_gap_top_" + i_data_edit).animate({
			    	        height: new_gap_top + 'px',
			    	    });
	    		    }
	    		    
	    		    if(jQuery("#data_gap_bottom_" + i_data_edit)) {
		    		    jQuery("#data_gap_bottom_" + i_data_edit).animate({
			    	        height: new_gap_bottom + 'px',
			    	    });
	    		    }
	    		    
	    		    if(jQuery("#data_gap_innertop_" + i_data_edit)) {
		    		    jQuery("#data_gap_innertop_" + i_data_edit).animate({
			    	        height: new_gap_innertop + 'px',
			    	    });
	    		    }
	    		    
	    		    if(jQuery("#data_gap_innerbottom_" + i_data_edit)) {
		    		    jQuery("#data_gap_innerbottom_" + i_data_edit).animate({
			    	        height: new_gap_innerbottom + 'px',
			    	    });
	    		    }
	    		   
	    		    if(module_type == "columns") {
		    		    var w_columns = new_values[0].split("-");
		    		    
		    		    for(var i=0, len = w_columns.length; i<len; i++) {
	    		    		if(jQuery("#data_column_" + i_data_edit + '_' + i)) {
		    				    jQuery("#data_column_" + i_data_edit + '_' + i).animate({
		    				    	width: w_columns[i] + 'px',
		    				    }, 300);
		    				    
		    				    jQuery("#data_column_" + i_data_edit + '_' + i + " img").each(function(index){
		    				    	if(jQuery(this).width() > w_columns[i]) {
			    				    	jQuery(this).animate({
				    				    	width: w_columns[i] + 'px',
				    				    }, 300);
				    				}
				    			});
		    				    
		    				    jQuery("#data_column_" + i_data_edit + '_' + i).find(".videoplayer div").animate({
		    				    	width: w_columns[i] + 'px',
		    				    }, 300);
		    				}
	    		    	}
		    		    
	    		    } else {
	    		    	if(jQuery("#data_" + i_data_edit)) {
		    			    if(new_types[0] == 'image') {
		    			    	jQuery("#data_" + i_data_edit).attr("src", new_values[0]);
		    			    	
		    			    } else {
		    			    	jQuery("#data_" + i_data_edit).html(new_values[0]);
		    			    	blink("#data_" + i_data_edit);
		    			    }
	    		    	}
	    		    	
	    		    	for(var i=0, len = new_values.length; i<len; i++) {
	    		    		if(jQuery("#data_" + i_data_edit + '_' + i)) {
		    				   	jQuery("#data_" + i_data_edit + '_' + i).html(new_values[i]);
		    				   	blink("#data_" + i_data_edit + '_' + i);
		    				}
	    		    	}
	    		     }
	    		     
	    		     hide_reset_cache(post_id);
	    		        		
	    		} else {
	    		    alert("Fehler beim Speichern der Inhalte");
	    		}
	    	}	
	    }
	});
}


function hide_reset_cache(post_id) {
	if(jQuery("#admin_frontpage_update_post_modified_" + post_id)) {
		jQuery("#admin_frontpage_update_post_modified_" + post_id).hide();
	}
}


function data_edit_meta(post_id) {
	data_edit_close();
	
	var editor = jQuery("#admin_frontpage_edit");
	var url = get_theme() + "/_backend/ajaxCreateDataEditMeta.php";
	var data = "ajax=1&data_edit_meta=1&post_id=" + post_id;
	
	
	jQuery.ajax({
	   url: url,
	    type: "POST",
	    data: data,
	    evalScripts: true,
	    success: function(responses, status, xhr) {
	    	if(status == "success") {
	    		/* alert(responses); */
	    		
	    		var response 		= responses.split("|||");
	    		
	    		var editor_content 	= response[0];
	    		
	    		editor.html(editor_content);
	    		data_edit_show();
	    	}	
	    }
	});
}


function data_edit_save_meta(post_id) {
	var editor = jQuery("#admin_frontpage_edit");
	
	var meta_title 			= jQuery("#data_edit_meta_title").val();
	var meta_description 	= jQuery("#data_edit_meta_description").val();
	var meta_keywords 		= jQuery("#data_edit_meta_keywords").val();
	var sitemap 			= jQuery("#data_edit_sitemap").val();
	var changefreq 			= jQuery("#data_edit_changefreq").val();
	var noindex 			= jQuery("#data_edit_noindex").val();
	
	if (jQuery('#data_edit_noindex').is(":checked")) {
		var noindex = 1;
	} else {
		var noindex = 0;
	}
	
	var url = get_theme() + "/_backend/ajaxSaveDataEditMeta.php";
	var data = "ajax=1&data_edit_save_meta=1&post_id=" + post_id + "&meta_title=" + encodeURIComponent(meta_title) + "&meta_description=" + encodeURIComponent(meta_description) + "&meta_keywords=" + encodeURIComponent(meta_keywords) + "&sitemap=" + sitemap + "&changefreq=" + changefreq + "&noindex=" + noindex;
	/* alert(url + '____' + data); */
	
	jQuery.ajax({
		url: url,
	    type: "POST",
	    data: data,
	    evalScripts: true,
	    success: function(responses, status, xhr) {
	    	if(status == "success") {
	    		//alert(responses);
	    		
	    		var response 	= responses.split("|||");
	    		
	    		var success 	= response[0];
	    		var new_value	= response[1];
	    		var test	 	= response[2];
	    		
	    		data_edit_close();
	    	}	
	    }
	});
}

function show_info_admin_option(text) {
	jQuery("#admin_frontpage_options_info")
		.html(text);
}

function hide_info_admin_option() {
	jQuery("#admin_frontpage_options_info")
		.html("&nbsp;<br>&nbsp;");
}

function admin_show_grid(){
	jQuery("#admin_grid").toggle();
	jQuery(".module_column").toggleClass("admin_module_column");
	jQuery("#admin_frontpage_option_raster").toggleClass("admin_frontpage_options_button_selected");
}

function admin_show_dimensions(){
	jQuery("#admin_grid_dimensions").toggle();
	jQuery("#admin_frontpage_option_grid_dimensions").toggleClass("admin_frontpage_options_button_selected");
}

function admin_show_edit(){
	jQuery(".data_edit_object").toggle();
	jQuery("#admin_frontpage_option_edit").toggleClass("admin_frontpage_options_button_selected");
}


function keyEnter(e) {
	if(e.keyCode == 13) {
		return true;
	}
}



var $gmarkers = [];

function map(args) {
	var center 			= args['center'].split(",");
	var lats 			= args['lats'].split("###");
	var lngs 			= args['lngs'].split("###");
	
	var center_w = center[0];
	var center_h = center[1];
	var gmarkers = [];
	
	var mapStyles = [
		{
		  "stylers": [
		    { "saturation": -100 }
		  ]
		},{
		  "featureType": "road",
		  "elementType": "geometry.fill",
		  "stylers": [
		    { "lightness": 100 }
		  ]
		},{
		  "featureType": "road",
		  "elementType": "labels.icon",
		  "stylers": [
		    { "visibility": "off" }
		  ]
		},{
		  "featureType": "road",
		  "elementType": "labels.text",
		  "stylers": [
		    { "invert_lightness": true },
		    { "weight": 0.1 },
		    { "lightness": -100 }
		  ]
		}
	];
	
	var myOptions = {
		zoom					: args['zoom'],
 		center					: new google.maps.LatLng(center_w, center_h),
 		mapTypeControl			: false,
 		panControl				: false,
 		streetViewControl		: false,
 		scrollwheel      		: true,
 		mapTypeId        		: google.maps.MapTypeId.ROADMAP,
		styles           		: mapStyles,
		/* disableDefaultUI 		: true */
	};
	
	var map = new google.maps.Map(document.getElementById(args['object']), myOptions);
	
		
	var i_marker = 1;  
	for (var i = 0; i < lats.length; i++) {
	    var myLatLng = new google.maps.LatLng(parseFloat(lats[i]), parseFloat(lngs[i]));
	    
	    var marker = new google.maps.Marker({
			position: myLatLng,
			title:"Hello World!"
		});
	    
		marker.setMap(map);
	    
	    ++i_marker;
	}
}