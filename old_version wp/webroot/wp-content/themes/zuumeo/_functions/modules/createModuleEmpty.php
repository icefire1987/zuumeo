<?php

function createModuleEmpty($args) {
	//debug($args);
	
	$color = $args['m_empty_color'];
	
	$content = '<div style="background-color:'.$color.';">&nbsp;</div>';
	
	$return = '
		'.setGapTop($args).'
		'.$content.'
		'.setGapBottom($args).'
	';
	
	return $return;
}

?>