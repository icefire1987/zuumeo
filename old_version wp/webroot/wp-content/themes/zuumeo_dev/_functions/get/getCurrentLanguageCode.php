<?php

function getCurrentLanguageCode() {
	$array = array(
		'de' => 'de_DE',
		'en' => 'en_US',
	);
	
	if(isset($array[getCurrentLanguage(array())])) {
		$return = $array[getCurrentLanguage(array())];
	
	} else {
		$return = $array['de'];
	}
	
	return $return;
}

?>