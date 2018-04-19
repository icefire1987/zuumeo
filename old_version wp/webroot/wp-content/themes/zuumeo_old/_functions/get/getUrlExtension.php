<?php

function getUrlExtension($url) {	
	$array_extension = explode(".", $url);
	$extension = $array_extension[sizeof($array_extension)-1];
	$result = array();
	
	$result['extension'] = $extension;
	
	switch ($extension) {
		case "local":
		case "de":
		case "at":
		case "ch":
			$result['lang'] = "de";
			break;
			
		default:
			$result['lang'] = "en";
			break;
	}
	
	return $result;
}

?>