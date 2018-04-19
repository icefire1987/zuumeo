<?php

function checkURLSyntax($url) {
	//return $url;
	
	$pattern = "=^([a-z0-9\-_]{2,}\.)+([a-z0-9\-_]+)\.(.*)$=i";
	//$check = "=^([a-z0-9\-_]+)\.(.*)$=i";
	$pattern = "#(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?(.*)*$#i";
	
	if(preg_match($pattern, $url)) {
		//echo "<p>check_url_syntax: 1 ($url)";
		return $url;
	
	} else {
		//echo "<p>check_url_syntax: 2 ($url)";
		return false;
	}
}

?>