var share_option_id = 0;
var share_option_type = '';
var current_share_option_id = 'none';
var current_share_option_type = 'none';

function showShareOptions(html) {
	//var test = share_option_type + '_' + current_share_option_type + '_' + share_option_id + '_' + current_share_option_id;
	
	var div = jQuery("#share-option-output");
	
	if(div.css("display") == "none" || (share_option_type != current_share_option_type || share_option_id != current_share_option_id)) {
		current_share_option_type = share_option_type;
		current_share_option_id = share_option_id;
		
		var final_content = html + '<div class="share-option-output-close" onclick="hideShareOptions();"></div>';
		
		div.html(final_content);
		
		var left 	= Math.round(mouseX - (div.outerWidth()/2));
		var top 		= Math.round(mouseY - div.outerHeight() - 28);
		
		div.css("top", top + "px");
		div.css("left", left + "px");
		
		div.fadeIn(350);
		
	} else {
		
		hideShareOptions();
	}
}