<?php

function createModuleShortcode($args) {
	//debug($args);
	
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	$data = $args['m_shortcode_content'][0];
	
	$parameter_col_w = '';
	if(isset($args['col_w']) && $args['col_w'] > 0) {
		$parameter_col_w = ' col_w='.$args['col_w'];
	}
	
	
	if(isAdmin() & isset($args['meta_key'])) {
		$e = addFrontpageEdit(array(
	    	'id' 			=> $page_id,
	    	'field'			=> $args['meta_key'],
	    	'shortcode'		=> 1,
	    ));
	}
	
	$parameter = array();
	if(isset($data['parameter']) && !empty($data['parameter'])) {
		foreach($data['parameter'] AS $param_key => $param_value) {
			if($param_value['var'] != "") {
				$parameter[] = $param_value['var'].'="'.$param_value['value'].'" ';	
			}
		}
	}
	
	$return = '
		'.setGapTop($args, @$e['edit_id']).'
		<div class="relative null">
			'.@$e['content'].'
			'.setGapLeftRight($args, do_shortcode('['.$data['code'].' '.implode("", $parameter).' '.$parameter_col_w.']')).'
		</div>
		'.setGapBottom($args, @$e['edit_id']).'
	';
	
	return $return;
}

?>