function createShareButton(args) {
	var share_option_id 		= args['id'];
	var share_option_type 	= args['type'];
	var randomnumber 			= '?' + Math.floor(Math.random()*999999);
	
	var info = jQuery("#share-option-text-" + share_option_id + '-' + share_option_type).html();
	
	var info_final = '';
	if(info != "" && info != null) {
		info_final = '<div class="clearer" style="height:10px;"></div>' + info;
	}
	
	var url = "";
	if(args['url']) {
		url = encodeURIComponent(args['url']);
	}
	
	if(share_option_type == "twitter") {
		var code = '<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?lang=de&url=' + url + '" style="width:240px; height:24px;"></iframe>';
	
	} else if(share_option_type == "facebook") {
		var code = '<iframe src="http://www.facebook.com/plugins/like.php?locale=de_DE&amp;href=' + url + '&amp;send=false&amp;layout=button_count&amp;width=240&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font&amp;height=24" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:240px; height:24px;" allowTransparency="true"></iframe>';
	
	} else if(share_option_type == "ics") {
		var code = '<a href="' + jQuery("#code-" + share_option_id + '-' + share_option_type).val() + '">Download ICS</a>';
	}
	
	var final_code = '<div class="share-option-output-active">' + code + info_final + '</div>'
	
	showShareOptions(final_code);
}