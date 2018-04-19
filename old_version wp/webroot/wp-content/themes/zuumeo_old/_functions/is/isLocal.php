<?php

function isLocal() {
	$check_local = getUrlExtension($_SERVER['SERVER_NAME']);
	
	if ($check_local['extension'] == "local") {
		return true;
	
	} else {
		return false;
	}
}

?>