<?php

function getCurrentHOST() {
	$return = getHTTP().$_SERVER['HTTP_HOST'];
	
	return $return;
}

?>