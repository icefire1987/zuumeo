<?php

function isPolylang() {
	if(function_exists("pll_the_languages")) {
		return true;
		
	} else {
		return false;
	}
}

?>