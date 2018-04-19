<?php

function isiPhone() {
	global $detect;
	
	if($detect->isiPhone()) {
		return true;
	} else {
		return false;	
	}
}

?>