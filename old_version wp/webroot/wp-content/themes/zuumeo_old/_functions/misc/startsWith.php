<?php

function startsWith($haystack, $needle) {
	$length = strlen($needle);
	
	//echo '######'.$needle;
	
	return (substr($haystack, 0, $length) === $needle);
}

?>