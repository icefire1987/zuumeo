<?php

function createModuleText($args) {
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	$text = $args['m_text_text'];
	
	if(isAdmin() & isset($args['meta_key'])) {
	    $e = addFrontpageEdit(array(
	    	'id' 		=> $page_id,
	    	'field'		=> $args['meta_key'],
	    	'content'	=> $text,
	    	'type'		=> 'wysiwyg',
	    ));
	    
	    $text = $e['content'];
	
	} else {
	    $text = do_shortcode($text);
	    $text = removeSpaceBug($text);
	}
	
	//debug($args);
	
	$return = '
		'.setGapTop($args, @$e['edit_id']).'
		<div class="relative">
			'.setGapLeftRight($args, $text).'
			'.clearer().'
		</div>
		'.setGapBottom($args, @$e['edit_id']).'
	';
		
	return $return;
}

?>