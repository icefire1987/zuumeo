<?php

function formatLink($link) {
	$http = 'http://';
	if(startsWith($link, "https")) {
		$http = 'https://';
		
	}
	
	$link = $http.str_replace($http, "", $link);
	
	return $link;
}

?>