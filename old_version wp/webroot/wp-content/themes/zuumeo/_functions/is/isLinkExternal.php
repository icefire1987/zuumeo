<?php

function isLinkExternal($link) {
	if(contains($link, $_SERVER['HTTP_HOST'])) {
		return false;
		
	} else {
		return true;
	}
}

?>