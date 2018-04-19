<?php

function setGapLeftRight($args, $content) {
	//debug($args);
	
	(isset($args['config_base'][0]['left'])) ? $l = $args['config_base'][0]['left'] : $l = 0;
	(isset($args['config_base'][0]['right'])) ? $r = $args['config_base'][0]['right'] : $r = 0;
	
	$return = '
		<div style="padding: 0px '.$r.'px 0px '.$l.'px;">
			'.$content.'
		</div>
	';
	
	return $return;
}

?>