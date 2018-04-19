<?php

function getCurrentContentLanguage() {
	$array = array(
		'de' => 'de_DE',
		'en' => 'en_GB',
		'fr' => 'fr_FR',
		'sv' => 'sv_SE',
		'pt' => 'pt_PT',
		'no' => 'no_NO',
		'zh' => 'zh_CN',
		'tr' => 'tr_TR',
		'es' => 'es_ES',
		'ru' => 'ru_RU',
	);
	
	if(isset($array[getCurrentLanguage(array())])) {
		$result = $array[getCurrentLanguage(array())];
	
	} else {
		$result = $array["de"];
	}
	
	return $result;
}

?>