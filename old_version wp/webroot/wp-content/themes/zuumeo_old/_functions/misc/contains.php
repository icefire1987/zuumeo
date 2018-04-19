<?php

function contains($haystack, $needle) {
	if (strlen(strstr($haystack,$needle))>0) {
		return true;
	}
}


?>