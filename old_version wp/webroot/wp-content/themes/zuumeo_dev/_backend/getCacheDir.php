<?php

function getCacheDir($type="desktop") {
	$cache_dir = dirname(ABSPATH).'/cache';
		
	if($type == "mobile") {
		$cache_dir = $cache_dir.'/_mobile';
	}
	
	return $cache_dir;
}

?>