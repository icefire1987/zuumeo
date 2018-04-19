<?php

function getYoutubeIDFromURL($url) {
	$regExp = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/';
	preg_match($regExp, $url, $result);
	
	//parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
	//echo $my_array_of_vars['v']; 

	//print_r($result);
	
	if ($result && strlen($result[7]) == 11){
		return $result[7];
		
	} else {
		return false;
	}
}

?>