<?php

function getVimeoIDFromURL($url) {
	//echo 'yyyyyyy';
	
	$regExp = '/[http|https]:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';
	preg_match($regExp, $url, $result);
	
	if ($result){
		return $result[2];
		
	} else {
		return false;
	}
}

?>