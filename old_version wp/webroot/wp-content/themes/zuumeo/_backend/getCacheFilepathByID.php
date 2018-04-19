<?php

function getCacheFilepathByID($post_id) {
	//$post_type = get_post_type($post_id);
	    		
	//$permalink = getPermalink(array(
	//    'post_id'		=> $post_id,
	//    'post_type'		=> $post_type,
	//));
	//
	//if($post_id == get_option("page_on_front")) {
	//    $filename = '/';
	//
	//} else {
	//    $filename = str_replace(getRealSiteURL(), "", $permalink);
	//}
	$file = getCacheDir().'/'.$post_id.'.html';
	
	return $file;
}