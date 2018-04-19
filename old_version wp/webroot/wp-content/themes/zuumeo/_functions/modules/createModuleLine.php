<?php

function createModuleLine($args) {
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	
	//debug($args);
	
	$top_border 	= '';
	$bottom_border 	= '';
	$top_color 		= '';
	$bottom_color 	= '';
	$top_title 		= '';
	$bottom_title 	= '';
	
	//debug($args);
	
	if(isset($args['m_line_options'][0])) {
		$l = $args['m_line_options'][0];	
	} else {
		$l = array();
	}
	
	
	
	
	
	if(isAdmin() & isset($args['meta_key'])) {
	    $e = addFrontpageEdit(array(
	    	'id' 		=> $page_id,
	    	'field'		=> $args['meta_key'],
	    	'type'		=> 'none',
	    	'top'		=> 7,
	    ));
	}
	
	
	$return = '
		'.setGapTop($args, @$e['edit_id']).'
		<div class="line relative">'.@$e['content'].'</div>
		'.setGapBottom($args, @$e['edit_id']).'
	';
	
	return $return;
}

?>