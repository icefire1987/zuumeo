<?php

function setFacebookMeta() {
	if(!isMetaNoIndex()) {
		$meta = array();
		
		$meta[] = '<meta property="og:title" content="'.getMetaTitle(array()).'" />';
		$meta[] = '<meta property="og:type" content="website" />';
		$meta[] = '<meta property="og:url" content="'.getCurrentURL().'" />';
		$meta[] = '<meta property="og:description" content="'.getMetaDescription(array()).'" />';
		//$meta[] = '<meta property="fb:app_id" content="'.FACEBOOK_SHARE_API.'" />';
		//$meta[] = '<meta property="fb:page_id" content="'.getOptionWord("facebook_page_id").'" />';
		
		$fb_admins = explode(",", getOptionWord("facebook_admins"));
		if(sizeof($fb_admins) > 0) {
		    foreach($fb_admins AS $fb_admin) {
		    	$meta[] = '<meta property="fb:admins" content="'.$fb_admin.'" />';
		    }
		}
		
		$image_url = getStylesheetDirectoryURI().'/_images/logo-facebook-2.jpg';
		//$image_url_ssl = str_replace(getCurrentHost(), getOptionWord('https_url'), $image_url);
			
		$meta[] = '<meta property="og:image" content="'.$image_url.'"/>';
		
		$return = implode("\n", $meta);
		
		return $return;
	}
}

?>