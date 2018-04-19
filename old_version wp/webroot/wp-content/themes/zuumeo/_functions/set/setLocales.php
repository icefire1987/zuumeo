<?php

function setLocales() {
	$array = array(
		'de' => 'de_DE.UTF-8',
		'en' => 'en_GB.UTF-8',
		'fr' => 'fr_FR.UTF-8',
		'sv' => 'sv_SE.UTF-8',
		'pt' => 'pt_PT.UTF-8',
		'no' => 'no_NO.UTF-8',
		'zh' => 'zh_CN.UTF-8',
		'tr' => 'tr_TR.UTF-8',
		'es' => 'es_ES.UTF-8',
		'ru' => 'ru_RU.UTF-8',
	);
	
	$result = $array["de"];
	
	setlocale(LC_ALL, $result);
	setlocale(LC_CTYPE, $result);
	setlocale(LC_TIME, $result);
}

?>