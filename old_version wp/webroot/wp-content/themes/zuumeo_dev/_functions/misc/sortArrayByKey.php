<?php

function sortMultiArray($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	arsort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}


function sortArrayByKey(array $array, $key, $asc = true) {
    $result = array();
        
    $values = array();
    foreach ($array as $id => $value) {
        $values[$id] = isset($value[$key]) ? strtolower($value[$key]) : '';
    }
        
    if ($asc) {
        asort($values);
    }
    else {
        arsort($values);
    }
        
    foreach ($values as $key => $value) {
        $result[$key] = $array[$key];
    }
        
    return $result;
}

?>