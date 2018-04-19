<?php

function getSlug($str, $replace=array(), $delimiter='-') {
	setlocale(LC_ALL, 'en_US.UTF8');
	//
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);	
	$clean=strip_tags($clean);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	return $clean;
}

?>