<?php

function createModuleContentList($args) {
	//debug($args);
	
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	
	$c = $args['config_base'][0];
	$d = $args['m_content_list_content'];
	
	$ids = getRepeaterIDs(array(
		'data' 	=> $args['m_content_list_content'],
		'key'	=> 'post',
	));
	
	
	if(isAdmin() & isset($args['meta_key'])) {
		$e = addFrontpageEdit(array(
	    	'id' 			=> $page_id,
	    	'field'			=> $args['meta_key'],
	    	'column'		=> 1,
	    ));
	}
	
	
	if($output != "") {
		$return = '
			'.setGapTop($args, @$e['edit_id']).'
			<div class="relative null" style="">
				'.@$e['content'].'
				'.$output.'
				'.clearer().'
			</div>
			'.setGapBottom($args, @$e['edit_id']).'
			
		';
		
		return $return;
	}	
}

?>