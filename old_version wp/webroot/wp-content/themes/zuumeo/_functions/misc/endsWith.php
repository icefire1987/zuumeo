<?php

function endsWith($haystack, $needle) {
	$length = strlen($needle);
	$start  = $length * -1; //negative
	return (substr($haystack, $start) === $needle);
}

?>