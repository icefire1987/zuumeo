<?php

function getHTTP() {
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
		$return = 'https://';
	
	} else {
		$return = 'http://';
	}

	return $return;
}


?>