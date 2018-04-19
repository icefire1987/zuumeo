<?php

function setLanguageDirection() {
	if(isLanguageRTL()) {
		return "rtl";
	
	} else {
		return "ltr";
	}
}

?>