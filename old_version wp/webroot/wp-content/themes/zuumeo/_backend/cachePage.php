<?php

function cachePage($args) {
	if(isCache() && !isset($_GET['nocache'])) {
		if(file_exists(getCacheDir())) {
			wp_reset_postdata();
			$post_id 	= getPageID();
			
			if(is_numeric($post_id) && $post_id > 0) {
			    $cache_dir = getCacheDir();
			    if(isPhone()) {
			    	$cache_dir = getCacheDir("mobile");
			    }
			    
			    $url = explode('?', $_SERVER['REQUEST_URI']);
				
			    $file = $cache_dir.'/'.urlencode($url[0]).'.html';
			    
			    //$content = minifyHTML($content);
			    
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
				
				$q_insert = '
				INSERT INTO
				    `'.TABLE_PREFIX.'individole_statistics`
				(`post_id`, `timestamp`, `platform`, `browser`, `version`, `ip`, `updater`)
				VALUES
				    ('.$post_id.', "'.date("Y-m-d H:i:s").'", "'.$platform.'", "'.$browser.'", "'.$version.'", "'.$ip.'", "function cachePage()")
				ON DUPLICATE KEY UPDATE
				    `timestamp` 			= "'.date("Y-m-d H:i:s").'",
				    `platform` 			= "'.$platform.'",
				    `browser` 			= "'.$browser.'",
				    `version` 			= "'.$version.'",
				    `ip` 				= "'.$ip.'",
				    `updater`			= "function cachePage()",
				    `last_cached` 		= "'.date("Y-m-d H:i:s").'"
				';
				
				//echo $q_insert;
				
				mysql_query($q_insert);
			}
		}
	}
}

?>