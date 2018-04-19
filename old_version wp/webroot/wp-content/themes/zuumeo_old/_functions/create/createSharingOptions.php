<?php

function createSharingOptions($args) {
	if(!isMetaNoIndex()) {
		global $page_id;
		
		$page_title 	= get_the_title($page_id);
		$url 			= getCurrentURL();
		
		(isset($args['size'])) ? $size = $args['size'] : $size = 'small';
		
		$buttons = array();
		
		if(isset($args['description']) && $args['description'] != "") {
			$description = strip_tags($args['description']);
		
		} else {
			$description = getMetaDescription(array());
		}
		
		
		if(wp_attachment_is_image($args['image'])) {
			$media = wp_get_attachment_url($args['image'], 'full');
			//$description = get_the_title($args['pinterest']);
				
		} else {
			$media = $args['image'];
		}
			
		
		//!Facebook
		$buttons[] = '
			<td>
				<a class="sharing_button sharing_button_'.$size.'" href="http://www.facebook.com/dialog/feed?app_id='.getOptionWord("facebook_app_post_api").'&link='.urlencode($url).'&picture='.urlencode($media).'&name='.urlencode($page_title).'&description='.urlencode($description).'&redirect_uri='.urlencode($url).'" target="_blank"><img src="'.getStylesheetDirectoryURI().'/_images/sharing_facebook_'.$size.'.png" /></a>
			</td>
		';
		
		
		
		//!Google+
		$buttons[] = '
			<td>
    		<div class="relative">
    		<div class="googlehider">
    		    <g:plusone annotation="none"></g:plusone>
    		    
    		    <!-- Place this render call where appropriate -->
    		    <script type="text/javascript">
    		      window.___gcfg = {lang: "en-GB"};
    		    
    		      (function() {
    		        var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
    		        po.src = "https://apis.google.com/js/plusone.js";
    		        var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
    		      })();
    		    </script>
    		</div>
    		</div>
    		<img src="'.getStylesheetDirectoryURI().'/_images/sharing_google_plus_'.$size.'.png" class="" />
    		</td>
    	';
		
		
		
		//!Twitter
		$buttons[] = '
			<td>
				<a class="sharing_button sharing_button_'.$size.'" href="https://twitter.com/share" data-url="'.$url.'" data-lang="'.getCurrentLanguage(array()).'" target="_blank"><img src="'.getStylesheetDirectoryURI().'/_images/sharing_twitter_'.$size.'.png" /></a>
			</td>
		';
		
		
		
		//!Pinterest
		//$buttons[] = '<div class="left sharing_option"><a class="sharing_button sharing_button_'.$size.'" data-pin-config="beside" href="//pinterest.com/pin/create/button/?url='.urlencode($url).'&media='.urlencode($media).'&description='.urlencode($description).'&data-pin-do=buttonPin" target="_blank"><img src="'.getStylesheetDirectoryURI().'/_images/sharing_pinterest_'.$size.'.png" /></a></div>';
		
		
		if(!empty($buttons)) {
			$return = '
				'.createLine(array("top" => 0, "bottom" => 0, 'clean' => 1)).'
				<div class="content_inner">
					<center>
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							'.implode("", $buttons).'
						</tr>
					</table>
					</center>
				</div>
			';
			
			return $return;
		}
	}
}