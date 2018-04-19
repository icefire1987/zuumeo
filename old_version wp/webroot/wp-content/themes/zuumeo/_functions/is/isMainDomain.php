<?php

function isMainDomain() {
	if(endsWith($_SERVER['HTTP_HOST'], getCurrentMainDomain())) {
		return true;
	
	} else {
		return false;
	}
}

?>