<?php

function createCache($args) {
	global $config_cpt;
	
	$post_ids = $args['post_ids'];
	
	//if(isset($args['siteurl'])) {
	//	$siteurl 	= $args['siteurl'];
	//	
	//} else {
	//	$siteurl 	= get_option("siteurl");
	//}
	$cache_dir = getCacheDir();
	if(isPhone()) {
	   	$cache_dir = getCacheDir("mobile");
	}
	    
	$permalinks = array();
	$i_post = 0;
	foreach($post_ids AS $post_id) {
	    if($post_id > 0) {
	    	if(isset($_SESSION['ajax_cache_creating'])) {
	    		unset($_SESSION['ajax_cache_creating']);
	    		break;
	    	}
	    	
	    	$nocache 	= get_post_meta($post_id, get_option("individole_praefix_seo").'_0_cache', true);
	    	
	    	if($nocache != 1) {
	    		//$permalink 	= get_permalink($post_id);
	    		//$permalink 	= str_replace($siteurl, "", $permalink);
	    		$post_type 	= get_post_type($post_id);
	    		
	    		$permalink		= getPermalink(array(
	    			'post_id'		=> $post_id,
	    			'post_type'		=> $post_type,
	    		));
	    		
	    		$file_get_contents_url = $permalink;
	    		$permalinks[] = $file_get_contents_url;
	    		
	    		if(isset($args['content'])) {
		    		$content = $args['content'];
		    		
	    		} else {
		    		$content = file_get_contents($file_get_contents_url.'?ajax_cache=1');
		    	}
	    		
	    		$search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
	    		$replace = array('>', '<', '\\1');
	    		$content = trim(preg_replace($search, $replace, $content));				
	    		
	    		if($post_id == get_option("page_on_front")) {
	    	    	$filename = '/';
	    		} else {
	    	    	$filename = str_replace(getRealSiteURL(), "", $permalink);
	    		}
	    		$file = $cache_dir.'/'.urlencode($filename).'.html';
	    		$file = $cache_dir.'/'.$post_id.'.html';
	    		
	    		//echo $file;
	    		
	    		file_put_contents($file, $content);
	    		chmod($file, 0777);
	    		
	    		
	    		$platform 	= '-';
				$browser 	= '-';
				$version 	= '-';
				$ip 		= $_SERVER['REMOTE_ADDR'];
			    if(getBrowser()) {
			    	$browser_detect = getBrowser();
					$platform = $browser_detect['platform'];
					$browser = $browser_detect['name'];
					$version = $browser_detect['version'];
				}
				
				$user = 'unknown';
				if(isset($args['user'])) {
					$user = $args['user'];
				}
				
				$q_insert = '
				INSERT INTO
				    `'.TABLE_PREFIX.'individole_statistics`
				(`post_id`, `timestamp`, `platform`, `browser`, `version`, `ip`, `updater`, `last_cached_by`)
				VALUES
				    ('.$post_id.', "'.date("Y-m-d H:i:s").'", "'.$platform.'", "'.$browser.'", "'.$version.'", "'.$ip.'", "function cachePage()", "'.$user.'")
				ON DUPLICATE KEY UPDATE
				    `timestamp` 			= "'.date("Y-m-d H:i:s").'",
				    `platform` 			= "'.$platform.'",
				    `browser` 			= "'.$browser.'",
				    `version` 			= "'.$version.'",
				    `ip` 				= "'.$ip.'",
				    `updater`			= "function cachePage()",
				    `last_cached_by`		= "'.$user.'",
				    `last_cached` 		= "'.date("Y-m-d H:i:s").'"
				';
				
				//echo $q_insert;
				mysql_query($q_insert);
	    		
	    		++$i_post;
	    	}
	    }
	}
		
	if(is_user_logged_in() || isset($args['cron'])) {
		$return = array(
			'count'		=> $i_post,
			'urls'		=> $permalinks,
		);
		
		return $return;
	}
}