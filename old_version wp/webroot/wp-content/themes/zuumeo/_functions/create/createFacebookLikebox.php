<?php

add_shortcode('fb_likebox', 'createFacebookLikebox');

function createFacebookLikebox($args) {
	if(isset($args['url'])) {
		(isset($args['w'])) 		? $w = $args['w'] 		: $w = 200;
		(isset($args['h'])) 		? $h = $args['h'] 		: $h = 200;
		(isset($args['col_w'])) 	? $w = $args['col_w'] 	: "";
		
		$return = '<div data-href="'.$args['url'].'" data-show-faces="true" data-stream="false" data-header="false" class="fb-like-box fb_iframe_widget" fb-xfbml-state="rendered" data-width="'.$w.'" data-height="'.($h+20).'" data-border_color="#dbe3e5"></div><style>.fb-like-box { height: '.($h+50).'px; }</style>'.clearer();
		
		return $return;
	}
}


?>