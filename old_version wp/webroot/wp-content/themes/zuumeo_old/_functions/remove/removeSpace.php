<?php

function removeSpace($input) {
	$result = preg_replace('#<p[^>]*>(\s|&nbsp;?)*</p>#', '', $input);
	$result = str_replace("%20", " ", $result);
	
	return $result;
}

?>