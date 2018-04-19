<?php

function getCachedPage($post_id=0) {
	if(isCache()) {
		wp_reset_postdata();
		
		if($post_id == 0) {
			$post_id 	= getPageID();
		}
		
		
		$post_type 	= get_post_type($post_id);
		
		$cache_dir = getCacheDir();
		if(isPhone()) {
		   	$cache_dir = getCacheDir("mobile");
		}
		
		
		//$url = explode('?', $_SERVER["REQUEST_URI"]);
			
		//$file_best = $cache_dir.'/'.urlencode($url[0]).'%2F.html';
		//$file_default = $cache_dir.'/'.urlencode($url[0]).'.html';
		$file = $cache_dir.'/'.$post_id.'.html';
		
		$final_file = '';
		//if(file_exists($file_best)) {
		//	$final_file = $file_best;
		//
		//} else if(file_exists($file_default)) {
		//	$final_file = $file_default;
		//}
		
		if(file_exists($file)) {
			$final_file = $file;
		}
		
		if($final_file != "") {
		   	$time_now 			= time();
		    $time_post 			= get_post_modified_time("U", true, $post_id);
		    $time_file 			= filemtime($final_file);
		    
		    $time_diff_post 	= $time_now - $time_post;
		    $time_diff_file 	= $time_now - $time_file;
		    
		    //echo '<p>$file:'.$file.'<br>$post_id:'.$post_id.'<br>$time_now:'.$time_now.'<br>$time_post:'.$time_post.'<br>$time_file:'.$time_file.'<br>$time_diff_post:'.$time_diff_post.'<br>$time_diff_file:'.$time_diff_file;
		    
		    
		    if(isPhone()) {
		    	$cache_time = getCacheTime("mobile");
		    } else {
			    $cache_time = getCacheTime();
		    }
		    
		    if(isset($GLOBALS['configs_cache'][$post_type])) {
		    	$cache_time = $GLOBALS['configs_cache'][$post_type];
		    }
		    
		    
		    if($time_diff_file < $cache_time && $time_diff_post > 0 && $time_diff_file < $time_diff_post) {
		    	//echo '<p>CACHED CONTENT / '.$post_type.' / '.$cache_time;
		    	
		    	$content = file_get_contents($final_file);
		    	
		    	return $content;
		    
		    } else {
		    	return false;
		    }
		    
		} else {
		    return false;
		}
				
	} else {
		return false;
	}
}

?>