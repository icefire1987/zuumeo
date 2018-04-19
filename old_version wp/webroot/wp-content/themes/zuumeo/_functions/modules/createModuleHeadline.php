<?php

function createModuleHeadline($args) {
	$o = $args['m_headline_content'][0];
	
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	
	(isset($o['type']) && $o['type'] != "") 			? $type = $o['type'] 		: $type = 'h2';
	(isset($o['alignment']) && $o['alignment'] != "") 	? $align = $o['alignment'] 	: $align = 'left';
	
	$class_underline = '';
	if(isset($o['underline']) && $o['underline'] == true) {
		$class_underline = 'headline_line';
	}
	
	if(isAdmin() & isset($args['meta_key'])) {
	    $e = addFrontpageEdit(array(
	    	'id' 		=> $page_id,
	    	'field'		=> $args['meta_key'],
	    ));
	}
	
	$content = '<'.$type.' class="'.$class_underline.'" style="text-align:'.$align.';" '.@$e['id'].'>'.$o['text'].'</'.$type.'>';
	
	$return = '
		'.setGapTop($args, @$e['edit_id']).'
		<div class="relative">
			'.@$e['content'].setGapLeftRight($args, $content).'
		</div>
		'.setGapBottom($args, @$e['edit_id']).'
	';
	
	return $return;
}

?>