<?php

function getDepthCustomPostType($id) {
	$current_post = get_post_ancestors($id);
	
	//'<p>'.$id.'-->';
	//debug($current_post);
	
	$level = 0;
	if(isset($current_post[0])) {
		++$level;
		
		$current_post = get_post_ancestors($current_post[0]);
		
		if(isset($current_post[0])) {
			++$level;
			$current_post = get_post_ancestors($current_post[0]);
			
			if(isset($current_post[0])) {
				++$level;
				$current_post = get_post_ancestors($current_post[0]);
			}
		}
	}
	
	return $level;
	
}

?>